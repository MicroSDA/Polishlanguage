<?php
/**
 * Created by PhpStorm.
 * User: Ro
 * Date: 5/4/2018
 * Time: 7:41 AM
 */

class calendar_model extends Model
{

    private $student;

    public function __construct()
    {
        $this->student = new Students();
        if (!$this->student->isLogin()) {
            echo 'Session lost';
            die();
        }

    }

    private function isFormatCorrect($array, $flag)
    {

        switch ($flag) {

            case 'DATE':
                if (preg_match('/^[0-9]{4,4}[-][0-9]{2,2}[-][0-9]{2,2}$/', $array, $out)) {

                    return true;
                } else {
                    return false;
                }

                break;
            case 'TIME':
                if (preg_match('/^[0-9]{2,2}[:][0-9]{2,2}$/', $array, $out)) {

                    return true;

                } else {
                    return false;
                }

                break;
            case 'OFFSET':
                if (preg_match('/^(\+|\-)[0-9]{2,2}[:][0-9]{2,2}$/', $array, $out)) {

                    return true;
                } else {
                    return false;
                }
                break;

        }
    }

    private function isTimeAvailable($input_time, $all_time, $delay, $break)
    {
        $date_now = new DateTime($input_time); // текущее значение времени

        if($all_time){

            foreach ($all_time as $value) {


                $date_min = new DateTime($value['Time']); // минимальное значение времени
                $date_max = new DateTime($value['Time']); // максимальное значение времени

                $date_min->modify('-'.$delay.' hour');
                $date_max->modify('+'.$delay.' hour');


                // Проверяем, находится ли $date_now в диапазоне
                if ($date_now >= $date_min && $date_now <= $date_max) {
                    return false;
                    break;
                }
            }

        }else{

            $date_end_of_day_f = new DateTime('23:00');
            $date_end_of_day_s = new DateTime('24:00');

            $date_start_of_day_f = new DateTime('00:00');
            $date_start_of_day_s = new DateTime('01:00');



            if($date_now >= $date_end_of_day_f && $date_now <= $date_end_of_day_s){

                return false;
            }

            if($date_start_of_day_f && $date_now <= $date_start_of_day_s){

                return false;
            }
        }



        return true;
    }

    public function get_events()
    {

//--------------------------------------------------------------------------------------------------
// This script reads event data from a JSON file and outputs those events which are within the range
// supplied by the "start" and "end" GET parameters.
//
// An optional "timezone" GET parameter will force all ISO8601 date stings to a given timezone.
//
// Requires PHP 5.2.0 or higher.
//--------------------------------------------------------------------------------------------------

// Require our Event class and datetime utilities
        require_once URL_ROOT . '/core/Models/service/calendar/utils.php';

// Short-circuit if the client did not give us a date range.
        if (!isset($_GET['start']) || !isset($_GET['end'])) {
            die("Please provide a date range.");
        }

// Parse the start/end parameters.
// These are assumed to be ISO8601 strings with no time nor timezone, like "2013-12-29".
// Since no timezone will be present, they will parsed as UTC.
        $range_start = parseDateTime($_GET['start']);
        $range_end = parseDateTime($_GET['end']);

// Parse the timezone parameter if it is present.
        $timezone = null;
        if (isset($_GET['timezone'])) {
            $timezone = new DateTimeZone($_GET['timezone']);
        }

// Read and parse our events JSON file into an array of event data arrays.


        $lessonsDB = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons WHERE StudentID=?s AND StudentEmail=?s', $this->student->getID(), $this->student->getEMAIL());
        $lessons = [];


        if ($lessonsDB) {

            foreach ($lessonsDB as $value) {

                $color = '';

                switch ($value['Status']) {
                    case 'approved':
                        $color = 'green';
                        array_push($lessons, array('title' => $value['Time'], 'start' => $value['Data'], 'end' => $value['Data'], 'color' => $color));
                        break;
                    case 'not-approved':
                        $color = 'blue';
                        array_push($lessons, array('title' => $value['Time'], 'start' => $value['Data'], 'end' => $value['Data'], 'color' => $color));
                        break;
                    case 'disallowed':
                        $color = 'red';
                        array_push($lessons, array('title' => $value['Time'], 'start' => $value['Data'], 'end' => $value['Data'], 'color' => $color));
                        break;
                    case 'completed':
                        $title ='';

                        if($value['Feedback']=='open'){
                            $title = 'Оставьте свой отзыв'."\n".$value['Time'];
                        }else{
                            $title = $value['Time'];
                        }

                        $color = 'gray';
                        array_push($lessons, array('title' =>  $title, 'start' => $value['Data'], 'end' => $value['Data'], 'color' => $color,  'url'=> '/account/lesson-feedback/?date='.$value['Data'].'&time='.$value['Time']));
                        break;
                    default:
                        $color = 'blue';
                        array_push($lessons, array('title' => $value['Time'], 'start' => $value['Data'], 'end' => $value['Data'], 'color' => $color));
                        break;
//http://127.0.0.1/account/lesson-feedback/?date=2018-05-11&time=12:00&ref=eee5e1d597bbf0600bfc69734a2f4e546e991d2836d4de62ac8d5ba1b6fb5b1dd8100f3c30bf076069083e139ad22c84
                }


            }

        }

        echo json_encode($lessons);
    }

    public function add_events()
    {
        try {



            if (!$this->isFormatCorrect($_POST['Data'], 'DATE')) {
                throw new Exception('Incorrect date format');
            }

            if (!$this->isFormatCorrect($_POST['Time'], 'TIME')) {
                throw new Exception('Incorrect time format');
            }

            if (!$this->isFormatCorrect($_POST['Offset'], 'OFFSET')) {
                throw new Exception('Incorrect offset format');
            }


            $all_lessons = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons WHERE Data=?s', $_POST['Data']);
            $result = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons WHERE StudentID=?s AND StudentEmail=?s AND Data=?s', $this->student->getID(), $this->student->getEMAIL(), $_POST['Data']);



            if ($result) {

                throw new Exception('You have already picked this day');
            }


            preg_match('/^(\+|\-)[0-9]{2,2}/', $_POST['Offset'], $offset);


            if ((string)$_POST['Data'] == (string)gmdate('Y-m-d', strtotime($offset[0] . ' hours'))) {

                echo 'It\'s too late';

            } else {


                $date = new DateTime($_POST['Data']);
                $now = new DateTime();

                if($date < $now) {

                    echo 'This is past day, please choose available days';
                    die();
                }

                if(!$this->isTimeAvailable($_POST['Time'], $all_lessons, '01', '00:00')){

                    echo 'Time is not available, please try to choose another time';
                    die();
                }



                DataBase::getInstance()->getDB()->query('INSERT INTO c_lessons (Title, Data, Time, StudentID, StudentEmail, Status) VALUES (?s,?s,?s,?s,?s,?s)', 'Lesson', $_POST['Data'],
                    $_POST['Time'], $this->student->getID(), $this->student->getEMAIL(), 'approved');

                echo 'Lesson was added';
            }


        } catch (Exception $e) {

            echo $e->getMessage();
        }
    }

    public function edit_events()
    {

        try {

            if (!$this->isFormatCorrect($_POST['Data'], 'DATE')) {
                throw new Exception('Incorrect date format');
            }

            if (!$this->isFormatCorrect($_POST['Time'], 'TIME')) {
                throw new Exception('Incorrect time format');
            }

            if (!$this->isFormatCorrect($_POST['Offset'], 'OFFSET')) {
                throw new Exception('Incorrect offset format');
            }

            $all_lessons = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons WHERE Data=?s AND StudentID !=?s AND  StudentEmail !=?s', $_POST['Data'],$this->student->getID(), $this->student->getEMAIL());
            $result = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons WHERE StudentID=?s AND StudentEmail=?s AND Data=?s', $this->student->getID(), $this->student->getEMAIL(), $_POST['Data']);




            if ($result) {

                preg_match('/^[+|-}[0-9+]{2,}/', $_POST['Offset'], $offset);

                if ((string)$_POST['Data'] == (string)gmdate('Y-m-d', strtotime($offset[0] . ' hours'))) {

                    echo 'Unfortunately you can\'t change time, 24 hours before!';

                } else {

                    $date = new DateTime($_POST['Data']);
                    $now = new DateTime();

                    if($date < $now) {

                        echo 'This is past day, please choose available days';
                        die();
                    }

                    if(!$this->isTimeAvailable($_POST['Time'], $all_lessons, '01', '00:00')){

                        echo 'Time is not available, please try to choose another time';
                        die();

                    }


                    DataBase::getInstance()->getDB()->query('UPDATE c_lessons SET Time=?s WHERE StudentID=?s AND StudentEmail=?s AND Data=?s', $_POST['Time'], $this->student->getID(), $this->student->getEMAIL(), $_POST['Data']);

                    echo 'Time has been changed';

                }


            }else{

                throw new Exception('Date wasn\'t find');
            }

        } catch (Exception $es) {

            $es->getMessage();
        }

    }

    public function delete_events()
    {

        try {

            if (!$this->isFormatCorrect($_POST['Data'], 'DATE')) {

                throw new Exception('Incorrect date format');
            }


            DataBase::getInstance()->getDB()->query("DELETE FROM c_lessons WHERE StudentID=?s AND StudentEmail=?s AND Data=?s", $this->student->getID(), $this->student->getEMAIL(), $_POST['Data']);

            echo 'Lesson has been removed';

        } catch (Exception $e) {

            $e->getMessage();
        }

    }
}
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
                $time = $value['Time'];
                $time_out = '';
                for ($i = 0; $i < strlen($time); $i++) {
                    if ($i == 5) $time_out .= "\n";
                    $time_out .= $time[$i];
                }

                switch ($value['Status']) {
                    case 'approved':
                        $color = 'green';
                        break;
                    case 'not-approved':
                        $color = 'blue';
                        break;
                    case 'disallowed':
                        $color = 'red';
                        break;
                    case 'completed':
                        $color = 'gray';
                        break;
                    default:
                        $color = 'blue';

                }

                array_push($lessons, array('title' => $value['Time'], 'start' => $value['Data'], 'end' => $value['Data'], 'color' => $color, 'blocked' => 'true'));

            }

        }

        echo json_encode($lessons);
    }

    public function add_events()
    {
        try {

            $result = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons WHERE StudentID=?s AND StudentEmail=?s AND Data=?s', $this->student->getID(), $this->student->getEMAIL(), $_POST['Data']);
            if ($result) {

                throw new Exception('You have already picked this day');
            }

            preg_match('/^[+|-}[0-9+]{2,}/',$_POST['Offset'], $offset);

            if ((string)$_POST['Data'] == (string)gmdate('Y-m-d',strtotime($offset[0].' hours'))) {

                echo  'It\'s too late';

            }else{

                DataBase::getInstance()->getDB()->query('INSERT INTO c_lessons (Title, Data, Time, StudentID, StudentEmail, Status) VALUES (?s,?s,?s,?s,?s,?s)', 'Lesson', $_POST['Data'],
                    $_POST['Time'], $this->student->getID(), $this->student->getEMAIL(), 'not-approved');

                echo 'Lesson was added';
            }


        } catch (Exception $e) {

            echo $e->getMessage();
        }
    }

    public function edit_events()
    {

        try {

            $result = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons WHERE StudentID=?s AND StudentEmail=?s AND Data=?s', $this->student->getID(), $this->student->getEMAIL(), $_POST['Data']);

            if ($result) {

                preg_match('/^[+|-}[0-9+]{2,}/',$_POST['Offset'], $offset);

                if ((string)$_POST['Data'] == (string)gmdate('Y-m-d',strtotime($offset[0].' hours'))) {

                    echo  'Unfortunately you can\'t change time, 24 hours before!';

                }else{

                    DataBase::getInstance()->getDB()->query('UPDATE c_lessons SET Time=?s WHERE StudentID=?s AND StudentEmail=?s AND Data=?s', $_POST['Time'],$this->student->getID(), $this->student->getEMAIL(), $_POST['Data']);

                    echo 'Time has been changed';

                }


            }

        } catch (Exception $es) {

            $es->getMessage();
        }

    }

    public function delete_events(){

        try {

            DataBase::getInstance()->getDB()->query("DELETE FROM c_lessons WHERE StudentID=?s AND StudentEmail=?s AND Data=?s",$this->student->getID(), $this->student->getEMAIL(), $_POST['Data']);

            echo 'Lesson has been removed';

        } catch (Exception $es) {

            $es->getMessage();
        }

    }
}
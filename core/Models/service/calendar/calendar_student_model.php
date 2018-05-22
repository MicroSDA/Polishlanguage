<?php
/**
 * Created by PhpStorm.
 * User: Ro
 * Date: 5/4/2018
 * Time: 7:41 AM
 */

class calendar_student_model extends Model
{

    private $student;
    private $teachers;

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
            case 'ID':
                if (preg_match('/^[0-9]+$/', $array, $out)) {

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

        if ($all_time) {

            foreach ($all_time as $value) {


                $date_min = new DateTime($value['Time']); // минимальное значение времени
                $date_max = new DateTime($value['Time']); // максимальное значение времени

                $date_min->modify('-' . $delay . ' hour');
                $date_max->modify('+' . $delay . ' hour');


                // Проверяем, находится ли $date_now в диапазоне
                if ($date_now >= $date_min && $date_now <= $date_max) {
                    return false;
                    break;
                }
            }

        } else {

            $date_end_of_day_f = new DateTime('23:00');
            $date_end_of_day_s = new DateTime('24:00');

            $date_start_of_day_f = new DateTime('00:00');
            $date_start_of_day_s = new DateTime('01:00');


            if ($date_now >= $date_end_of_day_f && $date_now <= $date_end_of_day_s) {

                return false;
            }

            if ($date_start_of_day_f && $date_now <= $date_start_of_day_s) {

                return false;
            }
        }


        return true;
    }

    public function get_student_calendar()
    {

        $lessonsDB = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons WHERE StudentID=?i', $this->student->getID());
        $lessons = [];


        if ($lessonsDB) {

            foreach ($lessonsDB as $value) {

                $color = '';

                switch ($value['Status']) {
                    case 'approved':
                        $color = 'green';
                        array_push($lessons, array('title' => $value['Time'], 'start' => $value['Date'], 'end' => $value['Date'], 'color' => $color));
                        break;
                    case 'not-approved':
                        $color = 'blue';
                        array_push($lessons, array('title' => $value['Time'], 'start' => $value['Date'], 'end' => $value['Date'], 'color' => $color));
                        break;
                    case 'disallowed':
                        $color = 'red';
                        array_push($lessons, array('title' => $value['Time'], 'start' => $value['Date'], 'end' => $value['Date'], 'color' => $color));
                        break;
                    case 'completed':
                        $title = '';

                        if ($value['Feedback'] == 'open') {
                            $title = 'Оставьте свой отзыв' . "\n" . $value['Time'];

                        } else {

                            $title = $value['Time'];
                        }

                        $color = 'gray';
                        array_push($lessons, array('title' => $title, 'start' => $value['Date'], 'end' => $value['Date'], 'color' => $color, 'url' => '/account/lesson-feedback/?date=' . $value['Date'] . '&time=' . $value['Time']));
                        break;
                    default:
                        $color = 'blue';
                        array_push($lessons, array('title' => $value['Time'], 'start' => $value['Date'], 'end' => $value['Date'], 'color' => $color));
                        break;
                }


            }

        }

        echo json_encode($lessons);
    }

    public function add_student_lesson()
    {
        try {


            if (!$this->isFormatCorrect($_POST['Data'][0]['value'], 'DATE')) {
                throw new Exception('Incorrect date format');
            }

            if (!$this->isFormatCorrect($_POST['Data'][2]['value'], 'TIME')) {
                throw new Exception('Incorrect time format');
            }

            if (!$this->isFormatCorrect($_POST['Data'][1]['value'], 'ID')) {
                throw new Exception('Incorrect id format');
            }


            $teacherDB = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_teacher WHERE id=?i', $_POST['Data'][1]['value']);

            if ($teacherDB) {

                $teacher = new Teacher();
                $availebleTime = json_decode($teacherDB[0]['AvailableTime'], true);
                $token = md5(getenv("REMOTE_ADDR"). time()). md5($_POST['Data'][0]['value'].time()).md5($_POST['Data'][2]['value'].time());
                if ($teacher->setLesson($availebleTime, $_POST['Data'][0]['value'], $_POST['Data'][2]['value'], $_POST['Data'][1]['value'], 'yes', $token)) {

                   $isLesson = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons WHERE Date=?s AND Time=?s AND StudentID=?i',$_POST['Data'][0]['value'], $_POST['Data'][2]['value'], $this->student->getID());

                   if($isLesson){

                       echo 'Вы можете назначить только один урок в день';

                   }else{



                       DataBase::getInstance()->getDB()->query('INSERT INTO c_lessons (Date, Time, StudentID, TeacherID, Token) VALUES (?s,?s,?i,?i,?s)',
                           $_POST['Data'][0]['value'], $_POST['Data'][2]['value'], $this->student->getID(), $_POST['Data'][1]['value'],
                           $token );

                       echo 'Урок был назначаен, ожидайте звонка на ' . $this->student->getSKYPE();
                   }


                } else {

                    echo 'No';
                }

            }


        } catch (Exception $e) {

            echo $e->getMessage();
        }
    }

    public function edit_student_lesson()
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

            $all_lessons = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons WHERE Date=?s AND StudentID !=?s AND  StudentEmail !=?s', $_POST['Data'], $this->student->getID(), $this->student->getEMAIL());
            $result = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons WHERE StudentID=?s AND StudentEmail=?s AND Date=?s', $this->student->getID(), $this->student->getEMAIL(), $_POST['Data']);


            if ($result) {

                preg_match('/^[+|-}[0-9+]{2,}/', $_POST['Offset'], $offset);

                if ((string)$_POST['Data'] == (string)gmdate('Y-m-d', strtotime($offset[0] . ' hours'))) {

                    echo 'Unfortunately you can\'t change time, 24 hours before!';

                } else {

                    $date = new DateTime($_POST['Data']);
                    $now = new DateTime();

                    if ($date < $now) {

                        echo 'This is past day, please choose available days';
                        die();
                    }

                    if (!$this->isTimeAvailable($_POST['Time'], $all_lessons, '01', '00:00')) {

                        echo 'Time is not available, please try to choose another time';
                        die();

                    }


                    DataBase::getInstance()->getDB()->query('UPDATE c_lessons SET Time=?s WHERE StudentID=?s AND StudentEmail=?s AND Date=?s', $_POST['Time'], $this->student->getID(), $this->student->getEMAIL(), $_POST['Data']);

                    echo 'Time has been changed';

                }


            } else {

                throw new Exception('Date wasn\'t find');
            }

        } catch (Exception $es) {

            $es->getMessage();
        }

    }

    public function delete_student_lesson()
    {

        try {

            if (!$this->isFormatCorrect($_POST['Date'], 'DATE')) {

                throw new Exception('Incorrect date format');
            }

            if (!$this->isFormatCorrect($_POST['Time'], 'TIME')) {

                throw new Exception('Incorrect date format');
            }


            $lesson = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons WHERE Date=?s AND Time=?s AND StudentID=?i AND Status=?s', $_POST['Date'], $_POST['Time'], $this->student->getID(), 'approved');
            if ($lesson) {

                $teacher = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_teacher WHERE id=?i', $lesson[0]['TeacherID']);

                if ($teacher) {

                    $teacher_func = new Teacher();
                    $availebleTime = json_decode($teacher[0]['AvailableTime'], true);

                    if ($teacher_func->unsetLesson($availebleTime, $_POST['Date'], $_POST['Time'], $teacher[0]['id'])) {

                        DataBase::getInstance()->getDB()->query('DELETE FROM c_lessons WHERE Date=?s AND Time=?s AND StudentID=?i AND TeacherID=?i',
                            $_POST['Date'], $_POST['Time'], $this->student->getID(), $teacher[0]['id']);

                        echo 'Назначенный урок был успешно удален';

                    } else {

                        echo 'Unset function error';
                    }


                } else {

                    echo 'Учитель был не найден';
                }

            } else {

                echo 'Урок был не обнаружен';
            }


        } catch (Exception $e) {
            $e->getMessage();
        }
    }

    public function get_all_teachers()
    {

        try {

            //echo $_POST['Date'];

            if (!$this->isFormatCorrect($_POST['Date'], 'DATE')) {
                throw new Exception('Incorrect date format');
            }


            $this->teachers = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_teacher WHERE Level=?s', $this->student->getLEVEL());

            if ($this->teachers) {

                $available_teachers = [];

                foreach ($this->teachers as $key_one => $value_one) {

                    $timesArray = json_decode($value_one['AvailableTime'], true);


                    foreach ($timesArray as $value_two) {

                        if (array_search($_POST['Date'], $value_two)) {

                            array_push($available_teachers, $this->teachers[$key_one]);
                            break;

                        }

                    }


                }

               if(empty($available_teachers)){
                   echo 'We can\'t find any teachers that equals to your level';

               }else{
                   echo '<div class="row">';
                   foreach ($available_teachers as $value) {
                       echo '<div class="col-lg-4 col-sm-3">';
                       echo '<div class="thumbnail">';
                       echo '<div class="caption">';
                       echo '<h5 style="text-align: center">Профиль</h5>
                                <hr>
                                <h6>Имя: ' . $value['FirstName'] . '</h6>
                                <h6>Уровень: ' . $value['Level'] . '</h6>
                                <h6>Доступное время</h6>
                                <hr>';
                       echo '<form id="' . $value['id'] . '">';
                       echo '<input type="text" name="date" value="' . $_POST['Date'] . '" hidden/>';
                       echo '<input type="text" name="id" value="' . $value['id'] . '" hidden/>';
                       echo '<div data-toggle="buttons">';
                       $teacher_time_to_array = json_decode($value['AvailableTime'], true);
                       $inuse = true;

                       foreach ($teacher_time_to_array as $time) {
                           if ($time['start'] == $_POST['Date'] && $time['in-use'] == 'no') {
                               $inuse = false;
                               echo '<label class="btn btn-primary">
                                                 <input type="radio" name="time" id="" value="' . $time['title'] . '" autocomplete="off">' . $time['title'] . '
                                                 </label>
                                             <br><br>';
                           }
                       }

                       if ($inuse) {

                           echo 'Все время занято';
                       }

                       echo '</div>';
                       echo '<hr>';
                       if (!$inuse) {
                           echo '<button type="button" class="btn btn-success" onclick="addNewLesson(\'' . $value['id'] . '\')">Выбрать</button>';
                       }

                       echo '</form>';
                       echo '</div>';
                       echo '</div>';
                       echo '</div>';
                   }
                   echo '</div>';

               }

            } else {

                echo 'We can\'t find any teachers that equals to your level';
            }

        } catch (Exception $e) {

            echo $e->getMessage();
        }
    }
}


<?php
/**
 * Created by PhpStorm.
 * User: Ro
 * Date: 5/16/2018
 * Time: 19:41
 */

class calendar_teacher_model
{
    private $teacher;

    public function __construct()
    {
        $this->teacher = new Teacher();
        if (!$this->teacher->isLogin()) {
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

    public function get_time(){

        try{

            $time = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_teacher WHERE id=?i AND Email=?s', $this->teacher->getID(),$this->teacher->getEMAIL());
            $time_out = json_decode($time[0]['AvailableTime'],true);

            foreach ($time_out as $key=> $value){
                if($value['in-use']== 'yes' ){
                    $time_out[$key]['color']= 'green';
                }

            }

            echo json_encode($time_out);

        }catch (Exception $e){

            echo $e->getMessage();
        }
    }

    public function add_time(){
        try {


            if (!$this->isFormatCorrect($_POST['Date'], 'DATE')) {
                throw new Exception('Incorrect date format');
            }

            if (!$this->isFormatCorrect($_POST['Time'], 'TIME')) {
                throw new Exception('Incorrect time format');
            }

            if (!$this->isFormatCorrect($_POST['Offset'], 'OFFSET')) {
                throw new Exception('Incorrect offset format');
            }


              $teacher_time =  DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_teacher WHERE id=?i AND Email=?s',$this->teacher->getID(),$this->teacher->getEMAIL());
              $array = json_decode($teacher_time[0]['AvailableTime'],true);

              $this->teacher->addAVAILABLETIME($array, $_POST['Date'], $_POST['Time']);


        } catch (Exception $e) {

            echo $e->getMessage();
        }
    }

    public function delete_time(){

        try{

            if (!$this->isFormatCorrect($_POST['Date'], 'DATE')) {
                throw new Exception('Incorrect date format');
            }

            if (!$this->isFormatCorrect($_POST['Time'], 'TIME')) {
                throw new Exception('Incorrect time format');
            }

            $teacher_time =  DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_teacher WHERE id=?i AND Email=?s',$this->teacher->getID(),$this->teacher->getEMAIL());
            $array = json_decode($teacher_time[0]['AvailableTime'],true);

            if($this->teacher->deleteAVAILABLETIME($array, $_POST['Date'], $_POST['Time'])){

                echo 'Время было удалено';

            }else{

                echo 'Урок уже был назначен на это время';
            }

        }catch (Exception $e){

            echo $e->getMessage();
        }

    }
}
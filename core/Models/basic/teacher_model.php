<?php
/**
 * Created by PhpStorm.
 * User: bansc
 * Date: 2/10/2018
 * Time: 8:48 PM
 */

class teacher_model extends Model
{

    private $teacher;

    public function __construct()
    {
        parent::__construct();

        $this->teacher = new Teacher();
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
            case 'TOKEN':
                if (preg_match('/^[a-zA-Z0-9_-]+$/', $array, $out)) {

                    return true;
                } else {
                    return false;
                }
                break;

        }
    }

    public function dashboard(){

        if (!$this->teacher->isLogin()) {

            header('Location:/login');
            die();
        }


        /**
         * If GET action is logout the delete cookie
         */
        if (isset($_GET['submit'])) {

            switch ($_GET['submit']) {
                case 'logout':
                    setcookie('t-id', '', time() - 100, "/");
                    setcookie('t-hash', '', time() - 100, "/");
                    header('Location:' . $_SERVER['HTTP_REFERER']);
                    break;
                default:
                    break;
            }
        }

        /**
         * Main Body Section ///////////////////////////////////////////////////////////////////////////////////////////
         */

        DataManager::getInstance()->addData('Teacher', $this->teacher);


        /**
         * Render///////////////////////////////////////////////////////////////////////////////////////////////////////
         */


        $this->render();
    }

    public function lessons(){

        if (!$this->teacher->isLogin()) {

            header('Location:/login');
            die();
        }


        DataManager::getInstance()->addData('Teacher', $this->teacher);
        $this->render();
    }

    public function available_time(){

        if (!$this->teacher->isLogin()) {

            header('Location:/login');
            die();
        }
        /**
         * Main Body Section ///////////////////////////////////////////////////////////////////////////////////////////
         */


        DataManager::getInstance()->addData('Teacher', $this->teacher);
        /**
         * Render///////////////////////////////////////////////////////////////////////////////////////////////////////
         */

        $this->render();
    }

    public function lesson(){

        if (!$this->teacher->isLogin()) {

            header('Location:/login');
            die();
        }
        /**
         * Main Body Section ///////////////////////////////////////////////////////////////////////////////////////////
         */




        if(isset($_GET['date']) and isset($_GET['time']) and isset($_GET['token'])){

            try{

                if (!$this->isFormatCorrect($_GET['date'], 'DATE')) {
                    throw new Exception('Incorrect date format');
                }



                if (!$this->isFormatCorrect($_GET['time'], 'TIME')) {
                    throw new Exception('Incorrect time format');
                }

                if (!$this->isFormatCorrect($_GET['token'], 'TOKEN')) {
                    throw new Exception('Incorrect token format');
                }


               $lesson = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons WHERE Date=?s AND Time=?s AND Token=?s',
                   $_GET['date'],$_GET['time'],$_GET['token']);


                if($lesson){

                    DataManager::getInstance()->addData('Lesson',$lesson[0]);

                    $student =  DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_students WHERE id=?i',$lesson[0]['StudentID']);

                    if($student){

                        DataManager::getInstance()->addData('Student',$student[0]);



                        if($lesson[0]['Status']=='approved'){

                            DataManager::getInstance()->addData('Status','approved');

                        }

                        if($lesson[0]['Status']=='completed'){
                            DataManager::getInstance()->addData('Status','completed');
                        }



                    }else{

                        UrlsDispatcher::getInstance()->setCurrentUrlData(UrlsDispatcher::getInstance()->getUrlsDataListByKey('(^)'));
                        $controller = new Controller();
                        die();
                    }


                }else{

                    UrlsDispatcher::getInstance()->setCurrentUrlData(UrlsDispatcher::getInstance()->getUrlsDataListByKey('(^)'));
                    $controller = new Controller();
                    die();
                }

            }catch (Exception $e){
                $e->getMessage();
            }
        }


        DataManager::getInstance()->addData('Teacher', $this->teacher);
        /**
         * Render///////////////////////////////////////////////////////////////////////////////////////////////////////
         */

        $this->render();
    }

}

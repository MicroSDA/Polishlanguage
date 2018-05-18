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

    public function index(){

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

    public function get_student_profile(){

        if (!$this->teacher->isLogin()) {

            header('Location:/login');
            die();
        }
        /**
         * Main Body Section ///////////////////////////////////////////////////////////////////////////////////////////
         */

        if(isset($_GET['ref'])){

            try{

               $student = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_students WHERE Referal=?s',$_GET['ref'] );

                if($student){
                    DataManager::getInstance()->addData('Student',$student[0]);
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

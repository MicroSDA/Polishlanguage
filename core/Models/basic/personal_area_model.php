<?php
/**
 * User: Ro Kovalenko
 * Date: 12/30/2017
 * Time: 7:58 PM
 */

class personal_area_model extends Model
{

    /**
     * index_model constructor.
     */

    private $students;

    public function __construct()
    {
        parent::__construct();


        $this->students = new Students();

    }

    /**
     *
     */
    public function index()
    {
        /**
         * If isn't login then redirect to login page
         */
        if (!$this->students->isLogin()) {

            header('Location:/login');
            die();
        }


        /**
         * If GET action is logout the delete cookie
         */
        if (isset($_GET['submit'])) {

            switch ($_GET['submit']){
                case 'logout':
                    setcookie('id','',time()-100,"/");
                    setcookie('hash', '',time()-100,"/");
                    header('Location:' . $_SERVER['HTTP_REFERER']);
                    break;
                default:
                    break;
            }
        }

        /**
         * Main Body Section ///////////////////////////////////////////////////////////////////////////////////////////
         */



        $lessons = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons_pdf');
        DataManager::getInstance()->addData('Lessons', $lessons);
        DataManager::getInstance()->addData('Students', $this->students);







        /**
         * Render///////////////////////////////////////////////////////////////////////////////////////////////////////
         */
        $this->render();

    }

    public function login()
    {

        if ($this->students->isLogin()) {

            header('Location:/account');
            die();
        }


        $this->render();
    }

    public function logout(){

    }
}

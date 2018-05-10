<?php
/**
 * User: Ro Kovalenko
 * Date: 12/30/2017
 * Time: 7:58 PM
 */

require_once URL_ROOT.'/core/Libs/Basic/General/ContentsDraw.php';

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

            switch ($_GET['submit']) {
                case 'logout':
                    setcookie('id', '', time() - 100, "/");
                    setcookie('hash', '', time() - 100, "/");
                    header('Location:' . $_SERVER['HTTP_REFERER']);
                    break;
                default:
                    break;
            }
        }

        /**
         * Main Body Section ///////////////////////////////////////////////////////////////////////////////////////////
         */

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

    public function contents()
    {

        /**
         * If isn't login then redirect to login page
         */
        if (!$this->students->isLogin()) {

            header('Location:/login');
            die();
        }


        /**
         * Main Body Section ///////////////////////////////////////////////////////////////////////////////////////////
         */


        $lessons_A1 = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons_pdf WHERE Level=?s','A1');
        $lessons_A2 = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons_pdf WHERE Level=?s','A2');
        $lessons_B1 = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons_pdf WHERE Level=?s','B1');
        $lessons_B2 = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons_pdf WHERE Level=?s','B2');
        $lessons_C1 = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons_pdf WHERE Level=?s','C1');

        DataManager::getInstance()->addData('LessonsA1', $lessons_A1);
        DataManager::getInstance()->addData('LessonsA2', $lessons_A2);
        DataManager::getInstance()->addData('LessonsB1', $lessons_B1);
        DataManager::getInstance()->addData('LessonsB2', $lessons_B2);
        DataManager::getInstance()->addData('LessonsC1', $lessons_C1);

        DataManager::getInstance()->addData('Students', $this->students);



        /**
         * Render///////////////////////////////////////////////////////////////////////////////////////////////////////
         */
        $this->render();

    }
}
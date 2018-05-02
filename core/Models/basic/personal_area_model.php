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


        if (!$this->students->isLogin()) {

            header('Location:/login');
            die();
        }


        $lessons = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons_pdf');
        DataManager::getInstance()->addData('Lessons', $lessons);
        DataManager::getInstance()->addData('Students', $this->students);


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
}

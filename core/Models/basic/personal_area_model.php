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
    public function __construct()
    {


        parent::__construct();

    }

    /**
     *
     */
    public function index()
    {
        $lessons = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons_pdf');
        DataManager::getInstance()->addData('Lessons',$lessons);
        $this->render();

    }

}

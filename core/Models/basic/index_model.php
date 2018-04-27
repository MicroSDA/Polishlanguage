<?php
/**
 * User: Ro Kovalenko
 * Date: 12/30/2017
 * Time: 7:58 PM
 */


class index_model extends Model
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

        DataManager::getInstance()->addData('lox', 'Hi');

        $x = 10/5;
        DataManager::getInstance()->addData('x', $x);
        $this->render();

    }

}
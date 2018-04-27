<?php
/**
 * Created by PhpStorm.
 * User: bansc
 * Date: 1/19/2018
 * Time: 7:56 PM
 */

class DataManager
{

    /**
     * @var
     */
    protected static $_instance;

    /**
     * @var
     */
    private $data;

    /**
     * DataManager constructor.
     */
    private function __construct() {

    }

    /**
     * @return DataManager
     */
    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }


    /**
     *
     */
    private function __wakeup() {

    }


    /**
     *
     */
    private function __clone() {
    }


    /**
     * @param $key
     * @return mixed
     */
    public function getDataByKey($key)
    {
        return $this->data[$key];
    }


    /**
     * @return mixed
     */
    public function getAllData(){

        return $this->data;
    }
    /**
     * @param $key
     * @param $data
     */
    public function addData($key, $data)
    {
        $this->data[$key]= $data;
    }



}
<?php
/**
 * Created by PhpStorm.
 * User: bansc
 * Date: 12/30/2017
 * Time: 10:36 PM
 */




class error_404_model extends Model {


    /**
     * error_model constructor.
     */
    public function __construct(){


        parent::__construct();

    }

    /**
     *
     */
    public function index(){
         header('HTTP/1.1 404 Not Found');
        $this->render();

    }
}
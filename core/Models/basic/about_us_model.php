<?php
/**
 * Created by PhpStorm.
 * User: bansc
 * Date: 1/20/2018
 * Time: 6:35 PM
 */

class about_us_model extends Model
{

    /**
     * about_us_model constructor.
     */
    public function __construct(){


        parent::__construct();

    }

    /**
     *
     */
    public function index(){

        $this->render();

    }
}

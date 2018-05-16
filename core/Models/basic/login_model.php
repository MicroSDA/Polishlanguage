<?php
/**
 * Created by PhpStorm.
 * User: Ro
 * Date: 5/14/2018
 * Time: 20:52
 */

class login_model extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function login(){

        $this->render();
    }
}
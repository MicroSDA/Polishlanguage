<?php
/**
 * Created by PhpStorm.
 * User: bansc
 * Date: 1/29/2018
 * Time: 11:06 PM
 */

class ajax_page_model extends Model
{

    public function __construct(){


        parent::__construct();

    }

    public function index(){

        $this->render();
    }
}
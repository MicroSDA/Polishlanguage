<?php
/**
 * Created by PhpStorm.
 * User: Ro
 * Date: 7/18/2018
 * Time: 14:09
 */

class contact_model extends Model
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


        $this->render(false,false);

    }

}
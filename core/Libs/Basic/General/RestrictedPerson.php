<?php
/**
 * Created by PhpStorm.
 * User: bansc
 * Date: 4/27/2018
 * Time: 1:13 AM
 */

class RestrictedPerson
{

    public function __construct()
    {


        $restricted = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_restricted_person WHERE IP =?s', $_SERVER['REMOTE_ADDR']);
        if($restricted){

            echo 'We\'ve restricted your access to the web site! <br>';
            echo 'Reason: '.$restricted[0]['Reason'].'';
            die();
        }

    }
}
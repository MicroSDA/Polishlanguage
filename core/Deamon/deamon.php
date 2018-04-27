<?php
/**
 * Created by PhpStorm.
 * User: bansc
 * Date: 1/27/2018
 * Time: 10:09 PM
 */


 require_once $_SERVER['DOCUMENT_ROOT'].'/core/Libs/DataBase/DataBase.php';

 DataBase::getInstance()->getDB()->query('INSERT INTO c_deamon (Message) VALUES (?s)','Hello');
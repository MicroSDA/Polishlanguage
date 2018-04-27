<?php
/**
 * Created by PhpStorm.
 * User: bansc
 * Date: 2/10/2018
 * Time: 6:48 PM
 */

class  Visitor
{


    /**
     * Visitor constructor.
     */
    protected static $_instance;

    private function __construct()
    {

    }

    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }


    public static function addVisitor()
    {

        if(isset($_SERVER['HTTP_USER_AGENT']) and $_SERVER['REMOTE_ADDR']){


            $hour = date('H');
            $day = date('d');
            $week = date('l');
            $week_n = date('W');
            $month = date('F');
            $year = date('Y');

            try{

                DataBase::getInstance()->getDB()->query("INSERT INTO c_visitor (Browser, Hour, Day, Week, WeekN, Month, Year, Name, Page, Ip) VALUES (?s, ?s, ?s, ?s, ?s, ?s, ?s, ?s, ?s, ?s)",
                    $_SERVER['HTTP_USER_AGENT'], $hour , $day, $week, $week_n, $month, $year, UrlsDispatcher::getInstance()->getCurrentUrlData()['name'], $_SERVER['REQUEST_URI'], $_SERVER['REMOTE_ADDR']);
            }catch (Exception $exception){

                //echo $exception;
            }

        }


    }
}
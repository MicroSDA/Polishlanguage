<?php
/**
 * User: Ro Kovalenko
 * Date: 12/30/2017
 * Time: 2:24 PM
 */


/**
 * Catch all exception
 */

/**
 * Define global time of start script
 */

   function arrayPrint($array_i){
       echo '<pre>';
       print_r($array_i);
       echo '</pre>';
   }

    $GLOBALS['time'] = microtime(true);

    try{

        /**
         * Predefine section
         */

        define('URL_ROOT', $_SERVER['DOCUMENT_ROOT']); /** Core address */

        /**
         * End of Predefine section
         */

        require URL_ROOT.'/core/Libs/Config/Bootstrap.php';
        $Router = new Router();


    } catch (Exception $message){

        echo '<div style="text-align: center"><span class="btn btn-danger">INTERNAL ERROR<hr>'.$message->getMessage().'<hr>Contact with developer !</span></div>.';
    }



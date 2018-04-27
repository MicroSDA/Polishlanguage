<?php
/**
 * User: Ro Kovalenko
 * Date: 12/30/2017
 * Time: 7:59 PM
 */

class Model
{

    /**
     * Model constructor.
     */
    public function __construct()
    {

    }

    protected function render($header = 'header.php', $footer ='footer.php',$index ='index.php'){

        View::getInstance()->setViewFolder(UrlsDispatcher::getInstance()->getCurrentUrlData()['view']);

        if($header == false){


        }else{

            View::getInstance()->setHeader($header);
        }

        View::getInstance()->setIndex($index);

        if($footer == false){

        }else{

            View::getInstance()->setFooter($footer);
        }


        View::getInstance()->render($header,$footer);

    }

}
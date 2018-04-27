<?php
/**
 * Created by PhpStorm.
 * User: bansc
 * Date: 1/19/2018
 * Time: 10:09 PM
 */

class View
{

    /**
     * @var
     */
    protected static $_instance;
    /**
     * @var
     */
    private $view_folder;
    /**
     * @var
     */
    private $header;
    /**
     * @var
     */
    private $footer;
    /**
     * @var
     */
    private $index;

    /**
     * View constructor.
     */
    private function __construct() {


    }


    /**
     * @return View
     */
    public static function getInstance() {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    /**
     * @return mixed
     */
    public function getHeader()
    {
        return $this->header;
    }


    /**
     * @param $header
     * @throws ErrorException
     */
    public function setHeader($header)
    {

        if (file_exists(URL_ROOT .'/views/public/'.TemplateManager::getInstance()->getTemplate()['path']  . '/'.$header.'')) {

            $this->header = URL_ROOT .'/views/public/'.TemplateManager::getInstance()->getTemplate()['path'] . '/'.$header.'';

        } else {

            throw new ErrorException(sprintf('TEMPLATE HEADER WAS NOT FOUND IN "%s"',URL_ROOT .'/views/public/'.TemplateManager::getInstance()->getTemplate()['path']  . '/'));
        }
    }

    /**
     * @return mixed
     */
    public function getFooter()
    {
        return $this->footer;
    }


    /**
     * @param $footer
     * @throws ErrorException
     */
    public function setFooter($footer)
    {

        if (file_exists(URL_ROOT . '/views/public/'.TemplateManager::getInstance()->getTemplate()['path'] . '/'.$footer.'')) {

            $this->footer = URL_ROOT .  '/views/public/'.TemplateManager::getInstance()->getTemplate()['path'] . '/'.$footer.'';

        } else {

            throw new ErrorException(sprintf('TEMPLATE FOOTER WAS NOT FOUND IN "%s"',URL_ROOT . '/views/public/'.TemplateManager::getInstance()->getTemplate()['path']  . '/'));
        }
    }

    /**
     * @return mixed
     */
    public function getIndex()
    {
        return $this->index;
    }


    /**
     * @param $index
     * @throws ErrorException
     */
    public function setIndex($index)
    {
        $this->index = $index;

        if (file_exists(URL_ROOT . '/views/public/'.TemplateManager::getInstance()->getTemplate()['path'] . '/'.$this->view_folder.'/'.$index.'')) {

            $this->index = URL_ROOT . '/views/public/'.TemplateManager::getInstance()->getTemplate()['path']  . '/'.$this->view_folder.'/'.$index.'';


        } else {

            throw new ErrorException(sprintf('TEMPLATE INDEX WAS NOT FOUND IN "%s"', URL_ROOT  .'/views/public/'.TemplateManager::getInstance()->getTemplate()['path']  . '/'.$this->view_folder.'/'));
        }
    }


    /**
     * @return mixed
     */
    public function getViewFolder()
    {
        return $this->view_folder;
    }

    /**
     * @param mixed $view_folder
     */
    public function setViewFolder($view_folder)
    {
        $this->view_folder = $view_folder;
    }


    /**
     *
     */
    private function __wakeup() {

    }

    /**
     *
     */
    private function __clone() {
    }


    /**
     * @throws ErrorException
     */
    public function render($header = true, $footer = true){

        ob_start();
        ob_implicit_flush(0);
        try{

            if($header == false){

            }else{

                require_once $this->header;
            }

            require_once $this->index;

            if($footer == false){

            }else{
                require_once $this->footer;
            }


        }catch (ErrorException $error){

            ob_end_clean();

            throw $error;
        }

        if(UrlsDispatcher::getInstance()->getCurrentUrlData()['cache']=='yes'){

          if(!CacheGenerator::isCache()){
              CacheGenerator::generateCache();
          }
        }
          /* echo '<div style="text-align: center;">Usage:'.round(memory_get_usage() / 1024 / 1024, 2).'MB</div>';
           echo ' <div style="text-align: center;">Time:'.(microtime(true) - $GLOBALS['time']) .'Sec</div>';*/

        echo ob_get_clean();
    }
}

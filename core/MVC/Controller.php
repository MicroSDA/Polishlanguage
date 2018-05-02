<?php

/**
 * Class controller
 *
 */



class controller
{

    /**
     * @var
     */
    private $model;
    /**
     * controller constructor.
     * @throws ErrorException
     */
    public function __construct()
    {
        /**
         * Initialize Model
         */
        if (is_file(URL_ROOT . '/core/Models/' .UrlsDispatcher::getInstance()->getCurrentUrlData()['type'].'/'.UrlsDispatcher::getInstance()->getCurrentUrlData()['model']. '.php')) {

            require_once URL_ROOT . '/core/Models/' .UrlsDispatcher::getInstance()->getCurrentUrlData()['type'].'/'. UrlsDispatcher::getInstance()->getCurrentUrlData()['model'] . '.php';

            $modelName =  basename(UrlsDispatcher::getInstance()->getCurrentUrlData()['model']);
            $this->model = new $modelName();
            $method = UrlsDispatcher::getInstance()->getCurrentUrlData()['method'];

            /**
             * Run current method following by urls template
             */
            if (method_exists($this->model, $method)) {

                $this->model->$method();


            } else {

                throw new ErrorException(sprintf('METHOD "%s" IS NOT FOUND IN "%s"', UrlsDispatcher::getInstance()->getCurrentUrlData()['method'], URL_ROOT . '/core/Models/' .
                    UrlsDispatcher::getInstance()->getCurrentUrlData()['model'] . '.php'));
            }

        } else {

            throw new ErrorException(sprintf('MODEL "%s" IS NOT FOUND IN "%s"', UrlsDispatcher::getInstance()->getCurrentUrlData()['model'], URL_ROOT . '/core/Models/'));
        }


    }

}
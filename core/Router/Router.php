<?php
/**
 * User: Ro Kovalenko
 * Date: 12/30/2017
 * Time: 1:19 PM
 */

/**
 * Class Router
 *
 * Simple scheme of work
 * 1.Default initialization
 * 2.Call Parse function(pars incoming url)
 * 3.Call Routing function for check our income url parameters and return answer
 * 4.Check answers by switch
 * 5.Call controller
 *
 */
class Router
{

    /**
     * @var UrlsManager
     */
    private $urls_manager;
    /**
     * @var UrlsDispatcher
     */
    private $request_url;
    /**
     * @var
     */
    private $url_data;
    /**
     * @var
     */
    private $controller;


    /**
     *
     */
    private function route()
    {

        /**
         *  Visitors
         */
        require_once URL_ROOT.'/core/Libs/Basic/General/Visitor.php';
        /**
         * Skip statistic if url's contain file format and url has service type
         */
        if(!preg_match('(\.(css|js|php|mp4|txt|jpeg|gif|png|woff|woff2|ttf|map|ico)$)',UrlsDispatcher::getInstance()->getUlrRequest())
            && UrlsDispatcher::getInstance()->getCurrentUrlData()['type'] != 'service'){

            Visitor::addVisitor();

        }

        /**
         * If server's cache exist
         */

        if(UrlsDispatcher::getInstance()->getCurrentUrlData()['cache']=='yes') {

            if (CacheGenerator::isCache()) {

                CacheGenerator::getCache();
                die();
                /**
                 * End of server work if cache exist
                 */

            }else{
                $this->controller = new Controller();
            }

        }else{
            $this->controller = new Controller();
        }
    }

    /**
     * @throws ErrorException
     */
    private function parse()
    {

        /**
         *  Getting url
         */
        $this->request_url = rtrim($_SERVER['REQUEST_URI'], '/');
        $this->request_url = mb_strtolower($this->request_url, 'UTF-8');
        $this->url_data = $this->urls_manager->manegeUrl($this->request_url);

        /**
         * Set Current Url Data
         */
        UrlsDispatcher::getInstance()->setCurrentUrlData($this->url_data);
        /**
         * Set Current Url Request
         */
        UrlsDispatcher::getInstance()->setUlrRequest($this->request_url);


    }

    /**
     * Router constructor.
     * @throws ErrorException
     */
    public function __construct()
    {

        $this->urls_manager = new UrlsManager(URLS_CONFIG_FILE_PATH);
        $this->parse();
        $this->route();

    }


}

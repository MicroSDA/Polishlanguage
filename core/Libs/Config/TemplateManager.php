<?php
/**
 * Created by PhpStorm.
 * User: bansc
 * Date: 1/18/2018
 * Time: 9:28 PM
 */

class TemplateManager
{

    /**
     * @var
     */
    protected static $_instance;
    /**
     * @var array
     */
    private $template = [];

    /**
     * @var array
     */
    private $assets = [];
    /**
     * @var
     */
    private $current_page;

    /**
     * @var
     */
    private $xml_parse_doc;

    /**
     * @return array
     */
    public function getTemplate()
    {

        return $this->template;
    }



    public function getAssets($page, $key){

        if(isset($this->assets[$page][$key])){
            return $this->assets[$page][$key];

        }else{

            return false;
        }

    }

    /**
     * @param $page
     * @param $key
     * @return mixed
     */
    public function assetsDraw($page, $key)
    {

     /** echo '<pre>';
        var_dump($this->assets[$page][$key]);
       echo '</pre>';*/

        if ($key == 'css') {

            $css_out = '';


            foreach ($this->assets[$page][$key] as $keys=> $value) {

                if($value['type'] == 'internal') {

                    $css_temp = '<link href="' . $value['url'] . '?page=' . UrlsDispatcher::getInstance()->getCurrentUrlData()['name'] . '&hash=' . $keys . '" rel="stylesheet">' . "\n";
                    $css_out .= $css_temp;
                }else{

                    $css_temp = '<link href="' . $value['path'] . '"rel="stylesheet">' . "\n";
                    $css_out .= $css_temp;
                }

            }

            return $css_out;
        }


        if ($key == 'js') {

            $js_out = '';
            foreach ($this->assets[$page][$key] as $keys=> $value) {

                if($value['type'] == 'internal'){

                    $js_temp = '<script src="' . $value['url'] .'?page='.UrlsDispatcher::getInstance()->getCurrentUrlData()['name'].'&hash='.$keys. '"></script>' . "\n";
                    $js_out .= $js_temp;

                }else{

                    $js_temp = '<script src="' . $value['path'] .'"></script>' . "\n";
                    $js_out .= $js_temp;
                }



            }

            return $js_out;
        }



        return '<!--Key wasn\'t defined!! -->';

    }

    /**
     * TemplateManager constructor.
     * @throws ErrorException
     */


    private function __construct()
    {
        //echo 'construct<br>';
        $this->read();
    }

    /**
     * @return TemplateManager
     */
    public static function getInstance()
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }

    /**
     * @throws ErrorException
     */
    private function read()
    {

        $this->xml_parse_doc = new XMLReader();

        if (!$this->xml_parse_doc->open(URL_ROOT . '/config/Template-Config.xml')) {

            throw new ErrorException('TEMPLATE CONFIG FILE IS NOT EXIST');

        } else {

            while ($this->xml_parse_doc->read()) {

                if ($this->xml_parse_doc->nodeType == XMLReader::ELEMENT) {


                    if ($this->xml_parse_doc->localName == 'Template') {


                        $this->template['status'] = $this->xml_parse_doc->getAttribute('status');
                        $this->template['path'] = $this->xml_parse_doc->getAttribute('folder');


                        $this->xml_parse_doc->read();
                        if ($this->xml_parse_doc->nodeType == XMLReader::TEXT) {
                            $this->template['name'] = $this->xml_parse_doc->value;

                        }


                    }

                    if ($this->xml_parse_doc->localName == 'Page') {

                        $this->current_page = $this->xml_parse_doc->getAttribute('name');

                    }

/////////////////////////////////////////////////////////////////////////////////////////////


                    if ($this->xml_parse_doc->localName == 'css') {

                        $css['type'] = $this->xml_parse_doc->getAttribute('type');
                        if ($css['type'] == 'internal') {

                            $css['path'] = '/views/public/' . $this->template['path'] . $this->xml_parse_doc->getAttribute('path');
                            $css['url'] = $this->xml_parse_doc->getAttribute('url');
                            $css['file'] = $this->xml_parse_doc->getAttribute('file');
                            $this->assets[$this->current_page]['css'][$this->xml_parse_doc->getAttribute('hash')] = $css;

                        }else{

                            $css['path'] = $this->xml_parse_doc->getAttribute('path');
                            $this->assets[$this->current_page]['css'][$this->xml_parse_doc->getAttribute('path')] = $css;
                        }


                    }


                    if ($this->xml_parse_doc->localName == 'js') {

                        $js['type'] = $this->xml_parse_doc->getAttribute('type');

                        if ($js['type'] == 'internal') {

                            $js['path'] = '/views/public/' . $this->template['path'] . $this->xml_parse_doc->getAttribute('path');
                            $js['url'] = $this->xml_parse_doc->getAttribute('url');
                            $js['file'] = $this->xml_parse_doc->getAttribute('file');
                            $this->assets[$this->current_page]['js'][$this->xml_parse_doc->getAttribute('hash')] = $js;
                        } else {

                            $js['path'] = $this->xml_parse_doc->getAttribute('path');
                            $this->assets[$this->current_page]['js'][$this->xml_parse_doc->getAttribute('path')] = $js;
                        }




                    }

                }
            }
        }

    }


    /**
     * @throws ErrorException
     */
    private function read_old()
    {


        $this->xml_parse_doc = new XMLReader();

        if (!$this->xml_parse_doc->open(URL_ROOT . '/config/Template-Config.xml')) {

            throw new ErrorException('TEMPLATE CONFIG FILE IS NOT EXIST');
        }


        while ($this->xml_parse_doc->read()) {

            if ($this->xml_parse_doc->nodeType == XMLReader::ELEMENT) {

                if ($this->xml_parse_doc->localName == 'Template') {


                    if ($this->xml_parse_doc->getAttribute('status') == 'ACTIVE') {

                        $this->template['status'] = $this->xml_parse_doc->getAttribute('status');
                        $this->template['path'] = $this->xml_parse_doc->getAttribute('folder');

                        $this->xml_parse_doc->read();

                        if ($this->xml_parse_doc->nodeType == XMLReader::TEXT) {

                            $this->template['name'] = $this->xml_parse_doc->value;
                            $this->xml_parse_doc->read();
                            /**
                             * Load Assets
                             */
                            $this->xml_parse_doc->read();
                            /**
                             * When we have found Page Name
                             */
                            while ($this->xml_parse_doc->localName == 'Page') {
                                echo 'Page';

                                $this->xml_parse_doc->next('Assets-Css');
                                if ($this->xml_parse_doc->localName == 'Assets-Css') {

                                    echo 'Assets-Css';
                                }

                                $this->xml_parse_doc->moveToElement();
                                $this->xml_parse_doc->next('Page');
                            }


                        } else {

                            throw new ErrorException('TEMPLATE NAME IS NOT EXIST');
                        }

                    }

                }
            }

        }
    }
}


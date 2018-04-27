<?php

class assets_model
{

    public function __construct()
    {

    }

    public function index()
    {

    }

    public function css()
    {


        $css = TemplateManager::getInstance()->getAssets($_GET['page'], 'css');
        if ($css) {
            if (isset($css[$_GET['hash']])) {


               if(!file_exists(URL_ROOT . $css[$_GET['hash']]['path'])){
                   echo 'file doesn\'t exits';
                   die();
                }

                $last_modified_time = filemtime(URL_ROOT . $css[$_GET['hash']]['path']);
                $etag = md5_file(URL_ROOT . $css[$_GET['hash']]['path']);

                header("Last-Modified: " . gmdate("D, d M Y H:i:s", $last_modified_time) . " GMT");
                header("Etag: $etag");

                if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) and @strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $last_modified_time ||
                    @trim($_SERVER['HTTP_IF_NONE_MATCH']) == $etag) {

                    header("HTTP/1.1 304 Not Modified");
                    header('Content-Encoding: gzip');
                    header('Content-Type: text/css; charset: UTF-8');
                    //header('Content-Transfer-Encoding: binary');
                    exit;

                } else {

                    header('Content-Description: File Transfer');
                    header('Content-Type: text/css; charset: UTF-8');
                    header('Content-Transfer-Encoding: binary');
                    header('Cache-control: must-revalidate');
                    header('Content-Length: ' . filesize(URL_ROOT . $css[$_GET['hash']]['path']));
                    readfile(URL_ROOT . $css[$_GET['hash']]['path']);
                }

            } else {

                die();
            }
        }

    }

    public function js()
    {

        $js = TemplateManager::getInstance()->getAssets($_GET['page'], 'js');
        if ($js) {

            if (isset($js[$_GET['hash']])) {


                if(!file_exists(URL_ROOT . $js[$_GET['hash']]['path'])){
                    echo 'file doesn\'t exits';
                    die();
                }

                $last_modified_time = filemtime(URL_ROOT . $js[$_GET['hash']]['path']);
                $etag = md5_file(URL_ROOT . $js[$_GET['hash']]['path']);

                header("Last-Modified: " . gmdate("D, d M Y H:i:s", $last_modified_time) . " GMT");
                header("Etag: $etag");

                if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) and @strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $last_modified_time ||
                    @trim($_SERVER['HTTP_IF_NONE_MATCH']) == $etag) {

                    header("HTTP/1.1 304 Not Modified");
                    header('Content-Encoding: gzip');
                    header('Content-Type: text/javascript; charset: UTF-8');
                    header('Content-Transfer-Encoding: binary');

                    exit;

                } else {
                    header('Content-Description: File Transfer');
                    header('Content-Type: text/javascript; charset: UTF-8');
                    header('Content-Transfer-Encoding: binary');
                    header('Cache-control: must-revalidate');
                    header('Content-Length: ' . filesize(URL_ROOT . $js[$_GET['hash']]['path']));
                    readfile(URL_ROOT . $js[$_GET['hash']]['path']);
                }


            }else{
                die();
            }

        }

    }

    public function image(){

       // if (isset($_SERVER['HTTP_REFERER'])) {

            if (isset($_GET['hash'])) {


                $image = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_image WHERE Url=?s', $_GET['hash']);

                if ($image) {

                    /**
                     * /public/Image/getImage.php?ref=f8baa7bce9b90d1128dd19a6c1f1ee9d
                     *
                     * image/gif
                     * image/x-icon
                     * image/jpeg
                     * image/png
                     * image/tiff
                     */

                    $image_type = NULL;

                    switch (exif_imagetype(URL_ROOT.$image[0]['Path'])){

                        case IMAGETYPE_JPEG:
                            $image_type = 'image/jpeg';
                            break;
                        case IMAGETYPE_PNG:
                            $image_type ='image/png';
                            break;
                        case IMAGETYPE_GIF:
                            $image_type = 'image/gif';
                            break;
                        default:
                            die();
                            break;
                    }


                    /**
                     * Cache
                     */

                    $last_modified_time = filemtime(URL_ROOT.$image[0]['Path']);
                    $etag = md5_file(URL_ROOT.$image[0]['Path']);

                    header("Last-Modified: " . gmdate("D, d M Y H:i:s", $last_modified_time) . " GMT");
                    header("Etag: $etag");

                    if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) and @strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) == $last_modified_time ||
                        @trim($_SERVER['HTTP_IF_NONE_MATCH']) == $etag) {

                        header("HTTP/1.1 304 Not Modified");
                        header('Content-Encoding: gzip');
                        header('Content-Type: '.$image_type.'');
                        header('Content-Transfer-Encoding: binary');

                       exit();

                    }else{

                        ob_get_clean();
                        header('Content-Description: File Transfer');
                        header('Content-Type: '.$image_type);
                        header('Content-Transfer-Encoding: binary');
                        header('Cache-control: must-revalidate');
                        header('Content-Length: '.filesize(URL_ROOT.$image[0]['Path']));
                        readfile(URL_ROOT.$image[0]['Path']);

                        flush();
                    }



                } else {

                    header('Location:/');
                }

            } else {

                header('Location:/');
            }

    }

    public function video(){


        /**
         * /public/Video/getVideo.php?ref=8ec8c1f9cc6332c5043337bd2efc8e0a
         */
        if (isset($_SERVER['HTTP_REFERER'])) {

            if (isset($_GET['hash'])) {


                $video = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_video WHERE Url=?s', $_GET['hash']);

                if($video){
                    require_once URL_ROOT.'/core/Libs/Basic/General/VideoStream.php';

                    $stream = new VideoStream(URL_ROOT.$video[0]['Path']);
                    $stream->start();

                }else{

                    header('Location:/');
                }

            }else{

                header('Location:/');
            }

        }else{

            echo 'IDI NAXYI';

            //header('Location:/');
        }
    }
}
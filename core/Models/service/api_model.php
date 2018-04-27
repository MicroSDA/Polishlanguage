<?php
/**
 * Created by PhpStorm.
 * User: bansc
 * Date: 1/27/2018
 * Time: 6:53 PM
 */

/**
 * Class api_model
 *
 * There is standart model for api request and response
 */

class api_model
{

    public function __construct()
    {

    }


    public function index()
    {

        /**
         * Index method will take your income link and with relation to query will send you response
         *
         * Link example:
         * www.your-domain.com/secure/api/?token=1c0b76fce779f78f51be339c49445c498a5da52ed126447d359e70c05721a8aa&key=23ac22cddf4aa098df0c23ac2f501e70&query=test
         * Token - > Is First part for validate yor request
         * Key - > Is Second part for validate yor request
         * Query - > Is your type of  request
         * Parameters - > Should be after query, it' doesn't matter what it will be, it's related to your query request and will be reviewed in your specific response thru method
         */
        /*$out = json_encode($brand);
        // header('Content-Type: application/json');

        var_dump($out);*/

        if (isset($_GET['token']) && isset($_GET['key']) && isset($_GET['query'])) {

            $api = DataBase::getInstance()->getDB()->getAll("SELECT * FROM c_api_key WHERE Token=?s", $_GET['token']);

            if ($api) {

                if ($_GET['key'] == $api[0]['APIKey']) {

                    switch ($_GET['query']) {

                        /**
                         * ////////////////////////////////////////////////////////////////////////////////////
                         * Call needed function
                         */
                        case 'test':
                            $this->test();
                            break;
                        default:
                            echo 'error';
                            break;

                    }

                } else {

                    echo 'error';
                }

            } else {

                echo 'Token Error';
            }


        } else {

            echo 'error';
        }


    }


    public function test()
    {

        if(isset($_SERVER['HTTP_REFERER'])){

            echo 'Refer: '.$_SERVER['HTTP_REFERER'].'<br>';
        }

        echo 'Ip: '.$_SERVER['REMOTE_ADDR'];
    }
}
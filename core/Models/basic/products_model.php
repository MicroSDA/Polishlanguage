<?php
/**
 * Created by PhpStorm.
 * User: bansc
 * Date: 1/20/2018
 * Time: 6:45 PM
 */

class products_model extends Model
{

    /**
     * index_model constructor.
     */
    public function __construct()
    {


        parent::__construct();

    }

    /**
     *
     */
    public function index()
    {

        /** DataBase::getInstance();
         * DataManager::getInstance();*/

        DataManager::getInstance()->addData('Products', DataBase::getInstance()->getDB()->getall('SELECT * FROM c_products'));

        $this->render();

    }

    public function product()
    {


        $product_id = UrlsDispatcher::getInstance()->getValue('NUMBER');

        if($product_id == 'NOT FOUND'){

            header('Location:/error');
            die();
        }


        $product_arry = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_products WHERE id=?i', $product_id);
        if (!$product_arry) {


            header('Location:/products');
        } else {

            DataManager::getInstance()->addData('Product', $product_arry[0]);
            $this->render();
        }
    }

    public function product_by_part(){



        $product_part = UrlsDispatcher::getInstance()->getValue('STR');

        if($product_part == 'NOT FOUND'){

            header('Location:/error');
            die();
        }

        $product_arry = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_products WHERE Url=?s', $product_part);


        if (!$product_arry) {
            header('Location:/products');

        } else {

        }

        session_start();

        if(isset($_POST['submit'])){

            if (!empty($_POST['first_name']) &&
                !empty($_POST['last_name']) &&
                !empty($_POST['email']) &&
                !empty($_POST['phone'])){


                $first_name = $_POST['first_name'];
                $last_name = $_POST['last_name'];
                $email = $_POST['email'];
                $phone = $_POST['phone'];
                $message = $_POST['message'];
                $part_number = $product_arry[0]['PartNumber'];
                DataBase::getInstance()->getDB()->query("INSERT INTO c_order (FirstName, LastName, Email, Phone, Message, PartNumber) VALUES(?s, ?s, ?s, ?s, ?s, ?s)",$first_name, $last_name, $email, $phone, $message,  $part_number);



                $_SESSION['order_info'] = 'TRUE';
                unset($_POST['submit']);
                unset($_POST['first_name']);
                unset($_POST['last_name']);
                unset($_POST['email']);
                unset($_POST['phone']);
                unset($_POST['message']);


            }else{
                $_SESSION['order_info'] = 'ERROR';
            }



        }else{
            unset($_SESSION['order_info']);
        }


        DataManager::getInstance()->addData('Product', $product_arry[0]);
        $this->render();

    }
}
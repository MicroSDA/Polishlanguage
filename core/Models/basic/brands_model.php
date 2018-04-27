<?php
/**
 * Created by PhpStorm.
 * User: bansc
 * Date: 1/21/2018
 * Time: 4:58 PM
 */

class brands_model extends Model
{

    public function __construct()
    {


        parent::__construct();

    }

    public function index()
    {

        /**
         * DataBase::getInstance();
         * DataManager::getInstance();
         */

        DataManager::getInstance()->addData('Brands', DataBase::getInstance()->getDB()->getall('SELECT * FROM c_brands'));
        $this->render();



    }


    public function brand(){

        $brand = UrlsDispatcher::getInstance()->getValue('STR');

        if($brand == 'NOT FOUND'){

            header('Location:/error');
            die();

        }

        $brand_arry = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_brands WHERE Url=?s', $brand);

        if (!$brand_arry) {

            header('Location:/brands');

        } else {

            $products_array = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_products WHERE Brand=?s', $brand_arry[0]['Name']);

            if(!$products_array){

                header('Location:/brands');

            }else{
                DataManager::getInstance()->addData('Brand', $brand_arry[0]);
                DataManager::getInstance()->addData('Products', $products_array);
                $this->render();
            }

        }
    }
}
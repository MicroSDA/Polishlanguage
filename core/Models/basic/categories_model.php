<?php
/**
 * Created by PhpStorm.
 * User: bansc
 * Date: 1/21/2018
 * Time: 1:00 PM
 */

class categories_model extends Model
{
    /**
     * categories_model.
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

        /**
         * DataBase::getInstance();
         * DataManager::getInstance();
         */

        DataManager::getInstance()->addData('Categories', DataBase::getInstance()->getDB()->getall('SELECT * FROM c_categories'));
        $this->render();

    }

    public function category(){


        $category = UrlsDispatcher::getInstance()->getValue('STR');

        if($category == 'NOT FOUND'){

            header('Location:/error');
            die();

        }

        $category_arry = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_categories WHERE Url=?s', $category);

        if (!$category_arry) {

            header('Location:/categories');
        } else {


            switch ($category_arry[0]['Type']){

                case 'Main':
                    $products_array = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_products WHERE MainCategory=?s', $category_arry[0]['Name']);
                    DataManager::getInstance()->addData('Category', $category_arry[0]);
                    DataManager::getInstance()->addData('Products', $products_array);
                    break;
                case 'Sub':
                    $products_array = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_products WHERE SubCategory=?s', $category_arry[0]['Name']);
                    DataManager::getInstance()->addData('Category', $category_arry[0]);
                    DataManager::getInstance()->addData('Products', $products_array);
                    break;
                case 'Section':
                    $products_array = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_products WHERE SectionCategory=?s', $category_arry[0]['Name']);
                    DataManager::getInstance()->addData('Category', $category_arry[0]);
                    DataManager::getInstance()->addData('Products', $products_array);
                    break;
            }

            $this->render();
        }


    }

}
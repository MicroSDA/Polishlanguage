<?php
/**
 * Created by PhpStorm.
 * User: bansc
 * Date: 2/10/2018
 * Time: 8:48 PM
 */

class article_model extends Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index(){

    }

    public function all_articles(){

      $articles = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_article ORDER BY id DESC');

      DataManager::getInstance()->addData('Articles',$articles);
        $this->render();
    }

    public function article(){

        $article = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_article WHERE Url=?s', UrlsDispatcher::getInstance()->getValue('STR'));
        if($article){
            DataManager::getInstance()->addData('Article',$article[0]);
        }else{
            header('Location:/articles');
        }

        $this->render();
    }
}
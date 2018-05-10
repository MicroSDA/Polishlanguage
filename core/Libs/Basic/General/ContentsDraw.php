<?php
/**
 * Created by PhpStorm.
 * User: Ro
 * Date: 5/10/2018
 * Time: 20:37
 */

class ContentsDraw
{

    private $level;

    public function __construct($level)
    {
        $this->level = $level;
    }


    public function draw(){

        $lessons_A1 = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons_pdf WHERE Level=?s','A1');
        $lessons_A2 = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons_pdf WHERE Level=?s','A2');
        $lessons_B1 = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons_pdf WHERE Level=?s','B1');
        $lessons_B2 = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons_pdf WHERE Level=?s','B2');
        $lessons_C1 = DataBase::getInstance()->getDB()->getAll('SELECT * FROM c_lessons_pdf WHERE Level=?s','C1');


        echo '<div class="tabs">
                    <ul class="nav nav-tabs">';
        if($lessons_A1){
            echo '<li role="presentation"><a href="#A1" class="active" data-toggle="tab">Курс A1</a></li>';
        }

        if($lessons_A2){
            echo '<li role="presentation"><a href="#A2" data-toggle="tab">Курс A2</a></li>';
        }

        if($lessons_B1){
            echo '<li role="presentation"><a href="#B1" data-toggle="tab">Курс B1</a></li>';
        }

        if($lessons_B2){
            echo '<li role="presentation"><a href="#B2" data-toggle="tab">Курс B2</a></li>';
        }

        if($lessons_C1){
            echo '<li role="presentation"><a href="#C1" data-toggle="tab">Курс C1</a></li>';
        }

        echo '</ul>';
        echo '</div>';


        if($lessons_A1){
            echo '<div class="tab-pane fade in active" id="A1">';
            foreach ($lessons_A1 as $data){
                echo '<br>';
                echo '<div class="row">';
                echo '<div class="col-sm-6 col-md-4">';
                echo '<div class="thumbnail">';
                echo '<img src="https://media.giphy.com/media/TvLuZ00OIADoQ/giphy.gif" alt="">';
                echo '<div class="caption">';
                echo '<h3>'. $data['Name'].'</h3>';
                echo '<p>'.$data['Description'].'</p>';
                echo '<hr>';
                echo '<p><a href="/lessons-donwload?hash='.$data['Url'].'" class="btn btn-primary" role="button">Скачать</a> <a href="/lessons-donwload?hash='.$data['Url'].'" class="btn btn-default" role="button">Открыть</a></p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';
            }
            echo '</div>';
        }

        if($lessons_A2){

            echo '<div class="tab-pane fade" id="A2">';
            foreach ($lessons_A2 as $data){

                echo '<br>';
                echo '<div class="row">';
                echo '<div class="col-sm-6 col-md-4">';
                echo '<div class="thumbnail">';
                echo '<img src="https://media.giphy.com/media/TvLuZ00OIADoQ/giphy.gif" alt="">';
                echo '<div class="caption">';
                echo '<h3>'. $data['Name'].'</h3>';
                echo '<p>'.$data['Description'].'</p>';
                echo '<hr>';
                echo '<p><a href="/lessons-donwload?hash='.$data['Url'].'" class="btn btn-primary" role="button">Скачать</a> <a href="/lessons-donwload?hash='.$data['Url'].'" class="btn btn-default" role="button">Открыть</a></p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';

            }
            echo '</div>';
        }

        if($lessons_B1){

            echo '<div class="tab-pane fade" id="B1">';
            foreach ($lessons_B1 as $data){

                echo '<br>';
                echo '<div class="row">';
                echo '<div class="col-sm-6 col-md-4">';
                echo '<div class="thumbnail">';
                echo '<img src="https://media.giphy.com/media/TvLuZ00OIADoQ/giphy.gif" alt="">';
                echo '<div class="caption">';
                echo '<h3>'. $data['Name'].'</h3>';
                echo '<p>'.$data['Description'].'</p>';
                echo '<hr>';
                echo '<p><a href="/lessons-donwload?hash='.$data['Url'].'" class="btn btn-primary" role="button">Скачать</a> <a href="/lessons-donwload?hash='.$data['Url'].'" class="btn btn-default" role="button">Открыть</a></p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';

            }
            echo '</div>';
        }

        if($lessons_B2){

            echo '<div class="tab-pane fade" id="B1">';
            foreach ($lessons_B2 as $data){

                echo '<br>';
                echo '<div class="row">';
                echo '<div class="col-sm-6 col-md-4">';
                echo '<div class="thumbnail">';
                echo '<img src="https://media.giphy.com/media/TvLuZ00OIADoQ/giphy.gif" alt="">';
                echo '<div class="caption">';
                echo '<h3>'. $data['Name'].'</h3>';
                echo '<p>'.$data['Description'].'</p>';
                echo '<hr>';
                echo '<p><a href="/lessons-donwload?hash='.$data['Url'].'" class="btn btn-primary" role="button">Скачать</a> <a href="/lessons-donwload?hash='.$data['Url'].'" class="btn btn-default" role="button">Открыть</a></p>';
                echo '</div>';
                echo '</div>';
                echo '</div>';

            }
            echo '</div>';
        }

die;
        echo '<div class="tabs">
                    <ul class="nav nav-tabs">';
        foreach ($lessons as $key => $data){
            echo '<li role="presentation"><a href="#'.$key.'" data-toggle="tab">Курс '.$key.'</a></li>';
        }
        echo '</ul>';
        echo '<div>';
        echo '<div class="tab-content">';
        foreach ($lessons as $key => $data){
            echo '<div class="tab-pane fade in active" id="'.$key.'">';
            echo '<br>';
            echo '<div class="row">';
            echo '<div class="col-sm-6 col-md-4">';
            echo '<div class="thumbnail">';
            echo '<img src="https://media.giphy.com/media/TvLuZ00OIADoQ/giphy.gif" alt="">';
            echo '<div class="caption">';
            echo '<h3>'. $data['Name'].'</h3>';
            echo '<p>'.$data['Description'].'</p>';
            echo '<hr>';
            echo '<p><a href="/lessons-donwload?hash='.$data['Url'].'" class="btn btn-primary" role="button">Скачать</a> <a href="/lessons-donwload?hash='.$data['Url'].'" class="btn btn-default" role="button">Открыть</a></p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';

        }

    }
}
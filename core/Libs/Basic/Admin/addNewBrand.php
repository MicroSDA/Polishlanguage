<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/core/Libs/DataBase/DataBase.php';

if (!empty($_POST['brand_name']) &&
    !empty($_POST['brand_url']) &&
    !empty($_POST['brand_description'])) {

    $if_exist = DataBase::getInstance()->getDB()->getAll("SELECT * FROM c_brands WHERE Name=?s", $_POST['brand_name']);

    if (!$if_exist) {
        $result = DataBase::getInstance()->getDB()->query("INSERT INTO c_brands (Name, Url, Description, Image) VALUES (?s, ?s, ?s, ?s)",
            $_POST['brand_name'], $_POST['brand_url'], $_POST['brand_description'], 'image');

        if ($result) {

            echo 'Added';

        } else {

            echo '<span class="btn btn-warning">Internal error, wasn\'t added</span>';
        }

    } else {

        echo '<span class="btn btn-warning">This Brand is already exist</span>';
    }


} else {
    echo '<span class="btn btn-warning">All Fields should be filled</span>';
}
<?php
/**
 * Created by PhpStorm.
 * User: bansc
 * Date: 2/17/2018
 * Time: 7:37 PM
 */


/**
 * Table Creation
 */

require_once $_SERVER['DOCUMENT_ROOT'].'/core/Libs/DataBase/DataBase.php';

$query['employeeTable'] = '
CREATE TABLE `c_employee` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`FirstName` VARCHAR(100) NULL DEFAULT NULL,
	`LastName` VARCHAR(100) NULL DEFAULT NULL,
	`Email` VARCHAR(150) NULL DEFAULT NULL,
	`Password` TEXT NULL,
	`Hash` TEXT NULL,
	`LastLogin` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`Role` ENUM(\'developer\',\'admin\',\'manager\',\'moderator\',\'employee\') NULL DEFAULT \'employee\',
	PRIMARY KEY (`id`),
	UNIQUE INDEX `Email` (`Email`)
)
COLLATE=\'utf8_general_ci\'';
$query['apiKeyTable'] = '
CREATE TABLE IF NOT EXISTS `c_api_key` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`Token` VARCHAR(250) NOT NULL,
	`APIKey` VARCHAR(250) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `Token` (`Token`),
	UNIQUE INDEX `APIKey` (`APIKey`)
) COLLATE=\'utf8_general_ci\'';
$query['articleTable'] = '
CREATE TABLE IF NOT EXISTS `c_article` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`Url` VARCHAR(250) NULL DEFAULT NULL,
	`Title` TEXT NULL,
	`Description` TEXT NULL,
	`Body` TEXT NULL,
	`Time` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
	`Writer` VARCHAR(50) NULL DEFAULT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `Url` (`Url`)
) COLLATE=\'utf8_general_ci\'';
$query['brandsTable'] = '
CREATE TABLE IF NOT EXISTS `c_brands` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`Name` TEXT NOT NULL,
	`Description` TEXT NOT NULL,
	`Url` VARCHAR(250) NOT NULL,
	`Image` TEXT NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `Url` (`Url`)
) COLLATE=\'utf8_general_ci\'';
$query['categoriesTable'] ='
CREATE TABLE IF NOT EXISTS `c_categories` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`Type` VARCHAR(50) NULL DEFAULT \'Main\',
	`Name` TEXT NULL,
	`Parrent` TEXT NULL,
	`Child` TEXT NULL,
	`Description` TEXT NULL,
	`Url` VARCHAR(250) NULL DEFAULT NULL,
	`Image` TEXT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `Url` (`Url`)
) COLLATE=\'utf8_general_ci\'';
$query['imageTable'] = '
CREATE TABLE IF NOT EXISTS `c_image` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`Name` VARCHAR(100) NOT NULL DEFAULT \'0\',
	`Path` VARCHAR(200) NOT NULL DEFAULT \'0\',
	`Url` VARCHAR(250) NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `Url` (`Url`)
) COLLATE=\'utf8_general_ci\'';
$query['logsTable']='
CREATE TABLE IF NOT EXISTS `c_logs` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`Time` VARCHAR(60) NOT NULL,
	`File` TEXT NOT NULL,
	`Line` VARCHAR(15) NOT NULL,
	`Message` TEXT NOT NULL,
	`Ip` TEXT NOT NULL,
	PRIMARY KEY (`id`),
	UNIQUE INDEX `Time` (`Time`)
) COLLATE=\'utf8_general_ci\'';
$query['orderTable'] = '
CREATE TABLE IF NOT EXISTS `c_order` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`FirstName` VARCHAR(50) NOT NULL DEFAULT \'0\',
	`LastName` VARCHAR(50) NOT NULL DEFAULT \'0\',
	`Email` VARCHAR(60) NOT NULL DEFAULT \'0\',
	`Phone` VARCHAR(60) NOT NULL DEFAULT \'0\',
	`Message` TEXT NOT NULL,
	`PartNumber` TEXT NOT NULL,
	`Data` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	PRIMARY KEY (`id`)
) COLLATE=\'utf8_general_ci\'';
$query['productsTable'] ='
CREATE TABLE IF NOT EXISTS `c_products` (
	`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT,
	`ProdID` INT(11) UNSIGNED NOT NULL,
	`PartNumber` TEXT NOT NULL,
	`ProdType` INT(11) NOT NULL DEFAULT \'1\',
	`Title` TEXT NOT NULL,
	`Anchor` TEXT NOT NULL,
	`Description` TEXT NOT NULL,
	`Specification` TEXT NOT NULL,
	`Brand` TEXT NOT NULL,
	`MainCategory` TEXT NOT NULL,
	`SubCategory` TEXT NOT NULL,
	`SectionCategory` TEXT NOT NULL,
	`Url` VARCHAR(250) NOT NULL,
	`Keywords` TEXT NOT NULL,
	`Image` TEXT NOT NULL,
	`Price` DOUBLE UNSIGNED NULL DEFAULT NULL,
	`Currency` VARCHAR(50) NOT NULL DEFAULT \'0\',
	PRIMARY KEY (`id`),
	UNIQUE INDEX `Url` (`Url`),
	INDEX `ProdID` (`ProdID`)
) COLLATE=\'utf8_general_ci\'';
$query['sitemapTable'] = '
CREATE TABLE IF NOT EXISTS `c_sitemap` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`Url` VARCHAR(250) NOT NULL,
	`LastModified` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
	`UpdatetFrequency` VARCHAR(20) NOT NULL DEFAULT \'Daily\',
	`Priority` DOUBLE NOT NULL DEFAULT \'0.5\',
	PRIMARY KEY (`id`),
	UNIQUE INDEX `Url` (`Url`)
) COLLATE=\'utf8_general_ci\'';
$query['urlsTable'] = '
CREATE TABLE IF NOT EXISTS `c_urls` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`Pattern` VARCHAR(250) NOT NULL,
	`Name` VARCHAR(50) NOT NULL,
	`Type` ENUM(\'basic\',\'service\') NOT NULL DEFAULT \'basic\',
	`View` VARCHAR(100) NULL DEFAULT NULL,
	`Cache` ENUM(\'yes\',\'no\') NOT NULL DEFAULT \'no\',
	`Model` VARCHAR(60) NOT NULL,
	`Method` VARCHAR(60) NOT NULL,
	`Status` ENUM(\'active\',\'not-active\') NOT NULL DEFAULT \'active\',
	PRIMARY KEY (`id`),
	UNIQUE INDEX `Pattern` (`Pattern`)
) COLLATE=\'utf8_general_ci\'';
$query['videoTable'] = '
CREATE TABLE IF NOT EXISTS `c_video` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`Name` VARCHAR(100) NOT NULL DEFAULT \'0\',
	`Path` VARCHAR(200) NOT NULL DEFAULT \'0\',
	`Url` VARCHAR(250) NOT NULL DEFAULT \'0\',
	PRIMARY KEY (`id`),
	UNIQUE INDEX `Url` (`Url`)
) COLLATE=\'utf8_general_ci\'';
$query['visitorsTable'] = '
CREATE TABLE IF NOT EXISTS `c_visitor` (
	`id` INT(11) NOT NULL AUTO_INCREMENT,
	`Time` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	`Hour` VARCHAR(50) NOT NULL,
	`Day` VARCHAR(50) NOT NULL,
	`Week` VARCHAR(50) NOT NULL,
	`WeekN` VARCHAR(50) NOT NULL,
	`Month` VARCHAR(50) NOT NULL,
	`Year` VARCHAR(50) NOT NULL,
	`Browser` VARCHAR(200) NOT NULL,
	`Name` VARCHAR(100) NOT NULL,
	`Page` VARCHAR(50) NOT NULL,
	`Session-Time` VARCHAR(50) NULL DEFAULT NULL,
	`Ip` VARCHAR(30) NOT NULL,
	`User-id` VARCHAR(50) NOT NULL DEFAULT \'guest\',
	PRIMARY KEY (`id`)
) COLLATE=\'utf8_general_ci\'';
/**
 * End of Table Creation
 */
try{
    foreach ($query as $value){
        DataBase::getInstance()->getDB()->query($value);
    }

    $href = md5(getenv("REMOTE_ADDR") . "key" . date("i")). md5(getenv("REMOTE_ADDR") . "key-2" . date("i")). md5(getenv("REMOTE_ADDR") . "key-3" . date("i"));
    DataBase::getInstance()->getDB()->query('INSERT INTO c_employee (Login, Password, Href) VALUES (?s,?s,?s)','admin@admin','admin',$href);

    DataBase::getInstance()->getDB()->mysqlQuery('INSERT INTO `c_urls` (`id`, `Pattern`, `Name`, `Type`, `View`, `Cache`, `Model`, `Method`, `Status`) VALUES 
    (1, \'(^)\', \'Error-404\', \'basic\', \'error-404\', \'no\', \'error_404_model\', \'index\', \'active\'),
	(2, \'(^\\/index\\/{0,1}$)\', \'General\', \'basic\', \'index\', \'yes\', \'index_model\', \'index\', \'active\'),
	(3, \'(^\\/secure\\/api\\/\\?(.+)$)\', \'Api\', \'service\', \'\', \'no\', \'api_model\', \'index\', \'active\'),
	(4, \'(^\\/ajax-admin\\/edit-url\\/{0,1}\\??)\', \'Ajax-General-Admin\', \'service\', \'index\', \'no\', \'ajax_model\', \'admin_edit_url\', \'active\'),
	(5, \'(^\\/ajax-admin\\/add-new-brand\\/{0,1}$)\', \'Ajax-General-Admin\', \'service\', \'index\', \'no\', \'ajax_model\', \'admin_add_newbrand\', \'active\'),
	(6, \'(^\\/ajax-admin\\/edit-url-validate\\/{0,1}\\??)\', \'Ajax-General-Admin\', \'service\', \'index\', \'no\', \'ajax_model\', \'admin_validate_edit_url\', \'active\'),
	(7, \'(^\\/ajax-admin\\/delete-url-validate\\/{0,1}\\??)\', \'Ajax-General-Admin\', \'service\', \'index\', \'no\', \'ajax_model\', \'admin_validate_delete_url\', \'active\'),
	(8, \'(^\\/ajax-admin\\/delete-url\\/{0,1}$)\', \'Ajax-General-Admin\', \'service\', \'index\', \'no\', \'ajax_model\', \'admin_delete_url\', \'active\'),
	(9, \'(^\\/ajax-admin\\/add-url\\/{0,1}$)\', \'Ajax-General-Admin\', \'service\', \'index\', \'no\', \'ajax_model\', \'admin_add_url\', \'active\'),
	(10, \'(^\\/ajax-admin\\/add-article\\/{0,1}$)\', \'Ajax-General-Admin\', \'service\', \'index\', \'no\', \'ajax_model\', \'add_article\', \'active\'),
	(11, \'(^\\/ajax-admin\\/edit-article-validate\\/{0,1}$)\', \'Ajax-General-Admin\', \'service\', \'index\', \'no\', \'ajax_model\', \'admin_validate_edit_article\', \'active\'),
	(12, \'(^\\/ajax-admin\\/edit-article\\/{0,1}$)\', \'Ajax-General-Admin\', \'service\', \'index\', \'no\', \'ajax_model\', \'admin_edit_article\', \'active\'),
	(13, \'(^\\/assets\\/image\\/{0,1}\\?hash\\=(.+)$)\', \'Image\', \'service\', \'index\', \'no\', \'assets_model\', \'image\', \'active\'),
	(14, \'(^\\/assets\\/video\\/{0,1}\\?hash\\=(.+)$)\', \'Video\', \'service\', \'index\', \'no\', \'assets_model\', \'video\', \'active\'),
	(15, \'(^\\/assets\\/js\\/{0,1}\\?page\\=(.+)hash\\=(.+))\', \'Js\', \'service\', \'index\', \'no\', \'assets_model\', \'js\', \'active\'),
	(16, \'(^\\/assets\\/css\\/{0,1}\\?page\\=(.+)hash\\=(.+))\', \'Css\', \'service\', \'index\', \'no\', \'assets_model\', \'css\', \'active\'),
	(17, \'(^\\/admin\\/secure\\/dashboard\\/[a-zA-Z0-9_-]+\\/{0,1}.?$)\', \'Admin\', \'service\', \'admin/dashboard\', \'no\', \'admin_model\', \'index\', \'active\'),
	(18, \'(^\\/admin\\/secure\\/brands\\/{0,1}$)\', \'Admin\', \'service\', \'admin/brand\', \'no\', \'admin_model\', \'brand\', \'active\'),
	(19, \'(^\\/admin\\/secure\\/category\\/{0,1}$)\', \'Admin\', \'service\', \'admin/category\', \'no\', \'admin_model\', \'category\', \'active\'),
	(20, \'(^\\/admin\\/secure\\/products\\/{0,1}$)\', \'Admin\', \'service\', \'admin/products\', \'no\', \'admin_model\', \'products\', \'active\'),
	(21, \'(^\\/admin\\/secure\\/articles\\/{0,1}$)\', \'Admin\', \'service\', \'admin/articles\', \'no\', \'admin_model\', \'articles\', \'active\'),
	(22, \'(^\\/admin\\/secure\\/settings\\/{0,1}\\??)\', \'Admin\', \'service\', \'admin/settings\', \'no\', \'admin_model\', \'settings\', \'active\'),
	(23, \'(^\\/admin\\/secure\\/login\\/[a-zA-Z0-9_-]+\\/{0,1}.?$)\', \'Admin Login\', \'service\', \'admin/login\', \'no\', \'admin_model\', \'login\', \'active\');');


    echo '<h1>Installation was successful</h1>';
    echo '<h2>Your Admin Link! Don\'t forget it</h2>';
    echo '<h3><a href="'.$_SERVER['HTTP_HOST'].'/admin/secure/dashboard/'.$href.'">'.$_SERVER['HTTP_HOST'].'/admin/secure/dashboard/'.$href.'</a></h3>';
}catch (Exception $exception){
    echo '<h1>Something was wrong!</h1><br>';
    echo $exception->getMessage();
}


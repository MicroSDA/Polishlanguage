<?php



/**
 * Booting ours classes, modules, models, etc
 */


/**
 * include global core modules
 */

require_once URL_ROOT.'/core/Libs/Basic/General/RestrictedPerson.php';
require_once URL_ROOT.'/core/Libs/Config/Config.php';
require_once URL_ROOT.'/core/Libs/Config/ErrorLog.php';
require_once URL_ROOT.'/core/Libs/Config/TemplateManager.php';

require_once URL_ROOT.'/core/Libs/DataBase/DataBase.php';
require_once URL_ROOT.'/core/MVC/DataManager.php';
require_once URL_ROOT.'/core/Router/Router.php';
require_once URL_ROOT.'/core/Router/UrlsManager.php';
require_once URL_ROOT.'/core/Router/UrlsDispatcher.php';
require_once URL_ROOT.'/core/MVC/View.php';
require_once URL_ROOT.'/core/MVC/Controller.php';
require_once URL_ROOT.'/core/MVC/Model.php';
require_once URL_ROOT.'/core/Libs/Basic/General/VideoStream.php';
require_once URL_ROOT.'/core/Libs/Basic/General/CacheGenerator.php';
require_once URL_ROOT.'/core/Libs/Basic/General/Students.php';
require_once URL_ROOT.'/core/Libs/Basic/General/Teacher.php';



/**
 * Error module
 */

ErrorLog::getInstance()->setLogFile(URL_ROOT.'/logs/LOG.xml');
/** Enable all errors catch  */
error_reporting(E_ALL);
set_error_handler(array(ErrorLog::getInstance(),'addIntoLogDB'));       /** Function for catch  */


/**
 * -------------------
 */
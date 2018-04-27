<?php


/**
 * Declaring Constants and Global vars
 */


/**
 * ------------------------------------------
 */
       /** Template section */

       require_once URL_ROOT.'/core/Libs/Config/TemplateManager.php';
       //$template = TemplateManager::getInstance();

       //define('TEMPLATE_NAME', $template->getTemplate()['name']);               /** Template Name     */
      // define('TEMPLATE_PATH', '/views/public/'.$template->getTemplate()['path']);               /** Template Path     */
      // define('TEMPLATE_STATUS', $template->getTemplate()['status']);           /** Template Status   */

        /** End of Template section */
/**
 * Section for standard server configuration
 *
 */
     /** Information arry about which plugins are included */

     global $PLUGINS_INFORMATION;
            $PLUGINS_INFORMATION = [
                'name'=>'name',
                'path'=>'path',
                'version'=>'version'
            ];

            /** Urls config file path and name*/

     define('URLS_CONFIG_FILE_PATH',URL_ROOT.'/config/Urls-Routing-List.xml');

/**
 * -----------------------------------------
 */


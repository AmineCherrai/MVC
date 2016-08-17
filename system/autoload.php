<?php

/**
 * Cliprz framework
 *
 * Color your project, An open source application development framework for PHP 5.3.0 or newer
 *
 * loading automatically framework system and configurations files
 *
 * LICENSE: This program is released as free software under the Affero GPL license. You can redistribute it and/or
 * modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 * at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 * written permission from the original author(s)
 *
 * @package    Cliprz
 * @author     Yousef Ismaeil <cliprz@gmail.com>
 * @copyright  Copyright (c) 2012 - 2013, Cliprz Developers team
 * @license    http://www.cliprz.org/licenses/agpl
 * @link       http://www.cliprz.org
 * @since      Version 2.0.0
 */

/**
 * Framework and project Charset
 */
define('CHARSET','UTF-8',TRUE);

/**
 * Development environment, Change value to FALSE if you in real website
 */
define('DEVELOPMENT_ENVIRONMENT',TRUE,TRUE);

/**
 * Method to get system path
 */
define('SYSTEM_PATH',BASE_PATH.'system'.DS,TRUE);

/**
 * Method to get system path
 */
define('APPLICATION_PATH',BASE_PATH.'application'.DS,TRUE);

/**
 * Method to get application/project path
 */
define('PROJECT_PATH',APPLICATION_PATH.'project'.DS,TRUE);

/**
 * Method to get temporary path
 */
define('TEMPORARY_PATH',BASE_PATH.'temporary'.DS,TRUE);

/**
 * Method to get cache path
 */
define('CACHE_PATH',APPLICATION_PATH.'cache'.DS,TRUE);

/**
 * Method to get includes folder
 */
define('INCLUDES_PATH',APPLICATION_PATH.'includes'.DS,TRUE);

/**
 * Method to get assets path
 */
define('ASSETS_PATH',BASE_PATH.'assets'.DS,TRUE);

/**
 * Method to get uploads path
 */
define('UPLOAD_PATH',ASSETS_PATH.'uploads'.DS,TRUE);


/**
 * All configurations array
 */
$_config = array();

/**
 * Method to get application/config/config.php file
 */
define('CONFIGURATION',APPLICATION_PATH.'config'.DS.'config'.EXT,TRUE);

/**
 * Call config file.
 */
if (file_exists(CONFIGURATION)) require_once CONFIGURATION;

else exit('You can not load Cliprz framework because configurations file does not exist');

mb_internal_encoding (CHARSET);

iconv_set_encoding("internal_encoding",CHARSET);

/**
 * Call Core object (cliprz)
 */
require_once SYSTEM_PATH.'cliprz'.DS.'cliprz'.EXT;

/**
 * Cliprz framework Singleton
 */
cliprz::get_instance();

// Set time zone
if (cliprz::system('config')->get('time','zone') !== NULL)
{
    date_default_timezone_set(cliprz::system('config')->get('time','zone'));
}

/**
 * Call constants
 */
require_once SYSTEM_PATH.'constants'.DS.'constants'.EXT;

/**
 * CaLL functions
 */
require_once SYSTEM_PATH.'functions'.DS.'functions'.EXT;

if (file_exists(APPLICATION_PATH.'config'.DS.'wakeup'.EXT))
{
    require_once APPLICATION_PATH.'config'.DS.'wakeup'.EXT;
}

// If CMA (Cliprz my admin) defined don not use router
if (!defined('CMA'))
{
    /**
     * Call router.php
     */
    require_once APPLICATION_PATH.'config'.DS.'router'.EXT;

    /**
     * Hanlding router rules
     */
    cliprz::system('router')->handler();
}

/**
 * End of file autoload.php
 *
 * @created  20/03/2013 05:31 am
 * @updated  06/04/2013 07:41 am
 * @location ./system/autoload.php
 */

?>
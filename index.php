<?php
ob_start();

/**
 * Cliprz framework
 *
 * Color your project, An open source application development framework for PHP 5.3.0 or newer
 *
 * Never modify this file, this file is very important to initialize framework
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

if (version_compare(phpversion(),'5.3.0', "<")) exit('Please upgrade to PHP 5.3.0 or >');

if (!gc_enabled()) { gc_enable(); }

/**
 * We will use this to ensure scripts are not called from outside of the framework
 */
define('IN_CLIPRZ',TRUE);

/**
 * Directory separator
 */
define('DS','/',TRUE);

/**
 * PHP file extension.
 */
define('EXT','.php',TRUE);

/**
 * Returns canonicalized absolute pathname and parent directory's path
 */
define('BASE_PATH',realpath(dirname(__FILE__)).DS,TRUE);

/**
 * Call autoload.
 */
require_once BASE_PATH.'system'.DS.'autoload'.EXT;

if (file_exists(APPLICATION_PATH.'config'.DS.'sleep'.EXT))
{
    require_once APPLICATION_PATH.'config'.DS.'sleep'.EXT;
}

/**
 * End of file index.php
 *
 * @created  20/03/2013 04:32 am
 * @updated  12/04/2013 04:34 am
 * @location ./index.php
 */

ob_end_flush();
?>
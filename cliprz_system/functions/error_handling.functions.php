<?php

/**
 * Copyright :
 *  Cliprz model view controller framework.
 *  Copyright (C) 2012 - 2013 By Yousef Ismaeil.
 *
 * Framework information :
 *  Version 1.0.0 - Incomplete version for real use 7.
 *  Official website http://www.cliprz.org .
 *
 * File information :
 *  File path BASE_PATH/cliprz_system/functions/ .
 *  File name error_handling.functions.php .
 *  Created date 17/10/2012 03:01 AM.
 *  Last modification date 29/12/2012 11:47 AM.
 *
 * Description :
 *  Cliprz error handling Functions.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

/**
 * Check if environment is development and display errors.
 *
 * @return void;
 */
function c_set_reporting()
{
    if (C_DEVELOPMENT_ENVIRONMENT == true)
    {
        error_reporting(E_ALL);
        ini_set('display_errors','On');
        ini_set('log_errors', 'On');
        // ini_set('error_log', 'error_log');
        ini_set('error_log', APP_PATH.'logs'.DS.'error_log.txt');
    }
    else
    {
        // error_reporting (E_ERROR | E_WARNING | E_PARSE);
        error_reporting(E_ALL);
        ini_set('display_errors','Off');
        ini_set('log_errors', 'On');
		ini_set('error_log', APP_PATH.'logs'.DS.'error_log.txt');
    }
}

c_set_reporting();

?>
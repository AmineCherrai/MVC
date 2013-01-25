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
 *  File name magic_quotes.functions.php .
 *  Created date 22/01/2013 06:28 PM.
 *  Last modification date 22/01/2013 06:45 PM.
 *
 * Description :
 *  Magic quotes functions.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

/**
 * Magic quotes
 */
#ini_set("magic_quotes_gpc","Off");
#ini_set("magic_quotes_runtime","Off");
#ini_set("magic_quotes_sybase","Off");

if (!function_exists('c_get_magic_quotes'))
{
    /**
     * Gets the current configuration setting of magic_quotes_gpc.
     * And gets the current active configuration setting of magic_quotes_runtime
     */
    function c_get_magic_quotes ()
    {
        if (c_version_compare("5.4.0"))
        {
            return (bool) ((get_magic_quotes_gpc() || get_magic_quotes_runtime()) ? true : false);
        }
        else
        {
            return false;
        }
    }
}

?>
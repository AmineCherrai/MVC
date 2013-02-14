<?php

/**
 * Copyright :
 *  Cliprz model view controller framework.
 *  Copyright (C) 2012 - 2013 By Yousef Ismaeil.
 *
 * Framework information :
 *  Version 1.1.0 - Stability Beta.
 *  Official website http://www.cliprz.org .
 *
 * File information :
 *  File path BASE_PATH/cliprz_system/functions/ .
 *  File name network.functions.php .
 *  Created date 20/10/2012 01:32 AM.
 *  Last modification date 20/10/2012 01:35 AM.
 *
 * Description :
 *  network Functions.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

if (!function_exists('c_redirecting'))
{
    /**
     * this function use to refresh pages to index.php or other pages.
     *
     * @param (string) $page page name.
     */
    function c_redirecting($page='')
    {
        if ($page == '')
        {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: index.php");
            exit();
        }
        else
        {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$page);
            exit();
        }
    }
}

?>
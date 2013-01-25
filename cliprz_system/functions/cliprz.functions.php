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
 *  File name cliprz.functions.php .
 *  Created date 30/10/2012 06:52 AM.
 *  Last modification date 21/01/2013 12:01 AM.
 *
 * Description :
 *  cliprz functions.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

if (!function_exists("c_trim_path"))
{
    /**
     * Remove slashes from beginning and ending of path.
     *
     * @param (string) $path - Site path.
     */
    function c_trim_path ($path)
    {
        return trim($path,DS);
    }
}

if (!function_exists("c_url"))
{
    /**
     * Get website url.
     *
     * @param (string) $path - path.
     */
    function c_url ($path='')
    {
        global $_config;
        return c_trim_path($_config['output']['url']).DS.$path;
    }
}

if (!function_exists("c_public"))
{
    /**
     * get file from public path.
     *
     * @param (string) $file - file path.
     */
    function c_public ($file)
    {
        return PUBLIC_PATH.$file;
    }
}

if (!function_exists('c_charset'))
{
    /**
     * Get project charset.
     */
    function c_charset ()
    {
        global $_config;
        return $_config['output']['charset'];
    }
}

?>
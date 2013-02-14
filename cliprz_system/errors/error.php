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
 *  File path BASE_PATH/cliprz_system/errors/ .
 *  File name error.php .
 *  Created date 14/11/2012 07:54 PM.
 *  Last modification date 01/02/2013 03:41 AM.
 *
 * Description :
 *  Errors class.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

class cliprz_error
{

    /**
     * Get error css style file from public.
     *
     * @param (string) $filename - file name.
     * @access public.
     */
    public static function errors_style ($filename)
    {
        return c_url('public'.DS.'css'.DS.'errors'.DS.$filename);
    }

    /**
     * Show 404 Not Found error.
     *
     * @access public.
     */
    public static function show_404 ()
    {
        $forzerofor = APP_PATH.'errors'.DS.'404.php';

        if (file_exists($forzerofor))
        {
            require_once ($forzerofor);
        }
        else
        {
            echo "<h1>404</h1>";
        }
    }

    /**
     * Show 400 Bad Request error.
     *
     * @access public.
     */
    public static function show_400 ()
    {
        $forzerofor = APP_PATH.'errors'.DS.'400.php';

        if (file_exists($forzerofor))
        {
            require_once ($forzerofor);
        }
        else
        {
            echo "<h1>400</h1>";
            //exit();
        }

    }

    /**
     * No javascript error page.
     *
     * @access public.
     */
    public static function noscript ()
    {
        $noscript = APP_PATH.'errors'.DS.'noscript.php';

        if (file_exists($noscript))
        {
            require_once ($noscript);
        }
        else
        {
            echo "<h1>No javascript</h1>";
        }

    }

    /**
     * Show database errors.
     *
     * @param (array) $_error - error content.
     *  $_error :
     *   'title'   - error title.
     *   'content' - error content (msg).
     * @access public.
     */
    public static function database ($_error='')
    {
        if (is_array($_error))
        {
            extract($_error);
        }

        if (file_exists(APP_PATH.'errors'.DS.'database.php'))
        {
            require_once APP_PATH.'errors'.DS.'database.php';
        }

        exit();
    }

}

?>
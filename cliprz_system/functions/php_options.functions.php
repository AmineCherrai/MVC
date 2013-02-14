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
 *  File name php_options.functions.php .
 *  Created date 13/12/2012 06:59 PM.
 *  Last modification 28/01/2013 02:53 PM.
 *
 * Description :
 *  PHP Options/Info functions.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

if (!function_exists('c_php_get_constants'))
{
    /**
     * Returns an associative array with the names of all the constants and their values.
     *
     * @param (boolean) $categorize - Causing this function to return a multi-dimensional array with
     *  categories in the keys of the first dimension and constants and their values in the second dimension.
     */
    function c_php_get_constants($categorize=true,$print_r=true)
    {
        if (is_bool($categorize) && is_bool($print_r))
        {
            if ($print_r == true)
            {
                return c_print_r(get_defined_constants($categorize));
            }
            else
            {
                return get_defined_constants($categorize);
            }
        }
    }
}

if (!function_exists('c_get_loaded_extensions'))
{
    /**
     *  Returns an array with the names of all modules compiled and loaded.
     *
     * @param (boolean) $print_r - if true you will return with c_print_r() else return with array
     */
    function c_get_loaded_extensions($print_r=true)
    {
        return (($print_r == true) ? c_print_r(get_loaded_extensions()) : (array) get_loaded_extensions());
    }
}

if (!function_exists('c_is_extension_loaded'))
{
    /**
     * Finds out whether the extension is loaded.
     *
     * @param (string) $extension - extension name.
     */
    function c_is_extension_loaded ($extension)
    {
        return (bool) ((extension_loaded($extension)) ? 1 : 0);
    }
}

if (!function_exists('c_get_temp_dir'))
{
    /**
     * Get directory path used for temporary files.
     */
    function c_get_temp_dir()
    {
        if (!empty($_ENV['TEMP']))
        {
            return realpath( $_ENV['TEMP']);
        }
        else if (!empty($_ENV['TMP']))
        {
            return realpath($_ENV['TMP']);
        }
        else if (!empty($_ENV['TMPDIR']))
        {
            return realpath( $_ENV['TMPDIR']);
        }
        else
        {
            return null;
        }
    }
}

?>
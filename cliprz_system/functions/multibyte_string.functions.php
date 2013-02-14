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
 *  File name multibyte_string.functions.php .
 *  Created date 18/11/2012 08:19 AM.
 *  Last modification date 03/02/2013 03:39 PM.
 *
 * Description :
 *  Multibyte String functions.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

mb_internal_encoding ($_config['output']['charset']);


if (!function_exists('c_mb_strlen'))
{
    /**
     * Get string length as string.
     */
    function c_mb_strlen($str)
    {
        return mb_strlen($str);
    }
}

if (!function_exists('c_mb_substr'))
{
    /**
     * Get part of string.
     *
     * @param (string) $str - The string to extract the substring from.
     * @param (integer) $start - Position of first character to use from str. Default = 0.
     * @param (integer) $length - Maximum number of characters to use from str. Default = 100 characters.
     */
    function c_mb_substr($str,$start=0,$length=100)
    {
        return mb_substr($str,$start,$length);
    }
}

if (!function_exists('c_mb_strtolower'))
{
    /**
     * Make a string or array lowercase.
     *
     * @param (mixed) $str - The input.
     */
    function c_mb_strtolower($str)
    {
        if (is_array($str))
        {
            foreach ($str as $key => $val)
            {
                $str[$key] = c_mb_strtolower($val);
            }
        }
        else
        {
            $str = mb_strtolower($str);
        }

        return $str;
    }
}

if (!function_exists('c_mb_strtoupper'))
{
    /**
     * Make a string or array uppercase.
     *
     * @param (mixed) $str - The input.
     */
    function c_mb_strtoupper($str)
    {
        if (is_array($str))
        {
            foreach ($str as $key => $val)
            {
                $str[$key] = c_mb_strtoupper($val);
            }
        }
        else
        {
            $str = mb_strtoupper($str);
        }

        return $str;
    }
}

?>
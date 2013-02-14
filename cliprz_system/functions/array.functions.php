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
 *  File name array.functions.php .
 *  Created date 19/10/2012 11:00 PM.
 *  Last modification date 10/02/2013 11:09 AM.
 *
 * Description :
 *  array functions.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

if (!function_exists('c_print_r'))
{
    /**
     * print array in to pre tag.
     *
     * @param (array) $array - array.
     */
    function c_print_r($array)
    {
        try
        {
            if (is_array($array))
            {
                echo '<pre>';
                print_r($array);
                echo '</pre>';
            }
            else
            {
                throw new Exception(__FUNCTION__.'(); $array parameter must be a array.');
            }
        }
        catch (Exception $e)
        {
            c_log_error($e,'ERROR');
        }
    }
}

if (!function_exists('c_is_array_empty'))
{
    /**
     * Check if array is empty or not.
     *
     * @param (array) $array - Array.
     */
    function c_is_array_empty ($array)
    {
        try
        {
            if (is_array($array))
            {
                foreach ($array as $key => $value)
                {
                    if (empty($value) || is_null($value))
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                }
            }
            else
            {
                throw new Exception(__FUNCTION__.'(); $array parameter must be a array.');
            }
        }
        catch (Exception $e)
        {
            c_log_error($e,'ERROR');
        }
    }
}

?>
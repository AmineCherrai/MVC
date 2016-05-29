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
 *  File name validate_filters.functions.php .
 *  Created date 04/12/2012 03:37 PM.
 *  Last modification 19/12/2012 04:49 PM.
 *
 * Description :
 *  validate filters functions.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

if (!function_exists("c_validate_id"))
{
    /**
     * return to make ID's clean and seafty to use with intger get values.
     *
     * @param (integer) $id - id you want to filtered.
     */
    function c_validate_id($id)
    {
        if (!preg_match("/^[0-9]+$/",$id) || empty($id) || !isset($id) || !filter_var($id,FILTER_VALIDATE_INT))
        {
            return false;
        }
        else
        {
            return true;
        }
    }
}

if (!function_exists("c_validate_email"))
{
    /**
     * Validate email value with regex.
     *
     * @param (string) $email - value.
     */
    function c_validate_email($email)
    {
        $pattren = "/^[A-Z0-9_.-]{1,40}+@([A-Z0-9_-]){2,30}+\.([A-Z0-9]){2,20}$/i";

        return (bool) preg_match($pattren,$email);
    }
}

if (!function_exists("c_validate_url"))
{
    /**
     * Validate urls value with regex.
     *
     * @param (string) $url - url value to check if url or not.
     */
    function c_validate_url($url)
    {
        $pattren = "|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i";

        return (bool) preg_match($pattren,$url);
    }
}

if (!function_exists("c_validate_num"))
{
    /**
     * Validate if value is numbers with regex & filter_var int.
     *
     * @param (integer) $num - the value to filtered.
     */
    function c_validate_num($num)
    {
        $pattren = "/^[0-9]+$/";

        if (preg_match($pattren,$num) || filter_var($num,FILTER_VALIDATE_INT))
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
?>
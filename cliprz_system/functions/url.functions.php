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
 *  File name url.functions.php .
 *  Created date 11/12/2012 11:22 AM.
 *  Last modification date 19/12/2012 04:47 PM.
 *
 * Description :
 *  URL functions.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

if (!function_exists('c_get_headers'))
{
    /**
     * Fetches all the headers sent by the server in response to a HTTP request.
     *
     * @param (string) $url - The target URL.
     * @param (integer) $format - If the optional format parameter is set to non-zero,
     *  parses the response and sets the array's keys.
     * @param (boolean) $print_r - if the optional is true you will get data with c_print_r function.
     * @return if format non-zero will get data as array with kyes else get data without kyes.
     */
    function c_get_headers($url,$format=0,$print_r=false)
    {
        if (is_integer($format) && is_bool($print_r))
        {
            return ($print_r == true) ? c_print_r(get_headers($url,$format)) : get_headers($url,$format);
        }
        else
        {
            trigger_error('c_get_headers function error.');
        }
    }
}

?>
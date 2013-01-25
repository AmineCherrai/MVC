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
 *  File name array.functions.php .
 *  Created date 19/10/2012 11:00 PM.
 *  Last modification date 19/10/2012 11:00 PM.
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
        if (is_array($array))
        {
            echo '<pre>';
            print_r($array);
            echo '</pre>';
        }
        else
        {
            echo $array.' Not array';
        }
    }
}

?>
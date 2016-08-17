<?php

/**
 * Cliprz framework
 *
 * Color your project, An open source application development framework for PHP 5.3.0 or newer
 *
 * Hanlding strings object
 *
 * LICENSE: This program is released as free software under the Affero GPL license. You can redistribute it and/or
 * modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 * at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 * written permission from the original author(s)
 *
 * @package    Cliprz
 * @category
 * @author     Yousef Ismaeil <cliprz@gmail.com>
 * @copyright  Copyright (c) 2012 - 2013, Cliprz Developers team
 * @license    http://www.cliprz.org/licenses/agpl
 * @link       http://www.cliprz.org
 * @since      Version 2.0.0
 */

class cliprz_string
{

    /**
     * Un-quotes a quoted string
     *
     * @param mixed $str The input string
     *
     * @access public
     * @static
     */
    public static function stripslashes($str)
    {
        if (is_array($str))
        {
            foreach ($str as $key => $val)
            {
                $str[$key] = self::stripslashes($val);
            }
        }
        else
        {
            $str = stripslashes($str);
        }

        return $str;
    }

    /**
     * Quote string with slashes and strip whitespace from the beginning and end of a string
     *
     * @param mixed   $str  The string to be escaped
     * @param boolean $trim Use trim spacing
     *
     * @access public
     * @static
     */
    public static function addslashes ($str,$trim=TRUE)
    {
        if (is_array($str))
        {
            foreach ($str as $key => $val)
            {
                $str[$key] = self::addslashes($val,$trim);
            }
        }
        else
        {
            $str = (is_bool($trim) && $trim == TRUE) ? trim(addslashes($str)) : addslashes($str);
        }

        return $str;
    }

    /**
     * Convert all applicable characters to HTML entities with utf-8
     *
     * @param string $str  The input string
     * @param string $flag A bitmask of one or more of the following flags, which specify how to handle quotes,
     *                     invalid code unit sequences and the used document type
     *
     * @access public
     * @static
     */
    public static function htmlentities($str,$flag=NULL)
    {
        if (is_null($flag))
        {
            return htmlentities($str,ENT_COMPAT,CHARSET);
        }
        else
        {
            return htmlentities($str,$flag,CHARSET);
        }
    }

}

/**
 * End of file string.php
 *
 * @created  22/03/2013 03:58 pm
 * @updated  25/03/2013 01:53 pm
 * @location ./system/strings/string.php
 */

?>
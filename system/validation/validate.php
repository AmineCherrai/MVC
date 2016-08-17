<?php

/**
 * Cliprz framework
 *
 * Color your project, An open source application development framework for PHP 5.3.0 or newer
 *
 * This object well validation inputs and vairables data
 *
 * LICENSE: This program is released as free software under the Affero GPL license. You can redistribute it and/or
 * modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 * at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 * written permission from the original author(s)
 *
 * @package    Cliprz
 * @category   system
 * @author     Yousef Ismaeil <cliprz@gmail.com>
 * @copyright  Copyright (c) 2012 - 2013, Cliprz Developers team
 * @license    http://www.cliprz.org/licenses/agpl
 * @link       http://www.cliprz.org
 * @since      Version 2.0.0
 */

class cliprz_validate
{

    /**
     * Check the value is integer
     *
     * @param integer $int The validate value
     *
     * @return TRUE if input is integer
     * @access public
     * @static
     */
    public static function is_int ($int)
    {
        return (boolean) ((preg_match("/^[0-9]+$/",$int) && filter_var($int,FILTER_VALIDATE_INT)) ? TRUE : FALSE);
    }

    /**
     * Check if email address is validate
     *
     * @param string $email Input value
     *\
     * @return TRUE if email address is validate
     * @access public
     * @static
     */
    public static function is_email ($email)
    {
        $pattren = "/^[A-Z0-9_.-]{1,40}+@([A-Z0-9_-]){2,30}+\.([A-Z0-9]){2,20}$/i";

        return (boolean) preg_match($pattren,$email);
    }

    /**
     * Check if website urls is validate
     *
     * @param string $url Input value
     *
     * @return TRUE if website url is validate
     * @access public
     * @static
     */
    public static function is_url ($url)
    {
        $pattren = "|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i";

        return (boolean) preg_match($pattren,$url);
    }

    /**
     * Validate session name
     *
     * @param string $session_id Session id
     *
     * @return TRUE if validate session name
     * @access public
     * @static
     */
    public static function is_session ($session_id)
    {
        return (boolean) (preg_match("/^[0-9a-z_-]+$/i",$session_id));
    }

    /**
     * @see self::is_int()
     *
     * @param integer $int The validate value
     *
     * @access public
     * @static
     */
    public static function is_id ($int)
    {
        return self::is_int($int);
    }

    /**
     * @see self::is_int()
     *
     * @param integer $int The validate value
     *
     * @access public
     * @static
     */
    public static function is_integer ($int)
    {
        return self::is_int($int);
    }

    /**
     * @see self::is_url()
     *
     * @param string $url Input value
     *
     * @return TRUE if website url is validate
     * @access public
     * @static
     */
    public static function is_website ($url)
    {
        return self::is_url($url);
    }

    /**
     * @sess self::is_session
     *
     * @param string $session_id Session id
     *
     * @return TRUE if validate cookie name
     * @access public
     * @static
     */
    public static function is_cookie ($session_id)
    {
        return self::is_session($session_id);
    }

}

/**
 * End of file validate.php
 *
 * @created  22/03/2013 09:59 pm
 * @updated  25/03/2013 01:53 pm
 * @location ./system/validation/validate.php
 */

?>
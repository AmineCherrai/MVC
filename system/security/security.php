<?php

/**
 * Cliprz framework
 *
 * Color your project, An open source application development framework for PHP 5.3.0 or newer
 *
 * Security object
 *
 * LICENSE: This program is released as free software under the Affero GPL license. You can redistribute it and/or
 * modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 * at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 * written permission from the original author(s)
 *
 * @package    Cliprz
 * @category   system
 * @author     Yousef Ismaeil <cliprz@gmail.com>
 * @copyright  Copyright (c) 2012 - 2013, Cliprz Developers team.
 * @license    http://www.cliprz.org/licenses/agpl
 * @link       http://www.cliprz.org
 * @since      Version 2.0.0
 */

class cliprz_security
{

    /**
     * Security constructor
     *
     * @access public
     */
    public function __construct()
    {

        if (self::check_get_xss($_GET))
        {
            exit("Access Denied");
        }

        $super_destruct = array("_GET","_POST","_SERVER","_COOKIE","_FILES","_ENV","GLOBALS");

        foreach($super_destruct as $var)
        {
            if(isset($_REQUEST[$var]) || isset($_FILES[$var]))
            {
                die("Access Denied");
            }
        }

        // Clean server variables
        $_SERVER['PHP_SELF']     = self::clean_url($_SERVER['PHP_SELF']);

        $_SERVER['QUERY_STRING'] = isset($_SERVER['QUERY_STRING'])
            ? self::clean_url($_SERVER['QUERY_STRING'])
            : NULL;

        $_SERVER['PATH_INFO']    = isset($_SERVER['PATH_INFO'])
            ? self::clean_url($_SERVER['PATH_INFO'])
            : NULL;

        $_SERVER['REQUEST_URI']  = isset($_SERVER['REQUEST_URI'])
            ? self::clean_url($_SERVER['REQUEST_URI'])
            : NULL;

        $_SERVER['SCRIPT_NAME']  = isset($_SERVER['SCRIPT_NAME'])
            ? self::clean_url($_SERVER['SCRIPT_NAME'])
            : NULL;

    }

    /**
     * Clean URL Function, prevents entities in server globals
     *
     * @param $url the server super global request and selfs
     *
     * @access public
     * @static
     */
    public static function clean_url($url)
    {
    	$bad_entities = array("&", "\"", "'", '\"', "\'", "<", ">", "(", ")", "*",'$');
    	$safe_entities = array("&amp;", "", "", "", "", "", "", "", "", "",'');
    	$url = str_ireplace($bad_entities, $safe_entities, $url);
    	return $url;
    }

    /**
     * Prevent any possible XSS attacks via $_GET Super Global
     *
     * @param mixed $check_url url who want to filter
     *
     * @access private
     * @static
     */
    private static function check_get_xss($check_url)
    {
        $return = false;

        if (is_array($check_url))
        {
            foreach ($check_url as $value)
            {
                if (self::check_get_xss($value) == true)
                {
                    return true;
                }
            }
        }
        else
        {
            $check_url = str_replace(array("\"", "\'"), array("", ""), urldecode($check_url));
            if (preg_match("/<[^<>]+>/i", $check_url))
            {
                return true;
            }
        }

        return $return;
    }

}

/**
 * End of file security.php
 *
 * @created  21/03/2013 03:49 pm
 * @updated  25/03/2013 01:55 pm
 * @location ./system/security/security.php
 */

?>
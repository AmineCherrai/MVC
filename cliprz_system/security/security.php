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
 *  File path BASE_PATH/cliprz_system/security/ .
 *  File name security.php .
 *  Created date 17/11/2012 09:35 PM.
 *  Last modification date 19/01/2013 07:22 PM.
 *
 * Description :
 *  security class.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

class cliprz_security
{

    /**
     * Security constructor.
     *
     * @access public.
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

        // clean server variables
        $_SERVER['PHP_SELF']     = self::cleanurl($_SERVER['PHP_SELF']);

        $_SERVER['QUERY_STRING'] = isset($_SERVER['QUERY_STRING'])
            ? self::cleanurl($_SERVER['QUERY_STRING'])
            : "";

        $_SERVER['PATH_INFO']    = isset($_SERVER['PATH_INFO'])
            ? self::cleanurl($_SERVER['PATH_INFO'])
            : "";

        $_SERVER['REQUEST_URI']  = isset($_SERVER['REQUEST_URI'])
            ? self::cleanurl($_SERVER['REQUEST_URI'])
            : "";

        $_SERVER['SCRIPT_NAME']  = isset($_SERVER['SCRIPT_NAME'])
            ? self::cleanurl($_SERVER['SCRIPT_NAME'])
            : "";

    }

    /**
     * Clean URL Function, prevents entities in server globals.
     *
     * @param (string) $url - the server super global request and selfs.
     * @access public.
     */
    public static function cleanurl($url)
    {
    	$bad_entities = array("&", "\"", "'", '\"', "\'", "<", ">", "(", ")", "*",'$');
    	$safe_entities = array("&amp;", "", "", "", "", "", "", "", "", "",'');
    	$url = str_ireplace($bad_entities, $safe_entities, $url);
    	return $url;
    }

    /**
     * Prevent any possible XSS attacks via $_GET Super Global.
     *
     * @param (mixed) $check_url - url who want to filter.
     * @author PHP-Fusion.co.uk.
     * @access protected.
     */
    protected static function check_get_xss($check_url)
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

?>
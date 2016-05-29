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
 *  File path BASE_PATH/cliprz_system/router/ .
 *  File name uri.php .
 *  Created date 19/01/2013 01:50 PM.
 *  Last modification date 19/01/2013 10:23 PM.
 *
 * Description :
 *  uri class.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

class cliprz_uri
{

    /**
     * Processing the request before sending.
     *
     * @access protected.
     */
    public static function uri_protocol ()
    {
        global $_config;

        $uri_protocol = null;

        switch ($_config['uri']['protocol'])
        {
            case "REQUEST_URI":
                $uri_protocol = self::request_uri();
            break;
            case "PATH_INFO":
                $uri_protocol = self::path_info();
            break;
            case "PHP_SELF":
                $uri_protocol = self::php_self();
            break;
            default:
                $uri_protocol = null;
            break;
        }

        return $uri_protocol;
    }

    /**
     * Get PATH_INFO.
     *
     * PHP :
     * Contains any client-provided pathname information trailing the actual script filename but preceding the query string, if available.
     * For instance, if the current script was accessed via the URL http://www.example.com/php/path_info.php/some/stuff?foo=bar,
     * then $_SERVER['PATH_INFO'] would contain /some/stuff.
     *
     * @access protected.
     */
    protected static function path_info ()
    {
        $path_info = c_trim_path(c_get_server_env("PATH_INFO"));

        return $path_info;
    }

    /**
     * Get The filename of the currently executing script, relative to the document root.
     *
     * @access protected.
     */
    protected static function php_self ()
    {
        if (!isset($_SERVER['SCRIPT_NAME']))
        {
            if (C_DEVELOPMENT_ENVIRONMENT == true)
            {
                trigger_error("SCRIPT_NAME cannot access to the request.");
            }
            else
            {
                cliprz::system(error)->show_400();
            }
        }
        else
        {
            $php_self = c_get_server_env("PHP_SELF");

            $script_name = (string) c_trim_path($_SERVER['SCRIPT_NAME']);

            $php_self = c_trim_path($php_self);

            if (preg_match("`^{$script_name}`i",$php_self))
            {
                $php_self = str_ireplace($script_name,"",$php_self);
            }

            unset($script_name);

            $uri = c_trim_path($php_self);

            unset($php_self);

            return $uri;
        }
    }

	/**
	 * Detects the Request URI and fix the query string.
	 *
	 * @access protected.
     * @author CodeIgniter.
	 */
    protected static function request_uri ()
    {
        if (!isset($_SERVER['REQUEST_URI']) || !isset($_SERVER['SCRIPT_NAME']))
        {
            if (C_DEVELOPMENT_ENVIRONMENT == true)
            {
                trigger_error("REQUEST_URI or SCRIPT_NAME cannot access to the request.");
            }
            else
            {
                cliprz::system(error)->show_400();
            }
        }
        else
        {
            $request_uri = $_SERVER['REQUEST_URI'];

            if (strpos($request_uri, $_SERVER['SCRIPT_NAME']) === 0)
            {
                $request_uri = mb_substr($request_uri, c_mb_strlen($_SERVER['SCRIPT_NAME']));
            }
            else if (strpos($request_uri,dirname($_SERVER['SCRIPT_NAME'])) === 0)
            {
                $request_uri = mb_substr($request_uri, c_mb_strlen(dirname($_SERVER['SCRIPT_NAME'])));
            }

            if (strncmp($request_uri, '?/', 2) === 0)
            {
                $request_uri = mb_substr($request_uri,2);
            }

            $parts = preg_split('#\?#i', $request_uri,2);

            $request_uri = $parts[0];

            if (isset($parts[1]))
            {
                $_SERVER['QUERY_STRING'] = $parts[1];
                parse_str($_SERVER['QUERY_STRING'],$_GET);
            }
            else
            {
                $_SERVER['QUERY_STRING'] = '';
                $_GET = array();
            }

            if ($request_uri == '/' || empty($request_uri))
            {
                #return '/';
                return ;
            }

            $request_uri = parse_url($request_uri,PHP_URL_PATH);

            $request_uri = str_replace(array('//', '../'),'/',$request_uri);

            $uri = c_trim_path($request_uri);

            unset($request_uri);

            return $uri;
        }
    }

}

?>
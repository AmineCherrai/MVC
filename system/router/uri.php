<?php

/**
 * Cliprz framework
 *
 * Color your project, An open source application development framework for PHP 5.3.0 or newer
 *
 * URI protocol object
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

class cliprz_uri
{

    /**
     * Processing the request before sending
     *
     * @access public
     * @static
     */
    public static function uri_protocol ()
    {
        $uri_protocol = NULL;

        $config_uri = mb_strtoupper(cliprz::system('config')->get('protocol','uri'));

        switch ($config_uri)
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
                $uri_protocol = NULL;
            break;
        }

        unset($config_uri);

        return $uri_protocol;
    }

    /**
     * Get PATH_INFO to set in URI protocol
     *
     * @access private
     * @static
     */
    private static function path_info ()
    {
        $path_info = cliprz::rds((isset($_SERVER["PATH_INFO"])) ? $_SERVER['PATH_INFO'] : getenv('PATH_INFO'),'both');

        return $path_info;
    }

    /**
     * Get The filename of the currently executing script, relative to the document root to set in URI protocol
     *
     * @access private
     * @static
     */
    private static function php_self ()
    {
        if (!isset($_SERVER['SCRIPT_NAME']))
        {
            exit("SCRIPT_NAME cannot access to the request.");
        }
        else
        {
            $php_self = (isset($_SERVER['PHP_SELF'])) ? $_SERVER['PHP_SELF'] : getenv('PHP_SELF');

            $script_name = (string) cliprz::rds($_SERVER['SCRIPT_NAME'],'both');

            $php_self = cliprz::rds($php_self,'both');

            if (preg_match("`^{$script_name}`i",$php_self))
            {
                $php_self = str_ireplace($script_name,"",$php_self);
            }

            unset($script_name);

            $uri = cliprz::rds($php_self,'both');

            unset($php_self);

            return $uri;
        }
    }

    /**
     * Detects the Request URI and fix the query string
     *
     * @author CodeIgniter
     * @access private
     * @static
     */
    private static function request_uri ()
    {
        if (!isset($_SERVER['REQUEST_URI']) || !isset($_SERVER['SCRIPT_NAME']))
        {
            exit("REQUEST_URI or SCRIPT_NAME cannot access to the request.");
        }
        else
        {
            $request_uri = $_SERVER['REQUEST_URI'];

            if (strpos($request_uri, $_SERVER['SCRIPT_NAME']) === 0)
            {
                $request_uri = mb_substr($request_uri, mb_strlen($_SERVER['SCRIPT_NAME']));
            }
            else if (strpos($request_uri,dirname($_SERVER['SCRIPT_NAME'])) === 0)
            {
                $request_uri = mb_substr($request_uri, mb_strlen(dirname($_SERVER['SCRIPT_NAME'])));
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

            $uri = cliprz::rds($request_uri,'both');

            unset($request_uri);

            return $uri;
        }
    }

}

/**
 * End of file uri.php
 *
 * @created  20/03/2013 12:49 pm
 * @updated  25/03/2013 01:55 pm
 * @location ./system/router/uri.php
 */

?>
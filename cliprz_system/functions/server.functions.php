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
 *  File name server.functions.php .
 *  Created date 18/10/2012 09:05 AM.
 *  Last modification date 19/01/2013 04:30 PM.
 *
 * Description :
 *  server functions.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

if (!function_exists('c_get_request_resource'))
{
    /**
     * Get requested URI that the sent by the Client.
     */
    function c_get_request_resource()
    {
        if(isset($_SERVER["PATH_INFO"]))
        {
            return $_SERVER["PATH_INFO"];
        }
        else if(isset($_SERVER["PHP_SELF"]))
        {
            return $_SERVER["PHP_SELF"];
        }
        else if(isset($_SERVER["REQUEST_URI"]))
        {
            $uri = $_SERVER["REQUEST_URI"];

            if($request_uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH))
            {
                $uri = $request_uri;
            }

            return rawurldecode($uri);
        }
        else
        {
            exit('Could not find the request URI using PATH_INFO, PHP_SELF, or REQUEST_URI.');
        }
    }
}

if (!function_exists('c_get_request_method'))
{
    /**
     * get request method.
     */
    function c_get_request_method ()
    {
        if (isset($_SERVER["REQUEST_METHOD"]))
        {
            return $_SERVER["REQUEST_METHOD"];
        }
    }
}

if (!function_exists('c_get_http_user_agent'))
{
    /**
     * Get server HTTP_USER_AGENT
     */
    function c_get_http_user_agent ()
    {
        return (isset($_SERVER["HTTP_USER_AGENT"])) ? trim($_SERVER["HTTP_USER_AGENT"]) : "";
    }
}

if (!function_exists('c_get_referer'))
{
    /**
     * Get HTTP_REFERER
     */
    function c_get_referer ()
    {
        return (isset($_SERVER["HTTP_REFERER"])) ? trim($_SERVER["HTTP_REFERER"]) : "";
    }
}

if (!function_exists('c_get_https'))
{
    /**
     * Set to a non-empty value if the script was queried through the HTTPS protocol.
     * @note: Note that when using ISAPI with IIS,
     *  the value will be off if the request was not made through the HTTPS protocol.
     */
    function c_get_https ()
    {
        return (isset($_SERVER['HTTPS'])) ? $_SERVER['HTTPS'] : getenv('HTTPS');
    }
}

if (!function_exists('c_get_http_host'))
{
    /**
     * Contents of the Host: header from the current request, if there is one.
     */
    function c_get_http_host ()
    {
        return (isset($_SERVER['HTTP_HOST'])) ? $_SERVER['HTTP_HOST'] : getenv('HTTP_HOST');
    }
}

if (!function_exists('c_get_ip'))
{
    /**
     * return to get the real ip address.
     */
    function c_get_ip()
    {
        if (isset($_SERVER["HTTP_CLIENT_IP"]))
        {
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"]))
        {
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_X_FORWARDED"]))
        {
            $ip = $_SERVER["HTTP_X_FORWARDED"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED_FOR"]))
        {
            $ip = $_SERVER["HTTP_FORWARDED_FOR"];
        }
        elseif (isset($_SERVER["HTTP_FORWARDED"]))
        {
            $ip = $_SERVER["HTTP_FORWARDED"];
        }
        else if (isset($_SERVER["REMOTE_ADDR"]))
        {
            $ip = $_SERVER["REMOTE_ADDR"];
        }
        else
        {
            $ip = getenv("REMOTE_ADDR");
        }

        return $ip;
    }
}

if (!function_exists('c_get_domain'))
{
    /**
     * Get the current TLD address and scheme (domain).
     */
    function c_get_domain ()
    {
        $domain = "";

        if (strtolower(c_get_https()) == 'on')
        {
            $domain .= "https";
        }
        else
        {
            $domain .= "http";
        }

        $domain .= "://";

        $domain .= c_get_http_host();

        $domain .= DS;

        return $domain;
    }
}

if (!function_exists("c_get_accept_language"))
{
    /**
     * Contents of the Accept-Language: header from the current request, if there is one. Example: 'en'.
     */
    function c_get_accept_language()
    {
        return ((isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) ? trim($_SERVER['HTTP_ACCEPT_LANGUAGE']) : "");
    }
}

if (!function_exists('c_get_server_env'))
{
    /**
     * This function will test if isset $_SERVER or get from getenv() function.
     *
     * @param (string) $env - key name.
     */
    function c_get_server_env ($env)
    {
        return ((isset($_SERVER[$env])) ? $_SERVER[$env] : @getenv($env));
    }
}

?>
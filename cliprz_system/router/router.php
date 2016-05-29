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
 *  File name router.php .
 *  Created date 17/10/2012 05:06 AM.
 *  Last modification date 19/01/2013 01:47 PM.
 *
 * Description :
 *  Router class.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

class cliprz_router
{

    /**
     * @var (array) $_map - Get requested URI that the sent by the Client as in array.
     * @access protected.
     */
    protected static $_map = array();

    /**
     * @var (array) $_rule - Routing rules.
     * @access protected.
     */
    protected static $_rule = array();

    /**
     * @var (array) $_requested - Get requested URI and requested method.
     * @access protected.
     */
    protected static $_requested;

    /**
     * @var (array) $_mask - Regular expression mask to access routing and parameters.
     * @access protected.
     */
    protected static $_mask = array(
        ":ANY"    => ".+",
        ":INT"    => "[0-9]+",
        ":FLO"    => "[0-9]+.+[0-9]+",
        ":STR"    => "[a-z0-9-_]+",
        ":CHR"    => "[a-z]+",
		":ACTION" => "index|show|view|add|create|edit|update|remove|delete",
		":BOOL"   => "true|false|0|1"
    );
	
    /**
     * @var (string) $default_function - If function does not exists use index function as main function.
     * @access protected.
     */
    protected static $default_function = "index";

    /**
     * Router constructor.
     *
     * @access public.
     */
    public function __construct()
    {
        self::$_requested['resource'] = cliprz::system('uri')->uri_protocol();
        self::$_requested['method']   = c_get_request_method();
        self::$_map = self::map(self::$_requested['resource']);
        //echo self::$_requested['resource'];
        // c_print_r(self::$_map);
    }

    /**
     * Add new rule to routing.
     *
     * @param (array) $_action.
     *  $_action :
     *   'regex'      - Add url mask you want to use.
     *   'class'      - Add controller class.
     *   'function'   - Add controller class method (function), By default take self::$default_function value.
     *   'parameters' - Add parameters to controller class method (function).
     *   'path'       - If controller class in subfolder inside controllers folder, put the path name here.
     *   'method'     - Request method to access routing, By default GET u can use (PUT|HEAD|POST|GET).
     * @access public.
     */
    public static function rule ($_action)
    {
        if (is_array($_action))
        {
            self::$_rule[] = array(
                "regex"      => (isset($_action['regex']))
                    ? (string) $_action['regex']
                    : null,

                "class"      => (isset($_action['class']))
                    ? (string) $_action['class']
                    : null,

                "function"   => (isset($_action['function']))
                    ? (string) $_action['function']
                    : (string) self::$default_function,

                "parameters" => (isset($_action['parameters']))
                    ? (array) $_action['parameters']
                    : null,

                "path"       => (isset($_action['path']))
                    ? c_trim_path($_action['path']).'/'
                    : "",

                "method"     => (isset($_action['method']))
                    ? strtoupper($_action['method'])
                    : "GET"
            );
        }
    }

    /**
     * Handling router to access project.
     *
     * @access public.
     */
    public static function handler ()
    {

        if (self::get_router() === true)
        {
            $regex      = null;
            $class      = null;
            $class_path = null;
            $object     = null;
            $function   = null;
            $parameters = null;


            foreach (self::$_rule as $rule)
            {
                $regex = self::resource_to_regex($rule['regex']);

                if (preg_match($regex,self::$_requested['resource']))
                {

                    if ($rule['method'] == self::$_requested['method'])
                    {

                        // check class
                        $class      = $rule['class'];
                        $class_path = APP_PATH.'controllers'.DS.$rule['path'].$class.'.php';

                        if (file_exists($class_path))
                        {
                            require_once $class_path;

                            // check if class exists
                            if (class_exists($class))
                            {
                                $object = new $class();

                                // check object functions (methods).
                                $function   = $rule['function'];
                                $parameters = $rule['parameters'];

                                if (method_exists($class,$function))
                                {

                                    if (!is_null($parameters) && is_array($parameters))
                                    {
                                        call_user_func_array(
                                            array($object,$function),
                                            self::get_parameters($parameters));
                                    }
                                    else
                                    {
                                        $object->$function();
                                    }

                                }
                                else
                                {
                                    cliprz::system(error)->show_404();
                                }

                            }
                            else
                            {
                                cliprz::system(error)->show_404();
                            }

                        }
                        else
                        {
                            cliprz::system(error)->show_404();
                        }

                    }

                    // if regex matched break the loop
                    break;
                }

            }

            // Unset data
            unset($regex,$class,$class_path,$object,$function,$parameters);
            self::$_rule      = array();
            self::$_map       = array();
            self::$_requested = array();

        }
        else
        {
            cliprz::system(error)->show_404();
        }

    }

    /**
     * redirecting to index page.
     *
     * @param (string) $index - Home page.
     * @access public.
     */
    public static function index ($index)
    {
        if (!self::$_requested['resource'] || empty(self::$_requested['resource']))
        {
            c_redirecting(c_url($index));
        }
    }

    /**
     * Convert requested URI that the sent by the Client to regular expression.
     *
     * @param (string) $resource - Requested URI that the sent by the Client.
     * @access protected.
     */
    protected static function resource_to_regex ($resource)
    {
        $keys    = array_keys(self::$_mask);

        $replace = str_replace($keys,self::$_mask,$resource);

        $regex   = (string) "`^{$replace}$`i";

        return $regex;
    }

    /**
     * Convert requested URI that the sent by the Client to array.
     *
     * @param (string) $map - Requested URI that the sent by the Client.
     * @access protected.
     */
    protected static function map ($map)
    {
        return ((array) explode("/",$map));
    }

    /**
     * Find and set parameters if exsists.
     *
     * @param (array) $parameters - parameters numbers.
     * @access protected.
     */
    protected static function set_parameters ($parameters)
    {
        if (is_array($parameters))
        {
            // $result = null;

            foreach ($parameters as $param)
            {
                $result[] = self::$_map[$param];
            }

            return $result;
        }
    }

    /**
     * Get parameters if exsists.
     *
     * @param (array) $parameters - parameters numbers.
     * @access protected.
     */
    protected static function get_parameters ($parameters)
    {
        return (array) self::set_parameters($parameters);
    }

    /**
     * Check and set rules if exists.
     *
     * @access protected.
     */
    protected static function set_router ()
    {
        $bool = false;

        foreach (self::$_rule as $router)
        {
            $regex = self::resource_to_regex($router['regex']);

            if (preg_match($regex,self::$_requested['resource']))
            {
                $bool = true;
                break;
            }
        }
        return $bool;
    }

    /**
     * Get rules if exists.
     *
     * @return to boolean.
     * @access protected.
     */
    protected static function get_router ()
    {
        return (boolean) self::set_router();
    }

}

?>
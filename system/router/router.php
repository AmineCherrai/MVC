<?php

/**
 * Cliprz framework
 *
 * Color your project, An open source application development framework for PHP 5.3.0 or newer
 *
 * Routing project URLs object, Helps you to routing a slashes URLs as in example http://example.example/blog/author/Cliprz
 * this object is very good for SEO (Search engine optimization), Google, Yahoo, bing, and Popular search engines will trust your project
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

class cliprz_router
{

    /**
     * Get requested URI that the sent by the Client as in array
     *
     * @var array
     * @access private
     * @static
     */
    private static $_map = array();

    /**
     * Routing rules
     *
     * @var array
     * @access private
     * @static
     */
    private static $_rule = array();

    /**
     * Get requested URI and requested method
     *
     * @var array
     * @access private
     * @static
     */
    private static $_requested;

    /**
     * Regular expression mask to access routing and parameters
     *
     * @var array
     * @access private
     * @static
     */
    private static $_mask = array(
        ':ANY'    => ".+",
        ':INT'    => "[0-9]+",
        ':FLO'    => "[0-9]+.+[0-9]+",
        ':STR'    => "[a-z0-9-_]+",
        ':CHR'    => "[a-z]+",
        ':ACTION' => "index|show|view|add|create|edit|update|remove|delete",
        ':BOOL'   => "true|false|0|1"
    );

    /**
     * If function does not exists use index function as main function
     *
     * @var string
     * @access private
     * @static
     */
    private static $default_function = 'index';

    /**
     * Router constructor
     *
     * @access public
     */
    public function __construct()
    {
        self::$_requested['resource'] = cliprz::system('uri')->uri_protocol();
        self::$_requested['method']   = (isset($_SERVER["REQUEST_METHOD"])) ? $_SERVER["REQUEST_METHOD"] : NULL;
        self::$_map = self::map(self::$_requested['resource']);
        //echo self::$_requested['resource'];
    }

    /**
     * Add new rule to routing
     *
     * @param array $_action Rule actions as array with keys
     *               string 'regex'       URL mask you want to use
     *               string 'class'       Controller class name
     *               string 'function'    Controller class method (function), By default take self::$default_function value
     *               string 'parameters'  Controller class method (function) parameters as array with position number beginning from zero
     *               string 'path'        If controller class in subfolder inside controllers folder, put the path name here
     *               string 'redirecting' Redirecting page of your choice if Regular expressions matched
     *               string 'method'      Request method to access routing, By default GET u can use (POST|GET)
     *
     * @access public
     * @static
     */
    public static function rule ($_action)
    {
        if (is_array($_action))
        {
            self::$_rule[] = array(
                // Regular expressions
                'regex'       => (isset($_action['regex']))
                ? (string) $_action['regex']
                : NULL,

                // Class name
                'class'       => (isset($_action['class']))
                ? (string) $_action['class']
                : NULL,

                // Metohd (function) name.
                'function'    => (isset($_action['function']))
                ? (string) $_action['function']
                : (string) self::$default_function,

                // parameters as array.
                'parameters'  => (isset($_action['parameters']))
                ? (array) $_action['parameters']
                : NULL,

                // Set class sub folder name in controller folder.
                'path'        => (isset($_action['path']))
                ? cliprz::rds($_action['path'],'both').DS
                : '',

                // Redirecting to page of your choice if Regular expressions matched.
                'redirecting' => (isset($_action['redirecting']))
                ? cliprz::rds($_action['redirecting'],'both')
                : NULL,

                // Request method type.
                'method'      => (isset($_action['method']))
                ? mb_strtoupper($_action['method'])
                : 'GET'
            );
        }
    }

    /**
     * Handling router to access controller
     *
     * @access public
     * @static
     */
    public static function handler ()
    {

        if (self::get_router() === TRUE)
        {
            $regex      = NULL;
            $class      = NULL;
            $class_path = NULL;
            $object     = NULL;
            $function   = NULL;
            $parameters = NULL;


            foreach (self::$_rule as $rule)
            {
                // Convert resource to regular expressions.
                $regex = self::resource_to_regex($rule['regex']);

                // Check regex if match resource.
                if (preg_match($regex,self::$_requested['resource']))
                {
                    // Check request method.
                    if ($rule['method'] == self::$_requested['method'])
                    {
                        // Check if redirecting is isset and not null go to redirecting page.
                        if (isset($rule['redirecting']) && !is_null($rule['redirecting']))
                        {
                            self::redirecting($rule['redirecting']);
                        }
                        else // else if no redirecting page.
                        {
                            // Set class name.
                            $class      = $rule['class'];
                            // Set class path
                            $class_path = PROJECT_PATH.$rule['path'].$class.'.controller'.EXT;

                            // Check if class file is exists.
                            if (file_exists($class_path))
                            {
                                // Call class.
                                require_once $class_path;

                                // check if class exists
                                if (class_exists($class))
                                {
                                    // Create a new object.
                                    $object = new $class();

                                    // check object functions (methods).
                                    $function   = $rule['function'];
                                    $parameters = $rule['parameters'];

                                    // Check if method exists.
                                    if (method_exists($class,$function))
                                    {
                                        // Check if parameters is array.
                                        if (!is_null($parameters) && is_array($parameters))
                                        {
                                            // Call object and method and set parameters for method.
                                            call_user_func_array(
                                                array($object,$function),
                                                self::get_parameters($parameters));
                                        }
                                        else // Else if parameters is not array
                                        {
                                            $object->$function();
                                        }

                                    }
                                    else
                                    {
                                        cliprz::system('error')->status(404);
                                    }

                                }
                                else
                                {
                                    cliprz::system('error')->status(404);
                                }

                            }
                            else
                            {
                                cliprz::system('error')->status(404);
                            }

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
            cliprz::system('error')->status(404);
        }

    }

    /**
     * Set a Index page (homepage)
     *
     * @param string $index Home page name
     *
     * @access public
     * @static
     */
    public static function index ($index)
    {
        if (!self::$_requested['resource'] || empty(self::$_requested['resource']))
        {
            self::redirecting($index);
        }
    }

    /**
     * Convert requested URI that the sent by the Client to regular expression
     *
     * @param string $resource Requested URI that the sent by the Client
     *
     * @access private
     * @static
     */
    private static function resource_to_regex ($resource)
    {
        $keys    = array_keys(self::$_mask);

        $replace = str_replace($keys,self::$_mask,$resource);

        $regex   = (string) "`^{$replace}$`i";

        return $regex;
    }

    /**
     * Convert requested URI that the sent by the Client to array
     *
     * @param string $map Requested URI that the sent by the Client
     *
     * @access private
     * @static
     */
    private static function map ($map)
    {
        return ((array) explode("/",$map));
    }

    /**
     * Find and set parameters if exsists
     *
     * @param array $parameters
     *
     * @access private
     * @static
     */
    private static function set_parameters ($parameters)
    {
        if (is_array($parameters))
        {
            foreach ($parameters as $param)
            {
                $result[] = self::$_map[$param];
            }

            return $result;
        }
    }

    /**
     * Get parameters if exsists
     *
     * @param array $parameters Method (function) parameters
     *
     * @access private
     * @static
     */
    private static function get_parameters ($parameters)
    {
        return (array) self::set_parameters($parameters);
    }

    /**
     * Check and set rules if exists
     *
     * @access private
     * @static
     */
    private static function set_router ()
    {
        $bool = FALSE;

        foreach (self::$_rule as $router)
        {
            $regex = self::resource_to_regex($router['regex']);

            if (preg_match($regex,self::$_requested['resource']))
            {
                $bool = TRUE;
                break;
            }
        }
        return $bool;
    }

    /**
     * Get rules if exists
     *
     * @access private
     * @static
     */
    private static function get_router ()
    {
        return (boolean) self::set_router();
    }

    /**
     * Redirecting
     *
     * @param string $page Redirecting page as default NULL index.php
     *
     * @access public
     * @static
     */
    public static function redirecting ($page=NULL)
    {
        if (is_null($page))
        {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: index.php");
            exit();
        }
        else
        {
            header("HTTP/1.1 301 Moved Permanently");
            header("Location: ".$page);
            exit();
        }
    }

}

/**
 * End of file router.php
 *
 * @created  20/03/2013 11:39 am
 * @updated  01/04/2013 06:16 pm
 * @location ./system/router/router.php
 */

?>
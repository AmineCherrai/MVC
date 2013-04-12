<?php

/**
 * Cliprz framework
 *
 * Color your project, An open source application development framework for PHP 5.3.0 or newer
 *
 * Cliprz Core object
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

class cliprz
{

    /**
     * The instance of the registry
     *
     * @var string
     * @access private
     * @static
     */
    private static $_instances;

    /**
     * our registry objects
     *
     * @var array
     * @access private
     * @static
     */
    private static $_objects = array();

    /**
     * Project folder name
     *
     * @var string $project
     *
     * @access private
     * @static
     */
    private static $project = 'project';

    /**
     * Cliprz framework call properties
     *
     *  string key 'models' Use a model
     *   string value 'model' Model object name prefix
     *  string key 'libraries' Use a library
     *   string value 'library' Library object name prefix
     *  string key 'system' Use a model
     *   string value 'cliprz' Model object name prefix
     *
     * @var array
     * @access private
     * @static
     */
    private static $_call    = array(
        'models'    => 'model',
        'libraries' => 'library',
        'system'    => 'cliprz'
    );

    /**
     * Cliprz constructor
     *
     * @access public
     */
    public function __construct ()
    {
        /**
         * Call error object
         */
        self::call('error','errors');

        /**
         * Call security object
         */
        self::call('security','security');

        /**
         * Call config object
         */
        self::call('config','configuration');

        /**
         * Call language object
         */
        self::call('language','languages');

        /**
         * Call file object
         */
        self::call('file','files');

        /**
         * Call encrypt object
         */
        self::call('encrypt','encryption');

        /**
         * Call cache object
         */
        self::call('cache','cache');

        /**
         * Call views object
         */
        self::call('view','views');

        /**
         * Call URI object
         */
        self::call('uri','router');

        /**
         * Call router object
         */
        self::call('router','router');

        /**
         * Call http object
         */
        self::call('http','http');

        /**
         * Call string object
         */
        self::call('string','strings');

        /**
         * Call validate object
         */
        self::call('validate','validation');

        /**
         * Call session object
         */
        self::call('session','sessions');

        /**
         * Call core constants
         */
        self::constants();

        /**
         * Call database object
         */
        if (self::system('config')->get('database','connect') === TRUE)
        {
            self::call('database','databases');
            self::system('database')->connect();
            self::system('database')->select_db();
            self::system('database')->set_charset();
        }
    }

    /**
     * Singleton
     *
     * Creates and gives a new Cliprz instance and keeps a record of it
     *
     * @access public
     * @static
     */
    public static function get_instance ()
    {
        $obj = (function_exists('get_called_class')) ? get_called_class() : __CLASS__;

        if (!isset(self::$_instances))
        {
            $class = (string) $obj;
            self::$_instances = new $class();
        }

        return self::$_instances;
    }

    /**
     * Call and use system, models and libraries objects
     *
     * @param string $class     The object name
     * @param string $directory The folder that contains the object
     * @param string $from      From where you have 3 options
     *                           string 'system'    Load as system object
     *                           string 'models'    Load as model object
     *                           string 'libraries' Load as library object
     *                          As default Load as 'system'
     *
     * @access public
     * @static
     */
    public static function call ($class,$directory,$from='system')
    {

        if (array_key_exists($from,self::$_call))
        {
            $path   = NULL;
            $folder = NULL;

            if ($directory != '')
            {
                $folder = self::rds($directory,'both').DS;
            }

            /**
             * Check $from param.
             */
            if ($from == 'system')
            {
                $path   = SYSTEM_PATH.$folder.$class.EXT;
            }
            else if ($from == 'libraries')
            {
                $path   = SYSTEM_PATH.'libraries'.DS.$folder.$class.EXT;
            }
            else if ($from == 'models')
            {
                $path = PROJECT_PATH.$folder.$class.'.model'.EXT;
            }

            if (file_exists($path))
            {
                require_once $path;

                $obj = (string) mb_strtolower(self::$_call[$from].'_'.$class);

                if (class_exists($obj))
                {
                    self::$_objects[$obj] = new $obj();
                }
                else
                {
                    trigger_error($obj.' class not founded.');
                }
            }
            else
            {
                trigger_error($path.' file not founded.');
            }
        }
        else
        {
            trigger_error($from.' not indexed.');
        }
    }

    /**
     * Remove directory separator
     *
     * @param string $directory The directory that you want to remove directory separator from him
     * @param string $from      The place of directory separator that you want to remove
     *                           string 'right' Remove right directory separator if exists
     *                           string 'left'  Remove left directory separator if exists
     *                           string 'both'  Remove both directory separator if exists
     *
     * @access public
     * @static
     */
    public static function rds ($directory,$from='right')
    {
        if ($from == 'right')
        {
            return rtrim($directory,DS);
        }
        else if ($from == 'left')
        {
            return ltrim($directory,DS);
        }
        else if ($from == 'both')
        {
            return trim($directory,DS);
        }
        else
        {
            return $directory;
        }
    }

    /**
     * Get system object
     *
     * @param string $class Object name
     *
     * @access public
     * @static
     */
    public static function system ($class)
    {
        return self::initialize ($class,'system');
    }

    /**
     * Get model object
     *
     * @param string $class Object name
     *
     * @access public
     * @static
     */
    public static function model ($class)
    {
        return self::initialize ($class,'models');
    }

    /**
     * Get library object
     *
     * @param string $class Object name
     *
     * @access public
     * @static
     */
    public static function library ($class)
    {
        return self::initialize ($class,'libraries');
    }


    /**
     * initializing objects to load
     *
     * @param string $class Object name.
     * @param string $call  Call properties
     *
     * @see self::$_call comment
     * @access private
     * @static
     */
    private static function initialize ($class,$call)
    {
        $key = mb_strtolower(self::$_call[$call].'_'.$class);

        if (is_object(self::$_objects[$key]))
        {
            return self::$_objects[$key];
        }
    }

    /**
     * Get all loaded objects
     *
     * @access public
     * @static
     */
    public static function all_objects ()
    {
        return (array) self::$_objects;
    }

    /**
     * Set framework system constants
     *
     * @access public
     * @static
     */
    public static function constants ()
    {
        // You can use URL to get project main URL as in example http://example.example/
        define('URL',self::rds(self::system('config')->get('project','url')).DS,TRUE);

        // Database prefix
        define('DATABASE_PREFIX',self::system('config')->get('database','prefix'),TRUE);
    }

}

/**
 * End of file cliprz.php
 *
 * @created  20/03/2013 05:05 am
 * @updated  03/04/2013 09:49 am
 * @location ./system/cliprz/cliprz.php
 */

?>
<?php

/**
 * Copyright :
 *  Cliprz model view controller framework.
 *  Copyright (C) 2012 - 2013 By Yousef Ismaeil.
 *
 * Framework information :
 *  Version 1.0.0 - Incomplete version for real use 7.
 *  Official website http://www.cliprz.org .
 *
 * File information :
 *  File path BASE_PATH/cliprz_system/cliprz/ .
 *  File name cliprz.php .
 *  Created date 17/10/2012 01:17 AM.
 *  Last modification date 29/12/2012 11:43 AM.
 *
 * Description :
 *  cliprz class is the main file that controls all system files and objects.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

class cliprz
{

    /**
     * @var (object) $_instances - The instance of the registry.
     * @access protected.
     */
    protected static $_instances;

    /**
     * @var (array) $_objects - our registry objects (this get system objects only).
     * @access protected.
     */
    protected static $_objects = array();

    /**
     * @var (array) $_libraries - your library objects (this get library objects only).
     * @access protected.
     */
    protected static $_libraries = array();

    /**
     * @var (string) $library_prefix - systen library classes prefix as in example 'library_'classname {};.
     * @access protected.
     */
    protected static $library_prefix = "library_";

    /**
     * Cliprz constructor.
     *
     * @access public.
     */
    #public function __construct() {}

    /**
     * singleton, Creates and gives a new Cliprz instance and keeps a record of it.
     *
     * @return Cliprz Instance.
     * @access public.
     */
    public static function get_instance ()
    {
        $call_class_name = (function_exists('get_called_class')) ? get_called_class() : __CLASS__;

        if (!isset(self::$_instances))
        {
            $class = (string) $call_class_name;
            self::$_instances = new $class();
        }

        return self::$_instances;
    }

    /**
     * load our system files to use.
     *
     * @param (string) $directory - The folder that contains the class without / ending.
     * @param (string) $class - class file name without .php extension, Please read the note below.
     * @return require path/class and start new class.
     * @access public.
     *
     * @note about $class variable file name in system directory must be same class name,
     *  do not forget all file names and class name in system must be lowercase characters,
     *  As an example : file name (cliprz.php), class name (cliprz).
     */
    public static function system_use($directory,$class)
    {
        $include_path = SYS_PATH.c_trim_path($directory).DS.$class.'.php';

        if (file_exists($include_path))
        {
            require_once $include_path;

            $controller_class = (string) strtolower(CLIPRZ.$class);

            //self::$_objects[$controller_class] = new $controller_class(self::$_instances);
            self::$_objects[$controller_class] = new $controller_class();
        }
        else
        {
            trigger_error($include_path.' not found in cliprz system path.');
        }
    }

    /**
     * get loaded system class.
     *
     * @param (string) $system_class - system class name.
     * @return loaded class.
     * @access public.
     */
    public static function system($system_class)
    {
        $key = strtolower(CLIPRZ.$system_class);

        if (is_object(self::$_objects[$key]))
        {
            return self::$_objects[$key];
        }
        else
        {
            trigger_error($key.' class not found in cliprz system.');
        }
    }

    /**
     * get cliprz configuration.
     *
     * @param (string) $key - the key in configuration ini file.
     * @access public.
     */
    public static function get_framework($key)
    {
        $output = null;

        $s = '&nbsp;';

        $configuration = null;

        $configuration_path = SYS_PATH.'configuration'.DS;

        if (file_exists($configuration_path.'cliprz.ini'))
        {
            $configuration = c_ini_data($configuration_path.'cliprz.ini');
        }

        if ($configuration == null)
        {
            trigger_error($configuration_path.'cliprz.ini not exists.');
        }
        else
        {
            switch ($key)
            {
                case 'name':
                    $output = (string) $configuration['name'];
                break;
                case 'version':
                    $output = (string) $configuration['version'];
                break;
                case 'ver':
                    $output = (integer) $configuration['ver'];
                break;
                case 'stability':
                    $output = (string) $configuration['stability'];
                break;
                case 'readable':
                    $output = (string) $configuration['name']
                        .$s
                        .'version'
                        .$s
                        .$configuration['version']
                        .$s
                        .$configuration['stability'];
                break;
                case 'under':
                    $output = (string) "Working under"
                        .$s
                        .'<a target="_blank" href="http://www.'.$configuration['website'].'/">'
                        .$configuration['name']
                        .'</a>'
                        .$s
                        .'environment.';
                break;
                case 'generator':
                    $output = (string) $configuration['name']." Version ".$configuration['version'];
                break;
                default:
                    $output = $configuration['name'];
                break;
            }
        }

        return $output;

    }
	
	/**
	 * Get Cliprz framework information.
	 *
	 * @access public.
	 */
	public static function info ()
	{
		self::system_use("cliprz/info/","info");
		self::system("info")->info();
	}
	
    /**
     * load your library file to use.
     *
     * @param (string) $directory - The folder that contains the main library class without / ending.
     * @param (string) $class - class file name without .php extension, Please read the note below.
     * @return require path/class and start new library class.
     * @access public.
     *
     * @note about $class variable file name in system library directory must be same class name,
     *  do not forget all file names and class name in system library must be lowercase characters,
     *  As an example : file name (cliprz.php), class name (cliprz).
     */
    public static function library_use($directory,$class)
    {
        $include_path = SYS_PATH."libraries".DS.c_trim_path($directory).DS.$class.'.php';

        if (file_exists($include_path))
        {
            require_once $include_path;

            $controller_class = (string) strtolower(self::$library_prefix.$class);

            self::$_libraries[$controller_class] = new $controller_class();
        }
        else
        {
            trigger_error($include_path.' library not found in cliprz system libraries.');
        }
    }

    /**
     * get loaded library class.
     *
     * @param (string) $library_class - library class name.
     * @return loaded library class.
     * @access public.
     */
    public static function library($library_class)
    {
        $key = strtolower(self::$library_prefix.$library_class);

        if (is_object(self::$_libraries[$key]))
        {
            return self::$_libraries[$key];
        }
        else
        {
            trigger_error($key.' class not found in cliprz system libraries.');
        }
    }

}

?>
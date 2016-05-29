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
 *  File path BASE_PATH/cliprz_system/cliprz/ .
 *  File name cliprz.php .
 *  Created date 17/10/2012 01:17 AM.
 *  Last modification date 12/02/2013 11:14 AM.
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

c_call_exception('cliprz','cliprz');

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
     * @var (string) $library_prefix - system library classes prefix as in example 'library_'classname {};.
     * @access protected.
     */
    protected static $library_prefix = "library_";

    /**
     * @var (array) $_models - model objects (this get model objects in cliprz_application models folder only).
     * @access protected.
     */
    protected static $_models = array();

    /**
     * @var (string) $model_prefix - models classes prefix as in example 'model_'classname {};.
     * @access protected.
     */
    protected static $model_prefix = "model_";

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
        try
        {
            if (file_exists($include_path))
            {
                require_once $include_path;

                $controller_class = (string) strtolower(CLIPRZ.'_'.$class);

                //self::$_objects[$controller_class] = new $controller_class(self::$_instances);
                self::$_objects[$controller_class] = new $controller_class();
            }
            else
            {
                throw new cliprz_exception($include_path.' not found in cliprz system path.');
            }
        }
        catch (cliprz_exception $e)
        {
            c_log_error($e);
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
        $key = strtolower(CLIPRZ.'_'.$system_class);
        try
        {
            if (is_object(self::$_objects[$key]))
            {
                return self::$_objects[$key];
            }
            else
            {
                throw new cliprz_exception($key.' class not found in cliprz system.');
            }
        }
        catch (cliprz_exception $e)
        {
            c_log_error($e);
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
                        .ucfirst($configuration['name'])
                        .'</a>'
                        .$s
                        .'framework.';
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
        try
        {
            if (file_exists($include_path))
            {
                require_once $include_path;

                $controller_class = (string) strtolower(self::$library_prefix.$class);

                self::$_libraries[$controller_class] = new $controller_class();
            }
            else
            {
                throw new cliprz_exception($include_path.' library not found in cliprz system libraries.');
            }
        }
        catch (cliprz_exception $e)
        {
            c_log_error($e);
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
        try
        {
            if (is_object(self::$_libraries[$key]))
            {
                return self::$_libraries[$key];
            }
            else
            {
                throw new cliprz_exception($key.' class not found in cliprz system libraries.');
            }
        }
        catch (cliprz_exception $e)
        {
            c_log_error($e);
        }
    }

    /**
     * Check is library loaded.
     *
     * @param (string) $library - Library name without library_ prefix.
     * @access public.
     */
    public static function is_library_loaded ($library)
    {
        return (bool) (isset(self::$_libraries[self::$library_prefix.$library]) && is_object(self::$_libraries[self::$library_prefix.$library]) ? true : false);
    }

    /**
     * Load model form cliprz_application models folder.
     *
     * @param (string) $model - class file name without .php extension, Please read the note below.
     * @param (string) $directory - The folder that contains the class without / ending.
     * @return require path/class and start new model class.
     * @access protected.
     *
     * @note about $model variable file name in cliprz_application models directory must be same class name,
     *  do not forget all file names and class name in cliprz_application models must be lowercase characters,
     *  As an example : file name (cliprz.php), class name (cliprz).
     */
    final public static function model_use ($model,$directory='')
    {
        $model_path = APP_PATH.'models'.DS.c_trim_path($directory).$model.'.php';
        try
        {
            if (file_exists($model_path))
            {
                require_once $model_path;

                $model_class = (string) strtolower(self::$model_prefix.$model);

                self::$_models[$model_class] = new $model_class();
            }
            else
            {
                throw new cliprz_exception($model.' not found.');
            }
        }
        catch (cliprz_exception $e)
        {
            c_log_error($e);
        }
    }

    /**
     * Get loaded model class.
     *
     * @param (string) $model_class - model class name.
     * @return loaded model class.
     * @access public.
     */
    public static function model($model_class)
    {
        $key = strtolower(self::$model_prefix.$model_class);
        try
        {
            if (is_object(self::$_models[$key]))
            {
                return self::$_models[$key];
            }
            else
            {
                throw new cliprz_exception($key.' class not found in models folder.');
            }
        }
        catch (cliprz_exception $e)
        {
            c_log_error($e);
        }
    }

}

?>
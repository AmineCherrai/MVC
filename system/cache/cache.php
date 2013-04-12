<?php

/**
 * Cliprz framework
 *
 * Color your project, An open source application development framework for PHP 5.3.0 or newer
 *
 * cache object
 *
 * LICENSE: This program is released as free software under the Affero GPL license. You can redistribute it and/or
 * modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 * at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 * written permission from the original author(s)
 *
 * @package    Cliprz
 * @category   system
 * @author     Albert Negix <negix@cliprz.org>
 * @copyright  Copyright (c) 2012 - 2013, Cliprz Developers team
 * @license    http://www.cliprz.org/licenses/agpl
 * @link       http://www.cliprz.org
 * @since      Version 2.0.0
 */

class cliprz_cache
{

    /**
     * Create a new cache file
     *
     * @param string  $filename  File name with full path in views
     * @param array   $data      File data
     * @param integer $cache_time Cache expiration time as minutes
     *
     * @access public
     * @static
     */
    public static function create($filename,$data=NULL,$cache_time=NULL)
    {
        if (file_exists($filename))
        {
            $cache_folder   = CACHE_PATH.'views'.DS.self::get_last_path_segment($filename).DS;

            $cache_name     = $cache_folder.self::get_real_file_name($filename).'.html';

            // Check dir
            if (is_dir($cache_folder))
            {
                self::conditions($filename,$cache_name,$data,$cache_time);
            }
            else
            {
                if (mkdir($cache_folder,0777,TRUE))
                {
                    self::conditions($filename,$cache_name,$data,$cache_time);
                }
                else
                {
                    trigger_error('Can not create '.$cache_folder.' Folder');
                }
            }
        }
        else
        {
            trigger_error('You are call a bad file path '.$filename);
        }
    }

    /**
     * Create a output buffering cache file
     *
     * @param string $cache_name Cache file name
     * @param array  $data       Cache file data from view object
     *
     * @access private
     * @static
     */
    private static function ob_cache ($filename,$cache_name,$data=NULL)
    {
        ob_start();

        if (is_array($data))
        {
            extract($data);
        }

        include $filename;

        file_put_contents($cache_name,ob_get_contents());

        ob_end_clean();
    }

    /**
     * Create cache file conditions
     *
     * @param string  $filename   File name with full path in views
     * @param string  $cache_name Cache file name with current path
     * @param array   $data       File data
     * @param integer $cache_time Cache expiration time as minutes
     *
     * @access private
     * @static
     */
    private static function conditions ($filename,$cache_name,$data=NULL,$cache_time=NULL)
    {

        $expiration_time = (is_null($cache_time)) ? (int) cliprz::system('config')->get('cache','time') : (int) $cache_time;

        if (file_exists($cache_name) && (filemtime($cache_name) < filemtime($filename)))
        {
            self::ob_cache($filename,$cache_name,$data);
            include $cache_name;
        }
        else if (file_exists($cache_name) && (time() - $expiration_time < filemtime($cache_name)))
        {
            include $cache_name;
        }
        else
        {
            self::ob_cache($filename,$cache_name,$data);
            include $cache_name;
        }
    }

    /**
     * Get Real file name
     *
     * @param string $filename File name with full path
     *
     * @access private
     * @static
     */
    private static function get_real_file_name ($filename)
    {
        $file      =  pathinfo($filename);
        return (string) str_ireplace('.view.php','',$file['basename']);
    }

    /**
     * get last path segment to create a cache folder
     *
     * @param string $filename File name with full path
     *
     * @private static
     * @static
     */
    private static function get_last_path_segment($filename)
    {
        $path = parse_url($filename, PHP_URL_PATH);

        $path_trimmed = trim($path, '/');

        $path_tokens = explode('/', $path_trimmed);

        if (substr($path, -1) !== '/')
        {
            array_pop($path_tokens);
        }

        return end($path_tokens);
    }

}

/**
 * End of file cache.php
 *
 * @created  25/03/2013 02:07 pm
 * @updated  12/04/2013 04:10 am
 * @location ./system/cache/cache.php
 */

?>
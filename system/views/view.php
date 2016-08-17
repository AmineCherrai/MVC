<?php

/**
 * Cliprz framework
 *
 * Color your project, An open source application development framework for PHP 5.3.0 or newer
 *
 * View and assets object
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

class cliprz_view
{

    /**
     * Assets folder name
     *
     * @var string assets
     *
     * @access private
     * @static
     */
    private static $assets = 'assets';

    /**
     * Display a page
     *
     * @param string  $filename   File name in ./application/project folder without .view.php
     * @param array   $data       File inserted data
     * @param boolean $cache      Use caching system
     * @param integer $cache_time Cache expiration time as minutes
     *
     * @access public
     * @static
     */
    public static function display ($filename,$data=NULL,$cache=FALSE,$cache_time=NULL)
    {
        $file = PROJECT_PATH.cliprz::rds($filename,'both').'.view'.EXT;

        if (file_exists($file))
        {
            if (!is_null($data))
            {
                extract($data);
            }

            if ($cache === TRUE)
            {
                cliprz::system('cache')->create($file,$data,$cache_time);
            }
            else
            {
                /* Removed by Negix
                ob_start();
                include_once $file;
                $contents = ob_get_contents();
                ob_end_clean();
                echo $contents;
                */
                include_once $file;
            }
        }
        else
        {
            exit($file.' not founded in views');
        }
    }

    /**
     * Get some files from assets
     *
     * @param string $file File name with full path inside assets
     *
     * @access public
     * @static
     */
    public static function assets ($file)
    {
        return (string) URL.self::$assets.DS.$file;
    }

    /**
     * Get image from assets folder
     *
     * @param string $img Image name with full path inside assets folder
     *
     * @access public
     * @static
     */
    public static function image ($img)
    {
        return self::assets('images'.DS.$img);
    }

    /**
     * Get javascript file from assets folder
     *
     * @param string $js Javascript file name with full path inside assets folder
     *
     * @access public
     * @static
     */
    public static function javascript ($js)
    {
        return self::assets('javascript'.DS.$js);
    }

    /**
     * Get CSS file from assets folder
     *
     * @param string $css CSS file name with full path inside assets folder
     *
     * @access public
     * @static
     */
    public static function css ($css)
    {
        return self::assets('css'.DS.$css);
    }

}

/**
 * End of file view.php
 *
 * @created  20/03/2013 01:43 pm
 * @updated  01/04/2013 06:11 pm
 * @location ./system/views/view.php
 */

?>
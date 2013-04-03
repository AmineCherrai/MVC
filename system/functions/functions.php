<?php

/**
 * Cliprz framework
 *
 * Color your project, An open source application development framework for PHP 5.3.0 or newer
 *
 * Our functions
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

if (!function_exists('assets'))
{
    /**
     * Get some files from assets
     *
     * @param string $file File name with full path inside assets
     */
    function assets ($file)
    {
        return cliprz::system('view')->assets($file);
    }
}

if (!function_exists('image'))
{
    /**
     * Get image from assets folder
     *
     * @param string $img Image name with full path inside assets folder
     */
    function image ($img)
    {
        return cliprz::system('view')->image($img);
    }
}

if (!function_exists('img'))
{
    /**
     * @see image()
     *
     * @param string $img Image name with full path inside assets folder
     */
    function img ($img)
    {
        return image($img);
    }
}

if (!function_exists('javascript'))
{
    /**
     * Get javascript file from assets folder
     *
     * @param string $js Javascript file name with full path inside assets folder
     */
    function javascript ($js)
    {
        return cliprz::system('view')->javascript($js);
    }
}

if (!function_exists('js'))
{
    /**
     * @see javascript()
     *
     * @param string $js Javascript file name with full path inside assets folder
     */
    function js ($js)
    {
        return javascript($js);
    }
}

if (!function_exists('css'))
{
    /**
     * Get CSS file from assets folder
     *
     * @param string $css CSS file name with full path inside assets folder
     */
    function css ($css)
    {
        return cliprz::system('view')->css($css);
    }
}

if (!function_exists('lang'))
{
    /**
     * Get a language array
     *
     * @param string $key       array key
     * @param array $replacing  Replacing words as in example array('{name}'=>'Yousef') so any word in lang variable that have {name} will replaced to Yousef
     */
    function lang ($key,$replacing=NULL)
    {
        return cliprz::system('language')->lang($key,$replacing);
    }
}

if (!function_exists('remove_base_path'))
{
    /**
     * Remove BASE_PATH constant from chosen path
     *
     * @param string $path path
     */
    function remove_base_path($path)
    {
        return str_ireplace(BASE_PATH,NULL,$path);
    }
}

if (!function_exists('pre_print_r'))
{
    /**
     * Print array with HTML pre tag
     *
     * @param array $array
     */
    function pre_print_r ($array)
    {
        if (is_array($array))
        {
            echo '<pre>';
            print_r($array);
            echo '</pre>';
        }
        else
        {
            var_dump($array);
        }
    }
}

/**
 * End of file functions.php
 *
 * @created  22/03/2013 11:18 pm
 * @updated  02/04/2013 07:29 pm
 * @location ./system/functions/functions.php
 */

?>
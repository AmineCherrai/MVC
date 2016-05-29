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
 *  File path BASE_PATH/cliprz_system/css/ .
 *  File name css.php .
 *  Created date 11/12/2012 02:41 PM.
 *  Last modification date 16/01/2013 11:38 PM.
 *
 * Description :
 *  CSS class.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

class cliprz_css
{

    /**
     * @var (string) $ext - Minified css file extension.
     * @access protected.
     */
    #protected static $ext = ".min.css";

    /**
     * @var (array) $_font_weight - font weight names and numbers.
     * @access protected.
     */
    protected static $_font_weight = array(
        "lighter" => 100,
        "normal"  => 400,
        "bold"    => 700,
        "bolder"  => 900);

    /**
     * @var (string) $min - Minified folder (inside public/css path).
     * @access protected.
     */
    protected static $min = "min";

    /**
     * Get CSS folder path.
     *
     * @access public.
     */
    public static function path ()
    {
        return PUBLIC_PATH."css".DS;
    }

    /**
     * Load css file from public/css folder and get contents.
     *
     * @param (string) $filename - css file name in public folder without (public/css) path.
     * @access protected.
     */
    protected static function load ($filename)
    {
        $path = self::path().$filename;

        if (file_exists($path))
        {
            $contents = c_file_get_contents($path);
            return $contents;
        }
        else
        {
            trigger_error($path." file not exists in ".self::path());
        }
    }

    /**
     * Remove tabs, spaces, newlines, etc.
     *
     * @param (string) $filecontents - file contents.
     * @access protected.
     */
    protected static function remove_spacing($filecontents)
    {
        $contents = str_ireplace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '),"",$filecontents);
        return $contents;
    }

    /**
     * Compress CSS file.
     *
     * @param (string) $filecontents - file contents.
     * @access protected.
     */
    protected static function compress ($filecontents)
    {

        $search  = array(
            "!/\*[^*]*\*+([^/][^*]*\*+)*/!", // Remove comments
            "/url\(['\"](.*?)['\"]\)/s",     // Remove quotes from urls
            "/(\s+)?([,{};:>\+])(\s+)?/s",   // Remove un-needed spaces around special characters
            "/\s+/s"                         // Compress all spaces into single space
        );
        $replace = array(
            "",
            "url($1)",
            "$2",
            " "
        );

        $replacement = preg_replace($search,$replace,$filecontents);

        $remove_spacing = self::remove_spacing($replacement);

        $trim = trim($remove_spacing);

        $contents = $trim;

        return $contents;

    }

    /**
     * Initializing compressing.
     *
     * @param (string)
     * @access protected.
     */
    protected static function initializing ($filename)
    {
        $cssfile     = self::load($filename);

        $min_dir = self::path().c_trim_path(self::$min).DS;

        if (c_mkdir($min_dir))
        {

            $new_file    = $min_dir.$filename;
            $contents    = self::compress($cssfile);

            if (!file_exists($new_file))
            {
                file_put_contents($new_file,$contents);
            }

            if (!file_exists($min_dir.'index.php'))
            {
                file_put_contents($min_dir."index.php","");
            }

        }
    }

    /**
     * CSS style url.
     *
     * @param (string) $filename - file name.
     * @param (boolean) $compress - Compress CSS file.
     * @access public.
     */
    public static function style ($filename,$compress=false)
    {
        if (file_exists(self::path().$filename))
        {
            if ($compress == true)
            {
                self::initializing($filename);
                return c_url("public".DS."css".DS.c_trim_path(self::$min).DS.$filename);
            }
            else
            {
                return c_url("public".DS."css".DS.$filename);
            }
        }
    }

    /**
     * Convert HEX color to RGB color.
     *
     * @param (string) $hex - Hex Color.
     * @access public.
     */
    public static function hex2rgb($hex)
    {
        $hex = str_replace("#", "", $hex);
        $color = array();

        if(mb_strlen($hex) == 3)
        {
            $color['r'] = hexdec(mb_substr($hex, 0, 1) . $r);
            $color['g'] = hexdec(mb_substr($hex, 1, 1) . $g);
            $color['b'] = hexdec(mb_substr($hex, 2, 1) . $b);
        }
        else if(mb_strlen($hex) == 6)
        {
            $color['r'] = hexdec(mb_substr($hex, 0, 2));
            $color['g'] = hexdec(mb_substr($hex, 2, 2));
            $color['b'] = hexdec(mb_substr($hex, 4, 2));
        }

        return $color;
    }

    /**
     * Convert RGB color to HEX color.
     *
     * @param (string) $r - red.
     * @param (string) $g - green.
     * @param (string) $b - blue.
     * @access public.
     */
    public static function rgb2hex($r, $g, $b)
    {
        $hex = "#";
        $hex.= str_pad(dechex($r), 2, "0", STR_PAD_LEFT);
        $hex.= str_pad(dechex($g), 2, "0", STR_PAD_LEFT);
        $hex.= str_pad(dechex($b), 2, "0", STR_PAD_LEFT);

        return $hex;
    }

}

?>
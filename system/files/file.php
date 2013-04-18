<?php

/**
 * Cliprz framework
 *
 * Color your project, An open source application development framework for PHP 5.3.0 or newer
 *
 * Handling Files object
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

class cliprz_file
{

    /**
     * Convert measurement unit to bytes
     *
     * @param integer $value file size
     *
     * @access public
     * @static
     */
    public static function str2bytes($value)
    {
        $value = trim($value);
        $last  = mb_strtolower($value[strlen($value)-1]);

        switch($last)
        {
            // The 'G' modifier is available since PHP 5.1.0
            case 'g':
            $value *= 1024;
            case 'm':
            $value *= 1024;
            case 'k':
            $value *= 1024;
        }

        return $value;
    }

    /**
     * Convert bytes to measurement unit
     *
     * @param integer $size  size
     * @param boolean $round round
     *
     * @access public
     * @static
     */
    public static function bytes2str($size, $round = 0)
    {
        $unit = array('','K','M','G','T','P','E','Z','Y');

        while($size >= 1000)
        {
            $size /= 1024;
            array_shift($unit);
        }

        return round($size, $round) . array_shift($unit) . 'B';
    }

    /**
     * Deletes a file with checking
     *
     * @param string $filename Path to the file
     *
     * @access public
     * @static
     */
    public static function delete ($filename)
    {
        if (file_exists($filename))
        {
            return (boolean) ((unlink($filename)) ? TRUE : FALSE);
        }
    }

    /**
     * Move file from current directory to another
     *
     * @param string  $current_file current full path file
     * @param string  $move_to      Full path to new directory you want to move file for him
     * @param boolean $unlink       do you want to delete old $current_file After ending processing, By default true delete the $current_file
     */
    public static function move ($current_file,$move_to,$unlink=TRUE)
    {
        if (file_exists($current_file))
        {
            if (!file_exists($move_to))
            {
                if ($unlink === TRUE)
                {
                    return rename($current_file,$move_to);
                }
                else
                {
                    return copy($current_file,$move_to);
                }
            }
        }
    }

}

/**
 * End of file file.php
 *
 * @created  02/04/2013 05:35 pm
 * @updated  19/04/2013 12:12 am
 * @location ./system/files/file.php
 */

?>

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
 *  File path BASE_PATH/cliprz_system/functions/ .
 *  File name filesystem.functions.php .
 *  Created date 17/10/2012 01:56 AM.
 *  Last modification date 21/01/2013 08:02 AM.
 *
 * Description :
 *  Cliprz Filesystem Functions.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

if (!function_exists('c_ini_data'))
{
    /**
     * Parse a configuration file to array.
     *
     * @param (string) $filename - The filename of the ini file being parsed, With .ini extension.
     * @param (string) $process_sections - By setting the process_sections parameter to TRUE,
     *  you get a multidimensional array, with the section names and settings included.
     *  The default for process_sections is FALSE.
     * @return The settings are returned as an associative array on success, and FALSE on failure.
     */
    function c_ini_data($filename,$process_sections=false)
    {

        if (file_exists($filename))
        {
            $output = parse_ini_file($filename,$process_sections);
            return (array) $output;
        }
        else
        {
            trigger_error("c_ini_data function error : ".$filename.' configuration file not found.');
        }

    }
}

if (!function_exists('c_file_get_contents'))
{
    /**
     * Reads entire file into a string.
     *
     * @param (string) $filename - file name and path.
     */
    function c_file_get_contents ($filename)
    {
        if (file_exists($filename))
        {
            if (function_exists('file_get_contents'))
            {
                $contents = file_get_contents($filename);
                return $contents;
            }
            else
            {
                $handle =  fopen($filename,'r');
                $contents = fread($handle,filesize($filename));
                fclose($handle);
                return $contents;
            }
        }
        else
        {
            trigger_error("c_file_get_contents function error : ".$filename." not exists.");
        }
    }
}

if (!function_exists('c_file_put_contents'))
{
    /**
     * Write a string to a file.
     *
     * @param (string) $filename - Path to the file where to write the data.
     * @param (mixed) $data - The data to write. Can be either a string, an array or a stream resource.
     * @param (mixed) $flags - The value of flags can be any combination of the following flags,
     *  joined with the binary OR (|) operator.
     */
    function c_file_put_contents ($filename,$data,$flags=null)
    {
        if (function_exists('file_put_contents'))
        {
            if ($flags == null)
            {
                file_put_contents($filename,$data);
            }
            else
            {
                file_put_contents($filename,$data,$flags);
            }
        }
        else
        {
            trigger_error("Your PHP version dose not support file_put_contents() function.");
        }
    }
}

if (!function_exists('c_mkdir'))
{
    /**
     * Makes directory with no errors.
     *
     * @param (string) $pathname - The directory path.
     * @param (integer) $mode - The mode is 0777 by default, which means the widest possible access.
     * @param (boolean) $recursive - Allows the creation of nested directories specified in the $pathname.
     * @return to TRUE on success or FALSE on failure.
     */
    function c_mkdir($pathname,$mode=0777,$recursive=false)
    {
        if (!is_dir($pathname))
        {
            if (mkdir($pathname,$mode,$recursive))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return true;
        }
    }
}

if (!function_exists('c_all_files'))
{
    /**
     * View all files from specified path.
     *
     * @param (string) $path - Path name.
     * @author Vidmantas Norkus.
     * @return as array.
     */
    function c_all_files($path)
    {
        $files = array();

        $file_tmp= glob($path.'*',GLOB_MARK | GLOB_NOSORT);

        foreach($file_tmp as $item)
        {
            if(substr($item,-1) != DIRECTORY_SEPARATOR)
            {
                $files[] = $item;
            }
            else
            {
                $files = array_merge($files,c_all_files($item));
            }
        }

        return (array) $files;
    }
}

?>
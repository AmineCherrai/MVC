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
 *  File path BASE_PATH/cliprz_system/functions/ .
 *  File name filesystem.functions.php .
 *  Created date 17/10/2012 01:56 AM.
 *  Last modification date 14/02/2013 04:07 PM.
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
        try
        {
            if (file_exists($filename))
            {
                $output = parse_ini_file($filename,$process_sections);
                return (array) $output;
            }
            else
            {
                throw new Exception (__FUNCTION__.'() function error : '.$filename.' configuration file not found.');
            }
        }
        catch (Exception $e)
        {
            c_log_error($e);
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
        try
        {
            if (file_exists($filename))
            {
                $contents = file_get_contents($filename);
                return $contents;
            }
            else
            {
                throw new Exception (__FUNCTION__.'() function error : '.$filename.' not exists.');
            }
        }
        catch (Exception $e)
        {
            c_log_error($e);
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
        if ($flags == null)
        {
            file_put_contents($filename,$data);
        }
        else
        {
            file_put_contents($filename,$data,$flags);
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

if (!function_exists('c_create_index'))
{
    /**
     * Create index.php file in Chosen path.
     *
     * @param (string) $path - Chosen path.
     */
    function c_create_index ($path)
    {
        try
        {
            if (is_dir($path) && is_writeable($path))
            {
                if (!file_exists($path.'index.php'))
                {
                    c_file_put_contents($path.'index.php',"");
                }
            }
            else
            {
                throw new Exception ('Cannot find '.$path.' so we can not create index.php inside chosen path');
            }
        }
        catch (Exception $e)
        {
            c_log_error($e);
        }
    }
}

if (!function_exists('c_move_file'))
{
    /**
     * Move file from current directory to another.
     *
     * @param (string) $current_file - current full path file.
     * @param (string) $move_to - Full path to new directory you want to move file for him.
     * @param (boolean) $unlink - do you want to delete old $current_file After ending processing, By default true delete the $current_file.
     */
    function c_move_file ($current_file,$move_to,$unlink=true)
    {
        if (file_exists($current_file))
        {
            if (!file_exists($move_to))
            {
                if ($unlink == true)
                {
                    if (rename($current_file,$move_to))
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
                    if (copy($current_file,$move_to))
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                }
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }
}

if (!function_exists('c_str2bytes'))
{
    /**
     * Convert measurement unit to bytes.
     *
     * @param (integer) $val - file size.
     */
    function c_str2bytes($value)
    {
        $value = trim($value);
        $last  = strtolower($val[strlen($val)-1]);

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
}

if (!function_exists('c_bytes2str'))
{
    /**
     * Convert bytes to measurement unit.
     *
     * @param (integer) $val - size.
     * @param (boolean) $round.
     */
    function c_bytes2str($size, $round = 0)
    {
        $unit = array('','K','M','G','T','P','E','Z','Y');

        while($size >= 1000)
        {
            $size /= 1024;
            array_shift($unit);
        }

        return round($size, $round) . array_shift($unit) . 'B';
    }
}

if (!function_exists('c_delete_file'))
{
    /**
     * Deletes a file with checking.
     *
     * @param (string) $filename - Path to the file.
     */
    function c_delete_file ($filename)
    {
        if (file_exists($filename))
        {
            if (unlink($filename))
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
            return false;
        }
    }
}

if (!function_exists('c_is_rw'))
{
    /**
     * Check folder is writeable and readable.
     *
     * @param (string) $folder - Folder name.
     */
    function c_is_rw ($folder)
    {
        return (bool) ((is_readable($folder) && is_writeable($folder)) ? true : false);
    }
}

?>
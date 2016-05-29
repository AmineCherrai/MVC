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
 *  File name error_handling.functions.php .
 *  Created date 17/10/2012 03:01 AM.
 *  Last modification date 10/02/2013 11:25 AM.
 *
 * Description :
 *  Cliprz error handling Functions.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

/**
 * Check if environment is development and display errors.
 *
 * @return void;
 */
function c_set_reporting()
{
    if (C_DEVELOPMENT_ENVIRONMENT == true)
    {
        error_reporting(E_ALL);
        ini_set('display_errors','On');
        ini_set('log_errors', 'On');
        // ini_set('error_log', 'error_log');
        ini_set('error_log', APP_PATH.'logs'.DS.'error_log.txt');
    }
    else
    {
        // error_reporting (E_ERROR | E_WARNING | E_PARSE);
        error_reporting(E_ALL);
        ini_set('display_errors','Off');
        ini_set('log_errors', 'On');
		ini_set('error_log', APP_PATH.'logs'.DS.'error_log.txt');
    }
}

c_set_reporting();

/**
 * Handling Cliprz log errors.
 *
 * @param (object) $e     - Exception catch errors.
 * @param (object) $level - Error level by default error.
 * @author Albert Negix.
 */
function c_log_error ($e,$level='ERROR')
{
    $logs_file = APP_PATH.'logs'.DS.'cliprz_error_log.txt';

    $time = date("[d/M/Y:H:i:s A]").' ';

    $trace = $e->getTrace();

    $log_content = PHP_EOL;
    $log_content .= $time;
    $log_content .= 'CLIPRZ_'.$level.' : '.$e->getMessage();
    $log_content .= ' in "'.$trace[0]['file'].'" line ('.$trace[0]['line'].')';

    if (file_exists($logs_file))
    {
        file_put_contents($logs_file,$log_content,FILE_APPEND);
    }
    else
    {
        file_put_contents($logs_file,$log_content);
    }

    unset($log_content,$time);

    if (C_DEVELOPMENT_ENVIRONMENT)
    {
        $style = 'padding: 10px; font-family: Consolas, Monaco, Courier, monospace; font-size: 12px;';
        $style .= ' width: 700px; background: #FBFBFB; margin: 2px auto;';
        echo '<div style="'.$style.'">';
        echo '<strong>CLIPRZ_'.$level.' : </strong>'.$e->getMessage();
        echo '<br />In File '.$trace[0]['file'].'';
        echo '<br />line ('.$trace[0]['line'].')';
        echo '</div>';

        unset($style);

        if ($level == 'WARNING')
        {
            exit();
        }
    }
}

/**
 * Call a exception from system path.
 *
 * @param (string) $filename - Exception file name.
 * @param (string) $path     - Exception path.
 * @author Albert Negix.
 */
function c_call_exception ($filename,$path)
{
    $path = SYS_PATH.$path.DS.'exceptions'.DS.$filename.'_exception.php';
    try
    {
        if (file_exists($path))
        {
            include $path;
        }
        else
        {
            throw new Exception (__FUNCTION__.'(); Cannot call '.$path);
        }
    }
    catch (Exception $e)
    {
        c_log_error($e);
    }
}

?>
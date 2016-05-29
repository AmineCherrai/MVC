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
 *  File path BASE_PATH/cliprz_system/console/ .
 *  File name execute.php .
 *  Created date 30/01/2013 04:43 AM.
 *  Last modification date 30/01/2013 04:58 AM.
 *
 * Description :
 *  Execute class.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

class cliprz_execute
{

    /**
     * @var (string) $style - Style (CSS).
     * @access protected.
     */
    protected static $style = "
        text-align: center;
        text-align: center;
        padding: 5px;
        margin-top: 20px;
        color: #FFF;
        background-color: #990000;
        font-size: 11px;
        font-family: Consolas, Monaco, Courier, monospace;";

    /**
     * Get execute start time.
     *
     * @access protected.
     */
    protected static function get_start_time ()
    {
        if (defined('CLIPRZ_EXECUTE_START_TIME'))
        {
            return CLIPRZ_EXECUTE_START_TIME;
        }
    }

    /**
     * Get execute end time.
     *
     * @access protected.
     */
    protected static function get_end_time ()
    {
        if (defined('CLIPRZ_EXECUTE_END_TIME'))
        {
            return CLIPRZ_EXECUTE_END_TIME;
        }
    }

    /**
     * Calculate start and end of execution.
     *
     * @access protected.
     */
    protected static function calculate_execution ()
    {
        return round(self::get_end_time() - self::get_start_time(),3);
    }

    /**
     * Get Cliprz execution time.
     *
     * @access public.
     */
    public static function execution ()
    {
        global $_config;

        if ($_config['console']['execute'] === true && C_DEVELOPMENT_ENVIRONMENT == true)
        {
            echo '<div style="'.self::$style.'">Cliprz execution Time : '.self::calculate_execution().' seconds.</div>';
        }
    }

}

?>
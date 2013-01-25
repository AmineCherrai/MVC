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
 *  File path BASE_PATH/cliprz_system/sessions/ .
 *  File name session.php .
 *  Created date 01/12/2012 01:02 PM.
 *  Last modification date 16/01/2013 06:30 AM.
 *
 * Description :
 *  Sessions class.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

class cliprz_session
{

    /**
     * @var (string) $session_name - session name.
     * @access protected.
     */
    protected static $session_name = "CLIPRZCOOKIE";

    /**
     * Sessions constructor.
     *
     * @access public.
     */
    public function __construct()
    {
        global $_config;

        // Set new session name.
        if (isset($_config['session']['name']) && !empty($_config['session']['name']))
        {
            ini_set('session.name',strtoupper($_config['session']['name']));
        }
        else
        {
            ini_set('session.name',strtoupper(self::$session_name));
        }


        // gc_maxlifetime
        self::session_gc_configuration("gc_maxlifetime");

        // gc_probability
        self::session_gc_configuration("gc_probability");

        // gc_divisor
        self::session_gc_configuration("gc_divisor");

        // gc_maxlifetime
        self::session_gc_configuration("gc_maxlifetime");

        // session_start();

    }

    /**
     * Sessions gc configuration.
     *
     * @param (string) $gc - gc name.
     * @access protected.
     */
    protected static function session_gc_configuration ($gc)
    {
        global $_config;

        if (isset($_config['session'][$gc])
        && !empty($_config['session'][$gc])
        && is_integer($_config['session'][$gc]))
        {
            ini_set('session.'.$gc,$_config['session'][$gc]);
        }
    }

    /**
     * checking for session ID's if true with numbers and characters.
     *
     * @param (string) session id.
     * @access public.
     */
    public static function check_session($id)
    {
    	if (preg_match("/^[0-9a-z]+$/", $id))
        {
    		return $id;
    	}
        else
        {
    		return "";
    	}
    }

}

?>
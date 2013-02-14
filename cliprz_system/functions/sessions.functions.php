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
 *  File name sessions.functions.php .
 *  Created date 09/12/2012 01:50 AM.
 *  Last modification date 27/01/2013 09:03 PM.
 *
 * Description :
 *  Sessions functions.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

/**
 * @def (string) C_SESSION_PREFIX - session prefix.
 */
define("C_SESSION_PREFIX",$_config['session']['prefix'],true);

if (!function_exists('c_set_session'))
{
    /**
     * Set new session (cookie), this function get C_SESSION_PREFIX as prefix.
     *
     * @param (string) $key - session key.
     * @param (string) $key - session value.
     */
    function c_set_session ($key,$value)
    {
        $_SESSION[C_SESSION_PREFIX.$key] = $value;
    }
}

if (!function_exists('c_get_session'))
{
    /**
     * Get session value if exists.
     *
     * @param (string) $key - session key.
     */
    function c_get_session ($key)
    {
        return ((isset($_SESSION[C_SESSION_PREFIX.$key]))
            ? $_SESSION[C_SESSION_PREFIX.$key]
            : "Undefined session index '".$key."'.");
    }
}

if (!function_exists('c_is_session'))
{
    /**
     * Check is session exists.
     *
     * @param (string) $key - session key.
     */
    function c_is_session ($key)
    {
        return (bool) ((isset($_SESSION[C_SESSION_PREFIX.$key])) ? true : false);
    }
}

if (!function_exists('c_check_session'))
{
    /**
     * Checking for session ID's if true with numbers and characters.
     *
     * @param (string) session id.
     */
    function c_check_session($id)
    {
    	if (preg_match("/^[0-9a-z_.-]+$/i",$id))
        {
    		return true;
    	}
        else
        {
    		return false;
    	}
    }
}

if (!function_exists('c_session_destroy'))
{
    /**
     * Destroys all data registered to a session.
     *
     * @param (booelan) $regenerate_id - If TRUE system will Update the current session id with a newly generated one.
     */
    function c_session_destroy ($regenerate_id=true)
    {
        #unset($_SESSION);
        session_unset();
        session_destroy();

        if (is_bool($regenerate_id) && $regenerate_id == true)
        {
            session_regenerate_id();
        }
    }
}

?>
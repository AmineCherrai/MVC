<?php

/**
 * Cliprz framework
 *
 * Color your project, An open source application development framework for PHP 5.3.0 or newer
 *
 * Handling cookies and sessions object
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

class cliprz_session
{

    /**
     * Cookies default name
     *
     * @var string $session_name
     *
     * @access private
     * @static
     */
    private static $cookie_name = 'CLIPRZCOOKIE';

    /**
     * Session constructor.
     *
     * @access public.
     */
    public function __construct()
    {
        define('SESSION_PREFIX',cliprz::system('config')->get('session','prefix'),TRUE);

        self::cookie_name();

        self::handle();

        self::hijacking();
    }

    /**
     * Set session handle type
     *
     * @access private
     * @static
     */
    private static function handle ()
    {
        $handle = cliprz::system('config')->get('session','handle');

        if ($handle == 'files')
        {
            cliprz::call('session_handler','sessions');
        }
        else
        {
            session_start();
        }
    }

    /**
     * Change cookie name from php.ini
     *
     * @access private
     * @static
     */
    private static function cookie_name ()
    {
        // Get cookie name from config
        $conf_cookie_name = mb_strtoupper(cliprz::system('config')->get('session','name'));

        // Change cookies name from php.ini
        if (isset($conf_cookie_name) && !empty($conf_cookie_name))
        {
            ini_set('session.name',$conf_cookie_name);
        }
        else
        {
            ini_set('session.name',self::$cookie_name);
        }
    }

    /**
     * Set new session (cookie)
     *
     * @param string $key Session key
     * @param string $val Session value
     *
     * @access public
     * @static
     */
    public static function set ($key,$val)
    {
        $_SESSION[SESSION_PREFIX.$key] = $val;
    }

    /**
     * Get session value if exists
     *
     * @param string $key Session key
     *
     * @access public
     * @static
     */
    public static function get ($key)
    {
        return ((self::is_set($key)) ? $_SESSION[SESSION_PREFIX.$key] : 'Undefined session index '.$key);
    }

    /**
     * Check if session exists
     *
     * @param string $key Session key
     *
     * @return TRUE if session exists
     * @access public
     * @static
     */
    public static function is_set ($key)
    {
        return (boolean) ((isset($_SESSION[SESSION_PREFIX.$key])) ? TRUE : FALSE);
    }

    /**
     * Delete session data
     *
     * @param string $key Session key
     *
     * @access public
     * @static
     */
    public static function delete ($key)
    {
        if (self::is_set($key))
        {
            unset($_SESSION[SESSION_PREFIX.$key]);
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Destroys all data registered to a session
     *
     * @param boolean $regenerate_id If TRUE system will Update the current session id with a newly generated one
     *
     * @access public
     * @static
     */
    public static function destroy ($regenerate_id=TRUE)
    {
        session_unset();
        session_destroy();

        if ($regenerate_id === TRUE)
        {
            session_regenerate_id();
        }
    }

    /**
     * Protected Sessions from Hijacking
     *
     * @access private
     * @static
     */
    private static function hijacking ()
    {
        if (!self::is_set('hijacking_user_ip'))
        {
            self::set('hijacking_user_ip',cliprz::system('http')->ip());
        }
        else
        {
            if (self::get('hijacking_user_ip') != cliprz::system('http')->ip())
            {
                self::destroy();
            }
        }
    }

}

/**
 * End of file session.php
 *
 * @created  23/03/2013 09:30 am
 * @updated  12/04/2013 04:08 am
 * @location ./system/sessions/session.php
 */

?>
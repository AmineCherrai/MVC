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
 *  File path BASE_PATH/cliprz_system/sessions/ .
 *  File name session.php .
 *  Created date 01/12/2012 01:02 PM.
 *  Last modification date 02/02/2013 05:50 PM.
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

        self::handler();
        self::hijacking();
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
     * Handling sessions.
     *
     * @access protected.
     */
    protected static function handler ()
    {
        global $_config;

        if ($_config['session']['use_handler'] === true)
        {
            if (is_string($_config['session']['handler_type'])
            && $_config['session']['handler_type'] == 'files')
            {
                cliprz::system_use(session.'s',session.'_handler_files');
            }
            else if (is_string($_config['session']['handler_type'])
            && $_config['session']['handler_type'] == 'database')
            {
                // Get driver name
                $driver_name = strtolower($_config['db']['driver']);

                // Get session driver path
                $session_driver_path = 'databases'.DS.'drivers'.DS.$driver_name.DS;

                // Session object name.
                $session_object = $driver_name.'_session_handler';

                // Get full session handler path from cliprz_system/databases/drivers/{drivername}/drivername_session_handler.php
                $full_session_handler_path = SYS_PATH.$session_driver_path.$session_object.'.php';

                // Check if this driver have a session handler
                if (file_exists($full_session_handler_path))
                {
                    cliprz::system_use($session_driver_path,$session_object);
                }
                else // Or show error
                {
                    trigger_error(
                        $driver_name
                        .' Does not have a session handler.
                        the solution is replace $_config[\'session\'][\'handler_type\'] from database to files.'
                        ,E_WARNING);
                }
            }
            else
            {
                trigger_error(
                    "Sessions handler error,
                    Handler type must be files or database or you can close session handler",
                    E_WARNING);
            }
        }
        else
        {
            session_start();
        }
    }

    /**
     * Protected Sessions from Hijacking.
     *
     * @access protected.
     */
    protected static function hijacking ()
    {
        if (!c_is_session('hijacking_user_ip'))
        {
            c_set_session('hijacking_user_ip',c_get_ip());
        }
        else
        {
            if (c_get_session('hijacking_user_ip') != c_get_ip())
            {
                c_session_destroy (false);
            }
        }
    }

}

?>
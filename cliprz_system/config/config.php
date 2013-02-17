<?php

/**
 * Copyright :
 *  Cliprz model view controller framework.
 *  Copyright (C) 2012 - 2013 By Yousef Ismaeil.
 *
 * Framework information :
 *  Version 1.1.0 - Stability Stable.
 *  Official website http://www.cliprz.org .
 *
 * File information :
 *  File path BASE_PATH/cliprz_system/config/ .
 *  File name config.php .
 *  Created date 01/12/2012 07:15 AM.
 *  Last modification date 16/02/2013 03:31 PM.
 *
 * Description :
 *  Config class.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

class cliprz_config
{

    /**
     * @var (array) $kyes - Main Configuration array keys.
     * @access protected.
     */
    protected static $kyes = array(
        'db','output','language','datetime',
        'session','recaptcha','uri','console','cap');

    /**
     * @var (array) $config - Porject Configuration array.
     * @access protected.
     */
    protected static $config;

    /**
     * Conifg constructor.
     *
     * @access public.
     */
    public function __construct()
    {
        self::set();
    }

    /**
     * Set data to self::$config array.
     *
     * @access protected.
     */
    protected static function set ()
    {
        global $_config;

        if (is_array($_config))
        {
            // Foreach array main keys
            foreach (self::$kyes as $key)
            {
                // Check if key exists
                if (array_key_exists($key,$_config))
                {
                    // Loop $_config
                    foreach ($_config[$key] as $k => $v)
                    {
                        if (array_key_exists($k,$_config[$key]))
                        {
                            // Set self::$config
                            self::$config[$key][$k] = $v;
                        }
                    }
                }
            }
        }

        unset($_config);
    }

    /**
     * Get data from self::$config array.
     *
     * @param (string) $key     - Array main key.
     * @param (string) $sub_key - Array sub key.
     * @access public.
     */
    public static function get($key,$sub_key)
    {
        if (is_array(self::$config))
        {
            if (array_key_exists($key,self::$config))
            {
                if (array_key_exists($sub_key,self::$config[$key]))
                {
                    return self::$config[$key][$sub_key];
                }
            }
        }
    }

}

?>
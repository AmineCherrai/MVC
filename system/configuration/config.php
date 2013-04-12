<?php

/**
 * Cliprz framework
 *
 * Color your project, An open source application development framework for PHP 5.3.0 or newer
 *
 * Configuration object
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

class cliprz_config
{

    /**
     * Main Configuration array keys
     *
     * @var array $keys
     * @access private
     * @static
     */
    private static $keys = array(
        'database','project','session',
        'language','protocol','time'
    );

    /**
     * Porject Configuration array
     *
     * @var array $config
     * @access private
     * @static
     */
    private static $config;

    /**
     * Conifg constructor
     *
     * @access public
     */
    public function __construct()
    {
        self::set();
    }

    /**
     * Set data to self::$config array
     *
     * @access private
     * @static
     */
    private static function set ()
    {
        global $_config;

        if (is_array($_config))
        {
            // Foreach array main keys
            foreach (self::$keys as $key)
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
     * Get data from self::$config array
     *
     * @param string $key     Array main key
     * @param string $sub_key Array sub key
     *
     * @access public
     * @static
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

/**
 * End of file config.php
 *
 * @created  21/03/2013 03:31 pm
 * @updated  12/04/2013 04:08 am
 * @location ./system/configuration/config.php
 */

?>
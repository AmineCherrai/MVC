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
 *  File path BASE_PATH/cliprz_system/console/ .
 *  File name console.php .
 *  Created date 14/02/2013 04:14 PM.
 *  Last modification date 16/02/2013 05:48 PM.
 *
 * Description :
 *  Console class.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

class cliprz_console
{

    /**
     * @var (array) $_folders_errors - Folders errors.
     * @access protected.
     */
    protected static $_folders_errors = null;

    /**
     * Console constructor.
     *
     * @access public.
     */
    public function __construct()
    {
        self::check_rw_folders(self::app_folders());

        if (is_array(self::$_folders_errors) && !is_null(self::$_folders_errors))
        {
            foreach (self::$_folders_errors as $message)
            {
                echo $message.'<br />';
            }
            exit();
            // Unset self::$_folders_errors
            self::$_folders_errors = null;
        }
    }

    /**
     * Check main folders is writeable and readable (0777).
     *
     * @param (array) $folders - Folders as array.
     * @access protected.
     */
    protected static function check_rw_folders ($folders,$key='main')
    {
        if (is_array($folders))
        {
            foreach ($folders as $k => $f)
            {
                if (is_dir($f))
                {
                    if (!c_is_rw($f))
                    {
                        self::$_folders_errors[$key.'_'.$k] = $f.' Not writeable and readable.';
                    }
                }
                else
                {
                    self::$_folders_errors[$key.'_'.$k] = $f.' Not founded.';
                }
            }
        }
    }

    /**
     * Get Main cliprz application folders that want to check as array.
     *
     * @access protected.
     */
    protected static function app_folders ()
    {
        $folders = array();

        $folders[] = APP_PATH;
        $folders[] = APP_PATH.'config'.DS;
        $folders[] = APP_PATH.'controllers'.DS;
        $folders[] = APP_PATH.'cache'.DS;
        $folders[] = APP_PATH.'logs'.DS;

        if (cliprz::system(config)->get('session','use_handler') === true
        && cliprz::system(config)->get('session','handler_type') == 'files'
		&& is_dir(cliprz::system(config)->get('session','save_path')))
        {
            $folders[] = cliprz::system(config)->get('session','save_path');
        }

        if (is_dir(APP_PATH.'cache'.DS.'templates'.DS))
        {
            $folders[] = APP_PATH.'cache'.DS.'templates'.DS;
        }

        if (cliprz::system(config)->get('cap','enabled') === true)
        {
            $folders[] = APP_PATH.'capanel'.DS;
            $folders[] = APP_PATH.'controllers'.DS.'capanel'.DS;
        }

        return (array) $folders;
    }

}

?>
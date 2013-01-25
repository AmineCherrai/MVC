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
 *  File path BASE_PATH/cliprz_system/languages/ .
 *  File name language.php .
 *  Created date 20/12/2012 06:24 PM.
 *  Last modification date 20/01/2013 02:45 AM.
 *
 * Description :
 *  Languages class.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

$_lang   = array();

class cliprz_language
{

    /**
     * @var (string) $default_language - Default language.
     * @access protected.
     */
    protected static $default_language = "english";

    /**
     * @var (string) $language_file_prefix - Language file prefix.
     * @access protected.
     */
    protected static $language_file_prefix = ".lang.php";

    /**
     * Language constructor.
     *
     * @access public.
     */
    public function __construct()
    {
        global $_config;

        self::load_language($_config['language']['name']);

    }

    /**
     * This function will load all languages.
     *
     * @param (string) $language_name - Configurations language name.
     * @access protected.
     */
    protected static function load_language ($language_name)
    {

        global $_lang;

        $languages_path = APP_PATH."languages".DS.$language_name.DS;

        if (is_dir($languages_path))
        {

            // Check cliprz.lang.php
            $cliprz_language = $languages_path.'cliprz'.self::$language_file_prefix;

            if (file_exists($cliprz_language))
            {
                include_once $cliprz_language;
            }
            else
            {
                trigger_error($language_name." file not exists.");
            }

            // Load all languages files in this folder.
            $glob = (string) $languages_path."*".self::$language_file_prefix;

            unset($languages_path);

            self::call_language_package ($glob,$cliprz_language);

            unset($glob,$cliprz_language);

        }
        else
        {
            // If language does not exists get default language.
            $default_language_path = APP_PATH."languages".DS.self::$default_language.DS;

            if (is_dir($default_language_path))
            {

                // Check cliprz.lang.php
                $cliprz_language = $default_language_path.'cliprz'.self::$language_file_prefix;

                if (file_exists($cliprz_language))
                {
                    include_once $cliprz_language;
                }
                else
                {
                    trigger_error($language_name." file not exists.");
                }

                // Load all languages files in this folder.
                $glob = (string) $default_language_path."*".self::$language_file_prefix;

                unset($default_language_path);

                self::call_language_package ($glob,$cliprz_language);

                unset($glob,$cliprz_language);

            }
            else
            {
                trigger_error("language packages not exists.");
                exit();
            }

        }
    }

    /**
     * Call all language package.
     *
     * @param (string) $glob - The pattern. No tilde expansion or parameter substitution is done.
     * @param (string) $cliprz_language - The main language file called cliprz.lang.php.
     * @access protected.
     */
    protected static function call_language_package ($glob,$cliprz_language)
    {
        global $_lang;

        // $lf = language file
        foreach (glob($glob) as $package_files)
        {
            if ($package_files == $cliprz_language)
            {
                continue;
            }

            include_once $package_files;

            //echo $package_files.'<br />';
        }
    }

    /**
     * Get a language array.
     *
     * @param (string) $key - array key.
     * @access public.
     */
    public static function lang ($key)
    {
        global $_lang;
        return $_lang[$key];
    }

}

?>
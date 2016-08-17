<?php

/**
 * Cliprz framework
 *
 * Color your project, An open source application development framework for PHP 5.3.0 or newer
 *
 * Hanlding language files object
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
 * @since      Version 1.2.0
 */

$_lang   = array();

class cliprz_language
{

    /**
     * Default language
     *
     * @var string $default_language
     *
     * @access private
     * @static
     */
    private static $default_language = "english";

    /**
     * Language file prefix
     *
     * @var string $language_file_prefix
     *
     * @access private
     * @static
     */
    private static $language_file_prefix = ".lang.php";

    /**
     * Language constructor
     *
     * @access public
     */
    public function __construct()
    {
        self::load_language(cliprz::system('config')->get('language','name'));
    }

    /**
     * This function will load all languages
     *
     * @param string $language_name Configurations language name
     *
     * @access private
     * @static
     */
    private static function load_language ($language_name)
    {
        global $_lang;

        $languages_path = APPLICATION_PATH.'languages'.DS.$language_name.DS;

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
                trigger_error($language_name.' file not exists.');
            }

            // Load all languages files in this folder
            $glob = (string) $languages_path."*".self::$language_file_prefix;

            unset($languages_path);

            self::call_language_package ($glob,$cliprz_language);

            unset($glob,$cliprz_language);

        }
        else
        {
            // If language does not exists get default language
            $default_language_path = APPLICATION_PATH.'languages'.DS.self::$default_language.DS;

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
                    trigger_error($language_name.' file not exists.');
                }

                // Load all languages files in this folder
                $glob = (string) $default_language_path."*".self::$language_file_prefix;

                unset($default_language_path);

                self::call_language_package ($glob,$cliprz_language);

                unset($glob,$cliprz_language);

            }
            else
            {
                trigger_error('language packages not exists.');
            }

        }
    }

    /**
     * Call all language package
     *
     * @param string $glob            The pattern. No tilde expansion or parameter substitution is done
     * @param string $cliprz_language The main language file called cliprz.lang.php
     *
     * @access private
     * @static
     */
    private static function call_language_package ($glob,$cliprz_language)
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
     * Replace some data from language variable
     *
     * @param string $key       array key
     * @param array  $replacing Replacing words as array with keys, As in example array('{site}'=>'www.cliprz.org','{cliprz}'=>'Yousef Ismaeil').
     *
     * @access private
     * @static
     */
    private static function replace_to ($lang,$replacing)
    {
        $search  = array_keys($replacing);
        $replace = (array) $replacing;

        unset($replacing);

        return str_replace($search,$replace,$lang);
    }

    /**
     * Get a language array
     *
     * @param string $key       array key
     * @param array $replacing  Replacing words as in example array('{name}'=>'Yousef') so any word in lang variable that have {name} will replaced to Yousef
     *
     * @access public
     * @static
     */
    public static function lang ($key,$replacing=NULL)
    {
        global $_lang;

        if (isset($_lang[$key]))
        {
            if (is_array($replacing))
            {
                return self::replace_to($_lang[$key],$replacing);
            }
            else
            {
                return $_lang[$key];
            }
        }
        else
        {
            trigger_error('Undefined ['.$key.'] key in $_lang array.');
        }
    }

}

/**
 * End of file language.php
 *
 * @created  02/04/2013 07:16 pm
 * @updated  02/04/2013 07:29 pm
 * @location ./system/languages/language.php
 */

?>
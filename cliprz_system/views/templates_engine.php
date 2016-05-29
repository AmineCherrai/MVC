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
 *  File path BASE_PATH/cliprz_system/views/ .
 *  File name templates_engine.php .
 *  Created date 29/01/2013 10:13 PM.
 *  Last modification date 30/01/2013 07:03 PM.
 *
 * Description :
 *  Templates engine class.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

class cliprz_templates_engine
{

    /**
     * @var (string) $cache_path - Cache full path.
     * @access protected.
     */
    protected static $cache_path;

    /**
     * @var (string) $cache_time - Cache time, If time finished Cache will delete files.
     * @access protected.
     */
    protected static $cache_time;

    /**
     * @var (string) $templates_path - Templates full path.
     * @access protected.
     */
    protected static $templates_path;

    /**
     * @var (string) $templates_extension - Templates extension.
     * @access protected.
     */
    protected static $templates_extension = ".tpl";

    /**
     * @var (array) $variables - Global variables.
     * @access protected.
     */
    protected static $variables;

    /**
     * Templates engine constructor.
     *
     * @access public.
     */
    public function __construct ()
    {
        self::$cache_path     = APP_PATH.'cache'.DS.'templates'.DS; // Set cache path.
        self::$templates_path = APP_PATH.view.'s'.DS; // Set templates path.
        self::$cache_time     = 60; // Set cache time, By default 60 seconds.

        // Check cache path if not exists create new cache folder with 0777 mode.
        if (!is_dir(self::$cache_path))
        {
            c_mkdir(self::$cache_path,0777);
            c_create_index(self::$cache_path);
        }
    }

    /**
     * Templates parser.
     *
     * @param (string) $template_content - Template contents.
     * @access protected.
     */
    protected static function parser ($template_content)
    {
        // We will add some features soon in parser.
        $parser = array(
            '`{([a-zA-Z0-9\_\-]+)}`s' => '<?php echo (isset(self::$variables[\'\\1\']) ? self::$variables[\'\\1\'] : "{ \\1 }"); ?>',
            /*'`{call\s*(.*?)}`is'      => '<?php self::call_template(\'\\1\'); ?>',*/
        );

        return preg_replace(
            array_keys($parser),
            array_values($parser),
            $template_content);
    }

    /**
     * Filter cache template names, Replace (: / \ -) symbols with (_) Underscore.
     *
     * @param (string) $cache_template - cache template name.
     * @access protected.
     */
    protected static function filter_cache_names ($cache_template)
    {
        return str_replace(array(":","/","\\","-"),"_",$cache_template);
    }

    /**
     * Encrypt template names.
     *
     * @param (string) $template_name - Template name with path if exists without .tpl extension.
     * @access protected.
     */
    protected static function encrypt_template_names ($template_name)
    {
        return sha1(md5($template_name));
    }

    /**
     * Get cached template contents.
     *
     * @param (string) $cached_template - Cached template name.
     * @access protected.
     */
    protected static function page_contents ($cached_template)
    {
        ob_start();
        include $cached_template;
        $page_contents = ob_get_contents();
        ob_end_clean();
        return $page_contents;
    }

    /**
     * Call another template inside chosen template.
     *
     * @param (string) $template_name - Template name with path if exists without .tpl extension.
     * @access protected.
     */
    /** Removed for now we will active that soon, Removed By Albert (Negix)
    protected static function call_template($template_name)
    {
        echo self::show($template_name);
    }
    */

    /**
     * Show template.
     *
     * @param (string) $template_name - Template name with path if exists without .tpl extension.
     * @param (array)  $data          - Template data with keys.
     * @param (string) $cache_time    - Cache time, If time finished Cache will delete files.
     */
    public static function show ($template_name,$data=null,$cache_time=0)
    {

        // Filter template name
        $template_name = c_trim_path($template_name);

        // Check if cache path is writeable
        if (!is_writeable(self::$cache_path))
        {
            trigger_error(self::$cache_path.' is not writeable.');
        }

        // Get chosen template.
        $template = self::$templates_path.$template_name.self::$templates_extension;

        // Get cached template name.
        $cached_template = self::$cache_path
            .self::filter_cache_names($template_name)
            .'_'
            .self::encrypt_template_names($template_name)
            .self::$templates_extension
            .'.php';

        // Get cached time
        $cached_time = ($cache_time !== 0) ? $cache_time : self::$cache_time;

         // Set vairables data.
        if (is_array($data))
        {
            foreach ($data as $key => $value)
            {
                self::$variables[$key] = $value;
            }
        }
        else
        {
            self::$variables = array();
        }

        // Page contents
        $page_contents = null;

        // Check if template in is cached.
        if (file_exists($cached_template))
        {
            $cache_offset_time = $cached_time + filemtime($cached_template);

            if ($cache_offset_time <= TIME_NOW)
            {
                // Detele cached template
                unlink($cached_template);

                // Get chosen template contents
                $contents = self::parser(c_file_get_contents($template));

                // Here parser
                c_file_put_contents($cached_template,$contents,LOCK_EX);

                // Changes file mode to 0666
                chmod($cached_template,0666);

                // Check cached template before shown.
                if (file_exists($cached_template))
                {
                    $page_contents = self::page_contents($cached_template);
                }
                else // if cached template not exists show error.
                {
                    trigger_error($cached_template." not exists.");
                }
            }
            else
            {
                $page_contents = self::page_contents($cached_template);
            }
        }
        else // If template not cached
        {
            // Check if template exists
            if (file_exists($template))
            {
                // Get chosen template contents
                $contents = self::parser(c_file_get_contents($template));

                // Here parser
                c_file_put_contents($cached_template,$contents,LOCK_EX);

                // Changes file mode to 0666
                chmod($cached_template,0666);

                // Check cached template before shown.
                if (file_exists($cached_template))
                {
                    $page_contents = self::page_contents($cached_template);
                }
                else // if cached template not exists show error.
                {
                    trigger_error($cached_template." not exists.");
                }
            }
            else // If  template not exists show error.
            {
                trigger_error($template." not exists.");
            }
        }

        // Get page contents.
        return $page_contents;
    }

}

?>
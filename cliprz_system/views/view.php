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
 *  File path BASE_PATH/cliprz_system/views/ .
 *  File name view.php .
 *  Created date 17/10/2012 04:15 AM.
 *  Last modification date 01/01/2013 10:47 AM.
 *
 * Description :
 *  View class.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

class cliprz_view
{

    /**
     * @var (string) $ext - view file extension.
     * @access protected.
     */
    protected static $ext = '.page.php';

    /**
     * @var (string) $public - public folder name in www/project/.
     * @access protected.
     */
    protected static $public = "public";

    /**
     * display file from project views folder.
     *
     * @param (string) $file - file name.
     * @param (string) $folder - if view file in folder but the folder name.
     * @param (array) $data - put data in view files.
     * @access public.
     */
    public function display($file,$folder='',$data=null)
    {
        $view_path = null;

        // check path for view file
        if ($folder == '')
        {
            $view_path = APP_PATH.'views'.DS.$file.self::$ext;
        }
        else
        {
            $view_path = APP_PATH.'views'.DS.c_trim_path($folder).DS.$file.self::$ext;
        }

        // extract data if exsists
        if (!is_null($data) && is_array($data))
        {
            extract($data);
        }

        // include and show view file
        if (file_exists($view_path))
        {
            require_once $view_path;
        }
        else
        {
            if (C_DEVELOPMENT_ENVIRONMENT == true)
            {
                trigger_error($view_path." file not exists.");
            }
            else
            {
                cliprz::system(error)->show_404();
            }
        }

        // unset data
        unset($data,$view_path,$folder);

    }

    /**
     * load javascript (js) files from public folder.
     *
     * @param (string) $file - file name.
     * @param (string) $folder- folder name inside public folder.
     * @access public.
     * @return string (http(s)://www.example.example/public/javascript/$folder/$file).
     */
    public static function javascript ($file,$folder='')
    {
        global $_config;

        // Path example = http://example.example/public/javascript/$folder/$file
        $path = c_trim_path($_config['output']['url']);
        $path .= DS.self::$public.DS."javascript".DS;
        $path .= (isset($folder) && !empty($folder)) ? c_trim_path($folder).DS : "";
        $path .= $file;

        return $path;
    }

    /**
     * load images files from public folder.
     *
     * @param (string) $file - file name.
     * @param (string) $folder- folder name inside public folder.
     * @access public.
     * @return string (http(s)://www.example.example/public/images/$folder/$file).
     */
    public static function image ($file,$folder='')
    {
        global $_config;

        // Path example = http://example.example/public/css/$folder/$file
        $path = c_trim_path($_config['output']['url']);
        $path .= DS.self::$public.DS."images".DS;
        $path .= (isset($folder) && !empty($folder)) ? c_trim_path($folder).DS : "";
        $path .= $file;

        return $path;
    }

}

?>
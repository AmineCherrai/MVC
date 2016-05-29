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
 *  File path BASE_PATH/cliprz_system/cliprz/info/ .
 *  File name info.php .
 *  Created date 19/01/2013 06:31 PM.
 *  Last modification date 21/01/2013 05:22 PM.
 *
 * Description :
 *  Cliprz framework info .
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

class cliprz_info
{

    /**
     * Show cliprz information.
     *
     * @access public.
     * @warning Don't ever user cliprz::info();, You can use cliprzinfo();
     */
    public static function info ()
    {
        $info_page = SYS_PATH.'cliprz/info/info.page.php';

        if (file_exists($info_page))
        {

            $cliprz_functions  = self::cliprz_functions();
            $cliprz_developers = self::cliprz_team();


            $funcs = "";

            foreach ($cliprz_functions as $cf)
            {
                $funcs .= $cf."(), ";
            }

            $functions = trim($funcs,", ");


            $phpinfo = (((C_DEVELOPMENT_ENVIRONMENT == true)) ? true : false);

            $get_all_loaded_extensions = c_get_loaded_extensions(false);

            $loaded_exts = null;

            foreach ($get_all_loaded_extensions as $le)
            {
                $loaded_exts .= $le.", ";
            }

            $loaded_extensions = trim($loaded_exts,", ");

            $info = array(
                "phpinfo"           => $phpinfo,
                "loaded_extensions" => $loaded_extensions,
                "constants"         => self::cliprz_constants(),
                "functions"         => $functions,
                "developers"        => $cliprz_developers
            );


            extract($info);

            include $info_page;

            unset($info);
        }
        else
        {
            exit($info_page." not exists.");
        }
    }

    /**
     * Get Cliprz framework constants.
     *
     * @access protected.
     */
    protected static function cliprz_constants ()
    {
        $php_constants    = (array) c_php_get_constants(true,false);

        $cliprz_constants = (array) $php_constants['user'];

        unset($php_constants);

        return $cliprz_constants;
    }

    /**
     * Get Cliprz framework functions.
     *
     * @access protected.
     */
    protected static function cliprz_functions ()
    {
        $php_functions = (array) get_defined_functions();

        $cliprz_functions = (array) $php_functions['user'];

        unset($php_functions);

        return $cliprz_functions;
    }

    /**
     * Get Cliprz framework team and sttuf names.
     *
     * @access protected.
     */
    protected static function cliprz_team ()
    {
        $developers_path = SYS_PATH.'configuration'.DS.'developers.ini';

        $team = c_ini_data($developers_path);

        return (string) $team['developers'];
    }

}

?>
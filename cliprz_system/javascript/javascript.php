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
 *  File path BASE_PATH/cliprz_system/javascript/ .
 *  File name javascript.php .
 *  Created date 25/01/2013 01:54 AM.
 *  Last modification date 27/01/2013 09:43 PM.
 *
 * Description :
 *  Javascript handler class.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

class cliprz_javascript
{

    /**
     * @var (string) $js_path - Javascript files path (BASE_PATH/public/javascript).
     * @access protected.
     */
    protected static $js_path;

    /**
     * Javascript Construct.
     *
     * @access public.
     */
    public function __construct()
    {
        self::$js_path = C_URL.'public'.DS.'javascript'.DS;
    }

    /**
     * Load javascript (js) files from public folder.
     *
     * @param (string) $filename - file name.
     * @access public.
     */
    public static function src ($filename)
    {
        return ((file_exists(PUBLIC_PATH.'javascript'.DS.$filename))
            ? self::$js_path.$filename
            : trigger_error($filename." Not exists in ".self::$js_path));
    }

}

?>
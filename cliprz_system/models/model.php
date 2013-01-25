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
 *  File path BASE_PATH/cliprz_system/models/ .
 *  File name model.php .
 *  Created date 17/11/2012 10:15 PM.
 *  Last modification date 08/12/2012 11:51 PM.
 *
 * Description :
 *  Model class.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

class cliprz_model
{

    /**
     * @var (array) $_models - model objects (this get model objects in cliprz_application models folder only).
     * @access protected.
     */
    protected static $_models = array();

    /**
     * Load model form cliprz_application models folder.
     *
     * @param (string) $model - class file name without .php extension, Please read the note below.
     * @param (string) $directory - The folder that contains the class without / ending.
     * @return require path/class and start new model class.
     * @access protected.
     *
     * @note about $model variable file name in cliprz_application models directory must be same class name,
     *  do not forget all file names and class name in cliprz_application models must be lowercase characters,
     *  As an example : file name (cliprz.php), class name (cliprz).
     */
    final public static function load ($model,$directory='')
    {
        $model_path = APP_PATH.'models'.DS.c_trim_path($directory).$model.'.php';

        if (file_exists($model_path))
        {
            require_once $model_path;

            $model_class = (string) strtolower($model);

            self::$_models[$model_class] = new $model_class();
        }
        else
        {
            trigger_error($model.' not found.');
        }

    }

    /**
     * get loaded model class.
     *
     * @param (string) $model_class - model class name.
     * @return loaded model class.
     * @access public.
     */
    final public static function get($model_class)
    {
        $key = strtolower($model_class);

        if (is_object(self::$_models[$key]))
        {
            return self::$_models[$key];
        }
        else
        {
            trigger_error($key.' class not found in models folder.');
        }
    }

}

?>
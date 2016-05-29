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
 *  File path BASE_PATH/cliprz_application/libraries/upload_file/ .
 *  File name upload_file.php .
 *  Created date 02/02/2013 08:09 PM.
 *  Last modification date 04/02/2013 04:59 PM.
 *
 * Description :
 *  Upload files library, Upload single or Multiple files to a path of your choice, easily and safely.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

/**
 * @library version : 1.0
 * @library author  : Yousef Ismaeil.
 * @author email    : Cliprz[at]gmail[dot]com .
 * @author website  : http://www.cliprz.org .
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

class library_upload_file
{

    /**
     * @var (mixed) $errors - uploading errors.
     * @var (mixed) $file   - file name.
     * @access protected.
     */
    protected static $errors,$file;

    /**
     * This is a powerful function to check 3 things :
     *  1- Allow extensions types from get file information.
     *  2- Allow extensions types as regular expression.
     *  3- Allow MIME Types.
     *
     * @param (string) $file       - File name.
     * @param (string) $type       - File mime type.
     * @param (array) $_extensions - allow mime types with keys as in example below.
     *  Example array('png' => 'image/png','jpe' => 'image/jpeg','jpg' => 'image/jpeg','gif' => 'image/gif',);
     * @access protected.
     */
    protected static function is_allow_extensions ($file,$type,$_extensions)
    {
        // Check if $_extensions is array
        if (is_array($_extensions))
        {
            $_extensions = c_mb_strtolower($_extensions);

            // Get uploaded file inforamtions.
            $get_extensions = self::get_file_information($file);

            // Get extensions array keys.
            $extensions_keys = array_keys($_extensions);

            // Check if extensions keys is exists in uploaded file inforamtions.
            if (in_array($get_extensions['extension'],c_mb_strtolower($extensions_keys)))
            {
                // Not check via regular expression. as in example "`\.(?:jpe?g|png|gif)$`"
                $regular_expression_extensions = implode("|",$extensions_keys);

                // Create regular expression extensions to more security.
                $regular_expression = (string) c_mb_strtolower("`\.(".$regular_expression_extensions.")$`");

                // Check if preg match with file name.
                if (preg_match($regular_expression,$file))
                {
                    // Check mime types
                    if (in_array($type,self::get_mime_types($_extensions)))
                    {
                        return true;
                    }
                    else
                    {
                        return false;
                    }
                }
                else
                {
                    return false;
                }
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    /**
     * Get file information.
     *
     * @param (mixed) $file - File name as string or array.
     * @access protected.
     */
    protected static function get_file_information ($file)
    {
        if (is_array($file))
        {
            foreach ($file as $value)
            {
                self::get_file_information($value);
            }
        }
        else
        {
            return (array) pathinfo($file);
        }
    }

    /**
     * Get mime types and children.
     *
     * @param (array) $mimes - Mime types as array values.
     * @access protected.
     */
    protected static function get_mime_types ($mimes)
    {
        $result = null;

        foreach ($mimes as $value)
        {
            if (is_array($value))
            {
                foreach ($value as $children)
                {
                    $result[] = $children;
                }
            }
            else
            {
                $result[] = $value;
            }
        }

        $types = array_unique($result);

        return (array) $types;
    }

    /**
     * Check is file empty.
     *
     * @param (string) $file - File name.
     * @access protected.
     */
    protected static function is_file ($file)
    {
        return (bool) ((!empty($file)) ? true : false);
    }

    /**
     * Check allow file max size.
     *
     * @param (integer) $file - File name.
     * @param (integer) $size - Allow max size.
     * @access protected.
     */
    protected static function max_size ($file,$size)
    {
        return (bool) (($file <= $size) ? true : false);
    }

    /**
     * Check if file name is secure to upload.
     *
     * @param (string) $file - File name.
     * @access protected.
     */
    protected static function secure_filename ($file)
    {
        return (bool) ((preg_match("`^[-0-9A-Z_\.]+$`i",$file)) ? true : false);
    }

    /**
     * When uploading a file with a very long filename, for example 255 characters, move_uploaded_file fails.
     * So this function will handling That.
     *
     * @param (string) $file - File name.
     * @access protected.
     */
    protected static function is_long_filename ($file)
    {
        return (bool) ((c_mb_strlen($file) > 220) ? true : false);
    }

    /**
     * Show a maximum file size message for users.
     *
     * @param (integer) $size - Add maximum file size as Bytes.
     * @access public.
     */
    public static function maximum_file_size ($size)
    {
        return c_lang('c_uf_maximum_file_size').' '.c_bytes2str($size);
    }

    /**
     * Set uploading errors.
     *
     * @param (mixed) $messages.
     * @access protected.
     */
    protected static function set_errors($messages)
    {
        if (is_array($messages))
        {
            foreach ($messages as $key => $value)
            {
                self::$errors[$key] = $value;
            }
        }
        else
        {
            self::$errors = $messages;
        }
        return false;
    }

    /**
     * Get uploading errors to display in your proeject.
     *
     * @access public.
     */
    public static function errors($_numbers=null)
    {
        if (is_array(self::$errors))
        {
            $messages = self::$errors;

            $errors = null;

            $n = 0;

            foreach ($messages as $key => $value)
            {
                $n++;
                $errors[$n] = $value.' '.c_lang('c_uf_in_field_number').' '.$n.'<br />';
            }

            $display = null;

            foreach ($errors as $key => $value)
            {
                $display .= $value.PHP_EOL;
            }

            if (is_integer($_numbers))
            {
                return $errors[$_numbers];
            }
            else
            {
                return $display;
            }
        }
        else
        {
            return self::$errors;
        }
    }

    /**
     * Get file upload success message.
     *
     * @access public.
     */
    public static function success ()
    {
        return c_lang('c_uf_uploaded_successfully');
    }

    /**
     * Set single file info information.
     *
     * @param (mixed) $file - file name.
     * @access protected.
     */
    protected static function set_file_info ($file)
    {
        if (is_array($file))
        {
            foreach ($file as $key => $value)
            {
                self::$file[$key] = $value;
            }
        }
        else
        {
            self::$file = $file;
        }
    }

    /**
     * Get file information.
     *
     * @param (integer) $number - if you use multiple upload you can chosse a number for file input.
     * @access protected.
     */
    protected static function get_file_info($number=null)
    {
        if (is_array($number))
        {
            return self::$file[$number];
        }
        else
        {
            return self::$file;
        }
    }

    /**
     * Get file information as string.
     *
     * @param (string) $get - get information type, Read below lines.
     *  $get :
     *   'all'       - All information as string.
     *   'dirname'   - Dir name.
     *   'basename'  - base name.
     *   'extension' - extension name.
     *   'filename'  - file name.
     *   'url'       - File url in your project.
     * @access protected.
     */
    public static function file_info ($get='all')
    {
        $information = self::get_file_information(self::get_file_info());

        // Get data
        $data = '';

        if ($get == 'all')
        {
            foreach ($information as $key => $value)
            {
                $data .= $key.' = '.$value."<br />";
            }

            $data .= "url = ".C_URL.c_remove_base_path(c_rtrim_path($information['dirname'])).DS.$information['basename'].'<br />';
        }
        else if ($get == 'dirname')
        {
            $data = $information['dirname'];
        }
        else if ($get == 'basename')
        {
            $data = $information['basename'];
        }
        else if ($get == 'extension')
        {
            $data = $information['extension'];
        }
        else if ($get == 'filename')
        {
            $data = $information['filename'];
        }
        else if ($get == 'url')
        {
            $data = C_URL.c_remove_base_path(c_rtrim_path($information['dirname'])).DS.$information['basename'];
        }
        else
        {
            $data = 'No data';
        }

        return $data;
    }

    /**
     * Get a Mega bytes size, You can use it for your upload size.
     *
     * @param (integer) $megabytes - Mega bytes number as in example 1 you get = 1MB.
     * @access public.
     */
    public static function megabytes ($megabytes=1)
    {
        return (integer) 1048576 * $megabytes;
    }

    /**
     * Rename file name.
     *
     * @param (string) $filename     - Current file name.
     * @param (string) $new_filename - The new file name By default NULL read below values, Or you can rename as you want.
     *  $new_filename :
     *   NULL   - You will get image name with date as (dmYhsm).
     *   'md5'  - You will get image name as md5.
     *   'sha1' - You will get image name as sha1.
     * @access protected.
     */
    protected static function rename_file ($filename,$new_filename='time')
    {
        // Remove extension from file name.
      	$temp_arr = explode(".",$filename);
      	$file_ext = array_pop($temp_arr);
      	$file_ext = trim($file_ext);
      	$file_ext = c_mb_strtolower($file_ext);

        // Get filename without extension.
        $filename_without_ext = rtrim($filename,'.'.$file_ext);

        // This variable only for get the last file name.
        $new = null;

        // Check if $new_filename parameter is null or not
        // If $new_filename null rename as date
        if ($new_filename == 'time')
        {
            $new = c_mb_strtolower($filename_without_ext.'_'.date("dmYhsm",TIME_NOW));
        }
        else if ($new_filename == 'md5')
        {
            $new = md5($new_filename.TIME_NOW);
        }
        else if ($new_filename == 'sha1')
        {
            $new = sha1(md5($new_filename.TIME_NOW));
        }
        else
        {
            $new = c_mb_strtolower($new_filename);
        }

        return $new.'.'.$file_ext;
    }

    /**
     * Upload single file to a path of your choice, easily and safely.
     *
     * @param (string) $name     - Input file name. as in example if <input type="file" name="img" /> You must add 'img' as parameter.
     * @param (string) $_options - More options to upload with what you need. Check below line.
     *  $_options :
     *   (integer) 'max_size'   - Maximum file size, By default 1MB.
     *   (array)   'mime_types' - Mime types as array with keys as in example array('png' => 'image/png','jpe' => 'image/jpeg','jpg' => 'image/jpeg','gif' => 'image/gif',);.
     *   (string)  'save_path'  - You uploading save path, By default BASE_PATH/public/uploads/.
     *   (boolean) 'filter'     - Filter file from bad codes.
     *   (boolean) 'rename'     - Rename file after upload You can read self::rename_file() method in this library.
     * @access public.
     */
    public static function single_upload ($name,$_options)
    {
        // Get file names
        $files      = $_FILES[$name];

        // Get file max size to upload.
        $max_size   = (isset($_options['max_size']) ? (integer) $_options['max_size'] : self::megabytes());

        // Get allow MIME Types.
        $mime_types = (isset($_options['mime_types']) ? (array) $_options['mime_types'] : null);

        // Get file save path or upload files to BASE_PATH/public/uploads/.
        $save_path  = (isset($_options['save_path'])) ? (string) c_rtrim_path($_options['save_path']).DS : UP_PATH;

        // Filter file from bad codes
        $filter  = (isset($_options['filter'])) ? (bool) $_options['filter'] : false;

        // Rename file
        $rename = (isset($_options['rename'])) ? $_options['rename'] : false;

        // Chcek $mime_types must not be null
        if ($mime_types === null)
        {
            trigger_error("You must add a mime types as array to more security.",E_WARNING);
        }

        // Check is save path exists.
        if (is_dir($save_path))
        {
            $filename = c_mb_strtolower($files['name']);
            $filetype = c_mb_strtolower($files['type']);

            // Check is file not empty.
            if (!self::is_file($filename))
            {
                self::set_errors(c_lang('c_uf_choose_a_file'));
            }
            // Check if file name have a long character
            else if (self::is_long_filename($filename))
            {
                self::set_errors('c_uf_long_file_name');
            }
            // Check file name is secure.
            else if (!self::secure_filename($filename))
            {
                self::set_errors(c_lang('c_uf_filename_rules'));
            }
            // Check if file size allow with max size.
            else if (!self::max_size ($files['size'],$max_size))
            {
                self::set_errors(c_lang('c_uf_maximum_file_size').c_bytes2str($max_size));
            }
            // Check file extensions is allow.
            else if (!self::is_allow_extensions($filename,$filetype,$mime_types))
            {
                self::set_errors(c_lang('c_uf_type_not_allowed'));
            }
            // Upload file now
            else
            {
                // Save current file name.
                $current_file_name = self::rename_file($filename);

                // Check if file not exists or show error message.
                if (!file_exists($save_path.$filename))
                {
                    if ($filter === true)
                    {
                        if (move_uploaded_file($files['tmp_name'],TMP_PATH.$filename))
                        {
                            // If bad codes exists will link file
                            if (!self::is_clean_file(TMP_PATH.$current_file_name))
                            {
                                c_delete_file(TMP_PATH.$current_file_name);
                                self::set_errors(c_lang('c_uf_our_server_del_the_file'));
                            }
                            else
                            {
                                if (c_move_file(TMP_PATH.$current_file_name,$save_path.$current_file_name))
                                {
                                    self::set_file_info($save_path.$current_file_name);
                                    return true;
                                }
                                else
                                {
                                    self::set_errors(c_lang('c_uf_failed_to_upload'));
                                }
                            }
                        }
                        else
                        {
                            self::set_errors(c_lang('c_uf_failed_to_upload'));
                        }
                    }
                    else
                    {
                        if (move_uploaded_file($files['tmp_name'],$save_path.$filename))
                        {
                            self::set_file_info($save_path.$filename);
                            return true;
                        }
                        else
                        {
                            self::set_errors(c_lang('c_uf_failed_to_upload'));
                        }
                    }
                }
                else
                {
                    self::set_errors($filename." ".c_lang('c_uf_file_is_already_exists'));
                }
            }
        }
        else // if save path not exists get below error.
        {
            trigger_error($save_path." not exists.");
        }
    }

    /**
     * Upload multiple files to a path of your choice, easily and safely.
     *
     * @param (string) $name     - Input file name. as in example if <input type="file" name="img" /> You must add 'img' as parameter.
     * @param (string) $_options - More options to upload with what you need. Check below line.
     *  $_options :
     *   (integer) 'max_size'   - Maximum file size, By default 1MB.
     *   (array)   'mime_types' - Mime types as array with keys as in example array('png' => 'image/png','jpe' => 'image/jpeg','jpg' => 'image/jpeg','gif' => 'image/gif',);.
     *   (string)  'save_path'  - You uploading save path, By default BASE_PATH/public/uploads/.
     *   (boolean) 'filter'     - Filter file from bad codes.
     *   (boolean) 'rename'     - Rename file after upload You can read self::rename_file() method in this library.
     * @access public.
     */
    public static function multiple_upload ($name,$_options)
    {
        // Get file names
        $files      = $_FILES[$name];

        $count = count($files['name']);

        echo $count;

        // Get file max size to upload.
        $max_size   = (isset($_options['max_size']) ? (integer) $_options['max_size'] : self::megabytes());

        // Get allow MIME Types.
        $mime_types = (isset($_options['mime_types']) ? (array) $_options['mime_types'] : null);

        // Get file save path or upload files to BASE_PATH/public/uploads/.
        $save_path  = (isset($_options['save_path'])) ? (string) c_rtrim_path($_options['save_path']).DS : UP_PATH;

        // Filter file from bad codes
        $filter  = (isset($_options['filter'])) ? (bool) $_options['filter'] : false;

        // Rename file
        $rename = (isset($_options['rename'])) ? $_options['rename'] : false;

        // Chcek $mime_types must not be null
        if ($mime_types === null)
        {
            trigger_error("You must add a mime types as array to more security.",E_WARNING);
        }

        // Check is save path exists.
        if (is_dir($save_path))
        {

            for ($i = 0; $i < $count; $i++)
            {

            $filename = c_mb_strtolower($files['name'][$i]);
            $filetype = c_mb_strtolower($files['type'][$i]);

            echo $filename.'<br />';

            // Check is file not empty.
            if (!self::is_file($filename))
            {
                self::set_errors(c_lang('c_uf_choose_a_file'));
            }
            // Check if file name have a long character
            else if (self::is_long_filename($filename))
            {
                self::set_errors('c_uf_long_file_name');
            }
            // Check file name is secure.
            else if (!self::secure_filename($filename))
            {
                self::set_errors(c_lang('c_uf_filename_rules'));
            }
            // Check if file size allow with max size.
            else if (!self::max_size ($files['size'][$i],$max_size))
            {
                self::set_errors(c_lang('c_uf_maximum_file_size').c_bytes2str($max_size));
            }
            // Check file extensions is allow.
            else if (!self::is_allow_extensions($filename,$filetype,$mime_types))
            {
                self::set_errors(c_lang('c_uf_type_not_allowed'));
            }
            // Upload file now
            else
            {
                // Save current file name.
                $current_file_name = self::rename_file($filename);

                // Check if file not exists or show error message.
                if (!file_exists($save_path.$current_file_name))
                {
                    if ($filter === true)
                    {
                        if (move_uploaded_file($files['tmp_name'][$i],TMP_PATH.$current_file_name))
                        {
                            // If bad codes exists will link file
                            if (!self::is_clean_file(TMP_PATH.$current_file_name))
                            {
                                c_delete_file(TMP_PATH.$current_file_name);
                                self::set_errors(c_lang('c_uf_our_server_del_the_file'));
                            }
                            else
                            {
                                if (c_move_file(TMP_PATH.$current_file_name,$save_path.$current_file_name))
                                {
                                    self::set_file_info($save_path.$current_file_name);
                                    return true;
                                }
                                else
                                {
                                    self::set_errors(c_lang('c_uf_failed_to_upload'));
                                }
                            }
                        }
                        else
                        {
                            self::set_errors(c_lang('c_uf_failed_to_upload'));
                        }
                    }
                    else
                    {
                        if (move_uploaded_file($files['tmp_name'][$i],$save_path.$current_file_name))
                        {
                            self::set_file_info($save_path.$current_file_name);
                            return true;
                        }
                        else
                        {
                            self::set_errors(c_lang('c_uf_failed_to_upload'));
                        }
                    }
                }
                else
                {
                    self::set_errors($current_file_name." ".c_lang('c_uf_file_is_already_exists'));
                }
            }
            } // end for
        }
        else // if save path not exists get below error.
        {
            trigger_error($save_path." not exists.");
        }
    }

    /**
     * A simple function to check file from bad codes.
     *
     * @param (string) $file - file path.
     * @access protected.
     */
    protected static function is_clean_file ($file)
    {
        $contents = c_file_get_contents($file);

        if (preg_match('/(base64_|eval|system|shell_|exec|php_)/i',$contents))
        {
            return false;
        }
        else if (preg_match("#&\#x([0-9a-f]+);#i", $contents))
        {
            return false;
        }
        elseif (preg_match('#&\#([0-9]+);#i', $contents))
        {
            return false;
        }
        elseif (preg_match("#([a-z]*)=([\`\'\"]*)script:#iU", $contents))
        {
            return false;
        }
        elseif (preg_match("#([a-z]*)=([\`\'\"]*)javascript:#iU", $contents))
        {
            return false;
        }
        elseif (preg_match("#([a-z]*)=([\'\"]*)vbscript:#iU", $contents))
        {
            return false;
        }
        elseif (preg_match("#(<[^>]+)style=([\`\'\"]*).*expression\([^>]*>#iU", $contents))
        {
            return false;
        }
        elseif (preg_match("#(<[^>]+)style=([\`\'\"]*).*behaviour\([^>]*>#iU", $contents))
        {
            return false;
        }
        elseif (preg_match("#</*(applet|link|style|script|iframe|frame|frameset|form)[^>]*>#i", $contents))
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * You can use our Secure mime types or use your mime types array as you want.
     *
     * @param (string) $type - Whats mime types you want to use.
     *  $type :
     *   'image'    - Secure images mime types.
     *   'archive'  - Secure Compress mime types.
     * @access public.
     */
    public static function secure_mime_types ($type)
    {
        $_image = array(
              'bm'        => 'image/bmp',
              'bmp'       => array('image/bmp','image/x-windows-bmp'),
              'gif'       => 'image/gif',
              //'jp2'       => array('image/jpeg','image/pjpeg','image/jpg','image/x-jpeg','image/x-jpeg','image/x-jpg','image/pipeg'),
              'jpeg'      => array('image/jpeg','image/pjpeg','image/jpg','image/x-jpeg','image/x-jpeg','image/x-jpg','image/pipeg'),
              'jpg'       => array('image/jpeg','image/pjpeg','image/jpg','image/x-jpeg','image/x-jpeg','image/x-jpg','image/pipeg'),
              'jpe'       => array('image/jpeg','image/pjpeg','image/jpg','image/x-jpeg','image/x-jpeg','image/x-jpg','image/pipeg'),
              //'jfif'      => array('image/jpeg','image/pjpeg','image/jpg','image/x-jpeg','image/x-jpeg','image/x-jpg','image/pipeg'),
              //'jfif-tbnl' => array('image/jpeg','image/pjpeg','image/jpg','image/x-jpeg','image/x-jpeg','image/x-jpg','image/pipeg'),
              'png'       => array('image/png','image/x-png','image/x-citrix-png'));

        $_archive  = array(
              'rar'  => 'application/x-rar-compressed',
              'gtar' => 'application/x-gtar',
              'gz'   => 'application/x-gzip',
              'tar'  => 'application/x-tar',
              'tgz'  => array('application/x-tar','application/x-gzip-compressed'),
              'zip'  => array('application/x-zip','application/zip','application/x-zip-compressed','application/octet-stream'));

        $mime_types = null;

        switch ($type)
        {
            case 'image':
            case 'images':
                $mime_types = $_image;
            break;
            case 'archive':
            case 'archives':
            case 'compress':
                $mime_types = $_archive;
            break;
        }

        return $mime_types;
    }

}

?>
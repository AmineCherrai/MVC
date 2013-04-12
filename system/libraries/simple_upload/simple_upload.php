<?php

/**
 * Cliprz framework
 *
 * Color your project, An open source application development framework for PHP 5.3.0 or newer
 *
 * Upload files library, Upload files to a path of your choice, easily and safely
 *
 * LICENSE: This program is released as free software under the Affero GPL license. You can redistribute it and/or
 * modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 * at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 * written permission from the original author(s)
 *
 * @package    Cliprz
 * @category
 * @author     Yousef Ismaeil <cliprz@gmail.com>
 * @copyright  Copyright (c) 2012 - 2013, Cliprz Developers team
 * @license    http://www.cliprz.org/licenses/agpl
 * @link       http://www.cliprz.org
 * @since      Version 2.0.0
 */

class library_simple_upload
{

    /**
     * Uploading errors and File information
     *
     * @var string $errors   Upload errors
     * @var string $fileinfo File information
     *
     * @access private
     * @static
     */
    private static $errors,$fileinfo;

    /**
     * Check is file empty
     *
     * @param string $file File name
     *
     * @access private
     * @static
     */
    private static function is_file ($file)
    {
        return (bool) ((!empty($file)) ? TRUE : FALSE);
    }

    /**
     * Check if file name is secure to upload
     *
     * @param string $file File name
     *
     * @access private
     * @static
     */
    private static function is_secure_filename ($file)
    {
        return (bool) ((preg_match("`^[-0-9A-Z_\.]+$`i",$file)) ? TRUE : FALSE);
    }

    /**
     * When uploading a file with a very long filename, for example 255 characters, move_uploaded_file fails
     * So this function will handling That
     *
     * @param string $file File name
     *
     * @access private
     * @static
     */
    private static function is_long_filename ($file)
    {
        return (bool) ((mb_strlen($file) < 220) ? TRUE : FALSE);
    }

    /**
     * Check allow file max size
     *
     * @param integer $file File name
     * @param integer $size Allow max size
     *
     * @access private
     * @static
     */
    private static function is_max_size ($file,$size)
    {
        return (bool) (($file < $size) ? TRUE : FALSE);
    }

    /**
     * Get a Mega bytes size, You can use it for your upload size
     *
     * @param integer $megabytes Mega bytes number as in example 1 you get = 1MB
     *
     * @access public
     * @static
     */
    public static function megabytes ($megabytes=1)
    {
        return (integer) 1048576 * $megabytes;
    }

    /**
     * Get file information
     *
     * @param mixed $file File name as string or array
     *
     * @access private
     * @static
     */
    private static function get_file_information ($file)
    {
        return (array) pathinfo($file);
    }

    /**
     * Check is allow extensions
     *
     * @param array  $extensions extensions as array
     * @param string $filename   File name
     *
     * @access private
     * @static
     */
    private static function is_allow_extensions ($extensions,$filename)
    {
        if (is_array($extensions))
        {
            // Get $filename extension
            $file_information = self::get_file_information($filename);

            // Check extension from get self::file_information method();
            if (in_array(mb_strtolower($file_information['extension']),mb_strtolower($extensions)))
            {
                // Now check via regular expression. as in example "`\.(?:jpe?g|png|gif)$`"
                $regular_expression_extensions = implode("|",$extensions);

                // Create regular expression extensions to more security
                $regular_expression = (string) mb_strtolower("`\.(".$regular_expression_extensions.")$`");

                // Check if preg match with file name
                if (preg_match($regular_expression,$filename))
                {
                    return TRUE;
                }
                else
                {
                    return FALSE;
                }
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Check if is allow mime type
     *
     * @param string $file       Uploaded file
     * @param array  $mime_types Mime type as array
     *
     * @access private
     * @static
     */
    private static function is_allow_mime_type ($file,$mime_types)
    {
        if (is_array($mime_types))
        {
            if (in_array(mb_strtolower($file),mb_strtolower($mime_types)))
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * An associative array of items uploaded to the current script via the HTTP POST method
     *
     * @param string $name Input file name, as in example if <input type="file" name="img" /> You must add 'img' as parameter
     *
     * @access private
     * @static
     */
    private static function items ($name)
    {
        // Set $_FILES name
        $file = $_FILES[$name];

        return array(
            // The original name of the file on the client machine
            'name'     => mb_strtolower(basename($file['name'])),

            // The mime type of the file, if the browser provided this information. An example would be "image/gif"
            // This mime type is however not checked on the PHP side and therefore don't take its value for granted
            'type'     => mb_strtolower($file['type']),

            // The size, in bytes, of the uploaded file
            'size'     => $file['size'],

            // The temporary filename of the file in which the uploaded file was stored on the server
            'tmp_name' => $file['tmp_name'],

            // The error code associated with this file upload
            'error'    => $file['error']);
    }

    /**
     * Set error message
     *
     * @param string $message Error message
     *
     * @access private
     * @static
     */
    private static function set_error ($message)
    {
        self::$errors = $message;
        return FALSE;
    }

    /**
     * Get uploading errors to display in your proeject
     *
     * @access public
     * @static
     */
    public static function errors ()
    {
        if (!empty(self::$errors))
        {
            return self::$errors;
        }
        else
        {
            return 'There is no error.';
        }
    }

    /**
     * Get file upload success message
     *
     * @access public
     */
    public static function success ()
    {
        return 'File was uploaded successfully.';
    }

    /**
     * Rename file name
     *
     * @param string $filename     Current file name
     * @param string $new_filename The new file name By default NULL read below values, Or you can rename as you want
     *                              'time' You will get image name with date as (dmYhsm)
     *                              'md5'  You will get image name as md5
     *                              'sha1' You will get image name as sha1
     *                             or You can rename file as we want in $new_filename parameters
     *
     * @access private
     * @static
     */
    private static function rename_file ($filename,$new_filename='default')
    {
        // Remove extension from file name
      	$temp_arr = explode(".",$filename);
      	$file_ext = array_pop($temp_arr);
      	$file_ext = trim($file_ext);
      	$file_ext = mb_strtolower($file_ext);

        // Get filename without extension
        $filename_without_ext = rtrim($filename,'.'.$file_ext);

        // This variable only for get the last file name
        $new = NULL;

        // Check if $new_filename parameter is null or not
        // If $new_filename null rename as date
        if ($new_filename == 'time')
        {
            $new = mb_strtolower($filename_without_ext.'_'.date("dmYhsm",TIME_NOW));
        }
        else if ($new_filename == 'md5')
        {
            $new = md5($new_filename.TIME_NOW);
        }
        else if ($new_filename == 'sha1')
        {
            $new = sha1(md5($new_filename.TIME_NOW));
        }
        else if ($new_filename == 'default')
        {
            $new = mb_strtolower($filename_without_ext);
        }
        else
        {
            $new = mb_strtolower($new_filename);
        }

        return $new.'.'.$file_ext;
    }

    /**
     * Set file information
     *
     * @param string $filename  Uploaded file name with path
     * @param string $mime_type Uploaded file Mime type
     * @param string $file_size Uploaded file File size
     *
     * @access private
     * @static
     */
    private static function set_file_information ($filename,$mime_type,$file_size)
    {
        // Get pathinof() to set in file information
        $pathinfo = self::get_file_information($filename);

        // Set info from pathinfo();
        $info['dirname']   = $pathinfo['dirname'];
        $info['basename']  = $pathinfo['basename'];
        $info['extension'] = $pathinfo['extension'];
        $info['filename']  = $pathinfo['filename'];

        // Set url
        $info['url']       = URL.remove_base_path($pathinfo['dirname']).DS.$pathinfo['basename'];

        // Set safe path without base path
        $info['safepath']  = remove_base_path($pathinfo['dirname']).DS;

        // Set mime type
        $info['mime_type'] = $mime_type;

        // Set size as bytes
        $info['bytes']      = (int) $file_size;

        // Set size as string (measurement unit)
        $info['size']      = cliprz::system('file')->bytes2str($file_size);

        self::$fileinfo = (array) $info;

        unset($info,$pathinfo,$filename,$mime_type,$file_size);
    }

    /**
     * Get uploaded file information
     *
     * @param string $key Information key
     *                     'dirname'   Returns parent directory's path with BASE_PATH
     *                     'basename'  Returns file name with extension as in example filename.gif
     *                     'extension' Returns file extension
     *                     'filename'  Returns file name wothout extension
     *                     'url'       Returns file URL with full path as in example http://example/public/upload/filename.gif
     *                     'safepath'  Returns safe path, path without BASE_PATH
     *                     'mime_type' Returns file mime types as in example image/gif
     *                     'bytes'     Retruns file bytes size
     *                     'size'      Retruns file measurement unit size
     *                      NULL       Returns all data as print_r array
     *
     * @access public
     * @static
     */
    public static function file_information ($key=NULL)
    {
        if (is_array(self::$fileinfo))
        {
            if (array_key_exists($key,self::$fileinfo))
            {
                return self::$fileinfo[$key];
            }
            else
            {
                pre_print_r(self::$fileinfo);
            }
        }
    }

    /**
     * Upload file
     *
     * @param string $name     Input file name. as in example if <input type="file" name="img" /> You must add 'img' as parameter
     * @param string $_options More options to upload with what you need. Read below line
     *                          integer 'size'       Maximum file size, By default 1MB
     *                          array   'mime_types' Mime types as array with keys as in example array('image/png','image/jpeg','image/jpeg','image/gif');
     *                          array   'extensions' For more seucrity you must check extensions, as in example array('jpg','jpeg','gif','png');
     *                          string  'save_path'  Your uploading save path, By default BASE_PATH/public/uploads/
     *                          boolean 'filter'     Filter file from bad codes, By default FALSE
     *                          boolean 'rename'     Rename file after upload You can read self::rename_file() method in this library
     *
     * @access public
     * @static
     */
    public static function upload ($name,$_options)
    {
        // Set $_FILES name
        $file       = (array) self::items($name);

        $size       = (isset($_options['size'])) ? (int) $_options['size'] : self::megabytes();

        $save_path  = (isset($_options['save_path'])) ? cliprz::rds($_options['save_path'],'right').DS : UPLOAD_PATH;

        $filter     = (isset($_options['filter'])) ? (boolean) $_options['filter'] : FALSE;

        $extensions = (isset($_options['extensions'])) ? (array) $_options['extensions'] : NULL;

        $mime_types = (isset($_options['mime_types'])) ? (array) $_options['mime_types'] : NULL;

        $rename     = (isset($_options['rename'])) ? $_options['rename'] : 'default';

        if (!is_array($extensions))
        {
            self::set_error('You must set extensions array.');
        }
        else if (!is_array($mime_types))
        {
            self::set_error('You must set mime types array.');
        }
        else if (!is_dir($save_path))
        {
            self::set_error($save_path.' not found.');
        }
        else if (!is_readable($save_path) && !is_writeable($save_path))
        {
            self::set_error($save_path.' chmod must be 0777.');
        }
        else
        {
            if (!self::is_file($file['name']))
            {
                self::set_error('Please choose a file.');
            }
            else if (!self::is_secure_filename($file['name']))
            {
                self::set_error('Filename must be in English letters, numbers, Symbols that in parentheses (- _ .) and without spacing.');
            }
            else if (!self::is_long_filename($file['name']))
            {
                self::set_error('File name must be less than 220 character.');
            }
            else if (!self::is_max_size($file['size'],$size))
            {
                self::set_error('Maximum file size is : '.cliprz::system('file')->bytes2str($size));
            }
            else if (!self::is_allow_extensions($extensions,$file['name']))
            {
                self::set_error('File type is not allowed.');
            }
            else if (!self::is_allow_mime_type($file['type'],$mime_types))
            {
                self::set_error('File type is not allowed.');
            }
            else
            {
                $current_file_name = self::rename_file($file['name'],$rename);

                $temporary = TEMPORARY_PATH.$current_file_name;
                $path      = $save_path.$current_file_name;

                unset($current_file_name);

                // Check if file is already exists
                if (file_exists($temporary) || file_exists($path))
                {
                    self::set_error('We are sorry this file is already exists. You can rename your file and upload again.');
                }
                else
                {
                    // If filter true, Check the file with self::is_clean_file() method
                    if ($filter === TRUE)
                    {
                        // Try to upload file now to temporary folder
                        if (move_uploaded_file($file['tmp_name'],$temporary))
                        {
                            // Check if file is clean
                            if (self::is_clean_file($temporary))
                            {
                                // If file is clean move file from temporary folder to $save_path folder
                                if (cliprz::system('file')->move($temporary,$path))
                                {
                                    self::set_file_information($path,$file['type'],$file['size']);
                                    return TRUE;
                                }
                                // Else if file not moved to $save_path set error
                                else
                                {
                                    self::set_error('Failed to upload file.');
                                }
                            }
                            // If file not clean delete file from server
                            else
                            {
                                cliprz::system('file')->delete($temporary);
                                self::set_error('Our server delete the file for security reasons.');
                            }
                        }
                        // If file not uploaded to temporary set error
                        else
                        {
                            self::set_error('Failed to upload file.');
                        }
                    }
                    // If filter is false upload file to $save_path folder
                    else
                    {
                        // Try to upload file now to $save_path folder
                        if (move_uploaded_file($file['tmp_name'],$path))
                        {
                            self::set_file_information($path,$file['type'],$file['size']);
                            return TRUE;
                        }
                        // If not uploaded to $save_path folder set error
                        else
                        {
                            self::set_error('Failed to upload file.');
                        }
                    }
                }
            }
        }
    }

    /**
     * Since PHP 4.2.0, PHP returns an appropriate error code along with the file array
     * The error code can be found in the error segment of the file array that is created during the file upload by PHP
     * In other words, the error might be found in $_FILES['userfile']['error']
     *
     * @param mixed $error Error code
     *
     * @access private
     * @static
     */
    private static function error_messages_explained ($error)
    {
        $message = NULL;

        switch ($error)
        {
            case 0:
            case UPLOAD_ERR_OK:
                $message = 'There is no error, the file uploaded with success.';
            break;
            case 1:
            case UPLOAD_ERR_INI_SIZE:
                $message = 'The uploaded file exceeds the upload_max_filesize directive in php.ini.';
            break;
            case 2:
            case UPLOAD_ERR_FORM_SIZE:
                $message = 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.';
            break;
            case 3:
            case UPLOAD_ERR_PARTIAL:
                $message = 'The uploaded file was only partially uploaded.';
            break;
            case 4:
            case UPLOAD_ERR_NO_FILE:
                $message = 'No file was uploaded.';
            break;
            case 6:
            case UPLOAD_ERR_NO_TMP_DIR:
                $message = ' Missing a temporary folder.';
            break;
            case 7:
            case UPLOAD_ERR_CANT_WRITE:
                $message = ' Failed to write file to disk.';
            break;
            case 8:
            case UPLOAD_ERR_EXTENSION:
                $message = 'A PHP extension stopped the file upload.
                    PHP does not provide a way to ascertain which extension caused the file upload to stop;
                    examining the list of loaded extensions with phpinfo() may help.';
            break;
            default:
                $message = "Unknown upload error";
            break;
        }

        return $message;
    }

    /**
     * A simple function to check file from bad codes
     *
     * @param string $file file path
     *
     * @access private
     * @static
     */
    private static function is_clean_file ($file)
    {
        $contents = file_get_contents($file);

        if (preg_match('/(base64_|eval|system|shell_|exec|php_)/i',$contents))
        {
            return FALSE;
        }
        else if (preg_match("#&\#x([0-9a-f]+);#i", $contents))
        {
            return FALSE;
        }
        elseif (preg_match('#&\#([0-9]+);#i', $contents))
        {
            return FALSE;
        }
        elseif (preg_match("#([a-z]*)=([\`\'\"]*)script:#iU", $contents))
        {
            return FALSE;
        }
        elseif (preg_match("#([a-z]*)=([\`\'\"]*)javascript:#iU", $contents))
        {
            return FALSE;
        }
        elseif (preg_match("#([a-z]*)=([\'\"]*)vbscript:#iU", $contents))
        {
            return FALSE;
        }
        elseif (preg_match("#(<[^>]+)style=([\`\'\"]*).*expression\([^>]*>#iU", $contents))
        {
            return FALSE;
        }
        elseif (preg_match("#(<[^>]+)style=([\`\'\"]*).*behaviour\([^>]*>#iU", $contents))
        {
            return FALSE;
        }
        elseif (preg_match("#</*(applet|link|style|script|iframe|frame|frameset|form)[^>]*>#i", $contents))
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

}

/**
 * End of file simple_upload.php
 *
 * @created  08/03/2013 05:52 am
 * @updated  02/04/2013 06:08 pm
 * @location ./system/libraries/simple_upload/simple_upload.php
 */

?>
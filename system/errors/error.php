<?php

/**
 * Cliprz framework
 *
 * Color your project, An open source application development framework for PHP 5.3.0 or newer
 *
 * Error handling object
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
 * @since      Version 2.0.0
 */

class cliprz_error
{

    /**
     * Error constructor
     *
     * @access public
     */
    public function __construct()
    {
        error_reporting(E_ALL);

        ini_set('log_errors', 'On');

        if (DEVELOPMENT_ENVIRONMENT)
        {
            ini_set('display_errors','On');
        }
        else
        {
            ini_set('display_errors','Off');
        }

        ini_set('error_log',APPLICATION_PATH.'logs'.DS.'error_log');
    }

    /**
     * Hypertext Transfer Protocol (HTTP) response status codes
     * This function helps you to create your own (HTTP) response status codes pages
     * You can create your error page on ./application/errors/ folder with same response status codes
     *
     * @param integer $code response status codes
     *
     * @access public
     * @static
     * @see http://en.wikipedia.org/wiki/List_of_HTTP_status_codes
     * @see http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html
     */
    public static function status($code)
    {
        if (is_integer($code))
        {
            $error_page = APPLICATION_PATH.'errors'.DS.$code.EXT;

            if (file_exists($error_page))
            {
                include $error_page;
            }
            else
            {
                exit($code);
            }
        }
    }

}

/**
 * End of file error.php
 *
 * @created  21/03/2013 03:56 pm
 * @updated  25/03/2013 01:57 pm
 * @location ./system/errors/error.php
 */

?>
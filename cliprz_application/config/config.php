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
 *  File path BASE_PATH/cliprz_application/config/ .
 *  File name config.php .
 *  Created date 21/11/2012 01:00 AM.
 *  Last modification date 22/01/2013 06:00 PM.
 *
 * Description :
 *  Config file.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

/**
 * Database Connection.
 *
 * @var (string) $_config['db']['host'] - Database host server.
 * @var (string) $_config['db']['user'] - Database username.
 * @var (string) $_config['db']['pass'] - Database password.
 * @var (string) $_config['db']['name'] - Database name.
 * @var (string) $_config['db']['prefix'] - Database prefix, Be sure to end the prefix with  _ mark.
 * @var (string) $_config['db']['charset'] - Database charset, We believe that the best encoding is UTF-8,
 *  You can change charset to what you need.
 * @var (string) $_config['db']['collation'] - Server connection collation.
 * @var (string) $_config['db']['port'] - Specifies the port number to attempt to connect to the MySQL server,
 *  By default 3306, If you get an error like Can't connect to MySQL server on 'localhost' (10061) repalce value with null.
 * @var (string) $_config['db']['socket'] - Specifies the socket or named pipe that should be used.
 * @var (boolean) $_config['db']['pconnect'] - if you wan't to use mysql and pconnect function, Change the value to true.
 */
$_config['db']['host']      = "localhost";
$_config['db']['user']      = "root";
$_config['db']['pass']      = "";
$_config['db']['name']      = "";
$_config['db']['prefix']    = "";
$_config['db']['charset']   = "utf8";
$_config['db']['collation'] = "utf8_unicode_ci";
$_config['db']['port']      = null; // By default port is 3306
$_config['db']['socket']    = null;
$_config['db']['pconnect']  = false; // use in MySQLi, SQLite Only.


/**
 * Output, Multibyte String and charset.
 *
 * @var (string) ['output']['url'] - your website full URL.
 * @var (string) ['output']['charset'] - your website charset as default UTF-8.
 */
$_config['output']['url']     = "http://localhost/Cliprz/";
$_config['output']['charset'] = "UTF-8";

/**
 * Database driver.
 *
 * @var (boolean) $_config['db']['use_database']  - use a database.
 * @var (string) $_config['db']['driver_path'] - Driver path name in 'cliprz_system/databases' folder.
 *
 * You can use:
 *  'mysql' // Removed by Yousef Ismaeil - 06/01/2013 06:44 PM
 *  'mysqli'
 *  'sqlite'
 */
$_config['db']['use_database'] = false;
$_config['db']['driver']       = "mysqli";


/**
 * Languages
 *
 * @var (string) $_config['language']['name'] - Language name.
 * @var (string) $_config['language']['code'] - Language short code name.
 * @var (string) $_config['language']['direction'] - Language direction.
 *  $_config['language']['direction'] :
 *   'ltr' - Left to right.
 *   'rtl' - Right to left.
 *
 * Note: You can change the values later, in c_language() function.
 */
$_config['language']['name']      = "english";
$_config['language']['code']      = "en";
$_config['language']['direction'] = "ltr";

/**
 * Date and time
 *
 * @var (string) $_config['datetime']['timezone'] - Sets the default timezone used by all date/time functions in a script.
 *  Get List of Supported Timezones : http://php.net/manual/en/timezones.php
 */
$_config['datetime']['timezone'] = null;

/**
 * Sessions and Cookies
 *
 * @var (string) $_config['session']['name'] - Session name.
 * @var (string) $_config['session']['prefix'] - Session prefix, You can change prefix for security reasons.
 * @var (string) $_config['session']['save_path'] - Session save path, By default BASE_PATH/cliprz_application/cache/sessions/.
 * @var (integer) $_config['session']['gc_maxlifetime'] - Change gc_maxlifetime value in php.ini.
 * @var (integer) $_config['session']['gc_probability'] - Change gc_probability value in php.ini.
 * @var (integer) $_config['session']['gc_divisor'] - Change gc_divisor value in php.ini.
 */
$_config['session']['name']           = "CLIPRZCOOKIE";
$_config['session']['prefix']         = "cliprz_cookie_";
$_config['session']['gc_maxlifetime'] = 34560;
$_config['session']['gc_probability'] = 1;
$_config['session']['gc_divisor']     = 100;

/**
 * ReCaptcha Keys
 *
 * @var (string) $_config['recaptcha']['publickey'] - Use this in the JavaScript code that is served to your users.
 * @var (string) $_config['recaptcha']['privatekey'] - Use this when communicating between your server and our server.
 *
 * Get more about recaptcha https://www.google.com/recaptcha/.
 */
$_config['recaptcha']['publickey']  = "";
$_config['recaptcha']['privatekey'] = ""; // Be sure to keep it a secret.
$_config['recaptcha']['response']   = null;
$_config['recaptcha']['error']      = null;

/**
 * URI protocol
 *
 * @(var) (string) $_config['uri']['protocol'] - Router requested type. By default REQUEST_URI.
 * $_config['uri']['protocol'] :
 *  'REQUEST_URI' - use REQUEST_URI method with filtering.
 *  'PHP_SELF'    - use PHP_SELF method with filtering.
 *  'PATH_INFO'   - use PATH_INFO method with filtering.
 */
$_config['uri']['protocol'] = "REQUEST_URI";

?>
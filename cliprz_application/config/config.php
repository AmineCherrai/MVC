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
 *  File path BASE_PATH/cliprz_application/config/ .
 *  File name config.php .
 *  Created date 21/11/2012 01:00 AM.
 *  Last modification date 14/02/2013 03:49 PM.
 *
 * Description :
 *  Configuration file.
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
 * @var (string)  $_config['db']['host']      - Database host server.
 * @var (string)  $_config['db']['user']      - Database username.
 * @var (string)  $_config['db']['pass']      - Database password.
 * @var (string)  $_config['db']['name']      - Database name.
 * @var (string)  $_config['db']['prefix']    - Database prefix, Be sure to end the prefix with  _ mark.
 * @var (string)  $_config['db']['charset']   - Database charset, We believe that the best encoding is UTF-8, You can change charset to what you need.
 * @var (string)  $_config['db']['collation'] - Server connection collation.
 * @var (string)  $_config['db']['port']      - Specifies the port number to attempt to connect to the MySQL server,
 *  By default 3306, If you get an error like Can't connect to MySQL server on 'localhost' (10061) repalce value with null.
 * @var (string)  $_config['db']['socket']    - Specifies the socket or named pipe that should be used.
 * @var (boolean) $_config['db']['pconnect']  - if you wan't to use mysql and pconnect function, Change the value to true.
 * @var (boolean) $_config['db']['options']   - if you wan't to some options for database, like PDO PHP Dataa Objects.
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
$_config['db']['options']   = array();


/**
 * Output, Multibyte String and charset.
 *
 * @var (string) ['output']['url']     - your website full URL.
 * @var (string) ['output']['charset'] - your website charset as default UTF-8.
 */
$_config['output']['url']     = "http://localhost/Cliprz";
$_config['output']['charset'] = "UTF-8";

/**
 * Database driver.
 *
 * @var (boolean) $_config['db']['use_database']  - use a database.
 * @var (string) $_config['db']['driver_path']    - Driver path name in 'cliprz_system/databases' folder.
 *
 * You can use:
 *  'mysql' // Removed by Yousef Ismaeil - 06/01/2013 06:44 PM
 *  'mysqli'
 */
$_config['db']['use_database'] = false;
$_config['db']['driver']       = "mysqli";


/**
 * Languages
 *
 * @var (string) $_config['language']['name']      - Language name.
 * @var (string) $_config['language']['code']      - Language short code name.
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
 * @var (string)  $_config['session']['name']            - Session name.
 * @var (string)  $_config['session']['prefix']          - Session prefix, You can change prefix for security reasons.
 * @var (boolean) $_config['session']['use_handler']     - Use a sessions handler, this configuration write your sessions in path of your choice with sessions files or in database.
 * @var (string)  $_config['session']['handler_type']    - You can choose 'files' to save sessions in files or 'database' to save sessions in database.
 * @var (string)  $_config['session']['save_path']       - Session save path, By default BASE_PATH/cliprz_application/cache/sessions/.
 * @var (integer) $_config['session']['cookie_lifetime'] - Lifetime in seconds of cookie or, if 0, until browser is restarted, Default is week 604800.
 * @var (string)  $_config['session']['cookie_path']     - The path for which the cookie is valid. By default '/'.
 * @var (string)  $_config['session']['cookie_domain']   - Cookie domain, for example 'www.cliprz.org'. To make cookies visible on all subdomains then the domain must be prefixed with a dot like '.cliprz.org'. By default null.
 * @var (string)  $_config['session']['cookie_secure']   - If TRUE cookie will only be sent over secure connections.
 * @var (string)  $_config['session']['cookie_httponly'] - If set to TRUE then PHP will attempt to send the httponly flag when setting the session cookie.
 * @var (integer) $_config['session']['gc_maxlifetime']  - Change gc_maxlifetime value in php.ini.
 * @var (integer) $_config['session']['gc_probability']  - Change gc_probability value in php.ini.
 * @var (integer) $_config['session']['gc_divisor']      - Change gc_divisor value in php.ini.
 * @var (boolean) $_config['session']['encrypt']         - Encrypt session names, its good for session security.
 */
$_config['session']['name']            = "CLIPRZCOOKIE";
$_config['session']['prefix']          = "cliprz_cookie_";
$_config['session']['use_handler']     = true; // If this FALSE you will get php.ini session configuration.
$_config['session']['handler_type']    = "files"; // $_config['session']['use_handler'] Must be with true value, You can use 'files' or 'database', if you use database you must enable $_config['db']['use_database'] to true.
$_config['session']['save_path']       = APP_PATH.'cache'.DS.'sessions';
$_config['session']['cookie_lifetime'] = 604800;
$_config['session']['cookie_path']     = DS;
$_config['session']['cookie_domain']   = null;
$_config['session']['cookie_secure']   = false;
$_config['session']['cookie_httponly'] = true; // This setting can effectively help to reduce identity theft through XSS attacks (although it is not supported by all browsers).
$_config['session']['gc_maxlifetime']  = 65535; // max value for "session.gc_maxlifetime" is 65535. values bigger than this may cause  php session stops working.
$_config['session']['gc_probability']  = 1;
$_config['session']['gc_divisor']      = 100;
$_config['session']['encrypt']         = true; // For more security leave it as true to Encrypt sessions.

/**
 * ReCaptcha Keys
 *
 * @var (string) $_config['recaptcha']['publickey']  - Use this in the JavaScript code that is served to your users.
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
 *  $_config['uri']['protocol'] :
 *   'REQUEST_URI' - use REQUEST_URI method with filtering.
 *   'PHP_SELF'    - use PHP_SELF method with filtering.
 *   'PATH_INFO'   - use PATH_INFO method with filtering.
 */
$_config['uri']['protocol'] = "REQUEST_URI";

/**
 * Console and execution.
 *
 * @var (boolean) $_config['console']['execute']   - Show execution time if true, Note you should in C_DEVELOPMENT_ENVIRONMENT to get this execution.
 * @var (boolean) $_config['console']['benchmark'] - Calculate Cliprz framework Project speed.
 */
$_config['console']['execute']   = true; // Warning make it false if you are in real server.
//$_config['console']['benchmark'] = false; // Warning make it false if you are in real server.

/**
 * CAP - Cliprz Admin Panel.
 *
 * @var (boolean) $_config['cap']['enabled'] - Enable capanel to use it in you project, by the way you can create your admin panel as you wish without useing capanel.
 * @var (string)  $_config['cap']['name']    - Capanel name in routing as in example if value is 'capanel' all urls will http://example/capanel/rules.
 * @var (string)  $_config['cap']['theme']   - Capanel theme.
 */
$_config['cap']['enabled'] = false;
$_config['cap']['name']    = 'CAPanel';
$_config['cap']['theme']   = "default";

?>
<?php

/**
 * Here you can configuration your project
 *
 * @author    Your name
 * @copyright copyrights (c) 2012 - 2013 By your name or company name
 * @license   http://example/Project/license
 * @link      http://projecturl/
 */

/**
 * Project
 *
 * @var string $_config['project']['url'] Project full URL
 */
$_config['project']['url']     = 'http://localhost/cliprz';

/**
 * Database
 *
 * @var boolean $_config['database']['connect']   Use MySQL database object, if TRUE MySQL database will enabled to use
 * @var string  $_config['database']['host']      Database Host name
 * @var string  $_config['database']['user']      Database Username
 * @var string  $_config['database']['pass']      Database Password
 * @var string  $_config['database']['name']      Database Table name
 * @var string  $_config['database']['prefix']    Database prefix
 * @var string  $_config['database']['charset']   Database charset
 * @var string  $_config['database']['collation'] Database collation
 * @var integer $_config['database']['port']      Database connection prot
 * @var string  $_config['database']['socket']    Database socket
 * @var boolean $_config['database']['pconnect']  Use mysql pconnect function if FALSE database object will use normal connect
 * @var array   $_config['database']['options']   More options in MySQL database connection
 */
$_config['database']['connect']   = FALSE;
$_config['database']['host']      = 'localhost';
$_config['database']['user']      = 'root';
$_config['database']['pass']      = '';
$_config['database']['name']      = '';
$_config['database']['prefix']    = NULL;
$_config['database']['charset']   = 'utf8';
$_config['database']['collation'] = 'utf8_unicode_ci';
$_config['database']['port']      = NULL; // By default port is 3306
$_config['database']['socket']    = NULL;
$_config['database']['pconnect']  = FALSE;
#$_config['database']['options']   = array();

/**
 * Cookies and sessions
 *
 * @var string $_config['session']['handle']          How do you want handling cookies as sessinos
 *                                                     'files'    Hanlding sessions in files
 *                                                     'database' Hanlding sessions in MySQL database
 *                                                     'php'      Hanlding sessions as default php.ini configuration
 *                                                    By default files
 * @var string  $_config['session']['prefix']          Sessions prefix
 * @var string  $_config['session']['name']            Session (cookie) Name
 * @var string  $_config['session']['save_path']       If $_config['session']['handle'] value is files you must choose a session save path
 * @var integer $_config['session']['cookie_lifetime'] Lifetime in seconds of cookie or, if 0, until browser is restarted, Default is week 604800
 * @var string  $_config['session']['cookie_path']     The path for which the cookie is valid. By default '/'
 * @var string  $_config['session']['cookie_domain']   Cookie domain, for example 'www.cliprz.org'. To make cookies visible on all subdomains then the domain must be prefixed with a dot like '.cliprz.org'. By default null
 * @var string  $_config['session']['cookie_secure']   If TRUE cookie will only be sent over secure connections
 * @var string  $_config['session']['cookie_httponly'] If set to TRUE then PHP will attempt to send the httponly flag when setting the session cookie
 * @var integer $_config['session']['gc_maxlifetime']  Change gc_maxlifetime value in php.ini
 * @var integer $_config['session']['gc_probability']  Change gc_probability value in php.ini
 * @var integer $_config['session']['gc_divisor']      Change gc_divisor value in php.ini
 * @var boolean $_config['session']['encrypt']         Encrypt session names, its good for session security
 */
$_config['session']['handle']          = 'files';
$_config['session']['prefix']          = 'cliprz_';
$_config['session']['name']            = 'CLIPRZCOOKIE';
$_config['session']['save_path']       = APPLICATION_PATH.'cache'.DS.'sessions';
$_config['session']['cookie_lifetime'] = 604800;
$_config['session']['cookie_path']     = DS;
$_config['session']['cookie_domain']   = NULL;
$_config['session']['cookie_secure']   = FALSE;
$_config['session']['cookie_httponly'] = TRUE; // This setting can effectively help to reduce identity theft through XSS attacks (although it is not supported by all browsers)
$_config['session']['gc_maxlifetime']  = 65535; // max value for "session.gc_maxlifetime" is 65535. values bigger than this may cause  php session stops working
$_config['session']['gc_probability']  = 1;
$_config['session']['gc_divisor']      = 100;
$_config['session']['encrypt']         = TRUE; // For more security leave it as true to Encrypt sessions

/**
 * Languages
 *
 * @var string $_config['language']['name']       Language packge
 * @var string $_config['language']['direction']  Language direction
 */
$_config['language']['name']      = 'english';
#$_config['language']['direction'] = 'ltr';

/**
 * Protocol
 *
 * @var string $_config['protocol']['uri'] Protocol request URI you can use
 *                                          'REQUEST_URI'
 *                                          'PHP_SELF'
 *                                          'PATH_INFO'
 *                                         REQUEST_URI is default
 */
$_config['protocol']['uri'] = 'REQUEST_URI';

/**
 * Cache
 *
 * @var integer $_config['cache']['time'] Cache default time
 */
$_config['cache']['time'] = 5 * 60; // Five minutes

/**
 * Time and date
 *
 * @var string $_config['time']['zone'] Sets the default timezone used by all date/time functions in a script,
 *                                       Get List of Supported Timezones : http://php.net/manual/en/timezones.php
 */
$_config['time']['zone'] = NULL;

?>
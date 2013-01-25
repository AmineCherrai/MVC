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
 *  File path BASE_PATH/cliprz_system/databases/ .
 *  File name database.php .
 *  Created date 06/01/2013 01:52 PM.
 *  Last modification date 06/01/2013 06:52 PM.
 *
 * Description :
 *  Database abstract class.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

class cliprz_database
{

    /**
     * @var (array) $_connection - Connection values.
     * @access protected.
     */
    protected static $_connection;

    /**
     * @var (array) $_driver - Driver object.
     * @access protected.
     */
    protected static $_driver;

    /**
     * @var (string) $prefix - Database prefix.
     * @access protected.
     */
    protected static $prefix;

    /**
     * @var (resource) $link_identifier - Driver connection link identifier.
     * @access protected.
     */
    #protected static $link_identifier;

    /**
     * Database Construct
     *
     * @access public.
     */
    public function __construct()
    {
        self::load_driver();
        self::$_connection = self::link_identifier();
    }

    /**
     * Load driver.
     *
     * @access protected.
     */
    protected static function load_driver ()
    {
        global $_config;

        $define = strtoupper(CLIPRZ)."DATABASE_DRIVER_".strtoupper($_config['db']['driver'])."_INCLUDED";

        if (!defined($define))
        {
            $driver_path = SYS_PATH."databases".DS."drivers".DS
                .$_config['db']['driver'].DS.$_config['db']['driver'].".php";

            if (file_exists($driver_path))
            {
                require_once ($driver_path);

                $driver_class_name = (string) CLIPRZ."database_driver_".$_config['db']['driver'];

                if (class_exists($driver_class_name))
                {
                    self::$_driver = new $driver_class_name();
                    self::connect();
                    self::select_db();
                    self::set_charset();
                }
                else
                {
                    trigger_error($driver_class_name." class not exists.");
                }
            }
            else
            {
                trigger_error($_config['db']['driver']." not exists");
            }
        }
        else
        {
            trigger_error($define." not defined.");
        }
    }

    /**
     * Start Connection to database driver.
     *
     * @access protected.
     */
    protected static function connect ()
    {
        return self::$_driver->connect();
    }

    /**
     * Start select a database name.
     *
     * @access protected.
     */
    protected static function select_db ()
    {
        return self::$_driver->select_db();
    }

    /**
     * Set database charset.
     *
     * @access protected.
     */
    protected static function set_charset ()
    {
        return self::$_driver->set_charset();
    }

    /**
     * Close Connection to database driver.
     *
     * @access public.
     */
    public static function close ()
    {
        return self::$_driver->close();
    }

    /**
     * Connection link identifier.
     *
     * @access protected.
     */
    protected static function link_identifier ()
    {
        return self::$_driver->link_identifier();
    }

    /**
     * Database prefix.
     *
     * @access public.
     */
    public static function prefix ()
    {
        return self::$_driver->prefix();
    }

    /**
     * Get database version.
     *
     * @access public.
     */
    public static function version ()
    {
        return self::$_driver->version();
    }

    /**
     * Send a SQL query.
     *
     * @param (string) $sql - SQL query.
     * @access public.
     */
    public static function query ($sql)
    {
        return self::$_driver->query($sql);
    }

    /**
     * Selection from the database driver tables.
     *
     * @param (string) $table - table name in database.
     * @param (string) $fields - fields name.
     * @param (string) $where - where SQL.
     * @param (string) $orderby - ORDER BY SQL.
     * @param (string) $limit - LIMIT SQL.
     * @access public.
     */
    public static function select($table,$fields='*',$where='',$orderby='',$limit='')
    {
        return self::$_driver->select($table,$fields,$where,$orderby,$limit);
    }

    /**
     * Insert data into database driver.
     *
     * @param (string) $table - table name in database.
     * @param (array) $array - post variables with Keys.
     * @access public.
     */
    public static function insert($table,$array)
    {
        return self::$_driver->insert($table,$array);
    }

    /**
     * Update database driver data.
     *
     * @param (string) $table - table name in database.
     * @param (array) $array - Array with Keys.
     * @param (string) $where -  Where $_GET.
     * @param (string) $limit - Limit.
     * @param (boolean) $no_quote - Quote default is false (true or false).
     * @access public.
     */
    public static function update($table, $array, $where="", $limit="", $no_quote=false)
    {
        return self::$_driver->update($table, $array, $where, $limit, $no_quote);
    }

    /**
     * Update data from database driver where Specific SQL requested.
     *
     * @param (string) $table - table name in database.
     * @param (string) $fields - field names.
     * @param (string) $where - where id = $_GET['id'];.
     * @access public.
     */
    public static function update_where($table,$fields,$where)
    {
        return self::$_driver->update_where($table,$fields,$where);
    }

    /**
     * Delete data from database driver where Specific SQL requested.
     *
     * @param (string) $table - table name in database.
     * @param (string) $field_name - field name.
     * @param (string) $where - Where value.
     * @access public.
     */
    public static function delete($table,$field_name,$where)
    {
        return self::$_driver->delete($table,$field_name,$where);
    }

    /**
     * Escapes special characters in a string for use in an SQL statement.
     *
     * @param (string) $str - The string that is to be escaped.
     * @access public.
     */
    public static function real_escape_string($str)
    {
        return self::$_driver->real_escape_string($str);
    }

    /****************************************/
    // Result methods
    /****************************************/

    /**
     * Fetch a result row as an associative array.
     * Returns an associative array that corresponds to the fetched row and moves the internal data pointer ahead.
     *
     * @param (resource) $result - result.
     * @access public.
     */
    public static function fetch_assoc($result)
    {
        return self::$_driver->fetch_assoc($result);
    }

    /**
     * Fetch a result row as an associative array, a numeric array, or both.
     * Returns an array that corresponds to the fetched row and moves the internal data pointer ahead.
     *
     * @param (resource) $result - result.
     * @access public.
     */
    public static function fetch_array($result)
    {
        return self::$_driver->fetch_array($result);
    }

    /**
     * Fetch a result row as an object.
     * Returns an object with properties that correspond to the fetched row and moves the internal data pointer ahead.
     *
     * @param (resource) $result - result.
     * @access public.
     */
    public static function fetch_object($result)
    {
        return self::$_driver->fetch_object($result);
    }

    /**
     * Get a result row as an enumerated array.
     *
     * @param (resource) $result - Result.
     * @access public.
     */
    public static function fetch_row($result)
    {
        return self::$_driver->fetch_row($result);
    }

    /**
     * Free result memory.
     * will free all memory associated with the result identifier result.
     *
     * @param (resource) $result - result.
     * @access public.
     */
    public static function free_result($result)
    {
        return self::$_driver->free_result($result);
    }

    /**
     * Get number of rows in result.
     *
     * @param (resource) $result - result.
     * @access public.
     */
    public static function num_rows($result)
    {
        return self::$_driver->num_rows($result);
    }

    /**
     * Get number of fields in result.
     *
     * @param (resource) $result - result.
     * @access public.
     */
    public static function num_fields($result)
    {
        return self::$_driver->num_fields($result);
    }

    /**
     * Get number of affected rows in previous database driver operation.
     *
     * @access public.
     */
    public static function affected_rows()
    {
        return self::$_driver->affected_rows();
    }

    /****************************************/
    // Forge methods
    /****************************************/

    /****************************************/
    // Utility methods
    /****************************************/

}

?>
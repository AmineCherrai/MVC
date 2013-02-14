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
 *  File path BASE_PATH/cliprz_system/databases/ .
 *  File name database.php .
 *  Created date 06/01/2013 01:52 PM.
 *  Last modification date 10/02/2013 11:42 AM.
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

c_call_exception(database,database.'s');

class cliprz_database
{

    /**
     * @var (object) $driver - Driver object.
     * @access protected.
     */
    protected static $driver;

    /**
     * @var (resoucrc) $link_identifier - A connection link identifier.
     * @access protected.
     */
    #protected static $link_identifier;

    /**
     * Database constructor.
     *
     * @access public.
     */
    public function __construct()
    {
        self::load_driver();

        try
        {
            // Checl if object is exists
            if (!is_object(self::$driver))
            {
                throw new database_exception("Driver object not exists.");
            }
            else // Start connections to driver and database
            {
                // Connect to database.
                self::connect();

                // Pings a server connection, or tries to reconnect if the connection has gone down.
                self::ping();

                // Select a database.
                self::select_db();

                // Sets the default client character set.
                self::set_charset();
                self::character_set_name();
            }
        }
        catch (database_exception $e)
        {
            c_log_error($e,'WARNING');
        }

    }

    /**
     * Load driver.
     *
     * @access protected.
     */
    protected static function load_driver ()
    {
        global $_config;

        // Get driver name
        $driver_name = strtolower($_config['db']['driver']);

        // Get driver path
        $driver_path = SYS_PATH.database.'s'.DS.'drivers'.DS.$driver_name.DS.$driver_name.'.php';

        try
        {
            // Check if driver exists
            if (file_exists($driver_path))
            {
                // Call driver
                include $driver_path;

                // Get driver define.
                $driver_define = strtoupper(CLIPRZ.'_DATABASE_DRIVER_'.$_config['db']['driver'].'_INCLUDED');

                // Check if is defined CLIPRZ_DATABASE_DRIVER_NAME_INCLUDED.
                if (defined($driver_define))
                {
                    // Get driver object name.
                    $driver_object = (string) strtolower(CLIPRZ.'_database_driver_'.$driver_name);

                    // Check if driver class is exists
                    if (class_exists($driver_object))
                    {
                        // Create new object.
                        self::$driver = new $driver_object();
                    }
                    else
                    {
                        throw new database_exception($driver_object.' class not exists.');
                    }
                }
                else
                {
                    throw new database_exception($driver_define.' not defined.');
                }
            }
            else
            {
                throw new database_exception($_config['db']['driver'].' driver not exists.');
            }
        }
        catch (database_exception $e)
        {
            c_log_error($e,'WARNING');
        }
    }

    /********************************************************************/
    /****************************** Driver ******************************/
    /********************************************************************/

    /**
     * Start connection to database.
     *
     * @access protected.
     */
    protected static function connect ()
    {
        return self::$driver->connect();
    }

    /**
     * Pings a server connection, or tries to reconnect if the connection has gone down.
     *
     * @access public.
     */
    public static function ping ()
    {
        return self::$driver->ping();
    }

    /**
     * Selects the default database for database queries.
     *
     * @access protected.
     */
    protected static function select_db ()
    {
        return self::$driver->select_db();
    }

    /**
     * Sets the default client character set.
     *
     * @access protected.
     */
    protected static function set_charset ()
    {
        return self::$driver->set_charset();
    }

    /**
     * Returns the default character set for the database connection.
     *
     * @access protected.
     */
    protected static function character_set_name ()
    {
        return self::$driver->character_set_name();
    }

    /**
     * Get connection link identifier.
     *
     * @access public.
     */
    public static function link ()
    {
        return self::$driver->link_identifier();
    }

    /**
     * Performs a query on the database.
     *
     * @param (string) $query - The query string.
     * @access public.
     */
    public static function query ($query)
    {
        return self::$driver->query($query);
    }

    /**
     * Escapes special characters in a string for use in an SQL statement. (Real escape string).
     *
     * @param (string) $escapestr - The string to be escaped.
     * @access public.
     */
    public static function res($escapestr)
    {
        return self::$driver->res($escapestr);
    }

    /**
     * Gets the number of affected rows in a previous SQL operation.
     *
     * @access public.
     */
    public static function affected_rows ()
    {
        return self::$driver->affected_rows();
    }

    /**
     * Returns the auto generated id used in the last query.
     *
     * @access public.
     */
    public static function insert_id ()
    {
        return self::$driver->insert_id();
    }

    /**
     * Returns a string description of the last error.
     *
     * @access public.
     */
    public static function error ()
    {
        return self::$driver->error();
    }

    /**
     * Returns the error code for the most recent function call.
     *
     * @access public.
     */
    public static function errno ()
    {
        return self::$driver->errno();
    }

    /**
     * Returns a string description of the last connect error.
     *
     * @access public.
     */
    public static function connect_error ()
    {
        return self::$driver->connect_error();
    }

    /**
     * Returns the error code from last connect call.
     *
     * @access public.
     */
    public static function connect_errno ()
    {
        return self::$driver->connect_errno();
    }

    /**
     * Get driver Version number.
     *
     * @access public.
     */
    public static function version ()
    {
        return self::$driver->version();
    }

    /**
     * Get driver Platform.
     *
     * @access public.
     */
    public static function platform ()
    {
        return self::$driver->platform();
    }

    /**
     * Closes a previously opened database connection.
     *
     * @access public.
     */
    public static function close ()
    {
        return self::$driver->close();
    }

    /**
     * Selection from the database tables.
     *
     * @param (string) $table   - Table name.
     * @param (string) $fields  - Fields names.
     * @param (string) $where   - Where SQL.
     * @param (string) $orderby - Order By SQL.
     * @param (string) $limit   - Limit SQL.
     * @access public.
     */
    public static function select ($table,$fields='*',$where='',$orderby='',$limit='')
    {
        return self::$driver->select($table,$fields,$where,$orderby,$limit);
    }

    /**
     * Insert data into database.
     *
     * @param (string) $table - Table name.
     * @param (array)  $posts - posts as array with keys.
     * @access public.
     */
    public static function insert ($table,$posts)
    {
        return self::$driver->insert($table,$posts);
    }

    /**
     * Update data from database.
     *
     * @param (string)  $table    - Table name.
     * @param (array)   $posts    - posts as array with keys.
     * @param (string)  $where    - Where SQL.
     * @param (array)   $limit    - Limit SQL.
     * @param (boolean) $no_quote - no quote.
     * @access public.
     */
    public static function update ($table, $posts, $where="", $limit="", $no_quote=false)
    {
        return self::$driver->update($table,$posts,$where,$limit,$no_quote);
    }

    /**
     * Update data from database where Specific SQL requested.
     *
     * @param (string) $table  - Table name.
     * @param (string) $fields - Fields names.
     * @param (string) $where  - Where SQL.
     * @access public.
     */
    public static function update_where ($table,$fields,$where)
    {
        return self::$driver->update_where($table,$fields,$where);
    }

    /**
     * Delete data from database where Specific SQL requested.
     *
     * @param (string) $table - Table name.
     * @param (string) $where - Where SQL.
     * @access public.
     */
    public static function delete ($table,$where)
    {
        return self::$driver->delete($table,$where);
    }

    /**
     * Changes the user of the specified database connection.
     *
     * @param (string) $database_name - The new database name.
     * @access public.
     */
    public static function change_user ($database_name)
    {
        return self::$driver->change_user($database_name);
    }

    /********************************************************************/
    /****************************** Result ******************************/
    /********************************************************************/

    /**
     * Fetch a result row as an associative, a numeric array, or both.
     *
     * @param (string) $result     - A result set identifier returned by query.
     * @param (string) $resulttype - This optional parameter is a constant indicating what type of array should be produced from the current row data.
     *  $resulttype :
     *   'ASSOC'
     *   'NUM'
     *   'BOTH'
     * @access public.
     */
    public static function fetch_array ($result,$resulttype='')
    {
        return self::$driver->fetch_array($result,$resulttype);
    }

    /**
     * Returns the current row of a result set as an object.
     *
     * @param (string) $result     - A result set identifier returned by query.
     * @param (string) $class_name - The name of the class to instantiate, set the properties of and return. If not specified, a stdClass object is returned.
     * @param (array)  $params     - An optional array of parameters to pass to the constructor for class_name objects.
     * @access public.
     */
    public static function fetch_object ($result,$class_name=null,$params=null)
    {
        return self::$driver->fetch_object($result,$class_name,$params);
    }

    /**
     * Fetch a result row as an associative array
     *
     * @param (string) $result - A result set identifier returned by query.
     * @access public.
     */
    public static function fetch_assoc ($result)
    {
        return self::$driver->fetch_assoc($result);
    }

    /**
     * Fetches all result rows as an associative array, a numeric array, or both.
     *
     * @param (string) $result     - A result set identifier returned by query.
     * @param (string) $resulttype - This optional parameter is a constant indicating what type of array should be produced from the current row data.
     *  $resulttype :
     *   'ASSOC'
     *   'NUM'
     *   'BOTH'
     * @access public.
     */
    public static function fetch_all ($result,$resulttype='')
    {
        return self::$driver->fetch_all($result,$resulttype);
    }

    /**
     * Returns the next field in the result set.
     *
     * @param (string) $result - A result set identifier returned by query.
     * @access public.
     */
    public static function fetch_field ($result)
    {
        return self::$driver->fetch_field($result);
    }

    /**
     * Returns an array of objects representing the fields in a result set.
     *
     * @param (string) $result - A result set identifier returned by query.
     * @access public.
     */
    public static function fetch_fields ($result)
    {
        return self::$driver->fetch_fields($result);
    }

    /**
     * Get a result row as an enumerated array.
     *
     * @param (string) $result - A result set identifier returned by query.
     * @access public.
     */
    public static function fetch_row ($result)
    {
        return self::$driver->fetch_row($result);
    }

    /**
     * Get the number of fields in a result.
     *
     * @param (string) $result - A result set identifier returned by query.
     * @access public.
     */
    public static function num_fields ($result)
    {
        return self::$driver->num_fields($result);
    }

    /**
     * Frees the memory associated with a result.
     *
     * @param (string) $result - A result set identifier returned by query.
     * @access public.
     */
    public static function free_result ($result)
    {
        return self::$driver->free_result($result);
    }

    /**
     * Returns the lengths of the columns of the current row in the result set.
     *
     * @param (string) $result - A result set identifier returned by query.
     * @access public.
     */
    public static function fetch_lengths ($result)
    {
        return self::$driver->fetch_lengths($result);
    }

    /**
     * Gets the number of rows in a result.
     *
     * @param (string) $result - A result set identifier returned by query.
     * @access public.
     */
    public static function num_rows ($result)
    {
        return self::$driver->num_rows($result);
    }

    /*******************************************************************/
    /****************************** Forge ******************************/
    /*******************************************************************/

    /**
     * Create a new database.
     *
     * @param (string) $database_name - Database name.
     * @access public.
     */
    public static function create_database ($database_name)
    {
        return self::$driver->create_database($database_name);
    }

    /**
     * Drop a database.
     *
     * @param (string) $database_name - Database name.
     * @access public.
     */
    public static function drop_database ($database_name)
    {
        return self::$driver->drop_database($database_name);
    }

    /**
     * Create a new table.
     *
     * @param (string) $table_name - Table name without prefix.
     * @access public.
     */
    public static function create_table ($table_name)
    {
        return self::$driver->create_table($table_name);
    }

    /**
     * Drop a table.
     *
     * @param (string) $table_name - Table name  without prefix.
     * @access public.
     */
    public static function drop_table ($table_name)
    {
        return self::$driver->drop_table($table_name);
    }

    /**
     * Rename table.
     *
     * @param (string) $old_table_name - Old table name, Note without prefix.
     * @param (string) $new_table_name - New table name, Note without prefix.
     * @access public.
     */
    public static function rename_table ($old_table_name,$new_table_name)
    {
        return self::$driver->rename_table($old_table_name,$new_table_name);
    }

    /*********************************************************************/
    /****************************** utility ******************************/
    /*********************************************************************/

    /**
     * Get all databases list.
     *
     * @access public.
     */
    public static function list_databases ()
    {
        return self::$driver->list_databases();
    }

    /**
     * Optimize table.
     *
     * @param (string) $table_name - Table name without prefix.
     * @access public.
     */
    public static function optimize_table ($table_name)
    {
        return self::$driver->optimize_table($table_name);
    }

    /**
     * Repair table.
     *
     * @param (string) $table_name - Table name without prefix.
     * @access public.
     */
    public static function repair_table ($table_name)
    {
        return self::$driver->repair_table($table_name);
    }

    /**
     * Get database backup.
     *
     * @access public.
     */
    public static function backup ()
    {
        return self::$driver->backup();
    }

}

?>
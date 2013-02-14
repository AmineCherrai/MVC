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
 *  File path BASE_PATH/cliprz_system/databases/drivers/{replace it to the driver name path}/.
 *  File name {replace it to the driver file name.php} .
 *  Created date {replace it to created data}.
 *  Last modification date {replace it to Last modification date}.
 *
 * Description :
 *  {replace it to the driver name} database class.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

// Replace {DRIVERNAME} from below define with the new driver name
define("CLIPRZ_DATABASE_DRIVER_{DRIVERNAME}_INCLUDED",true);

// Replace {drivername} with the new driver name
class cliprz_database_driver_{drivername}
{

    /**
     * @var (resource) $link_identifier - The database connection link.
     * @access protected.
     */
    protected $link_identifier;

    /********************************************************************/
    /****************************** Driver ******************************/
    /********************************************************************/

    /**
     * Start connection to database.
     *
     * @access public.
     */
    public function connect ()
    {
        global $_config;
        // Start your connection here you can global the $_config[db] here.
    }

    /**
     * Pings a server connection, or tries to reconnect if the connection has gone down.
     *
     * @access public.
     */
    public function ping ()
    {
        // return to true if you don't have a functino for this.
    }

    /**
     * Selects the default database for database queries.
     *
     * @access public.
     */
    public function select_db ()
    {
        global $_config;
        // Start selection here add you function to select a new database or return to true if don't have a function for this.
    }

    /**
     * Sets the default client character set.
     *
     * @access public.
     */
    public function set_charset ()
    {
        global $_config;
        //  Sets the default client character set or return to true if don't have a function for this.
    }

    /**
     * Returns the default character set for the database connection.
     *
     * @access public.
     */
    public function character_set_name ()
    {
        // Returns the default character set for the database connection or return to true if don't have a function for this.
    }

    /**
     * Get connection link identifier.
     *
     * @access public.
     */
    public function link ()
    {
        // Get connection link identifier or return to true if don't have a function for this.
    }

    /**
     * Performs a query on the database.
     *
     * @param (string) $query - The query string.
     * @access public.
     */
    public function query ($query)
    {
        // Performs a query on the database or return to true if don't have a function for this.
    }

    /**
     * Escapes special characters in a string for use in an SQL statement. (Real escape string).
     *
     * @param (string) $escapestr - The string to be escaped.
     * @access public.
     */
    public function res($escapestr)
    {
        // Escapes special characters in a string for use in an SQL statement or return to true if don't have a function for this.
    }

    /**
     * Gets the number of affected rows in a previous SQL operation.
     *
     * @access public.
     */
    public function affected_rows ()
    {
        // Gets the number of affected rows in a previous SQL operation or return to true if don't have a function for this.
    }

    /**
     * Returns the auto generated id used in the last query.
     *
     * @access public.
     */
    public function insert_id ()
    {
        // Returns the auto generated id used in the last query or return to true if don't have a function for this.
    }

    /**
     * Returns a string description of the last error.
     *
     * @access public.
     */
    public function error ()
    {
        // Returns a string description of the last error or return to true if don't have a function for this.
    }

    /**
     * Returns the error code for the most recent function call.
     *
     * @access public.
     */
    public function errno ()
    {
        // Returns the error code for the most recent function call or return to true if don't have a function for this.
    }

    /**
     * Returns a string description of the last connect error.
     *
     * @access public.
     */
    public function connect_error ()
    {
        // Returns a string description of the last connect error or return to true if don't have a function for this.
    }

    /**
     * Returns the error code from last connect call.
     *
     * @access public.
     */
    public function connect_errno ()
    {
        // Returns the error code from last connect call or return to true if don't have a function for this.
    }

    /**
     * Get driver Version number.
     *
     * @access public.
     */
    public function version ()
    {
        // Get driver Version number or return to true if don't have a function for this.
    }

    /**
     * Get driver Platform.
     *
     * @access public.
     */
    public function platform ()
    {
        // Get driver Platform or return to true if don't have a function for this.
    }

    /**
     * Closes a previously opened database connection.
     *
     * @access public.
     */
    public function close ()
    {
        // Closes a previously opened database connection or return to true if don't have a function for this.
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
    public function select ($table,$fields='*',$where='',$orderby='',$limit='')
    {
        // Selection from the database tables or return to true if don't have a function for this.
    }

    /**
     * Insert data into database.
     *
     * @param (string) $table - Table name.
     * @param (array)  $posts - posts as array with keys.
     * @access public.
     */
    public function insert ($table,$posts)
    {
        // Insert data into database or return to true if don't have a function for this.
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
    public function update ($table, $posts, $where="", $limit="", $no_quote=false)
    {
        // Update data from database or return to true if don't have a function for this.
    }

    /**
     * Update data from database where Specific SQL requested.
     *
     * @param (string) $table  - Table name.
     * @param (string) $fields - Fields names.
     * @param (string) $where  - Where SQL.
     * @access public.
     */
    public function update_where ($table,$fields,$where)
    {
        // Update data from database where Specific SQL requested or return to true if don't have a function for this.
    }

    /**
     * Delete data from database where Specific SQL requested.
     *
     * @param (string) $table - Table name.
     * @param (string) $where - Where SQL.
     * @access public.
     */
    public function delete ($table,$where)
    {
        // Delete data from database where Specific SQL requested or return to true if don't have a function for this.
    }

    /**
     * Changes the user of the specified database connection.
     *
     * @param (string) $database_name - The new database name.
     * @access public.
     */
    public function change_user ($database_name)
    {
        global $_config;
        // Changes the user of the specified database connection or return to true if don't have a function for this.
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
    public function fetch_array ($result,$resulttype='')
    {
        // Fetch a result row as an associative, a numeric array, or both or return to true if don't have a function for this.
    }

    /**
     * Returns the current row of a result set as an object.
     *
     * @param (string) $result     - A result set identifier returned by query.
     * @param (string) $class_name - The name of the class to instantiate, set the properties of and return. If not specified, a stdClass object is returned.
     * @param (array)  $params     - An optional array of parameters to pass to the constructor for class_name objects.
     * @access public.
     */
    public function fetch_object ($result,$class_name=null,$params=null)
    {
        // Returns the current row of a result set as an object or return to true if don't have a function for this.
    }

    /**
     * Fetch a result row as an associative array
     *
     * @param (string) $result - A result set identifier returned by query.
     * @access public.
     */
    public function fetch_assoc ($result)
    {
        // Fetch a result row as an associative array or return to true if don't have a function for this.
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
    public function fetch_all ($result,$resulttype='')
    {
        // Fetches all result rows as an associative array, a numeric array, or both or return to true if don't have a function for this.
    }

    /**
     * Returns the next field in the result set.
     *
     * @param (string) $result - A result set identifier returned by query.
     * @access public.
     */
    public function fetch_field ($result)
    {
        // Returns the next field in the result set or return to true if don't have a function for this.
    }

    /**
     * Returns an array of objects representing the fields in a result set.
     *
     * @param (string) $result - A result set identifier returned by query.
     * @access public.
     */
    public function fetch_fields ($result)
    {
        // Returns an array of objects representing the fields in a result set or return to true if don't have a function for this.
    }

    /**
     * Get a result row as an enumerated array.
     *
     * @param (string) $result - A result set identifier returned by query.
     * @access public.
     */
    public function fetch_row ($result)
    {
        // Get a result row as an enumerated array or return to true if don't have a function for this.
    }

    /**
     * Get the number of fields in a result.
     *
     * @param (string) $result - A result set identifier returned by query.
     * @access public.
     */
    public function num_fields ()
    {
        // Get the number of fields in a result or return to true if don't have a function for this.
    }

    /**
     * Frees the memory associated with a result.
     *
     * @param (string) $result - A result set identifier returned by query.
     * @access public.
     */
    public function free_result ($result)
    {
        // Frees the memory associated with a result or return to true if don't have a function for this.
    }

    /**
     * Returns the lengths of the columns of the current row in the result set.
     *
     * @param (string) $result - A result set identifier returned by query.
     * @access public.
     */
    public function fetch_lengths ($result)
    {
        // Returns the lengths of the columns of the current row in the result set or return to true if don't have a function for this.
    }

    /**
     * Gets the number of rows in a result.
     *
     * @param (string) $result - A result set identifier returned by query.
     * @access public.
     */
    public function num_rows ($result)
    {
        // Gets the number of rows in a result or return to true if don't have a function for this.
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
    public function create_database ($database_name)
    {
        // Create a new database or return to true if don't have a function for this.
    }

    /**
     * Drop a database.
     *
     * @param (string) $database_name - Database name.
     * @access public.
     */
    public function drop_database ($database_name)
    {
        // Drop a database or return to true if don't have a function for this.
    }

    /**
     * Create a new table.
     *
     * @param (string) $table_name - Table name without prefix.
     * @access public.
     */
    public function create_table ($table_name)
    {
        // Create a new table or return to true if don't have a function for this.
    }

    /**
     * Drop a table.
     *
     * @param (string) $table_name - Table name  without prefix.
     * @access public.
     */
    public function drop_table ($table_name)
    {
        // Drop a table or return to true if don't have a function for this.
    }

    /**
     * Rename table.
     *
     * @param (string) $old_table_name - Old table name, Note without prefix.
     * @param (string) $new_table_name - New table name, Note without prefix.
     * @access public.
     */
    public function rename_table ($old_table_name,$new_table_name)
    {
        // Rename table or return to true if don't have a function for this.
    }

    /*********************************************************************/
    /****************************** utility ******************************/
    /*********************************************************************/

    /**
     * Get all databases list.
     *
     * @access public.
     */
    public function list_databases ()
    {
        // Get all databases list or return to true if don't have a function for this.
    }

    /**
     * Optimize table.
     *
     * @param (string) $table_name - Table name without prefix.
     * @access public.
     */
    public function optimize_table ($table_name)
    {
        // Optimize table or return to true if don't have a function for this.
    }

    /**
     * Repair table.
     *
     * @param (string) $table_name - Table name without prefix.
     * @access public.
     */
    public function repair_table ($table_name)
    {
        // Repair table or return to true if don't have a function for this.
    }

    /**
     * Get database backup.
     *
     * @access public.
     */
    public function backup ()
    {
        // Get database backup or return to true if don't have a function for this.
    }

}

?>
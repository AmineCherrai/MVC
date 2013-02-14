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
 *  File path BASE_PATH/cliprz_system/databases/drivers/mysqli/.
 *  File name mysqli.php .
 *  Created date 06/01/2013 02:29 PM.
 *  Last modification date 10/02/2013 05:45 AM.
 *
 * Description :
 *  Mysqli database class.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

define("CLIPRZ_DATABASE_DRIVER_MYSQLI_INCLUDED",true);

class cliprz_database_driver_mysqli
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

        // Check if $_config['db']['port'] is null.
        if ($_config['db']['port'] === null)
        {
            $this->link_identifier = @mysqli_connect($_config['db']['host'],$_config['db']['user'],$_config['db']['pass']);
        }
        else // add $_config['db']['port'] in connections
        {
            $this->link_identifier = @mysqli_connect($_config['db']['host'],$_config['db']['user'],$_config['db']['pass'],$_config['db']['port']);
        }

        // Check connections
        if (!$this->link_identifier)
        {
            cliprz::system(error)->database(array(
                "title"   => "MySQL error",
                "content" => $this->connect_error()));
        }
    }

    /**
     * Pings a server connection, or tries to reconnect if the connection has gone down.
     *
     * @access public.
     */
    public function ping ()
    {
        if (mysqli_ping($this->link_identifier) === false)
        {
            $this->link_identifier = false;
        }
    }

    /**
     * Selects the default database for database queries.
     *
     * @access public.
     */
    public function select_db ()
    {
        global $_config;
        mysqli_select_db($this->link_identifier,$_config['db']['name']);
    }

    /**
     * Sets the default client character set.
     *
     * @access public.
     */
    public function set_charset ()
    {
        global $_config;
        mysqli_set_charset($this->link_identifier,$_config['db']['charset']);
    }

    /**
     * Returns the default character set for the database connection.
     *
     * @access public.
     */
    public function character_set_name ()
    {
        return true;
    }

    /**
     * Get connection link identifier.
     *
     * @access public.
     */
    public function link ()
    {
        return $this->link_identifier;
    }

    /**
     * Performs a query on the database.
     *
     * @param (string) $query - The query string.
     * @access public.
     */
    public function query ($query)
    {
        $do = mysqli_query($this->link_identifier,$query);

        if (!$do)
        {
            cliprz::system(error)->database(array(
                "title"   => "MySQL error ".$this->errno(),
                "content" => $this->error()));
        }
        else
        {
            return $do;
        }
    }

    /**
     * Escapes special characters in a string for use in an SQL statement. (Real escape string).
     *
     * @param (string) $escapestr - The string to be escaped.
     * @access public.
     */
    public function res($escapestr)
    {
        if (is_array($escapestr))
        {
            foreach ($escapestr as $key => $val)
            {
                $escapestr[$key] = self::res($val);
            }
        }
        else
        {
            $escapestr = trim(mysqli_real_escape_string($this->link_identifier,$escapestr));
        }

        return $escapestr;
    }

    /**
     * Gets the number of affected rows in a previous SQL operation.
     *
     * @access public.
     */
    public function affected_rows ()
    {
        mysqli_affected_rows($this->link_identifier);
    }

    /**
     * Returns the auto generated id used in the last query.
     *
     * @access public.
     */
    public function insert_id ()
    {
        mysqli_insert_id($this->link_identifier);
    }

    /**
     * Returns a string description of the last error.
     *
     * @access public.
     */
    public function error ()
    {
        return mysqli_error($this->link_identifier);
    }

    /**
     * Returns the error code for the most recent function call.
     *
     * @access public.
     */
    public function errno ()
    {
        return mysqli_errno($this->link_identifier);
    }

    /**
     * Returns a string description of the last connect error.
     *
     * @access public.
     */
    public function connect_error ()
    {
        return mysqli_connect_error();
    }

    /**
     * Returns the error code from last connect call.
     *
     * @access public.
     */
    public function connect_errno ()
    {
        return mysqli_connect_errno();
    }

    /**
     * Get driver Version number.
     *
     * @access public.
     */
    public function version ()
    {
        mysqli_get_client_version();
    }

    /**
     * Get driver Platform.
     *
     * @access public.
     */
    public function platform ()
    {
        mysqli_get_client_info();
    }

    /**
     * Closes a previously opened database connection.
     *
     * @access public.
     */
    public function close ()
    {
        mysqli_close($this->link_identifier);
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
        $query = "SELECT ".$fields." FROM `".C_DATABASE_PREFIX.$table."`";

        if ($where != '')
        {
            $query .= " WHERE ".$where." ";
        }

        if ($orderby != '')
        {
            $query .= " ORDER BY ".$orderby." ";
        }

        if ($limit != '')
        {
            $query .= " LIMIT ".$limit."";
        }

        return $this->query($query);
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
        // Check array
		if(!is_array($posts))
        {
            return false;
        }

        // Impload $posts array keys from the the array
        $fields = "`".implode("`,`", array_keys($posts))."`";

        // Impload $posts array as variables
        $values = implode("','",$posts);

        // Query
        return $this->query("INSERT INTO `".C_DATABASE_PREFIX.$table."` (".$fields.") VALUES ('".$values."')");
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
        // Check array
		if(!is_array($posts))
        {
            return false;
        }

		$comma = "";
		$query = "";
		$quote = "'";

		if($no_quote == true)
        {
            $quote = "";
        }

		foreach($posts as $field => $value)
		{
			$query .= $comma."`".$field."`=".$quote."".$value."".$quote."";
			$comma = ', ';
		}

		if(!empty($where))
        {
            $query .= " WHERE $where";
        }

		if(!empty($limit))
        {
            $query .= " LIMIT $limit";
        }

        return $this->query("UPDATE `".C_DATABASE_PREFIX.$table."` SET ".$query."");
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
        return $this->query("UPDATE `".C_DATABASE_PREFIX.$table."` SET ".$fields." WHERE ".$where."");
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
        return $this->query("DELETE FROM `".C_DATABASE_PREFIX.$table."` WHERE ".$where."");
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
        return mysqli_change_user($_config['db']['user'],$_config['db']['pass'],$database_name);
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
        $return = null;

        switch ($resulttype)
        {
            case 'ASSOC':
                $return = mysqli_fetch_array($result,MYSQLI_ASSOC);
            break;
            case 'NUM':
                $return = mysqli_fetch_array($result,MYSQLI_NUM);
            break;
            case 'BOTH':
                $return = mysqli_fetch_array($result,MYSQLI_BOTH);
            break;
            default:
                $return = mysqli_fetch_array($result);
            break;
        }

        return $return;
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
        $return = null;

        if ($class_name !== null)
        {
            $return = mysqli_fetch_object($result,$class_name);
        }
        else if ($params !== null && is_array($params))
        {
            $return = mysqli_fetch_object($result,$class_name,$params);
        }
        else
        {
            $return = mysqli_fetch_object($result);
        }

        return $return;
    }

    /**
     * Fetch a result row as an associative array
     *
     * @param (string) $result - A result set identifier returned by query.
     * @access public.
     */
    public function fetch_assoc ($result)
    {
        return mysqli_fetch_assoc($result);
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
        $return = null;

        switch ($resulttype)
        {
            case 'ASSOC':
                $return = mysqli_fetch_all($result,MYSQLI_ASSOC);
            break;
            case 'NUM':
                $return = mysqli_fetch_all($result,MYSQLI_NUM);
            break;
            case 'BOTH':
                $return = mysqli_fetch_all($result,MYSQLI_BOTH);
            break;
            default:
                $return = mysqli_fetch_all($result);
            break;
        }

        return $return;
    }

    /**
     * Returns the next field in the result set.
     *
     * @param (string) $result - A result set identifier returned by query.
     * @access public.
     */
    public function fetch_field ($result)
    {
        return mysqli_fetch_field($result);
    }

    /**
     * Returns an array of objects representing the fields in a result set.
     *
     * @param (string) $result - A result set identifier returned by query.
     * @access public.
     */
    public function fetch_fields ($result)
    {
        return mysqli_fetch_fields($result);
    }

    /**
     * Get a result row as an enumerated array.
     *
     * @param (string) $result - A result set identifier returned by query.
     * @access public.
     */
    public function fetch_row ($result)
    {
        return mysqli_fetch_row($result);
    }

    /**
     * Get the number of fields in a result.
     *
     * @param (string) $result - A result set identifier returned by query.
     * @access public.
     */
    public function num_fields ()
    {
        return mysqli_num_fields($result);
    }

    /**
     * Frees the memory associated with a result.
     *
     * @param (string) $result - A result set identifier returned by query.
     * @access public.
     */
    public function free_result ($result)
    {
        return mysqli_free_result($result);
    }

    /**
     * Returns the lengths of the columns of the current row in the result set.
     *
     * @param (string) $result - A result set identifier returned by query.
     * @access public.
     */
    public function fetch_lengths ($result)
    {
        return mysqli_fetch_lengths($result);
    }

    /**
     * Gets the number of rows in a result.
     *
     * @param (string) $result - A result set identifier returned by query.
     * @access public.
     */
    public function num_rows ($result)
    {
        return mysqli_num_rows($result);
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
        $this->query("CREATE DATABASE `".$database_name."`");
    }

    /**
     * Drop a database.
     *
     * @param (string) $database_name - Database name.
     * @access public.
     */
    public function drop_database ($database_name)
    {
        $this->query("DROP DATABASE `".$database_name."`");
    }

    /**
     * Create a new table.
     *
     * @param (string) $table_name - Table name without prefix.
     * @access public.
     */
    public function create_table ($table_name)
    {
        $this->query("CREATE TABLE IF NOT EXISTS `".C_DATABASE_PREFIX.$table_name."` DEFAULT CHARSET=".C_DATABASE_CHARSET." COLLATE ".C_DATABASE_COLLATION.";") ;
    }

    /**
     * Drop a table.
     *
     * @param (string) $table_name - Table name  without prefix.
     * @access public.
     */
    public function drop_table ($table_name)
    {
        $this->query("DROP TABLE IF EXISTS `".C_DATABASE_PREFIX.$table_name."`");
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
        $this->query("ALTER TABLE `".C_DATABASE_PREFIX.$old_table_name."` RENAME TO `".C_DATABASE_PREFIX.$new_table_name."`");
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
        $this->query("SHOW DATABASES");
    }

    /**
     * Optimize table.
     *
     * @param (string) $table_name - Table name without prefix.
     * @access public.
     */
    public function optimize_table ($table_name)
    {
        $this->query("OPTIMIZE TABLE `".C_DATABASE_PREFIX.$table_name."`");
    }

    /**
     * Repair table.
     *
     * @param (string) $table_name - Table name without prefix.
     * @access public.
     */
    public function repair_table ($table_name)
    {
        $this->query("REPAIR TABLE `".C_DATABASE_PREFIX.$table_name."`");
    }

    /**
     * Get database backup.
     *
     * @access public.
     */
    public function backup ()
    {
        return true;
        // If you have class to backup from database useit here.
    }

}

?>
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
 *  File path BASE_PATH/cliprz_system/databases/drivers/mysqli/.
 *  File name mysqli.php .
 *  Created date 06/01/2013 02:29 PM.
 *  Last modification date 06/01/2013 06:52 PM.
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
     * @var (resource) $connection - The MySQL connection link.
     * @access protected.
     */
    protected $connection;

    /****************************************/
    // Driver methods
    /****************************************/

    /**
     * Opens or reuses a connection to a MySQL server and select a MySQL database.
     *
     * @access public.
     */
    public function connect ()
    {
        global $_config;

        if (is_null($_config['db']['port']))
        {
            $this->connection = @mysqli_connect($_config['db']['host'],$_config['db']['user'],
                $_config['db']['pass']);
        }
        else
        {
            $this->connection = @mysqli_connect($_config['db']['host'],$_config['db']['user'],
                $_config['db']['pass'],$_config['db']['port']);
        }

        if (!$this->connection)
        {
            cliprz::system(error)->database(array(
                "title"   => "MySQL error",
                "content" => "Could not connect to the database."));
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

        $select_database = @mysqli_select_db($this->connection,$_config['db']['name']);

        if (!$select_database)
        {
            cliprz::system(error)->database(array(
                "title"   => "MySQL error",
                "content" => $_config['db']['name']." not exists in database."));
        }
    }

    /**
     * Sets the default character set for the current connection.
     *
     * @access protected.
     */
    public function set_charset ()
    {
        global $_config;

        if(function_exists('mysqli_set_charset'))
        {
            mysqli_set_charset($this->connection,$_config['db']['charset']);
        }
        else
        {
            $this->query("SET NAMES ".$_config['db']['charset']);
            // $this->query("SET CHARACTER SET ".$_config['db']['charset']);
        }
    }

    /**
     * Close mysql connection.
     *
     * @access public.
     */
    public function close ()
    {
        mysqli_close($this->connection);
    }

    /**
     * The MySQL connection.
     *
     * @access public.
     */
    public function link_identifier ()
    {
        return $this->connection;
    }

    /**
     * Database prefix.
     *
     * @access public.
     */
    public function prefix ()
    {
        global $_config;
        return $_config['db']['prefix'];
    }

    /**
     * Get mysql version.
     *
     * @access public.
     */
    public function version ()
    {
        return "SELECT version() AS ver";
    }

    /**
     * Send a MySQL query.
     *
     * @param (string) $sql - An SQL query.
     * @access public.
     */
    public function query ($sql)
    {
        $query = mysqli_query($this->connection,$sql);

        if (!$query)
        {
            cliprz::system(error)->database(array(
                "title"   => "MySQL error ".mysqli_errno($this->connection),
                "content" => mysqli_error($this->connection)));
        }
        else
        {
            return $query;
        }
    }

    /**
     * Selection from the database tables.
     *
     * @param (string) $table - table name in database.
     * @param (string) $fields - fields name.
     * @param (string) $where - where SQL.
     * @param (string) $orderby - ORDER BY SQL.
     * @param (string) $limit - LIMIT SQL.
     * @access public.
     */
    public function select($table,$fields='*',$where='',$orderby='',$limit='')
    {
        $query = "SELECT ".$fields." FROM ".$this->prefix()."".$table."";

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

        $select = $this->query($query);
        return $select;
    }

    /**
     * Insert data into MySQL database.
     *
     * @param (string) $table - table name in database.
     * @param (array) $array -post variables with Keys.
     * @access public.
     */
    public function insert($table,$array)
    {
        // Check array
		if(!is_array($array))
        {
            return false;
        }

        // Impload array keys from the the array
        $fields = "`".implode("`,`", array_keys($array))."`";

        // Impload array as variables
        $values = implode("','",$array);

        // Query
        $insert = $this->query("INSERT INTO ".$this->prefix()."".$table." (".$fields.") VALUES ('".$values."')");

        return $insert;
    }

    /**
     * Update mysql database data.
     *
     * @param (string) $table - table name in database.
     * @param (array) $array - Array with Keys.
     * @param (string) $where -  Where $_GET.
     * @param (string) $limit - Limit.
     * @param (boolean) $no_quote - Quote default is false (true or false).
     * @access public.
     */
    public function update($table, $array, $where="", $limit="", $no_quote=false)
    {
        // Check array
		if(!is_array($array))
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

		foreach($array as $field => $value)
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

        $update = $this->query("UPDATE ".$this->prefix()."".$table." SET ".$query."");
        return $update;
    }

    /**
     * Update data from MySQL database where Specific SQL requested.
     *
     * @param (string) $table - table name in database.
     * @param (string) $fields - field names.
     * @param (string) $where - where id = $_GET['id'];.
     * @access public.
     */
    public function update_where($table,$fields,$where)
    {
        $update_where = $this->query("UPDATE ".$this->prefix()."".$table." SET ".$fields." WHERE ".$where."");
        return $update_where;
    }

    /**
     * Delete data from MySQL database where Specific SQL requested.
     *
     * @param (string) $table - table name in database.
     * @param (string) $field_name - field name.
     * @param (string) $where - Where value.
     * @access public.
     */
    public function delete($table,$field_name,$where)
    {
        $delete = $this->query("DELETE FROM ".$this->prefix()."".$table." WHERE ".$field_name."='".$where."'");
        return $delete;
    }

    /**
     * Escapes special characters in a string for use in an SQL statement.
     *
     * @param (string) $str - The string that is to be escaped.
     * @access public.
     */
    public function real_escape_string($str)
    {
        if (function_exists('mysqli_real_escape_string'))
        {
            $escape = trim(mysqli_real_escape_string($this->connection,$str));
            return $escape;
        }
        else
        {
            $search  = array("\\","\0","\n","\r","\x1a","'",'"');
            $replace = array("\\\\","\\0","\\n","\\r","\Z","\'",'\"');
            $escape  = trim(str_replace($search,$replace,$str));
            return $escape;
        }
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
    public function fetch_assoc($result)
    {
        $fetch_assoc = mysqli_fetch_assoc($result);
        return $fetch_assoc;
    }

    /**
     * Fetch a result row as an associative array, a numeric array, or both.
     * Returns an array that corresponds to the fetched row and moves the internal data pointer ahead.
     *
     * @param (resource) $result - result.
     * @access public.
     */
    public function fetch_array($result)
    {
        $fetch_array = mysqli_fetch_array($result);
        return $fetch_array;
    }

    /**
     * Fetch a result row as an object.
     * Returns an object with properties that correspond to the fetched row and moves the internal data pointer ahead.
     *
     * @param (resource) $result - result.
     * @access public.
     */
    public function fetch_object($result)
    {
        $fetch_object = mysqli_fetch_object($result);
        return $fetch_object;
    }

    /**
     * Get a result row as an enumerated array.
     *
     * @param (resource) $result - Result.
     * @access public.
     */
    public function fetch_row($result)
    {
        $fetch_row = mysqli_fetch_row($result);
        return $fetch_row;
    }

    /**
     * Free result memory.
     * will free all memory associated with the result identifier result.
     *
     * @param (resource) $result - result.
     * @access public.
     */
    public function free_result($result)
    {
        $free_result = mysqli_free_result($result);
        return $free_result;
    }

    /**
     * Get number of rows in result.
     *
     * @param (resource) $result - result.
     * @access public.
     */
    public function num_rows($result)
    {
        $num_rows = mysqli_num_rows($result);
        return $num_rows;
    }

    /**
     * Get number of fields in result.
     *
     * @param (resource) $result - result.
     * @access public.
     */
    public function num_fields($result)
    {
        $num_fields = mysqli_num_fields($result);
        return $num_fields;
    }

    /**
     * Get number of affected rows in previous MySQL operation.
     *
     * @access public.
     */
    public function affected_rows()
    {
        return mysqli_affected_rows($this->connection); // $link
    }

    /****************************************/
    // Forge methods
    /****************************************/

    /****************************************/
    // Utility methods
    /****************************************/

}

?>
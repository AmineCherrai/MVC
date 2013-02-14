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
 *  File path BASE_PATH/cliprz_system/databases/drivers/mysqli/ .
 *  File name mysqli_session_handler.php .
 *  Created date 27/01/2013 08:52 PM.
 *  Last modification 30/01/2013 11:58 PM.
 *
 * Description :
 *  MySQLi session handler database class.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

class cliprz_mysqli_session_handler
{

    /**
     * @var session table name in database with prefix.
     * @access protected.
     */
    protected $table_name = "sessions";

    /**
     * @var ($connection) $connection - connection link to MySQL database.
     * @access protected.
     */
    protected $connection;

    /**
     * start session class Automatically.
     *
     * @access public.
     */
    public function __construct()
    {

        global $_config;

        $this->create_session_table();

        $this->sessionLifetime = ini_get("session.gc_maxlifetime");

        session_set_save_handler(
                array(&$this,'open_session'),
                array(&$this,'close_session'),
                array(&$this,'read_session'),
                array(&$this,'write_session'),
                array(&$this,'destroy_session'),
                array(&$this,'gc_session'));

        register_shutdown_function('session_write_close');


        $cookie_domain = (is_null($_config['session']['cookie_domain'])) ? "" : $_config['session']['cookie_domain'];


        session_set_cookie_params(
            $_config['session']['cookie_lifetime'],
            $_config['session']['cookie_path'],
            $cookie_domain,
            $_config['session']['cookie_secure'],
            $_config['session']['cookie_httponly']);

        unset($cookie_domain);

        session_start();
    }

    /**
     * delete session from database.
     *
     * @access public.
     */
    public function delete_session()
    {
        session_unset();
        session_destroy();
        $this->regenerate_id();
    }

    /**
     * regenerate a new session id.
     *
     * @access public.
     */
    public function regenerate_id()
    {
        $oldSessionID = session_id();
        session_regenerate_id();
        $this->destroy_session($oldSessionID);
    }

    /**
     * The open callback works like a constructor in classes and is executed when the session is being opened.
     * It is the first callback function executed when the session is started automatically or manually with session_start().
     * Return value is TRUE for success, FALSE for failure.
     *
     * @param (string) $save_path - session save path.
     * @param (string) $session_name - session name.
     * @access public.
     */
    public function open_session($save_path,$session_name)
    {
        global $_config;
        $this->connection = @mysqli_connect($_config['db']['host'],$_config['db']['user'],$_config['db']['pass']) or die ('session handler restart');
        mysqli_select_db($this->connection,$_config['db']['name']);
        mysqli_set_charset($this->connection,$_config['db']['charset']);
        return true;
    }

    /**
     * Get secure http user agent.
     *
     * @access public.
     */
    public function session_http_agent ()
    {
        return mysqli_real_escape_string($this->connection,c_htmlentities(c_get_http_user_agent()));
    }

    /**
     * The close callback works like a destructor in classes and is executed after the session write callback has been called.
     * It is also invoked when session_write_close() is called. Return value should be TRUE for success, FALSE for failure.
     *
     * @access public.
     */
    public function close_session()
    {
        //@mysqli_close($this->connection);
        return true;
    }

    /**
     * The read callback must always return a session encoded (serialized) string, or an empty string if there is no data to read.
     * This callback is called internally by PHP when the session starts or when session_start() is called.
     * Before this callback is invoked PHP will invoke the open callback.
     *
     * @param (string) $session_id - session id.
     * @access public.
     */
    public function read_session($session_id)
    {
        $result = mysqli_query($this->connection,"
        SELECT session_data FROM ".C_DATABASE_PREFIX.$this->table_name."
        WHERE session_id='".$session_id."'
        AND http_user_agent='".$this->session_http_agent()."'
        AND session_expire > '".time()."'");

        if (is_resource($result) && mysqli_num_rows($result) > 0)
        {
            $fields = mysqli_fetch_assoc($result);
            return $fields["session_data"];
        }

        return "";

        mysqli_free_result($result);
    }

    /**
     * The write callback is called when the session needs to be saved and closed.
     * This callback receives the current session ID a serialized version the $_SESSION superglobal.
     * The serialization method used internally by PHP is specified in the session.serialize_handler ini setting.
     * The serialized session data passed to this callback should be stored against the passed session ID.
     * When retrieving this data, the read callback must return the exact value that was originally passed to the write callback.
     * This callback is invoked when PHP shuts down or explicitly when session_write_close() is called.
     * @Note : that after executing this function PHP will internally execute the close callback.
     *
     * @param (string) $session_id - session id.
     * @param (string) $session_data - session data.
     * @access public.
     */
    public function write_session($session_id, $session_data)
    {

        $result = mysqli_query($this->connection,"
        SELECT * FROM ".C_DATABASE_PREFIX.$this->table_name."
        WHERE session_id='".$session_id."'");

        if (mysqli_num_rows($result) > 0)
        {
            $result = mysqli_query($this->connection,"
            UPDATE ".C_DATABASE_PREFIX.$this->table_name." SET
            session_data='".$session_data."',
            session_expire = '".(TIME_NOW + $this->sessionLifetime)."'
            WHERE session_id='".$session_id."'");

            if (mysqli_affected_rows($this->connection))
            {
                return true;
            }
        }
        else
        {
            $result = mysqli_query($this->connection,"
            INSERT INTO ".C_DATABASE_PREFIX.$this->table_name."
            (session_id,http_user_agent,session_data,session_expire)
            VALUES
            ('".$session_id."','".$this->session_http_agent()."','".$session_data."'
            ,'".(time() + $this->sessionLifetime)."')");

            if (mysqli_affected_rows($this->connection))
            {
                return "";
            }
        }
        return false;
    }

    /**
     * This callback is executed when a session is destroyed with session_destroy(),
     * Or with session_regenerate_id() with the destroy parameter set to TRUE.
     * Return value should be TRUE for success, FALSE for failure.
     *
     * @param (string) $session_id - session id.
     * @access public.
     */
    public function destroy_session($session_id)
    {
        $result = mysqli_query($this->connection,"
        DELETE FROM ".C_DATABASE_PREFIX.$this->table_name."
        WHERE `session_id`='".$session_id."'");

        if (mysqli_affected_rows($this->connection))
        {
            return true;
        }

        return false;
    }

    /**
     * The garbage collector callback is invoked internally by PHP periodically in order to purge old session data.
     * The frequency is controlled by session.gc_probability and session.gc_divisor.
     * The value of lifetime which is passed to this callback can be set in session.gc_maxlifetime.
     * Return value should be TRUE for success, FALSE for failure.
     *
     * @param (integer) $maxlifetime - max lifet time.
     * @access public.
     */
    public function gc_session($maxlifetime)
    {
        $result = mysqli_query($this->connection,"DELETE FROM ".C_DATABASE_PREFIX.$this->table_name."
        WHERE session_expire < '".(TIME_NOW - $maxlifetime)."'");
    }

    /**
     * Create sessions table if not exists in database.
     *
     * @access protected.
     */
    protected function create_session_table ()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS `".C_DATABASE_PREFIX.$this->table_name."` (
                `session_id` varchar(32) NOT NULL default '',
                `http_user_agent` varchar(255) NOT NULL default '',
                `session_data` longtext NOT NULL,
                `session_expire` int(11) NOT NULL default '0',
                PRIMARY KEY  (`session_id`)
            ) DEFAULT CHARSET=".C_DATABASE_CHARSET.";";

        cliprz::system(database)->query($sql);
    }

}

?>
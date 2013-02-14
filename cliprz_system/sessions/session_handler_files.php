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
 *  File path BASE_PATH/cliprz_system/sessions/ .
 *  File name session_handler_files.php .
 *  Created date 27/01/2013 08:41 AM.
 *  Last modification date 31/01/2013 07:38 AM.
 *
 * Description :
 *  Sessions handler with files class.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

class cliprz_session_handler_files
{

    /**
     * @var (string) $session_path - session path.
     * @access protected.
     */
    protected $session_path;

    /**
     * @var (string) $sess_prefix - session file prefix.
     * @access protected.
     */
    protected $sess_prefix = 'cliprz_sess_';


    /**
     * start session handler class Automatically.
     *
     * @access public.
     */
    public function __construct()
    {
        global $_config;

        $session_save_path = c_rtrim_path($_config['session']['save_path']).DS;

        if (is_dir($session_save_path))
        {
            session_save_path($session_save_path);
        }
        else
        {
            if (c_mkdir($session_save_path,0777))
            {
                c_create_index($session_save_path);
                session_save_path($session_save_path);
            }
        }

        unset($session_save_path);

        session_set_save_handler(
                array(&$this,'open'),
                array(&$this,'close'),
                array(&$this,'read'),
                array(&$this,'write'),
                array(&$this,'destroy'),
                array(&$this,'gc'));

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
     * Open sessions from session save path.
     *
     * @param (string) $session_path - Session save path.
     * @param (string) $session_id - Session ID.
     * @access public.
     */
    public function open ($session_path,$session_id)
    {
        $this->session_path = c_rtrim_path($session_path).DS;

        if (is_dir($this->session_path) && is_writable($this->session_path)
        && is_readable($this->session_path) && c_check_session($session_id))
        {
            return true;
        }
        else
        {
            trigger_error("Can not open [".$this->session_path."] path.");
        }
    }

    /**
     * Read session data from session save path.
     *
     * @param (string) $session_id - Sessions id.
     * @access public.
     */
    public function read ($session_id)
    {
        if (c_check_session($session_id))
        {
            $path  = (string) $this->session_path.$this->sess_prefix.$session_id;

            if (file_exists($path))
            {
                return (string) c_file_get_contents($path);
            }
            else
            {
                return false;
            }
        }
        else
        {
            trigger_error("Security error invalid [".$session_id."] session ID.");
        }
    }

    /**
     * Write data in session file.
     *
     * @param (string) $session_id - Session id.
     * @param (string) $session_data - Session Data.
     * @access public.
     */
    public function write($session_id,$session_data)
    {
        if (c_check_session($session_id))
        {
            $path  = (string) $this->session_path.$this->sess_prefix.$session_id;

            if (!file_exists($path))
            {
                return c_file_put_contents($path,$session_data) === false ? false : true;
            }
            else
            {
                return c_file_put_contents($path,$session_data) === false ? false : true;
            }
        }
        else
        {
            trigger_error("Security error invalid [".$session_id."] session ID.");
        }
    }

    /**
     * Close session.
     *
     * @access public.
     */
    public function close()
    {
        return true;
    }

    /**
     * Destroy session.
     *
     * @param (string) $session_id - Session id.
     * @access public.
     */
    public function destroy($session_id)
    {
        if (c_check_session($session_id))
        {
            $path  = (string) $this->session_path.$this->sess_prefix.$session_id;

            if (file_exists($path))
            {
                unlink($path);
            }
            else
            {
                return false;
            }
        }
        else
        {
            trigger_error("Security error invalid [".$session_id."] session ID.");
        }

        return true;
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
    public function gc($maxlifetime)
    {
        $glob = (string) $this->session_path.$this->sess_prefix."*";

        foreach (glob($glob) as $file)
        {
            if (filemtime($file) + $maxlifetime < TIME_NOW && file_exists($file))
            {
                unlink($file);
            }
        }

        return true;
    }

}

?>
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
 *  File path BASE_PATH/cliprz_application/libraries/flood_handler/ .
 *  File name flood_handler.php .
 *  Created date 17/01/2013 07:14 AM.
 *  Last modification date 22/01/2013 06:16 PM.
 *
 * Description :
 *  Flood handler library class, this library handle flooding via databases.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

class library_flood_handler
{

    /**
     * @var (string) $table_name - Table name in database.
     * @access protected.
     */
    protected $table_name = 'flood';

    /**
     * Check if user are flooding.
     *
     * @param (string) $ip - user ip.
     * @param (string) $where - where is flooding.
     * @param (integer) $seconds - The seconds between flood.
     * @param (integer) $keep_seconds - Keep user in stop ber seconds, By default 600.
     * @access public.
     */
    public function initializing($ip,$where='default',$seconds=60,$keep_seconds=600)
    {

        $this->create_flood_table();

        if($this->is_flooding_exists($where))
        {
            $return = $this->is_flooding_again($where,$seconds);
            $this->update_flood($where);
            $this->delete_flood($where,$keep_seconds);
            return $return;
        }
        else
        {
            $this->insert_flood($where);
            $this->delete_flood($where,$keep_seconds);
            return false;
        }
    }

    /**
     * Insert new flooding data in database.
     *
     * @param (string) $where - where is flooding.
     * @access protected.
     */
    protected function insert_flood($where)
    {
        $flood_posts = array(
            "flood_ip"    => c_get_ip(),
            "flood_time"  => TIME_NOW,
            "flood_where" => $where);

        $result = cliprz::system(database)->insert($this->table_name,$flood_posts);

        unset($flood_posts);

        if(!$result)
        {
            return false;
        }
        else
        {
            return true;
        }
    }

    /**
     * Check if user flooding.
     *
     * @param (string) $where - where is flooding.
     * @access protected.
     */
    protected function is_flooding_exists($where)
    {
        $result = cliprz::system(database)->select(
            $this->table_name,
            "`flood_time`",
            "`flood_ip`='".c_get_ip()."' AND `flood_where`='".$where."'",
            "","0,1");

        if(cliprz::system(database)->num_rows($result) > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Check if user flooding again.
     *
     * @param (string) $where - where is flooding.
     * @param (integer) $seconds - The seconds between flood.
     * @access protected.
     */
    protected function is_flooding_again($where,$seconds)
    {
        $time = TIME_NOW - $seconds;

        $result = cliprz::system(database)->select(
            $this->table_name,
            "`flood_time`",
            "`flood_ip`='".c_get_ip()."'
            AND `flood_time`>='".$time."'
            AND `flood_where`='".$where."'",
            "","0,1");

        if(cliprz::system(database)->num_rows($result) > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Update flood in database.
     *
     * @param (string) $where - where is flooding.
     * @access protected.
     */
    protected function update_flood($where)
    {
        cliprz::system(database)->update_where(
            $this->table_name,
            "`flood_time`='".TIME_NOW."'",
            "`flood_ip`='".c_get_ip()."' AND `flood_where`='".$where."'");
    }

    /**
     * Delete flooding from database.
     *
     * @param (string) $where - where is flooding.
     * @param (integer) $keep_seconds - Keep user in stop ber seconds, By default 600.
     * @access protected.
     */
    protected function delete_flood($where,$keep_seconds)
    {
        $time = TIME_NOW - $keep_seconds;

        // Query db to remove all the old users
        cliprz::system(database)->query("
            DELETE FROM `".C_DATABASE_PREFIX.$this->table_name."`
            WHERE `flood_time` <='".$time."' AND `flood_where`='".$where."'");
    }

    /**
     * Create flood table if not exists in database.
     *
     * @access protected.
     */
    protected function create_flood_table ()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS `".C_DATABASE_PREFIX.$this->table_name."` (
              `flood_ip` varchar(40) NOT NULL,
              `flood_time` varchar(40) NOT NULL,
              `flood_where` varchar(40) NOT NULL
            ) DEFAULT CHARSET=".C_DATABASE_CHARSET.";";

        cliprz::system(database)->query($sql);
    }

}

?>
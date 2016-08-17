<?php

/**
 * Cliprz framework
 *
 * Color your project, An open source application development framework for PHP 5.3.0 or newer
 *
 * Flood handler library class, this library handle flooding via databases
 *
 * LICENSE: This program is released as free software under the Affero GPL license. You can redistribute it and/or
 * modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 * at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 * written permission from the original author(s)
 *
 * @package    Cliprz
 * @category   system
 * @author     Yousef Ismaeil <cliprz@gmail.com>
 * @copyright  Copyright (c) 2012 - 2013, Cliprz Developers team
 * @license    http://www.cliprz.org/licenses/agpl
 * @link       http://www.cliprz.org
 * @since      Version 2.0.0
 */
               
class library_flood_handler
{

    /**
     * Table name in database
     *
     * @var string $table_name
     *
     * @access private
     */
    private $table_name = 'flood';

    /**
     * Check if user are flooding
     *
     * @param string  $ip           user ip
     * @param string  $where        where is flooding
     * @param integer $seconds      The seconds between flood
     * @param integer $keep_seconds Keep user in stop ber seconds, By default 600
     *
     * @access public
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
            return FALSE;
        }
    }

    /**
     * Insert new flooding data in database
     *
     * @param string $where where is flooding
     *
     * @access private
     */
    private function insert_flood($where)
    {
        $flood_posts = array(
            "flood_ip"    => cliprz::system('http')->ip(),
            "flood_time"  => TIME_NOW,
            "flood_where" => $where);

        $result = cliprz::system('database')->insert($this->table_name,$flood_posts);

        unset($flood_posts);

        if(!$result)
        {
            return FALSE;
        }
        else
        {
            return TRUE;
        }
    }

    /**
     * Check if user flooding
     *
     * @param string $where where is flooding
     *
     * @access private
     */
    private function is_flooding_exists($where)
    {
        $result = cliprz::system('database')->select(
            $this->table_name,
            "`flood_time`",
            "`flood_ip`='".cliprz::system('http')->ip()."' AND `flood_where`='".$where."'",
            "","0,1");

        if(cliprz::system('database')->num_rows($result) > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Check if user flooding again
     *
     * @param string  $where   where is flooding
     * @param integer $seconds The seconds between flood
     *
     * @access private
     */
    private function is_flooding_again($where,$seconds)
    {
        $time = TIME_NOW - $seconds;

        $result = cliprz::system('database')->select(
            $this->table_name,
            "`flood_time`",
            "`flood_ip`='".cliprz::system('http')->ip()."'
            AND `flood_time`>='".$time."'
            AND `flood_where`='".$where."'",
            "","0,1");

        if(cliprz::system('database')->num_rows($result) > 0)
        {
            return TRUE;
        }
        else
        {
            return FALSE;
        }
    }

    /**
     * Update flood in database
     *
     * @param string $where where is flooding
     *
     * @access private
     */
    private function update_flood($where)
    {
        cliprz::system('database')->update_where(
            $this->table_name,
            "`flood_time`='".TIME_NOW."'",
            "`flood_ip`='".cliprz::system('http')->ip()."' AND `flood_where`='".$where."'");
    }

    /**
     * Delete flooding from database
     *
     * @param string $where         where is flooding
     * @param integer $keep_seconds Keep user in stop ber seconds, By default 600
     *
     * @access private
     */
    private function delete_flood($where,$keep_seconds)
    {
        $time = TIME_NOW - $keep_seconds;

        // Query db to remove all the old users
        cliprz::system('database')->query("
            DELETE FROM `".DATABASE_PREFIX.$this->table_name."`
            WHERE `flood_time` <='".$time."' AND `flood_where`='".$where."'");
    }

    /**
     * Create flood table if not exists in database
     *
     * @access private
     */
    private function create_flood_table ()
    {
        $sql = "
            CREATE TABLE IF NOT EXISTS `".DATABASE_PREFIX.$this->table_name."` (
              `flood_ip` varchar(40) NOT NULL,
              `flood_time` varchar(40) NOT NULL,
              `flood_where` varchar(40) NOT NULL
            ) DEFAULT CHARSET=".cliprz::system('config')->get('database','charset').";";

        cliprz::system('database')->query($sql);
    }

}

/**
 * End of file flood_handler.php
 *
 * @created  17/01/2013 07:14 am
 * @updated  03/04/2013 03:51 am
 * @location .system/libraries/flood_handler/flood_handler.php
 */


?>
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
 *  File path BASE_PATH/cliprz_application/libraries/pagination/ .
 *  File name pagination.php .
 *  Created date 10/02/2013 07:19 AM.
 *  Last modification date 13/02/2013 02:15 AM.
 *
 * Description :
 *  Pagination library.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

class library_pagination
{

    /**
     * @var (string) $table - Table name in database without prefix.
     * @access protected.
     */
    protected static $table;

    /**
     * @var (string) $page - Handling page name in router.
     */
    protected static $page;

    /**
     * @var (integer) $limit - Rows limit.
     * @access protected.
     */
    protected static $limit;


    /**
     * @var (integer) $adjacents - Pages number to starting adjacent.
     * @access protected.
     */
    protected static $adjacents;

    /**
     * @var (string) $sql_limit - Set SQL limit to use it in SQL query.
     * @access protected.
     */
    protected static $sql_limit;

    /**
     * @var (integer) $current - Current page identifier.
     * @access protected.
     */
    protected static $current;

    /**
     * @var (integer) $start - start limit page.
     * @access protected.
     */
    protected static $start;

    /**
     * @var (integer) $total_pages - Get a table rows count in database.
     * @access protected.
     */
    protected static $total_pages;


    /**
     * Set a new options for pagination.
     *
     * @param (string)  $page      - Handling page name.
     * @param (string)  $table     - Table name in database without prefix.
     * @param (integer) $current   - Current page identifier.
     * @param (integer) $limit     - limit rows, By default 10.
     * @param (integer) $adjacents - Number to set adjacent between pagination numbers.
     * @access public.
     */
    public static function set ($page,$table,$current,$limit=10,$adjacents=1)
    {

        // Set handling page name.
        self::$page  = $page;

        // Set table name in database without prefix.
        self::$table = $table;

        // Set limit rows.
        self::$limit = (int) $limit;

        // Set adjacents.
        self::$adjacents = (int) $adjacents;

        // Set current page identifier.
        self::$current = (int) $current;

        // Get how many rows in table
        $count = cliprz::system(database)->fetch_array(
            cliprz::system(database)->query(
                "SELECT COUNT(*) as `count` FROM `".C_DATABASE_PREFIX.self::$table."`"
        ));

        // Total pages
        self::$total_pages = (int) $count['count'];

        // Check if current page identifier if isset get limit count.
        if(self::$current)
        {
            self::$start = (self::$current - 1) * self::$limit;
        }
        else // If no current page identifier return start limit to 0.
        {
            self::$start = 0;
        }

        // Get limit as a string SQL line, this will give you x,z.
        self::$sql_limit = (string) self::$start.",".self::$limit;

        // If current page identifier 0 or null return current page identifier to 1
        if (self::$current == 0 || self::$current == null)
        {
            self::$current = 1;
        }

        if (self::$current > ceil(self::$total_pages/self::$limit))
        {
            c_redirecting(c_url(self::$page.DS.'page'.DS.'1'));
        }
    }

    /**
     * Display pagination.
     *
     * @param (array) $_show - Handling links before display pagination.
     *  $_show :
     *   'first' - Show first link boolean value as default false do not show first link.
     *   'last'  - Show last link boolean value as default false do not show last link.
     * @access protected.
     */
    public static function display($_show=array())
    {

        // Set previous.
        $previous = self::$current - 1;

        // Set next.
        $next     = self::$current + 1;

        // Set last page
        $lastpage = ceil(self::$total_pages/self::$limit);

        // Set last page - 1.
        $lpm1     = $lastpage - 1;

        $last     = $lastpage;

        // Pagination HTML tags variable.
        $pagination = C_CRNL;

        // If last page bigger than 1, Pagination will display.
        if($lastpage > 1)
        {

            // Start pagination.
            $pagination .= "<div class=\"pagination\">";

            if(isset($_show['first']) && $_show['first'] === true)
            {
                // Set first link.
                if (self::$current <= 1)
                {
                    $pagination.= "<span class=\"disabled\">".c_lang('c_pg_first')."</span>";
                }
                else
                {
                    $pagination.= "<a href=\"".C_URL.self::$page."/page/1\">".c_lang('c_pg_first')."</a>";
                }
            }


            // Set previous Link.
            if (self::$current > 1)
            {
                $pagination.= "<a href=\"".C_URL.self::$page."/page/$previous\">".c_lang('c_pg_previous')."</a>";
            }
            else
            {
                $pagination.= "<span class=\"disabled\">".c_lang('c_pg_previous')."</span>";
            }

            // Pagination numbers
            if ($lastpage < 7 + (self::$adjacents * 2))
            {
                for ($counter = 1; $counter <= $lastpage; $counter++)
                {
                    if ($counter == self::$current)
                    {
                        $pagination.= "<span class=\"current\">$counter</span>";
                    }
                    else
                    {
                        $pagination.= "<a href=\"".C_URL.self::$page."/page/$counter\">$counter</a>";
                    }
                }
            }
            elseif($lastpage > 5 + (self::$adjacents * 2))	//enough pages to hide some
            {
                if(self::$current < 1 + (self::$adjacents * 2))
                {
                    for ($counter = 1; $counter < 4 + (self::$adjacents * 2); $counter++)
                    {
                        if ($counter == self::$current)
                        {
                            $pagination.= "<span class=\"current\">$counter</span>";
                        }
                        else
                        {
                            $pagination.= "<a href=\"".C_URL.self::$page."/page/$counter\">$counter</a>";
                        }
                    }

                    $pagination.= c_lang('c_pg_adjacent');
                    $pagination.= "<a href=\"".C_URL.self::$page."/page/$lpm1\">$lpm1</a>";
                    $pagination.= "<a href=\"".C_URL.self::$page."/page/$lastpage\">$lastpage</a>";
                }
                elseif($lastpage - (self::$adjacents * 2) > self::$current && self::$current > (self::$adjacents * 2))
                {
                    $pagination.= "<a href=\"".C_URL.self::$page."/page/1\">1</a>";
                    $pagination.= "<a href=\"".C_URL.self::$page."/page/2\">2</a>";
                    $pagination.= c_lang('c_pg_adjacent');

                    for ($counter = self::$current - self::$adjacents; $counter <= self::$current + self::$adjacents; $counter++)
                    {
                        if ($counter == self::$current)
                        {
                            $pagination.= "<span class=\"current\">$counter</span>";
                        }
                        else
                        {
                            $pagination.= "<a href=\"".C_URL.self::$page."/page/$counter\">$counter</a>";
                        }
                    }

                    $pagination.= c_lang('c_pg_adjacent');
                    $pagination.= "<a href=\"".C_URL.self::$page."/page/$lpm1\">$lpm1</a>";
                    $pagination.= "<a href=\"".C_URL.self::$page."/page/$lastpage\">$lastpage</a>";
                }
                else
                {
                    $pagination.= "<a href=\"".C_URL.self::$page."/page/1\">1</a>";
                    $pagination.= "<a href=\"".C_URL.self::$page."/page/2\">2</a>";
                    $pagination.= c_lang('c_pg_adjacent');

                    for ($counter = $lastpage - (2 + (self::$adjacents * 2)); $counter <= $lastpage; $counter++)
                    {
                        if ($counter == self::$current)
                        {
                            $pagination.= "<span class=\"current\">$counter</span>";
                        }
                        else
                        {
                            $pagination.= "<a href=\"".C_URL.self::$page."/page/$counter\">$counter</a>";
                        }
                    }
                }
            }

            // Set next link.
            if (self::$current < $counter - 1)
            {
                $pagination.= "<a href=\"".C_URL.self::$page."/page/$next\">".c_lang('c_pg_next')."</a>";
            }
            else
            {
                $pagination.= "<span class=\"disabled\">".c_lang('c_pg_next')."</span>";
            }

            if (isset($_show['last']) && $_show['last'] === true)
            {
                // Set last link.
                if (self::$current >= $counter - 1)
                {
                    $pagination.= "<span class=\"disabled\">".c_lang('c_pg_last')."</span>";
                }
                else
                {
                    $pagination.= "<a href=\"".C_URL.self::$page."/page/$last\">".c_lang('c_pg_last')."</a>";
                }
            }

            // end pagination.
            $pagination.= "</div>";
            $pagination.= C_CRNL;
        }

        return $pagination;

    }

    /**
     * Get SQL limit.
     *
     * @access public.
     */
    public static function limit ()
    {
        return self::$sql_limit;
    }

}

?>
<?php

/**
 * Cliprz framework
 *
 * Color your project, An open source application development framework for PHP 5.3.0 or newer
 *
 * Pagination library
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

class library_pagination
{

    /**
     * Table name in database without prefix
     *
     * @var string $table
     *
     * @access private
     * @static
     */
    private static $table;

    /**
     * Handling page name in router
     *
     * @var string $page
     *
     * @access private
     * @static
     */
    private static $page;

    /**
     * Rows limit
     *
     * @var integer $limit
     *
     * @access private
     * @static
     */
    private static $limit;


    /**
     * Pages number to starting adjacent
     *
     * @var integer $adjacents
     *
     * @access private
     * @static
     */
    private static $adjacents;

    /**
     * Set SQL limit to use it in SQL query
     *
     * @var string $sql_limit
     *
     * @access private
     * @static
     */
    private static $sql_limit;

    /**
     * Current page identifier
     *
     * @var integer $current
     *
     * @access private
     * @static
     */
    private static $current;

    /**
     * start limit page
     *
     * @var integer $start
     *
     * @access private
     * @static
     */
    private static $start;

    /**
     * Get a table rows count in database
     *
     * @var integer $total_pages
     *
     * @access private
     * @static
     */
    private static $total_pages;


    /**
     * Set a new options for pagination
     *
     * @param string  $page      Handling page name
     * @param string  $table     Table name in database without prefix
     * @param integer $current   Current page identifier
     * @param integer $limit     limit rows, By default 10
     * @param integer $adjacents Number to set adjacent between pagination numbers
     *
     * @access public
     * @static
     */
    public static function set ($page,$table,$current,$limit=10,$adjacents=1)
    {

        // Set handling page name
        self::$page  = $page;

        // Set table name in database without prefix
        self::$table = $table;

        // Set limit rows
        self::$limit = (int) $limit;

        // Set adjacents
        self::$adjacents = (int) $adjacents;

        // Set current page identifier
        self::$current = (int) $current;

        // Get how many rows in table
        $count = cliprz::system('database')->fetch_array(
            cliprz::system('database')->query(
                "SELECT COUNT(*) as `count` FROM `".DATABASE_PREFIX.self::$table."`"
        ));

        // Total pages
        self::$total_pages = (int) $count['count'];

        // Check if current page identifier if isset get limit count
        if(self::$current)
        {
            self::$start = (self::$current - 1) * self::$limit;
        }
        else // If no current page identifier return start limit to 0
        {
            self::$start = 0;
        }

        // Get limit as a string SQL line, this will give you x,z
        self::$sql_limit = (string) self::$start.",".self::$limit;

        // If current page identifier 0 or null return current page identifier to 1
        if (self::$current == 0 || self::$current == null)
        {
            self::$current = 1;
        }
    }

    /**
     * Display pagination
     *
     * @param array $_show Handling links before display pagination.
     *                      'first' Show first link boolean value as default false do not show first link
     *                      'last'  Show last link boolean value as default false do not show last link
     *
     * @access public
     * @static
     */
    public static function display($_show=array())
    {

        // Set previous
        $previous = self::$current - 1;

        // Set next.
        $next     = self::$current + 1;

        // Set last page
        $lastpage = ceil(self::$total_pages/self::$limit);

        // Set last page - 1
        $lpm1     = $lastpage - 1;

        $last     = $lastpage;

        // Pagination HTML tags variable
        $pagination = NEWLINE;

        // If last page bigger than 1, Pagination will display
        if($lastpage > 1)
        {

            // Start pagination
            $pagination .= "<div class=\"pagination\">";

            if(isset($_show['first']) && $_show['first'] === TRUE)
            {
                // Set first link
                if (self::$current <= 1)
                {
                    $pagination.= "<span class=\"disabled\">First</span>";
                }
                else
                {
                    $pagination.= "<a href=\"".URL.self::$page."/page/1\">First</a>";
                }
            }


            // Set previous Link
            if (self::$current > 1)
            {
                $pagination.= "<a href=\"".URL.self::$page."/page/$previous\">Previous</a>";
            }
            else
            {
                $pagination.= "<span class=\"disabled\">Previous</span>";
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
                        $pagination.= "<a href=\"".URL.self::$page."/page/$counter\">$counter</a>";
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
                            $pagination.= "<a href=\"".URL.self::$page."/page/$counter\">$counter</a>";
                        }
                    }

                    $pagination.= '...';
                    $pagination.= "<a href=\"".URL.self::$page."/page/$lpm1\">$lpm1</a>";
                    $pagination.= "<a href=\"".URL.self::$page."/page/$lastpage\">$lastpage</a>";
                }
                elseif($lastpage - (self::$adjacents * 2) > self::$current && self::$current > (self::$adjacents * 2))
                {
                    $pagination.= "<a href=\"".URL.self::$page."/page/1\">1</a>";
                    $pagination.= "<a href=\"".URL.self::$page."/page/2\">2</a>";
                    $pagination.= '...';

                    for ($counter = self::$current - self::$adjacents; $counter <= self::$current + self::$adjacents; $counter++)
                    {
                        if ($counter == self::$current)
                        {
                            $pagination.= "<span class=\"current\">$counter</span>";
                        }
                        else
                        {
                            $pagination.= "<a href=\"".URL.self::$page."/page/$counter\">$counter</a>";
                        }
                    }

                    $pagination.= '...';
                    $pagination.= "<a href=\"".URL.self::$page."/page/$lpm1\">$lpm1</a>";
                    $pagination.= "<a href=\"".URL.self::$page."/page/$lastpage\">$lastpage</a>";
                }
                else
                {
                    $pagination.= "<a href=\"".URL.self::$page."/page/1\">1</a>";
                    $pagination.= "<a href=\"".URL.self::$page."/page/2\">2</a>";
                    $pagination.= '...';

                    for ($counter = $lastpage - (2 + (self::$adjacents * 2)); $counter <= $lastpage; $counter++)
                    {
                        if ($counter == self::$current)
                        {
                            $pagination.= "<span class=\"current\">$counter</span>";
                        }
                        else
                        {
                            $pagination.= "<a href=\"".URL.self::$page."/page/$counter\">$counter</a>";
                        }
                    }
                }
            }

            // Set next link
            if (self::$current < $counter - 1)
            {
                $pagination.= "<a href=\"".URL.self::$page."/page/$next\">Next</a>";
            }
            else
            {
                $pagination.= "<span class=\"disabled\">Next</span>";
            }

            if (isset($_show['last']) && $_show['last'] === TRUE)
            {
                // Set last link
                if (self::$current >= $counter - 1)
                {
                    $pagination.= "<span class=\"disabled\">Last</span>";
                }
                else
                {
                    $pagination.= "<a href=\"".URL.self::$page."/page/$last\">Last</a>";
                }
            }

            // end pagination
            $pagination.= "</div>";
            $pagination.= NEWLINE;
        }

        return $pagination;

    }

    /**
     * Get SQL limit
     *
     * @access public
     * @static
     */
    public static function limit ()
    {
        return self::$sql_limit;
    }

}

/**
 * End of file pagination.php
 *
 * @created  10/02/2013 07:19 am
 * @updated  03/04/2013 06:42 am
 * @location ./system/libraries/pagination/pagination.php
 */

?>
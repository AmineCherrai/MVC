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
 *  File path BASE_PATH/cliprz_system/functions/ .
 *  File name datetime.functions.php .
 *  Created date 29/12/2012 10:50 AM.
 *  Last modification 27/01/2013 06:35 AM.
 *
 * Description :
 *  Date and Time Functions.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

// Set default timezone
if (!is_null($_config['datetime']['timezone']))
{
    date_default_timezone_set($_config['datetime']['timezone']);
}

/**
 * @def (resource) get time now.
 */
define("TIME_NOW",time());

if (!function_exists('c_time_units'))
{
    /**
     * Time units as array.
     */
    function c_time_units ()
    {
        return array (
            "year"   => 29030400, // seconds in a year   (12 months)
            "month"  => 2419200,  // seconds in a month  (4 weeks)
            "week"   => 604800,   // seconds in a week   (7 days)
            "day"    => 86400,    // seconds in a day    (24 hours)
            "hour"   => 3600,     // seconds in an hour  (60 minutes)
            "minute" => 60,       // seconds in a minute (60 seconds)
            "second" => 1         // 1 second
        );
    }
}

if (!function_exists('c_str_month'))
{
    /**
     * Convert integer month to string.
     *
     * @param (integer) $int - Month number.
     * @param (boolean) $short - Get short month names or not, By default false will return full months name.
     */
    function c_str_month ($int,$short=false)
    {
        $month  = null;
        $result = null;

        switch ($int)
        {
            case 01:
            case 1:
                $month = "January";
            break;
            case 02:
            case 2:
                $month = "February";
            break;
            case 03:
            case 3:
                $month = "March";
            break;
            case 04:
            case 4:
                $month = "April";
            break;
            case 05:
            case 5:
                $month = "May";
            break;
            case 06:
            case 6:
                $month = "June";
            break;
            case 07:
            case 7:
                $month = "July";
            break;
            case 08:
            case 8:
                $month = "August";
            break;
            case 09:
            case 9:
                $month = "September";
            break;
            case 10:
                $month = "October";
            break;
            case 11:
                $month = "November";
            break;
            case 12:
                $month = "December";
            break;
        }

        if (is_bool($short) && $short == true)
        {
            $result = c_short_month($month);
            unset($month);
        }
        else
        {
            $result = $month;
            unset($month);
        }

        return $result;
    }
}

if (!function_exists('c_int_month'))
{
    /**
     * Convert string month names to integer.
     *
     * @param (string) $str - month name as string.
     */
    function c_int_month ($str)
    {
        $month = null;

        $str = strtolower($str);

        switch ($str)
        {
            case "january":
            case "jan":
            case "i":
                $month = 01;
            break;
            case "february":
            case "feb":
            case "ii":
                $month = 02;
            break;
            case "march":
            case "mar":
            case "iii":
                $month = 03;
            break;
            case "april":
            case "apr":
            case "iv":
                $month = 04;
            break;
            case "may":
            case "v":
                $month = 05;
            break;
            case "june":
            case "jun":
            case "vi":
                $month = 06;
            break;
            case "july":
            case "jul":
            case "vii":
                $month = 07;
            break;
            case "august":
            case "aug":
            case "viii":
                $month = 08;
            break;
            case "september":
            case "sep":
            case "ix":
                $month = 09;
            break;
            case "october":
            case "oct":
            case "x":
                $month = 10;
            break;
            case "november":
            case "nov":
            case "xi":
                $month = 11;
            break;
            case "december":
            case "dec":
            case "xii":
                $month = 12;
            break;
        }

        return (integer) $month;

    }
}

if (!function_exists('c_short_month'))
{
    /**
     * Convert month full name to short name as example December will be Dec.
     *
     * @param (string) $month - month.
     */
    function c_short_month($month)
    {

		$months = array(
            "january","february","march","april","may","june","july",
            "august","september","october","november","december");

        if (in_array(strtolower($month),$months))
        {
            $months = array(); // Unset

            return ucfirst(c_mb_substr($month,0,3));
		}
        else
        {
            return $month.' '.c_lang('c_not_a_month');
        }
    }

}

if (!function_exists('c_time_ago'))
{
    /**
     * Convert Time To Ago
     *														 Y   M  D  H  M
     * @param (string) $time - the time should be like this 2009-03-04 17:45 .
     */
    function c_time_ago($time)
    {

        if(empty($time))
        {
            return c_lang('c_not_valid_date');
        }

        $periods         = array(c_lang('c_second'), c_lang('c_minute'), c_lang('c_hour'), c_lang('c_day'),
                            c_lang('c_week'), c_lang('c_month'), c_lang('c_year'), c_lang('c_decade'));
        $lengths         = array("60","60","24","7","4.35","12","10");

        $now             = time();
        $unix_date       = strtotime($time);

        // check validity of date
        if(empty($unix_date))
        {
            return c_lang('c_bad_date');
        }

        // is it future date or past date
        if($now > $unix_date)
        {
            $difference = $now - $unix_date;
            $tense      = c_lang('c_bad_date');
        }
        else
        {
            $difference = $unix_date - $now;
            $tense      = c_lang('c_from_now');
        }

        for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++)
        {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if($difference != 1)
        {
            $periods[$j].= c_lang('c_s');
        }

        return "$difference $periods[$j] {$tense}";
    }
}

?>
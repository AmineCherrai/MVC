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
 *  File path BASE_PATH/cliprz_system/http/ .
 *  File name http.php .
 *  Created date 07/01/2013 12:19 AM.
 *  Last modification date 07/01/2013 11:07 AM.
 *
 * Description :
 *  Http information class.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

class cliprz_http
{

    /**
     * @var (string) $agent - Get server HTTP_USER_AGENT.
     * @access protected.
     */
    protected static $agent;

    /**
     * @var (string) $language - Get server HTTP_ACCEPT_LANGUAGE.
     * @access protected.
     */
    protected static $language;

    /**
     * @var (string) $unknown - Unknown name.
     * @access protected.
     */
    protected static $unknown = 'Unknown';

    /**
     * @var (array) $_arguments - http user agent data arguments as array.
     * $_arguments :
     *  'browser'   - browser name.
     *  'platform'  - platform name.
     *  'robot'     - robot name.
     *  'mobile'    - mobile name.
     *  'version'   - version.
     *  'languages' - get language.
     * @access protected.
     */
    protected static $_arguments = array(
        "browser"   => null,
        "platform"  => null,
        "robot"     => null,
        "mobile"    => null,
        "version"   => null,
        "languages" => null
    );

    /**
     * @var (array) $_is - is a browser or robot or mobile.
     * @access protected.
     */
    protected static $_is = array(
        "browser"  => false,
        "robot"    => false,
        "mobile"   => false
    );

    /**
     * @var (array) $_browsers - Browsers names.
     * @access protected.
     */
    protected static $_browsers = array(
        "amaya"             => "Amaya",
        "Camino"            => "Camino",
        "Chimera"           => "Chimera",
        "Chrome"            => "Chrome",
        "Firebird"          => "Firebird",
        "Firefox"           => "Firefox",
        "Flock"             => "Flock",
        "hotjava"           => "HotJava",
        "IBrowse"           => "IBrowse",
        "Internet Explorer" => "Internet Explorer",
        "MSIE"              => "Internet Explorer",
        "Konqueror"         => "Konqueror",
        "Links"             => "Links",
        "Lynx"              => "Lynx",
        "Mozilla"           => "Mozilla",
        "Netscape"          => "Netscape",
        "OmniWeb"           => "OmniWeb",
        "Opera"             => "Opera",
        "Phoenix"           => "Phoenix",
        "Safari"            => "Safari",
        "Shiira"            => "Shiira",
        "icab"              => "iCab");

    /**
     * @var (array) $_platforms - Platforms names.
     * @access protected.
     */
    protected static $_platforms = array (
        "aix"            => "AIX",
        "apachebench"    => "ApacheBench",
        "bsdi"           => "BSDi",
        "beos"           => "BeOS",
        "osf"            => "DEC OSF",
        "debian"         => "Debian",
        "freebsd"        => "FreeBSD",
        "gnu"            => "GNU/Linux",
        "hp-ux"          => "HP-UX",
        "irix"           => "Irix",
        "linux"          => "Linux",
        "os x"           => "Mac OS X",
        "ppc"            => "Macintosh",
        "netbsd"         => "NetBSD",
        "openbsd"        => "OpenBSD",
        "ppc mac"        => "Power PC Mac",
        "sunos"          => "Sun Solaris",
        "unix"           => "Unknown Unix OS",
        "windows"        => "Unknown Windows OS",
        "windows nt 5.0" => "Windows 2000",
        "windows nt 5.2" => "Windows 2003",
        "windows 95"     => "Windows 95",
        "win95"          => "Windows 95",
        "windows 98"     => "Windows 98",
        "win98"          => "Windows 98",
        "windows nt 6.0" => "Windows Longhorn",
        "winnt 4.0"      => "Windows NT",
        "winnt"          => "Windows NT",
        "winnt4.0"       => "Windows NT 4.0",
        "windows nt 4.0" => "Windows NT 4.0",
        "windows nt 5.1" => "Windows XP"
    );

    /**
     * @var (array) $_robots - Robots names.
     * @access protected.
     */
    protected static $_robots = array(
        "askjeeves"   => "AskJeeves",
        "fastcrawler" => "FastCrawler",
        "googlebot"   => "Googlebot",
        "infoseek"    => "InfoSeek Robot 1.0",
        "slurp"       => "Inktomi Slurp",
        "lycos"       => "Lycos",
        "msnbot"      => "MSNBot",
        "yahoo"       => "Yahoo"
    );

    protected static $_mobiles = array(
        "alcatel"              => "Alcatel",
        "amoi"                 => "Amoi",
        "iphone"               => "Apple iPhone",
        "ipod"                 => "Apple iPod Touch",
        "avantgo"              => "AvantGo",
        "benq"                 => "BenQ",
        "blackberry"           => "BlackBerry",
        "hiptop"               => "Danger Hiptop",
        "digital paths"        => "Digital Paths",
        "cldc"                 => "Generic Mobile",
        "mobile"               => "Generic Mobile",
        "wireless"             => "Generic Mobile",
        "midp"                 => "Generic Mobile",
        "j2me"                 => "Generic Mobile",
        "smartphone"           => "Generic Mobile",
        "up.browser"           => "Generic Mobile",
        "cellphone"            => "Generic Mobile",
        "up.link"              => "Generic Mobile",
        "ipaq"                 => "HP iPaq",
        "htc"                  => "HTC",
        "lg"                   => "LG",
        "mda"                  => "MDA",
        "mobileexplorer"       => "Mobile Explorer",
        "mobilexplorer"        => "Mobile Explorer",
        "motorola"             => "Motorola",
        "mot-"                 => "Motorola",
        "nec-"                 => "NEC",
        "docomo"               => "NTT DoCoMo",
        "netfront"             => "Netfront Browser",
        "nokia"                => "Nokia",
        "novarra"              => "Novarra Transcoder",
        "o2"                   => "O2",
        "cocoon"               => "O2 Cocoon",
        "obigo"                => "Obigo",
        "openwave"             => "Openwave Browser",
        "operamini"            => "Opera Mini",
        "opera mini"           => "Opera Mini",
        "palm"                 => "Palm",
        "elaine"               => "Palm",
        "palmsource"           => "Palm",
        "palmscape"            => "Palmscape",
        "panasonic"            => "Panasonic",
        "philips"              => "Philips",
        "playstation portable" => "PlayStation Portable",
        "spv"                  => "SPV",
        "sagem"                => "Sagem",
        "samsung"              => "Samsung",
        "sanyo"                => "Sanyo",
        "sendo"                => "Sendo",
        "sharp"                => "Sharp",
        "sie-"                 => "Siemens",
        "ericsson"             => "Sony Ericsson",
        "sony"                 => "Sony Ericsson",
        "symbian"              => "Symbian",
        "series60"             => "Symbian S60",
        "SymbianOS"            => "SymbianOS",
        "blazer"               => "Treo",
        "vario"                => "Vario",
        "vodafone"             => "Vodafone",
        "windows ce"           => "Windows CE",
        "xda"                  => "XDA",
        "xiino"                => "Xiino",
        "zte"                  => "ZTE",
        "ipad"                 => "iPad"
    );

    /**
     * Http Construct
     *
     * @access public.
     */
    public function __construct()
    {
        self::$agent    = c_get_http_user_agent();
        self::$language = c_get_accept_language();
        self::initializing();
    }

    /**
     * Get full http inforamtion as string.
     *
     * @access public.
     */
    public static function as_string ()
    {
        $string = "<pre>";
        $string .= "<h2 style=\"margin: 0;\">http information :</h2>\n";
        $string .= "<strong>Platform</strong> : ".self::platform()."\n";
        $string .= "<strong>Browser</strong> : ".self::browser()."\n";
        $string .= "<strong>Browser version</strong> : ".self::version()."\n";

        if (self::is_mobile() == true)
        {
            $string .= "<strong>Mobile</strong> : ".self::mobile()."\n";
        }

        if (self::is_robot() == true)
        {
            $string .= "<strong>Robot</strong> : ".self::robot()."\n";
        }

        $string .= "<strong>USER AGENT </strong> : ".self::agent()."\n";

        $string .= "<strong>Accept languages </strong> : ";

        $languages = "";

        foreach (self::languages() as $key => $value)
        {
            $string .= $value." ";
        }

        $string .= "\n";

        $string .= "</pre>";
        return $string;
    }

    /**
     * Get full http inforamtion as array.
     *
     * @access public.
     */
    /**  Removed By Yousef Ismaeil 07/01/2013 11:07 AM
    public static function as_array ()
    {
        $platform  = self::platform();
        $browser   = null;
        $version   = null;
        $mobile    = null;
        $robot     = null;
        $agent     = null;
        $languages = null;

        if (self::is_browser())
        {
            $browser = self::browser();
        }

        $version = self::version();

        if (self::is_mobile())
        {
            $mobile = self::mobile();
        }

        if (self::is_robot())
        {
            $robot = self::robot();
        }

        $agent = self::agent();

        $languages = self::languages();

    } */

    /**
     * Initializing methods.
     *
     * @access protected.
     */
    protected static function initializing ()
    {
        self::set_platform();
        self::set_languages();

        $set = array('set_robot', 'set_browser', 'set_mobile');

        foreach ($set as $function)
        {
            if (self::$function() === true)
            {
                break;
            }
        }
    }

    /**
     * Checking platform names.
     *
     * @access protected.
     */
    protected static function set_platform ()
    {
        foreach (self::$_platforms as $key => $value)
        {
            if (preg_match("|".preg_quote($key)."|i",self::$agent))
            {
                self::$_arguments['platform'] = $value;
                break;
            }
            else
            {
                self::$_arguments['platform'] = self::$unknown;
            }
        }
    }

    /**
     * Checking browsers names.
     *
     * @access protected.
     */
    protected static function set_browser ()
    {
        foreach (self::$_browsers as $key => $value)
        {
            if (preg_match("|".preg_quote($key).".*?([0-9\.]+)|i",self::$agent,$match))
            {
                self::$_arguments['browser'] = $value;
                self::$_arguments['version'] = $match[1];
                self::$_is['browser'] = true;
                self::set_mobile();
                break;
            }
            else
            {
                self::$_arguments['browser'] = self::$unknown;
                self::$_arguments['version'] = self::$unknown;
                self::set_mobile();
            }
        }
    }

    /**
     * Checking robots names.
     *
     * @access protected.
     */
    protected static function set_robot ()
    {
        foreach (self::$_robots as $key => $value)
        {
            if (preg_match("|".preg_quote($key)."|i",self::$agent))
            {
                self::$_is['robot']        = true;
                self::$_arguments['robot'] = $value;
                break;
            }
        }
    }

    /**
     * Checking mobiles names.
     *
     * @access protected.
     */
    protected static function set_mobile ()
    {
        foreach (self::$_mobiles as $key => $value)
        {
            if (false !== (strpos(strtolower(self::$agent),$key)))
            {
                self::$_is['mobile']        = true;
                self::$_arguments['mobile'] = $value;
                break;
            }
        }
    }

    /**
     * Checking languages.
     *
     * @access protected.
     */
    protected static function set_languages ()
    {
        if ((count(self::$_arguments['languages']) == 0) && self::$language != "")
        {
            $languages = preg_replace('/(;q=[0-9\.]+)/i','',strtolower(self::$language));

            self::$_arguments['languages'] = explode(',',$languages);
        }

        if (count(self::$_arguments['languages']) == 0)
        {
            self::$_arguments['languages'] = array('Undefined');
        }
    }

    /**
     * Get platform name as string.
     *
     * @access public.
     */
    public static function platform ()
    {
        return self::$_arguments['platform'];
    }

    /**
     * Get browser name as string.
     *
     * @access public.
     */
    public static function browser ()
    {
        return self::$_arguments['browser'];
    }

    /**
     * Get mobile name as string.
     *
     * @access public.
     */
    public static function mobile ()
    {
        return self::$_arguments['mobile'];
    }

    /**
     * Get robot name as string.
     *
     * @access public.
     */
    public static function robot ()
    {
        return self::$_arguments['robot'];
    }

    /**
     * Get version as string.
     *
     * @access public.
     */
    public static function version ()
    {
        return self::$_arguments['version'];
    }

    /**
     * Is browser.
     *
     * @access public.
     */
    public static function is_browser ()
    {
        return (boolean) self::$_is['browser'];
    }

    /**
     * Is mobile.
     *
     * @access public.
     */
    public static function is_mobile ()
    {
        return (boolean) self::$_is['mobile'];
    }

    /**
     * Is robot.
     *
     * @access public.
     */
    public static function is_robot ()
    {
        return (boolean) self::$_is['robot'];
    }

    /**
     * Get server HTTP_USER_AGENT
     *
     * @access public.
     */
    public static function agent ()
    {
        return self::$agent;
    }

    /**
     * Get language.
     *
     * @access public.
     * @return languages array
     */
    public static function languages ()
    {
        return (array) self::$_arguments['languages'];
    }

}

?>
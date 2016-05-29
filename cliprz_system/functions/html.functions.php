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
 *  File name html.functions.php .
 *  Created date 23/1/2013 9:56 PM.
 *  Last modification 23/1/2013 11:39 PM.
 *
 * Description :
 *  Functions to add link, meta and script to the document.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

/**
 * @var $_html           (array)  - array have position of tags
 * @var $_html['head']   (array) - the head tags
 * @var $_html['footer'] (array) - script tags
 */
$_html = array();
$_html['head'] = array();
$_html['footer'] = array();

if (!function_exists('c_html_meta'))
{
    /**
     * Add meta tag to head.
     *
     * @param (string) $name - The name of meta (can you use charset and http-equiv).
     * @param (string) $value - The value of it.
     * @param (string) $content - The value of it if use charset or http-equiv asname
     *  $content examples:
     *   c_html_meta('keywords', 'HTML,CSS,XML,JavaScript');
     *   c_html_meta('charset', 'UTF-8');
     *   c_html_meta('http-equiv', 'refresh', '5');
     */
    function c_html_meta($name, $value, $content = '')
    {
        global $_html;

        if ($name == 'http-equiv')
        {
            // <meta $name="$value" content="$content" />
            $meta = '<meta http-equiv="' . $value . '" content="' . $content . '" />';
            $id = 'meta:http-equiv|' . $value;
        }
        else if ($name == 'charset')
        {
            // <meta charset="$value" />
            $meta = '<meta charset="' . $value . '" />';
            $id = 'meta:charset';
        }
        else
        {
            // <meta name="$name" content="$value" />
            $meta = '<meta name="' . $name . '" content="' . $value . '" />';
            $id = 'meta:' . $name;
        }

        if (!(isset($_html['head'][$id])))
        {
            $_html['head'][$id] = $meta;
        }
    }
}

if (!function_exists('c_html_link'))
{
    /**
     * Add link tag to head.
     *
     * @param (string) $href  - location of the linked document
     * @param (string) $rel   - relationship between the current document and the
     * linked document
     * @param (string) $media - what device the linked document will be displayed
     */
    function c_html_link($href, $rel, $media = 'all')
    {
        global $_html;
        // '' | media="$media"
        $media = ($media == 'all') ? '' : 'media="' . $media . '"';

        // '<link href="$href" rel="$rel" $media />'
        $link = '<link href="' . $href . '" rel="' . $rel . '" ' . $media . ' />';

        $id = 'link:' . basename($href);

        if (!(isset($_html['head'][$id])))
        {
            $_html['head'][$id] = $link;
        }
    }

}

if (!function_exists('c_html_script'))
{
    /**
     * Add script tag to footer.
     *
     * @param (string) $src - URL of an external script file
     */
    function c_html_script($src)
    {
        global $_html;

        // <script src="$src" />
        $script = '<script src="' . $src . '" />';

        $id = 'script:' . basename($src);

        if (!(isset($_html['footer'][$id])))
        {
            $_html['footer'][$id] = $script;
        }
    }

}


if ( !function_exists('c_html_add'))
{
    /**
     * Add HTML to same position of document.
     *
     * @param (string) $html - the html to add it
     * @param (string) $to   - the position of html
     */
    function c_html_add($id, $html, $to)
    {
        global $_html;
        echo $_html[$to][$id] = $html;
    }
}

if (!function_exists('c_head'))
{
    /**
     * print head tags.
     */
    function c_head()
    {
        global $_html;
        c_html_print($_html['head']);
        unset($_html['head']);
    }
}

if (!function_exists('c_footer'))
{
    /**
     * print footer tags
     */
    function c_footer()
    {
        global $_html;
        c_html_print($_html['footer']);
        unset($_html);
        // last use of $_html (in footer)
    }
}

if (!function_exists('c_html_print'))
{
    /**
     * Print HTML code from array
     *
     * @param (array) $codes - array of  codes to print
     */
    function c_html_print($codes)
    {
        $cd = "\n\t\t";

        // code dividing - tab to give code some beauty
        $result = "\t\t";

        foreach ($codes as $code)
        {
            $result .= ($code . $cd);
        }
        echo $result;
    }
}
?>
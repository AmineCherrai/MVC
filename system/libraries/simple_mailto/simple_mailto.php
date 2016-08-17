<?php

/**
 * Cliprz framework
 *
 * Color your project, An open source application development framework for PHP 5.3.0 or newer
 *
 * A very simple mail to object
 *
 * LICENSE: This program is released as free software under the Affero GPL license. You can redistribute it and/or
 * modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 * at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 * written permission from the original author(s)
 *
 * @package    Cliprz
 * @category   libraries
 * @author     Yousef Ismaeil <cliprz@gmail.com>
 * @copyright  Copyright (c) 2012 - 2013, Cliprz Developers team
 * @license    http://www.cliprz.org/licenses/agpl
 * @link       http://www.cliprz.org
 * @since      Version 2.0.0
 */

/**
 * Example:
 *
 * 1. Call the object :
 *
 * <code>
 * cliprz::call('simple_mailto','simple_mailto','libraries');
 * </code>
 *
 * 2. Use the object :
 *
 * <code>
 * cliprz::library("simple_mailto")->send(array(
 *     "from_email" => "noreply@YourWebsiteURL.com",
 *     "from_name"  => "Website Help Center",
 *     "to_email"   => "to@emailsite.com",
 *     "to_name"    => "User name",
 *     "subject"    => "Here message subject",
 *     "message"    => "Message content"
 * ));
 * </code>
 */

class library_simple_mailto
{

    /**
     * Send email
     *
     * @param array $data message data
     *                     'from_email' From email, For example cliprz@gmail.com
     *                     'from_name'  From name, For example Yousef Ismaeil
     *                     'to_email'   To name, For example Mishael Alomaran
     *                     'to_name'    To email, For example eg@gmail.com
     *                     'subject'    email subject
     *                     'message'    email message
     *
     * @access public
     * @static
     */
    public static function send($data)
    {
        if (isset($data) && is_array($data))
        {
            // To send HTML mail, the Content-type header must be set
            $headers  = 'MIME-Version: 1.0'.NEWLINE;
            $headers .= 'Content-type: text/html; charset='.CHARSET.NEWLINE;

            // Additional headers
            $headers .= 'To: '.$data['to_name'].' <'.$data['to_email'].'>'.NEWLINE;
            $headers .= 'From: '.$data['from_name'].' <'.$data['from_email'].'>'.NEWLINE;
            $headers .= 'Return-Path: '.$data['from_email'].NEWLINE;
            $headers .= "X-Priority: 1".NEWLINE;
            $headers .= "X-MSMail-Priority: High".NEWLINE;

            // Removed
            #$headers .= 'Cc: cliprz@gmail.com'.NEWLINE;
            #$headers .= 'Bcc: cliprz@gmail.com'.NEWLINE;

            if (@mail($data['to_email'],$data['subject'],$data['message'],$headers))
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }

}

/**
 * End of file simple_upload.php
 *
 * @created  02/04/2013 05:03 pm
 * @updated  02/04/2013 05:12 pm
 * @location ./system/libraries/simple_upload/simple_upload.php
 */


?>
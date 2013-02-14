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
 *  File path BASE_PATH/cliprz_application/libraries/simple_mailto/ .
 *  File name simple_mailto.php .
 *  Created date 19/12/2012 08:15 PM.
 *  Last modification date 29/12/2012 02:46 PM.
 *
 * Description :
 *  Simple mailto library class.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

class library_simple_mailto
{
    /**
     * @var newlines.
     */
    protected static $rn = "\r\n";

    /**
     * Send email.
     *
     * @param (array) $data - message data.
     *  'from_email' - From email, For example cliprz@gmail.com.
     *  'from_name'  - From name, For example Yousef Ismaeil.
     *  'to_email'   - To name, For example Mishael Alomaran.
     *  'to_name'    - To email, For example eg@gmail.com.
     *  'subject'    - email subject.
     *  'message'    - email message.
     * @access public.
     */
    public static function send($data)
    {
        if (isset($data) && is_array($data))
        {
            // To send HTML mail, the Content-type header must be set
            $headers  = 'MIME-Version: 1.0'.self::$rn;
            $headers .= 'Content-type: text/html; charset='.c_charset().self::$rn;

            // Additional headers
            $headers .= 'To: '.$data['to_name'].' <'.$data['to_email'].'>'.self::$rn;
            $headers .= 'From: '.$data['from_name'].' <'.$data['from_email'].'>'.self::$rn;
            $headers .= 'Return-Path: '.$data['from_email'].self::$rn;
            $headers .= "X-Priority: 1".self::$rn;
            $headers .= "X-MSMail-Priority: High".self::$rn;

            // Removed
            #$headers .= 'Cc: cliprz@gmail.com'.$this->rn;
            #$headers .= 'Bcc: cliprz@gmail.com'.$this->rn;

            if (@mail($data['to_email'],$data['subject'],$data['message'],$headers))
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return false;
        }
    }

}

?>
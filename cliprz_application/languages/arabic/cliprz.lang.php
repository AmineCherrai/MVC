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
 *  File path BASE_PATH/cliprz_application/languages/arabic/ .
 *  File name cliprz.lang.php .
 *  Created date 27/01/2013 08:08 PM.
 *  Last modification date 12/02/2013 10:21 AM.
 *
 * Description :
 *  Cliprz framework arabic languages array.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

/**
 * Arabic language package.
 *
 * @author Yousef Ismaeil.
 * @email Cliprz@gmail.com.
 * @website http://cliprz.org
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

// Global
$_lang['c_back_to_homepage'] = "الرجوع للرئيسية ؟";

// errors
$_lang['c_400_bad_request']         = "400 طلب خاطئ";
$_lang['c_400_bad_request_message'] = "لا يمكن أن تتحقق على طلب بسبب بناء جملة غير صالح.";

$_lang['c_404_not_found']           = "404 لم يتم العثور على الصفحة";
$_lang['c_404_not_found_message']   = "لم يتم العثور على الصفحة, قد تكون هذه الصفحة غير موجودة في السيرفر او تكون انت غير مخول لدخول إليها او سيتم اضافتها فيما بعد .";

$_lang['c_no_script']               = "لا يدعم Javascript !!";
$_lang['c_no_script_message']       = "يتوجب ان تقوم باستخدام javascript قم بتفعيلها من المتصفح لو سمحت .";

$_lang['c_database_error']          = "خطأ في قواعد البيانات";
$_lang['c_database_error_message']  = "لديك خطأ في قاعدة البيانات .";

// Data and time
$_lang['c_january']   = "يناير";
$_lang['c_february']  = "فبراير";
$_lang['c_march']     = "مارس";
$_lang['c_april']     = "أبريل";
$_lang['c_may']       = "مايو";
$_lang['c_june']      = "يونيو";
$_lang['c_july']      = "يوليو";
$_lang['c_august']    = "أغسطس";
$_lang['c_september'] = "سبتمبر";
$_lang['c_october']   = "أكتوبر";
$_lang['c_november']  = "نوفمبر";
$_lang['c_december']  = "ديسمبر";

$_lang['c_jan'] = "يناير";
$_lang['c_feb'] = "فبراير";
$_lang['c_mar'] = "مارس";
$_lang['c_apr'] = "أبريل";
$_lang['c_may'] = "مايو";
$_lang['c_jun'] = "يونيو";
$_lang['c_jul'] = "يوليو";
$_lang['c_aug'] = "أغسطس";
$_lang['c_sep'] = "سبتمبر";
$_lang['c_oct'] = "أكتوبر";
$_lang['c_nov'] = "نوفمبر";
$_lang['c_dec'] = "ديسمبر";

$_lang['c_ago']            = "مضى";
$_lang['c_from_now']       = "الآن";
$_lang['c_not_valid_date'] = "لا يوجد تاريخ مقدم";
$_lang['c_bad_date']       = "تاريخ خاطئ";
$_lang['c_not_a_month']    = "ليس شهر";
$_lang['c_s']              = "";

$_lang['c_second'] = "ثانية";
$_lang['c_minute'] = "دقيقة";
$_lang['c_hour']   = "ساعة";
$_lang['c_day']    = "يوم";
$_lang['c_week']   = "أسبوع";
$_lang['c_month']  = "شهر";
$_lang['c_year']   = "سنة";
$_lang['c_decade'] = "عقد";

// Upload file library
$_lang['c_uf_choose_a_file']          = "الرجاء أختيار ملف .";
$_lang['c_uf_filename_rules']         = "الملف يتوجب ان يكون  مسماه بالاحرف الانجليزية والارقام والعلامات الموجودة بين القوسين  (- _ .) ومن غير مسافات.";
$_lang['c_uf_maximum_file_size']      = "الحجم المسموح به لرفع الملفات هو : ";
$_lang['c_uf_type_not_allowed']       = "صيغة الملف غير مسموح بها.";
$_lang['c_uf_uploaded_successfully']  = "تم رفع الملف بنجاح.";
$_lang['c_uf_file_is_already_exists'] = "نحن نعتذر يبدوا ان الملف المرفوع موجود مسبقاً , لذلك نتمنى اعادة تسمية الملف واعادة محاولة الرفع.";
$_lang['c_uf_long_file_name']         = "اسم الملف طويل يتوجب ان يكون اقل من 220 حرف حتى يتم قبوله في الرفع .";
$_lang['c_uf_failed_to_upload']       = "فشل في رفع الملف .";
$_lang['c_uf_our_server_del_the_file'] = "قام السيرفر بحذ ف الملف لاسباب أمنية.";
$_lang['c_uf_in_field_number']         = "في الحقل رقم";

// pagination library
$_lang['c_pg_first']    = "&laquo; الاولى";
$_lang['c_pg_previous'] = "&laquo; السابق";
$_lang['c_pg_adjacent'] = "&hellip;";
$_lang['c_pg_adjacent'] = "&hellip;";
$_lang['c_pg_next']     = "التالي &raquo;";
$_lang['c_pg_last']     = "الاخيرة &raquo;";

// recaptcha
/*Removed By Albert (Negix)
$_lang['c_recaptcha'] = array(
    "invalid-site-public-key"  => "المفتاح العام خاطئ.",
    "invalid-site-private-key" => "المفتاح السري خاطئ.",
    "invalid-request-cookie"   => "خطئ في استقبال الكعكات.",
    "incorrect-captcha-sol"    => "لقد ادخلت رمز التحقق بشكل خاطئ.",
    "verify-params-incorrect"  => "التحقق من المعلمات غير صحيح",
    "invalid-referrer"         => "المرجعية غير صالحة",
    "recaptcha-not-reachable"  => "اختبار reCAPTCHA غير قابلة للوصول."
);
*/

?>
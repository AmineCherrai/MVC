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
 *  File path BASE_PATH/cliprz_application/config/ .
 *  File name router.php .
 *  Created date 21/11/2012 01:01 AM.
 *  Last modification date 03/12/2012 10:05 AM.
 *
 * Description :
 *  Routing file.
 *
 * Licenses :
 *  This program is released as free software under the Affero GPL license. You can redistribute it and/or
 *  modify it under the terms of this license which you can read by viewing the included agpl.txt or online
 *  at www.gnu.org/licenses/agpl.html. Removal of this copyright header is strictly prohibited without
 *  written permission from the original author(s).
 */

if (!defined("IN_CLIPRZ")) die('Access Denied');

/**
 * Warning :
 *  Do not use
 *   ('index.php','index','public','cliprz_temporary','cliprz_system','cliprz_application') as routing regex.
 */

cliprz::system(router)->index("home");

cliprz::system(router)->rule(array(
	"regex"    => "home",
	"class"    => "home",
	"function" => "index",
	"method"   => "GET"
));

cliprz::system(router)->rule(array(
	"regex"    => "cliprzinfo",
	"class"    => "home",
	"function" => "info",
	"method"   => "GET"
));
 

?>
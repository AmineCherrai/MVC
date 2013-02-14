<?php if (!defined("IN_CLIPRZ")) die('Access Denied'); ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8" />
<title><?php echo (isset($_error['title']) && !empty($_error['title'])) ? $_error['title'] : c_lang('c_database_error'); ?></title>
<link rel="stylesheet" href="<?php echo cliprz::system(error)->errors_style('database.css'); ?>" type="text/css" />
</head>
<body>

<div id="database_container">
<div id="database_bodytitle"><?php echo (isset($_error['title']) && !empty($_error['title'])) ? $_error['title'] : c_lang('c_database_error'); ?></div>
<div class="database_bodytext ">
<?php echo (isset($_error['content']) && !empty($_error['content'])) ? $_error['content'] : c_lang('c_database_error_message'); ?>
</div>
</div>


</body>
</html>
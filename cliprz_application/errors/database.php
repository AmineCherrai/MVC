<?php if (!defined("IN_CLIPRZ")) die('Access Denied'); ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8" />
<title><?= c_lang('c_database_error'); ?></title>
<style type="text/css">
html,body { margin: 5px; padding: 0; outline: 0; }
body { background-color: white; color: #606060; }
#database_container { width: 500px; background-color: #FFFFCC; padding: 5px; margin: 10px 0px; border: 1px dotted #FFCC33; }
#database_bodytitle { font: 13pt/15pt verdana, arial, sans-serif; height: 35px; vertical-align: top; }
.database_bodytext  { font: 8pt/11pt verdana, arial, sans-serif;  }
a:link     { font: 8pt/11pt verdana, arial, sans-serif; color: red; }
a:visited  { font: 8pt/11pt verdana, arial, sans-serif; color: #4e4e4e; }
</style>
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
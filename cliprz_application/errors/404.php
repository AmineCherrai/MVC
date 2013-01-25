<?php if (!defined("IN_CLIPRZ")) die('Access Denied'); ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8" />
<title><?=c_lang('c_404_not_found');?></title>
<style type="text/css">
html,body { margin: 5px; padding: 0; outline: 0; }
body { background-color: white; color: black; }
#container { width: 500px; }
#bodytitle { font: 13pt/15pt verdana, arial, sans-serif; height: 35px; vertical-align: top; }
.bodytext  { font: 8pt/11pt verdana, arial, sans-serif;  }
a:link     { font: 8pt/11pt verdana, arial, sans-serif; color: red; }
a:visited  { font: 8pt/11pt verdana, arial, sans-serif; color: #4e4e4e; }
</style>
</head>
<body>


<div id="container">
<div id="bodytitle"><?=c_lang('c_404_not_found');?></div>
<div class="bodytext ">
<?=c_lang('c_404_not_found_message');?>
<br />
<br />
<a href="<?php echo c_url(""); ?>"><?=c_lang("c_back_to_homepage"); ?></a>
</div>
</div>


</body>
</html>
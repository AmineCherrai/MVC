<?php if (!defined("IN_CLIPRZ")) die('Access Denied'); ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8" />
<title><?=c_lang('c_404_not_found');?></title>
<link rel="stylesheet" href="<?php echo cliprz::system(error)->errors_style('404.css'); ?>" type="text/css" />
</head>
<body>


<div id="container">
<div id="bodytitle"><?=c_lang('c_404_not_found');?></div>
<div class="bodytext ">
<?=c_lang('c_404_not_found_message');?>
<br />
<br />
<a href="<?php echo C_URL; ?>"><?=c_lang("c_back_to_homepage"); ?></a>
</div>
</div>


</body>
</html>
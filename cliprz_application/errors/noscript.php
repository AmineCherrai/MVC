<?php if (!defined("IN_CLIPRZ")) die('Access Denied'); ?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8" />
<title><?=c_lang('c_no_script');?></title>
<link rel="stylesheet" href="<?php echo cliprz::system(error)->errors_style('noscript.css'); ?>" type="text/css" />
</head>
<body>

<div id="container">
<div id="bodytitle"><?=c_lang('c_no_script');?></div>
<div class="bodytext ">
<?=c_lang('c_no_script_message');?>
<br />
<br />
<a href="<?php echo C_URL; ?>"><?php echo c_lang("c_back_to_homepage"); ?></a>
</div>
</div>

</body>
</html>
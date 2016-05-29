<!DOCTYPE HTML>
<html>
<head>
<meta charset="<?php echo C_CHARSET; ?>" />
<title>Cliprz</title>
<link rel="icon" type="image/png" href="<?php echo c_image('favicon.png') ;?>" />
<link rel="stylesheet" href="<?php echo c_style("styles.css",false); ?>" type="text/css" />
<script type="text/javascript" src="<?php echo c_javascript("jquery.js"); ?>"></script>
</head>
<body>

<div class="logo">
    <img src="<?php echo c_image("logo.png"); ?>" alt="Cliprz" />
</div>

<div class="content">
<h2>Welcome</h2>
Welcome to Cliprz framework, Cliprz is free and open source PHP Framework,
this framework is easy, fast and safe to use,
you can learn more about Cliprz framework through <a href="http://cliprz.org/manual">Manual</a> documents.
Visit the official site periodically for the latest releases and updates. for informations visit <a href="<?=c_url('cliprzinfo');?>">cliprzinfo();</a>
<br />
<br />
You can edit this page by visiting
<div class="path">
    cliprz_application/views/home.page.php
</div>
<br />
<br />
You can edit controllers of this page by visiting
<div class="path">
    cliprz_application/controllers/home.php
</div>
<br />
<br />
You can edit CSS file
<div class="path">
    public/css/styles.css
</div>
The public folder is a special folder that Contains (images,CSS,fonts, and Javascript).
<br />
<br />
<br />
Also don't forget modify website URL from
<div class="path">
    cliprz_application/config/config.php
</div>
Search for
<div class="code">
<?php
highlight_string('<?php

$_config[\'output\'][\'url\'] = "http://localhost/Cliprz/";

?>');
?>
</div>
<br />
<h2>Databases</h2>
If you want to use a database edit connections values from
<div class="path">
    cliprz_application/config/config.php
</div>
<div class="code">
<?php
highlight_string('<?php

$_config[\'db\'][\'host\']      = "localhost";
$_config[\'db\'][\'user\']      = "root";
$_config[\'db\'][\'pass\']      = "";
$_config[\'db\'][\'name\']      = "";
$_config[\'db\'][\'prefix\']    = "";
$_config[\'db\'][\'charset\']   = "utf8";
$_config[\'db\'][\'collation\'] = "utf8_unicode_ci";
$_config[\'db\'][\'port\']      = null; // By default port is 3306
$_config[\'db\'][\'socket\']    = null;
$_config[\'db\'][\'pconnect\']  = false; // use in MySQLi, SQLite Only.
$_config[\'db\'][\'options\']   = array();

?>');
?>
</div>
<br />
<br />
Don't forget to edit value to true in use database and choose your driver you prefer
<div class="code">
<?php
highlight_string('<?php

$_config[\'db\'][\'use_database\'] = true;
$_config[\'db\'][\'driver\']       = "mysqli";

?>');
?>
</div>
<br />
<h2>Information</h2>
<pre>
Version : <?=cliprz::get_framework("version"); ?> <?=cliprz::get_framework("stability"); ?>
</pre>
</div>

<div class="under">
<?php echo cliprz::get_framework("under"); ?>
</div>

</body>
</html>
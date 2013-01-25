<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8" />
<title><?php echo cliprz::get_framework('name'); ?></title>
<style type="text/css">
html,body { margin: 0; padding: 0; outline: 0; }
body { background-color: #FFF; color: black; direction: ltr; font: 8pt verdana, arial, sans-serif; }
.logo { font-size: 40pt; font-weight: bold; letter-spacing: -9pt; font-family: Arial, Arial Black; }
.lc { color: #3088C7; }
.ll { color: #59BB4C; }
.li { color: #F69224; }
.lp { color: #F05D28; }
.lr { color: #C0C0C0; }
.lz { color: #30C5F3; }
.null { margin: 0; }
a { color: #CC0000; }
a:hover { color: #990000; }
#info { width: 85%; margin: 0 auto 50px auto; position: relative; }
.content { padding: 1px; border: 1px solid #CCC; }
.head { background-color: #ddd; color: #202020; padding: 5px; font-size: 9pt; font-weight: bold; }
.f { border-top: 1px solid #CCC; }
.f-left { float: left; width: 35%; background-color: #F1F1F1; }
.f-left .c { padding: 5px; }
.f-center { padding: 5px; background-color: #F1F1F1; }
.f-right { float: right; width: 65%; }
.f-right .c { padding: 5px; }
.clear { clear: both; }
</style>
</head>
<body>

<div id="info">

    <div>
        <h2 class="null logo">
            <span class="lc">C</span>
            <span class="ll">L</span>
            <span class="li">I</span>
            <span class="lp">P</span>
            <span class="lr">R</span>
            <span class="lz">Z</span>
        </h2>
    </div>

    <div class="content">

    <div class="head">
        <?= cliprz::get_framework('name'); ?> information.
    </div>

    <div class="f">
        <div class="f-left"><div class="c">Version</div></div>
        <div class="f-right"><div class="c"><?= cliprz::get_framework("version"); ?> - <?=cliprz::get_framework("stability")?></div></div>
        <div class="clear"></div>
    </div>

    <?php

    if ($phpinfo === true)
    {
    ?>
    <div class="f">
        <div class="f-left"><div class="c">PHP Version</div></div>
        <div class="f-right"><div class="c"><?= PHP_VERSION; ?></div></div>
        <div class="clear"></div>
    </div>
    <div class="f">
        <div class="f-left"><div class="c">PHP Loaded Extensions<br /><br /><br /><br /><br /><br /></div></div>
        <div class="f-right"><div class="c"><?= $loaded_extensions; ?></div></div>
        <div class="clear"></div>
    </div>
    <?php
    }
    ?>

    <div class="head">
        <?php echo cliprz::get_framework('name'); ?> Constants.
    </div>

    <?php
        foreach ($constants as $key => $value)
        {
    ?>
        <div class="f">
            <div class="f-left"><div class="c"><?= $key; ?></div></div>
            <div class="f-right"><div class="c"><?= $value; ?></div></div>
            <div class="clear"></div>
        </div>
    <?php
        }
    ?>

    <div class="head">
        <?php echo cliprz::get_framework('name'); ?> Functions.
    </div>

    <div class="f">
        <div class="f-center"><?= $functions; ?></div>
    </div>

    <div class="head">
        <?php echo cliprz::get_framework('name'); ?> Developers.
    </div>

    <div class="f">
        <div class="f-center"><?= $developers; ?></div>
    </div>

    </div>

</div>

</body>
</html>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8" />
<title><?php echo cliprz::system(cap)->get_title(); ?></title>
<link rel="stylesheet" href="<?php echo cliprz::system(cap)->get_file('styles.css'); ?>" type="text/css" />
<script type="text/javascript">
var capanelURL = "<?php echo cliprz::system(cap)->get_info('theme_url'); ?>";
</script>
<script type="text/javascript" src="<?php echo c_javascript('jquery.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo cliprz::system(cap)->get_file('jquery.tipsy.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo cliprz::system(cap)->get_file('capenl.js') ; ?>"></script>
</head>
<body>
<!--wrapper-->
<div id="wrapper">

    <!--header-->
    <div id="header">
        <div class="logo-side">
            <div class="logo">
                <img src="<?php echo cliprz::system(cap)->get_image('logo.png'); ?>" alt="CAPanel" />
            </div>
        </div>
        <div class="more-side">
            <div class="more">&nbsp;</div>
        </div>
        <div class="clear"></div>
    </div>
    <!--/header-->

    <!--navbar-->
    <div id="navbar">
        <ul>
            <li><a href="<?php echo cliprz::system(cap)->url('home'); ?>">Home</a></li>
            <li><a target="_blank" href="http://cliprz.org">Cliprz.org</a></li>
        </ul>
        <div class="clear"></div>
    </div>
    <div class="clear"></div>
    <!--/navbar-->

    <div class="br">&nbsp;</div>

    <!--conetnt-->
    <div id="conetnt">

        <!--content-table-->
        <table class="content-table">
        <tr class="content-tr">
            <!--goto-side-->
            <td class="goto-side">

                <?php

                cliprz::system(cap)->display('goto','capanel');
                ?>

                <div class="br">&nbsp;</div>

                <!--goto-options-->
                <div class="goto-options">
                    <a class="expand-all" href="#">Open all</a>&nbsp;&nbsp;&nbsp;&nbsp;<a class="close-all" href="#">Close all</a>
                </div>
                <!--/goto-options-->

            </td>
            <!--/goto-side-->

            <!--content-side-->
            <td class="content-side">
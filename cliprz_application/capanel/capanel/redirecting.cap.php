<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8" />
<title><?php echo (isset($title)) ? $title : 'Redirecting'; ?></title>
<meta http-equiv="refresh" content="<?php echo (isset($time)) ? $time : 3; ?>; url=<?php echo cliprz::system(cap)->url(isset($page) ? $page : "home"); ?>" />
<link rel="stylesheet" href="<?php echo cliprz::system(cap)->get_file('styles.css'); ?>" type="text/css" />
</head>
<body>

<div id="redirecting">
    <div class="redirecting_title"><?php echo (isset($title)) ? $title : 'Redirecting'; ?></div>
    <div class="redirecting_message"><?php echo (isset($message)) ? $message : 'Message'; ?></div>
    <div class="redirecting_waiting">
        <a href="<?php echo cliprz::system(cap)->url(isset($page) ? $page : "home"); ?>">Click here if you don't want to wait any longer.</a>
    </div>
</div>

</body>
</html>
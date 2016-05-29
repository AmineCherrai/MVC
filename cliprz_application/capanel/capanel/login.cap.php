<!DOCTYPE HTML>
<html>
<head>
<meta charset="UTF-8" />
<title>Login</title>
<link rel="stylesheet" href="<?php echo cliprz::system(cap)->get_file('styles.css'); ?>" type="text/css" />
<script type="text/javascript" src="<?php echo c_javascript('jquery.js') ; ?>"></script>
<script type="text/javascript" src="<?php echo cliprz::system(cap)->get_file('jquery.watermark.js') ; ?>"></script>
</head>
<body>

<div id="login">
    <div class="login_field">
    <!--<div class="error">Here login errors</div>-->
    <input type="text" class="text-small" name="email" />
    <input type="password" class="text-small" name="password" />
    <input type="submit" value="Login" />
    </div>
</div>
<script type="text/javascript">
$("input[name=email]").watermark("Email");
$("input[name=password]").watermark("Password");
</script>

</body>
</html>
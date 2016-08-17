<!DOCTYPE HTML>
<html>
<head>
<meta charset="<?=CHARSET?>">
<title>404 Not Found</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="<?=assets('bootstrap/css/bootstrap.css');?>">
<style type="text/css">
body {
    padding-top: 60px;
    background-color: #F5F5F5;
}

.page {
    max-width: 500px;
    margin: 20px auto 0px;
    background-color: #FFF;
    border: 1px solid #e5e5e5;
    -webkit-border-radius: 5px;
    -moz-border-radius: 5px;
    border-radius: 5px;
    -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
    -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
    box-shadow: 0 1px 2px rgba(0,0,0,.05);
}

.page h1 {
    padding: 10px;
    margin: 0;
    border-bottom: 1px solid #E5E5E5;
}
.page p {
    padding: 10px;
}

.back {
    max-width: 500px;
    margin: 20px auto 20px;
}

@media (max-width: 979px) {
    .page h1 {
        font-size: 15pt;
    }
}
</style>
<link rel="stylesheet" type="text/css" href="<?=assets('bootstrap/css/bootstrap-responsive.css');?>">
<script type="text/javascript" src="<?=javascript('jquery.js');?>"></script>
<script type="text/javascript" src="<?=assets('bootstrap/js/bootstrap.js');?>"></script>
</head>
<body>

<div class="page">
    <h1>404 Not Found</h1>
    <p>The requested resource could not be found but may be available again in the future.
    Subsequent requests by the client are permissible.</p>
</div>

<div class="back">
    <a href="<?=URL;?>" class="btn btn-large btn-block"><span class="icon-home"></span> Back to home page</a>
</div>

</body>
</html>
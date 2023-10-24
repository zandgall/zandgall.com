<?php
$ROOT = str_repeat("../", substr_count($_SERVER['REQUEST_URI'], "/"));
?>

<head>
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src='<?php echo $ROOT?>/global/perlin.js'></script>
    <title><?php echo $pagetitle?></title>
    <meta name="description" content="<?php echo $pagedesc?>">
    <meta name="author" content="Zandgall">
    
    <link rel="icon" href="<?php echo $ROOT?>assets/Icon.png">
    
    <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" type="text/css">
    <style>
        @font-face {
            font-family: basicbit2;
            src: url("assets/basicbit2.ttf");
        }
    </style>
    
    <link rel="stylesheet" href="<?php echo $ROOT?>style.css">
    <link rel="stylesheet" href="<?php echo $ROOT?>scroll.css">
    <link rel="stylesheet" href="<?php echo $ROOT?>global/parallax.css">
<!-- Head is ended in begin, to allow for page-specific head elements -->


<html lang="en">
    <head>
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="layers.js"></script>
    <title>Zandgall - Normal Buddy</title>
    <meta name="description" content="Information about a small tool for creating Normal maps">
    <meta name="author" content="Zandgall">
    
    <link rel="icon" href="assets/Icon.png">
    
    <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" type="text/css">
    
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="scroll.css">
    <link rel="stylesheet" href="global/parallax.css">
</head>

<body>
    <?php 
    $title = "Normal Buddy!";
    $subtitle = "Liking the PBR sandwich";
    ?>
    <!--    Split everything into a universal div-->
    <div id = "cut" style="height: 100vh; width: 100%; top: 0; left: 0; overflow: hidden;">
        <div id="universal" class = "parallax">

            <?php include "global/head.php"?>

            <div class="section" style="position: relative; margin-left: auto; margin-right: auto; margin-top: 80; width: 800">
                
                <!--STUFF HERE-->
                <h1 class="basictext">Normal Buddy</h1>
                <h2 class="basictext">This tool creates a Normal map based on a height map, or diffuse map. It tries to guess based on the darker and light spots of an image. This "Normal Map" is used in 3d Programs in order to create faked lighting.</h2>
                <img class = "section" src="assets/thumbnail/NormalBuddyThumb.png" style="width: 98%; margin-left: 1%">
                <a href="Downloads/Normal Buddy.zip"><div class="section" style="width:75%; margin-left: auto; margin-right: auto; margin-bottom: 20;"><h1 class="basictext outlinetext">Normal Buddy.zip - 38KB</h1></div></a>
                <a href="index"><div class="section" style="width:25%; margin-left: auto; margin-right: auto; margin-bottom: 20;"><h1 class="basictext outlinetext">Home</h1></div></a>
            </div>
        
        </div>
    </div>
    
    
</body>
</html>










































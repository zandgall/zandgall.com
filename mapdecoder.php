
<html lang="en">
    <head>
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="layers.js"></script>
    <title>Zandgall - Map Decoder</title>
    <meta name="description" content="Information about the Map Decoder by Zandgall">
    <meta name="author" content="Zandgall">
    
    <link rel="icon" href="assets/Icon.png">
    
    <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" type="text/css">
    
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="scroll.css">
    <link rel="stylesheet" href="global/parallax.css">
</head>

<body>
    <?php 
    $title = "Welcome to the site!";
    $subtitle = "A resource for Arvopia and other projects";
    ?>
    <!--    Split everything into a universal div-->
    <div id = "cut" style="height: 100vh; width: 100%; top: 0; left: 0; overflow: hidden;">
        <div id="universal" class = "parallax">

            <?php include "global/head.php"?>

            <div class="section" style="position: relative; margin-left: auto; margin-right: auto; margin-top: 80; width: 800">
                
                <!--STUFF HERE-->
                <h1 class="basictext">Map Decoder</h1>

                <h2 class="basictext">The Map Decoder was a small side project, to import and export .dat Minecraft maps and PNGs. It's main usage, is taking an image, and resizing and converting the colors to colors used by Minecraft maps. Then, it is written to NBT and can be used in any Minecraft world. There's not much to the program other than the code behind it, using a library to write the NBT, and filtering colors based on which color is closest in "distance". Where, RGB would be XYZ and it checks differences between "Points"</h2>
                <img class = "section" src="assets/thumbnail/MapCoderThumb.png" style="width: 98%; margin-left: 1%">
                <a href="Downloads/MapCoder - BETA0.1.zip"><div class="section" style="width:75%; margin-left: auto; margin-right: auto; margin-bottom: 20;"><h1 class="basictext outlinetext">MapCoder - BETA0.1.zip - 83KB</h1></div></a>
                <a href="index"><div class="section" style="width:25%; margin-left: auto; margin-right: auto; margin-bottom: 20;"><h1 class="basictext outlinetext">Home</h1></div></a>
            </div>
        
        </div>
    </div>
    
    
</body>
</html>










































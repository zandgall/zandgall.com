<html lang="en">
    <head>
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="layers.js"></script>
    <title>Zandgall - Fire</title>
    <meta name="description" content="A Simple fire simulation">
    <meta name="author" content="Zandgall">
    <script type="text/javascript" src="Funsies/NOISE/PATH.js"></script>
    
    <link rel="icon" href="assets/Icon.png">
    
    <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" type="text/css">
    
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="scroll.css">
    <link rel="stylesheet" href="global/parallax.css">
</head>

<body>
<?php 
    $title = "Fire!";
    $subtitle = "So fake I feel cold!";
    ?>
    <!--    Split everything into a universal div-->
    <div id = "cut" style="height: 100vh; width: 100%; top: 0; left: 0; overflow: hidden;">
        <div id="universal" class = "parallax">

            <?php include "global/head.php"?>
            <div style="margin:auto; width: 766; height: 60">
                <canvas class="section" id="Perlin" width=200 height=200 style="position:relative; margin: auto; margin-top:100; margin-bottom: 100; width:800; height:800;">CANVAS NOT SUPPORTED</canvas> 
            </div>
                
    <!--
            <div class="section" style="margin:auto; width: 766; height: 60">
                <input type="range" min=1 max=1200 value=200 class="slider" id="NUMPARTICLES" name = "Number of particles">
                <input type="range" min=0 max=1 value=0.1 class="slider" id="PARTICLEALPHA" name = "Alpha">
                <input type="range" min=0 max=255 value=0 class="slider" id="PARTICLERED" name="Red">
                <input type="range" min=0 max=255 value=100 class="slider" id="PARTICLEGREEN" name = "Green">
                <input type="range" min=0 max=255 value=200 class="slider" id="PARTICLEBLUE" name = "Blue">
                <input type="range" min=0.1 max=20 value=2 class="slider" id="PARTICLESPEED" name = "Particle Speed">
            </div>
    -->
            
            <script type="text/javascript" src="Funsies/NOISE/fire.js">
                
            </script>
        </div>
    </div>
    
</body>
</html>









































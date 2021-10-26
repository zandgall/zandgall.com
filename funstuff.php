
<html lang="en">
    <head>
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="layers.js"></script>
    <title>Zandgall - Funsies
    </title>
    <meta name="description" content="For fun little projects you can play right here on the site">
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
                <div class="section" id = "master" style="margin-left: auto; margin-right: auto; width: 800; position: relative;">
                    <div id="projects">
                        <div style="width:100%; height:2100px;float:left;position:relative;"></div>
                        <a href="bubblecannons"><div class="proj" style="width: 100%; height:300px;float:left;position:absolute;">
                            <img class="projimg" src="assets/funsies/bubblecannons.png", style="width:100%; height:inherit; position:absolute; object-fit: cover">
                            <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
                            <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">Bubble Cannons</h1>
                            <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">A basic tower defense game where you stop other cannons from making it to the end of the path</h1>
                            <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
                        </div></a>
                        <a href="openinsects"><div class="proj" style="width: 100%; height:300px;float:left;position:absolute; top: 300px">
                            <img class="projimg" src="assets/funsies/openinsects.png", style="width:100%; height:inherit; position:absolute; object-fit: cover">
                            <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
                            <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">Open Insects</h1>
                            <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">Where one of five types of insects invade your screen</h1>
                            <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
                        </div></a>
                        <a href="fire"><div class="proj" style="width: 100%; height:300px;float:left;position:absolute; top: 600px">
                            <img class="projimg" src="assets/funsies/fire.png", style="width:100%; height:inherit; position:absolute; object-fit: cover">
                            <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
                            <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">Fire</h1>
                            <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">A basic, low-res, fire simulation</h1>
                            <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
                        </div></a>
                        <a href="flowfield"><div class="proj" style="width: 100%; height:300px;float:left;position:absolute; top: 900px">
                            <img class="projimg" src="assets/funsies/flowfield.png", style="width:100%; height:inherit; position:absolute; object-fit: cover">
                            <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
                            <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">Flow field</h1>
                            <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">The predecessor to Vector Fields, a bunch of particles dash around your screen making a cool pattern</h1>
                            <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
                        </div></a>
                        <a href="starfield"><div class="proj" style="width: 100%; height:300px;float:left;position:absolute; top: 1200px">
                            <img class="projimg" src="assets/funsies/starfield.png", style="width:100%; height:inherit; position:absolute; object-fit: cover">
                            <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
                            <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">Starfield</h1>
                            <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">The predecessor to the upcoming, Solar Glyphs. Arrows/WASD to move, CTRL+Arrows/WASD to zoom</h1>
                            <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
                        </div></a>
                        <a href="boids"><div class="proj" style="width: 100%; height:300px;float:left;position:absolute; top: 1500px">
                            <img class="projimg" src="assets/funsies/boids.png", style="width:100%; height:inherit; position:absolute; object-fit: cover">
                            <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
                            <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">Boids</h1>
                            <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">A Small simulation similar to Open Insect, except it's the Boids Algorithm</h1>
                            <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
                        </div></a>
                        <a href="cannondefense"><div class="proj" style="width: 100%; height:300px;float:left;position:absolute; top:1800px">
                            <img class="projimg" src="assets/funsies/bubblecannons.png", style="width:100%; height:inherit; position:absolute; object-fit: cover">
                            <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
                            <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">Cannon Defense</h1>
                            <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">A mockup of BubbleCannons mixed with "Toy defense" made by my 9 year old brother, Nat</h1>
                            <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
                        </div></a>
                    </div>
                    <h1 class="basictext">These are the very low-level "games", check out the other stuff I've made if you want to know what I can really do!</h1>
            </div>
        
        </div>
    </div>
    
    
</body>
</html>










































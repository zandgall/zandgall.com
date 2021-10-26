
<html lang="en">
    <head>
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="layers.js"></script>
    <title>Zandgall - Solar Glyphs</title>
    <meta name="description" content="Information about and download for Solar Glyphs">
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
                
                <img class="section" width=880 style="margin-top: 40; margin-left: -40; margin-bottom: 10; position: relative; width 880; height: auto;" src="assets/solarglyphs/1.png">

                <h1 class="basictext">Solar Glyphs</h1>

                <h2 class="basictext">OpenGL and Glyphs/Vector Graphics</h2>

                <h3 class="basictext">
                    OpenGL, as some of you may know, is an Open Graphics Library installed on almost all modern computers. It is primarily used in 3D Graphics, however, it has very universal graphical potential. This does not mean that every graphics-based operation works well on OpenGL, there are quite a few drawbacks of it's rendering pipeline.
                    <br><br>
                    There isn't much that needs to be known, other than Vector Graphics on OpenGL doesn't work very well, and I mean it doesn't work at all. The textures you pass to OpenGL to use for drawing, are all images, so drawing Vector Graphics aren't an option unless you do it yourself.
                    <br><br>
                    Valve came up with a nice and handy solution for it, given in their SIGGRAPH 2007 paper: <a href="https://steamcdn-a.akamaihd.net/apps/valve/2007/SIGGRAPH2007_AlphaTestedMagnification.pdf">"Improved Alpha-Tested Magnification for Vector Textures and Special Effects".</a> Now, long name I know but after reading through it a few times, I decided that this technique would be what I base my game's graphics on.
                </h3>

                <img class="section" width=880 style="margin-top: 40; margin-left: -40; margin-bottom: 10; position: relative; width 880; height: auto;" src="assets/solarglyphs/glyph example.png">
                <h3 class="basictext">
                    It's basically where you take a low res image, upscale it to whatever size you want to render it at, and only display the parts that have enough red in them. This technique is mainly for text rendering, so I called the game "Solar Glyphs"
                </h3>
                <img class="section" width=880 style="margin-top: 40; margin-left: -40; margin-bottom: 10; position: relative; width 880; height: auto;" src="assets/solarglyphs/2.png">
                <h3 class="basictext">
                    There's all of the planets (+pluto) and most of the popular and notable moons. Each planet and moon has a wall of details and information about it, clicking on a planet allows you to view it's information through the info pane, toggled by a little (i) button. There's 2 buttons, one that makes planets larger (while retaining mass) so it's easier to see them, and one that toggles the simulation.
                    <br>
                    The Simulation isn't all that great, it works until the speed it pushed up too much (that is, the slider next to the "Simulate" button). However at a slow enough rate, or if you don't count moons veering off course as disasterous, then it works well enough to see basic planet movement.
                    <br><br>
                    There is also a 'map' that allows you to click on a planet/moon that you wanna get to quickly, and a camera indicator which shows how the camera moves. WASD will move the camera in free move, and clicking the middle mouse button will toggle the mouse being used to look around, or to select buttons and things and scrolling will change your Field of View. When you are in orbit mode, scrolling zooms in and out of the selected planet, and dragging the middle mouse button rotates around the planet.
                    <br><br>
                    All of the information used to place and write about each planet was gotten from NASA, however I may have missed things or gotten numbers wrong, but it should be sufficiently accurate to just be enjoyable.
                </h3>

                <a href="Downloads/Solar Glyphs 0.1.zip"><div class="section" style="width:75%; margin-left: auto; margin-right: auto; margin-bottom: 20;"><h1 class="basictext outlinetext">Download Solar Glyphs0.1.zip</h1></div></a>
                <a href="Downloads/Solar Glyphs 0.2.zip"><div class="section" style="width:75%; margin-left: auto; margin-right: auto; margin-bottom: 20;"><h1 class="basictext outlinetext">Download Solar Glyphs0.2.zip</h1></div></a>
                <div class="splitter" style="margin-bottom:10;"></div>
                <a href="index" style="position:absolute; align-content: center; text-align: center; float: left; left: 50%; margin-left: auto; margin-right: auto; margin-bottom: 10;"><div style="margin-left: -50%;"><h3 class="basictext">Back</h3></div></a>

            </div>
        
        </div>
    </div>
    
    
</body>
</html>










































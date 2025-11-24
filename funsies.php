<!DOCTYPE html>
<html lang="en">
<?php 
$pagetitle = "Zandgall - Funsies";
$pagedesc = "A set of fun little javascript programs and games you can play right here on the web";
include "global/header.php"?>

<?php 
$title = "Welcome to the site!";
$subtitle = "Finally, something to DO here";
include "global/begin.php";
include "global/projectGenerator.php"?>

<div class="section" style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm">
    <!--STUFF HERE-->
    <div id="projects">
        <?php 
        project("100%", "300px", "Bubble Cannons", "A basic tower defense game where you stop other cannons from making it to the end of the path",
                "assets/funsies/bubblecannons.png", "bubblecannons");
        project("100%", "300px", "Open Insects", "Where one of five types of insects invade your screen",
                "assets/funsies/openinsects.png", "openinsects");
        project("100%", "300px", "Fire", "A basic, low-res, fire simulation",
                "assets/funsies/fire.png", "fire");
        project("100%", "300px", "Flowfield", "The predecessor to Vector Fields, a bunch of particles dash around your screen making a cool pattern",
                "assets/funsies/flowfield.png", "flowfield");
        project("100%", "300px", "Starfield", "The predecessor to Solar Glyphs. Arrows/WASD to move, CTRL+Arrows/WASD to zoom",
                "assets/funsies/starfield.png", "starfield");
        project("100%", "300px", "Boids", "A Small simulation similar to Open Insect, except it's the Boids Algorithm",
                "assets/funsies/boids.png", "boids");
        project("100%", "300px", "Gun Boy Demo", "A demo for a Nat Gall original boss fight game",
                "assets/funsies/gunboy.png", "gunboy");
        ?>
    </div>
    <h1 class="basictext">These are the very low-level "games", check out the other stuff I've made if you want to know what I can really do!</h1>
</div>
<?php include "global/end.php"?>
</html>
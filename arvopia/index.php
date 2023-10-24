<!DOCTYPE html>
<html lang="en">
<?php 
$pagetitle = "Zandgall - Arvopia";
$pagedesc = "All about Arvopia by Zandgall";
include "../global/header.php"?>

<?php 
$title = "Arvopia!";
$subtitle = "The - so far - longest running project!";
include "../global/begin.php";
include "../global/projectGenerator.php";?>

<div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm">
    <!-- Parent has no display style, so give it one here, but with a lower opacity. Not applied to parent so that other children won't have a default opacity of 0.92 -->
    <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div>
    <!--STUFF HERE-->
    <div id="projects">
        <?php
        project("100%", "300px", "Arvopia 0.1", "A basic platformer with no objective. Flowers and stones fill the world, with bees and butterflies flying around. You sit and move around a floating island with just a single tree.", 
                "../assets/arvopia/arvopia0.1.png", "0.1");
        project("100%", "300px", "Arvopia 0.2", "A quick update sporting bridges and foxes. It gives the players the ability to kill entities by clicking on them, including flowers and stones. Flowers and stones now drop particles and items when killed, which can be picked up by clicking on them. Lives are shown for the first time, displayed next to counters for all your items.", 
                "../assets/arvopia/arvopia0.2.png", "0.2");
        project("100%", "300px", "Arvopia 0.3", "An expanded world for the player to explore. Items are no longer permanently displayed, but instead visible in the inventory when hitting 'ESC'. All entities have health now, creating more of a 'combat system' compared to 0.2. ", 
                "../assets/arvopia/arvopia0.3.png", "0.3");
        project("100%", "300px", "Arvopia 0.4", "The game is now officially called \"Arvopia\" and now includes many environmental features. Such as weather, clouds, sky, and lighting. Raining when it's wet and getting dark past sunset, torches can be used to cast light. There are now also menus and music to accompany the game, with the ability to play around with settings.", 
                "../assets/arvopia/arvopia0.4.png", "0.4");
        project("100%", "300px", "Arvopia 0.5", "An extreme expansion to the environment. Adding sunset and sunrise colors, all sorts of plants that populate the world. Trees, grass, ferns, and dandilions. Saving the game is now possible, and external worlds can be loaded in, created by the level creator.", 
                "../assets/arvopia/arvopia0.5.png", "0.5");
        project("100%", "300px", "Arvopia 0.6", "With the addition of survival and rpg mechanics, it's growing up to be almost a regular game. NPCs, Quests, Achievements, bigger worlds, crafting, tree fall colors, and snow now included. Lia, Frizzy, and Fawncier can be found in Worlds 1 and 4, all with quests that can give you something to finally do in this game.", 
                "../assets/arvopia/arvopia0.6.png", "0.6");
        project("100%", "300px", "Arvopia 0.7", "\"The Customization Update\", customizable character, modding capabilities, internal level creator, generating random levels, there's a whole host of features to explore. Not to mention the major performance improvements compared to 0.6. With a large amount of smaller features that would take up too much space to write out.", 
                "../assets/arvopia/arvopia0.7.png", "0.7");
        project("100%", "300px", "Arvopia 0.8", "So far unreleased, an update that includes massive performance boost and overhauls of animations and lighting system, with animals added and some graphical changes. Overall a much better experience of Arvopia, and a peek at what it might look like in C++, if it ever comes to C++ at least.",
                "../assets/arvopia/arvopia0.8.png", "0.8");
        ?>
    </div>

    <h1 class="basictext">Each page has a download link, but it's much easier and simpler to download from <a
            href="arvopiadownload">here</a> if that's what you're interested in</h1>
</div>
<?php include "../global/end.php"?>
</html>
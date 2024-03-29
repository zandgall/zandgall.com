<!DOCTYPE html>
<html lang="en">
<?php 
$pagetitle = "Zandgall - Arvopia 0.3";
$pagedesc = "All about Arvopia version 0.3";
include "../global/header.php"?>

<?php 
$title = "Arvopia 0.3!";
$subtitle = "How much more classic can you get? (Answer: 2 versions classicaler)";
include "../global/begin.php"?>

<div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm">
    <!-- Parent has no display style, so give it one here, but with a lower opacity. Not applied to parent so that other children won't have a default opacity of 0.92 -->
    <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div>
    <!--STUFF HERE-->
    <img class="section"src="../assets/arvopia/arvopia0.3.png" style="width:98%; position: relative; left:0.8%; margin-top:1%" alt="Arvopia 0.3 Screenshot">
    <h1 class="basictext">
        Version 0.3
    </h1>

    <h2 class = "basictext">
        Released just 10 days after version 0.2, "Platformer 0.3" gave major improvements and changed in a few different fields. A larger world, physics had been altered, more items were added, load time was cut, and 'combat' was changed.
    </h2>

    <h2 class="basictext">
        Arvopia 0.3 had removed lag from the second version, whenever foxes spawned. However, there were still three major bugs included. First of which being the bug of small jumping from the previous two versions. The second bug, is with flowers and stones spawning on the highest platforms of grass in the world, so if there is a platform above another, no flowers or stones will spawn on the bottom platform.<br><br>
        The final bug is with the collision. Whenever you jump into the side of a 1-tile tall platform, it will let you pass through the tile, until either the top, or bottom of the player touches it. Similarly with bridges, if the bottom of the player touches a bridge while trying to jump on to it, the player will be teleported straight to the top of the bridge and all it's movement will be stopped instantly.
    </h2>

    <div class="splitter" style="margin-bottom:1cm"></div>
    <img class="section" src="../assets/arvopia/arvopia%200.3/health%20bars.png" style="image-rendering: pixelated; width:98%; position: relative; left:0.8%" alt="Health Bars">

    <h2 class="basictext">
        Like 0.2, you can kill entities when you click on them. Unlike 0.2 however, creatures are given health. Foxes have a health of 5, butterflies with 2, and bees with 1. You can also see each creatures health with healthbars that are shown abover their head. Creature also drop items apon death. Foxes give fur, butterflies give wings, and bees give honey. There's still nothing to do with these items, but they're in the game.<br><br>
        Items are also now viewed inside the menu, which is opened with esc. Leaving the GUI reserved for showing the player's lives.
    </h2>

    <a href="../Downloads/Platformer0.3.zip"><div class="section" style="width:75%; margin-left: auto; margin-right: auto; margin-bottom: 1cm;"><h1 class="basictext outlinetext">Download Arvopia 0.3.zip</h1></div></a>
    <div class="splitter" style="margin-bottom: 1cm;"></div>
    <a href="0.2" style="position:relative; float:left"><h3 class="basictext">Previous Version: 0.2</h3></a>
    <a href="../" style="position:absolute; align-content: center; text-align: center; float: left; left: 50%; margin-left: auto; margin-right: auto"><div style="margin-left: -50%;"><h3 class="basictext">Back</h3></div></a>
    <a href="0.4" style="position:relative; float:right;"><h3 class="basictext">Next Version: 0.4</h3></a>

</div>
<?php include "../global/end.php"?>
</html>
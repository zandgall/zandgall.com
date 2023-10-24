<!DOCTYPE html>
<html lang="en">
<?php 
$pagetitle = "Zandgall - Arvopia 0.5";
$pagedesc = "All about Arvopia version 0.5";
include "../global/header.php"?>

<?php 
$title = "Arvopia 0.5!";
$subtitle = "(I never spelt foliage like foilage, that's just the mandella effect)";
include "../global/begin.php"?>

<div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm">
    <!-- Parent has no display style, so give it one here, but with a lower opacity. Not applied to parent so that other children won't have a default opacity of 0.92 -->
    <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div>
    <!--STUFF HERE-->
    <img class="section"src="../assets/arvopia/arvopia0.5.png" style="width:98%; position: relative; left:0.8%; margin-top:1%" alt="Arvopia 0.5 Screenshot">
    <h1 class="basictext">
        Version 0.5
    </h1>

    <h2 class = "basictext">
        Arvopia 0.5 is the Foliage update. It had a main focus on plants, as the name suggests, and it made some environmental changes.<br><br>
        The original tree tiles were removed in favor of an entity tree similar to rocks and flowers. When you break a tree, it drops wood. In addition to trees however, there is the addition of grass, ferns, and dandilions that spawn ontop of grass tiles.
    </h2>

    <div class="splitter" style="margin-bottom:1cm"></div>
    <img class="section" src="../assets/arvopia/arvopia%200.5/tree%20chopping.png" style="width:98%; position: relative; left:0.8%; image-rendering: pixelated;" alt="Tree Chopping Screenshot">

    <h1 class="basictext">
        Gameplay changes
    </h1>

    <h2 class="basictext">
        Static entities, that is those that don't move, are now given health. Their healthbar is shown similarly to non-static entities, however it does not display a value like it does with creatures, but more of a progress bar.
    </h2>

    <h1 class="basictext">
        Smaller changes
    </h1>

    <h2 class = "basictext">
        In the options menu, the Scale slider was removed and replaced with a Toggle Button for whether or not the game will pause itself when the mouse leaves the game window. In addition to a new option, the ability to save and load a world was added, allowing people to keep their progress.<br>
        Branching off from Arvopia 0.4, version 0.5 introduced sunsets and sunrise colors into the game to spice up the lighting system.
    </h2>
    <a href="../Downloads/Arvopia0.5.zip"><div class="section" style="width:75%; margin-left: auto; margin-right: auto; margin-bottom: 1cm;"><h1 class="basictext outlinetext">Download Arvopia 0.5.zip</h1></div></a>
    <div class="splitter" style="margin-bottom:1cm;"></div>
    <a href="../0.4" style="position:relative; float:left"><h3 class="basictext">Previous Version: 0.4</h3></a>
    <a href="../" style="position:absolute; align-content: center; text-align: center; float: left; left: 50%; margin-left: auto; margin-right: auto"><div style="margin-left: -50%;"><h3 class="basictext">Back</h3></div></a>
    <a href="0.6" style="position:relative; float:right"><h3 class="basictext">Next Version: 0.6</h3></a>

</div>
<?php include "../global/end.php"?>
</html>
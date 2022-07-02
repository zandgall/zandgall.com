<html lang="en">
<?php 
$pagetitle = "Zandgall - Arvopia Level Creator";
$pagedesc = "All about the legacy level creator for Arvopia";
include "global/header.php"?>

<?php 
$title = "LevelCrator!";
$subtitle = "Getting creative circa 2019";
include "global/begin.php"?>

<div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm">
    <!-- Parent has no display style, so give it one here, but with a lower opacity. Not applied to parent so that other children won't have a default opacity of 0.92 -->
    <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div>
    <!--STUFF HERE-->
    <h1 class="basictext outlinetext" style="font-size:72; margin-bottom:-10">Arvopia Level Creator</h1>
    <h2 class="basictext outlinetext">A Level Creating tool for Arvopia</h2>
    <div class="splitter"></div>
    <h1 class="basictext">Arvopia Level Creator</h1>

    <h2 class="basictext">Back when Arvopia 0.4 was in development, a level tool was already in the making, in order to make levels easier to design. It came out right after 0.4 released, and kept in development up until 0.7, when a Level Creator was implemented into Arvopia itself.</h2>

    <img class="section" src="assets/arvopia/LevelCreator0.1.png" style="width:120%; margin-left:-10%; position: relative; z-index: 2;">
    <h1 class="basictext">LevelCreator 0.1 - Arvopia 0.4</h1>
    <h2 class="basictext">
        Stuck to the basics, given the ability to load, save, and edit worlds. Theres a slider that gives you the ability to choose a tile to place down in the world by clicking with the "Tiler" tool selected. With tools in mind, the only other tool you can select with the tool slider, is an Eraser. Which deletes the tile that your mouse is over when you click.<br><br>It is important to note however, this version is broken. The output is not in a correct format.
    </h2>
    <a href="Downloads/LevelCreator0.1.zip"><div class="section" style="width:75%; margin-left: auto; margin-right: auto; margin-bottom: 20;"><h1 class="basictext outlinetext">LevelCreator0.1.zip - 148KB [BROKEN]</h1></div></a>
    <div class="splitter"></div>

    <img class="section" src="assets/arvopia/LevelCreator0.2.png" style="width:120%; margin-left:-10%; position: relative; z-index: 2;">
    <h1 class="basictext">LevelCreator 0.2 - Arvopia 0.4</h1>
    <h2 class="basictext">
        This is the same as 0.1, however outputting will work with Arvopia 0.4 now.
    </h2>
    <a href="Downloads/LevelCreator0.2.zip"><div class="section" style="width:75%; margin-left: auto; margin-right: auto; margin-bottom: 20;"><h1 class="basictext outlinetext">LevelCreator0.2.zip - 149KB</h1></div></a>
    <div class="splitter"></div>

    <img class="section" src="assets/arvopia/LevelCreator0.3.png" style="width:120%; margin-left:-10%; position: relative; z-index: 2;">
    <h1 class="basictext">LevelCreator 0.3 - Arvopia 0.5</h1>
    <h2 class="basictext">
        LevelCreator 0.3 had introduced the first actual new features to the LevelCreator. Starting with hotkeys, being able to switch through tiles now using + to increment up a tile id, and - to decrement down a tile id. That paired with hotkeys for selecting a tool to use.<br><br>There were a few new tools added, all in line with use with entities. First one for placing entities, then for moving entities, then the Remover for deleting entities. The Entities include Clouds, Flowers, Stones, and Trees. Along with those features added, there was also two buttons that make the world size bigger, or smaller.
    </h2>
    <a href="Downloads/LevelCreator0.3.zip"><div class="section" style="width:75%; margin-left: auto; margin-right: auto; margin-bottom: 20;"><h1 class="basictext outlinetext">LevelCreator0.3.zip - 330KB</h1></div></a>
    <div class="splitter"></div>
    <img class="section" src="assets/arvopia/LevelCreator0.4.png" style="width:120%; margin-left:-10%; position: relative; z-index: 2;">
    <h1 class="basictext">LevelCreator 0.4 - Arvopia 0.6</h1>
    <h2 class="basictext">
        For Arvopia 0.6, a LevelCreator was made, but never released in time for Arvopia 0.6 to recieve any community levels. There were quite a few additions with this version, most seen in Arvopia 0.7. Firstly, the two new tools given, Rect, and Auto-Rect. Rect fills in an area with a single tile, whereas Auto-Rect fills an area with certain tiles in order to make a grass platform.<br><br>Entities were also changed drastically, adding Villagers, Houses, and NPCs. There are two panels on either side of the screen. An easier tile selection menu on the right, and entity options on the left. Whenever you place or select a placed entity, you can change any options pertaining to it with the Left Panel.
    </h2>
    <a href="Downloads/LevelCreator0.4.zip"><div class="section" style="width:75%; margin-left: auto; margin-right: auto; margin-bottom: 20;"><h1 class="basictext outlinetext">LevelCreator0.4.zip - 375KB</h1></div></a>
    <div class="splitter"></div>
    <a href="index"><div class="section" style="width:50%; margin-left: auto; margin-right: auto; margin-bottom: 20; margin-top: 20"><h1 class="basictext outlinetext">Home</h1></div></a>
</div>
<?php include "global/end.php"?>
</html>
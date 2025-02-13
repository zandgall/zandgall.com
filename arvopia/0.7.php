<!DOCTYPE html>
<html lang="en">
<?php 
$pagetitle = "Zandgall - Arvopia 0.7";
$pagedesc = "All about Arvopia version 0.7";
include "../global/header.php"?>

<?php 
$title = "Arvopia 0.7!";
$subtitle = "Change is good";
include "../global/begin.php"?>

<div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm">
    <!-- Parent has no display style, so give it one here, but with a lower opacity. Not applied to parent so that other children won't have a default opacity of 0.92 -->
    <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div>
    <!--STUFF HERE-->
    <img class="section"src="../assets/arvopia/arvopia0.7.png" style="width:98%; position: relative; left:0.8%; margin-top:1%" alt="Arvopia 0.7 Screenshot">
    <h1 class="basictext">
        Version 0.7
    </h1>

    <h2 class ="basictext">
        In the aptly named Customization Update, Arvopia 0.7 is a treat for game mechanics and overall potential.
    </h2>
    <div class="splitter"></div>
    <h1 class="basictext">Modding</h1>
    <h2 class="basictext">
        The biggest change in this update, was the ability to import mods. A set of mods for the game, made by me, were planned to release on the website along with 0.7, however development on Arvopia 0.8 began right away which pushed modding aside.<br><br>
        Along with mods, the Story Pack world type was added. This would pack a world and all the mods it uses into one, so you could load up a world and have mods installed automatically, just for that world. A small story was planned, but again got put off.
    </h2>

    <img class="section" src="../assets/arvopia/arvopia%200.7/mods.png" style="width: 98%; position: relative; left:0.8%; margin-top: 5mm; margin-bottom: 5mm" alt="Screenshot of mods">
    <div class = "splitter"></div>
    <h1 class="basictext">Player Customization</h1>
    <h2 class="basictext">
        Along with modding the game, you can customize your character. Picking from a small array of different body parts and hairstyles. Each part can also change color with the HSV cube on the right. If you want more options, or something a little more exciting, you can get a costume for 500 in-game points. These points are aquired when you complete a quest or get an achievement. The three costumes available, are Felix, Gnome, and King.
    </h2>
    <img class="section" src="../assets/arvopia/arvopia%200.7/Player%20Customization.png" style="width:98%; position: relative; left: 0.8%; margin-top: 5mm; margin-bottom: 5mm" alt="Player Customization Menu Screenshot">

    <div class = "splitter"></div>
    <h1 class="basictext">LevelCreator</h1>
    <h2 class="basictext">
        The LevelCreator is now built in as opposed to being a separate app like before. You can simply get into the LevelCreator from the World Choosing menu.<br><br>
        Rather than being a port of the original LevelCreator, this one has a completely revamped design. There are 4 menus to choose from. First one being the Settings for world size, name, and display information. Second is tiles, which is just a menu that lets you pick tiles to place down. Third controls natural spawning data of every entity, and fourth allows you to place down certain entities to preset them to exist in the world.
    </h2>
    <img class="section" src="../assets/arvopia/arvopia%200.7/levelcreator.png" style="width:98%; position:relative; left: 0.8%; margin-top: 5mm; margin-bottom: 5mm;" alt="Level Creator Screenshot">

    <div class = "splitter"></div>
    <h1 class="basictext">Gameplay</h1>
    <h2 class="basictext">
        There were a few major gameplay changes in this version, one of the more obvious is the new animals. There are 5 new animals. The bear, wolf, skunk, fairy, and bat. Bears and wolves will attack you if you attack them, but the rest won't attack you. However a fairy has the chance to spawn as hostile, which will attack the player at all times.<br><br>
        Another big gameplay element, was the Inventory. This was changes to allow you to move items, as well as make things. There are 10 items you can collect, and 6 tools you can make out of those 10 items.<br><br>
        Similarly to the Inventory, the Trading GUI was revamped. You can now respond with certain things to follow different dialogue options. So far only Lia has this feature, other NPCs just have "..." as the response for all the talking, and "Ok bye!" for when you leave.
    </h2>
    <img class="section" src="../assets/arvopia/arvopia%200.7/TradeMenu.png" style="width:98%; position:relative; left: 0.8%; margin-top: 5mm; margin-bottom: 1cm;" alt="Trade Menu Screenshot">

    <a href="../Downloads/Arvopia0.7.zip"><div class="section" style="width:75%; margin-left: auto; margin-right: auto; margin-bottom: 1cm;"><h1 class="basictext outlinetext">Download Arvopia 0.7.zip</h1></div></a>
    <div class="splitter" style="margin-bottom:1cm;"></div>
    <a href="0.6" style="position:relative; float:left"><h3 class="basictext">Previous Version: 0.6</h3></a>
    <a href="../" style="position:absolute; align-content: center; text-align: center; float: left; left: 50%; margin-left: auto; margin-right: auto"><div style="margin-left: -50%;"><h3 class="basictext">Back</h3></div></a>
    <a href="0.8" style="position:relative; float:right"><h3 class="basictext">Next Version: 0.8</h3></a>

</div>
<?php include "../global/end.php"?>
</html>
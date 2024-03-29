<!DOCTYPE html>
<html lang="en">
<?php 
$pagetitle = "Zandgall - Arvopia 0.8";
$pagedesc = "All about Arvopia version 0.8";
include "../global/header.php"?>

<?php 
$title = "Arvopia 0.8!";
$subtitle = "Has never been released, and it never will be!";
include "../global/begin.php"?>

<div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm">
    <!-- Parent has no display style, so give it one here, but with a lower opacity. Not applied to parent so that other children won't have a default opacity of 0.92 -->
    <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div>
    <!--STUFF HERE-->
    <img class="section"src="../assets/arvopia/arvopia0.8.png" style="width:98%; position: relative; left:0.8%; margin-top:1%" alt="Arvopia 0.8 Screenshot">
    <h1 class="basictext">
        Version 0.8
    </h1>

    <h2 class="basictext">
        Although no official title has been given to this update, it wouldn't be a stretch to call it "The Graphical Update" simply for it's major themes around making Arvopia look better than it ever has before. However there is an overhaul with performance included, making it one of the fastest versions as well.
    </h2>

    <div class="splitter"></div>

    <h1 class = "basictext">
        Player Animation
    </h1>

    <h2 class="basictext">
        Not the most polished thing, but definitely a good premise. Each limb of a player will be drawn at a certain rotation. This gives a smoother set of animations, that can work with any limb or costume design.<br><br>This also adds the option of custom animations, so that no new sprites are needed whenever a modder wishes to add a player animation. This definitely isn't as spot-on as it could've been, however development in C++ might eventually change that.
    </h2>

    <img class="section" src="../assets/arvopia/arvopia%200.8/player%20animation.gif" style="width: 98%; position: relative; left:0.8%; margin-top: 5mm; margin-bottom: 5mm; image-rendering: pixelated" alt="0.8 Player Animation">

    <div class = "splitter"></div>

    <h1 class = "basictext">
        Option Changes
    </h1>

    <h2 class="basictext">
        There were many option additions to this version, to boost performance and overall quality. A design change was therefore implemented in order to house these added options as well as make room for additions in the future.<br><br>The first of the two menus that the Options state contains, holds toggle-buttons and sliders for how the game should update and display. With FPS and Render Type, Music and Sound Volume, as well as Time Speed, Light Quality, and Light Smoothing types all for sliders. Each deals with what their names suggests, Light Smoothing and Render Type changing between speed and quality optimization.<br><br>The toggle-buttons change Slider Debug, Pause on Mouse Exit, Extra Debug, Render Background, Glow near sun, Sound per layer, Split-Stream Rendering, Split-Stream Lighting. The last three having to do with prioritizing CPU usage or framerate.<br><br>The second menu houses keybinds for every action in the game. From movement, to interaction and debug keys.
    </h2>

    <img class="section" src="../assets/arvopia/arvopia%200.8/options.png" style="width: 98%; position: relative; left:0.8%; margin-top: 5mm; margin-bottom: 5mm; image-rendering: pixelated" alt="0.8 Options Menu">

    <div class = "splitter"></div>

    <h1 class = "basictext">
        GUIs
    </h1>

    <h2 class="basictext">
        GUIs were changed this version, just like any other version. It gave a little more space for the gameplay and seeing certain menus optional. Firstly, the inventory gui was not changed, however the prompt for opening it was. Showing each gui prompt a little more subtly and out of the way. This also shows the two 'new' guis added.<br><br>You now have to hold down a key to see the weather information, instead of having it always be shown. You can now also see more detailed stats by toggling a button. This shows your health, breath, current sprite, and age. Breath is still included, although no water is used or usable in any level.<br><br>Although not much was changed with interacting menus, every NPC is now given a "voice" similar to that of games like Undertale, or Animal Crossing. Although more like the former.
    </h2>

    <img class="section" src="../assets/arvopia/arvopia%200.8/gui.png" style="width: 98%; position: relative; left:0.8%; margin-top: 5mm; margin-bottom: 5mm; image-rendering: pixelated" alt="0.8 Gui">

    <div class = "splitter"></div>

    <a href="../Downloads/Arvopia0.8.1.zip"><div class="section" style="width:75%; margin-left: auto; margin-right: auto; margin-bottom: 1cm;"><h1 class="basictext outlinetext">Download Arvopia 0.8.1.zip</h1></div></a>
    <div class="splitter" style="margin-bottom:1cm;"></div>
    <a href="0.7" style="position:relative; float:left"><h3 class="basictext">Previous Version: 0.7</h3></a>
    <a href="../" style="position:absolute; align-content: center; text-align: center; float: left; left: 50%; margin-left: auto; margin-right: auto;"><div style="margin-left: -50%;"><h3 class="basictext">Back</h3></div></a>
    <a style="position:relative; float:right"><h3 class="basictext">Next Version: TBD</h3></a>

</div>
<?php include "../global/end.php"?>
</html>
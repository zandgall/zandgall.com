<!DOCTYPE html>
<html lang="en">
<?php 
$pagetitle = "Zandgall - Arvopia 0.4";
$pagedesc = "All about Arvopia version 0.4";
include "../global/header.php"?>

<?php 
$title = "Arvopia 0.4!";
$subtitle = "The great enlightenment";
include "../global/begin.php"?>

<div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm">
    <!-- Parent has no display style, so give it one here, but with a lower opacity. Not applied to parent so that other children won't have a default opacity of 0.92 -->
    <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div>
    <!--STUFF HERE-->
    <img class="section"src="../assets/arvopia/arvopia0.4.png" style="width:98%; position: relative; left:0.8%; margin-top:1%" alt="Arvopia 0.4 Screenshot">
    <h1 class="basictext">
        Version 0.4
    </h1>

    <h2 class = "basictext">
        Arvopia 0.4 was the biggest release so far, and the first with the name "Arvopia". With big environment changes, and the star of the show, (pun intended) light system with the sun and the moon as well as time.
    </h2>

    <div class="splitter" style="margin-bottom:1cm"></div>
    <img class="section" src="../assets/arvopia/arvopia%200.4/options.png" style="image-rendering: pixelated; width:98%; position: relative; left:0.8%" alt="Options Menu Screenshot">

    <h1 class="basictext">
        GUI Additions
    </h1>

    <h2 class="basictext">
        One of the more important changes was the change and addition in GUIs. An overhauled title screen was introduced, as well as an addition options, instructions, changelog, and world choosing menus.<br><br>
        The options menu had sliders that would change framerate, light quality, time speed, volume, scale, and a toggle button that would make sure sliders worked properly. <br>
        The instructions menu boots up on the first launch of the game, and shows instructions on how each game mechanic works. <br>
        The changelog gives update details about 0.4, and other previous versions.<br>
        And the world chooser menu shows two different worlds, one loads up the classic world in the previous versions, and the second is a plain world with nothing much going on except for the fact that it's very flat. Another feature in the world choosing menu, is an "Open Other" button. This allows you to load in an external world made with the LevelCreator(s) for this version.
    </h2>
    <div class="splitter" style="margin-bottom:1cm"></div>

    <h1 class="basictext">
        Combat
    </h1>

    <h2 class="basictext">
        Combat in this version has evolved from the simple point and click of the last two versions. You need to be withing a certain range of an entity to be able to hit it, and you must hover your mouse closest to whichever entity you want to hit.<br><br>
        You are given 3 choices of weapon/tool. Your fists are the first, the second being a sword that does 3 damange to an entity, and the final is a torch which does 2 damange but creates light during the night. Cannibals now infect the game, as the first hostile entity that tries to kill you and gives you a way to die aside from falling off the edge of the world. Some Cannibals will spawn as "Alpha cannibals" and hold a torch with other cannibals following them.
    </h2>

    <div class="splitter" style="margin-bottom:1cm"></div>
    <img class="section" src="../assets/arvopia/arvopia%200.4/lighting.png" style="width:98%; position: relative; left:0.8%" alt="Lighting Screenshot">

    <h1 class="basictext">
        Lighting system
    </h1>

    <h2 class="basictext">
        As the biggest addition, and main focus of this update, lighting was added to Arvopia 0.4. The sun and the moon are the main light sources, and torches can be used to light up around you as well. Along with the sun and the moon, a time system was introduced to control when each light will appear. Time is shown in the bottom-left corner.<br><br>
        The light system draws as squares with a certain color, and opacity. The size of the squares depend on the value of the light quality set in the options menu. The higher the value, the blockier it looks. The smaller the value, the smoother things blend together.
    </h2>

    <div class="splitter" style="margin-bottom:1cm"></div>

    <h1 class="basictext">
        Soundtrack
    </h1>

    <h2 class="basictext">
        Arvopia 0.4, with all it's graphics and gameplay changes, also added a Sountrack. It featured only 4 songs, but they pack in a lot to the download size. The soundtrack in it's entirety, is available for listening on the <a href="music">music</a> page.
    </h2>

    <a href="../Downloads/Arvopia0.4.zip"><div class="section" style="width:75%; margin-left: auto; margin-right: auto; margin-bottom: 1cm;"><h1 class="basictext outlinetext">Download Arvopia 0.4.zip</h1></div></a>

    <div class="section" style="margin-bottom: 1cm; height: auto;"><h1 class="basictext outlinetext">Note:</h1><h2 class="basictext">When loading a world in 0.4, you will have to open the options menu (this has to be after opening a world, every time you open a world), make sure that FPS is set to 60, and light quality is pretty high (doesn't actually improve overall quality). Otherwise, the game will run very slowly.</h2></div>
    <div class="splitter" style="margin-bottom:1cm;"></div>
    <a href="0.3" style="position:relative; float:left"><h3 class="basictext">Previous Version: 0.3</h3></a>
    <a href="../" style="position:absolute; align-content: center; text-align: center; float: left; left: 50%; margin-left: auto; margin-right: auto"><div style="margin-left: -50%;"><h3 class="basictext">Back</h3></div></a>
    <a href="0.5" style="position:relative; float:right"><h3 class="basictext">Next Version: 0.5</h3></a>

</div>
<?php include "../global/end.php"?>
</html>
<html lang="en">
<?php 
$pagetitle = "Zandgall - Legacy Level Creator Download";
$pagedesc = "An old tool used to make worlds for Arvopia prior to it's built in level-creator";
include "global/header.php"?>

<?php 
$title = "LevelCreator!";
$subtitle = "Before Arvopia 0.7, this is the way to make Arvopia Levels!";
include "global/begin.php"?>

<div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm">
    <!-- Parent has no display style, so give it one here, but with a lower opacity. Not applied to parent so that other children won't have a default opacity of 0.92 -->
    <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div>
    <!--STUFF HERE-->
    <div id="projects;">
        <div class="splitter" style="top: 25px; width: 80%"></div>
        <div style="width:100%; height:875px;float:left;position:relative;"></div>
        <div class="splitter" style="position: relative; top: 875px; width: 80%"></div>
        <a href="/Downloads/LevelCreator0.1.zip"><div class="proj" style="width: 100%; height:200px;float:left;position:absolute; top:50">
            <img class="projimg" src="assets/arvopia/levelcreator0.1.png", style="width:100%; height:inherit; position:absolute; object-fit: cover">
            <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
            <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">LevelCreator 0.1 - Arvopia 0.4</h1>
            <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">Made to make level making easier, released to see what others could create. THIS IS A BROKEN VERSION, it does not save correctly<br>148kb - 4/25/18</h1>
            <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
        </div></a>
        <a href="/Downloads/LevelCreator0.2.zip"><div class="proj" style="width: 100%; height:200px;float:left;position:absolute; top: 250px">
            <img class="projimg" src="assets/arvopia/levelcreator0.2.png", style="width:100%; height:inherit; position:absolute; object-fit: cover">
            <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
            <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">LevelCreator0.2 - Arvopia 0.4</h1>
            <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">Switch between tiling and erasing, a very barebones level making tool. (A fixed version of 0.1)<br>149kb - 4/26/18</h1>
            <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
        </div></a>
        <a href="/Downloads/LevelCreator0.3.zip"><div class="proj" style="width: 100%; height:200px;float:left;position:absolute; top: 450px">
            <img class="projimg" src="assets/arvopia/levelcreator0.3.png", style="width:100%; height:inherit; position:absolute; object-fit: cover">
            <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
            <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">LevelCreator 0.3 - Arvopia 0.5</h1>
            <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">Giving the ability to place entities, as well as some keybinds. +/- to change tiles easily, and some letters to select a tool. (E)raser, (T)ile, Entity : (Q), (H)and, and Remover : (X)<br>330kb - 5/18/18</h1>
            <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
        </div></a>
        <a href="/Downloads/LevelCreator0.4.zip"><div class="proj" style="width: 100%; height:200px;float:left;position:absolute; top: 650px">
            <img class="projimg" src="assets/arvopia/levelcreator0.4.png", style="width:100%; height:inherit; position:absolute; object-fit: cover">
            <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
            <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">LevelCreator 0.4 - Arvopia 0.6</h1>
            <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">Changed GUI, added new entities for 0.6, and a few new tools. (R)ect, and AutoRect : (Shift + R). Side panels for selecting tile quickly, and editing entities easily.<br>375kb - 6/10/19</h1>
            <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
        </div></a>
    </div>
    <h1 class="basictext">If you want to make levels for a modern version of Arvopia, check out Arvopia 0.7. Otherwise, you're in the right place!</h1>

</div>
<?php include "global/end.php"?>
</html>
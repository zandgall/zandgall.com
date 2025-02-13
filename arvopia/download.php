<!DOCTYPE html>
<html lang="en">
<?php 
$pagetitle = "Zandgall - Arvopia Downloads";
$pagedesc = "Direct download links for Arvopia versions 0.1-0.7";
include "../global/header.php"?>

<?php 
$title = "Download Arvopia!";
$subtitle = "Only some of them are horrendously broken";
include "../global/begin.php";
include "../global/projectGenerator.php";?>

<div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm">
    <!-- Parent has no display style, so give it one here, but with a lower opacity. Not applied to parent so that other children won't have a default opacity of 0.92 -->
    <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div>
    <!--STUFF HERE-->
    <div id="projects">
    <?php 
    project("33.33%", "200px", "Arvopia 0.1", "Basic physics, butterflies, bees, flowers, rocks, and basic grass and tree. Started in November of 2017<br>60kb - 3/2/18",
            "../assets/arvopia/arvopia0.1.png", "../Downloads/Platformer.zip");
    project("33.33%", "200px", "Arvopia 0.2", "Pathes the way to the future, adding foxes, clouds, particles, a gui, and bridges. Lags every 2 seconds.<br>88kb - 3/6/18",
            "../assets/arvopia/arvopia0.2.png", "../Downloads/Platformer0.2.zip");
    project("33.33%", "200px", "Arvopia 0.3", "Changing the world, reduced lag, imrpoved particles and foxes, and added bridges as well as combat.<br>101kb - 3/16/18",
            "../assets/arvopia/arvopia0.3.png", "../Downloads/Platformer0.3.zip");
    project("33.33%", "200px", "Arvopia 0.4", "With enviornments, cannibals, weapons. This is also the first version called \"Arvopia\". Skies and lighting included, a full menu with an additional world, as well as soundtrack.<br>34mb - 4/20/18",
            "../assets/arvopia/arvopia0.4.png", "../Downloads/Arvopia0.4.zip");
    project("33.33%", "200px", "Arvopia 0.5", "Foliage! Works only if you have played 0.4 before launching this version. It adds all sorts of plants, crafting, and sunrised/sunsets. 3rd world<br>122mb - 5/19/18",
            "../assets/arvopia/arvopia0.5.png", "../Downloads/Arvopia0.5.zip");
    project("33.33%", "200px", "Arvopia 0.6", "NPCs with dialogue and houses, tree life-cycles, and some minor details to bring out life in this update. Quests and Achievements. A 4th world, and all reduced to 17mb!<br>17mb - 3/16/18",
            "../assets/arvopia/arvopia0.6.png", "../Downloads/Arvopia0.6.zip");
    project("100%", "200px", "Arvopia 0.7", "Customization of everything! Player designs to gameplay modifications. \"Story Pack\" world option, a level creator, and story scripting ability.<br>34mb - 5/19/18",
            "../assets/arvopia/arvopia0.7.png", "../Downloads/Arvopia0.7.zip");

    ?>
    <!--<div style="width:100%; height:600px;float:left;position:relative;"></div>
    <a href="/Downloads/Platformer.zip"><div class="proj" style="width: 33.33%; height:200px;float:left;position:absolute">
        <img class="projimg" src="assets/arvopia/arvopia0.1.png", style="width:100%; height:inherit; position:absolute; object-fit: cover">
        <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
        <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">Arvopia 0.1</h1>
        <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">Basic physics, butterflies, bees, flowers, rocks, and basic grass and tree. Started in November of 2017<br>60kb - 3/2/18</h1>
        <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
    </div></a>
    <a href="/Downloads/Platformer0.2.zip"><div class="proj" style="width: 33.33%; height:200px;float:left;position:absolute; left: 33.33%">
        <img class="projimg" src="assets/arvopia/arvopia0.2.png", style="width:100%; height:inherit; position:absolute; object-fit: cover">
        <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
        <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">Arvopia 0.2</h1>
        <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">Pathes the way to the future, adding foxes, clouds, particles, a gui, and bridges. Lags every 2 seconds.<br>88kb - 3/6/18</h1>
        <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
    </div></a>
    <a href="/Downloads/Platformer0.3.zip"><div class="proj" style="width: 33.33%; height:200px;float:left;position:absolute; left: 66.66%">
        <img class="projimg" src="assets/arvopia/arvopia0.3.png", style="width:100%; height:inherit; position:absolute; object-fit: cover">
        <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
        <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">Arvopia 0.3</h1>
        <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">Changing the world, reduced lag, imrpoved particles and foxes, and added bridges as well as combat.<br>101kb - 3/16/18</h1>
        <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
    </div></a>

    <a href="/Downloads/Arvopia 0.4.zip"><div class="proj" style="width: 33.33%; height:200px;float:left;position:absolute; top:200px">
        <img class="projimg" src="assets/arvopia/arvopia0.4.png", style="width:100%; height:inherit; position:absolute; object-fit: cover">
        <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
        <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">Arvopia 0.4</h1>
        <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">With enviornments, cannibals, weapons. This is also the first version called "Arvopia". Skies and lighting included, a full menu with an additional world, as well as soundtrack.<br>34mb - 4/20/18</h1>
        <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
    </div></a>
    <a href="/Downloads/Arvopia 0.5.zip"><div class="proj" style="width: 33.33%; height:200px;float:left;position:absolute; left: 33.33%; top:200px">
        <img class="projimg" src="assets/arvopia/arvopia0.5.png", style="width:100%; height:inherit; position:absolute; object-fit: cover">
        <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
        <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">Arvopia 0.5</h1>
        <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">Foliage! Works only if you have played 0.4 before launching this version. It adds all sorts of plants, crafting, and sunrised/sunsets. 3rd world<br>122mb - 5/19/18</h1>
        <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
    </div></a>
    <a href="/Downloads/Arvopia 0.6.zip"><div class="proj" style="width: 33.33%; height:200px;float:left;position:absolute; left: 66.66%; top:200px">
        <img class="projimg" src="assets/arvopia/arvopia0.6.png", style="width:100%; height:inherit; position:absolute; object-fit: cover">
        <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
        <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">Arvopia 0.6</h1>
        <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">NPCs with dialogue and houses, tree life-cycles, and some minor details to bring out life in this update. Quests and Achievements. A 4th world, and all reduced to 17mb!<br>17mb - 3/16/18</h1>
        <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
    </div></a>
    <a href="/Downloads/Arvopia 0.7.zip"><div class="proj" style="width: 100%; height:200px;float:left;position:absolute; top:400px">
        <img class="projimg" src="assets/arvopia/arvopia0.7.png", style="width:100%; height:inherit; position:absolute; object-fit: cover">
        <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
        <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">Arvopia 0.7</h1>
        <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">Customization of everything! Player designs to gameplay modifications. "Story Pack" world option, a level creator, and story scripting ability.<br>34mb - 5/19/18</h1>
        <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
    </div></a>-->
    </div>
    <h1 class = "basictext">Additional Information about each version can be found <a href="arvopia.php">here</a></h1>
</div>
<?php include "../global/end.php"?>
</html>
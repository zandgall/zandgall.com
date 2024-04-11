<div style="position: relative;margin: auto; margin-top:0px; width: 800px; height:0; float: right">

    <!-- The burger itself -->
    <img src="<?php echo $ROOT?>assets/menu.gif" id="menu_toast" style="position: absolute; top:25px; left:600px; opacity: 1.0" alt="Menu >">
    <a href="#" class="burger" onclick="open_menu()" style="display:block"><div id="hamburger" style="width:50px; height:50px; position: absolute; top:25px; left: 725px">
        <div id="top_bun" style="height: 10px; position: relative; border: solid 0px; background-color:#8db6f3; border-radius: 20px"></div>
        <div id="meat" style="height: 10px; position: relative; border: solid 0px; background-color:#8db6f3; margin-top: 10px; border-radius: 20px"></div>
        <div id="bottom_bun" style="height: 10px; position: relative; border: solid 0px; background-color:#8db6f3; margin-top: 10px; border-radius: 20px"></div>
    </div></a>

    <!-- Main menus -->
    <div class="bmenu" style="--bsize: 100; margin-right: -200px; margin-left: -200px;"> 
        <a class = "linkpages" href="#" onclick="menuSelected(0)"><h3 class="basictext btopic">Home</h3></a>
    </div>
    <div class="bmenu" style="--bsize: 410; margin-right: -200px; margin-left: -200px">
        <a class = "linkpages" href="#" onclick="menuSelected(1)"><h3 class="basictext link btopic">Projects</h3></a>
    </div>
    <div class="bmenu" style="--bsize: 100; margin-right: -200px; margin-left: -200px">
        <a class = "linkpages" href="#" onclick="menuSelected(2)"><h3 class="basictext link btopic">Resources</h3></a>
    </div>
    <div class="bmenu" style="--bsize: 100; margin-right: -200px; margin-left: -200px">
        <a class = "linkpages" href="#" onclick="menuSelected(3)"><h3 class="basictext link btopic">Settings</h3></a>
    </div>

    <!-- Main menu separators -->
    <div class="bmenu bline" style="position: absolute; --bindex:0; --bwidth:107; height: 10px"></div>
    <div class="bmenu bline" style="position: absolute; --bindex:0; --bwidth:107;  height: 10px"></div>
    <div class="bmenu bline" style="position: absolute; --bindex:1; --bwidth:150;  height: 10px"></div>
    <div class="bmenu bline" style="position: absolute; --bindex:1; --bwidth:150;  height: 10px"></div>
    <div class="bmenu bline" style="position: absolute; --bindex:2; --bwidth:189;  height: 10px"></div>
    <div class="bmenu bline" style="position: absolute; --bindex:2; --bwidth:189;  height: 10px"></div>
    <div class="bmenu bline" style="position: absolute; --bindex:3; --bwidth:83;  height: 10px; z-index:10"></div> <!-- z changed for style -->
    <div class="bmenu bline" style="position: absolute; --bindex:3; --bwidth:83;  height: 10px"></div>
    <div class="bmenu bline" style="position: absolute; --bindex:4; --bwidth:83;  height: 10px"></div>

    <!-- Home -->
    <div class="bmenu bholder">
        <a class="linkpages" href="<?php echo $ROOT?>"><h3 class="basictext link linkpages">Homepage</h3></a>
        <a class="linkpages" href="<?php echo $ROOT?>about"><h3 class="basictext link linkpages">About</h3></a>
    </div>

    <!-- Projects -->
    <div class="bmenu bholder">
        <a class="linkpages" href="<?php echo $ROOT?>arvopia/"><h3 class="basictext link linkpages">Arvopia</h3></a>
        <a class="linkpages" href="<?php echo $ROOT?>bubblecannons"><h3 class="basictext link linkpages">BubbleCannons</h3></a>
        <a class="linkpages" href="<?php echo $ROOT?>solarglyphs"><h3 class="basictext link linkpages">Solar Glyphs</h3></a>
        <a class="linkpages" href="<?php echo $ROOT?>vectorfield"><h3 class="basictext link linkpages">Vector Field</h3></a>
        <a class="linkpages" href="<?php echo $ROOT?>marbo"><h3 class="basictext link linkpages">Super Marbo</h3></a>
        <a class="linkpages" href="<?php echo $ROOT?>lants"><h3 class="basictext link linkpages">Lants</h3></a>
        <a class="linkpages" href="<?php echo $ROOT?>schute"><h3 class="basictext link linkpages">Schute!</h3></a>
        <a class="linkpages" href="<?php echo $ROOT?>fallingmine"><h3 class="basictext link linkpages">Falling Mine</h3></a>
        <a class="linkpages" href="<?php echo $ROOT?>mapdecoder"><h3 class="basictext link linkpages">Map decoder </h3></a>
        <a class="linkpages" href="<?php echo $ROOT?>normalbuddy"><h3 class="basictext link linkpages">Normal Buddy</h3></a>
        <a class="linkpages" href="<?php echo $ROOT?>arvopia/misctools"><h3 class="basictext link linkpages">Misc Arvopia Tools</h3></a>
    </div>

    <!-- Resources -->
    <div class="bmenu bholder">
        <a class="linkpages" href="<?php echo $ROOT?>funstuff"><h3 class="basictext link linkpages">Fun stuff</h3></a>
        <a class="linkpages" href="<?php echo $ROOT?>download"><h3 class="basictext link linkpages">Project Downloads</h3></a>
        <a class="linkpages" href="<?php echo $ROOT?>arvopia/download"><h3 class="basictext link linkpages">Arvopia Downloads</h3></a>
        <a class="linkpages" href="<?php echo $ROOT?>arvopia/betas"><h3 class="basictext link linkpages">Beta Downloads</h3></a>
        <a class="linkpages" href="<?php echo $ROOT?>music"><h3 class="basictext link linkpages">Music</h3></a>
    </div>

    <!-- Misc -->
    <div class="bmenu bholder">
        <a class="linkpages" href="#" onclick="kill_clouds()"><h3 class="basictext link linkpages">Toggle Clouds</h3></a>
        <a class="linkpages" href="#" onclick="kill_layers()"><h3 class="basictext link linkpages">Toggle Layers</h3></a>
        <a class="linkpages" href="#" onclick="kill_stars()"><h3 class="basictext link linkpages">Toggle Stars</h3></a>
        <a class="linkpages" href="<?php echo $ROOT?>arvopia/levelcreator"><h3 class="basictext link linkpages">Arvopia Level Creator</h3></a>
        <a class="linkpages" href="<?php echo $ROOT?>arvopia/levelcreatordownload"><h3 class="basictext link linkpages">ALC Download</h3></a>
    </div>
</div>
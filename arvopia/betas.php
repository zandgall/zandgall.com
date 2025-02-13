<!DOCTYPE html>
<html lang="en">
<?php 
$pagetitle = "Zandgall - Arvopia Beta Downloads";
$pagedesc = "Download links for beta versions of Arvopia updates";
include "../global/header.php"?>

<?php 
$title = "Grab a prerelease!";
$subtitle = "Fry your computer!";
include "../global/begin.php";
include "../global/projectGenerator.php"?>

<div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm">
    <!-- Parent has no display style, so give it one here, but with a lower opacity. Not applied to parent so that other children won't have a default opacity of 0.92 -->
    <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div>
    <!--STUFF HERE-->
    <div class="splitter" style="top: 25px; width: 80%"></div>
    <h1 class="basictext" style="margin-top:50px">Arvopia 0.8</h1>
    <h3 class="basictext">This may be all you're getting with Arvopia 0.8. Arvopia will be ported over to c++ to be rewritten and redesigned.</h3>
    <div id="0.8" style="position:relative; height:675px;">
        <div class="splitter" style="top: 25px; width: 80%"></div>
        <?php 
        project("100%", "200px", "Arvopia 0.8 Beta 3", "Released during a break of Arvopia, development will continue after porting to c++. Contains a newer set of sprites than previous betas, as well as some unknown bug fixes.<br>164mb - 3/31/21",
                "../assets/arvopia/arvopia0.8.1.png", "../Downloads/Arvopia%200.8%20beta%203.zip");
        project("100%", "200px", "Arvopia 0.8 Beta 2", "For some reason, contains two different versions of the game. The jarfile and executable have different contents, the most notable being that the jarfile contains a mockup of a new tree sprite.<br>192mb - 4/24/20",
                "../assets/arvopia/arvopia0.8.1.png", "../Downloads/Arvopia%200.8%20beta%202.zip");
        project("100%", "200px", "Arvopia 0.8 Beta 1", "Unknown differences from beta 2, likely a bug fix or rather fixing geinerally broken contents.<br>192mb - 4/24/21",
                "../assets/arvopia/arvopia0.8.1.png", "../Downloads/Arvopia%200.8%20beta%201.zip");
        ?>
    </div>
    <h1 class="basictext">Arvopia 0.7</h1>
    <h3 class="basictext">It is likely that neither of these work, beta 2 does not run on my machine and beta 1 gets stuck attempting to write a custom audio format that I decided to scrap soon after. Rather, they are here for documentation and archival purposes.</h3>
    <div id="0.7" style="position:relative; height: 475px">
        <div class="splitter" style="top: 25px; width: 80%"></div>
        <?php
        project("100%", "200px", "Arvopia 0.7 Beta 2", "Removed 'custom audio format' attempt.<br>35mb - 2/8/19",
                "../assets/arvopia/arvopia%200.7/Animals.png", "../Downloads/Arvopia%200.7%20beta%202.zip");
        project("100%", "200px", "Arvopia 0.7 Beta 1", "Despite not running, shows the ideas and progress of this beta through the files, in the fonts folder there is a copy of some resources, including a folder that shows an attempt at creating \"subworlds\", world files that can be accessed from a certain region in a parent world. Like going down a pipe in Super Mario Bros.<br>33mb - 1/2/19",
                "../assets/arvopia/arvopia%200.7/Animals.png", "../Downloads/Arvopia%200.7%20beta%201.zip");
        ?>
    </div>

    <h1 class="basictext">Arvopia 0.6</h1>
    <h3 class="basictext">As Arvopia 0.6 evolved, you could see the development of NPCs and other 0.6 features.</h3>
    <div id="0.6" style="position:relative; height: 900px">
        <div class="splitter" style="top: 25px; width: 80%"></div>
        <?php 
        project("100%", "200px", "Arvopia 0.6 Beta 4", "Switched out .wav for .ogg, introduced 'smooth' buttons.<br>17mb - 11/10/18",
                "../assets/arvopia/0.6.1img.png", "../Downloads/Arvopia%200.6%20beta%204.zip");
        project("100%", "200px", "Arvopia 0.6 Beta 3", "Runs successfully, shows an early implementation of background layers.<br>179mb - 9/5/18",
                "../assets/arvopia/0.6.1img.png", "../Downloads/Arvopia%200.6%20beta%203.zip");
        project("100%", "200px", "Arvopia 0.6 Beta 2", "Runs successfully, allows you to explore a 0.5 feeling world with early NPCs hanging around.<br>179mb - 8/16/18",
                "../assets/arvopia/0.6.1img.png", "../Downloads/Arvopia%200.6%20beta%202.zip");
        project("100%", "200px", "Arvopia 0.6 Beta 1", "Runs until loaded up a world, then only a blank screen is shown.<br>178mb - 7/30/18",
                "../assets/arvopia/0.6.1img.png", "../Downloads/Arvopia%200.6%20beta%201.zip");        
        ?>
    </div>


</div>
<?php include "../global/end.php"?>
</html>


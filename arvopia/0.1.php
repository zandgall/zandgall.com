<!DOCTYPE html>
<html lang="en">
<?php 
$pagetitle = "Zandgall - Arvopia 0.1";
$pagedesc = "All about Arvopia Version 0.1, by Zandgall";
include "../global/header.php"?>

<?php 
$title = "Arvopia 0.1!";
$subtitle = "The Stone Age of Arvopia!";
include "../global/begin.php"?>

<div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm">
    <!-- Parent has no display style, so give it one here, but with a lower opacity. Not applied to parent so that other children won't have a default opacity of 0.92 -->
    <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div>
    <!--STUFF HERE-->
    <img class="section"src="../assets/arvopia/arvopia0.1.png" style="width:98%; position: relative; left:0.8%; margin-top:1%" alt="Arvopia 0.1 Screenshot">
    <h1 class="basictext">
        Version 0.1
    </h1>

    <h2 class = "basictext">Started back in November of 2017, Arvopia started under the name, "Platformer". I was making it while following a tutorial online of how to make a video game in Java, which I stopped following after releasing this version.</h2>

    <h2 class="basictext">
        Arvopia 0.1 was then compiled, and released on March 2nd, 2018 so that I could show my friends. I ended up starting a YouTube series on it, (which got discontinued) and let anyone download it from that video's description.
    </h2>

    <div class="splitter" style="margin-bottom:1cm"></div>
    <img class="section" src="../assets/arvopia/arvopia%200.1/wallclipbug.png" style="width:98%; position: relative; left:0.8%" alt="Arvopia 0.1 Wall Clip Bug Screenshot">
    <h2 class="basictext">
        As it was the first version, and I was a new programmer to Java, this release came with a few bugs. One that came and stayed until release 0.4, was a jumping glitch that prevented the player from jumping full height if they didn't wait on the ground for more than a frame.
    </h2>

    <h2 class="basictext">
        I enjoyed making "Platformer" enough that I decided to continue working on it. I took suggestions from friends and siblings to see what I should add to the game for my second release.
    </h2>

    <a href="../Downloads/Platformer.zip"><div class="section" style="width:75%; margin-left: auto; margin-right: auto; margin-bottom: 1cm;"><h1 class="basictext outlinetext">Download Arvopia 0.1.zip</h1></div></a>
    <div class="splitter" style="margin-bottom:1cm;"></div>
    <a href="../" style="position:relative; float:left"><h3 class="basictext">Back</h3></a>
    <a href="0.2" style="position:relative; float:right"><h3 class="basictext">Next Version: 0.2</h3></a>
</div>

<?php include "../global/end.php"?>
</html>
<html lang="en">
<?php 
$pagetitle = "Zandgall - Falling Mine";
$pagedesc = "All about the March 2019 ScoreSpace Game Jam submission: Falling Mine";
include "global/header.php"?>

<?php 
$title = "Falling Mine!";
$subtitle = "For the March 2019 ScoreSpace Game Jam";
include "global/begin.php"?>

<div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm">
    <!-- Parent has no display style, so give it one here, but with a lower opacity. Not applied to parent so that other children won't have a default opacity of 0.92 -->
    <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div>
    <!--STUFF HERE-->
    <h1 class="basictext">Falling Mine</h1>

    <h2 class="basictext">
        The ScoreSpace Game Jam for March was the first time I had heard of ScoreSpace. The goal was to make a video game within 72 hours, and submit it for Streamers to get top highscores in the top rated games.<br><br>
        As this was my first Game Jam in general, of course my submission wasn't the best. It was a simple game, where you just keep jumping until you die. Similar to Doodle Jump a little bit. However with the constrained time, and limited knowlege, it didn't turn out too well. Platforms would spawn off screen, or too high. And there would be just impossible spike obstacles.<br><br>
        However it works, and I think it's still fun enough to have been made.
    </h2>
    <img class = "section" src="assets/thumbnail/FallingMineThumb.png" style="width: 98%; margin-left: 1%">
    <a href="Downloads/Fallen Mine.zip"><div class="section" style="width:75%; margin-left: auto; margin-right: auto; margin-bottom: 20;"><h1 class="basictext outlinetext">Fallen Mine.zip - 3.4MB</h1></div></a>
    <a href="index"><div class="section" style="width:25%; margin-left: auto; margin-right: auto; margin-bottom: 20;"><h1 class="basictext outlinetext">Home</h1></div></a>
</div>
<?php include "global/end.php"?>
</html>
<html lang="en">
    <?php 
$pagetitle = "Zandgall - Teasers";
$pagedesc = "Sneak peaks at upcoming projects or updates";
include "global/header.php"?>

<?php 
$title = "The future!";
$subtitle = "What's coming? You'll see here";
include "global/begin.php"?>

<div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm">
    <!-- Parent has no display style, so give it one here, but with a lower opacity. Not applied to parent so that other children won't have a default opacity of 0.92 -->
    <!-- <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div> -->
    <!--STUFF HERE-->
    <h2 class="basictext" style="margin-left: 20; margin-bottom: 0; font-family: sans-serif; font-weight: bold; position: relative;">Look into the future!</h2>
            
    <img class = "section" style="display: block; margin-top: 20; margin-left: -10%; float: center; position: relative; width: 120%; image-rendering: pixelated;" src="assets/solarglyphs/teaser.png">

    <img class = "section" style="display: block; margin-top: 20;  width:auto; height:auto; margin-left: auto; margin-right: auto; position: relative; text-align: center;" src="assets/arvopia/newstill.gif" alt="0.8 Movement" width = 108>
    
    <div class="section" style="margin-top: 20; text-align: center; width:auto; height:auto; margin-left: auto; margin-right: auto;">
        <h1 class="basictext">Birds!</h1>
        <video class="section" width="720" height="405" style="margin-bottom: 10" alt="Birds!" controls>
            <source src="assets/videos/birds.mp4" type="video/mp4">
            Your browser doesn't support videos
        </video>
    </div>
    <div class="section" style="margin-top: 20; width:auto; height:auto; margin-left: auto; margin-right: auto; text-align: center;">
        <h1 class="basictext">Improved Birds! (+Sound)</h1>
        <video class="section" width="720" height="405" style="margin-bottom: 10" alt="Better Birds!" controls>
            <source src="assets/videos/birdsnew.mp4" type="video/mp4">
            I already said your browser doesn't support videos
        </video>
    </div>
    <div class="section" style="margin-top: 20; text-align: center; width:auto; height:auto; margin-left: auto; margin-right: auto;">
        <h1 class="basictext">Better Lights!</h1>
        <video class="section" width="720" height="405" style="margin-bottom: 10" alt="Lights!" controls>
            <source src="assets/videos/reworkedlightsystem.mp4" type="video/mp4">
            Can you guess what your browser doesn't support?
        </video>
    </div>

</div>
<?php include "global/end.php"?>
</html>
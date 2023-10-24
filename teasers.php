<!DOCTYPE html>
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
    <!--STUFF HERE-->
    <h2 class="basictext" style="margin-left: 20px; margin-bottom: 0; font-family: sans-serif; font-weight: bold; position: relative;">Look into the future!</h2>
            
    <img class = "section" style="display: block; margin-top: 20px; margin-left: -10%; position: relative; width: 120%; image-rendering: pixelated;" src="assets/solarglyphs/teaser.png" alt="Solar Glyphs Teaser">

    <img class = "section" style="display: block; margin-top: 20px;  width:auto; height:auto; margin-left: auto; margin-right: auto; position: relative; text-align: center;" src="assets/arvopia/newstill.gif" alt="0.8 Movement" width = 108>
    
    <div class="section" style="margin-top: 20px; text-align: center; width:auto; height:auto; margin-left: auto; margin-right: auto;">
        <h1 class="basictext">Birds!</h1>
        <video class="section" width="720" height="405" style="margin-bottom: 10px" controls>
            <source src="assets/videos/birds.mp4" type="video/mp4">
            Your browser doesn't support videos
        </video>
    </div>
    <div class="section" style="margin-top: 20px; width:auto; height:auto; margin-left: auto; margin-right: auto; text-align: center;">
        <h1 class="basictext">Improved Birds! (+Sound)</h1>
        <video class="section" width="720" height="405" style="margin-bottom: 10px" controls>
            <source src="assets/videos/birdsnew.mp4" type="video/mp4">
            I already said your browser doesn't support videos
        </video>
    </div>
    <div class="section" style="margin-top: 20px; text-align: center; width:auto; height:auto; margin-left: auto; margin-right: auto;">
        <h1 class="basictext">Better Lights!</h1>
        <video class="section" width="720" height="405" style="margin-bottom: 10px" controls>
            <source src="assets/videos/reworkedlightsystem.mp4" type="video/mp4">
            Can you guess what your browser doesn't support?
        </video>
    </div>

</div>
<?php include "global/end.php"?>
</html>
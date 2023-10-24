
<!DOCTYPE html>
<html lang="en">
    <?php 
    $pagetitle = "Zandgall - Starfield";
    $pagedesc = "Information about Starfield, the predecessor to Solar Glyphs!";
include "global/header.php"?>

<?php 
$title = "Starfield!";
$subtitle = "Predecessor of <a href=\"solarglyphs\">SolarGlyphs!</a>";
include "global/begin.php"?>

<!-- <div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm"> -->
    <!-- Parent has no display style, so give it one here, but with a lower opacity. Not applied to parent so that other children won't have a default opacity of 0.92 -->
    <!-- <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div> -->
    <!--STUFF HERE-->
<div style="margin:auto; width:766px">
    <canvas class="section" id="Canvas" width=766 height=766 style="position:relative; margin: auto; margin-top:100px; margin-bottom: 100px; width:766px; height:766px">CANVAS NOT SUPPORTED</canvas>
</div>

<script src="Funsies/Starfield/starfield.js"></script>
<!-- </div> -->
<?php include "global/end.php"?>
</html>
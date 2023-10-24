<html lang="en">
    <?php 
$pagetitle = "Nat Gall - Cannon Defense";
$pagedesc = "A top down shooter inspired by BubbleCannons and Toy Defense";
include "global/header.php"?>

<script src="funsies/p5/p5.min.js"></script>
<?php 
$title = "Cannon Defense!";
$subtitle = "Created by 9yo Nathaniel Gall";
include "global/begin.php"?>

<!-- <div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm"> -->
    <!-- Parent has no display style, so give it one here, but with a lower opacity. Not applied to parent so that other children won't have a default opacity of 0.92 -->
    <!-- <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div> -->
    <!--STUFF HERE-->
    <div id="canvasDiv" class="section" height=850 width=750 style="z-index: 10; position: relative; margin:auto; margin-top: 0; margin-bottom:2cm; width:850; height:750;" ></div>
        <script src="nat/game 1/sketch.js"></script>
    </div>
<!-- </div> -->
<?php include "global/end.php"?>
</html>
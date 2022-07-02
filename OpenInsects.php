<html lang="en">
    <?php 
$pagetitle = "Zandgall - OpenInsects";
$pagedesc = "A simple simulation of insects crawling around the page";
include "global/header.php"?>

<script src="Funsies/OpenInsects/insect.js"></script>
<body>
    <canvas id="Canvas" class="bg" style="z-index: 1; pointer-events: none">Canvas is not supported</canvas>

<?php 
$title = "Insects!";
$subtitle = "One of 5 differents types, keep refreshing for new ones!";
include "global/begin.php"?>

<!-- <div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm"> -->
    <!-- Parent has no display style, so give it one here, but with a lower opacity. Not applied to parent so that other children won't have a default opacity of 0.92 -->
    <!-- <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div> -->
    <!--STUFF HERE-->
<script src="Funsies/OpenInsects/openinsects.js"></script>
        
<!-- </div> -->
<?php include "global/end.php"?>
</html>
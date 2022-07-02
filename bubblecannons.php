<!-- 
<html lang="en">
    <?php 
// $pagetitle = "Zandgall - BubbleCannons";
// $pagedesc = "A tower-defense-esque top down shooter";
// include "global/head_.php"?>

<body>
    <?php 
    // $title = "BubbleCannons!";
    // $subtitle = "An actual funsie on this site";
    // include "global/head.php"?>
        <div class="parallax" style="height:930px; overflow:hidden;">
            <!-- <div class="section" style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: 800">
                
                <!--STUFF HERE
                

            </div>
        
            <!-- </div>
        </div>
    </div>
    
</body>
</html> -->


<html lang="en">
    <?php 
$pagetitle = "Zandgall - BubbleCannons";
$pagedesc = "A tower-defense-esque top down shooter";
include "global/header.php"?>

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->
<script src="Funsies/BubbleCannons/input.js"></script>
<script src="Funsies/BubbleCannons/bubblebullets.js"></script>
<script src="Funsies/BubbleCannons/bubblemenu.js"></script>
<script src="Funsies/BubbleCannons/bubblepath.js"></script>
<script src="Funsies/BubbleCannons/bubbleenemy.js"></script>
<script src="Funsies/BubbleCannons/bubbleplayer.js"></script>

<?php 
$title = "BubbleCannons!";
$subtitle = "An actual funsie on this site?";
include "global/begin.php"?>

<div height=800 style="margin:auto; margin-top: 0; width:800; height:800">
    <canvas class="section" id="Canvas" width=800 height=800 style="position:relative; margin: auto; margin-top:0; margin-bottom: -4; width:800; height:800">CANVAS NOT SUPPORTED</canvas>
    <div id="upgrade" width=200 height=800 style="width:200; height: 800; float: right; position:relative; margin-top: -800; margin-bottom: 100; left: 216px;">
        <img src="Funsies/BubbleCannons/upgrademenubg.png" id="begin" style="object-fit: cover; position: absolute;">
    </div>
</div>

<a href="javascript:if(!playing) {iterate(); playing = true; increment = -1;}" style="text-decoration: none; margin: auto; position:relative;">
    <div width=400 height=100 style="width:400; height:100; position:relative; margin: auto; margin-top: 10;">
        <img src="Funsies/BubbleCannons/next round.png" style="object-fit: cover; position: absolute;">
    </div>
</a>
<canvas id="utilcan" style="display:none">

<script type="text/javascript" src="Funsies/BubbleCannons/bubblecannons.js">
    console.log("THIS IS THE BEGINNING");
    
    // e();
    // init();
    // draw();
</script>
<!-- <div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm"> -->
    <!-- Parent has no display style, so give it one here, but with a lower opacity. Not applied to parent so that other children won't have a default opacity of 0.92 -->
    <!-- <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div> -->
    <!--STUFF HERE-->

<!-- </div> -->
<?php include "global/end.php"?>
</html>
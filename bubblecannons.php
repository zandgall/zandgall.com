<!DOCTYPE html>
<html lang="en">
    <?php 
$pagetitle = "Zandgall - BubbleCannons";
$pagedesc = "A tower-defense-esque top down shooter";
include "global/header.php"?>

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

<div style="margin:auto; margin-top: 0; width:800px; height:800px">
    <canvas class="section" id="Canvas" width=800 height=800 style="position:relative; margin: auto; margin-top:0; margin-bottom: -4px; width:800px; height:800px">CANVAS NOT SUPPORTED</canvas>
    <div id="upgrade" style="width:200px; height: 800px; float: right; position:relative; margin-top: -800px; margin-bottom: 100px; left: 216px;">
        <img src="Funsies/BubbleCannons/upgrademenubg.png" id="begin" style="object-fit: cover; position: absolute;" alt="Upgrade">
    </div>
</div>

<a href="javascript:next_round()" style="text-decoration: none; margin: auto; position:relative;">
    <div style="width:400px; height:100px; position:relative; margin: auto; margin-top: 1cm;">
        <img src="Funsies/BubbleCannons/next%20round.png" style="object-fit: cover; position: absolute;" alt="Next Round!">
    </div>
</a>
<canvas id="utilcan" style="display:none"></canvas>

<script src="Funsies/BubbleCannons/bubblecannons.js"></script>

<?php include "global/end.php"?>
</html>
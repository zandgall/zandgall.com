<!DOCTYPE html>
<html lang="en">
    <?php 
$pagetitle = "Zandgall - Fire";
$pagedesc = "A (REALLY) simple fire sim";
include "global/header.php"?>
<script src="Funsies/NOISE/PATH.js"></script>

<?php 
$title = "Fire!";
$subtitle = "So bad I feel cold";
include "global/begin.php"?>
<div style="margin:auto; width: 766px; height: 60px">
    <canvas class="section" id="Perlin" width=200 height=200 style="position:relative; margin: auto; margin-top:100px; margin-bottom: 100px; width:800px; height:800px;">CANVAS NOT SUPPORTED</canvas> 
</div>

<script src="Funsies/NOISE/fire.js"></script>
<?php include "global/end.php"?>
</html>
<!DOCTYPE html>
<html lang="en">
<?php 
$pagetitle = "Zandgall - Flowfield";
$pagedesc = "A particle vector-field simulation";
include "global/header.php"?>

<script src="Funsies/NOISE/PATH.js"></script>

<?php 
$title = "Flowfield!";
$subtitle = "A predecessor to <a href=\"vectorfield\">Vector Field!</a>";
include "global/begin.php"?>

<div style="margin:auto; width: 766px; height: 60px"> 
    <canvas class="section" id="Perlin" width=766 height=766 style="position:relative; margin: auto; margin-top:100px; margin-bottom: 100px; width:766px; height:766px">CANVAS NOT SUPPORTED</canvas>
</div>

<script src="Funsies/NOISE/flowfield.js"></script>

<?php include "global/end.php"?>
</html>
<html lang="en">
    <?php 
$pagetitle = "Zandgall - Fire";
$pagedesc = "A (REALLY) simple fire sim";
include "global/header.php"?>
<script src="funsies/NOISE/PATH.js"></script>

<?php 
$title = "Fire!";
$subtitle = "So bad I feel cold";
include "global/begin.php"?>
<div style="margin:auto; width: 766; height: 60">
    <canvas class="section" id="Perlin" width=200 height=200 style="position:relative; margin: auto; margin-top:100; margin-bottom: 100; width:800; height:800;">CANVAS NOT SUPPORTED</canvas> 
</div>

<script type="text/javascript" src="Funsies/NOISE/fire.js"></script>
<?php include "global/end.php"?>
</html>
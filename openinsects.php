<!DOCTYPE html>
<html lang="en">
    <?php 
$pagetitle = "Zandgall - OpenInsects";
$pagedesc = "A simple simulation of insects crawling around the page";
include "global/header.php"?>

<script src="Funsies/OpenInsects/insect.js"></script>

<?php 
$title = "Insects!";
$subtitle = "One of 5 differents types, keep refreshing for new ones!";
include "global/begin.php"?>

<canvas id="Canvas" class="bg" style="z-index: 1; pointer-events: none">Canvas is not supported</canvas>
<script src="Funsies/OpenInsects/openinsects.js"></script>

<?php include "global/end.php"?>
</html>
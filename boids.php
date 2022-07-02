<html lang="en">
    <?php 
$pagetitle = "Zandgall - Boids";
$pagedesc = "See a classic boids simulation";
include "global/header.php"?>

<script src="Funsies/victor.js"></script>
<script src="Funsies/boids/boid.js"></script>
<body>
    <canvas id="Canvas" class="bg" style="z-index: 1; pointer-events: none">Canvas is not supported</canvas>

<?php 
$title = "Boids!";
$subtitle = "A classic Bird-Object Simulation!";
include "global/begin.php"?>

<script src="Funsies/boids/main.js"></script>

<?php include "global/end.php"?>
</html>
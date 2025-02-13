<!DOCTYPE html>
<html lang="en">
<?php 
$pagetitle = "Zandgall - Map Decoder";
$pagedesc = "Information about an old tool that can be used to import and export Minecraft Maps and Png images.";
include "global/header.php"?>

<?php 
$title = "MapDecoder!";
$subtitle = "A heavily outdated tool that can load and create Images and Minecraft map files.";
include "global/begin.php"?>

<div class="section" style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm; padding-bottom: 1cm">
    <!--STUFF HERE-->
    <h1 class="basictext">Map Decoder</h1>

    <h2 class="basictext">The Map Decoder was a small side project, to import and export .dat Minecraft maps and PNGs. It's main usage, is taking an image, and resizing and converting the colors to colors used by Minecraft maps. Then, it is written to NBT and can be used in any Minecraft world. There's not much to the program other than the code behind it, using a library to write the NBT, and filtering colors based on which color is closest in "distance". Where, RGB would be XYZ and it checks differences between "Points"</h2>
    <img class = "section" src="assets/thumbnail/MapCoder.png" style="width: 98%; margin-left: 1%" alt="Map Decoder Thumbnail">
    <a href="Downloads/MapCoder%20-%20BETA0.1.zip"><div class="section" style="width:75%; margin-left: auto; margin-right: auto; margin-bottom: 1cm; margin-top:1cm"><h1 class="basictext outlinetext">MapCoder - BETA0.1.zip - 83KB</h1></div></a>
    <a href="index"><div class="section" style="width:25%; margin-left: auto; margin-right: auto;"><h1 class="basictext outlinetext">Home</h1></div></a>

</div>
<?php include "global/end.php"?>
</html>
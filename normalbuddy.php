<html lang="en">
<?php 
$pagetitle = "Zandgall - Normal Buddy";
$pagedesc = "A tool used to create a normal map based on edges in an image.";
include "global/header.php"?>

<?php 
$title = "Normal Buddy!";
$subtitle = "Liking the PBR sandwich";
include "global/begin.php"?>

<div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm">
    <!-- Parent has no display style, so give it one here, but with a lower opacity. Not applied to parent so that other children won't have a default opacity of 0.92 -->
    <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div>
    <!--STUFF HERE-->
    <h1 class="basictext">Normal Buddy</h1>
    <h2 class="basictext">This tool creates a Normal map based on a height map, or diffuse map. It tries to guess based on the darker and light spots of an image. This "Normal Map" is used in 3d Programs in order to create faked lighting.</h2>
    <img class = "section" src="assets/thumbnail/NormalBuddyThumb.png" style="width: 98%; margin-left: 1%">
    <a href="Downloads/Normal Buddy.zip"><div class="section" style="width:75%; margin-left: auto; margin-right: auto; margin-bottom: 20;"><h1 class="basictext outlinetext">Normal Buddy.zip - 38KB</h1></div></a>
    <a href="index"><div class="section" style="width:25%; margin-left: auto; margin-right: auto; margin-bottom: 20;"><h1 class="basictext outlinetext">Home</h1></div></a>

</div>
<?php include "global/end.php"?>
</html>
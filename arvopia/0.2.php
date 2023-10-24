<!DOCTYPE html>
<html lang="en">
<?php 
$pagetitle = "Zandgall - Arvopia 0.2";
$pagedesc = "All about Arvopia version 0.2";
include "../global/header.php"?>

<?php 
$title = "Arvopia 0.2!";
$subtitle = "Bridges and foxes with a side o' lag";
include "../global/begin.php"?>

<div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm">
    <!-- Parent has no display style, so give it one here, but with a lower opacity. Not applied to parent so that other children won't have a default opacity of 0.92 -->
    <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div>
    <!--STUFF HERE-->
    <img class="section"src="../assets/arvopia/arvopia0.2.png" style="width:98%; position: relative; left:0.8%; margin-top:1%" alt="Arvopia 0.2 Screenshot">
    <h1 class="basictext">
        Version 0.2
    </h1>

    <h2 class = "basictext">Released 4 days after 0.1, "Platformer 0.2" had not added too much in content. Bridges and foxes are the most noticeable difference, however items, clouds, and particles were included.</h2>

    <h2 class="basictext">
        Like 0.1, bugs were prevalent in Arvopia 0.2. The jumping bug that prevented players from jumping full height was still in the game. But more notably, there would be a lag spike everytime a fox, or group of foxes, were spawned.
    </h2>

    <div class="splitter" style="margin-bottom:1cm"></div>
    <img class="section" src="../assets/arvopia/arvopia%200.2/deathfoxes.png" style="width:98%; position: relative; left:0.8%" alt="Broken fox AI Screenshot">
    <h5 class="basictext">(Broken fox ai)</h5>
    <h2 class="basictext">
        Players were able to kill entities in this version. Foxes, bees, and butterflies could be clicked if you managed to click them. And stones and flowers would drop metal and petals that the player could pick up by clicking on them. This would then show on the top of the screen, on a little make-shift GUI that also showed lives.<br><br>
        As mentioned before, bridges and foxes were introduced. The foxes weren't very smart creatures, but they were the first added that didn't have the ability to fly. Aside from foxes, bridges would become an important tile to the game, although in 0.2 they were completely solid, instead of the semi-solid version used today.
    </h2>

    <a href="../Downloads/Platformer0.2.zip"><div class="section" style="width:75%; margin-left: auto; margin-right: auto; margin-bottom: 1cm;"><h1 class="basictext outlinetext">Download Arvopia 0.2.zip</h1></div></a>
    <div class="splitter" style="margin-bottom:1cm;"></div>
    <a href="0.1" style="position:relative; float:left"><h3 class="basictext">Previous Version: 0.1</h3></a>
    <a href="../" style="position:absolute; align-content: center; text-align: center; float: left; left: 50%; margin-left: auto; margin-right: auto"><div style="margin-left: -50%;"><h3 class="basictext">Back</h3></div></a>
    <a href="0.3" style="position:relative; float:right"><h3 class="basictext">Next Version: 0.3</h3></a>

</div>
<?php include "../global/end.php"?>
</html>

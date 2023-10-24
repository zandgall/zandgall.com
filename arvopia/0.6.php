<!DOCTYPE html>
<html lang="en">
<?php 
$pagetitle = "Zandgall - Arvopia 0.6";
$pagedesc = "All about Arvopia version 0.6";
include "../global/header.php"?>

<?php 
$title = "Arvopia 0.6!";
$subtitle = '"Hello, welcome to Arvopia."';
include "../global/begin.php"?>

<div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm">
    <!-- Parent has no display style, so give it one here, but with a lower opacity. Not applied to parent so that other children won't have a default opacity of 0.92 -->
    <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div>
    <!--STUFF HERE-->
    <img class="section"src="../assets/arvopia/arvopia0.6.png" style="width:98%; position: relative; left:0.8%; margin-top:1%" alt="Arvopia 0.6 Screenshot">
    <h1 class="basictext">
        Version 0.6
    </h1>

    <h2 class="basictext">
        Arvopia 0.6 is the first update that specifically gives you something to do. Quests and Achievements are included along with NPCs. Certain NPCs can be interacted with, and give you quests or achievements.
    </h2>

    <div class="splitter" style="margin-bottom:1cm"></div>

    <h1 class="basictext">
        NPCs
    </h1>

    <h2 class = "basictext">
        The Major addition of this update, are NPCs that can be added to worlds. Some that are built in, exist in the first and fourth world. There are 5 of these said NPCs.<br><br>
        Lia, the turorial NPC. Telling you how how to play the game and complete quests. She gives you a starter quest to collect wood for her.<br>
        Frizzy and Fawncier are two village NPCs in World 1 that give you basic collecting quests to create or upgrade houses.<br>
        Two random NPCs in the new World 4, one just asks who you are and that's it, and the other asks for stuff to make a house in the wilderness.
    </h2>

    <div class="splitter" style="margin-bottom:1cm"></div>
    <img class="section" src="../assets/arvopia/arvopia%200.6/environment.png" style="width:98%; position: relative; left:0.8%" alt="Environment Screenshot">

    <h1 class="basictext">
        Environment and time changes
    </h1>

    <h2 class = "basictext">
        Time has been in Arvopia since 0.4, but included in Arvopia 0.6, is a yearly calendar with fall colors and snow and rain. The first months in your world will be fall, where the trees are reddening and the leaves are falling off. Eventually you'll get to winter where the trees get barren and it starts snowing once in a while. When the spring comes around, the trees will grow back their leaves.<br>
        During certain parts of the year, there is a possibility that it will either rain or snow depending on the temperature. 
    </h2>

    <div class="splitter" style="margin-bottom:1cm"></div>

    <h1 class="basictext">
        Smaller changes
    </h1>

    <h2 class = "basictext">
        Crafting was added as well with this version which required more items, in order to making things a little more challenging. A world loading state was implemented as well, to load in external worlds and saves. And as a soundtrack was introduced into Arvopia 0.4, 0.6 added more songs in to fit the weather conditions.
    </h2>

    <a href="../Downloads/Arvopia0.6.zip"><div class="section" style="width:75%; margin-left: auto; margin-right: auto; margin-bottom: 1cm;"><h1 class="basictext outlinetext">Download Arvopia 0.6.zip</h1></div></a>
    <div class="splitter" style="margin-bottom:1cm;"></div>
    <a href="0.5" style="position:relative; float:left"><h3 class="basictext">Previous Version: 0.5</h3></a>
    <a href="../" style="position:absolute; align-content: center; text-align: center; float: left; left: 50%; margin-left: auto; margin-right: auto"><div style="margin-left: -50%;"><h3 class="basictext">Back</h3></div></a>
    <a href="0.7" style="position:relative; float:right"><h3 class="basictext">Next Version: 0.7</h3></a>

</div>
<?php include "../global/end.php"?>
</html>
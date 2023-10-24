<!DOCTYPE html>
<html lang="en">
<?php 
$pagetitle = "Zandgall - Other Projects";
$pagedesc = "Download from an array of other projects I've made";
include "global/header.php"?>

<?php 
$title = "Pick a game!";
$subtitle = "Good luck.";
include "global/begin.php";
include "global/projectGenerator.php"?>

<div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm">
    <!-- Parent has no display style, so give it one here, but with a lower opacity. Not applied to parent so that other children won't have a default opacity of 0.92 -->
    <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div>
    <!--STUFF HERE-->
    <div id="projects">
        <?php 
        project("50%", "200px", "Solar Glyphs 0.1", "Solar system simulation made for a school project. Everything is rendered as Glyphs, and there are just a few planets<br>998KB - 5/6/20",
                "assets/solarglyphs/0.1.png", "Downloads/Solar%20Glyphs%200.1.zip");
        project("50%", "200px", "Solar Glyphs 0.2", "Finished, with many moons added, graphics and performance improved, better gui, and information about every single celestial being that exists (in Solar Glyphs)<br>2MB - 5/19/20",
                "assets/solarglyphs/1.png", "Downloads/Solar%20Glyphs%200.2.zip");
        project("100%", "200px", "Lants", "Cellular Automata Simulation of Langton's Ant<br>1,159kb - 5/22/20",
                "assets/lants/0.png", "Downloads/Lants%20v1.0.0.zip");
        project("100%", "200px", "Vector Fields", "A particle simulation that gives you eye candy. Lots of fun to play around with<br>10mb - 9/6/19",
                "assets/vector%20fields/Title.png", "Downloads/Vector%20Field.zip");
        project("50%", "200px", "Super Marbo 0.1.1", "A basic game of mario, physics are slightly off and there's only two levels. The second of which, is just the first with a different pallete<br>17mb - 10/4/19",
                "assets/super%20marbo/Marbo0.1.1.png", "Downloads/Super%20Marbo%200.1.1.zip");
        project("50%", "200px", "Super Marbo 0.1.2", "All levels from world 1 are present. Still a little off from the original, but it's gotten there better<br>18mb - 10/9/19",
                "assets/super%20marbo/Marbo0.1.2.png", "Downloads/Super%20Marbo%200.1.2.zip");
        project("50%", "200px", "Super Marbo 0.1.3", "All levels from every world. Feels like the actual Super Mario Bros.<br>18mb - 10/20/19",
                "assets/super%20marbo/Marbo0.1.3.png", "Downloads/Super%20Marbo%200.1.3.zip");
        project("50%", "200px", "Super Marbo 0.1.4", "Everything from SMB and more! You can toggle locked screen scrolling, life limit, time limit, and switch to NSMB mode and use multiplayer<br>19mb - 11/15/19",
                "assets/super%20marbo/Marbo0.1.4.png", "Downloads/Super%20Marbo%200.1.4.zip");
        project("50%", "400px", "Schute!", "Made for the Scorespace May Gamejam in 72 hours. You play as a little plant guy who places \"schutes\" to climb to higher places. You're able to place them on the ground, a wall, or even on other vines!<br>5mb - 5/7/19",
                "assets/thumbnail/SchuteThumb.png", "Downloads/Schute!.zip");
        project("50%", "400px", "Fallen Mine", "Made for the Scorespace March Gamejam in 72 hours. A game where you jump from platform to platform to avoid getting burnt. Also with the nice addition of fireballs falling from the cieling<br>4mb - 3/5/19",
                "assets/thumbnail/FallingMineThumb.png", "Downloads/Fallen%20Mine.zip");
        project("50%", "200px", "Map Coder", "Encode and Decode Minecraft Maps from and to PNGs!<br>83kb - 8/18/19",
                "assets/thumbnail/MapCoderThumb.png", "Downloads/MapCoder%20-%20BETA0.1.zip");
        project("50%", "200px", "Normal Buddy", "Make and preview Normal Maps from textures<br>38kb - 4/27/19",
                "assets/thumbnail/NormalBuddyThumb.png", "Downloads/Normal%20Buddy.zip");
        project("50%", "200px", "Arvopia Animator", "Used for making animations for Arvopia 0.8. Can be used in mods, however there is no documentation yet.<br>865kb - 4/27/19",
                "assets/thumbnail/AnimatorThumb.png", "Downloads/Arvopia%20Animator.zip");
        project("50%", "200px", "Trading Design", "Another modding tool to create interective NPCs. NAME will be the player's name, ~end~ ends the conversation, and \"Trader name\" will be the name of the variable, so no characters aside from A-Z and 0-9<br>625kb - 3/12/19",
                "assets/thumbnail/TradingThumb.png", "Downloads/Trading%20Design.zip");
        
        ?>
    </div>
    <h1 class="basictext">If you're looking for more littler projects to play, check out the <a href="funstuff">funsies</a> page</h1>

</div>
<?php include "global/end.php"?>
</html>
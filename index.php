<!DOCTYPE html>
<html lang="en">
<?php 
$pagetitle = "Zandgall - Home";
$pagedesc = "A website dedicated to projects created by Zandgall";
include "global/header.php"?>

<?php 
$title = "Welcome to the site!";
$subtitle = "A resource for Arvopia and other projects";
include "global/begin.php";
include "global/projectGenerator.php";?>
<h1 class="outlinetext basictext" style="width:600px; margin:auto; margin-bottom: 20px">(Website's currently being updated)</h1>
<h1 class="outlinetext basictext" style="margin: auto; margin-bottom: 20px">Project Directory</h1>
    <div class="section" id="projectss" style="position: relative; width:60vw; max-width:900px; height:1350px; margin:auto">
        <?php 
        project("50%", "400px", "NBT Video Essay", "A 20 min video essay explaining the details of the NBT format, how to use it, and comparisons to other general format JSON.",
                "assets/nbtthumb.png", "https://youtu.be/12PAtF2Ih_c");
        project("50%", "400px", "QB64 3D", "A essay sat here on this website explaining the intricacies of 3D graphics, starting from nothing.",
                "assets/qb64%203d/thumb.png", "/qb64%203d");
        project("33.33%", "250px", "Vector Field", "A fully customizable graphic eye-candy using a bunch of particles and the power of \"Vector Fields\"",
                "assets/thumbnail/VectorFieldThumb.png", "vectorfield");
        project("33.33%", "250px", "Super Marbo", "An original title",
                "assets/thumbnail/MarboThumb.png", "marbo");
        project("33.33%", "250px", "Schute!", "A game based on strategically planting \"Schutes\" that you can then climb and use to collect coins and beat levels",
                "assets/thumbnail/SchuteThumb.png", "schute");
        project("33.33%", "200px", "Arvopia", "My old longest standing project. It's a little misc platformer game with NPCs, crafting, and combat", 
                "assets/thumbnail/ArvopiaThumb.png", "arvopia");
        project("33.33%", "200px", "Arvopia Level Creator", "A quick level making tool that was used before Arvopia had it's own levelCreator built in",
                "assets/thumbnail/LevelMakerThumb.png", "arvopialevelcreator");
        project("33.33%", "200px", "Misc Arvopia Tools", "A couple different tools used for development in Arvopia. Animation, Menu designer, and Server testing included.",
                "assets/thumbnail/ArvopiaMiscThumb.png", "arvopia/misctools");
        project("33.33%", "200px", "Normal Buddy", "A small little program that takes an image and makes a NormalMap out of it",
                "assets/thumbnail/NormalBuddyThumb.png", "normalbuddy");
        project("33.33%", "200px", "Map Decoder", "A compact tool for making, saving, and opening Minecraft maps",
                "assets/thumbnail/MapCoderThumb.png", "mapdecoder");
        project("33.33%", "200px", "Falling Mine", "A submission for the ScoreSpace GameJam. Composed of platforms that fall, and you having to jump to live", 
                "assets/thumbnail/FallingMineThumb.png", "fallingmine");
        project("50%", "300px", "Lants", "A small chunk-based simulation of the cellular automata, Langton's Ant",
                "assets/thumbnail/Lants.png", "lants");
        project("50%", "300px", "Solar Glyphs", "A to-scale representation of the Solar System, made for a school project, based on a funsie on this website: Starfield",
                "assets/thumbnail/SolarGlyphs.png", "solarglyphs");
             ?>
    </div>
   
    <div style="width:55vw; max-width:800px; height:780px; margin: 5cm auto 0 auto">
        <iframe style="border-radius:12px;" src="https://open.spotify.com/embed/album/0E6QUnse299lO788TWbE8t?utm_source=generator" 
            width="100%" height="100%" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
    </div>
            
    <div style="width:55vw; max-width: 800px; margin: 5cm auto 0 auto; position: relative">
        <img width="960"
            style="image-rendering: pixelated; width: 120%; margin-top: -10%; margin-left: -10%; margin-bottom: 10%; position: relative"
            src="assets/nbtthumb.png" alt="NBT Video Thumbnail">

        <h1 class="basictext outlinetext" style="font-size: 32pt;">NBT - Lost in the Shadows</h1>
        <h2 class="basictext outlinetext">Video essay on a lesser-known file format, and the general principals of File formats in general!</h2>

        <h3 class="basictext outlinetext">
            We have many different types of files with many different ways to store data. Some types of files try to be very general in the data you can store. One very popular general-data format is "JSON." However, I believe there are alternatives that do a better job of storing data for programs and devices, and one of these types is "NBT."
        </h3>

        <a href="https://youtu.be/12PAtF2Ih_c" style="text-decoration: none; width: 50%; height:90px;  ">
            <div class="section" style="width:30vw; margin: auto; height: 90px; position: relative">
                    <h1 class="basictext" style="text-align:center; margin: auto; margin-top: 30px">Watch video</h1>
            </div>
        </a>
    </div>

    <div class="splitter" style="margin-top: 2cm;"></div>

    <h2 class="basictext">
        <a href="https://twitter.com/zandgall?ref_src=twsrc%5Etfw" class="twitter-follow-button" data-size="large"
            data-show-screen-name="false" data-show-count="false">Follow @zandgall</a>
    </h2>
    <div class="splitter" style="margin-top: 2cm;"></div>
<?php include "global/end.php"?>
</html>
<!-- <!DOCTYPE html> -->
<html lang="en" style="height:100%; width:100%;">
    <head>
    
    <meta charset="utf-8">
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="font-awesome/css/font-awesome.min.css"></script>
    <script src="layers.js" charset="utf-8"></script>
        
    <title>Zandgall - Home</title>
    <meta name="description" content="A website dedicated to Arvopia and other projects and works designed and created by Zandgall">
    <meta name="author" content="Zandgall">
    
    <link rel="icon" href="assets/Icon.png">
    <link rel="apple-touch-icon" href="assets/Icon.png">
    
    <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" type="text/css">
    
    <link rel="stylesheet" charset="utf-8" href="style.css">
    <link rel="stylesheet" charset="utf-8" href="scroll.css">
    <link rel="stylesheet" charset="utf-8" href="global/parallax.css">
</head>

<body data-gr-c-s-loaded="true" style="height:100%; width:100%;">

    <?php 
    $title = "Welcome to the site!";
    $subtitle = "A resource for Arvopia and other projects";
    ?>
    <div id = "cut" style="height: 100vh; width: 100%; top: 0; left: 0; overflow: hidden;">
    <div id="universal" class = "parallax" style="height:100%; width:100%;">
        <?php include "global/head.php"?>

        <div class="section" id = "master" style="margin-left: auto; margin-right: auto; width: 800; position: relative; margin-bottom: 5   0">
            <div id="projects">
                <div style="width:100%; height:800px;float:left;position:relative;"></div>
                <a href="arvopia"><div class="proj" style="width: 33.33%; height:200px;float:left;position:absolute;">
                    <img class="projimg" src="assets/thumbnail/ArvopiaThumb.png" alt="Arvopia" style="width:100%; height:inherit; position:absolute; object-fit: cover">
                    <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
                    <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">Arvopia</h1>
                    <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">Probably what you're here for, my longest standing biggest project</h1>
                    <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
                </div></a>
                <a href="arvopialevelcreator"><div class="proj" style="width: 33.33%; height:200px;float:left;position:absolute;left:33.33%">
                    <img class="projimg" src="assets/thumbnail/LevelMakerThumb.png" alt="Arvopia Level Creator" style="width:100%; height:inherit; position:absolute; object-fit: cover">
                    <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
                    <h1 class="basictext projtitle outlinetext", style="font-size:28; margin-top:0;width:100%; height:inherit; position:absolute;">Arvopia Level Creator</h1>
                    <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">A quick level making tool that was used before Arvopia had it's own levelCreator built in</h1>
                    <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
                </div></a>
                <a href="miscarvopiatools"><div class="proj" style="width: 33.33%; height:200px;float:left;position:absolute;left:66.66%">
                    <img class="projimg" src="assets/thumbnail/ArvopiaMiscThumb.png" alt="Miscellaneous Arvopia Tools" style="width:100%; height:inherit; position:absolute; object-fit: cover">
                    <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
                    <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">Misc Arvopia Tools</h1>
                    <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">A couple different tools used for development in Arvopia. Animation, Menu designer, and Server testing included.</h1>
                    <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
                </div></a>
                <a href="vectorfield"><div class="proj" style="width: 33.33%; height:200px;float:left;position:absolute;top:200px">
                    <img class="projimg" src="assets/thumbnail/VectorFieldThumb.png" alt="Vector Field" style="width:100%; height:inherit; position:absolute; object-fit: cover">
                    <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
                    <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">Vector Field</h1>
                    <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">A fully customizable graphic eye-candy using a bunch of particles and the power of "Vector Fields"</h1>
                    <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
                </div></a>
                <a href="marbo"><div class="proj" style="width: 33.33%; height:200px;float:left;position:absolute;left:33.33%;top:200px;">
                    <img class="projimg" src="assets/thumbnail/MarboThumb.png" alt="Super Marbo" style="width:100%; height:inherit; position:absolute; object-fit: cover">
                    <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
                    <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">Super Marbo</h1>
                    <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">An original title</h1>
                    <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
                </div></a>
                <a href="normalbuddy"><div class="proj" style="width: 33.33%; height:200px;float:left;position:absolute;left:66.66%;top:200px">
                    <img class="projimg" src="assets/thumbnail/NormalBuddyThumb.png" alt="Normal Buddy" style="width:100%; height:inherit; position:absolute; object-fit: cover">
                    <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
                    <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">Normal Buddy</h1>
                    <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">A small little program that takes an image and makes a NormalMap out of it</h1>
                    <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
                </div></a>
                <a href="mapdecoder"><div class="proj" style="width: 33.33%; height:200px;float:left;position:absolute;left:0%;top:400px">
                    <img class="projimg" src="assets/thumbnail/MapCoderThumb.png" alt="Map Decoder" style="width:100%; height:inherit; position:absolute; object-fit: cover">
                    <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
                    <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">Map Decoder</h1>
                    <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">A compact tool for making, saving, and opening Minecraft maps</h1>
                    <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
                </div></a>
                <a href = "fallingmine"><div class="proj" style="width: 33.33%; height:200px;float:left;position:absolute;left:33.33%;top:400px">
                    <img class="projimg" src="assets/thumbnail/FallingMineThumb.png" alt="Falling Mine" style="width:100%; height:inherit; position:absolute; object-fit: cover">
                    <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
                    <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">Falling Mine</h1>
                    <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">A submission for the ScoreSpace GameJam. Composed of platforms that fall and you having to jump to live</h1>
                    <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
                </div></a>
                <a href="schute"><div class="proj" style="width: 33.33%; height:200px;float:left;position:absolute;left:66.66%;top:400px">
                    <img class="projimg" src="assets/thumbnail/SchuteThumb.png" alt="Schute" style="width:100%; height:inherit; position:absolute; object-fit: cover">
                    <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
                    <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">Schute!</h1>
                    <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">A game based on strategically planting "Schutes" that you can then climb and use to collect coins and beat levels</h1>
                    <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
                </div></a>
                <a href="lants"><div class="proj" style="width: 50%; height:200px;float:left;position:absolute;left:0%;top:600px">
                    <img class="projimg" src="assets/thumbnail/Lants.png" alt="Lants" style="width:100%; height:inherit; position:absolute; object-fit: cover">
                    <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
                    <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">Lants</h1>
                    <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">A small chunk-based simulation of the cellular automata, Langton's Ant</h1>
                    <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
                </div></a>
                <a href="solarglyphs"><div class="proj" style="width: 50%; height:200px;float:left;position:absolute;left:50%;top:600px">
                    <img class="projimg" src="assets/thumbnail/SolarGlyphs.png" alt="Solar Glyphs" style="width:100%; height:inherit; position:absolute; object-fit: cover">
                    <div class = "splitter" style="position:absolute; width:100%; margin-top:32"></div>
                    <h1 class="basictext projtitle outlinetext", style="font-size:32; margin-top:0;width:100%; height:inherit; position:absolute;">Solar Glyphs</h1>
                    <h1 class="basictext projsubtitle outlinetext", style="font-size:16; margin-top:42; width:100%; height:inherit; position:absolute;">A to-scale representation of the Solar System, made for a school project, based on a funsie on this website: Starfield</h1>
                    <div class="projoverlay", style="width:100%; height:inherit; position:absolute;"></div>
                </div></a>

                <div class="splitter", style="color: #102033; top:810; width:95%; position:relative"></div>



                <!--<img class="projimg" src="BGImg0.png", style="width:33.33%; height:200px; float:left; position: absolute; object-fit: fill">
                <div class="proj", style="width:33.33%; height:200px; float:left; position: relative"></div>
                <img class="projimg" src="BGImg1.png", style="width:33.33%; height:200px; float: left; position: absolute; object-fit: cover">
                <div class="proj", style="width:33.33%; height:200px; float: left; position: relative"></div>
                <img class="projimg" src="BGImg2.png", style="width:33.33%; height:200px; float: left; position: absolute; object-fit: none">
                <div class="proj", style="width:33.33%; height:200px; float: left; position: relative"></div> -->
                
            </div>

            <!-- <h1 class = "basictext outlinetext" style="margin-top: 100px;">Ok ok this one's for evan!<h1>
            <div class="splitter"></div> -->
            <!-- <h3 class = "basictext">Did you know that the one of the wettest places in the world is Mawsynram? It only comes in second to all the women that Evan is in contact with<h3>
            <img src="https://post.healthline.com/wp-content/uploads/2020/10/Female_Water_Splash_732x549-thumbnail.jpg" style="margin-left:-40; width: 880;"> -->
            <img width=880 style="margin-top: 40; margin-left: -40; margin-bottom: 10; position: relative; width 880; height: auto; filter: none;" src="assets/solarglyphs/splash.png" alt="Solar Glyphs">

            <h1 class = "basictext" style="font-size: 48; font-weight: bold; margin-bottom: -10;">Solar Glyphs</h1>
            <h2 class = "basictext">A <a href="starfield">Starfield</a> sequal</h2>

            <h3 class = "basictext">
                Solar Glyphs is a visually based solar system sim. Everything, is rendered as a glyph, using a technique <a href = "https://steamcdn-a.akamaihd.net/apps/valve/2007/SIGGRAPH2007_AlphaTestedMagnification.pdf">written about by Valve.</a> In this small sim, each planet and moon has it's own data you can read about, with all the information originating from NASA.
            </h3>

            <h3 class = "basictext">
                There is an actual simulation part of this project. However, this massively drops the framerate, and at high speeds, doesn't work as intended. However, it does look nice, and is a fun experience to play around with nonetheless.
            </h3>

            <div class = "section" style="margin-left:-25; float: left; width: 400; margin-top: 10; margin-bottom: 10">
                <h1 class = "basictext"><a href="otherdownload" style="text-decoration: none;">Download</a></h1>
            </div>
            
            <div class = "section" style="margin-left:0; margin-right:-25; width:400; height: auto; float:right; margin-top: 10; margin-bottom: 10">
                <h1 class = "basictext"><a href="solarglyphs" style="text-decoration: none">Learn more</a></h1>
            </div> 

            <img width=880 style="image-rendering: pixelated; margin-top: 400; margin-left: -40; margin-bottom: 10; position: relative; width 880; height: auto;" src="assets/lants/splash.png" alt="Lants">

            <h1 class = "basictext" style="font-size: 48; font-weight: bold; margin-bottom: -10;">Lants</h1>
            <h2 class = "basictext">Cellular Automata Simulation</h2>

            <h3 class = "basictext">
                This Cellular Automata simulation, is based off of <a href="https://en.wikipedia.org/wiki/Langton%27s_ant">Langton's Ant.</a> Hence the name, being shortened to Lants. Langton's Ant has a few properties that are explored here. That being it's multiple rulesets, it's highways, and how ants should interact with eachother, even on different rulesets.
            </h3>

            <h3 class = "basictext">
                This sim is chunk based, so when an ant leaves the highlighted area, it will create a new chunk. This way, Lants has a very large area for ants to explore. That being, from negative (2^63) to positive (2^63) individual chunks, each with a 32 by 32 set of tiles, or cells.
            </h3>

            <div class = "section" style="margin-left:-25; float: left; width: 400; margin-top: 10; margin-bottom: 10">
                <h1 class = "basictext"><a href="otherdownload" style="text-decoration: none;">Download</a></h1>
            </div>
            
            <div class = "section" style="margin-left:0; margin-right:-25; width:400; height: auto; float:right; margin-top: 10; margin-bottom: 10">
                <h1 class = "basictext"><a href="lants" style="text-decoration: none">Learn more</a></h1>
            </div> 

            <img id="Title" width=880 style="image-rendering: pixelated; margin-top: 400 ; margin-left: -40; margin-bottom: 10; position: relative; width:880; height: auto;" src="assets/Splash.png" alt="Arvopia">
            
            <h1 class = "basictext" style="font-size: 48; font-weight: bold; margin-bottom: -10;">Arvopia 0.8</h1>
            <h2 class = "basictext">A sneak peak into the plans for Arvopia</h2>
            <h3 class = "basictext">Arvopia 0.8 is a discontinued update for Arvopia. As things are moved over to C++, development on a new Arvopia in C++ will begin eventually. For now, however, Arvopia 0.8 has a sneak peak at what it was supposed to be.
            </h3>
            <h3 class = "basictext">
                Overhauling the graphics was a big change in this version, much more work on that was to be done, however the changes in this demo are already drastic. Lighting is revamped, player animations are completely overhauled, and it all (supposedly) runs at a much smoother framerate.
            </h3>
            <h3 class = "basictext">
                If you want to see the full details, or download and try it out yourself, head over <a href = "arvopia0.8">here</a>
            </h3>

            <h1 class = "basictext" style="font-size: 48; font-weight: bold; margin-bottom: -10; margin-top: 100">Arvopia 0.7</h1>
            <h2 class = "basictext">The latest release of Arvopia</h2>
            <h3 class = "basictext">Arvopia 0.7 was updated with a heavy focus on modding support, and to be able to change anything about the game. Story lines and quests are supported, though not used quite yet. Creating NPC's is a possibility though.
            </h3>
            <h3 class = "basictext">But this update adds more than just modification support, it also adds player customization, new GUIs, better trading system, fully functional inventory, a full audio system refix ith a new song, as well as many redesigns.
            </h3>
            <div class = "section" style="margin-left:-25; float: left; width: 400; margin-top: 10; margin-bottom: 10">
                <h1 class = "basictext"><a href=arvopiadownload style="text-decoration: none;">Download</a></h1>
            </div>
            
            <div class = "section" style="margin-left:0; margin-right:-25; width:400; height: auto; float:right; margin-top: 10; margin-bottom: 10">
                <h1 class = "basictext"><a href="arvopia" style="text-decoration: none">Learn more</a></h1>
            </div> 
            
            <div class="section" id="info" style="margin-left: 10; width:780; height:auto; margin-top: 200; margin-bottom: 10; position:relative; font-size: 18">
                
                <h2 style="text-align: center; margin-left: 20; margin-bottom: 0; margin-top: 10; font-family: sans-serif; font-weight: bold; position: relative; color: rgba(0,0,0,0); ">What's Arvopia?</h1>
                <h3 style="text-align: center; margin-left: 10; margin-top: 0; font-family: sans-serif; font-weight: bold; position: relative; font-size: inherit">
                Arvopia is an indie tile-based random game about exploration and collecting resources with some rpg elements. Arvopia started back in 2017, around November. Development on Arvopia continued from then, and lead to bigger (and better?) updates. Now with creatures that roam the world, villagers that you can speak with, and quests and achievements you can unlock!</h2>
            </div>           

            <!-- <div class="splitter" style="margin-top: 75;"></div> -->

            <img id="MarboTitle" width=880 style="margin-top: 400; margin-left: -40; margin-bottom: 10; position: relative; width:880; height: auto;" src="assets/super marbo/Title.png" alt="Super Marbo">
            
            <h1 class = "basictext" style="font-size: 48; font-weight: bold; margin-bottom: -10;">Super Marbo</h1>
            <h2 class = "basictext">All 4 versions of Super Marbo are up for download</h2>
            <h3 class = "basictext">Super Marbo was a little project I started two years ago, just to see if I could recreate the classic Super Mario Bros. I then dropped it, and picked it back up in October of 2019.
            </h3>
            <h3 class = "basictext">It's essentially a buggy version of Super Mario Bros. with added features such as infinite lives, time, and unlocked screen scrolling, as well as New Super Mario Bros. mode and LAN multiplayer support. Worth the time though, it's very fun to play regardless of how buggy it may be.
            </h3>

            <div class = "section" style="margin-left:-25; float: left; width: 400; margin-top: 10; margin-bottom: 10">
                <h1 class = "basictext"><a href=otherdownload style="text-decoration: none;">Download</a></h1>
            </div>
            
            <div class = "section" style="margin-left:0; margin-right:-25; width:400; height: auto; float:right; margin-top: 10; margin-bottom: 10">
                <h1 class = "basictext"><a href="marbo" style="text-decoration: none">Learn more</a></h1>
            </div> 

            <!-- <div class="splitter" style="margin-top: 205;"></div> -->

            <img id="VectorFieldsTitle" width=880 style="margin-top: 400; margin-left: -40; margin-bottom: 10; position: relative; width:880; height: auto" src="assets/vector fields/Title.png" alt="Vector Fields">
            
            <h1 class = "basictext" style="font-size: 48; font-weight: bold; margin-bottom: -10;">Vector Fields</h1>
            <h2 class = "basictext">Eye candy</h2>
            <h3 class = "basictext">Another little project I had started a few years ago in the form of <a href = "Flowfield">Flowfield</a>, only to pick it up again in August of 2017 for my "Outdated Updates" video series. It is a simulation where you drop particles onto a 'vector-field' and let them travel around it to see what they make.
            </h3>
            <h3 class = "basictext">It's a fun little 'art tool' that can produce some very strange results. Anything varying from a galaxy to an actual painting that could be hung up in some modern art museum. Overall really fun to play around with.
            </h3>

            <div class = "section" style="margin-left:-25; float: left; width: 400; margin-top: 10; margin-bottom: 10">
                <h1 class = "basictext"><a href=otherdownload style="text-decoration: none;">Download</a></h1>
            </div>
            
            <div class = "section" style="margin-left:0; margin-right:-25; width:400; height: auto; float:right; margin-top: 10; margin-bottom: 10">
                <h1 class = "basictext"><a href="vectorfield" style="text-decoration: none">Learn more</a></h1>
            </div> 

            <div class="splitter" style="margin-top: 250;"></div>
            
            <!-- <h3 class="basictext">
                Twitter:
            </h3> -->
            
            <p class="basictext">
                <a href="https://twitter.com/zandgall?ref_src=twsrc%5Etfw" class="twitter-follow-button" data-size="large" data-show-screen-name="false" data-show-count="false">Follow @zandgall</a>
                <!-- <a href = "https://reddit.com/r/Arvopia" target="_blank"><img src="assets/arvopia-reddit-banner.png" alt="Reddit" width="84" height="28"></a> -->
            </p>
            <!-- <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script> -->
            
            <!--<p class="basictext">
                <a data-theme="dark" data-chrome="noheader nofooter noborders transparent" class="twitter-timeline" data-width="720" data-num="0" data-height="800" data-link-color="#8f70ff" href="https://twitter.com/zandgall?ref_src=twsrc%5Etfw" style="margin: auto">
                    My Twitter</a> 
            </p>
            <script async src="https://platform.twitter.com/widgets.js" charset="utf-8" style="margin: auto">
                
            </script>-->
        
            <!-- <script src="layers.js"></script> -->

        </div>
    
    </div>
</div>
    
</body>
</html>









































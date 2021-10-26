
<html lang="en">
    <head>
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="layers.js"></script>
    <title>Zandgall - Misc Arvopia Tools</title>
    <meta name="description" content="Information about miscellaneous Arvopia related tools">
    <meta name="author" content="Zandgall">
    
    <link rel="icon" href="assets/Icon.png">
    
    <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" type="text/css">
    
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="scroll.css">
    <link rel="stylesheet" href="global/parallax.css">
</head>

<body>
    <?php 
    $title = "Miscellaneous Arvopia Tools!";
    $subtitle = "Does anyone actually know how to spell Miscellaneous?";
    ?>
    <!--    Split everything into a universal div-->
    <div id = "cut" style="height: 100vh; width: 100%; top: 0; left: 0; overflow: hidden;">
        <div id="universal" class = "parallax">

            <?php include "global/head.php"?>

            <div class="section" style="position: relative; margin-left: auto; margin-right: auto; margin-top: 80; width: 800">
                
                <!--STUFF HERE-->
                <h1 class="basictext outlinetext" style="font-size:72; margin-bottom:-10">Miscellaneous Arvopia Tools</h1>
                <h2 class="basictext outlinetext">Arvopia Animator and Trading Designer</h2>
                <div class="splitter"></div>

                <img class="section" src="assets/thumbnail/AnimatorThumb.png" style="width:120%; margin-left:-10%; position: relative; z-index: 2;">
                <h1 class="basictext">Arvopia Animator</h1>
                <h2 class="basictext">
                    Used for making player animations for Arvopia 0.8. There are 4 sections to the screen. A left panel, center display, right panel, and timeline panel. The left panel shows 4 value changers, and a button. The value changers change the Length ot the animation, the position (x, y) and rotation of a selected limb. And the button compiles the created animation, and prints it to the command line so it can be copied and pasted into a mod.<br><br>The Middle display shows the limbs you can select, as well as a pause/play button, and a slider that changes the speed of the animation. Along side that, is a preview of the current frame compiled of the animation you have set.<br><br>The Right panel controls keyframes, creating and deleting keyframes, and changing keyframe timing and value. Along with that, you can change the easing types.<br><br>The timeline panel shows all the current keyframes that you have placed, and what limb/value they represent. There is also a marker showing the current animation frame being used, and it sends the information from keyframes and sends it to the center display.
                </h2>
                <a href="Downloads/Arvopia Animator.zip"><div class="section" style="width:75%; margin-left: auto; margin-right: auto; margin-bottom: 20;"><h1 class="basictext outlinetext">Arvopia Animator.zip - 865KB</h1></div></a>
                <div class="splitter"></div>
                <img class="section" src="assets/thumbnail/TradingThumb.png" style="width:120%; margin-left:-10%; position: relative; z-index: 2;">
                <h1 class="basictext">Trading Designer</h1>
                <h2 class="basictext">
                    The Trading Designer, similar to Arvopia Animator, is useful when creating mods. It gives a gui and export for making NPCs with certain dialogue trees. This makes making NPCs easier, because you can visualize the paths a player could take when talking with said NPC. After designing the tree and paths of Dialogue, you can set the name of the variable to be used when assigning the dialogue, as well as exporting the code to make the dialogue. <br><br>There are two ways to add dialogue boxes, one is by hitting the '+' button, another is by hitting CTRL+A to add one where the mouse is. After adding a Dialogue box, you can give it the response a player has to give to get to that dialogue, as well as the actual dialogue.<br><br>For example, if the "Response" box says "How are you?", the player gets a button that says "How are you?" and if the player clicks that button, the NPC will say whatever's in the "Say" box. If there's a "NAME" in the "Say" box, it will be replaced with the name of the player. If the "Say" box says "~end~", it will end the conversation.
                </h2>
                <a href="Downloads/Trading Design.zip"><div class="section" style="width:75%; margin-left: auto; margin-right: auto; margin-bottom: 20;"><h1 class="basictext outlinetext">Trading Design.zip - 625KB</h1></div></a>
                <div class="splitter"></div>
                <a href="index"><div class="section" style="width:50%; margin-left: auto; margin-right: auto; margin-bottom: 20; margin-top: 20"><h1 class="basictext outlinetext">Home</h1></div></a>

            </div>
        
        </div>
    </div>
    
    
</body>
</html>










































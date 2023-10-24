</head>


<body>
<div id = "parallax" style="position: fixed; width:100vw; height:400vh">

    <!-- Image for the sun + moon, shows in parallax. -->
    <div style="left: 5vh; top: 5vh; position: fixed; width: 100px; height: 100px; visibility: visible; overflow: hidden; z-index: -5;">
        <img class="sunmoon" style="height:32px; width: 32px; left:32px; top:32px; filter: drop-shadow(0px 0px 10px rgba(255, 255, 200, 0.5))" src="<?php echo $ROOT?>assets/background/Sun.png" alt="Sun">
    </div>
    
    <?php $front_off = rand(0,7200);?>

    <!-- The parallax layers -->
    <div class="paralayer" id="back" style="transform: translate3D(0, 0, 0); background-position-x: <?php echo -rand(0, 7200);?>px; width:100%; height:1800px; margin-top: -300px; background-image: url('<?php echo $ROOT?>assets/background/background 2.png'); background-repeat:repeat-x; z-index:-3; position: relative"></div>
    <div class="paralayer" id="mid" style="transform: translate3D(0, 0, 0); background-position-x: <?php echo -rand(0, 7200);?>px; width:100%; height:1800px; margin-top: -1200px; background-image: url('<?php echo $ROOT?>assets/background/background 1.gif'); background-repeat:repeat-x; z-index:-2; position: relative"></div>
    <div class="paralayer front" style="transform: translate3D(0, 0, 0); background-position-x: <?php echo -$front_off;?>px; width:100%; height:824px; margin-top:-1300px; background-image: url('<?php echo $ROOT?>assets/background/background 0.gif'); background-repeat:repeat-x; z-index:-1; position: relative"></div>
    <div class="paralayer front" id="span" style="transform: translate3D(0, 0, 0); background-position-x: <?php echo -$front_off;?>px; width:100%; height:12000vh; background-image: url('<?php echo $ROOT?>assets/background/dirt.png'); background-repeat:repeat; margin-top: -1px; z-index:-1; position: relative"></div>
    <!-- The clouds -->
    <?php
    for ($i = 0; $i < 4; $i++) {
        echo '<img class = "cloud" src = "'.$ROOT.'assets/background/Cloud1.png" style="height: 256px" alt="cloud">
            <img class = "cloud" src = "'.$ROOT.'assets/background/Cloud2.png" style="height: 256px" alt="cloud">
            <img class = "cloud" src = "'.$ROOT.'assets/background/Cloud3.png" style="height: 256px" alt="cloud">
            <img class = "cloud" src = "'.$ROOT.'assets/background/Cloud4.png" style="height: 256px" alt="cloud">
            <img class = "cloud" src = "'.$ROOT.'assets/background/Cloud5.png" style="height: 256px" alt="cloud">';
    }
    ?>
</div>

<!-- Parent of parent of parent of -->
<div id = "cut" style="height:100vh; top: 0; left: 0; overflow: hidden">
    <!-- Parent that every piece of content is stored inside, what actually scrolls -->
    <div id="universal" class = "p-container" style="height: 100vh; overflow-y: scroll; overflow-x:hidden; position:relative">

        <!-- Sun+moon interaction half -->
        <div style="left: 5vh; top: 5vh; position: fixed; width: 100px; height: 100px; visibility: visible; overflow: hidden; z-index: 5; pointer-events:none">
            <div class="sunmoon" style="height:32px; width: 32px; left:32px; top:32px; pointer-events:all" onclick="toggle_night()"></div>
        </div>

        <!-- Include the navigation menu -->
        <div style="position:absolute; width: 100vw; z-index:1;" id="menuholder">
            <?php include "menu.php" ?>
        </div>
        
        <!-- Index link, title and subtitle -->
        <h1 class="title" style="text-align: center; width:800px; margin: auto; margin-top:1cm;"><a href=".." class="title"style="text-decoration: none">Zandgall.com</a></h1>
        <?php
            echo "<h1 style='font-family: monospace; width:800px; margin: auto; text-align: center;'>" . $title . "</h1>";
            echo "<h1 style='font-family: monospace; width:800px; margin: auto; text-align: center; font-style: italic; font-size: 14px; margin-bottom:2cm;'>" . $subtitle . "</h1>";
        ?>

        <!-- Interactive script that controls parallax updates, cloud movement, and menu control -->
        <?php 
        include "script.php" 
        ?>
    
</head>


<body>
<div id = "parallax" style="position: fixed; width:100vw; height:400vh">
    <div style="left: 5vh; top: 5vh; position: fixed; width: 100; height: 100; visibility: visible; overflow: hidden; z-index: -5;">
        <img class="sunmoon" style="height:32px; width: 32px; left:32px; top:32px; filter: drop-shadow(0px 0px 10px rgba(255, 255, 200, 0.5))" src="assets/background/Sun.png" alt="Sun">
    </div>
    <div class="paralayer" id="back" style="transform: translate3D(0, 0, 0); width:100%; height:50vh; margin-top: 25vh; background-image: url('assets/background/bg 2.png'); background-repeat:repeat-x; z-index:-3; position: relative"></div>
    <div class="paralayer" id="mid" style="transform: translate3D(0, 0, 0); width:100%; height:50vh; margin-top: -30vh; background-image: url('assets/background/bg 1.png'); background-repeat:repeat-x; z-index:-2; position: relative"></div>
    <div class="paralayer front" style="transform: translate3D(0, 0, 0); width:100%; height:412px; margin-top:-30vh; background-image: url('assets/background/bg 0.png'); background-repeat:repeat-x; z-index:-1; position: relative"></div>
    <div class="paralayer front" id="span" style="transform: translate3D(0, 0, 0); width:100%; height:12000vh; background-image: url('assets/background/BGImg.png'); background-repeat:repeat; margin-top: -1px; z-index:-1; position: relative"></div>
    <?php
    for ($i = 0; $i < 4; $i++) {
    echo '<img class = "cloud" src = "assets/background/Cloud1.png" style="height: 144" alt="cloud">
        <img class = "cloud" src = "assets/background/Cloud2.png" style="height: 144" alt="cloud">
        <img class = "cloud" src = "assets/background/Cloud3.png" style="height: 144" alt="cloud">
        <img class = "cloud" src = "assets/background/Cloud4.png" style="height: 144" alt="cloud">';
    }
    ?>
</div>
<div id = "cut" style="height:100vh; top: 0; left: 0; overflow: hidden">
    <div id="universal" class = "p-container" style="height: 100vh; overflow-y: scroll; overflow-x:hidden; position:relative">
    <div style="left: 5vh; top: 5vh; position: fixed; width: 100; height: 100; visibility: visible; overflow: hidden; z-index: 5; pointer-events:none">
        <div class="sunmoon" style="height:32px; width: 32px; left:32px; top:32px; pointer-events:all" onclick="togglenight()"></div>
    </div>
    <div style="position:absolute; width: 100vw; z-index:1;" id="menuholder">
        <?php include "menu.php" ?>
    </div>
    <!-- <div id="titleholder"> -->
    <h1 class="title" style="text-align: center; width:800px; margin: auto; margin-top:1cm;"><a href=".." class="title"style="text-decoration: none">Zandgall.com</a></h1>
    <?php
        echo "<h1 style='font-family: monospace; width:800px; margin: auto; text-align: center;'>" . $title . "</h1>";
        echo "<h1 style='font-family: monospace; width:800px; margin: auto; text-align: center; font-style: italic;font-size: 14; margin-bottom:2cm;'>" . $subtitle . "</h1>";
    ?>
    <?php 
    include "script.php" 
    ?>
    <!-- </div> -->
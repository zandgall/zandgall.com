
<html lang="en">
    <head>
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="layers.js"></script>
    <script src="Funsies/BubbleCannons/input.js"></script>
    <script src="Funsies/BubbleCannons/bubblebullets.js"></script>
    <script src="Funsies/BubbleCannons/bubblemenu.js"></script>
    <script src="Funsies/BubbleCannons/bubblepath.js"></script>
    <script src="Funsies/BubbleCannons/bubbleenemy.js"></script>
    <script src="Funsies/BubbleCannons/bubbleplayer.js"></script>
    <title>Zandgall - BubbleCannons</title>
    <meta name="description" content="Play BubbleCannons online now">
    <meta name="author" content="Zandgall">
    
    <link rel="icon" href="assets/Icon.png">
    
    <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" type="text/css">
    
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="scroll.css">
    <link rel="stylesheet" href="global/parallax.css">
</head>

<body>
    <?php 
    $title = "BubbleCannons!";
    $subtitle = "An actual funsie on this site";
    ?>
    <!--    Split everything into a universal div-->
    <div id = "cut" style="height: 100vh; width: 100%; top: 0; left: 0; overflow: hidden;">
        <div id="universal" class = "parallax">
            <div class="parallax" style="height:1430px; overflow:hidden;">
                <?php include "global/head.php"?>

            <!-- <div class="section" style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: 800"> -->
                
                <!--STUFF HERE-->
                <div height=800 style="margin:auto; margin-top: 0; width:800; height:800">
                    <canvas class="section" id="Canvas" width=800 height=800 style="position:relative; margin: auto; margin-top:0; margin-bottom: -4; width:800; height:800">CANVAS NOT SUPPORTED</canvas>
                    <div id="upgrade" width=200 height=800 style="width:200; height: 800; float: right; position:relative; margin-top: -800; margin-bottom: 100; left: 216px;">
                        <img src="Funsies/BubbleCannons/upgrademenubg.png" id="begin" style="object-fit: cover; position: absolute;">
                    </div>
                </div>
                
                <a href="javascript:if(!playing) {iterate(); playing = true; increment = -1;}" style="text-decoration: none; margin: auto; position:relative;">
                    <div width=400 height=100 style="width:400; height:100; position:relative; margin: auto; margin-top: 10;">
                        <img src="Funsies/BubbleCannons/next round.png" style="object-fit: cover; position: absolute;">
                    </div>
                </a>
                <canvas id="utilcan">

                <script type="text/javascript" src="Funsies/BubbleCannons/bubblecannons.js">
                    console.log("THIS IS THE BEGINNING");
                    
                    // e();
                    // init();
                    // draw();
                </script>

            </div>
        
        <!-- </div> -->
    </div>
</div>
    
</body>
</html>




























































<html lang="en">
    <head>
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="layers.js"></script>
    <script src="Funsies/BubbleCannons_old/bcenemy.js"></script>
    <script src="Funsies/BubbleCannons_old/upgrademenu.js"></script>
    <script src="Funsies/BubbleCannons_old/cannons.js"></script>
    <script src="Funsies/BubbleCannons_old/rounds.js"></script>
    <script src="Funsies/BubbleCannons_old/bcplayer.js"></script>
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

            <?php include "global/head.php"?>

            <!-- <div class="section" style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: 800"> -->
                
                <!--STUFF HERE-->
                <div height=800 style="margin:auto; margin-top: 0; width:800; height:800">
                    <canvas class="section" id="Canvas" width=800 height=800 style="position:relative; margin: auto; margin-top:0; margin-bottom: -4; width:800; height:800">CANVAS NOT SUPPORTED</canvas>
                </div>

                <script type="text/javascript" src="Funsies/BubbleCannons_old/bubblecannons.js">
                    console.log("THIS IS THE BEGINNING");
                    e();
                    init();
                    draw();
                </script>

            </div>
        
        </div>
    </div>
    
    
</body>
</html>




























































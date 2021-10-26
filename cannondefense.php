
<html lang="en">
    <head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="layers.js"></script>
    <title>Nat-Gall - Cannon Defense</title>
    <meta name="description" content="A Mix between bubble cannons and toy defense - Nathaniel Gall, my 9yo brother">
    <meta name="author" content="Zandgall + Nat Gall">

    <script src="Funsies/p5/p5.js"></script>

    <link rel="icon" href="assets/Icon.png">
    
    <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" type="text/css">
    
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="scroll.css">
    <link rel="stylesheet" href="global/parallax.css">
</head>

<body>
    

    <!--    Split everything into a universal div-->
    <?php 
    $title = "Cannon Defense!";
    $subtitle = "Created by 9yo Nathaniel Gall";
    ?>
    <!--    Split everything into a universal div-->
    <div id = "cut" style="height: 100vh; width: 100%; top: 0; left: 0; overflow: hidden;">
        <div id="universal" class = "parallax">
            <?php include "global/head.php"?>

            <div id="canvasDiv" class="section" height=850 width=750 style="z-index: 10; position: relative; margin:auto; margin-top: 0; width:850; height:750;" ></div>
            <script src="nat/game 1/sketch.js"></script>
        </div>
    </div>


</body>
</html>











































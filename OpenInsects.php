
<html lang="en">
    <head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="layers.js"></script>
    <title>Zandgall - OpenInsects</title>
    <meta name="description" content="See a simulation of Insects moving around your screen">
    <meta name="author" content="Zandgall">

    <script src="Funsies/OpenInsects/insect.js"></script>

    <link rel="icon" href="assets/Icon.png">
    
    <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" type="text/css">
    
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="scroll.css">
    <link rel="stylesheet" href="global/parallax.css">
</head>

<body>
    <canvas id="Canvas" class="bg" style="z-index: 1; pointer-events: none">Canvas is not supported</canvas>

    <!--    Split everything into a universal div-->
    <?php 
    $title = "Insects!";
    $subtitle = "One of 5 different types, keep refreshing for new ones!";
    ?>
    <!--    Split everything into a universal div-->
    <div id = "cut" style="height: 100vh; width: 100%; top: 0; left: 0; overflow: hidden;">
        <div id="universal" class = "parallax">
            <?php include "global/head.php"?>

            <script src="Funsies/OpenInsects/openinsects.js"></script>
        </div>
    </div>


</body>
</html>












































<html lang="en">
    <head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script><script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="layers.js"></script>
    <title>Zandgall - Multiplayer test</title>
    <meta name="description" content="Just testing multiplayer :)">
    <meta name="author" content="Zandgall">

    <!-- <script src="Funsies\multiplayer\node_modules\ws\lib\websocket.js"></script> -->
    <script type="text/javascript" src="Funsies\lodash.js"></script>
    <script src="Funsies\multiplayer\node_modules\socket.io\client-dist\socket.io.js"></script>
    <!-- <script src="Funsies/OpenInsects/insect.js"></script> -->

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
    $title = "Multiplayer!";
    $subtitle = "Hi, things are just getting set up";
    ?>
    <!--    Split everything into a universal div-->
    <div id = "cut" style="height: 100vh; width: 100%; top: 0; left: 0; overflow: hidden;">
        <div id="universal" class = "parallax">
            <?php include "global/head.php"?>

            <script src="Funsies/multiplayer/static/main.js"></script>
        </div>
    </div>


</body>
</html>











































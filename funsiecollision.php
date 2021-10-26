<html lang="en">
    <head>
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="layers.js"></script>
    <script src="Funsies/NOISE/PATH.js"></script>
    <script src="Funsies/PublicMath/PublicMath.js"></script>
    <title>Zandgall - Collision Testing</title>
    <meta name="description" content="A Collision tester">
    <meta name="author" content="Zandgall">
        
    <link rel="icon" href="assets/Icon.png">
    
    <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" type="text/css">
    
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="scroll.css">
    <link rel="stylesheet" href="global/parallax.css">
</head>

<body>
    <?php 
    $title = "Flowfield!";
    $subtitle = "A predecessor to <a href=\"vectorfield\">Vector Field!</a>";
    ?>
    <!--    Split everything into a universal div-->
    <div id = "cut" style="height: 100vh; width: 100%; top: 0; left: 0; overflow: hidden;">
        <div id="universal" class = "parallax">

            <?php include "global/head.php"?>
        
            <div style="margin:auto; width: 766; height: 60"> 
                <canvas class="section" id="Canvas" width=766 height=766 style="position:relative; margin: auto; margin-top:100; margin-bottom: 100; width:766; height:766">CANVAS NOT SUPPORTED</canvas>
            </div>
         
            <script type="text/javascript" src="Funsies/Collision.js">
            </script>
        </div>
    </div>
    
</body>
</html>










































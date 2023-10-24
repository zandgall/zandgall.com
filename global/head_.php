<head>
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="layers.js"></script>
    <title><?php echo $pagetitle?></title>
    <meta name="description" content="<?php echo $pagedesc?>">
    <meta name="author" content="Zandgall">
    
    <link rel="icon" href="assets/Icon.png">
    
    <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" type="text/css">
    <style>
        @font-face {
            font-family: basicbit2;
            src: url("assets/basicbit2.ttf");
        }
    </style>

    <style>
        .p-container {
            /* width: 100vw;
            height: 100vh; */
            overflow-x: hidden;
            overflow-y: visible;
            perspective: 10px;
        }
        .p-section {
            transform-style: preserve-3d;
            height: 100vh;
            overflow-y:visible;
            position: relative;
        }
        .content,
        .bg {
            overflow-y:visible;
            position: absolute;
            top: 0;
            left: 0;
            /* bottom: 0; */
            right: 0;
            image-rendering: pixelated;
            /* background-size: cover; */
        }
        .p-section.back {
            z-index: -1;
        }
        .p-section.back .bg {
            transform: translateZ(-10px) scale(2);
        }
        .p-section.front {
            z-index: 5;
            background-color: coral;
        }
        /* #one .bg {
            background-image: url(https://placeimg.com/1440/700/nature);
        }
        #three .bg {
            background-image: url(https://placeimg.com/1440/700/arch);
        } */
    </style>
    
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../scroll.css">
    <link rel="stylesheet" href="../global/parallax.css">
</head>
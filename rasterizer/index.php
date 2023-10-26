<!DOCTYPE html>
<head>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="vertex.js"></script>
    <script src="shading.js"></script>
    <script src="triangle.js"></script>
    <script src="clipping.js"></script>
    <script src="object.js"></script>
    <title>zandgall - JavaScript Rasterizer</title>
    <link rel="icon" href="./assets/Icon.png">
</head>
<body style="margin: 0px">
    <div id="main" style="display:flex; flex-wrap: wrap">
        <canvas id="canvas" style="pointer-events:none; width: min(100vh, 100vw); height: min(100vh, 100vw); image-rendering: pixelated"></canvas>
        <form id="controls" style="float: right">
            <input type="checkbox" id="rasterizer_run" value="rasterizer_run">
            <label for="rasterizer_run">Run the Rasterizer</label><br>
            <input type="checkbox" id="blur" value="blur">
            <label for="blur">Blur</label><br>
            <input type="checkbox" id="affine" value="affine">
            <label for="affine">Use Affine Interpolation</label>
            <input type="checkbox" id="hqcube" value="hqcube">
            <label for="hqcube" id="hqcubelabel">Use High-Res Skybox Model </label><br>
            <input type="range" id="quality" name="quality" min="1" max="1000" step="1" value="250" style="width:100%; min-width: 500px"><br>
            <label for="quality">Quality: <output id="quality-value">250</output></label>
        </form>
    </div>

    <canvas id="hidden" style="display:none"></canvas>
    <img id="monkey" src="monkey.png" style="display:none">
    <img id="skybox_bottom" src="skybox/bottom.jpg" style="display:none">
    <img id="skybox_top" src="skybox/top.jpg" style="display:none">
    <img id="skybox_back" src="skybox/back.jpg" style="display:none">
    <img id="skybox_front" src="skybox/front.jpg" style="display:none">
    <img id="skybox_left" src="skybox/left.jpg" style="display:none">
    <img id="skybox_right" src="skybox/right.jpg" style="display:none">
    <script src="source.js"></script>
</body>

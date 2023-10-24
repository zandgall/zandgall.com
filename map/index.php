<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://colorjs.io/dist/color.global.js"></script>
        <style>
            button > img {
                border: 0px transparent;
                filter:none;
                image-rendering:pixelated;
                z-index:1;
                margin-bottom:-12px;
                height:32px;
            }
            button > p {

            }
            /* img:hover {
                border: 1px solid white;
                margin-left:-1px;
                margin-top:-1px;
                z-index:10;
            } */
            button {
                cursor:pointer;
                border:none;
                appearance:none;
                background-color: inherit;
                margin:0;
                padding:0;
            }
        </style>
    </head>
    <body>
        <?php
        // for($z = -14; $z < 15; $z++) {
        //     for($x = 0; $x < 27; $x++) {
        //         $l = $x * 128;
        //         $t = ($z+14) * 128;
        //         echo "<img src=\"img/map.".$x.".".$z.".png\" style=\"position:absolute; left:".$l."; top:".$t.";\"/>";
        //     }
        // }
        ?>
        <canvas id="paint" width="3456px" height="3712px" style="width:100vw; height:100vh; position:fixed; left:0; top:0; visibility:hidden"></canvas>
        <canvas id="c" width="100vw" height="100vw" style="width:100vw; height:100vh; position:fixed; left:0; top:0"></canvas>
        <div id="input" style="position:fixed; left:140; top:4px; visibility: hidden;">
            <input id="nameInput" type="text" style="width:300px;"/>
            <input id="descInput" type="text" style="width:300px;"/>
            <input id="deleteMarker" type="button" value="Delete Marker"/>
            <input id="moveMarker" type="button" value="Move Marker"/>
            <button id="icon_default" type="button"><img src="icons/markers/default.png"/></button>
            <button id="icon_important-place" type="button"><img src="icons/markers/important-place.png"/></button>
            <button id="icon_exclamation" type="button"><img src="icons/markers/exclamation.png"/></button>
            <button id="icon_question" type="button"><img src="icons/markers/question.png"/></button>
            <button id="icon_house" type="button"><img src="icons/markers/house.png"/></button>
            <button id="icon_tree" type="button"><img src="icons/markers/tree.png"/></button>
            <button id="icon_pin" type="button"><img src="icons/markers/pin.png"/></button>
        </div>
        <div id="r_input" style="position:fixed; left:400; top:4px; visibility: hidden;">
            <input id="r_nameInput" type="text" style="width:300px;"/>
            <input id="r_descInput" type="text" style="width:300px;"/>
            <input id="r_deleteRegion" type="button" value="Delete Region"/>
            <input id="r_color" type="color" value="#ff00ff"/>
            <button id="r_brush" type="button"><img src="icons/tools/region-painting.png"/></button>
            <button id="r_eraser" type="button"><img src="icons/tools/eraser.png"/></button>
        </div>
        <div id="toolbar" style="position: fixed; left: 140; top:4px; visibility: visible;">
            <button id="tool_marking" type="button"><img src="icons/tools/marking.png"><p>Marking</p></button>
            <button id="tool_region-painting" type="button" style="margin-left:10px"><img src="icons/tools/region-painting.png"><p>Region Painting</p></button>
            <button id="tool_cartography" type="button"style="margin-left:10px"><img src="icons/tools/cartography.png"><p>Cartography</p></button>
        </div>
        <div id="region-palette" style="position:fixed; left:4px; top:50px; visibility:hidden; width:60">
            <button id="addNewRegion" type="button" style="margin-left:10px">New</button>
        </div>
        <script src="script.js?version=6"></script>
    </body>
</html>
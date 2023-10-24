<?php
$ROOT = str_repeat("../", substr_count($_SERVER['REQUEST_URI'], "/"));?>
<!DOCTYPE html>
<html>
    <head>
        <title>Map</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <meta name="description" content="A ross wiki entry">
        <meta name="author" content="Zandgall">
        <link rel="icon" href="<?php echo $ROOT?>ross/Icon.png">
        <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="<?php echo $ROOT?>ross/style.css">
        <link rel="stylesheet" href="./edit/style.css">
    </head>
    <body style="display:block; margin:0">
    <?php
        $json_file = file_get_contents("data.json");
        $data = json_decode($json_file, true);
        if(!isset($_GET["server"])) {
            echo "<main>";
            foreach($data["servers"] as $name => $server) {
                echo "
                <a href='map?server=".$server["page"]."'>
                    <div class='item'>
                        <h1>$name</h1>
                        <img src='{$server["thumbnail"]}' alt=\"$name\">
                    </div>
                </a>";
            }
            echo "</main>";
            return;
        }
        $server = str_replace("_", " ", $_GET["server"]);
        echo "<script>var server = \"$server\";</script>";
    ?>
        <canvas id='can' style="display:block;margin:0;width:100vw;height:100vh;background-color:#aaa"></canvas>
        <p id='coords' style="position:fixed; bottom:5mm; left:5mm; font-family:basicbit"></p>
        <label for="bigIcons" style="position:fixed; right:15mm; top:5mm;">Bigger Icons:</label>
        <input id="bigIcons" type="checkbox" value='false' style="position:fixed; right:5mm; top:5mm">
        <div id='info' class='mcbg' style="position:fixed; left:5mm; top:5mm; padding:5mm; font-family:basicbit; min-width:25vw;">
            <h1>Build Name</h1>
            <p style="max-width:100%;font-family:basicbit-light">Click a build on the map to get information about it</p><br>
            <img id='thumbnail'><br>
            <a href='#'></a>
        </div>
        <script>
            var can = document.getElementById("can");
            var builds = <?php echo json_encode($data["builds"]); ?>;
            var files = {
                "1": <?php $out = array();
                    foreach (glob("$server/map/*.png") as $filename) {
                        $out[]=$filename;
                    }
                    echo json_encode($out);?>,
                "2": <?php $out = array();
                    foreach (glob("$server/map/2/*.png") as $filename) {
                        $out[]=$filename;
                    }
                    echo json_encode($out);?>,
                "4": <?php $out = array();
                    foreach (glob("$server/map/4/*.png") as $filename) {
                        $out[]=$filename;
                    }
                    echo json_encode($out);?>,
                "8": <?php $out = array();
                    foreach (glob("$server/map/8/*.png") as $filename) {
                        $out[]=$filename;
                    }
                    echo json_encode($out);?>,
                "16": <?php $out = array();
                    foreach (glob("$server/map/16/*.png") as $filename) {
                        $out[]=$filename;
                    }
                    echo json_encode($out);?>,
                "32": <?php $out = array();
                    foreach (glob("$server/map/32/*.png") as $filename) {
                        $out[]=$filename;
                    }
                    echo json_encode($out);?>,
                "64": <?php $out = array();
                    foreach (glob("$server/map/64/*.png") as $filename) {
                        $out[]=$filename;
                    }
                    echo json_encode($out);?>
            };

            var x = 0, y = 0, zoom = 1;
            let tiles = {
                "1": {

                },
                "2": {

                },
                "4": {

                },
                "8": {

                },
                "16": {

                },
                "32": {

                },
                "64": {

                }
            };
            let loadLock = false;

            function loaded_image() {
                loadLock = false;
            }

            let icons = {"Base": new Image(), "Shop": new Image(), "Build": new Image(), "Hub": new Image(), "Farm": new Image()};

            let mouseX, mouseY, pmouseX, pmouseY;
            let mouseLeft;

            function deformat(string) {
                for(let left = string.search("{"), right=string.search("}"); left!=-1; left=string.search("{"), right=string.search("}")) {
                    let rep = "";
                    tokens = string.substr(left+1, right-left-1).split(",");
                    if(tokens[0]!="i") {
                        rep = tokens[2];
                    }
                    string = string.substr(0, left)+rep+string.substr(right+1);
                }
                return string;
            }

            function draw() {
                let c = can.getContext("2d");
                let w = document.body.clientWidth;
                let h = document.body.clientHeight;
                can.width = w;
                can.height = h;
                c.clearRect(0, 0, w, h);
                c.save();
                c.scale(zoom, zoom);
                c.translate(-x, -y);
                c.translate(w/(2*zoom), h/(2*zoom));
                c.imageSmoothingEnabled = false;
                c.textAlign = "center";
                c.font = `${24/zoom}px basicbit`;

                let lvl = 1;
                if(zoom < 0.015625)
                    lvl = 64;
                else if(zoom < 0.03125)
                    lvl = 32;
                else if(zoom < 0.0625)
                    lvl = 16;
                else if(zoom < 0.125)
                    lvl = 8;
                else if(zoom < 0.25)
                    lvl = 4;
                else if(zoom < 0.5)
                    lvl = 2;

                let xMin = (x/(512*lvl)) - (w/zoom)/(1024*lvl);
                let xMax = (x/(512*lvl)) + (w/zoom)/(1024*lvl);
                let yMin = (y/(512*lvl)) - (h/zoom)/(1024*lvl);
                let yMax = (y/(512*lvl)) + (h/zoom)/(1024*lvl);

                for(let i = Math.floor(yMin); i < yMax; i++) {
                    for(let j = Math.floor(xMin); j < xMax; j++) {
                        if([j,i] in tiles[lvl]) {
                            c.drawImage(tiles[lvl][[j,i]], j*512*lvl, i*512*lvl, 512*lvl, 512*lvl);
                        }
                    }
                }

                let mouseMapX = (mouseX - w/2)/zoom + x;
                let mouseMapY = (mouseY - h/2)/zoom + y;
                $("#coords").text(`(${Math.floor(mouseMapX)}, ${Math.floor(mouseMapY)})`);

                let t = false, tx = 0, ty = 0;
                for(key in builds) {
                    if(!builds[key]["on_map"] || builds[key]["server"]!=server)
                        continue;
                    let coords = builds[key]["coordinates"];
                    coords[0] = Number(coords[0]);
                    coords[1] = Number(coords[1]);
                    coords[2] = Number(coords[2]);
                    let s = (8/zoom) * (document.getElementById("bigIcons").checked ? 2 : 1);
                    console.log(key, builds[key]["type"]);
                    c.drawImage(icons[builds[key]["type"]], coords[0]-s, coords[2]-s, 2*s, 2*s);
                    if(mouseMapX >= coords[0]-s && mouseMapX <= coords[0]+s && mouseMapY >= coords[2]-s && mouseMapY <= coords[2]+s) {
                        t = builds[key].name;
                        tx = coords[0];
                        ty = coords[2] - s - 2/zoom;
                        if(mouseLeft) {
                            c.font = "32px basicbit";
                            $("#info").css("width", `calc(${c.measureText(t).width}px + 10mm)`);
                            $("#info").show();
                            $("#info h1").text(t);
                            let desc = deformat(builds[key].description);
                            $("#info p").text((desc.length > 500) ? (desc.substr(0, 500)+"...") : desc);
                            $("#info img").attr("src", builds[key].thumbnail);
                            $("#info a").attr("href", builds[key].page);
                            $("#info a").text(t);
                        }
                    }
                }
                if(t!=false) {
                    c.font = `${24/zoom}px basicbit`;
                    c.fillStyle = "#ffffff";
                    c.fillText(t, tx-1/zoom, ty - 1/zoom);
                    c.fillText(t, tx-1/zoom, ty + 1/zoom);
                    c.fillText(t, tx+1/zoom, ty - 1/zoom);
                    c.fillText(t, tx+1/zoom, ty + 1/zoom);
                    c.fillStyle = "#000000";
                    c.fillText(t, tx, ty);
                }
                if(t==false && mouseLeft)
                    $("#info").hide();

                c.restore();
                if(!loadLock) {
                    let cx = Math.floor(x/(512*lvl));
                    let cy = Math.floor(y/(512*lvl));
                    let xToLoad = cx;
                    let yToLoad = cy;
                    // TODO: find next tile to load if current tile is already loaded
                    let findingImage = true;
                    let distanceOut = 0;
                    let src = `${server}/map/${lvl=="1"?"":lvl+"/"}r.${xToLoad}.${yToLoad}.png`;
                    while(findingImage) {
                        src = `${server}/map/${lvl=="1"?"":lvl+"/"}r.${xToLoad}.${yToLoad}.png`;
                        if([xToLoad, yToLoad] in tiles[lvl] || !files[lvl].includes(src)) {
                            xToLoad++;
                            if(xToLoad>cx+distanceOut) {
                                xToLoad = cx-distanceOut;
                                yToLoad++;
                            }
                            if(yToLoad>cy+distanceOut) {
                                distanceOut++;
                                xToLoad = cx-distanceOut;
                                yToLoad = cy-distanceOut;
                                if(xToLoad < Math.floor(xMin) && yToLoad < Math.floor(yMin))
                                    return;
                            }
                        } else {
                            findingImage = false;
                        }
                    }
                    loadLock = true;
                    tiles[lvl][[xToLoad, yToLoad]] = new Image();
                    tiles[lvl][[xToLoad, yToLoad]].onload = function() {
                        files[lvl].splice(files[lvl].indexOf(src), 1);
                        loadLock = false;
                    }
                    tiles[lvl][[xToLoad, yToLoad]].src = src;
                }
            }

            $(function() {
                icons["Base"].src = "icons/Base.png";
                icons["Shop"].src = "icons/Shop.png";
                icons["Build"].src = "icons/Build.png";
                icons["Hub"].src = "icons/Hub.png";
                icons["Farm"].src = "icons/Farm.png";

                window.setInterval(draw, 50);

                $(can).mousedown(function(e){
                    if(e.button==0)
                        mouseLeft = true;
                });

                $(document).mouseup(function(e){
                    if(e.button==0)
                        mouseLeft = false;
                });

                $(document).mousemove(function(e) {
                    pmouseX = mouseX;
                    pmouseY = mouseY;
                    mouseX = e.pageX;
                    mouseY = e.pageY;
                    if(mouseLeft) {
                        x += (pmouseX - mouseX)/zoom;
                        y += (pmouseY - mouseY)/zoom;
                    }
                });

                can.addEventListener("wheel", (ev) => {
                    zoom -= zoom * ev.deltaY * 0.0005;
                });
            });
        </script>
    </body>
</html>
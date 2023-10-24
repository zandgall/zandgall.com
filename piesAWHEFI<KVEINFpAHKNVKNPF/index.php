<html>
<head>
    <link rel="stylesheet" charset="utf-8" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" type="text/css">
</head>
<body style="background-color: #181a1b">
    <div style="position:fixed; width:1px; height:1px; left:50%; top:50%; border:0px">
        <div class="info" id="baseInfo" style="z-index: 4; position: fixed; left: 0px; top:0px; width:100%; height:300px; background-color:rgba(50, 50, 60, 0.85); visibility:visible">
            <h1 style="margin-left: 300px">Welcome to the Pies</h1>
            <h2 style="margin-left: 300px; color:#aaaaaa">Click on a pie to view it up close, click a slice to view info about that</h2>
        </div>

        <div style="position:fixed; width:100vw; height:100vh; margin-top:-50vh; margin-left:-50vw;" onclick="openmenu()"></div>
        <?php 
        // Friends
        $ffile = fopen("pies.json", "r") or die("death");
        $fffile = fread($ffile,filesize("pies.json"));
        fclose($ffile);
        $pies = json_decode($fffile, true)["pies"];
        for($i = 0, $l = count($pies); $i < $l; $i++) {
            $angle = (3.14159265*2) * ($i / $l) - 3.14159265*0.5;
            $x = cos($angle)*400;
            $y = sin($angle)*400;
            $slices = $pies[$i]["slices"];
            $total = 0;
            for($j = 0; $j < count($slices); $j++) {
                $total += $slices[$j]["value"];
                echo "<div class=\"info\" id=\"slice".$i."-".$j."Info\"style=\"z-index: 4; position:fixed; left:0px; top: 0px; width:100%; height: 300px; background-color: rgba(50, 50, 60, 0.85); visibility:hidden\">";
                echo "<h1 style=\"margin-left: 50px\">".$slices[$j]["name"]."</h1>";
                echo "<h2 style=\"margin-left: 50px; color:#aaaaaa\">".$slices[$j]["desc"]."</h2>";
                echo "</div>";
            }
            echo "<div style=\"position:fixed; width:1; height:1; margin-left:$x; margin-top:$y;\" onclick=\"opencircle($i)\">";
            echo "<div style=\"position:fixed; border-radius:100%; width:100; height:100; margin-left:-50; margin-top:-50; background-color:rgb(255, 0, 0);\">";
            echo "<svg viewBox=\"-1 -1 2 2\" style=\"transform:rotate(-0.25turn)\" width=100 height=100>";
            $pa = 0;
            $px = 1;
            $py = 0;
            for($j = 0; $j < count($slices); $j++) {
                $angle = $pa + $slices[$j]["value"]/$total * 3.14159265*2;
                $x = cos($angle);
                $y = sin($angle);
                echo "<path d=\"M 0 0 L $px $py A 1 1 0 ".($slices[$j]["value"]/$total>0.5 ? "1" : "0")." 1 $x $y L 0 0\" fill=\"hsl(".(0.618033988749895 * 360 * $j).", 100%, 50%)\" start=\"$pa\" stop=\"$angle\"></path>";
                $px = $x;
                $py = $y;
                $pa = $angle;
            }
            echo "</svg></div><h3 style=\"position:fixed; margin-top:-70; text-align:center; width:200; margin-left:-100\">".$pies[$i]["name"]."</h3>";
            echo "</div>";
            echo "<div class=\"circle\" id=\"circle$i\" style=\"position:fixed; width:600; height:600; margin-left:-300; margin-top:-300; visibility:hidden;\">";
            echo "<svg viewBox=\"-1.5 -1.5 3 3\" style=\"transform:rotate(-0.25turn)\" width=600 height=600>";
            $pa = 0;
            $px = 1;
            $py = 0;
            for($j = 0; $j < count($slices); $j++) {
                $angle = $pa + $slices[$j]["value"]/$total * 3.14159265*2;
                $x = cos($angle);
                $y = sin($angle);
                echo "<path class=\"slice\" d=\"M $px $py A 1 1 0 ".($slices[$j]["value"]/$total>0.5 ? "1" : "0")." 1 $x $y L 0 0 Z\" fill=\"hsl(".(0.618033988749895 * 360 * $j).", 100%, 50%)\" start=\"$pa\" stop=\"$angle\" animind=\"0\" isselected=\"false\" onclick=\"openslice($i,$j)\"></path>";
                $px = $x;
                $py = $y;
                $pa = $angle;
            }
            $pa = -3.14159265*0.5;
            $px = 1;
            $py = 0;
            for($j = 0; $j < count($slices); $j++) {
                $angle = $pa + $slices[$j]["value"]/$total * 3.14159265;
                $x = cos($angle);
                $y = sin($angle);
                echo "<text x=\"$x\" y=\"".($y-0.07)."\" text-anchor=\"middle\" fill=\"white\" stroke=\"black\" stroke-width=0.005 style=\"font: bold 0.13px sans-serif; transform:rotate(0.25turn)\" pointer-events=\"none\">".$slices[$j]["name"]."</text>";
                echo "<text x=\"$x\" y=\"".($y+0.07)."\" text-anchor=\"middle\" fill=\"white\" stroke=\"black\" stroke-width=0.004 style=\"font: bold 0.13px sans-serif; transform:rotate(0.25turn)\" pointer-events=\"none\">".floor(100*$slices[$j]["value"]/$total)."%</text>";
                $px = $x;
                $py = $y;
                $pa = $angle + $slices[$j]["value"]/$total * 3.14159265;
            }
        echo "</svg></div>";
        }
        
        ?>
        <script>
            function openmenu(friend) {
                console.log("Trying to open " + friend);
                $(".info").css("visibility", "hidden");
                $("#"+friend+"Info").css("visibility", "visible");
            }
            function opencircle(circle) {
                console.log("Trying to open " + circle);
                $(".circle").css("visibility", "hidden");
                $("#circle"+circle).css("visibility", "visible");
            }
            function openslice(pie, slice) {
                console.log("Trying to open pie: #",pie,"Slice: #",slice);
                $(".info").css("visibility", "hidden");
                $("#slice"+pie+"-"+slice+"Info").css("visibility", "visible");
            }
            /**
             * @param {JQueryMouseEventObject} e
             */
            function onMove(e) {
                var angle = Math.atan2(e.offsetY-150, e.offsetX - 150);
                if(angle<0)
                    angle += Math.PI * 2;
                // console.log("Angle: ", angle, $(e.target).is(".slice"));
                if($(e.target).is(".slice")) {
                    // console.log("Adding", $(e.target).attr("isselected"));
                    $(".slice").attr("isselected", "false");
                    $(e.target).attr("isselected", "true");
                }
                
            }

            function draw() {
                for(let i = 0; i < $(".slice").length; i++) {
                    let midang = 0.5*$(".slice").eq(i).attr("start")+0.5*$(".slice").eq(i).attr("stop");
                    let sx = Math.cos($(".slice").eq(i).attr("start"));
                    let sy = Math.sin($(".slice").eq(i).attr("start"));
                    let ex = Math.cos($(".slice").eq(i).attr("stop"));
                    let ey = Math.sin($(".slice").eq(i).attr("stop"));
                    let ox = Math.cos(midang)*parseFloat($(".slice").eq(i).attr("animind"))*0.1;
                    let oy = Math.sin(midang)*parseFloat($(".slice").eq(i).attr("animind"))*0.1;
                    // console.log("M",sx,sy,ex,ey,ox,oy, midang, parseFloat($(".slice").eq(i).attr("animind")), $(".slice").eq(i).attr("isselected"));
                    // M $px $py A 1 1 0 0 1 $x $y L 0 0
                    let long = 0;
                    if(parseFloat($(".slice").eq(i).attr("stop"))-parseFloat($(".slice").eq(i).attr("start"))>3.14159265)
                        long = 1;
                    $(".slice").eq(i).attr("d", `M ${sx+ox} ${sy+oy} A 1 1 0 ${long} 1 ${ex+ox} ${ey+oy} L ${ox} ${oy} Z`);
                    if($(".slice").eq(i).attr("isselected")==="true") {
                        $(".slice").eq(i).attr("animind",parseFloat($(".slice").eq(i).attr("animind")*0.8)+0.2);
                        $(".slice").eq(i).attr("stroke", "white");
                        $(".slice").eq(i).attr("stroke-width", "0.04");
                    }
                    else {
                        $(".slice").eq(i).attr("stroke", "none");
                        $(".slice").eq(i).attr("animind", parseFloat($(".slice").eq(i).attr("animind"))*0.8);
                    }
                }
            }

            window.onload = function() {
                $(".circle").mousemove(onMove);
                window.setInterval(draw, 13);
            };
            </script>
    </div>
    <a href="../index" style="position: relative; font-family: sans-serif; z-index: 4">go to main site</a>
</body>
</html>
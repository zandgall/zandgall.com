<html>
<head>
    <link rel="stylesheet" charset="utf-8" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" type="text/css">
</head>
<body style="background-color: #181a1b">
    <a href="../index" style="font-family: sans-serif; z-index: 4">go to main site</a>
    <div style="position:fixed; width:1px; height:1px; left:50%; top:50%; border:0px">
        <img id="me" src="me.jpg" style="margin-left:-20px; margin-top:-20px;">

        <!-- <div style="position:fixed; border: 0px; border-radius: 100%; width:1024; height:1024; margin-left: -1024; margin-top:-840; background-color:rgba(255, 0, 0, 0.1)">
            <h3 style="position: relative; margin:auto; text-align: center; margin-top:512; color:#d0d0d0">Wanker Crew</h3>
        </div> 
        <div style="position:fixed; border: 0px; border-radius: 100%; width:400; height:400; margin-left: -512; margin-top:-140; background-color:rgba(0, 255, 0, 0.1)">
            <h3 style="position: relative; margin:auto; text-align: center; margin-top:200; color:#d0d0d0">High School</h3>
        </div>
        <div style="position:fixed; border: 0px; border-radius: 100%; width:500; height:500; margin-left: -120; margin-top:10; background-color:rgba(0, 0, 255, 0.1)">
            <h3 style="position: relative; margin:auto; text-align: center; margin-top:200; color:#d0d0d0">Bitches</h3>
        </div>
        <div style="position:fixed; border: 0px; border-radius: 100%; width:800; height:800; margin-left:50; margin-top:-700; background-color:rgba(0, 255, 255, 0.1)">
            <h3 style="position: relative; margin:auto; text-align: center; margin-top:400; color:#d0d0d0">Concordia University</h3>
        </div> -->
        <!-- <div style="position:fixed;border:1px solid black; border-radius: 100%; width:128px; height:128px; margin-top:-64px; margin-left:-64px;"></div>
        <div style="position:fixed;border:1px solid black; border-radius: 100%; width:256px; height:256px; margin-top:-128px; margin-left:-128px;"></div>
        <div style="position:fixed;border:1px solid black; border-radius: 100%; width:512px; height:512px; margin-top:-256px; margin-left:-256px;"></div>
        <div style="position:fixed;border:1px solid black; border-radius: 100%; width:1024px; height:1024px; margin-top:-512px; margin-left:-512px;"></div> -->
        <div class="info" id="baseInfo" style="z-index: 4; position: fixed; left: 0px; top:0px; width:100%; height:300px; background-color:rgba(50, 50, 60, 0.85); visibility:visible">
            <h1 style="margin-left: 300px">Welcome to the Pies</h1>
            <h2 style="margin-left: 300px; color:#aaaaaa">Click on a pie to view it up close, click a slice to view info about that</h2>
        </div>
        <?php 
        // Friends
        $ffile = fopen("friends.json", "r") or die("death");
        $fffile = fread($ffile,filesize("friends.json"));
        fclose($ffile);
        $groups = json_decode($fffile, true)["groups"];
        // Grid
        for($x = 32; $x < 256; $x +=32) {
            echo "<div style=\"position:fixed; border: 1px solid rgb($x, $x, $x); border-radius: 100%; width: " 
            . ((256-$x)*8) ."px; height: " . ((256-$x)*8) . "px; margin-top: -" . ((256-$x)*4) . "px; margin-left: -" . ((256-$x)*4) . "px;\" onclick=\"openmenu()\"></div>";
        }
        for ($i = 0; $i < count($groups); $i++) {
            $spaceless = str_replace(" ", "", $groups[$i]["name"]);
            $xp = cos($groups[$i]["direction"]/180.0*3.14159265)*$groups[$i]["distance"] - $groups[$i]["r"];
            $yp = -sin($groups[$i]["direction"]/180.0*3.14159265)*$groups[$i]["distance"] - $groups[$i]["r"];
            echo "<div style=\"position:fixed; pointer-events:none; border: 0px; border-radius: 100%; width:".($groups[$i]["r"]*2)."; height:".($groups[$i]["r"] *2)."; margin-left: ".$xp."; margin-top:".$yp."; background-color:".$groups[$i]["color"]."\">";
            echo "<a href=\"#\" onclick=\"openmenu('".$spaceless."')\" style=\"pointer-events: all; z-index:2;\"><h3 style=\"position: relative; margin:auto; text-align: center; margin-top:".$groups[$i]["top"]."; color:#d0d0d0\">".$groups[$i]["name"]."</h3></a></div>";


            echo "<div class=\"info\" id=\"".$spaceless."Info\"style=\"z-index: 4; position:fixed; left:0px; top: 0px; width:100%; height: 300px; background-color: rgba(50, 50, 60, 0.85); visibility:hidden\">";
            echo "<h1 style=\"margin-left: 300px\">".$groups[$i]["name"]."</h1>";
            echo "<h2 style=\"margin-left: 300px; color:#aaaaaa\">".$groups[$i]["desc"]."</h2>";
            echo "</div>";
        }
        $friends = json_decode($fffile, true)["friends"];
        for($i = 0; $i < count($friends); $i++) {
            $xp = cos($friends[$i]["direction"]/180.0*3.14159265)*$friends[$i]["distance"]*128-20;
            $yp = -sin($friends[$i]["direction"]/180.0*3.14159265)*$friends[$i]["distance"]*128-20;
            $xd = cos($friends[$i]["direction"]/180.0*3.14159265)*$friends[$i]["desire"]*128-20;
            $yd = -sin($friends[$i]["direction"]/180.0*3.14159265)*$friends[$i]["desire"]*128-20;
            echo "<div>";
            echo "<a href=\"#\" onclick=\"openmenu('".$friends[$i]["name"]."')\"><img id=\"".$friends[$i]["name"]."\" src=\"".$friends[$i]["image"]."\"style=\"margin-left:$xp; margin-top:$yp\"></a>";
            echo "<h3 style=\"position:fixed; margin-left:".($xp+ 44) ."; margin-top:". ($yp + 10) .";\">" . $friends[$i]["name"] . "</h1>";
            echo "<svg style=\"position:fixed; pointer-events:none; z-index: 3; width:".(abs($xp-$xd)+10)."; height:".(abs($yp-$yd)+10)."; margin-left:".(min($xp, $xd)+15)."; margin-top:".(min($yp, $yd)+15)."\">";
            echo "<line x1=\"".($xp-min($xp, $xd)+5)."\" y1=\"".($yp-min($yp, $yd)+5)."\" x2=\"".($xd-min($xp, $xd)+5)."\" y2=\"".($yd-min($yp, $yd)+5)."\" stroke=\"green\" stroke-width=\"3\"/>";
            echo "<ellipse cx=\"".($xd-min($xp, $xd)+5)."\" cy=\"".($yd-min($yp, $yd)+5)."\" rx=\"5\" ry=\"5\" fill=\"green\"/>";
            echo "</svg>";
            $xd = cos($friends[$i]["direction"]/180.0*3.14159265)*$friends[$i]["prediction"]*128-20;
            $yd = -sin($friends[$i]["direction"]/180.0*3.14159265)*$friends[$i]["prediction"]*128-20;
            echo "<svg style=\"position:fixed; pointer-events:none; z-index: 3; width:".(abs($xp-$xd)+10)."; height:".(abs($yp-$yd)+10)."; margin-left:".(min($xp, $xd)+15)."; margin-top:".(min($yp, $yd)+15)."\">";
            echo "<line x1=\"".($xp-min($xp, $xd)+5)."\" y1=\"".($yp-min($yp, $yd)+5)."\" x2=\"".($xd-min($xp, $xd)+5)."\" y2=\"".($yd-min($yp, $yd)+5)."\" stroke=\"orange\" stroke-width=\"3\"/>";
            echo "<ellipse cx=\"".($xd-min($xp, $xd)+5)."\" cy=\"".($yd-min($yp, $yd)+5)."\" rx=\"5\" ry=\"5\" fill=\"orange\"/>";
            echo "</svg></div>";
            echo "<div class=\"info\" id=\"".$friends[$i]["name"]."Info\"style=\"z-index: 4; position:fixed; left:0px; top: 0px; width:100%; height: 300px; background-color: rgba(50, 50, 60, 0.85); visibility:hidden\">";
            echo "<img src=\"".$friends[$i]["image"]."\" style=\"width:250px; height: 250px; margin-left: 25px; margin-top: 25px; border: 2px solid white \">";
            echo "<h1 style=\"margin-left: 300px\">".$friends[$i]["name"]."</h1>";
            echo "<h3 style=\"margin-left: 300px\">".$friends[$i]["usernames"]."</h3>";
            echo "<h2 style=\"margin-left: 300px; color:#aaaaaa\">".$friends[$i]["desc"]."</h2>";
            echo "<h5 style=\"margin-left: 300px;color:#af9060;\">".$friends[$i]["them"]."</h6>";
            // echo "<h3 style=\"position: absolute; margin-left: 50%; top: 50px; color:blue; width:50%; \">".$friends[$i]["me"]."</h1>";
            echo "<h5 style=\"position: absolute; top: 280px; color: #af9060\">Things that make them a good or bad friend (for me, not universally). Explains why they're the distance that they are</h3>";
            // echo "<h3 style=\"position: absolute; top: 300px; color: blue\">Things I've attempted, or failed to get them to the distance I want. How I feel I'm doing as a friend for them</h3>";
            // echo "<h3 style=\"position: absolute; top: 300px; color: blue\">Things I've attempted, or failed to get them to the distance I want</h3>";
            echo "</div>";
        }
        ?>
        
        <script>
            function openmenu(friend) {
                console.log("Trying to open " + friend);
                $(".info").css("visibility", "hidden");
                $("#"+friend+"Info").css("visibility", "visible");
            }
        </script>
        
    </div>
</body>

</html>
<html>
<head>
    <link rel="stylesheet" charset="utf-8" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" type="text/css">
</head>
<body style="background-color: #181a1b">
    <a href="../index" style="font-family: sans-serif; z-index: 4">go to main site</a>
    <div style="position:fixed; width:1px; height:1px; left:50%; top:50%; border:0px;">
        <img id="me" src="https://cdn.discordapp.com/avatars/396039309674807298/d254ec969ba79f0c1cc1b7d1c5a29823.png"
        style="margin-left:-20px; margin-top:-20px;">

        <div style="position:fixed; border: 0px; border-radius: 100%; width:1024; height:1024; margin-left: -1024; margin-top:-840; background-color:rgba(255, 0, 0, 0.1)">
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
        </div>
        <!-- <div style="position:fixed;border:1px solid black; border-radius: 100%; width:128px; height:128px; margin-top:-64px; margin-left:-64px;"></div>
        <div style="position:fixed;border:1px solid black; border-radius: 100%; width:256px; height:256px; margin-top:-128px; margin-left:-128px;"></div>
        <div style="position:fixed;border:1px solid black; border-radius: 100%; width:512px; height:512px; margin-top:-256px; margin-left:-256px;"></div>
        <div style="position:fixed;border:1px solid black; border-radius: 100%; width:1024px; height:1024px; margin-top:-512px; margin-left:-512px;"></div> -->
        <?php 
        // Grid
        for($x = 32; $x < 256; $x +=32) {
            echo "<div style=\"position:fixed; border: 1px solid rgb($x, $x, $x); border-radius: 100%; width: " 
            . ((256-$x)*8) ."px; height: " . ((256-$x)*8) . "px; margin-top: -" . ((256-$x)*4) . "px; margin-left: -" . ((256-$x)*4) . "px;\" onclick=\"openmenu()\"></div>";
        }
        // Friends
        $ffile = fopen("friends.json", "r") or die("death");
        $fffile = fread($ffile,filesize("friends.json"));
        fclose($ffile);
        $friends = json_decode($fffile, true)["friends"];
        for($i = 0; $i < count($friends); $i++) {
            $xp = cos($friends[$i]["direction"]/180.0*3.14159265)*$friends[$i]["distance"]*128-20;
            $yp = -sin($friends[$i]["direction"]/180.0*3.14159265)*$friends[$i]["distance"]*128-20;
            echo "<a href=\"#\" onclick=\"openmenu(".$friends[$i]["name"].")\"><img id=\"".$friends[$i]["name"]."\" src=\"".$friends[$i]["image"]."\"style=\"margin-left:$xp; margin-top:$yp\"></a>";
            echo "<h3 style=\"position:fixed; margin-left:".($xp+ 44) ."; margin-top:". ($yp + 10) .";\">" . $friends[$i]["name"] . "</h1>";
            echo "<div class=\"info\" id=\"".$friends[$i]["name"]."Info\"style=\"z-index: 3; position:fixed; left:0px; top: 0px; width:100%; height: 300px; background-color: rgba(200, 200, 200, 0.7); visibility:hidden\">";
            echo "<img src=\"".$friends[$i]["image"]."\" style=\"width:250px; height: 250px; margin-left: 25px; margin-top: 25px; border: 2px solid white \">";
            echo "<h1 style=\"margin-left: 300px\">".$friends[$i]["name"]."</h1>";
            echo "<h3 style=\"margin-left: 300px;color:yellow; width:30%;\">".$friends[$i]["them"]."</h1>";
            echo "<h3 style=\"position: absolute; margin-left: 50%; top: 50px; color:blue; width:50%; \">".$friends[$i]["me"]."</h1>";
            echo "<h3 style=\"position: absolute; top: 280px; color: yellow\">Things that make them a good or bad friend (for me, not universally). Explains why they're the distance that they are</h3>";
            echo "<h3 style=\"position: absolute; top: 300px; color: blue\">Things I've attempted, or failed to get them to the distance I want. How I feel I'm doing as a friend for them</h3>";
            // echo "<h3 style=\"position: absolute; top: 300px; color: blue\">Things I've attempted, or failed to get them to the distance I want</h3>";
            echo "</div>";
        }
        ?>
        <canvas id="canvas" style="width:100%; height:100%; position:fixed; left:0px; top:0px; z-index: 1; pointer-events: none">
        </canas>
        
        <script>
            // header('Content-Type: application/json');
            var friends;
            $.ajax({
                type: "POST",
                url: "get.php",
                data: {url: "friends.json"},
                // dataType: 'json',
                success: function (data) {
                    friends = JSON.parse(data).friends;

                    ctx = document.getElementById("canvas").getContext("2d");
                    ctx.canvas.width = window.innerWidth;
                    ctx.canvas.height = window.innerHeight;
                    
                    // ctx.beginPath();
                    ctx.fillStyle = "#2CF272";
                    ctx.strokeStyle = "#6E9262";
                    ctx.lineWidth = 2;
                    ctx.lineCap = 'round'
                    for(var i = 0; i < friends.length; i++) {
                        var x1 = Math.cos(friends[i].direction/180.0*3.14159265)*friends[i].distance*128;
                        var y1 = -Math.sin(friends[i].direction/180.0*3.14159265)*friends[i].distance*128;
                        var x2 = Math.cos(friends[i].direction/180.0*3.14159265)*friends[i].desire*128;
                        var y2 = -Math.sin(friends[i].direction/180.0*3.14159265)*friends[i].desire*128;
                        canvas_arrow(ctx, x1+window.innerWidth/2, y1+window.innerHeight/2, x2+window.innerWidth/2, y2+window.innerHeight/2, 6);
                    }
                    // ctx.strokeStyle = "#1C8971";
                    // ctx.stroke();
                }
            })
            /*function canvas_arrow(context, fromx, fromy, tox, toy) {
                var headlen = 10; // length of head in pixels
                var dx = tox - fromx;
                var dy = toy - fromy;
                var angle = Math.atan2(dy, dx);
                context.moveTo(fromx, fromy);
                context.lineTo(tox, toy);
                context.lineTo(tox - headlen * Math.cos(angle - Math.PI / 6), toy - headlen * Math.sin(angle - Math.PI / 6));
                context.moveTo(tox, toy);
                context.lineTo(tox - headlen * Math.cos(angle + Math.PI / 6), toy - headlen * Math.sin(angle + Math.PI / 6));
            }*/
            function canvas_arrow(context, fromx, fromy, tox, toy, r){
                var x_center = tox;
                var y_center = toy;

                var angle;
                var x;
                var y;

                context.beginPath();

                context.moveTo(fromx, fromy);
                context.lineTo(tox, toy);

                angle = Math.atan2(toy-fromy,tox-fromx)
                x = r*Math.cos(angle) + x_center;
                y = r*Math.sin(angle) + y_center;

                context.moveTo(x, y);

                angle += (1/3)*(2*Math.PI)
                x = r*Math.cos(angle) + x_center;
                y = r*Math.sin(angle) + y_center;

                context.lineTo(x, y);

                angle += (1/3)*(2*Math.PI)
                x = r*Math.cos(angle) + x_center;
                y = r*Math.sin(angle) + y_center;

                context.lineTo(x, y);

                context.closePath();

                context.fill();
                context.stroke();
            }
            
            function openmenu(friend) {
                $(".info").css("visibility", "hidden");
                $("#"+friend.id+"Info").css("visibility", "visible");
            }
        </script>
        
    </div>
</body>

</html>
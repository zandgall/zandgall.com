<link rel="stylesheet" href="<?php echo $ROOT?>ross/gen/build.css">
</head>
<body>
    <?php
        $json_file = file_get_contents("../ross/data.json");
        $data = json_decode($json_file, true);
        $events = $data["events"];
        $event = $events[$EVENT_ID];
        echo "
        <main>
        <section id='card' class='mcbg'>
            <img id='thumbnail' src='".$event["thumbnail"]."'>
            <div>
                <div class='header'><p>Server:</p></div>
                <div class='text'><p>".$event["server"]."</p></div>
            </div>
            <div>
                <div class='header'><p>Type:</p></div>
                <div class='text'><p>".$event["type"]."</p></div>
            </div>
            <div>
                <div class='header'><p>Date:</p></div>
                <div class='text'><p>".$event["date"]."</p></div>
            </div>";
            if ($event["type"] == "Extended Event")
                echo "<div>
                    <div class='header'><p>Ending:</p></div>
                    <div class='text'><p>".$event["ending"]."</p></div>
                </div>";
            echo "<div>
                <div class='header'><p>Involved:</p></div>
                <div class='text'><p>";
            for($i = 0; $i < count($event["involved"]); $i++) {
                echo $event["involved"][$i];
                if($i < count($event["involved"])-1)
                    echo ", ";
            }
            echo "</p></div>
            </div>
        </section>";
        echo "<h1 id='Name'>{$event["name"]}</h1>";
        echo "<p id='Description'>".format($event["description"], $data, "p")."</p></main>";
        if(count($event["images"])>0) {
            echo "<h2 id='Gallery'>Gallery</h2>
            <section id='Images'>";
            for($i = 0; $i < count($event["images"]); $i++) {
                echo "
                <div class='img-container' id='image".$i."'>
                    <div class='overlay'></div>";
                    if (str_ends_with($event["images"][$i]["src"], "mp4")) {
                        echo "<video autoplay muted loop><source src='{$event["images"][$i]["src"]}' type='video/mp4'></video>";
                    } else
                        echo "<img src='".$event["images"][$i]["src"]."' alt='".$event["images"][$i]["caption"]."'>";
                    echo "<p class='caption'>".format($event["images"][$i]["caption"], $data, "p")."</p>
                </div>";
            }
            echo "</section>";
        }
    ?>
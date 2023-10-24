<?php
        $json_file = file_get_contents("../ross/data.json");
        $data = json_decode($json_file, true);
        $builds = $data["builds"];
        $build = $builds[$BUILD_ID];
    echo "<title>{$build["server"]} - {$build["name"]}</title>";
?>
    <link rel="stylesheet" href="<?php echo $ROOT?>ross/gen/build.css">
</head>
<body>
    <?php
        echo "
        <main>
        <section id='card' class='mcbg'>
            <img id='thumbnail' src='".$build["thumbnail"]."'>
            <div>
                <div class='header'><p>Server:</p></div>
                <div class='text'><p>".$build["server"]."</p></div>
            </div>
            <div>
                <div class='header'><p>Type:</p></div>
                <div class='text'><p>".$build["type"]."</p></div>
            </div>
            <div>
                <div class='header'><p>Coordinates:</p></div>
                <div class='text'><p>(".$build["coordinates"][0].", ".$build["coordinates"][1].", ".$build["coordinates"][2].")</p></div>
            </div>
            <div>
                <div class='header'><p>Constructed:</p></div>
                <div class='text'><p>".$build["constructed"]."</p></div>
            </div>
            <div>
                <div class='header'><p>".(count($build["builders"]) > 1 ? "Builders:" : "Builder:")."</p></div>
                <div class='text'><p>";
            for($i = 0; $i < count($build["builders"]); $i++) {
                echo $build["builders"][$i];
                if($i < count($build["builders"])-1)
                    echo ", ";
            }
            echo "</p></div>
            </div>
        </section>";
        echo "<h1 id='Name'>".$build["name"]."</h1>";
        echo "<p id='Description'>".format($build["description"], $data, "p")."</p></main>";
        if(count($build["images"])>0) {
            echo "<h2 id='Gallery'>Gallery</h2>
            <section id='Images'>";
            for($i = 0; $i < count($build["images"]); $i++) {
                echo "
                <div class='img-container' id='image".$i."'>
                    <div class='overlay'></div>";
                if (str_ends_with($build["images"][$i]["src"], "mp4")) {
                    echo "<video autoplay muted loop><source src='{$build["images"][$i]["src"]}' type='video/mp4'></video>";
                } else
                    echo "<img src='".$build["images"][$i]["src"]."' alt='".$build["images"][$i]["caption"]."'>";

                echo "<p class='caption'>".format($build["images"][$i]["caption"], $data, "p")."</p>
                </div>";
            }
            echo "</section>";
        }
    ?>
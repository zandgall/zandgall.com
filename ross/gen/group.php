<?php
        $json_file = file_get_contents("../ross/data.json");
        $data = json_decode($json_file, true);
        $groups = $data["groups"];
        $group = $groups[$GROUP_ID];
    echo "<title>Group - {$group["name"]}</title>";
?>
    <link rel="stylesheet" href="<?php echo $ROOT?>ross/gen/group.css">
</head>
<body>
    <?php
        echo "
        <main>
            <img id='thumbnail' src='".$group["thumbnail"]."'>";

            // <div>
            //     <div class='header'><p>".(count($group["builders"]) > 1 ? "Builders:" : "Builder:")."</p></div>
            //     <div class='text'><p>";
            // for($i = 0; $i < count($group["builders"]); $i++) {
            //     echo $group["builders"][$i];
            //     if($i < count($group["builders"])-1)
            //         echo ", ";
            // }
            // echo "</p></div>
            // </div>";
        echo "<h1 id='Name'>".$group["name"]."</h1>
        <p id='Description'>".format($group["description"], $data, "p")."</p>
        <p>Est. ".$group["start-date"].($group["end-date"]!="" ? " - ".$group["end-date"] : "")."</p>
        <h1>Members</h1>
        <section class='selection'>";
        for($i = 0; $i < count($group["members"]); $i++) {
            echo "<a class='select-link' href='{$group["members"][$i]}'><div class='select mcbg'>
                <h1>{$group["members"][$i]}</h1>
                <img src='skins/{$group["members"][$i]}.png' alt=\"{$group["members"][$i]}'s skin\">
            </div></a>";
        }
        if(count($group["builds"])>0 && $group["builds"][0]!="") {
            echo "</section>
            <h1>Builds</h1>
            <section class='selection'>";
            for($i = 0; $i < count($group["builds"]); $i++) {
                echo "<a class='select-link' href='{$data["builds"][$group["builds"][$i]]["page"]}'><div class='select mcbg'>
                    <h2>{$data["builds"][$group["builds"][$i]]["name"]}</h2>
                    <img src='{$data["builds"][$group["builds"][$i]]["thumbnail"]}' alt=\"{$data["builds"][$group["builds"][$i]]["name"]} thumbnail\">
                </div></a>";
            }
        }
        if(count($group["events"]) > 0 && $group["events"][0]!="") {
            echo "</section>
            <h1>Events</h1>
            <section class='selection'>";
            for($i = 0; $i < count($group["events"]); $i++) {
                echo "<a class='select-link' href='{$data["events"][$group["events"][$i]]["page"]}'><div class='select mcbg'>
                    <h2>{$data["events"][$group["events"][$i]]["name"]}</h2>
                    <img src='{$data["events"][$group["events"][$i]]["thumbnail"]}' alt=\"{$data["events"][$group["events"][$i]]["name"]} thumbnail\">
                </div></a>";
            }
        }
        echo "</section>";

        if(count($group["images"])>0) {
            echo "</main><h2 id='Gallery'>Gallery</h2>
            <section id='Images'>";
            for($i = 0; $i < count($group["images"]); $i++) {
                echo "
                <div class='img-container' id='image".$i."'>
                    <div class='overlay'></div>";
                if (str_ends_with($group["images"][$i]["src"], "mp4")) {
                    echo "<video autoplay muted loop><source src='{$group["images"][$i]["src"]}' type='video/mp4'></video>";
                } else
                    echo "<img src='".$group["images"][$i]["src"]."' alt='".$group["images"][$i]["caption"]."'>";

                echo "<p class='caption'>".format($group["images"][$i]["caption"], $data, "p")."</p>
                </div>";
            }
            echo "</section>";
        }
    ?>
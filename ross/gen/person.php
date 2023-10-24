<?php
        $json_file = file_get_contents("../ross/data.json");
        $data = json_decode($json_file, true);
        $people = $data["people"];
        $person = $people[$PERSON_ID];
    echo "<title>Player - $PERSON_ID</title>";
?>
    <link rel="stylesheet" href="<?php echo $ROOT?>ross/gen/group.css">
</head>
<body>
    <?php
        echo "
        <main>
        <h1 id='Name'>$PERSON_ID</h1>
        <img id='thumbnail' src='".$person["thumbnail"]."'><br>
        <p id='Description'>".format($person["description"], $data, "p")."</p><br>
        <p>Member from ".$person["join-date"].($person["leave-date"]!="" ? " - ".$person["leave-date"] : "")."</p><br>";
        if(isset($person["controversies"]) && $person["controversies"]!="") {
            echo "<h1>Controversies</h1><p>".format($person["controversies"], $data, "p")."</p>";
        }
        if(isset($person["groups"]) && $person["groups"][0]!="") {
        echo "<h1>Groups</h1>
            <section class='selection'>";
            for($i = 0; $i < count($person["groups"]); $i++) {
                echo "<a class='select-link' href='{$data["groups"][$person["groups"][$i]]["page"]}'><div class='select mcbg'>
                    <h1>{$data["groups"][$person["groups"][$i]]["name"]}</h1>
                    <img src='{$data["groups"][$person["groups"][$i]]["thumbnail"]}' alt=\"{$data["groups"][$person["groups"][$i]]["name"]}\">
                </div></a>";
            }
        }
        foreach($data["servers"] as $name => $server) {
            if(count($person["builds"][$name])>0 && $person["builds"][$name][0]!="") {
                echo "</section>
                <h1>$name Builds</h1>
                <section class='selection'>";
                for($i = 0; $i < count($person["builds"][$name]); $i++) {
                    echo "<a class='select-link' href='{$data["builds"][$person["builds"][$name][$i]]["page"]}'><div class='select mcbg'>
                        <h2>{$data["builds"][$person["builds"][$name][$i]]["name"]}</h2>
                        <img src='".thumb($data["builds"][$person["builds"][$name][$i]]["thumbnail"])."' alt=\"{$data["builds"][$person["builds"][$name][$i]]["name"]} thumbnail\">
                    </div></a>";
                }
            }
            if(count($person["events"][$name])>0 && $person["events"][$name][0]!="") {
                echo "</section>
                <h1>$name Events</h1>
                <section class='selection'>";
                for($i = 0; $i < count($person["events"][$name]); $i++) {
                    echo "<a class='select-link' href='{$data["events"][$person["events"][$name][$i]]["page"]}'><div class='select mcbg'>
                        <h2>{$data["events"][$person["events"][$name][$i]]["name"]}</h2>
                        <img src='".thumb($data["events"][$person["events"][$name][$i]]["thumbnail"])."' alt=\"{$data["events"][$person["events"][$name][$i]]["name"]} thumbnail\">
                    </div></a>";
                }
            }
        }
        echo "</section>";
    ?>
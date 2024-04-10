<?php
    if(!isset($_GET["id"])) {
        echo "<h1>No ID set</h1>";
        return;
    }
    include "../gen/head.php";
    $json_file = file_get_contents("../data.json");
    $data = json_decode($json_file, true);
    $events = $data["events"];
    $pageName = $_GET["id"];
    $EVENT_ID = -1;
    for($i = 0; $i < count($events); $i++)
        if($events[$i]["page"]==$pageName)
            $EVENT_ID = $i;
    if($EVENT_ID==-1) {
        echo "<h1>Unknown event</h1>";
        return;
    }

    include "../gen/event.php";

    include "../gen/footer.php";
?>
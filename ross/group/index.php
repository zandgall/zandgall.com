<?php
    if(!isset($_GET["id"])) {
        echo "<h1>No ID set</h1>";
        return;
    }
    include "../gen/head.php";
    $json_file = file_get_contents("../data.json");
    $data = json_decode($json_file, true);
    $groups = $data["groups"];
    $pageName = $_GET["id"];
    $GROUP_ID = -1;
    for($i = 0; $i < count($groups); $i++)
        if($groups[$i]["page"]==$pageName)
            $GROUP_ID = $i;
    if($GROUP_ID==-1) {
        echo "<h1>Unknown group</h1>";
        return;
    }

    include "../gen/group.php";

    include "../gen/footer.php";
?>
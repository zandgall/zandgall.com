<?php
    if(!isset($_GET["id"])) {
        echo "<h1>No ID set</h1>";
        return;
    }
    include "../gen/head.php";
    $json_file = file_get_contents("../data.json");
    $data = json_decode($json_file, true);
    $builds = $data["builds"];
    $pageName = $_GET["id"];
    $BUILD_ID = -1;
    for($i = 0; $i < count($builds); $i++)
        if($builds[$i]["page"]==$pageName)
            $BUILD_ID = $i;
    if($BUILD_ID==-1) {
        echo "<h1>Unknown building</h1>";
        return;
    }

    include "../gen/build.php";

    include "../gen/footer.php";
?>
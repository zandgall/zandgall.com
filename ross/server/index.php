<?php
    if(!isset($_GET["id"])) {
        echo "<h1>No ID set</h1>";
        return;
    }
    include "../gen/head.php";
    $json_file = file_get_contents("../data.json");
    $data = json_decode($json_file, true);
    $servers = $data["servers"];
    $pageName = $_GET["id"];
    $SERVER_ID = -1;
    foreach($servers as $name => $data)
        if($data["page"]==$pageName)
            $SERVER_ID = $name;
    if($SERVER_ID==-1) {
        echo "<h1>Unknown server</h1>";
        return;
    }

    include "../gen/server.php";

    include "../gen/footer.php";
?>
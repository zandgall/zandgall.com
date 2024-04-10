<?php
    if(!isset($_GET["id"])) {
        echo "<h1>No ID set</h1>";
        return;
    }
    include "../gen/head.php";
    $PERSON_ID = $_GET["id"];
    include "../gen/person.php";

    include "../gen/footer.php";
?>
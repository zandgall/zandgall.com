<?php
session_start();

if(!isset($_SESSION["user"]) || !isset($_POST["lstSlot"]) || !isset($_POST["radType"]) || !isset($_POST["table"])) {
    http_response_code(500);
    return;
}

// Establish connection with database
$database = new mysqli('localhost', 'remote', 'mysqlCSC235', 'dbdungeonTemp');

if($database->connect_error > 0) {
    die("Could not connect to the server database: ".$database->connect_error);
}

function attemptQuery($query) {
    global $database;
    if(!$res = $database->query($query)) {
        die("Query '$query' failed! ".$database->error);
    }
    return $res;
}

$slot = $_POST["lstSlot"];
$type = $_POST["radType"];
$table = $_POST["table"];
$user = $_SESSION["user"];

// Because of the trickery going on here with $PAGE_PATH being a table name, I don't think this can be a prepared statement. But, because there is no user input, this is secure.
$pageElement = attemptQuery("SELECT Elements.id as id, Elements.element as element FROM Elements JOIN $table on $table.`$slot` = Elements.id WHERE $table.uuid = '$user'")->fetch_assoc();
$backpackElement = attemptQuery("SELECT Elements.id as id, Elements.element as element FROM Elements JOIN Backpack on Backpack.`$slot` = Elements.id WHERE Backpack.uuid = '$user'")->fetch_assoc();

if($type == "toBackpack" && isset($pageElement["element"]) && !isset($backpackElement["element"])) {
    // Same reasoning for not preparing statements here.
    attemptQuery("UPDATE Backpack SET `$slot` = '{$pageElement["id"]}' WHERE Backpack.uuid = '$user'");
    attemptQuery("UPDATE $table SET `$slot` = NULL WHERE $table.uuid = '$user'");
} else if($type == "fromBackpack" && !isset($pageElement["element"]) && isset($backpackElement["element"])) {
    attemptQuery("UPDATE $table SET `$slot` = '{$backpackElement["id"]}' WHERE $table.uuid = '$user'");
    attemptQuery("UPDATE Backpack SET `$slot` = NULL WHERE Backpack.uuid = '$user'");
}

?>
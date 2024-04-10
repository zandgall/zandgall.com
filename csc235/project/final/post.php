<?php
/*

Zander Gall - galla@csp.edu
CSC235 - Prof. Furtney

12/8/23 - Adding basic server-side form functionality 

*/

session_start();

// Check that we have all information we need
if(!(isset($_SESSION["user"]) && isset($_POST["lstSlot"]) && isset($_POST["radType"]) && isset($_POST["hidTable"]))) {
    http_response_code(500);
    return;
}

// Establish database
require_once "database.php";

echo "Established database\n";

$table = $_POST["hidTable"];
$slot = $_POST["lstSlot"];
$type = $_POST["radType"];
$user = $_SESSION["user"];

$pageElement = attemptPrep(
    "SELECT Elements.id as id, Elements.element as element FROM Elements
        JOIN $table on $table.`$slot` = Elements.id
        WHERE $table.uuid = ?",
    "s", $user
)->fetch_assoc();
$backpackElement = attemptPrep(
    "SELECT Elements.id as id, Elements.element as element FROM Elements
        JOIN Backpack on Backpack.`$slot` = Elements.id
        WHERE Backpack.uuid = ?",
    "s", $user
)->fetch_assoc();

echo "Found page and backpack element\n$slot, $user, $table, $type, ".(isset($pageElement["element"])?$pageElement["element"]:"none").", ".(isset($pageElement["element"])?$pageElement["element"]:"none")."\n";

if($type == "toBackpack" && isset($pageElement["element"]) && !isset($backpackElement["element"])) {
    attemptPrep("UPDATE Backpack SET `$slot` = ? WHERE Backpack.uuid = ?", "is", $pageElement["id"], $user);
    attemptPrep("UPDATE $table SET `$slot` = NULL WHERE $table.uuid = ?", "s", $user);
    echo "Moved to backpack\n";
    http_response_code(200);
    return;
} else if($type == "fromBackpack" && !isset($pageElement["element"]) && isset($backpackElement["element"])) {
    attemptPrep("UPDATE $table SET `$slot` = ? WHERE $table.uuid = ?", "is", $backpackElement["id"], $user);
    attemptPrep("UPDATE Backpack SET `$slot` = NULL WHERE Backpack.uuid = ?", "s", $user);
    echo "Moved from backpack\n";
    http_response_code(200);
    return;
}

// Something failed
http_response_code(500);

?>
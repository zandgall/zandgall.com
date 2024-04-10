<?php 

/*
    Zander Gall - galla@csp.edu
    CSC235 - Prof. Furtney

    12/8/23 - Migrated from pagelet.php. (Used in pagelet.php and post.php)
*/

$database = new mysqli('localhost', 'remote', 'mysqlCSC235', 'dbdungeonTemp');

if($database->connect_error > 0) {
    die("Could not connect to the server database: ".$database->connect_error);
}

// Attempt basic sql query
function attemptQuery($query) {
    global $database;
    if(!$res = $database->query($query))
        die("Query '$query' failed! ".$database->error);
    return $res;
}

// Prepare and execute query with given types and variable
function attemptPrep($prep, $types, ...$_) {
    global $database;
    $sql = $database->prepare($prep);
    $sql->bind_param($types, ...$_);
    if(!$sql->execute())
        die("Prepared Query '$prep' failed! ".$sql->error);
    return $sql->get_result();
}
?>
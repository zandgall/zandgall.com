<!-- 
    Zander Gall - galla@csp.edu
    CSC235 - Prof. Furtney

    Not a part of the assignment, but showing progress for the overall project nonetheless.

    11/17/23 - Wrote most everything
    11/19/23 - Cleaning up and adding comments
 -->

<?php 

// Using session to maintain the current user UUID across pages
session_start();
if(!isset($PAGE_PATH))
    die("Error: pagelet called from non-server source. Sorry! Not allowed behind the curtain.");

// We keep the current UUID in the $_SESSION["user"] variable. If it isn't there, default to max value.
if(!isset($_SESSION["user"]))
    $_SESSION["user"] = "ffffffff-ffff-ffff-ffff-ffffffffffff";
$user = $_SESSION["user"];

// Establish connection with database
$database = new mysqli('localhost', 'remote', 'mysqlCSC235');

if($database->connect_error > 0)
    die("Could not connect to the server database: ".$database->connect_error);

if(!$database->query("USE dbdungeonWeek3"))
    die("Could not USE the proper database: ".$database->error);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; // Print title set in actual URL?></title>
</head>
<body>
    <?php
    // Things aren't going to look very pretty at the moment, but its functional.

    // The SQL code here maybe can be cleaned up a bit, but here's how it goes.
    // Loop a number from 1 to 8, then make a call to the Elements database for elements with an ID given by the table that shares a name with the $PAGE_PATH variable
    // It finds the $PAGE_PATH table, uses the column specified by $i, and only uses it where the uuid is equal to the current session UUID
    // Once we receive an element, we just print it, as it is HTML code.
    for($i = 1; $i <= 8; $i++)
        if($result = $database->query("SELECT element FROM Elements 
                                        JOIN {$PAGE_PATH} ON {$PAGE_PATH}.`{$i}` = Elements.id 
                                        WHERE {$PAGE_PATH}.uuid = '{$user}'"))
            echo $result->fetch_assoc()["element"];

    ?>
</body>
</html>
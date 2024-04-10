<!-- 
    Zander Gall - galla@csp.edu
    CSC235 - Prof. Furtney

    Simple file that just connects to and queries a database, and writes the result of the query to a JSON file.
    12/4/23 - Added functionality
    12/9/23 - Added link to showJSONData
 -->

<?php

$database = new mysqli("localhost", "remote", "mysqlCSC235", "dbdungeonWeek6");

if($database->connect_error)
    die("Couldn't connect to database! ".$database->connect_error);

// Query all data
$result = $database->query("SELECT * FROM generic");

// Store results
$data = array();
while($row = $result->fetch_assoc()) {
    array_push($data, $row);
}

// Encode in JSON and write to file
file_put_contents("./data.json", json_encode($data));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Get JSON Data</title>
</head>
<body>
    <p>Database read, and JSON data stored!</p>
    <a href="showJSONData">Show data now</a>
</body>
</html>
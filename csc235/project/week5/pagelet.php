<!-- 
    Zander Gall - galla@csp.edu
    CSC235 - Prof. Furtney

    Week 5 pagelet. This is a combination of 'pagelet.php' from Week 3, and 'index.php' from week 4. Adding the backpack and form/interactivity to this pagelet.

    12/2/23 - Copied from pagelet. Adding and molding to fit in backpack.
 -->

<?php 
session_start();
if(!isset($PAGE_PATH))
    die("Error: pagelet called from non-server source. Sorry! Not allowed behind the curtain.");

// Grab the path to the base site level
$ROOT = str_repeat("../", substr_count($_SERVER['REQUEST_URI'], "/"));


// Establish connection with database
$database = new mysqli('localhost', 'remote', 'mysqlCSC235', 'dbdungeonWeek5');

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

// We keep the current UUID in the $_SESSION["user"] variable. If it isn't there, default to max value.
if(!isset($_SESSION["user"])) {
    echo "<!--Need to set user-->";
    // Because my server is on linux, I can use this neat built in uuid generator
    $newUser = exec('uuidgen -r');

    try {
        $sql = $database->prepare("call newUser(?)");
        $sql->bind_param("s", $newUser);
        $sql->execute();
    } catch(Exception $e) {
        die("Could not create new user :( ".$e);
    }
    $_SESSION["user"] = $newUser;
} else {
    echo "<!--User already set ({$_SESSION["user"]})-->";
    if(!$database->query("SELECT EXISTS(SELECT * FROM $PAGE_PATH WHERE uuid='{$_SESSION["user"]}') as result")->fetch_assoc()["result"]) {
        echo "User {$_SESSION["user"]} has been corrupted...";
        session_destroy();
    }
}

$user = $_SESSION["user"];

echo "<!-- {$user} -->";

// Deal with form
if(isset($_POST["hidInterface"])) {
    $slot = $_POST["lstSlot"];
    $type = $_POST["radType"];

    // Because of the trickery going on here with $PAGE_PATH being a table name, I don't think this can be a prepared statement. But, because there is no user input, this is secure.
    $pageElement = attemptQuery("SELECT Elements.id as id, Elements.element as element FROM Elements JOIN $PAGE_PATH on $PAGE_PATH.`$slot` = Elements.id WHERE $PAGE_PATH.uuid = '$user'")->fetch_assoc();
    $backpackElement = attemptQuery("SELECT Elements.id as id, Elements.element as element FROM Elements JOIN Backpack on Backpack.`$slot` = Elements.id WHERE Backpack.uuid = '$user'")->fetch_assoc();
    
    if($type == "toBackpack" && isset($pageElement["element"]) && !isset($backpackElement["element"])) {
        // Same reasoning for not preparing statements here.
        attemptQuery("UPDATE Backpack SET `$slot` = '{$pageElement["id"]}' WHERE Backpack.uuid = '$user'");
        attemptQuery("UPDATE $PAGE_PATH SET `$slot` = NULL WHERE $PAGE_PATH.uuid = '$user'");
    } else if($type == "fromBackpack" && !isset($pageElement["element"]) && isset($backpackElement["element"])) {
        attemptQuery("UPDATE $PAGE_PATH SET `$slot` = '{$backpackElement["id"]}' WHERE $PAGE_PATH.uuid = '$user'");
        attemptQuery("UPDATE Backpack SET `$slot` = NULL WHERE Backpack.uuid = '$user'");
    }
}

// Create and populate arrays with page and backpack data, to be referenced later without needing to requery sql
$pageElements = array();
$backpackElements = array();
for($i = 1; $i <= 8; $i++) {
    if($element = $database->query("SELECT * FROM Elements JOIN $PAGE_PATH ON $PAGE_PATH.`$i` = Elements.id WHERE $PAGE_PATH.uuid = '$user'")) {
        $row = $element->fetch_assoc();
        if(!isset($row["element"]))
            array_push($pageElements, array("element"=>"Empty"));
        else 
            array_push($pageElements, $row);
    }

    if($element = $database->query("SELECT * FROM Elements JOIN Backpack ON Backpack.`$i` = Elements.id WHERE Backpack.uuid = '$user'")) {
        $row = $element->fetch_assoc();
        if(!isset($row["element"]))
            array_push($backpackElements, array("element"=>"Empty"));
        else 
            array_push($backpackElements, $row);
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title;?></title>
    <link rel="stylesheet" href="<?php echo $ROOT;?>/csc235/project/week5/style.css"/>

    <!-- Load 'lato' from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300..900&display=swap" rel="stylesheet">
</head>
<body>
    <!-- Main page content goes here -->
    <main>
        <?php 
        
        for($i = 1; $i <= 8; $i++) {
            if($pageElements[$i-1]["element"]=="Empty")
                continue;

            // Use regex to find the element type
            preg_match('/<(.+?)>/', $pageElements[$i-1]["element"], $matches, PREG_OFFSET_CAPTURE);
            echo "<div id='element$i' slot='$i' class='element'>";
            echo "  <div id='element$i.header' class='header'><div></div></div>\n
                    <div>";
            echo "      {$pageElements[$i-1]["element"]}";
            echo "      <div class='info'>";
            echo "          <h1>&lt;{$matches[1][0]}&gt;</h1>";
            echo "          <h2>ID: $i</h2>";
            echo "          <p>{$pageElements[$i-1]["description"]}</p>";    
            echo "      </div>\n
                    </div>";
            echo "</div>";
        }

        ?> 
    </main>

    <!-- UI elements to follow -->
    <section id='backpack'>
        <!-- Tab that pulls out -->
        <button class='tab' onclick="toggleBackpack()"></button>

        <div id='content' onmouseenter="mouseEnteredBackpack()" onmouseleave="mouseLeftBackpack()">
            <?php
            for($i = 1; $i <= 8; $i++) {
                echo "<div id='slot$i' slot='$i' class='slot'>";
                echo "  <h1 class='header' id='slot$i.header'>$i</h1>";
                if($backpackElements[$i-1]["element"]!="Empty")
                    echo "{$backpackElements[$i-1]["element"]}";
                echo "</div>";
            }
            ?>
        </div>

    </section>

    <section id='interface'>
        <!-- Tab that pulls out -->
        <button class='tab' onclick="toggleInterface()"></button>

        <form id='interfaceForm' method="post">
            <div>
                <label for="lstSlot">Backpack - Page</label>
                <select name='lstSlot' onchange="validateTransaction()" id='lstSlot'>
                    <?php 
                    for($i = 1; $i <= 8; $i++) {
                        
                        // The default value is "Empty" (Though we loop from 1-8 inclusive, we need 0 index for array)
                        $backpackElement = $backpackElements[$i-1]["element"];
                        if($backpackElement != "Empty") {
                            // Using regex to find the element
                            preg_match('/(<.+?>)/', $backpackElement, $matches, PREG_OFFSET_CAPTURE);
                            $backpackElement = htmlentities($matches[1][0]);
                        }
                        $pageElement = $pageElements[$i-1]["element"];
                        if($pageElement != "Empty") {
                            // Using regex to find the element
                            preg_match('/(<.+?>)/', $pageElement, $matches, PREG_OFFSET_CAPTURE);
                            $pageElement = htmlentities($matches[1][0]);
                        }
                        echo "<option value='$i'>#$i: $backpackElement - $pageElement</option>";
                    }
                    ?>
                </select>
            </div>

            <div>
                <label for="toBackpack">To Backpack</label>
                <input type="radio" name="radType" value="toBackpack" id="toBackpack" onchange="validateTransaction()" checked>
            </div>
            <div>
                <label for="fromBackpack">From Backpack</label>
                <input type="radio" name="radType" value="fromBackpack" id="fromBackpack" onchange="validateTransaction()">
            </div>

            <div>
                <input type="submit" value="Move" id="interfaceSubmit">
            </div>

            <input type="hidden" name="hidInterface">
        </form>
    </section>

    <script>
        // Provide arrays with backpack and page data to be used for validating the form
        var BACKPACK = [
            <?php
            foreach($backpackElements as $bpElem)
                echo json_encode($bpElem["element"]).", ";
            ?>
        ];
        var PAGE = [
            <?php
            foreach($pageElements as $pgElem)
                echo json_encode($pgElem["element"]).", ";
            ?>
        ];
    </script>

    <script src="<?php echo $ROOT;?>/csc235/project/week5/script.js"></script>
</body>
</html>
<!-- 
    Zander Gall - galla@csp.edu
    CSC235 - Prof. Furtney

    For simplicity, I will be using a barebones database that only has an elements, backpack, and page table.
    This will exist to show off some GUI elements, including backpack, dragging, and manual (accessible) interface.
    11/25 - Began work, created HTML and CSS for backpack and interface container
    11/26 - Added client-side form logic, and JavaScript
    11/27 - Added server-side form logic and draggability
 -->

<?php

$database = new mysqli("localhost", "remote", "mysqlCSC235");
if($database->connect_error)
    die("Couldn't connect to database! ".$database->connect_error);

function attemptQuery($query) {
    global $database;
    if(!$res = $database->query($query)) {
        die("Query '$query' failed! ".$database->error);
    }
    return $res;
}

attemptQuery("use dbdungeonWeek4");

// Deal with form
if(isset($_POST["hidInterface"])) {
    $slot = $_POST["lstSlot"];
    $type = $_POST["radType"];

    $pageElement = attemptQuery("SELECT Elements.id as id, Elements.element as element FROM Elements JOIN Page on Page.`$slot` = Elements.id WHERE Page.id = '1'")->fetch_assoc();
    $backpackElement = attemptQuery("SELECT Elements.id as id, Elements.element as element FROM Elements JOIN Backpack on Backpack.`$slot` = Elements.id WHERE Backpack.id = '1'")->fetch_assoc();

    if($type == "toBackpack" && isset($pageElement["element"]) && !isset($backpackElement["element"])) {
        attemptQuery("UPDATE Backpack SET `$slot` = '{$pageElement["id"]}' WHERE Backpack.id = '1'");
        attemptQuery("UPDATE Page SET `$slot` = NULL WHERE Page.id = '1'");
    } else if($type == "fromBackpack" && !isset($pageElement["element"]) && isset($backpackElement["element"])) {
        attemptQuery("UPDATE Page SET `$slot` = '{$backpackElement["id"]}' WHERE Page.id = '1'");
        attemptQuery("UPDATE Backpack SET `$slot` = NULL WHERE Backpack.id = '1'");
    }
}

// Create and populate arrays with page and backpack data, to be referenced later without needing to requery sql
$pageElements = array();
$backpackElements = array();
for($i = 1; $i <= 8; $i++) {
    if($element = $database->query("SELECT * FROM Elements JOIN Page ON Page.`$i` = Elements.id WHERE Page.id = '1'")) {
        $row = $element->fetch_assoc();
        if(!isset($row["element"]))
            array_push($pageElements, "Empty");
        else 
            array_push($pageElements, $row["element"]);
    }

    if($element = $database->query("SELECT * FROM Elements JOIN Backpack ON Backpack.`$i` = Elements.id WHERE Backpack.id = '1'")) {
        $row = $element->fetch_assoc();
        if(!isset($row["element"]))
            array_push($backpackElements, "Empty");
        else 
            array_push($backpackElements, $row["element"]);
    }
}

?>

 <!DOCTYPE html>
 <html lang="en">
 <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Week 4 Term Project</title>
    <link rel="stylesheet" href="style.css">
 </head>
 <body>
     <!-- Main page content goes here -->
    <main>
        <?php 
        
        for($i = 1; $i <= 8; $i++) {
            if($pageElements[$i-1]!="Empty") {
                echo "<div id='element$i' slot='$i' class='element'>";
                echo "  {$pageElements[$i-1]}";
                echo "</div>";
            }
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
                echo "  <h1>$i</h1>";
                if($backpackElements[$i-1]!="Empty")
                    echo "{$backpackElements[$i-1]}";
                echo "</div>";
            }
            ?>
        </div>

    </section>

    <section id='interface'>
        <!-- Tab that pulls out -->
        <button class='tab' onclick="toggleInterface()"></button>

        <form method='post' id='interfaceForm'>
            <div>
                <label for="lstSlot">Backpack - Page</label>
                <select name='lstSlot' onchange="validateTransaction()" id='lstSlot'>
                    <?php 
                    for($i = 1; $i <= 8; $i++) {
                        
                        // The default value is "Empty" (Though we loop from 1-8 inclusive, we need 0 index for array)
                        $backpackElement = $backpackElements[$i-1];
                        if($backpackElement != "Empty") {
                            // Using regex to find the element
                            preg_match('/<(.+?)>/', $backpackElement, $matches, PREG_OFFSET_CAPTURE);
                            $backpackElement = $matches[1][0];
                        }
                        $pageElement = $pageElements[$i-1];
                        if($pageElement != "Empty") {
                            // Using regex to find the element
                            preg_match('/<(.+?)>/', $pageElement, $matches, PREG_OFFSET_CAPTURE);
                            $pageElement = $matches[1][0];
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
                echo "\"$bpElem\", ";    
            ?>
        ];
        var PAGE = [
            <?php
            foreach($pageElements as $pgElem)
                echo "\"$pgElem\", ";    
            ?>
        ];
    </script>

    <script src="script.js"></script>
 </body>
 </html>
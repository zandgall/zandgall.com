<!-- 
    Zander Gall
    For my Computer Science Class
    Professor Furtney
 -->

<?php 

/* 

Zander Gall - galla@csp.edu
CSC235 - Prof. Furtney

Putting Changelog into server comments so it is hidden from the public

12/5/23     - Creating an outline of things. Blocking out where I plan to put sections of code (that I've already mostly created)
            - Created template/helper function
12/7/23     - Slight debugging
12/8/23     - Migrated database stuff to 'database.php'
12/9-18/23  - Researched, designed, and filled out final data. Also worked on final projects for other clases that were due before this one :')
12/19/23    - 
*/

session_start();

if(!(isset($pageTable) && isset($pageTitle) && isset($pageIndex))) {
    die("Don't have the necessary variables set.");
}

// Establish database
require_once "database.php";

// Takes <element attr='...'>....</element> and returns just "<element attr='..'>". Strips images of src attributes as well
function grabElement($element) {
    if($element=="Empty")
        return $element;

    preg_match('/<.+?>/', $element, $matches, PREG_OFFSET_CAPTURE);
    $outElement = $matches[0][0];

    if(preg_match('/src=".*?"/', $outElement, $matches, PREG_OFFSET_CAPTURE)) {
        $outElement = substr($outElement, 0, $matches[0][1]).substr($outElement, $matches[0][1]+strlen($matches[0][0]));
    }

    return htmlentities($outElement);
}

// Check for user, generate new one if doesn't exist
include "user.php";

$user = $_SESSION["user"];

// Relative path to the 'dbdungeon' directory. Used to query resources from anywhere in the dungeon
$dbdungeonDir = str_repeat("../", substr_count($_SERVER['REQUEST_URI'], "/")-2);

// Create and populate arrays with page and backpack data, to be referenced later without needing to requery sql
$pageElements = array();
$backpackElements = array();
for($i = 1; $i <= 8; $i++) {
    if($element = attemptPrep("SELECT * FROM Elements JOIN $pageTable ON $pageTable.`$i` = Elements.id WHERE $pageTable.uuid = ?", "s", $user)) {
        $row = $element->fetch_assoc();
        if(!isset($row["element"]))
            array_push($pageElements, array("element"=>"Empty"));
        else 
            array_push($pageElements, $row);
    }

    if($element = attemptPrep("SELECT * FROM Elements JOIN Backpack ON Backpack.`$i` = Elements.id WHERE Backpack.uuid = ?", "s", $user)) {
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
    <title>DBDungeon - <?=$pageTitle?></title>

    <link rel="stylesheet" href="<?php echo $dbdungeonDir;?>style.css"/>

    <!-- We're using JQuery now because 'nilla JS is getting to me -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Load 'lato' from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css?family=Lato:wght@300..900&display=swap" rel="stylesheet">
</head>
<body>
    <section id="progress">
        <!-- <?=$pageIndex?> -->
        <!-- <?=$pageTable?> -->
        <!-- <?=$user?> -->
        <?php
        $sorted = attemptPrep("SELECT * FROM SortedData WHERE SortedData.id = ?", "i", $pageIndex);
        $element = attemptPrep("SELECT * FROM $pageTable WHERE $pageTable.uuid = ?", "s", $user);
        echo "<!--";
        print_r($sorted);
        echo "-->";

        echo "<!--";
        print_r($element);
        echo "-->";

        $sortedRow = $sorted->fetch_assoc();
        $elementRow = $element->fetch_assoc();
        echo "<!--";
        print_r($sortedRow);
        echo "-->";

        echo "<!--";
        print_r($elementRow);
        echo "-->";

        for($i = 1; $i <= 8; $i++) {
            $classes = "bulb";
            if((!isset($sortedRow["$i"]) && !isset($elementRow["$i"])) || $sortedRow["$i"]==$elementRow["$i"]) {
                $classes = $classes." right";
            } else {
                $classes = $classes." wrong";
            }
            if(!isset($elementRow["$i"])) {
                $classes = $classes." empty";
            }
            echo "<div class='$classes'><h1>$i</h1></div>\n";
        }
        ?>
    </section>

    <!-- Main content of page -->
    <main>
        <?php for($i = 1; $i <= 8; $i++):?>
            <?php if($pageElements[$i-1]["element"]!="Empty"): ?>
                <div id='page.<?=$i?>' slot='<?=$i?>' class='pageSlot'>
                    <div id='page.<?=$i?>.header' class='header'> <div></div> </div>
                    <div>
                        <?=$pageElements[$i-1]["element"]?>
                        <div class="info">
                            <h1><?=grabElement($pageElements[$i-1]["element"])?></h1>
                            <h2>ID: <?=$i?></h2>
                            <p><?=$pageElements[$i-1]["description"]?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        <?php endfor; ?>
    </main>

    <!-- Backpack -->
    <section id="backpack" class="out" onmouseenter="mouseEnteredBackpack()" onmouseleave="mouseLeftBackpack()">
        <button class="tab" onclick="toggle('#backpack')"></button>
        <div id="backpackContent">
            <?php for($i = 1; $i <= 8; $i++): ?>
                <div id='backpack.<?=$i?>' slot='<?=$i?>' class='backpackSlot'>
                    <h1 class='header' id='backpack.<?=$i?>.header'><?=$i?></h1>
                    <?=$backpackElements[$i-1]["element"]?>
                </div>
            <?php endfor; ?>
        </div>
    </section>

    <!-- Interface -->
    <section id="interface">
        <button class="tab" onclick="toggle('#interface')"></button>
        <form id="interfaceForm">
            <div>
                <label for="lstSlot">Backpack - Page</label>
                <select name="lstSlot" id="lstSlot" onchange="validateForm()">
                    <?php for($i = 1; $i <= 8; $i++) {

                        $pageElement = $pageElements[$i-1]["element"];
                        if($pageElement != "Empty") {
                            preg_match('/(<.+?>)/', $pageElement, $matches, PREG_OFFSET_CAPTURE);
                            $pageElement = htmlentities($matches[1][0]);
                        }

                        echo "<option value='$i'>#$i:".grabElement($backpackElements[$i-1]["element"])
                                                ." - ".grabElement($pageElements[$i-1]["element"])."</option>";
                    } ?>
                </select>
            </div>

            <div>
                <label for="toBackpack">To Backpack</label>
                <input type="radio" name="radType" value="toBackpack" id="toBackpack" onchange="validateForm()" checked>
            </div>

            <div>
                <label for="fromBackpack">From Backpack</label>
                <input type="radio" name="radType" value="fromBackpack" id="fromBackpack" onchange="validateForm()">
            </div>

            <div>
                <input type="submit" value="Move" id="interfaceSubmit">
            </div>

            <input type="hidden" name="hidTable" value="<?=$pageTable?>">
        </form>
    </section>

    <!-- Provide some server side data in the form of JavaScript variables -->
    <script>
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

        var DBDUNGEON_DIR = "<?=$dbdungeonDir?>";
    </script>

    <script src="<?=$dbdungeonDir?>script.js"></script>
</body>
</html>

<?php

// 10 hour long session lol
ini_set('session.gc_maxlifetime', 36000);
session_set_cookie_params(36000);

session_start();

include "login.php";
if(!isset($_SESSION["logged"])) {
    return;
}

// Read data
$file = file_get_contents("data.json");
$data = json_decode($file, true);

$edit = false;

if(isset($_POST["hidFormType"])) {
    switch($_POST["hidFormType"]) {
    case "classUpdated":
        // Swap old class ID with new class ID if different
        if($_POST["txtID"] != $_POST["hidClass"]) {
            $data[$_POST["txtID"]] = $data[$_POST["hidClass"]];
            unset($data[$_POST["hidClass"]]);
        }

        $data[$_POST["txtID"]]["name"] = $_POST["txtName"];
        $data[$_POST["txtID"]]["color"] = $_POST["color"];
        $edit = true;

        break;
    case "classAdded":

        // Add new class with template values
        $data["ClassID"] = array("name"=>"Class Name", "color"=>"#ff0000", "assignments"=>array());
        $edit = true;

        break;
    case "classDeleted":

        // Delete class
        unset($data[$_POST["hidClass"]]);

        break;
    case "assignmentUpdated":
        
        // Update assignment details
        $assignment = intval($_POST["hidAssignment"]);
        if($_POST["newClass"] != $_POST["hidClass"]) {
            $assignment = count($data[$_POST["newClass"]]["assignments"]);
            array_push($data[$_POST["newClass"]]["assignments"], $data[$_POST["hidClass"]]["assignments"][$_POST["hidAssignment"]]);
            array_splice($data[$_POST["hidClass"]]["assignments"], $_POST["hidAssignment"], 1);
        }
        
        $data[$_POST["newClass"]]["assignments"][$assignment]["name"] = $_POST["txtName"];
        $datetime = new DateTime($_POST["dtDue"]);
        $data[$_POST["newClass"]]["assignments"][$assignment]["due"] = $datetime->getTimestamp();
        $edit = true;

        break;
    case "assignmentAdded":

        $datetime = new DateTime(); // Get 'now'
        array_push($data[array_key_first($data)]["assignments"], array("name"=>"Assignment Name", "due"=>$datetime->getTimestamp(), "steps"=>array(), "done"=>false));
        $edit = true;

        break;
    case "assignmentDeleted":

        // Splice assignment out of its class
        array_splice($data[$_POST["hidClass"]]["assignments"], $_POST["hidAssignment"], 1);
        $edit = true;

        break;
    case "stepUpdated":

        // Update step text
        $data[$_POST["hidClass"]]["assignments"][$_POST["hidAssignment"]]["steps"][$_POST["hidStepIndex"]]["name"] = $_POST["txtStep"];
        $edit = true;

        break;
    case "stepAdded":

        // Add step to class
        array_push($data[$_POST["hidClass"]]["assignments"][$_POST["hidAssignment"]]["steps"], array("name"=>$_POST["txtStep"], "done"=>false));
        $edit = true;

        break;
    case "stepDeleted":

        // Splice step from class assignment
        array_splice($data[$_POST["hidClass"]]["assignments"][$_POST["hidAssignment"]]["steps"], $_POST["hidStepIndex"], 1);
        $edit = true; 
    
        break;
    
    /* * * * * * * * * * * *
    * ASSIGNMENT PROGRESS  *
    * * * * * * * * * * * */
    case "markComplete":
        $class = $_POST["hidClass"];
        $assignment = $_POST["hidAssignment"];

        // Mark done, and mark all steps as done
        $data[$class]["assignments"][$assignment]["done"] = true;
        for($i = 0; isset($data[$class]["assignments"][$assignment]["steps"]) && $i < count($data[$class]["assignments"][$assignment]["steps"]); $i++)
            $data[$class]["assignments"][$assignment]["steps"][$i]["done"] = true;
        
        break;
    case "updateSteps":
        $class = $_POST["hidClass"];
        $assignment = $_POST["hidAssignment"];


        $data[$class]["assignments"][$assignment]["steps"][$_POST["hidStepIndex"]]["done"] = isset($_POST["chkStep"]);
        // Go through steps and update values
        // for($i = 0; isset($data[$class]["assignments"][$assignment]["steps"]) && $i < count($data[$class]["assignments"][$assignment]["steps"]); $i++)

        // Update and write new data
        break;
    }

    file_put_contents("data.json", json_encode($data));
}


// We'll put all assignments into this array, before sorting by due-date and displaying
$assignments = array();

// Populating the assignments array
foreach($data as $className => $classData) {
    for($i = 0; $i < count($classData["assignments"]); $i++) {
        $classData["assignments"][$i]["class"] = $className;
        $classData["assignments"][$i]["index"] = $i;
        array_push($assignments, $classData["assignments"][$i]);
    }
}

// We sort by due date to get them in order from soonest to latest.
function dueSort($a, $b) {
    return $a["due"]-$b["due"];
}
usort($assignments, "dueSort");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Planner</title>
    <link rel="stylesheet" href="style.css">
</head>
<body class="<?=$edit ? "editing" : "notEditing"?>">
    <main>
        <section id="classes" class="editElement">
            <h2>Classes</h2>
            <?php foreach($data as $classID => $class):?>
            <div class='classForm'>
                <form method='post'>
                    <input type='text' name='txtID' onchange='this.form.submit()' value='<?=$classID?>'>
                    <input type='text' name='txtName' onchange='this.form.submit()' value='<?=$class["name"]?>'>
                    <input type='color' name='color' onchange='this.form.submit()' value='<?=$class["color"]?>'>
                    <input type='hidden' name='hidFormType' value='classUpdated'>
                    <input type='hidden' name='hidClass' value='<?=$classID?>'>
                </form>
                <form method='post'>
                    <input type='submit' value='X' title='Delete Class' onclick='return confirm("Are you sure? This action will delete all assignments in this class.")'>
                    <input type='hidden' name='hidFormType' value='classDeleted'>
                    <input type='hidden' name='hidClass' value='<?=$classID?>'>
                </form>
            </div>
            <?php endforeach;?>

            <form method="post" style="margin:5mm;">
                <input type="hidden" name="hidFormType" value='classAdded'>
                <input type="submit" value="+" title='Add New Class'>
            </form>
        </section>


        <h2 style="display:inline">Assignments</h2>
        <button id="toggleWriting" onclick="toggleWriting()"><img src="quill.png" width="20"/></button>

        <form method='post' style="margin-bottom:10mm">
            <input type='submit' value='+' title='Add Assignment'>
            <input type='hidden' name='hidFormType' value='assignmentAdded'>
        </form>

        <?php
        
        $preDate = new DateTime();
        $firstAssignment = true;
        ?>
        <?php foreach($assignments as $assignment):?>
            
            <?php

            if($assignment["done"])
                continue; // If this assignment is done, then skip it

            
            // Loop through and display
            $date = new DateTime();
            $date->setTimestamp($assignment["due"]);

            // If a monday was crossed, add a congratulations for making it through the week
            if(intval($date->format('W')) > intval($preDate->format('W'))) {
                if($firstAssignment) {
                    echo "<div class='week'><div><img src='party-popper.svg' width='20mm'/><p>Woo! You made it through the week! Take some time to relax.</p></div><hr></div>";
                    echo "<img class='congrats' src='confetti.gif'>";
                } else {
                    echo "<div class='week'><hr></div>";
                }
            }
            $preDate = $date;

            $firstAssignment = false;
            $class = $assignment["class"];
            ?>
            <div class='assignment<?php if($date < new DateTime()) echo " late";?>'>
                <div class='color-id' style='background-color:<?= $data[$class]["color"]; ?>'>
                    <form method='post' class="editElement">
                        <input type='text' size='30' name='txtName' value='<?=$assignment["name"];?>'>
                        <input type='datetime-local' name='dtDue' step='1' value='<?=$date->format("Y-m-d\TH:i:s")?>'>
                        <br>
                        <select name="newClass" >
                            <?php 
                            foreach($data as $classID => $classOption) {
                                echo "<option value='$classID'";
                                if($classID==$class)
                                    echo "selected";
                                echo ">{$classOption["name"]}</option>";
                            }
                            ?>
                        </select>
                        <input type="submit" value="✓">
                        <input type='hidden' name='hidAssignment' value='<?=$assignment["index"]?>'>
                        <input type='hidden' name='hidClass' value='<?=$class?>'>
                        <input type='hidden' name='hidFormType' value='assignmentUpdated'>
                    </form>
                    <form method='post' class="editElement">
                        <input type='submit' value='X' title='Delete Assignment' onclick='return confirm("Are you sure?")'>
                        <input type='hidden' name='hidAssignment' value='<?=$assignment["index"]?>'>
                        <input type='hidden' name='hidClass' value='<?=$class?>'>
                        <input type='hidden' name='hidFormType' value='assignmentDeleted'>
                    </form>
                    <div class="nonEditElement">
                        <h1><?=$assignment["name"]?></h1>
                        <h2><?=$class?> - <?=$data[$class]["name"]?></h2>
                    </div>
                </div>
            
                <div>
                <?php for($i = 0; $i < count($assignment["steps"]); $i++): ?>
                    <!--
                    
                    For every step in the assignment, we create a div. In this div is a checkbox and a label.
                    If the step is marked done, the checkbox is default checked.
                    When the checkbox is changed, it submits the form automatically.
                    
                    -->
                    
                    <div>
                        <form method='post'>
                            <input type='hidden' name='hidFormType' value='updateSteps'>
                            <input type='hidden' name='hidAssignment' value='<?=$assignment["index"]?>'>
                            <input type='hidden' name='hidClass' value='<?=$assignment["class"]?>'>
                            <input type='hidden' name='hidStepIndex' value='<?=$i?>'>
                            <input type='checkbox' name='chkStep' onchange='this.form.submit()' <?php if($assignment["steps"][$i]["done"]) echo "checked";?> >
                            <label class="nonEditElement" for="chkStep"><?=$assignment["steps"][$i]["name"]?></label>
                        </form>
                        <form method='post' class="editElement">
                            <input type='text' size='40' name='txtStep' value='<?=$assignment["steps"][$i]["name"]?>'>
                            <input type='hidden' name='hidStepIndex' value='<?=$i?>'>
                            <input type='hidden' name='hidAssignment' value='<?=$assignment["index"]?>'>
                            <input type='hidden' name='hidClass' value='<?=$class?>'>
                            <input type='hidden' name='hidFormType' value='stepUpdated'>
                        </form>
                        <form method='post' class="editElement">
                            <input type='submit' value='X'>
                            <input type='hidden' name='hidStepIndex' value='<?=$i?>'>
                            <input type='hidden' name='hidAssignment' value='<?=$assignment["index"]?>'>
                            <input type='hidden' name='hidClass' value='<?=$class?>'>
                            <input type='hidden' name='hidFormType' value='stepDeleted'>
                        </form>
                    </div>
                <?php endfor; ?>

                <form method='post' id="addStep" class="editElement">
                    <input type='text' size='40' name='txtStep'>
                    <input type='submit' value='+'>
                    <input type='hidden' name='hidAssignment' value='<?=$assignment["index"]?>'>
                    <input type='hidden' name='hidClass' value='<?=$class?>'>
                    <input type='hidden' name='hidFormType' value='stepAdded'>
                </form>
            </div>

            <!-- Create a form with hidden input that marks currently modified data. This form marks an assignment (and all its steps) as complete. -->
            <form method='post'>
                <input type='hidden' name='hidFormType' value='markComplete'>
                <input type='hidden' name='hidAssignment' value='<?=$assignment["index"]?>'>
                <input type='hidden' name='hidClass' value='<?=$class?>'>
                <input type='submit' value='Done!' />
            </form>

            <!-- Echo a human readable date & time -->
            <p class='due'>Due: <?=$date->format("Y/m/d h:i A")?></p>
        </div>
        <?php endforeach;?>
    </main>

    <script>
        var edit = <?=$edit ? "true" : "false"?>;
        function toggleWriting() {
            if(edit) {
                document.body.classList.remove("editing");
                document.body.classList.add("notEditing");
                edit = false;
            } else {
                document.body.classList.remove("notEditing");
                document.body.classList.add("editing");
                edit = true;
            }
        }
    </script>
</body>
</html>

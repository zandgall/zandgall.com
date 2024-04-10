<!-- 
    Zander Gall - galla@csp.edu
    CSC235 - Prof. Furtney

    11/24 - Coded to near completion. Started with visualization, then added form functionality.
    11/25 - Added confetti congratulations for completing a week :)
 -->

<?php

// Read data
$file = file_get_contents("data.json");
$data = json_decode($file, true);

// Handle form input
if(isset($_POST["hidMarkComplete"])) {
    $class = $_POST["hidClass"];
    $assignment = $_POST["hidAssignment"];

    $assignmentProgress = $data["students"]["galla"]["enrolled-classes"][$class]["assignment-progress"][$assignment];

    // Mark done, and mark all steps as done
    $assignmentProgress["done"] = true;
    for($i = 0; isset($assignmentProgress["steps"]) && $i < count($assignmentProgress["steps"]); $i++)
        $assignmentProgress["steps"][$i] = true;
    
    // Update and write new data
    $data["students"]["galla"]["enrolled-classes"][$class]["assignment-progress"][$assignment] = $assignmentProgress;
    file_put_contents("data.json", json_encode($data));
} else if(isset($_POST["hidUpdateSteps"])) {
    $class = $_POST["hidClass"];
    $assignment = $_POST["hidAssignment"];

    $assignmentProgress = $data["students"]["galla"]["enrolled-classes"][$class]["assignment-progress"][$assignment];

    // Go through steps and update values
    for($i = 0; $i < count($assignmentProgress["steps"]); $i++)
        $assignmentProgress["steps"][$i] = isset($_POST["chkStep$i"]);

    // Update and write new data
    $data["students"]["galla"]["enrolled-classes"][$class]["assignment-progress"][$assignment] = $assignmentProgress;
    file_put_contents("data.json", json_encode($data));
}

// We'll put all assignments into this array, before sorting by due-date and displaying
$assignments = array();

// Populating the assignments array
foreach($data["students"]["galla"]["enrolled-classes"] as $className => $classData) {
    for($i = 0; $i < count($data["classes"][$className]["assignments"]); $i++) {
        // Grab assignment data from the classes object, and then progress from the user object
        $classAssignment = $data["classes"][$className]["assignments"][$i];
        $studentProgress = $classData["assignment-progress"][$i];

        array_push($assignments, array(
            "due"=>$classAssignment["due"],
            "class"=>$className,
            "name"=>$classAssignment["name"],
            "steps"=>(array_key_exists("steps", $classAssignment) ? $classAssignment["steps"] : array()),
            "progress"=>$studentProgress,
            "index"=>$i
        ));
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
    <title>Assignments</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Welcome galla!</h1>
        <a href="./edit">Admin View</a>
    </header>
    <main>
        <h2>Assignments</h2>
        <?php
        
        $preDate = new DateTime();
        $firstAssignment = true;
        // Loop through and display
        foreach($assignments as $assignment) {

            $date = new DateTime();
            $date->setTimestamp($assignment["due"]);

            // If a monday was crossed, add a congratulations for making it through the week
            if(intval($date->format('W')) > intval($preDate->format('W'))) {
                if($firstAssignment) {
                    echo "<div class='week'><div><img src='party-popper.svg' width='20mm'/><p>Woo! You made it through the week! Take some time to relax.</p></div><hr></div>";
                    echo "<img class='congrats' src='https://i.gifer.com/6k2.gif'>";
                } else {
                    echo "<div class='week'><hr></div>";
                }
            }
            $preDate = $date;

            if($assignment["progress"]["done"])
                continue; // If this assignment is done, then skip it

            $firstAssignment = false;
            echo "<div class='assignment'>\n";
            $class = $assignment["class"];
            echo "  <div class='color-id' style='background-color:{$data["classes"][$class]["color"]}'>\n";
            echo "      <h1>{$assignment["name"]}</h1>\n";
            echo "      <h2>$class - {$data["classes"][$class]["name"]}</h2>\n";
            echo "  </div>\n";
            echo "  <form method='post'>\n";
            
            // Hidden input that marks the assignment and value.
            echo "      <input type='hidden' name='hidUpdateSteps'>\n";
            echo "      <input type='hidden' name='hidAssignment' value='{$assignment["index"]}'>\n";
            echo "      <input type='hidden' name='hidClass' value='{$assignment["class"]}'>\n";

            echo "  <div>\n";
            for($i = 0; $i < count($assignment["steps"]); $i++) {
                
                /*

                For every step in the assignment, we create a div. In this div is a checkbox and a label.
                If the step is marked done, the checkbox is default checked.
                When the checkbox is changed, it submits the form automatically.

                */

                echo "  <div>";
                echo "      <input type='checkbox' name='chkStep$i' onchange='this.form.submit()' ";

                if($assignment["progress"]["steps"][$i])
                    echo "checked";
                
                echo "          />\n";
                echo "      <label for='chkStep$i'>{$assignment["steps"][$i]}</label>\n";
                echo "  </div>";
            }
            echo "  </div>\n";
            echo "  </form>\n";

            // Create a form with hidden input that marks currently modified data. This form marks an assignment (and all its steps) as complete.
            echo "  <form method='post'>\n";
            echo "      <input type='hidden' name='hidMarkComplete'>\n";
            echo "      <input type='hidden' name='hidAssignment' value='{$assignment["index"]}'>\n";
            echo "      <input type='hidden' name='hidClass' value='{$assignment["class"]}'>\n";
            echo "      <input type='submit' value='Done!' />\n";
            echo "  </form>\n";

            // Echo a human readable date & time 
            echo "  <p class='due'>Due: ".$date->format("Y/m/d h:i A")."</p>";
            echo "</div>\n";
        }

        ?>
    </main>
</body>
</html>
<!-- 
    Zander Gall - galla@csp.edu
    CSC235 - Prof. Furtney

    11/24 - Copied everything from index.php. Formed client-side form functionality. Including auto-submitting changes to forms. Set up hidFormType switch statement for tomorrow. (No updates to database yet)
    11/25 - Added server-side form functionality, removed class list drop down, as trying to move an assignment from one class to another would have been too messy and unnecessary.
 -->

<?php

// Read data
$file = file_get_contents("data.json");
$data = json_decode($file, true);

// Handle form functionality
if(isset($_POST["hidFormType"])) {
    switch($_POST["hidFormType"]) {
    case "classUpdated":
        // Swap old class ID with new class ID if different
        if($_POST["txtID"] != $_POST["hidClass"]) {
            $data["classes"][$_POST["txtID"]] = $data["classes"][$_POST["hidClass"]];
            unset($data["classes"][$_POST["hidClass"]]);

            // If class present for student, swap with new ID (could be expanded to multiple students, but for this assignment only doing myself)
            if(isset($data["students"]["galla"]["enrolled-classes"][$_POST["hidClass"]])) {
                $data["students"]["galla"]["enrolled-classes"][$_POST["txtID"]] = $data["students"]["galla"]["enrolled-classes"][$_POST["hidClass"]];
                unset($data["students"]["galla"]["enrolled-classes"][$_POST["hidClass"]]);
            }
        }

        $data["classes"][$_POST["txtID"]]["name"] = $_POST["txtName"];
        $data["classes"][$_POST["txtID"]]["color"] = $_POST["color"];

        break;
    case "classAdded":

        // Add new class with template values
        $data["classes"]["ClassID"] = array("name"=>"Class Name", "color"=>"#ff0000", "assignments"=>array());

        // Student will be enrolled in every class, as adding enrollment would extend this assignment too much.
        $data["students"]["galla"]["enrolled-classes"]["ClassID"] = array("grade"=>"something","attendance"=>"something","assignment-progress"=>array());

        break;
    case "classDeleted":

        // Delete class
        unset($data["classes"][$_POST["hidClass"]]);

        break;
    case "assignmentUpdated":
        
        // Update assignment details
        $data["classes"][$_POST["hidClass"]]["assignments"][$_POST["hidAssignment"]]["name"] = $_POST["txtName"];
        $datetime = new DateTime($_POST["dtDue"]);
        $data["classes"][$_POST["hidClass"]]["assignments"][$_POST["hidAssignment"]]["due"] = $datetime->getTimestamp();

        break;
    case "assignmentAdded":

        $datetime = new DateTime(); // Get 'now'
        array_push($data["classes"][$_POST["hidClass"]]["assignments"], array("name"=>"Assignment Name", "due"=>$datetime->getTimestamp(), "steps"=>array()));

        // If student in class, add assignment-progress for them
        if(isset($data["students"]["galla"]["enrolled-classes"][$_POST["hidClass"]])) {
            array_push($data["students"]["galla"]["enrolled-classes"][$_POST["hidClass"]]["assignment-progress"], array("done"=>false, "steps"=>array()));
        }

        break;
    case "assignmentDeleted":

        // Splice assignment out of its class
        array_splice($data["classes"][$_POST["hidClass"]]["assignments"], $_POST["hidAssignment"], 1);

        // If student in class, splice it out of assignment-progress
        if(isset($data["students"]["galla"]["enrolled-classes"][$_POST["hidClass"]])) {
            array_splice($data["students"]["galla"]["enrolled-classes"][$_POST["hidClass"]]["assignment-progress"], $_POST["hidAssignment"], 1);
        }

        break;
    case "stepUpdated":

        // Update step text
        $data["classes"][$_POST["hidClass"]]["assignments"][$_POST["hidAssignment"]]["steps"][$_POST["hidStepIndex"]] = $_POST["txtStep"];

        break;
    case "stepAdded":

        // Add step to class
        array_push($data["classes"][$_POST["hidClass"]]["assignments"][$_POST["hidAssignment"]]["steps"], $_POST["txtStep"]);

        // If student in class, add progress marker. Set it equal to 'done', so that if the student is done with the assignment, then this step is marked done too.
        if(isset($data["students"]["galla"]["enrolled-classes"][$_POST["hidClass"]])) {
            $done = $data["students"]["galla"]["enrolled-classes"][$_POST["hidClass"]]["assignment-progress"][$_POST["hidAssignment"]]["done"];
            array_push($data["students"]["galla"]["enrolled-classes"][$_POST["hidClass"]]["assignment-progress"][$_POST["hidAssignment"]]["steps"], $done);
        }

        break;
    case "stepDeleted":

        // Splice step from class assignment
        array_splice($data["classes"][$_POST["hidClass"]]["assignments"][$_POST["hidAssignment"]]["steps"], $_POST["hidStepIndex"], 1);

        // If student in class, add progress marker. Set it equal to 'done', so that if the student is done with the assignment, then this step is marked done too.
        if(isset($data["students"]["galla"]["enrolled-classes"][$_POST["hidClass"]])) {
        array_splice($data["students"]["galla"]["enrolled-classes"][$_POST["hidClass"]]["assignment-progress"][$_POST["hidAssignment"]]["steps"], $_POST["hidStepIndex"], 1);
        }
 
        break;
    }

    file_put_contents("data.json", json_encode($data));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header>
        <h1>Welcome Admin!</h1>
        <a href="./">User View</a>
    </header>
    <main>
        <h2>Classes</h2>
        <?php 
        
        foreach($data["classes"] as $classID => $class) {
            // For every class, echo a form with two texts and color input. For ID, name, and color. If any are changed, the form is submitted, and data updated.
            echo "<div class='classForm'>\n";
            echo "  <form method='post'>\n";
            echo "      <input type='text' name='txtID' onchange='this.form.submit()' value='$classID'>\n";
            echo "      <input type='text' name='txtName' onchange='this.form.submit()' value='{$class["name"]}'>\n";
            echo "      <input type='color' name='color' onchange='this.form.submit()' value='{$class["color"]}'>\n";
            echo "      <input type='hidden' name='hidFormType' value='classUpdated'>\n";
            echo "      <input type='hidden' name='hidClass' value='$classID'>\n";
            echo "  </form>\n";
            echo "  <form method='post'>\n";
            echo "      <input type='submit' value='X' title='Delete Class' onclick='return confirm(\"Are you sure? This action will delete all assignments in this class.\")'>\n";
            echo "      <input type='hidden' name='hidFormType' value='classDeleted'>\n";
            echo "      <input type='hidden' name='hidClass' value='$classID'>\n";
            echo "  </form>\n";
            echo "</div>\n";
        }

        ?>

        <form method="post" style="margin:5mm;">
            <input type="hidden" name="hidFormType" value='classAdded'>
            <input type="submit" value="+" title='Add New Class'>
        </form>

        <h2>Assignments</h2>
        <?php
                
        $preDate = new DateTime();
        foreach($data["classes"] as $classID => $class) {
            echo "<h3>$classID</h3>";
            for($i = 0; $i < count($class["assignments"]); $i++) {
                $assignment = $class["assignments"][$i];
                $datetime = new DateTime();
                $datetime->setTimestamp($assignment["due"]);

                echo "<div class='assignment'>\n";
                
                // Update assignment name, class, or date information
                echo "  <div class='color-id' style='background-color:{$class["color"]}'>\n";
                echo "      <form method='post'>\n";
                echo "          <input type='text' size='30' name='txtName' value='{$assignment["name"]}'>\n";
                echo "          <input type='datetime-local' name='dtDue' step='1' value='{$datetime->format("Y-m-d\TH:i:s")}'>\n"; // Y-m-d\TH:i:s was the required format for it to work
                echo "          <input type='hidden' name='hidAssignment' value='$i'>\n";
                echo "          <input type='hidden' name='hidClass' value='$classID'>\n";
                echo "          <input type='hidden' name='hidFormType' value='assignmentUpdated'>\n";
                echo "      </form>\n";

                echo "      <form method='post'>\n";
                echo "          <input type='submit' value='X' title='Delete Assignment' onclick='return confirm(\"Are you sure?\")'>\n";
                echo "          <input type='hidden' name='hidAssignment' value='$i'>\n";
                echo "          <input type='hidden' name='hidClass' value='$classID'>\n";
                echo "          <input type='hidden' name='hidFormType' value='assignmentDeleted'>\n";
                echo "      </form>\n";
                echo "  </div>\n";
                echo "  <div style='margin-bottom: 5mm;'>\n";
                if(isset($assignment["steps"]))
                    for($j = 0; $j < count($assignment["steps"]); $j++) {
                        echo "  <div>";
                        echo "      <form method='post'>\n";
                        echo "          <input type='text' size='40' name='txtStep' value='{$assignment["steps"][$j]}'>\n";
                        echo "          <input type='hidden' name='hidStepIndex' value='$j'>\n";
                        echo "          <input type='hidden' name='hidAssignment' value='$i'>\n";
                        echo "          <input type='hidden' name='hidClass' value='$classID'>\n";
                        echo "          <input type='hidden' name='hidFormType' value='stepUpdated'>\n";
                        echo "      </form>\n";
                        echo "      <form method='post'>\n";
                        echo "          <input type='submit' value='X'>\n";
                        echo "          <input type='hidden' name='hidStepIndex' value='$j'>\n";
                        echo "          <input type='hidden' name='hidAssignment' value='$i'>\n";
                        echo "          <input type='hidden' name='hidClass' value='$classID'>\n";
                        echo "          <input type='hidden' name='hidFormType' value='stepDeleted'>\n";
                        echo "      </form>\n";
                        echo "  </div>\n";
                    }
                echo "      <form style='display:flex; justify-content: center; margin-top:5mm;' method='post'>\n";
                echo "          <input type='text' size='40' name='txtStep'>\n";
                echo "          <input type='submit' value='+'>\n";
                echo "          <input type='hidden' name='hidAssignment' value='$i'>\n";
                echo "          <input type='hidden' name='hidClass' value='$classID'>\n";
                echo "          <input type='hidden' name='hidFormType' value='stepAdded'>\n";
                echo "      </form>\n";
                echo "  </div>\n";
                echo "</div>\n";
            }
            echo "<form method='post'>\n";
            echo "  <input type='submit' value='+' title='Add Assignment for $classID'>\n";
            echo "  <input type='hidden' name='hidFormType' value='assignmentAdded'>\n";
            echo "  <input type='hidden' name='hidClass' value='$classID'>\n";
            echo "</form>\n";
        }

        ?>
    </main>
</body>
</html>
<!-- 
    Zander Gall - galla@csp.edu
    CSC235 - Prof. Furtney

    11/24 - Began work. Added code to display galla user's assignments, with (functionless) forms matching the completion of the assignments.
    (cont) - Finished
 -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proof of Concept</title>

    <!-- Add some basic styling, to distinguish between different assignments (border) and elements -->
    <style>
        html {
            font-family: 'Courier New', Courier, monospace
        }

        .assignment {
            border: 1px solid black;
            margin: 5mm;
        }
        .color-id {
            padding: 2mm;
        }
        .color-id h1 {
            margin-top: 0;
            margin-bottom: 0;
        }
        .color-id h2 {
            margin-top: 0;
            font-size:small;
            font-style:italic;
        }
        .due {
            margin:0;
            font-style:italic;
            font-size:smaller;
        }
    </style>
</head>
<body>
    <header>
        <h1>You're viewing this page as 'galla'</h1>
        <h2>Here you'll find your upcoming schedule</h2>
    </header>
    <main>
        <?php
        
        $file = file_get_contents("data.json");
        $data = json_decode($file, true);

        // We'll put all assignments into this array, before sorting by due-date and displaying
        $assignments = array();

        // Populating the assignments array
        foreach($data["students"]["galla"]["enrolled-classes"] as $className => $classData) {
            for($i = 0; $i < count($data["classes"][$className]["assignments"]); $i++) {
                // Grab assignment data from the classes object, and then progress from the user object
                $classAssignment = $data["classes"][$className]["assignments"][$i];
                $studentProgress = $classData["assignment-progress"][$i];

                /* Push to assignment array the key-value of 
                "due-timestamp": {
                    "class": className,
                    "name": classAssignment[name],
                    "steps": classAssignment[steps] (if present, else empty array),
                    "progress": studentProgress
                }
                */
                array_push($assignments, array(
                    "due"=>$classAssignment["due"],
                    "class"=>$className,
                    "name"=>$classAssignment["name"],
                    "steps"=>(array_key_exists("steps", $classAssignment) ? $classAssignment["steps"] : array()),
                    "progress"=>$studentProgress));
            }
        }

        // We sort by due date to get them in order from soonest to latest.
        function dueSort($a, $b) {
            return $a["due"]-$b["due"];
        }
        usort($assignments, "dueSort");
        
        // Loop through and display
        foreach($assignments as $assignment) {
            if($assignment["progress"]["done"])
                continue; // If this assignment is done, then skip it
            echo "<div class='assignment'>\n";
            $class = $assignment["class"];
            echo "<div class='color-id' style='background-color:{$data["classes"][$class]["color"]}'>\n";
            echo "<h1>{$assignment["name"]}</h1>\n";
            echo "<h2>$class - {$data["classes"][$class]["name"]}</h2>\n";
            echo "</div>\n";
            echo "<form method='post'>\n";
            for($i = 0; $i < count($assignment["steps"]); $i++) {
                $inputName = "{$assignment["class"]}.{$assignment["name"]}.$i";
                echo "<label for='$inputName'>{$assignment["steps"][$i]}</label>\n";
                echo "<input type='checkbox' name='$inputName' ";
                if($assignment["progress"]["steps"][$i])
                    echo "checked";
                echo "/><br>\n";
            }

            echo "<input type='submit' value='Mark Complete' />";
            echo "</form>\n";
            $date = new DateTime();
            $date->setTimestamp($assignment["due"]);
            echo "<p class='due'>Due: ";
            echo $date->format("Y/m/d h:i A");
            echo "</div>\n";
        }

        ?>
    </main>
</body>
</html>
<!--
  Zander Gall - galla@csp.edu
  CSC235 - Prof. Furtney

  12/1/23   - Copied from registration 1, and rewritten in my style
  12/2/23   - Debugging - It seems that the code I was supposed to copy has errors? Or functionality that is missed?
            - All is working. Moving onto term project & video.
  12/3/23   - Making Video
  -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>SunRun Registration</title>
    <link rel="stylesheet" type="text/css" href="registration.css">

    <?PHP
    $database = new mysqli("localhost", "remote", "mysqlCSC235", "prjHackerDefenseDB");
    require_once("sunRunLib.php");

    if ($database->connect_error)
        die("Couldn't connect to database! " . $database->connect_error);

    // Putting everything in a function to be able to 'return' easily
    function serverLogic() {
        global $database, $selectedRunner;
        // User selected a runner 
        if (isset($_POST['lstRunner']) && !($_POST['lstRunner'] == 'new')) {
            // Extract runner and sponsor information, and store for later
            $sql = "SELECT runner.id_runner, fName, lName, phone, gender, sponsorName 
                        FROM runner 
                        LEFT OUTER JOIN sponsor ON runner.id_runner = sponsor.id_runner 
                        WHERE runner.id_runner =" . $_POST['lstRunner'];
            $result = $database->query($sql);
            $selectedRunner = $result->fetch_assoc();
        } else {
            clearSelectedRunner();
        }

        // If no form input, return
        if(!isset($_POST["btnSubmit"]))
            return;

        // Handle form input
        switch ($_POST['btnSubmit']) {
        case 'delete':
            // If no runner selected, cancel
            if ($_POST["txtFName"] == "") {
                displayMessage("Please select a runner's name.", "red");
                break;
            }
            // Delete runner and sponsor
            // Need to prep!
            $sql = $database->prepare("DELETE FROM runner WHERE id_runner = ?");
            $sql->bind_param("i", $selectedRunner["id_runner"]);
            $result = $sql->execute();

            $sql = $database->prepare("DELETE FROM sponsor WHERE id_runner = ?");
            $sql->bind_param("i", $selectedRunner["id_runner"]);
            $result &= $sql->execute(); // Using &= so that it will be false if either query failed
            if ($result)
                displayMessage($selectedRunner['fName'] . " " . $selectedRunner['lName'] . " deleted.", "green");
            // Zero out the current selected runner
            clearSelectedRunner();
            break;
        case 'new':

            // Need to prep!
            $sql = $database->prepare("SELECT COUNT(*) AS total FROM runner WHERE fName = ? AND lName = ? AND phone = ?;");
            $temp = unformatPhone($_POST['txtPhone']); // Need to use variable for referenceability
            $sql->bind_param("sss", $_POST['txtFName'], $_POST['txtLName'], $temp);
            $sql->execute();

            $result = $sql->get_result();
            $row    = $result->fetch_assoc();

            // Runner already registered?
            if ($row['total'] > 0) {
                displayMessage("This runner is already registered.", "red");
                break;
            }

            // Check for empty name fields or phone 
            if ($_POST['txtFName'] == "" || $_POST['txtFName'] == "" || $_POST['txtPhone'] == "") {
                displayMessage("Please type in a first and last name and a phone number.", "red");
                break;
            }

            // Add runner - Need to prep!
            $sql = $database->prepare("INSERT INTO runner (id_runner, fName, lName, phone, gender) VALUES (NULL, ?, ?, ?, ?)");
            $sql->bind_param("ssss", $_POST["txtFName"], $_POST["txtLName"], $temp, $_POST["lstGender"]);
            $sql->execute();

            $result = $sql->get_result();

            // Need to prep! - Also split into two queries
            $sql = $database->prepare("SELECT id_runner FROM runner WHERE fName = ? AND lName = ?");
            $sql->bind_param("ss", $_POST["txtFName"], $_POST["txtLName"]);
            $sql->execute();
            $tempID = $sql->get_result()->fetch_assoc()["id_runner"]; // Use in next statement!
            print_r($tempID);
            $sql = $database->prepare("INSERT INTO sponsor (id_sponsor, sponsorName, id_runner) VALUES (NULL, ?, ?)");
            $sql->bind_param("si", $_POST["txtSponsor"], $tempID);
            $sql->execute();
            $result = $sql->get_result();
            // Zero out the current selected runner
            clearSelectedRunner();
            break;
        case 'update':
            // Check for empty name 
            if ($_POST['txtFName'] == "" || $_POST['txtLName'] == "") {
                displayMessage("Please select a runner's name.", "red");
                break;
            }

            // Need to prep! Using procedure that updates both the runner and the sponsor at the same time.
            // See prjHackerDefense.sql
            $sql = $database->prepare("call updateRunner(?,?,?,?,?,?)");
            $temp = unformatPhone($_POST["txtPhone"]); // Need to add extra variable for refereceability
            $sql->bind_param("isssss", $selectedRunner["id_runner"], $_POST["txtFName"], $_POST["txtLName"], $temp, $_POST["lstGender"], $_POST["txtSponsor"]);
            $result = $sql->execute();

            // If successful update the variables
            if ($result) {
                displayMessage("Update successful!", "green");
                // $selectedRunner['id_runner'] = $_POST['id_runner'];
                $selectedRunner['fName']  = $_POST['txtFName'];
                $selectedRunner['lName']  = $_POST['txtLName'];
                $selectedRunner['phone']  = unformatPhone($_POST['txtPhone']);
                $selectedRunner['gender'] = $_POST['lstGender'];
                $selectedRunner['sponsor'] = $_POST['txtSponsor'];

                // Save array as a serialized session variable
                $_SESSION['sessionThisRunner'] = urlencode(serialize($selectedRunner));
            }
            // Zero out the current selected runner
            clearSelectedRunner();
            break;
        } // end of switch( )
    }

    // If return visit.. SERVER LOGIC
    if (array_key_exists('hidIsReturning', $_POST)) {
        serverLogic();
    } else {
        // New user
        clearSelectedRunner();
    }
    ?>

</head>

<body>
    <div id="frame">
        <h1>SunRun Registration</h1>

        <form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>" method="POST" name="frmRegistration" id="frmRegistration">

            <label for="lstRunner"><strong>Select Runner's Name</strong></label>

            <select name="lstRunner" id="lstRunner" onChange="this.form.submit();">
                <option value="new">Select a name</option>
                <?PHP
                
                // Loop through the runner table to build the <option> list
                $sql = "SELECT id_runner, CONCAT(fName,' ',lName) AS 'name' 
                            FROM runner ORDER BY lName";
                $result = $database->query($sql);
                while ($row = $result->fetch_assoc()) { echo "<option value='" . $row['id_runner'] . "'>" . $row['name'] . "</option>\n"; }

                ?>
            </select>

            <a href="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">New</a>

            <br />
            <br />

            <fieldset>
                <legend>Runner's Information</legend>
                <div class="topLabel">
                    <label for="txtFName">First Name</label>
                    <input type="text" name="txtFName" id="txtFName" value="<?php echo $selectedRunner['fName']; ?>" />

                </div>

                <div class="topLabel">
                    <label for="txtLName">Last Name</label>
                    <input type="text" name="txtLName" id="txtLName" value="<?php echo $selectedRunner['lName']; ?>" />
                </div>

                <div class="topLabel">
                    <label for="txtPhone">Phone</label>
                    <input type="text" name="txtPhone" id="txtPhone" value="<?php echo formatPhone($selectedRunner['phone']); ?>" />
                </div>

                <div class="topLabel">
                    <label for="lstGender">Gender</label>
                    <select name="lstGender" id="lstGender">
                        <option value="female">Female</option>
                        <option value="male">Male</option>
                    </select>
                </div>

                <div class="topLabel">
                    <label for="txtSponsor">Sponsor</label>
                    <input type="text" name="txtSponsor" id="txtSponsor" value="<?php echo $selectedRunner['sponsorName']; ?>" />
                </div>
            </fieldset>

            <br />
            <button name="btnSubmit" value="delete" style="float:left;" onclick="this.form.submit();">
                Delete
            </button>

            <button name="btnSubmit" value="new" style="float:right;" onclick="this.form.submit();">
                Add New Runner Information
            </button>

            <button name="btnSubmit" value="update" style="float:right;" onclick="this.form.submit();">
                Update
            </button>
            <br />
            <!-- Use a hidden field to tell server if return visitor -->
            <input type="hidden" name="hidIsReturning" value="true" />
        </form>
        <br /><br />
        <h2>Registered Runners</h2>

        <?PHP
        $sql = "SELECT runner.id_runner AS 'id',
                    CONCAT(fName,' ',lName) AS 'Runner Name',
                    CONCAT(SUBSTR(phone,1,3),'-',SUBSTR(phone,4,3),'-',SUBSTR(phone,7,4)) AS 'Phone',
                    gender AS Gender,
                    sponsor.sponsorName AS 'Sponsor'
                    FROM runner
                    LEFT OUTER JOIN sponsor
                    ON runner.id_runner = sponsor.id_runner
                    ORDER BY lName";

        $result = $database->query($sql);

        if ($result->num_rows > 0) {
            
            echo "<table border='1'>\n";
            
            $heading = $result->fetch_assoc( );
            echo "<tr>\n";
            foreach($heading as $key=>$value) { echo "<th>" . $key . "</th>\n"; }
            echo "</tr>\n";
        
            // Print values for the first row
            echo "<tr>\n";
            foreach($heading as $key=>$value) { echo "<td>" . $value . "</td>\n"; }
        
            // output rest of the records
            while($row = $result->fetch_assoc()) {

                echo "<tr>\n";
                foreach($row as $key=>$value) { echo "<td>" . $value . "</td>\n"; }
                echo "</tr>\n";

            }

            echo "</table>\n";

        } else {
            echo "<strong>zero results using SQL: </strong>" . $sql;
        }
        echo "<br />";
        ?>

        <script>
            <?php if($selectedRunner['id_runner'] != "") echo "document.getElementById(\"lstRunner\").value = {$selectedRunner['id_runner']};";?>
            document.getElementById("lstGender").value = "<?PHP echo $selectedRunner['gender']; ?>";
        </script>

        <p>
            Prepared Statements are a defense against SQL injection. 
            They work by 'sanitising' any input before plugging them into a function as PHP variables, rather than raw strings of text.
            You can create a prepared statement by writing out an SQL statement, with '?' in place of any user input.
            You can then ask your Mysqli to plug in parameters, marking the types of the parameters as they go through.
            Mysqli will then confirm their types, and prevent any injections by ensuring that the input doesn't span outside of the term marked as '?' in the original statement.
        </p>
        <p>
            We cannot control what users enter into a form or piece of user input, but we can control how it is displayed, if we do display it.
            If the user were to enter HTML code for example, we could either strip all HTML tags, or display it as raw text. 
            Stripping tags can be done with the "strip_tags()" PHP function, which takes any HTML tags out of the text, unless any are present in the 'allowed_tags' list.
            Another option is to use "htmlentities()" in order to convert any HTML text into raw displayable text, like &lt;h1&gt; into &amp;lt;h&amp;gt;
        </p>
    </div>
</body>

</html>
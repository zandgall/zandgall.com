<!DOCTYPE html>
<html lang="en">
<head>
 <meta charset="utf-8">
<!-- registration.php - Register new racers - edit, delete 
  Zander Gall
  Copied: 12/1   
  Revised: Not at all (see registration2.php)
  -->
 <title>SunRun Registration</title>
<link rel="stylesheet" type="text/css" href="registration.css">

<?PHP
   // Set up connection constants
   // Using default username and password for AMPPS  
   define("SERVER_NAME","localhost");
   define("DBF_USER_NAME", "remote");
   define("DBF_PASSWORD", "mysqlCSC235");
   define("DATABASE_NAME", "sunRun");
   // Global connection object
   $conn = NULL;

   // Link to external library file
   require_once("sunRunLib.php");   
   // Connect to database
   createConnection();
    // Is this a return visit?
    if(array_key_exists('hidIsReturning',$_POST)) {
        // echo '<h1>Welcome BACK</h1>';
        echo "<hr /><strong>\$_POST: </strong>";
        print_r($_POST);

        // Did the user select a runner from the list?
        // 'new' is the value of the first item on the runner list box 
        if(isset($_POST['lstRunner']) && !($_POST['lstRunner'] == 'new')){
            // Extract runner and sponsor information
            $sql = "SELECT runner.id_runner, fName, lName, phone, gender, sponsorName 
            FROM runner 
            LEFT OUTER JOIN sponsor ON runner.id_runner = sponsor.id_runner 
            WHERE runner.id_runner =" . $_POST['lstRunner'];
            $result = $conn->query($sql);
            $row = $result->fetch_assoc();
            // Create an associative array mirroring the record in the HTML table
            // This will be used to populate the text boxes with the current runner info
            $thisRunner = [
            "id_runner" => $row['id_runner'],
            "fName" => $row['fName'],
            "lName" => $row['lName'],
            "phone" => $row['phone'],
            "gender" => $row['gender'],
            "sponsor" => $row['sponsorName']
            ];
            displayMessage("\$thisRunner Array: ", "green");
            print_r($thisRunner);
        } // end if lstRunner 
        
        
        // Determine which button may have been clicked
        switch($_POST['btnSubmit']){
        // = = = = = = = = = = = = = = = = = = = 
        // DELETE  
        // = = = = = = = = = = = = = = = = = = = 
        case 'delete':
            //displayMessage("DEBUG DELETE button pushed.", "green");
                    
            //Make sure a runner has been selected.
            if($_POST["txtFName"] == "") {
                displayMessage("Please select a runner's name.", "red");
            } else {
                // Verify the DELETE using a SELECT first
                //$sql = "SELECT * FROM runner WHERE id_runner = " . $thisRunner["id_runner"];
                //$result = $conn->query($sql);
                //displayResult($result, $sql);
                //echo "<br />"; 
                $sql = "DELETE FROM runner WHERE id_runner = " . $thisRunner["id_runner"];
                $result = $conn->query($sql);
                // Remove any records in Table:sponsor
                $sql = "DELETE FROM sponsor WHERE id_runner = " . $thisRunner["id_runner"];
                $result = $conn->query($sql); 
                if($result) {
                displayMessage($thisRunner['fName'] . " " . $thisRunner['lName'] . " deleted.", "green");
                }
            } // end of if($_POST[txtFName])
            // Zero out the current selected runner
            clearThisRunner( );
            break;
        // = = = = = = = = = = = = = = = = = = = 
        // ADD NEW RUNNER 
        // = = = = = = = = = = = = = = = = = = = 
        case 'new':
            //displayMessage("ADD NEW RUNNER button pushed.", "green");
            
            // Check for duplicate names using fName, lName, and phoneNumber
            // Hard-coded test SQL
            //$sql = "SELECT COUNT(*) AS total FROM runner 
            //WHERE fName='Fred'
            //AND   lName='Flintstone'
            //AND   phone='6667778888'";
            $sql = "SELECT COUNT(*) AS total FROM runner 
            WHERE fName='" . $_POST['txtFName'] . "'
            AND   lName='" . $_POST['txtLName'] . "'
            AND   phone='" . unformatPhone($_POST['txtPhone']) . "'";
        
            $result = $conn->query($sql);
            $row=$result->fetch_assoc();
            //echo "<hr /><strong>DEBUG Count: </strong>";
            //echo $row['total'] . "<hr />";
            
            // Runner already registered?
            if($row['total'] > 0) {
                displayMessage("This runner is already registered.", "red");
            }  
            //No duplicates
            else { 
                // Check for empty name fields or phone 
                if ($_POST['txtFName']=="" 
                    || $_POST['txtFName']==""
                    || $_POST['txtPhone']=="") {
                    displayMessage("Please type in a first and last name and a phone number.", "red");
                }
                // First name and last name are populated
                else {
                    // Add to Table:runner
                    // Hard-coded values
                    //$sql = "INSERT INTO runner (id_runner, fName, lName, phone, gender)
                    //VALUES (NULL, 'Fred', 'Flintstone', '6667778888', 'male')";
                    
                    $sql = "INSERT INTO runner (id_runner, fName, lName, phone, gender)
                    VALUES (NULL, '" 
                    . $_POST['txtFName'] ."', '" 
                    . $_POST['txtLName'] ."', '"
                    . unformatPhone($_POST['txtPhone']) ."', '"
                    . $_POST['lstGender']."')";
                    $result = $conn->query($sql);
                                
                    // Add to Table:sponsor containing the foreign key id_runner
                    // Hard-code test SELECT for compound INSERT
                    //$sql = "SELECT id_runner FROM runner WHERE fName='Fred' AND lName='Flintstone'";
                    // Variable test SELECT for compound INSERT
                    // $sql = "SELECT id_runner 
                        //FROM runner 
                        //WHERE fName='" . $_POST['txtFName'] . "' 
                        //AND lName='"   . $_POST['txtLName'] . "'";
                    //$result = $conn->query($sql);
                    //$row = $result->fetch_assoc();
                    //displayMessage("DEBUG id_runner:", "green");
                    //print_r($row);
            
                    $sql = "INSERT INTO sponsor (id_sponsor, sponsorName, id_runner) 
                    VALUES (NULL,'" .$_POST['txtSponsor'] ."', 
                    (SELECT id_runner 
                        FROM runner 
                        WHERE fName='" . $_POST['txtFName'] . "' 
                        AND lName='"   . $_POST['txtLName'] . "'
                        )
                    )";
                    $result = $conn->query($sql);   
                }
            }
            // Zero out the current selected runner
            clearThisRunner( );
             // end of if/else($total > 0)
            break;    
        // = = = = = = = = = = = = = = = = = = = 
        // UPDATE   
        // = = = = = = = = = = = = = = = = = = = 
        case 'update':
            //displayMessage("UPDATE button pushed.", "green");
            // Check for empty name 
            if ($_POST['txtFName']=="" || $_POST['txtLName']=="") {
                displayMessage("Please select a runner's name.", "red");
            }
            // First name and last name are selected
            else {
                $isSuccessful = false;
                // Update Table:runner
                // Hard-coded test SQL 
                // Make sure value for id_runner exists in Table:runner.
                //$sql = "UPDATE runner SET fName='FirstTest',
                //                          lName='LastTest',
                //                          phone='1112223333'
                //                          WHERE id_runner = 4";
                $sql = "UPDATE runner SET fName = '" . $_POST['txtFName'] . "', "
                                    . " lName  = '" . $_POST['txtLName'] . "', "
                                    . " phone  = '" . unformatPhone($_POST['txtPhone']) . "', "
                                    . " gender = '" . $_POST['lstGender'] . "' 
                                WHERE id_runner = " . $thisRunner['id_runner'];
                $result = $conn->query($sql);
                if($result) {
                    $isSuccessful = true;
                }
                // Update Table:sponsor
                // !!!! Does not update sponsor unless an entry already exists in the table !!!!
                // Test SQL
                //$sql = "UPDATE sponsor SET sponsorName='General Foods2' WHERE id_runner = 4";
                $sql = "UPDATE sponsor SET sponsorName=' " . $_POST['txtSponsor'] 
                                . "' WHERE id_runner = " . $thisRunner['id_runner'];
                $result = $conn->query($sql);
                if(!$result) {
                    $isSuccessful = false;
                }
                    // If successful update the variables
            if($isSuccessful) {
                displayMessage("Update successful!", "green");
                $thisRunner['id_runner'] = $_POST['id_runner'];
                $thisRunner['fName']  = $_POST['txtFName'];
                $thisRunner['lName']  = $_POST['txtLName'];
                $thisRunner['phone']  = unformatPhone($_POST['txtPhone']);
                $thisRunner['gender'] = $_POST['lstGender'];
                $thisRunner['sponsor']= $_POST['txtSponsor'];
        
                // Save array as a serialized session variable
                $_SESSION['sessionThisRunner'] = urlencode(serialize($thisRunner));
            }
        }
        // Zero out the current selected runner
        clearThisRunner( );
        break;
                    
       } // end of switch( )
        
    }
?>

</head>
<body>
<div id="frame">
<h1>SunRun Registration</h1>

<form action="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>"
      method="POST"
      name="frmRegistration"
      id="frmRegistration">

     <label for="lstRunner"><strong>Select Runner's Name</strong></label>

     <select name="lstRunner" id="lstRunner" onChange="this.form.submit();">
        <option value="new">Select a name</option>
        <?PHP
           // Loop through the runner table to build the <option> list
           $sql = "SELECT id_runner, CONCAT(fName,' ',lName) AS 'name' 
           FROM runner ORDER BY lName";
           $result = $conn->query($sql);
           while($row = $result->fetch_assoc()) {    
              echo "<option value='" . $row['id_runner'] . "'>" . $row['name'] . "</option>\n";
           }
        ?>
   </select> 
   &nbsp;&nbsp;<a href="<?php echo htmlentities($_SERVER['PHP_SELF']); ?>">New</a>
   <br />
   <br />
   
    <fieldset>
        <legend>Runner's Information</legend>            
        <div class="topLabel">
            <label for="txtFName">First Name</label>
            <input type="text" name="txtFName"   id="txtFName"   value="<?php echo $thisRunner['fName']; ?>" />

        </div>

        <div class="topLabel">
            <label for="txtLName">Last Name</label>
            <input type="text" name="txtLName"   id="txtLName"   value="<?php echo $thisRunner['lName']; ?>" />
        </div>

        <div class="topLabel">
            <label for="txtPhone">Phone</label>
            <input type="text" name="txtPhone"   id="txtPhone"   
                    value="<?php echo formatPhone($thisRunner['phone']); ?>" />
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
            <input type="text" name="txtSponsor" id="txtSponsor" value="<?php echo $thisRunner['sponsor']; ?>" />
        </div>
    </fieldset>
   
   <br />
   <button name="btnSubmit" 
           value="delete"
           style="float:left;"
           onclick="this.form.submit();">
           Delete
   </button>
          
   <button name="btnSubmit"    
           value="new"  
           style="float:right;"
           onclick="this.form.submit();">
           Add New Runner Information
   </button>
          
   <button name="btnSubmit" 
           value="update" 
           style="float:right;"
           onclick="this.form.submit();">
           Update
   </button>
   <br />     
  <!-- Use a hidden field to tell server if return visitor -->
  <input type="hidden" name="hidIsReturning" value="true" />
</form>
<br /><br />
<h2>Registered Runners</h2>
<!-- <table>     
   <tr>
      <th>Name</th>
      <th>Phone</th>
      <th>Gender</th>
      <th>Sponsor</th>
   </tr>

   <tr>
      <td>First Runner</td>
      <td>123-456-7890</td>
      <td>Male</td>
      <td>3M Corporation</td>
   </tr>
   <tr>
      <td>Second Runner</td>
      <td>223-256-2222</td>
      <td>Female</td>
      <td>Nike</td>
   </tr>
   <tr>
      <td>Third Runner</td>
      <td>333-256-3333</td>
      <td>Female</td>
      <td>Wells Fargo</td>
   </tr>
</table> -->

<?PHP
   displayRunnerTable( );
   echo "<br />"; 
?>


<script>
   // Insert the values from the selected runner into the text boxes
   // This code moved into the value=" " attribute of each text box 
   //document.getElementById("txtFName").value = "<?PHP echo $thisRunner['fName']; ?>";
   //document.getElementById("txtLName").value = "<?PHP echo $thisRunner['lName']; ?>";
   //document.getElementById("txtPhone").value = "<?PHP echo $thisRunner['phone']; ?>";
   //document.getElementById("txtSponsor").value = "<?PHP echo $thisRunner['sponsor']; ?>";
   
   // Update the values of the list boxes based on the current selection 
   document.getElementById("lstRunner").value = "<?PHP echo $thisRunner['id_runner']; ?>";
   document.getElementById("lstGender").value = "<?PHP echo $thisRunner['gender']; ?>";
</script>
</div>
</body>
</html>
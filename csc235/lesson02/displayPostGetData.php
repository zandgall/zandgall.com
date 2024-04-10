<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8">
<!-- displayPostGetData.php - HTML test form
  Zander Gall
  Written (Copied):   10/31/23 
  -->
 <title>Feedback to User</title>
 <link rel="stylesheet" type="text/css" href="displayData.css">
</head>
<body>
<div id="frame">

<?php 
echo "<h1>This page was created by displayPostGetData.php</h1>";

echo "Contents of the \$_POST[ ] array:<br /><pre>";
echo print_r($_POST);
echo "</pre>";

echo "Contents of the \$_GET[ ] array:<br /><pre>";
echo print_r($_GET);
echo "</pre>";

// Extract the values from the associative array

if(isset($_POST["txtName"])) {
    $txtName = $_POST["txtName"];
 }
 
 if(isset($_POST["txtEmail"])) {
    $txtEmail = $_POST["txtEmail"];
 }
 
 if(isset($_POST["txtContact"])) {
    $txtContact = $_POST["txtContact"];
 }

// Display the information

if( $txtName || $txtEmail || $txtContact)
{
   echo "<p>";
   echo "Welcome: ". $txtName. "<br />";
   echo "Your Email is: ". $txtEmail. "<br />";
   echo "Your Mobile No. is: ". $txtContact;
   echo "</p>";
}

// Extract the GET variables

if( $_GET["serverID"] || $_GET["requestedBy"])
{
   echo "<p>";
   echo "This data was input from: " . $_GET["requestedBy"] .
      " using server #" . $_GET["serverID"];
   echo "</p>";
}

?>

<p style="font-size:10px;font-weight:200;">
   This is a response page displaying information from inputData.php. If you see this page with only a header 
   and this paragraph it was probably called directly. Instead, open up <a href="inputData.php">inputData.php</a> 
   (using localhost) and click the Submit button to see the feedback on this page.
</p>

</div>
</body>
</html>
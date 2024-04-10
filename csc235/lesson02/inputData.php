<!doctype html>
<html lang="en">
<head>
 <meta charset="utf-8">
<!-- inputDataDEMO.php - HTML test form
  Zander Gall
  Written (Copied):   10/31/21 
  Based on http://www.formget.com/php-post-get/
  -->
 <title>HTML Form</title>
<link rel="stylesheet" type="text/css" href="displayData.css">
</head>
<body>
<div id="frame">
   <h1>Getting Input from the User</h1>
   
   <form action="displayPostGetData.php?serverID=123&requestedBy=inputData.php" method="POST">
      <input type="text" name="txtName" placeholder="Your Name" value="Missy Sippy"></input><br/>
      <input type="text" name="txtEmail" placeholder="Your Email" value="river@tmail.com"></input><br/>
      <input type="text" name="txtContact" placeholder="Your Mobile" value="123-456-7890"></input><br/>
      <input type="submit" name="btnSubmit" value="Submit"></input>
   </form>
</div>
</body>
</html>
<!doctype html>
<html lang="en">
<head>
 <meta charset="utf-8">
<!-- arrayLoopInput.php - Collect data for loop demonstration
  Zander Gall
  Written (Copied):   10/31/23 
  -->
 <title>ArrayLoopInput</title>
<link rel="stylesheet" type="text/css" href="displayData.css">
</head>
<body>
<div id="frame">
   <h1>Working with Arrays</h1>
   
   <form action="arrayLoopResponse.php" method="POST">
      <input type="text" name="txtName" placeholder="Your Name" value="Herman Melville"></input><br/>
      <input type="text" name="txtEmail" placeholder="Your Email" value="pequod@nantucket.com"></input><br/>
      <input type="text" name="txtPhone" placeholder="Your Mobile" value="123-456-7890"></input><br/>
      <input type="submit" name="btnSubmit" value="Submit"></input>
   </form>
</div>
</body>
</html>
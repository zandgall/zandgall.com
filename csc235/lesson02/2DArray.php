<!doctype html>
<html lang="en">
<head>
 <meta charset="utf-8">
<!-- 2DArray.php - demonstrate using a 2D array
  Zander Gall
  Written (Copied): 10/31/23 
  Revised: 
  -->
 <title>2D Array</title>
</head>
<body>
   
<?PHP
   // Establish data as a 2D array 
   $vinylCollection = array( 
    array("The Wall", "Pink Floyd", "1979", 59.99),
    array("In Through the Out Door", "Led Zeppelin", "1978", 39.98),
    array("Presence", "Led Zeppelin", "1976", 39.98),
    array("Best of the Animals", "Eric Burdon", "1966", 18.99),
    array("Dark Side of the Moon", "Pink Floyd", "1973", 25.97)
    );


?>
   <h1>Classic Vinyl</h1>
<?PHP
   // Display the data
   echo "<strong>Album:</strong> " . $vinylCollection[0][0] 
   . "  <strong>Artist:</strong> " . $vinylCollection[0][1] 
   . "<br />\n";
      echo "<hr />\n";
    
   // Display using foreach loops
   echo("<table border='1'>\n");
   foreach($vinylCollection as $key => $row) {
      // Each row in the table
      echo("<tr>\n");
      foreach($row as $col){
         // Each col in the row
         echo "<td>" . $col . "</td>\n";
      }
      echo "</tr>\n";
   }
   echo("</table>\n")
?>
   
</body>
</html>
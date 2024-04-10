<?php
   // set up several types variables
   // String
   $userName = "Wiley Coyote";
   // integer
   $userAge = 67;
   // boolean
   $roadRunnerCaught = false;
   // create an indexed array
   $characterList =  array("Road Runner", "Wiley", "Acme Corporation");
   
   // set to preformatted text
   echo "<pre>";
   // output label using escape "\" to prevent PHP parsing
   echo "\$userName: ";
   // output meta data 
   var_dump($userName);
   
   echo "\$userAge: ";
   var_dump($userAge);
  
   echo "\$roadRunnerCaught: ";
   var_dump($roadRunnerCaught);
   
   echo "Contents of \$characterList is: ";
   print_r($characterList);
   echo "<br />";
   echo $characterList . "<br />";
   echo "\$doesNotExist: " . $doesNotExist . "<br />";
   echo "</pre>";
?>
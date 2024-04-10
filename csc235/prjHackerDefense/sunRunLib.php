<?PHP

/* sunRunLib.php - library of common PHP functions

    used with SunRun registration application.

    Peter Johnson for The Learning Tree


    Edited by Zander Gall
*/


/* = = = = = = = = = = = = = = = = = = =

    Functions are in alphabetical order

    = = = = = = = = = = = = = = = = = = = = */


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

    * clearSelectedRunner( ) - Clear the array $selectedRunner

    * to automatically clear the text boxes.

    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

function clearSelectedRunner( ) {
    global $selectedRunner;
    $selectedRunner['id_runner'] = "";
    $selectedRunner['fName'] = "";
    $selectedRunner['lName'] = "";
    $selectedRunner['phone'] = "";
    $selectedRunner['gender'] = "";
    $selectedRunner['sponsorName']= "";
}



/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

    * displayMessage( ) - Display message to user

    *  Parameters: $msg - Text of the message

    *        $color - Hex color code for text as String

    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

function displayMessage($msg, $color) {
    echo "<hr /><strong style='color:" . $color . ";'>" . $msg . "</strong><hr />";
}



/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

    * formatPhone( ) - Reformat phone 123-456-0000

    * Parameter: $phoneNumber String - 10 character containing numbers

    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

function formatPhone( $phoneNumber ) {
    
    $formattedPhone = "";

    if($phoneNumber > "") {
        $formattedPhone = substr($phoneNumber,0,3) . "-" . substr($phoneNumber,3,3) . "-" . substr($phoneNumber,6,4);
    }

    return $formattedPhone;

}



/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

    * unFormatPhone( ) - Strip out all extra characters from phone string

    * Parameter $phoneNumber String - phone number with various separators

    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

function unFormatPhone( $phoneNumber ) {
    return preg_replace('/\D+/', '', $phoneNumber);
}

?>
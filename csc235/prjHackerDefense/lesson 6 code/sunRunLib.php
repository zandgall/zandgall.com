<?PHP

/* sunRunLib.php - library of common PHP functions

    used with SunRun registration application.

    Peter Johnson for The Learning Tree

*/


/* = = = = = = = = = = = = = = = = = = =

    Functions are in alphabetical order

    = = = = = = = = = = = = = = = = = = = = */


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

    * clearThisRunner( ) - Clear the array $thisRunnner

    * to automatically clear the text boxes.

    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

function clearThisRunner( ) {

    global $thisRunner;

    $thisRunner['id_runner'] = "";

    $thisRunner['fName'] = "";

    $thisRunner['lName'] = "";

    $thisRunner['phone'] = "";

    $thisRunner['gender'] = "";

    $thisRunner['sponsor']= "";

} // end of clearThisRunner( )


/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

    * createConnection( ) - Create a database connection

    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

function createConnection( ) {

    global $conn;

    // Create connection object

    $conn = new mysqli(SERVER_NAME, DBF_USER_NAME, DBF_PASSWORD);

    // Check connection

    if ($conn->connect_error) {

    die("Connection failed: " . $conn->connect_error);

    }

    // Select the database

    $conn->select_db(DATABASE_NAME);

} // end of createConnection( )



/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

    * displayMessage( ) - Display message to user

    *  Parameters: $msg - Text of the message

    *        $color - Hex color code for text as String

    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

function displayMessage($msg, $color) {

    echo "<hr /><strong style='color:" . $color . ";'>" . $msg . "</strong><hr />";

}



/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

    * displayResult( ) - Execute a query and display the result

    *  Parameters: $rs - result set to display as 2D array

    *        $sql - SQL string used to display an error msg

    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

function displayResult($result, $sql) {

    if ($result->num_rows > 0) {

    echo "<table border='1'>\n";

    // print headings (field names)

    $heading = $result->fetch_assoc( );

    echo "<tr>\n";

    // print field names

    foreach($heading as $key=>$value){

        echo "<th>" . $key . "</th>\n";

    }

    echo "</tr>\n";

    

    // Print values for the first row

    echo "<tr>\n";

    foreach($heading as $key=>$value){

        echo "<td>" . $value . "</td>\n";

    }

            

    // output rest of the records

    while($row = $result->fetch_assoc()) {

        //print_r($row);

        //echo "<br />";

        echo "<tr>\n";

        // print data

        foreach($row as $key=>$value) {

        echo "<td>" . $value . "</td>\n";

        }

        echo "</tr>\n";

    }

    echo "</table>\n";

    } else {

    echo "<strong>zero results using SQL: </strong>" . $sql;

    }

} // end of displayResult( )



/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

    * displayRunnerTable( ) - Display the runner table with sponsor name

    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

function displayRunnerTable( ) {

    global $conn;

    $sql = "SELECT runner.id_runner AS 'id',

        CONCAT(fName,' ',lName) AS 'Runner Name',

        CONCAT(SUBSTR(phone,1,3),'-',SUBSTR(phone,4,3),'-',SUBSTR(phone,7,4)) AS 'Phone',

        gender AS Gender,

        sponsor.sponsorName AS 'Sponsor'

        FROM runner

        LEFT OUTER JOIN sponsor

        ON runner.id_runner = sponsor.id_runner

        ORDER BY lName";

        

    $result = $conn->query($sql);


    displayResult($result, $sql );

} // end of displayRunnerTable( )



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

    * runQuery( ) - Execute a query and display message

    * Parameters: $sql - SQL String to be executed.

    *       $msg - Text of message to display on success or error

    *       $echoSuccess - boolean True=Display message on success

    * If $echoSuccess true: $msg successful. 

    * Error Msg Format: $msg using SQL: $sql.

    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

function runQuery($sql, $msg, $echoSuccess) {

    global $conn;

    

    // run the query

    if ($conn->query($sql) === TRUE) {

    if($echoSuccess) {

        echo $msg . " successful.<br />";

    }

    } else {

    echo "<strong>Error when: " . $msg . "</strong> using SQL: " . $sql . "<br />" . $conn->error;

    } 

} // end of runQuery( )



/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

    * unFormatPhone( ) - Strip out all extra characters from phone string

    * Parameter $phoneNumber String - phone number with various separators

    * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * */

function unFormatPhone( $phoneNumber ) {

    return preg_replace('/\D+/', '', $phoneNumber);

}

?>
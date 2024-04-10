<!-- 
    Zander Gall - galla@csp.edu
    CSC235 - Prof. Furtney

    12/4/23 - Coded to completion
    12/9/23 - Added "clear data" form and logic, and link to getJSONData
 -->

<?php

if(isset($_POST["subClearData"])) {
    file_put_contents("./data.json", "{}");
}

$data = json_decode(file_get_contents("./data.json"), true);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show JSON Data</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Text</th>
                <th>Bool</th>
                <th>Number</th>
            </tr>
        </thead>
        <tbody>
            <?php 

            foreach($data as $element) {
                echo "
                <tr>\n
                    <td>{$element["id"]}</td>\n
                    <td>{$element["text"]}</td>\n
                    <td>{$element["bool"]}</td>\n
                    <td>{$element["number"]}</td>\n
                </tr>\n
                ";
            }

            ?>
        </tbody>
    </table>

    <p>Apologies for the lack of content and creativity this week, I am trying to pool all of my creative effort into the final term project, as I do really want to get that done in a specific way.</p>
    <a href="getJSONData">Generate Data</a>
    <p>Zander Gall - <a href="https://www.zandgall.com/dbdungeon">DBDungeon*</a></p>
    <p>*DBDungeon may or may not be complete, depending on when you get to this assignment</p>

    <form method="post">
        <input type="submit" name="subClearData" value="Clear Data">
    </form>
</body>
</html>
<!--
Zander Gall galla@csp.edu
Nov 11th, 2023
Csc235 - Prof. Furtney
Session 2 Individual Weekly project
-->
<!DOCTYPE html>
<html>
<head>
    <title>Project Data Display</title>
    <link rel="stylesheet" type="text/css" href="style.css">

    <!-- Load 'lato' from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300&display=swap" rel="stylesheet">
</head>
<body>
    <?php
    // If the user is coming from a form submission, run SQL and draw tables and such.
    if(array_key_exists('hidReturn', $_POST)) {
        // password stored in external .php file not included in assignment for security
        include "../sql_password.php";
        $database = new mysqli('localhost', 'root', $password, 'csc235prjdbf');
    
        if($database->connect_errno > 0) {
            die('Unable to connect to database [' . $db->connect_error . ']');
        }
    
        // Query all items from the table that the user selects. The form select values are the literal names of the tables.
        if(!$table = $database->query("SELECT * FROM {$_POST['lstRequest']}")) {
            die("Couldn't run query: " . $database->error);
        }
    
        // Draw our table. Switch on 'lstRequest' and draw different tables depending on which list was requested.
        echo "<table>
                <caption>{$_POST['lstRequest']}</caption>";
        switch($_POST["lstRequest"]){
        case "Products":
            echo "  <thead><tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Stock</th>
                        <th>URL</th>
                        <th>Color ID</th>
                        <th>Department ID</th>
                        <th>Manufacturer ID</th>
                    </tr></thead>
                    <tbody>";
            while($row = $table->fetch_assoc())
                echo "  <tr>
                            <th>{$row['id']}</th>
                            <td>{$row['name']}</td>
                            <td>{$row['price']}</td>
                            <td>{$row['quantity']}</td>
                            <td>{$row['page']}</td>
                            <td>{$row['color']}</td>
                            <td>{$row['department']}</td>
                            <td>{$row['manufacturer']}</td>
                        </tr>";
            break;
        case "Colors":
            echo "  <thead><tr>
                        <th>ID</th>
                        <th>Name</th>
                    </tr></thead>
                    <tbody>";
            while($row = $table->fetch_assoc())
                echo "  <tr>
                            <th>{$row['id']}</th>
                            <td>{$row['name']}</td>
                        </tr>";
            break;
        case "Departments":
            echo "  <thead><tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Manager</th>
                    </tr></thead>
                    <tbody>";
            while($row = $table->fetch_assoc())
                echo "  <tr>
                            <th>{$row['id']}</th>
                            <td>{$row['name']}</td>
                            <td>{$row['manager']}</td>
                        </tr>";
            break;
        case "Manufacturers":
            echo "  <thead><tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Website</th>
                    </tr></thead>
                    <tbody>";
            while($row = $table->fetch_assoc())
                echo    "<tr>
                            <th>{$row['id']}</th>
                            <td>{$row['name']}</td>
                            <td>{$row['website']}</td>
                        </tr>";
            break;
            
        }
        // A tbody is opened in every case, so we can close it outside the switch-case.
        echo "</tbody></table>";
    }
    ?>
    <form method="post">
        <select name="lstRequest">
            <option value="Products">Products</option>
            <option value="Colors">Colors</option>
            <option value="Departments">Departments</option>
            <option value="Manufacturers">Manufacturers</option>
        </select>
        <input type="hidden" name="hidReturn"/>
        <input type="submit" name="submit" value="List items">
    </form>
    <p>
        First thing I did was design my database. Then I filled out the tables with the data in phpMyAdmin.
    </p>
    <p>
        Starting on the PHP, I first wrote the code that would connect to the database. I realized I could put all of my PHP code in the same block, instead of having a portion at the beginning and some in the middle.
    </p>
    <p>
        While writing out the form code, I realized could give the options values that exactly match the names of my database tables. This way, I could use the input to query the correct table.
    </p>
    <p>
        I made a working switch case for the products database, and then duplicated and modified that code to add displays for the other tables.
    </p>
    <p>
        Then I started work on styling.
    </p>
</body>
</html>
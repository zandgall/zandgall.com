<!-- 
    Zander Gall - galla@csp.edu
    CSC235 - Prof. Furtney

    11/17/23 - Created main functionality, showing database data, links to example pages and to createDatabase.php.
    11/19/23 - Cleaning up and commenting more thoroughly, and added new database image.
 -->

<?php 
// We are using sessions for the example pages.
session_start();

// Connect to database, define attemptQuery() function (see prjCRUD) and use this week's database.
$database = new mysqli("localhost", "remote", "mysqlCSC235");
if($database->connect_error > 0)
    die("Could not connect to database: ".$database->connect_error);

function attemptQuery($query) {
    global $database;
    if(!$result = $database->query($query))
        die("Error on '".$query."': ".$database->error);
    return $result;
}

attemptQuery("USE dbdungeonWeek3");

// If no user selected, set default user
if(!isset($_SESSION["user"]))
    $_SESSION["user"] = "ffffffff-ffff-ffff-ffff-ffffffffffff";

// If the 'user selecting form' was used
if(isset($_POST["hidSelectUser"]))
    $_SESSION["user"] = $_POST["lstUser"];

// If the 'generate user form' was used
if(isset($_POST["hidGenerateUser"])) {
    // Because my server is on linux, I can use this neat built in uuid generator
    $_SESSION["user"] = exec('uuidgen -r');

    // Create new user in Users table, and copy DefaultData into the example pages using a INSERT INTO ___ SELECT ___ statement
    attemptQuery("INSERT INTO `Users` (`uuid`, `updated`, `immutable`) VALUES ('{$_SESSION["user"]}', NOW(), FALSE)");
    attemptQuery("INSERT INTO Home SELECT '{$_SESSION["user"]}', `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8` FROM DefaultData WHERE id=1");
    attemptQuery("INSERT INTO MoreWorms SELECT '{$_SESSION["user"]}', `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8` FROM DefaultData WHERE id=2");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DBDungeon - Week 3</title>
    
    <link rel="stylesheet" href="indexStyles.css">
    
    <!-- Google Fonts request -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sometype+Mono:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">
</head>
<body>

    <!-- Information on viewing extra data -->
    <header>
        <!-- Wrapper to center everything vertically -->
        <div>
            <a href="createDatabase">Create Database</a>

            <!-- Using https://stackoverflow.com/a/48352084 to submit form on select change -->
            <form id="userForm" method="post">
                <input type="hidden" name="hidSelectUser">
                <label for="lstUser">Select User:</label>
                <select onchange="userForm.submit()" name="lstUser">

                    <?php 
                    $users = attemptQuery("SELECT uuid from Users");
                    // Add all users as options. If a user is currently selected, mark it as "selected" for the form
                    while($row = $users->fetch_assoc()) {
                        echo "<option value='{$row["uuid"]}'";
                        if($_SESSION["user"]==$row["uuid"])
                            echo "selected";
                        echo ">{$row["uuid"]}</option>";
                    }
                    ?>

                </select>
            </form>

            <!-- Add links to example pages using current user -->
            <a href="home">View 'home' as <?php echo $_SESSION["user"]; ?></a>
            <a href="moreworms">View 'moreworms' as <?php echo $_SESSION["user"]; ?></a>

            <p>
                <?php
                // Printing information about the currently selected user.
                switch($_SESSION["user"]) {
                case "ffffffff-ffff-ffff-ffff-ffffffffffff":
                    echo "This user has completed the game. Viewing the pages from their perspective will show the end result of the website, in it's 'sorted' form.";
                    break;
                case "00000000-0000-0000-0000-000000000000":
                    echo "This user has just started, viewing the pages will show that they are all jumbled up. The effect isn't quite as strong as if there were many more pages, but you can see that after the title for Earthworms, the paragraph describes Leeches. The user can use these context clues to figure out where each element goes.";
                    break;
                case "invalid!-0000-0000-0000-000000000000":
                    echo "This user wouldn't be possible with the current data, as the links can only fill an 8th slot, but illustrates something that might happen with more pages. A user might accidentally click to a page without the link to get back. In this case, the user will have to use the web browser's backwards and forwards buttons in order to travel around. We will need to refresh the page whenever the back/forwards buttons are hit, so that if the user grabs something from one page, and hits back, the previous page refreshes to make sure the data is up to date. Look at 'home' and from there follow the link to 'moreworms' to see what happens.";
                    break;
                default:
                    echo "This user is one you've generated! It has the same data as 00000000-0000-0000-0000-000000000000";
                }

                ?>
            </p>

            <!-- A generate user form that simply has a 'generate new user' button, and a hidden form flag -->
            <form name="generateUser" method="post">
                <input type="hidden" name="hidGenerateUser">
                <input type="submit" value="Generate New User">
            </form>
        </div>
    </header>

    <main>
        <!-- Print out `Elements`, just as we've done in other projects -->
        <section>
            <table border='1'>
                <thead>
                    <caption>Elements</caption>
                    <tr>
                        <th>id</th>
                        <th>slot</th>
                        <th>element</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $result = attemptQuery("SELECT id, slot, CONCAT(LEFT(element, 15), '...') as element from Elements");
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>\n";
                            echo "<td>{$row["id"]}</td>\n";
                            echo "<td>{$row["slot"]}</td>\n";
                            echo "<td>".htmlspecialchars($row['element'])."</td>\n";
                            echo "<tr>\n";
                        }
                    ?>
                </tbody>
            </table>
        </section>

        <!-- Print out DefaultData -->
        <section>
            <table border='1'>
                <thead>
                    <caption>DefaultData</caption>
                    <tr>
                        <th>id</th>
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                        <th>4</th>
                        <th>5</th>
                        <th>6</th>
                        <th>7</th>
                        <th>8</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $result = attemptQuery("SELECT * from DefaultData");
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>\n";
                            echo "<td>{$row["id"]}</td>\n";
                            echo "<td>{$row["1"]}</td>\n";
                            echo "<td>{$row["2"]}</td>\n";
                            echo "<td>{$row["3"]}</td>\n";
                            echo "<td>{$row["4"]}</td>\n";
                            echo "<td>{$row["5"]}</td>\n";
                            echo "<td>{$row["6"]}</td>\n";
                            echo "<td>{$row["7"]}</td>\n";
                            echo "<td>{$row["8"]}</td>\n";
                            echo "<tr>\n";
                        }
                    ?>
                </tbody>
            </table>
        </section>

        <!-- Print out SortedData -->
        <section>
            <table border='1'>
                <thead>
                    <caption>SortedData</caption>
                    <tr>
                        <th>id</th>
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                        <th>4</th>
                        <th>5</th>
                        <th>6</th>
                        <th>7</th>
                        <th>8</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $result = attemptQuery("SELECT * from SortedData");
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>\n";
                            echo "<td>{$row["id"]}</td>\n";
                            echo "<td>{$row["1"]}</td>\n";
                            echo "<td>{$row["2"]}</td>\n";
                            echo "<td>{$row["3"]}</td>\n";
                            echo "<td>{$row["4"]}</td>\n";
                            echo "<td>{$row["5"]}</td>\n";
                            echo "<td>{$row["6"]}</td>\n";
                            echo "<td>{$row["7"]}</td>\n";
                            echo "<td>{$row["8"]}</td>\n";
                            echo "<tr>\n";
                        }
                    ?>
                </tbody>
            </table>
        </section>

        <!-- Print out Users -->
        <section>
            <table border='1'>
                <thead>
                    <caption>Users</caption>
                    <tr>
                        <th>uuid</th>
                        <th>updated</th>
                        <th>immutable</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $result = attemptQuery("SELECT * from Users");
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>\n";
                            echo "<td>{$row["uuid"]}</td>\n";
                            echo "<td>{$row["updated"]}</td>\n";
                            echo "<td>{$row["immutable"]}</td>\n";
                            echo "<tr>\n";
                        }
                    ?>
                </tbody>
            </table>
        </section>

        <!-- Print out Home -->
        <section>
            <table border='1'>
                <thead>
                    <caption>Home</caption>
                    <tr>
                        <th>uuid</th>
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                        <th>4</th>
                        <th>5</th>
                        <th>6</th>
                        <th>7</th>
                        <th>8</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $result = attemptQuery("SELECT * from Home");
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>\n";
                            echo "<td>{$row["uuid"]}</td>\n";
                            echo "<td>{$row["1"]}</td>\n";
                            echo "<td>{$row["2"]}</td>\n";
                            echo "<td>{$row["3"]}</td>\n";
                            echo "<td>{$row["4"]}</td>\n";
                            echo "<td>{$row["5"]}</td>\n";
                            echo "<td>{$row["6"]}</td>\n";
                            echo "<td>{$row["7"]}</td>\n";
                            echo "<td>{$row["8"]}</td>\n";
                            echo "<tr>\n";
                        }
                    ?>
                </tbody>
            </table>
        </section>

        <!-- Print out MoreWorms -->
        <section>
            <table border='1'>
                <thead>
                    <caption>MoreWorms</caption>
                    <tr>
                        <th>uuid</th>
                        <th>1</th>
                        <th>2</th>
                        <th>3</th>
                        <th>4</th>
                        <th>5</th>
                        <th>6</th>
                        <th>7</th>
                        <th>8</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $result = attemptQuery("SELECT * from MoreWorms");
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>\n";
                            echo "<td>{$row["uuid"]}</td>\n";
                            echo "<td>{$row["1"]}</td>\n";
                            echo "<td>{$row["2"]}</td>\n";
                            echo "<td>{$row["3"]}</td>\n";
                            echo "<td>{$row["4"]}</td>\n";
                            echo "<td>{$row["5"]}</td>\n";
                            echo "<td>{$row["6"]}</td>\n";
                            echo "<td>{$row["7"]}</td>\n";
                            echo "<td>{$row["8"]}</td>\n";
                            echo "<tr>\n";
                        }
                    ?>
                </tbody>
            </table>
        </section>

        <section>
            <img src="database.png" alt="Updated Database design image, 11/19/23"/>
        </section>
    </main>
</body>
</html>
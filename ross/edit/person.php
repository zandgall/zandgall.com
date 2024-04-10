<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);
$ROOT = str_repeat("../", substr_count($_SERVER['REQUEST_URI'], "/"));
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Person Edit</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <meta name="description" content="A ross wiki entry">
        <meta name="author" content="Zandgall">
        <link rel="icon" href="<?php echo $ROOT?>ross/Icon.png">
        <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
<?php

$json_file = file_get_contents("../data.json");
$data = json_decode($json_file, true);

if(!isset($_GET["person"])) {
    echo "<main>";
    foreach($data["people"] as $name => $person) {
        echo "
        <a href='person?person=".$name."'>
            <div class='item'>
                <h1>$name</h1>
                <img src='../skins/$name.png' alt=\"$name's skin\">
            </div>
        </a>
        ";
    }
    echo "</main>";
    return;
}

$PERSON_ID = $_GET["person"];
$person = $data["people"][$PERSON_ID];
echo "<a href='./person'>Back to people</a><br>";
// if(file_exists("../$PERSON_ID.php"))
echo "<a href='../person/$PERSON_ID'>View result</a>";
echo "
    <form action='person-form?person=".$PERSON_ID."' method='post' enctype='multipart/form-data'>
        <label for='aka'>AKA:</label>
        <input id='aka' name='aka' type='text' value='{$person["aka"]}'><br>
        <label for='description'>Description:</label><br>
        <textarea id='description' name='description' rows='10' cols='100'>".$person["description"]."</textarea><br>
        <label for='controversies'>Controversies: (IF YOU WANT)</label><br>
        <textarea id='controversies' name='controversies' rows='10' cols='100'>".$person["controversies"]."</textarea><br>
        <img id='thumbnail-img' src='../".(isset($person["thumbnail"])?$person["thumbnail"]:"")."' alt='thumbnail'><br>
        <label for='thumbnail'>Thumbnail:</label>
        <input id='thumbnail' name='thumbnail' type='file' accept='image/png, image/jpeg, image/gif'><br>
        <label for='groups'>Groups:</label>
        <input id='groups' name='groups' type='text' value='";
        for($i = 0; $i < count($person["groups"]); $i++) {
            echo $person["groups"][$i];
            if($i < count($person["groups"])-1)
                echo ", ";
        }
        echo"' /><br>
        <h2>Events:</h2>
        <div id='events'>";
        foreach($data["servers"] as $name => $server) {
            echo "<label for='{$server["page"]}-events'>$name Events:</label>
            <input id='{$server["page"]}-events' name='$name events' type='text' value='";
            for($i = 0; $i < count($person["events"][$name]); $i++) {
                echo $person["events"][$name][$i];
                if($i < count($person["events"][$name])-1)
                    echo ", ";
            }
            echo"' /><br>";
        }
        echo "</div><br>
        <h2>Builds:</h2>
        <div id='builds'>";
        foreach($data["servers"] as $name => $server) {
            echo "<label for='{$server["page"]}-builds'>$name Builds:</label>
            <input id='{$server["page"]}-builds' name='$name builds' type='text' value='";
            for($i = 0; $i < count($person["builds"][$name]); $i++) {
                echo $person["builds"][$name][$i];
                if($i < count($person["builds"][$name])-1)
                    echo ", ";
            }
            echo"' /><br>";
        }
        echo "</div><br>
        <label for='join-date'>Join Date:</label>
        <input id='join-date' name='join-date' type='date' value='".$person["join-date"]."' /><br>

        <label for='leave-date'>Leave Date: (If N/A leave blank/00-00-0000)</label>
        <input id='leave-date' name='leave-date' type='date' value='".$person["leave-date"]."' /><br>
        
        <input type='submit' value='Publish Page'>
    </form>";
?>
    </body>
</html>
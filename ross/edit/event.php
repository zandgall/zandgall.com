<?php
$ROOT = str_repeat("../", substr_count($_SERVER['REQUEST_URI'], "/"));
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Event Edit</title>
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

include "../password.php";
$database = new mysqli('localhost', 'zandgall', $DATABASE_PASSWORD, 'RossWiki');
if($database->connect_errno > 0) {
    die('Unable to connect to database [' . $db->connect_error . ']');
}

// Simply returns the image path with "_x.16" inserted before ".png", for code shortening
function thumb16($image_path) {
    return str_replace(".png", "_x.16.png", $image_path);
}
function thumb8($image_path) {
    return str_replace(".png", "_x0.125.png", $image_path);
}
function thumb4($image_path) {
    return str_replace(".png", "_x0.25.png", $image_path);
}

$json_file = file_get_contents("../data.json");
$data = json_decode($json_file, true);

if(!isset($_GET["event"])) {
    echo "<main>
    <a href='event?event=new".(isset($_GET["nothumb"])?"&nothumb":"")."'>
            <div class='new'>
                <h1>Add New</h1>
            </div>
        </a>";
    for($i = count($data["events"])-1; $i >= 0; $i--) {
        echo "
        <a href='event?event=".$i.(isset($_GET["nothumb"])?"&nothumb":"")."'>
            <div class='item'>
                <h1>{$data["events"][$i]["name"]}</h1>
                <h2>{$data["events"][$i]["type"]}</h2>
                <h3>{$data["events"][$i]["server"]}</h3>";
        if(isset($data["events"][$i]["thumbnail"]) && $data["events"][$i]["thumbnail"]!="" && !isset($_GET["nothumb"]))
            echo "<img src='../{$data["events"][$i]["thumbnail"]}' alt='{$data["events"][$i]["name"]}'>";
        echo "</div>
        </a>
        ";
    }
    echo "
    </main>";
    return;
}

$EVENT_ID = $_GET["event"];
$event = "";
if($EVENT_ID == "new") {
    // Create new page
    $EVENT_ID = strval(count($data["events"]));
    array_push($data["events"], json_decode('{
        "page": "",
        "name": "",
        "description": "",
        "server": "",
        "thumbnail": "",
        "type": "",
        "involved": [],
        "date": "",
        "ending": "",
        "images": [],
        "locations": []
    }'));
    $upl = fopen("../data.json", "w") or die("Unable to open file!");
    fwrite($upl, json_encode($data));
    fclose($upl);

    $data = json_decode(json_encode($data), true);
}
$event = $data["events"][$EVENT_ID];
// See if the element exists in the Highlights table
if(!$table = $database->query("SELECT * FROM Highlights WHERE `type`='event' and `selection`={$EVENT_ID}")) {
    die("Couldn't run query: " . $database->error);
}
echo "<a href='./event'>Back to events</a><br>";
// if(file_exists("../".$event["page"].".php"))
echo "<a href='../event/".$event["page"]."'>View result</a>";
echo "
    <form action='event-form?event=".$EVENT_ID."' method='post' enctype='multipart/form-data'>
        <label for='name'>Name:</label>
        <input id='name' name='name' type='text' value=\"".$event["name"]."\" /><br>
        <label for='page'>Page URL:</label>
        <input id='page' name='page' type='text' value='".$event["page"]."' /><br>
        <label for='description'>Description:</label><br>
        <textarea id='description' name='description' rows='10' cols='100'>".$event["description"]."</textarea><br>
        <img id='thumbnail-img' src='../".thumb4($event["thumbnail"])."' alt='thumbnail'><br>
        <label for='thumbnail'>Thumbnail:</label>
        <input id='thumbnail' name='thumbnail' type='file' accept='image/png, image/jpeg, image/gif'><br>
        <label for='server'>Server:</label>
        <select id='server' name='server'>
            <option value='Ross 1'" . ($event["server"]=="Ross 1" ? "selected" : "") . ">Ross 1</option>
            <option value='Ross 2'" . ($event["server"]=="Ross 2" ? "selected" : "") . ">Ross 2</option>
            <option value='Ross 3'" . ($event["server"]=="Ross 3" ? "selected" : "") . ">Ross 3</option>
            <option value='Ross 4'" . ($event["server"]=="Ross 4" ? "selected" : "") . ">Ross 4</option>
            <option value='Valhelsia'" . ($event["server"]=="Valhelsia" ? "selected" : "") . ">Valhelsia</option>
            <option value='Garden of Evan'" . ($event["server"]=="Garden of Evan" ? "selected" : "") . ">Garden of Evan</option>
            <option value='The Reef'" . ($event["server"]=="The Reef" ? "selected" : "") . ">The Reef</option>
            <option value='Origins'" . ($event["server"]=="Origins" ? "selected" : "") . ">Origins</option>
        </select><br>
        <label for='type'>Type:</label>
        <select id='type' name='type'>
            <option value='Event'" . ($event["type"]=="Event" ? "selected" : "") . ">Event</option>
            <option value='Extended Event'" . ($event["type"]=="Extended Event" ? "selected" : "") . ">Extended Event</option>
            <option value='Historical'" . ($event["type"]=="Historical" ? "selected" : "") . ">Historical</option>
            <option value='A Beginning'" . ($event["type"]=="A Beginning" ? "selected" : "") . ">A Beginning</option>
            <option value='An Ending'" . ($event["type"]=="An Ending" ? "selected" : "") . ">An Ending</option>
        </select><br>
        <label for='involved'>Involved:</label>
        <input id='involved' name='involved' type='text' value='";
        for($i = 0; $i < count($event["involved"]); $i++) {
            echo $event["involved"][$i];
            if($i < count($event["involved"])-1)
                echo ", ";
        }
        echo"' /><br>

        <label for='highlight'>A Ross Highlight:</label>
        <input id='highlight' name='highlight' type='checkbox' ". ($table->num_rows == 0 ? "" : "checked") ."><br>

        <label for='locations'>Locations:</label>
        <input id='locations' name='locations' type='text' value='";
        for($i = 0; $i < count($event["locations"]); $i++) {
            echo $event["locations"][$i];
            if($i < count($event["locations"])-1)
                echo ", ";
        }
        echo"' /><br>
        
        <label for='date'>Date:</label>
        <input id='date' name='date' type='date' value='".$event["date"]."' /><br>

        <label for='ending'>Ending: (Only affects extended events)</label>
        <input id='ending' name='ending' type='date' value='".$event["ending"]."' /><br>
        
        <section id='images'>";
        for($i = 0; $i < count($event["images"]); $i++) {
            echo "
            <div class='img-container' id='container".$i."'>";

                if (str_ends_with($event["images"][$i]["src"], "mp4")) {
                    echo "<video autoplay muted loop><source src='../{$event["images"][$i]["src"]}' type='video/mp4'></video>";
                } else
                    echo "<img src='../".thumb8($event["images"][$i]["src"])."' alt='{$event["images"][$i]["caption"]}'><br>";

                echo "<label for='image$i'>Image #$i:</label>
                <input id='image$i' name='image$i' type='file' accept='image/png, image/jpeg, image/gif, video/mp4'><br>
                <label for='caption$i'>Caption #$i:</label><br>
                <textarea id='caption$i' name='caption$i' rows='3' cols='100'>{$event["images"][$i]["caption"]}</textarea><br>
                <p>{i,$i}</p>
            </div>
            ";
        }
        echo "</section>
        <button type='button' onclick='addImage()'>Add new Image</button>
        <input type='submit' value='Publish Page'>
    </form>";
?>
    <script>
        function addImage() {
            let count = $("#images div").length;
            $("#images").append(
                $("\
                <div class='img-container' id='container" + count + "'>\
                    <img src='' alt=''><br>\
                    <label for='image"+count+"'>Image #" + count + ":</label>\
                    <input id='image"+count+"' name='image"+count+"' type='file' accept='image/png, image/jpeg, image/gif, video/mp4'><br>\
                    <label for='caption"+count+"'>Caption #" + count + ":</label><br>\
                    <textarea id='caption"+count+"' name='caption"+count+"' rows='3' cols='100'></textarea><br>\
                    <p>{i,"+count+"}</p>\
                </div>")
            );
        }
    </script>
    </body>
</html>
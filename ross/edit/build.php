<?php
$ROOT = str_repeat("../", substr_count($_SERVER['REQUEST_URI'], "/"));
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Build Edit</title>
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

$database = new mysqli('localhost', 'zandgall', 'Z3DavidGall', 'RossWiki');
if($database->connect_errno > 0) {
    die('Unable to connect to database [' . $db->connect_error . ']');
}

$json_file = file_get_contents("../data.json");
$data = json_decode($json_file, true);

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

if(!isset($_GET["build"])) {
    echo "<main>
        <a href='build?build=new".(isset($_GET["nothumb"])?"&nothumb":"")."'>
            <div class='new'>
                <h1>Add New</h1>
            </div>
        </a>";
    for($i = count($data["builds"])-1; $i >= 0; $i--) {
        echo "
        <a href='build?build=".$i.(isset($_GET["nothumb"])?"&nothumb":"")."'>
            <div class='item'>
                <h1>{$data["builds"][$i]["name"]}</h1>
                <h2>{$data["builds"][$i]["type"]}</h2>
                <h3>{$data["builds"][$i]["server"]}</h3>";
        if(isset($data["builds"][$i]["thumbnail"]) && $data["builds"][$i]["thumbnail"]!="" && !isset($_GET["nothumb"]))
            echo "<img src='../".thumb16($data["builds"][$i]["thumbnail"])."' alt='{$data["builds"][$i]["name"]}'>";
        echo "</div>
        </a>
        ";
    }
    echo "</main>";
    return;
}

$BUILD_ID = $_GET["build"];
$build = "";
if($BUILD_ID == "new") {
    // Create new page
    $BUILD_ID = strval(count($data["builds"]));
    array_push($data["builds"], json_decode('{
        "page": "",
        "name": "",
        "description": "",
        "server": "Ross 2",
        "type": "",
        "builders": [],
        "coordinates": [
          0,
          0,
          0
        ],
        "constructed": "",
        "thumbnail": "",
        "images": [],
        "events": [],
        "on_map": true
      }'));
    $upl = fopen("../data.json", "w") or die("Unable to open file!");
    fwrite($upl, json_encode($data));
    fclose($upl);

    $data = json_decode(json_encode($data), true);
}
$build = $data["builds"][$BUILD_ID];
// See if the element exists in the Highlights table
if(!$table = $database->query("SELECT * FROM Highlights WHERE `type`='build' and `selection`={$BUILD_ID}")) {
    die("Couldn't run query: " . $database->error);
}
echo "<a href='./build".(isset($_GET["nothumb"])?"?nothumb":"")."'>Back to builds</a><br>";
echo "<a href='../build/".$build["page"]."'>View result</a>";
echo "
    <form action='build-form?build=".$BUILD_ID."' method='post' enctype='multipart/form-data'>
        <label for='name'>Name:</label>
        <input id='name' name='name' type='text' value=\"".$build["name"]."\" /><br>
        <label for='page'>Page URL:</label>
        <input id='page' name='page' type='text' value=\"".$build["page"]."\" /><br>
        <label for='description'>Description:</label><br>
        <textarea id='description' name='description' rows='10' cols='100'>".$build["description"]."</textarea><br>
        <img id='thumbnail-img' src=\"../".thumb4($build["thumbnail"])."\" alt='thumbnail'><br>
        <label for='thumbnail'>Thumbnail:</label>
        <input id='thumbnail' name='thumbnail' type='file' accept='image/png, image/jpeg, image/gif'><br>
        <label for='server'>Server:</label>
        <select id='server' name='server'>
            <option value='Ross 1'" . ($build["server"]=="Ross 1" ? "selected" : "") . ">Ross 1</option>
            <option value='Ross 2'" . ($build["server"]=="Ross 2" ? "selected" : "") . ">Ross 2</option>
            <option value='Ross 3'" . ($build["server"]=="Ross 3" ? "selected" : "") . ">Ross 3</option>
            <option value='Ross 4'" . ($build["server"]=="Ross 4" ? "selected" : "") . ">Ross 4</option>
            <option value='Valhelsia'" . ($build["server"]=="Valhelsia" ? "selected" : "") . ">Valhelsia</option>
            <option value='Garden of Evan'" . ($build["server"]=="Garden of Evan" ? "selected" : "") . ">Garden of Evan</option>
            <option value='The Reef'" . ($build["server"]=="The Reef" ? "selected" : "") . ">The Reef</option>
            <option value='Origins'" . ($build["server"]=="Origins" ? "selected" : "") . ">Origins</option>
        </select><br>
        <label for='type'>Type:</label>
        <select id='type' name='type'>
            <option value='Base'" . ($build["type"]=="Base" ? "selected" : "") . ">Base</option>
            <option value='Shop'" . ($build["type"]=="Shop" ? "selected" : "") . ">Shop</option>
            <option value='Build'" . ($build["type"]=="Build" ? "selected" : "") . ">Build</option>
            <option value='Hub'" . ($build["type"]=="Hub" ? "selected" : "") . ">Hub</option>
            <option value='Farm'" . ($build["type"]=="Farm" ? "selected" : "") . ">Farm</option>
        </select><br>
        <label for='builders'>Builders:</label>
        <input id='builders' name='builders' type='text' value=\"";
        for($i = 0; $i < count($build["builders"]); $i++) {
            echo $build["builders"][$i];
            if($i < count($build["builders"])-1)
                echo ", ";
        }
        echo"\" /><br>
        <label for='on_map'>Appears on map:</label>
        <input id='on_map' name='on_map' type='checkbox' ". (isset($build["on_map"]) ? ($build["on_map"] ? "checked" : "") : "checked")."><br>
        <label for='highlight'>A Ross Highlight:</label>
        <input id='highlight' name='highlight' type='checkbox' ". ($table->num_rows == 0 ? "" : "checked") ."><br>
        <label for='x'>Coordinates:</label><br>
        <input id='x' name='x' type='number' value='{$build["coordinates"][0]}' style='width:60px'>
        <input id='y' name='y' type='number' value='{$build["coordinates"][1]}' style='width:60px'>
        <input id='z' name='z' type='number' value='{$build["coordinates"][2]}' style='width:60px'><br>
        <label for='constructed'>Constructed:</label>
        <input id='constructed' name='constructed' type='date' value='".$build["constructed"]."' /><br>

        <label for='events'>[Related] Events:</label>
        <input id='events' name='events' type='text' value='";
        for($i = 0; $i < count($build["events"]); $i++) {
            echo $build["events"][$i];
            if($i < count($build["events"])-1)
                echo ", ";
        }
        echo"' /><br>
        
        <section id='images'>";
        for($i = 0; $i < count($build["images"]); $i++) {
            echo "<div class='img-container' id='container".$i."'>";

            if (str_ends_with($build["images"][$i]["src"], "mp4")) {
                echo "<video autoplay muted loop><source src='../{$build["images"][$i]["src"]}' type='video/mp4'></video>";
            } else
                echo "<img src='../".thumb8($build["images"][$i]["src"])."' alt='{$build["images"][$i]["caption"]}'><br>";

            echo "<label for='image$i'>Image #$i:</label>
                <input id='image$i' name='image$i' type='file' accept='image/png, image/jpeg, image/gif, video/mp4'><br>
                <label for='caption$i'>Caption #$i:</label><br>
                <textarea id='caption$i' name='caption$i' rows='3' cols='100'>{$build["images"][$i]["caption"]}</textarea><br>
                <p>{i,$i}</p>
            </div>";
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
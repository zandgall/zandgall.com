<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

function set_if_set($dest, $source, $default) {
    if(isset($source))
        $dest = $source;
    else
        $dest = $default;
}

$_post_q = file_get_contents("php://input");
$json_file = file_get_contents("../data.json");
$data = json_decode($json_file, true);
$EVENT_ID = $_GET["event"];

$database = new mysqli('localhost', 'zandgall', 'Z3DavidGall', 'RossWiki');
if($database->connect_errno > 0) {
    die('Unable to connect to database [' . $db->connect_error . ']');
}
// See if the element exists in the Highlights table
if(!$table = $database->query("SELECT * FROM Highlights WHERE `type`='event' and `selection`={$EVENT_ID}")) {
    die("Couldn't run query: " . $database->error);
}

header("Location: event?event=".$EVENT_ID);
$event = $data["events"][$EVENT_ID];
if(isset($_POST["page"])) { 
    print($_POST["page"]);
    print($_POST["name"]);
    print($_POST["description"]);
    print($_POST["server"]);
    print($_POST["type"]);
    print($_POST["date"]);
    print($_POST["ending"]);
    print($_POST["page"]);
    print($_POST["involved"]);
    print($_POST["locations"]);
    print($_FILES["thumbnail"]["name"]);
    print($_FILES["thumbnail"]["error"]);
    print($_FILES["thumbnail"]["size"]);
    print($_FILES["thumbnail"]["tmp_name"]);
    print($_POST["caption0"]);
    print($_FILES["image0"]["name"]);
    print($_FILES["image0"]["error"]);
    print($_FILES["image0"]["size"]);
    print($_FILES["image0"]["tmp_name"]);

    $event["page"] = $_POST["page"];
    $event["name"] = $_POST["name"];
    $event["description"] = $_POST["description"];
    $event["server"] = $_POST["server"];
    $event["type"] = $_POST["type"];
    $event["date"] = $_POST["date"];
    $event["ending"] = $_POST["ending"];
    
    if(isset($_FILES["thumbnail"]) && strlen($_FILES["thumbnail"]["name"])>0 && $_FILES["thumbnail"]["error"]==0 && $_FILES["thumbnail"]["size"] > 0) {
        $arr = explode(".", $_FILES["thumbnail"]["name"]);
        $suffix = end($arr);
        $thumbnail_file = $event["server"]."/".$event["type"]."/".$event["page"]."/thumbnail.$suffix";
        if(!file_exists("../".$event["server"]."/".$event["type"]."/".$event["page"]))
            mkdir("../".$event["server"]."/".$event["type"]."/".$event["page"], 0777, true);
        // var_dump(getimagesize($_FILES["thumbnail"]["tmp_name"]));
        if(getimagesize($_FILES["thumbnail"]["tmp_name"])!=false) {
            $result = move_uploaded_file($_FILES["thumbnail"]["tmp_name"], "../".$thumbnail_file);
            $event["thumbnail"] = $thumbnail_file;
            if(str_ends_with($thumbnail_file, ".png")) {
                list($width, $height) = getimagesize("../".$thumbnail_file);
                $src = imagecreatefrompng("../".$thumbnail_file);
                $dst = imagescale($src, intdiv($width, 4), intdiv($height, 4));
                imagepng($dst, str_replace(".png", "_x0.25.png", "../".$thumbnail_file));
                $dst = imagescale($src, intdiv($width, 8), intdiv($height, 8));
                imagepng($dst, str_replace(".png", "_x0.125.png", "../".$thumbnail_file));
                $dst = imagescale($src, intdiv($width, 16), intdiv($height, 16));
                imagepng($dst, str_replace(".png", "_x.16.png", "../".$thumbnail_file));
            }
        }
    }

    $involved = explode(",", $_POST["involved"]);
    for($i = 0; $i < count($involved); $i++)
        $involved[$i] = trim($involved[$i]);
    $event["involved"] = $involved;

    $locations = explode(",", $_POST["locations"]);
    for($i = 0; $i < count($locations); $i++)
        $locations[$i] = trim($locations[$i]);
    $event["locations"] = $locations;

    if($_POST["highlight"]=="on") {
        if($table->num_rows == 0)
            if(!$table = $database->query("INSERT INTO Highlights(`selection`, `type`) VALUES ({$EVENT_ID}, 'event')"))
                die("Couldn't run query: " . $database->error);
    } else {
        if($table->num_rows > 0)
            if(!$table = $database->query("DELETE FROM Highlights WHERE 'selection'={$EVENT_ID} AND 'type'='event'"))
                die("Couldn't run query: " . $database->error);
    }

    for($i = 0; isset($_POST["caption".$i]); $i++) {
        // TODO: Handle images
        if(isset($_FILES["image".$i]) && strlen($_FILES["image".$i]["name"])>0 && $_FILES["image".$i]["error"]==0 && $_FILES["image".$i]["size"] > 0) {
            $new_file = $event["server"]."/".$event["type"]."/".$event["page"]."/".basename($_FILES["image".$i]["name"]);
            if(!file_exists("../".$event["server"]."/".$event["type"]."/".$event["page"]))
                mkdir("../".$event["server"]."/".$event["type"]."/".$event["page"], 0777, true);
            // var_dump(getimagesize($_FILES["image".$i]["tmp_name"]));
            // if(getimagesize($_FILES["image".$i]["tmp_name"])!=false) {
                $result = move_uploaded_file($_FILES["image".$i]["tmp_name"], "../".$new_file);
                $event["images"][$i]["src"] = $new_file;
            // }
                if(str_ends_with($new_file, ".png")) {
                    list($width, $height) = getimagesize("../".$new_file);
                    $src = imagecreatefrompng("../".$new_file);
                    $dst = imagescale($src, intdiv($width, 4), intdiv($height, 4));
                    imagepng($dst, str_replace(".png", "_x0.25.png", "../".$new_file));
                    $dst = imagescale($src, intdiv($width, 8), intdiv($height, 8));
                    imagepng($dst, str_replace(".png", "_x0.125.png", "../".$new_file));
                    $dst = imagescale($src, intdiv($width, 16), intdiv($height, 16));
                    imagepng($dst, str_replace(".png", "_x.16.png", "../".$new_file));
                }
        }
        $event["images"][$i]["caption"] = $_POST["caption".$i];
    }
    $upl = fopen("../data.json", "w") or die("Unable to open file!");
    $data["events"][$EVENT_ID] = $event;
    fwrite($upl, json_encode($data));
    fclose($upl);

    /*$n = PHP_EOL;
    $upl = fopen("../".$event["page"].".php", "w") or die("Unable to open page");
    fwrite($upl, "
    <?php$n
    include \"./gen/head.php\";$n
    \$EVENT_ID = $EVENT_ID;$n
    include \"./gen/event.php\";$n
    include \"./gen/footer.php\";$n
    ?>$n");
    fclose($upl);
    chmod("../".$event["page"].".php", 0777);*/
}
?>
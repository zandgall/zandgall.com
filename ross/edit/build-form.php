<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$_post_q = file_get_contents("php://input");
$json_file = file_get_contents("../data.json");
$data = json_decode($json_file, true);
$BUILD_ID = $_GET["build"];
header("Location: build?build=".$BUILD_ID);
$build = $data["builds"][$BUILD_ID];

$database = new mysqli('localhost', 'zandgall', 'Z3DavidGall', 'RossWiki');
if($database->connect_errno > 0) {
    die('Unable to connect to database [' . $db->connect_error . ']');
}
// See if the element exists in the Highlights table
if(!$table = $database->query("SELECT * FROM Highlights WHERE `type`='build' and `selection`={$BUILD_ID}")) {
    die("Couldn't run query: " . $database->error);
}

if(isset($_POST["page"])) {
    print($_POST["page"] . "\n");
    print($_POST["name"] . "\n");
    print($_POST["description"] . "\n");
    print($_POST["server"] . "\n");
    print($_POST["type"] . "\n");
    print($_POST["constructed"] . "\n");
    print($_POST["on_map"] . "\n");
    print($_POST["x"] . "\n");
    print($_POST["y"] . "\n");
    print($_POST["z"] . "\n");
    print($_FILES["thumbnail"]["name"] . "\n");
    print($_FILES["thumbnail"]["error"] . "\n");
    print($_FILES["thumbnail"]["size"] . "\n");

    print($_POST["builders"] . "\n");
    print($_POST["events"] . "\n");
    print($_POST["caption0"] . "\n");

    print($_FILES["image0"]["name"] . "\n");
    print($_FILES["image0"]["error"] . "\n");
    print($_FILES["image0"]["size"] . "\n");


    $build["page"] = $_POST["page"];
    $build["name"] = $_POST["name"];
    $build["description"] = $_POST["description"];
    $build["server"] = $_POST["server"];
    $build["type"] = $_POST["type"];
    $build["constructed"] = $_POST["constructed"];
    $build["on_map"] = ($_POST["on_map"] == "on");
    $build["coordinates"] = [$_POST["x"], $_POST["y"], $_POST["z"]];
    
    if(isset($_FILES["thumbnail"]) && strlen($_FILES["thumbnail"]["name"])>0 && $_FILES["thumbnail"]["error"]==0 && $_FILES["thumbnail"]["size"] > 0) {
        $arr = explode(".", $_FILES["thumbnail"]["name"]);
        $suffix = end($arr);
        $thumbnail_file = $build["server"]."/".$build["type"]."/".$build["page"]."/thumbnail.$suffix";
        if(!file_exists("../".$build["server"]."/".$build["type"]."/".$build["page"]))
            mkdir("../".$build["server"]."/".$build["type"]."/".$build["page"], 0777, true);
        // var_dump(getimagesize($_FILES["thumbnail"]["tmp_name"]));
        if(getimagesize($_FILES["thumbnail"]["tmp_name"])!=false) {
            $result = move_uploaded_file($_FILES["thumbnail"]["tmp_name"], "../".$thumbnail_file);
            $build["thumbnail"] = $thumbnail_file;
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

    $builders = explode(",", $_POST["builders"]);
    for($i = 0; $i < count($builders); $i++)
        $builders[$i] = trim($builders[$i]);
    $build["builders"] = $builders;

    $events = explode(",", $_POST["events"]);
    for($i = 0; $i < count($events); $i++)
        $events[$i] = trim($events[$i]);
    $build["events"] = $events;

    if($_POST["highlight"]=="on") {
        if($table->num_rows == 0)
            if(!$table = $database->query("INSERT INTO Highlights(`selection`, `type`) VALUES ({$BUILD_ID}, 'build')"))
                die("Couldn't run query: " . $database->error);
    } else {
        if($table->num_rows > 0)
            if(!$table = $database->query("DELETE FROM Highlights WHERE 'selection'={$BUILD_ID} AND 'type'='build'"))
                die("Couldn't run query: " . $database->error);
    }

    for($i = 0; isset($_POST["caption".$i]); $i++) {
        if(isset($_FILES["image".$i]) && strlen($_FILES["image".$i]["name"])>0 && $_FILES["image".$i]["error"]==0 && $_FILES["image".$i]["size"] > 0) {
            $new_file = $build["server"]."/".$build["type"]."/".$build["page"]."/".basename($_FILES["image".$i]["name"]);
            if(!file_exists("../".$build["server"]."/".$build["type"]."/".$build["page"]))
                mkdir("../".$build["server"]."/".$build["type"]."/".$build["page"], 0777, true);
            // var_dump(getimagesize($_FILES["image".$i]["tmp_name"]));
            // if(getimagesize($_FILES["image".$i]["tmp_name"])!=false) {
                $result = move_uploaded_file($_FILES["image".$i]["tmp_name"], "../".$new_file);
                $build["images"][$i]["src"] = $new_file;
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
            // }
        }
        $build["images"][$i]["caption"] = $_POST["caption".$i];
    }
    $upl = fopen("../data.json", "w") or die("Unable to open file!");
    $data["builds"][$BUILD_ID] = $build;
    fwrite($upl, json_encode($data));
    fclose($upl);

   /* $n = PHP_EOL;
    $upl = fopen("../".$build["page"].".php", "w") or die("Unable to open page");
    fwrite($upl, "
    <?php$n
    include \"./gen/head.php\";$n
    \$BUILD_ID = $BUILD_ID;$n
    include \"./gen/build.php\";$n
    include \"./gen/footer.php\";$n
    ?>$n");
    fclose($upl);
    chmod("../".$build["page"].".php", 0777);*/
}
?>
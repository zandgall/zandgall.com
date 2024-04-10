<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$_post_q = file_get_contents("php://input");
$json_file = file_get_contents("../data.json");
$data = json_decode($json_file, true);
$GROUP_ID = $_GET["group"];
header("Location: group?group=".$GROUP_ID);
$group = $data["groups"][$GROUP_ID];
if(isset($_POST["page"])) {
    $group["page"] = $_POST["page"];
    $group["name"] = $_POST["name"];
    $group["description"] = $_POST["description"];
    $group["start-date"] = $_POST["start-date"];
    $group["end-date"] = $_POST["end-date"];
    
    if(isset($_FILES["thumbnail"]) && strlen($_FILES["thumbnail"]["name"])>0 && $_FILES["thumbnail"]["error"]==0 && $_FILES["thumbnail"]["size"] > 0) {
        $arr = explode(".", $_FILES["thumbnail"]["name"]);
        $suffix = end($arr);
        $thumbnail_file = "groups/".$group["page"]."/thumbnail.$suffix";
        if(!file_exists("../groups/".$group["page"]))
            mkdir("../groups/".$group["page"], 0777, true);
        // var_dump(getimagesize($_FILES["thumbnail"]["tmp_name"]));
        if(getimagesize($_FILES["thumbnail"]["tmp_name"])!=false) {
            $result = move_uploaded_file($_FILES["thumbnail"]["tmp_name"], "../".$thumbnail_file);
            $group["thumbnail"] = $thumbnail_file;
        }
    }

    $members = explode(",", $_POST["members"]);
    for($i = 0; $i < count($members); $i++)
        $members[$i] = trim($members[$i]);
    $group["members"] = $members;

    $builds = explode(",", $_POST["builds"]);
    for($i = 0; $i < count($builds); $i++)
        $builds[$i] = trim($builds[$i]);
    $group["builds"] = $builds;

    $events = explode(",", $_POST["events"]);
    for($i = 0; $i < count($events); $i++)
        $events[$i] = trim($events[$i]);
    $group["events"] = $events;
    
    for($i = 0; isset($_POST["caption".$i]); $i++) {
        // TODO: Handle images
        if(isset($_FILES["image".$i]) && strlen($_FILES["image".$i]["name"])>0 && $_FILES["image".$i]["error"]==0 && $_FILES["image".$i]["size"] > 0) {
            $new_file = "groups/".$group["page"]."/".basename($_FILES["image".$i]["name"]);
            if(!file_exists("../groups/".$group["page"]))
                mkdir("../groups/".$group["page"], 0777, true);
            $result = move_uploaded_file($_FILES["image".$i]["tmp_name"], "../".$new_file);
            $group["images"][$i]["src"] = $new_file;
        }
        $group["images"][$i]["caption"] = $_POST["caption".$i];
    }
    $upl = fopen("../data.json", "w") or die("Unable to open file!");
    $data["groups"][$GROUP_ID] = $group;
    fwrite($upl, json_encode($data));
    fclose($upl);

    /*$n = PHP_EOL;
    $upl = fopen("../".$group["page"].".php", "w") or die("Unable to open page");
    fwrite($upl, "
    <?php$n
    include \"./gen/head.php\";$n
    \$GROUP_ID = $GROUP_ID;$n
    include \"./gen/group.php\";$n
    include \"./gen/footer.php\";$n
    ?>$n");
    fclose($upl);
    chmod("../".$group["page"].".php", 0777);*/
}
?>
<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

$_post_q = file_get_contents("php://input");
$json_file = file_get_contents("../data.json");
$data = json_decode($json_file, true);
$PERSON_ID = $_GET["person"];
// header("Content-Type: text/plain");
header("Location: person?person=".$PERSON_ID);
$person = $data["people"][$PERSON_ID];
if(isset($_POST["description"])) {
    $person["description"] = $_POST["description"];
    $person["controversies"] = $_POST["controversies"];
    $person["join-date"] = $_POST["join-date"];
    $person["leave-date"] = $_POST["leave-date"];
    
    if(isset($_FILES["thumbnail"]) && strlen($_FILES["thumbnail"]["name"])>0 && $_FILES["thumbnail"]["error"]==0 && $_FILES["thumbnail"]["size"] > 0) {
        $arr = explode(".", $_FILES["thumbnail"]["name"]);
        $suffix = end($arr);
        $thumbnail_file = "people/".$PERSON_ID."/thumbnail.$suffix";
        if(!file_exists("../people/$PERSON_ID"))
            mkdir("../people/$PERSON_ID", 0777, true);
        // var_dump(getimagesize($_FILES["thumbnail"]["tmp_name"]));
        if(getimagesize($_FILES["thumbnail"]["tmp_name"])!=false) {
            $result = move_uploaded_file($_FILES["thumbnail"]["tmp_name"], "../".$thumbnail_file);
            $person["thumbnail"] = $thumbnail_file;
        }
    }
    $groups = explode(",", $_POST["groups"]);
    for($i = 0; $i < count($groups); $i++)
        $groups[$i] = trim($groups[$i]);
    $person["groups"] = $groups;

    foreach($data["servers"] as $name => $server) {
        $builds = explode(",", $_POST[str_replace(" ", "_", "$name builds")]);
        for($i = 0; $i < count($builds); $i++)
            $builds[$i] = trim($builds[$i]);
        $person["builds"][$name] = $builds;
    }
    foreach($data["servers"] as $name => $server) {
        $events = explode(",", $_POST[str_replace(" ", "_", "$name events")]);
        for($i = 0; $i < count($events); $i++)
            $events[$i] = trim($events[$i]);
        $person["events"][$name] = $events;
    }

    $upl = fopen("../data.json", "w") or die("Unable to open file!");
    $data["people"][$PERSON_ID] = $person;
    fwrite($upl, json_encode($data));
    fclose($upl);

    $n = PHP_EOL;
    $upl = fopen("../$PERSON_ID.php", "w") or die("Unable to open page");
    fwrite($upl, "
    <?php$n
    include \"./gen/head.php\";$n
    \$PERSON_ID = \"$PERSON_ID\";$n
    include \"./gen/person.php\";$n
    include \"./gen/footer.php\";$n
    ?>$n");
    fclose($upl);
    chmod("../$PERSON_ID.php", 0777);
}
?>
<?php
$ROOT = str_repeat("../", substr_count($_SERVER['REQUEST_URI'], "/"));
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Group Edit</title>
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

if(!isset($_GET["group"])) {
    echo "<main>";
    for($i = 0; $i < count($data["groups"]); $i++) {
        echo "
        <a href='group?group=".$i."'>
            <div class='item'>
                <h1>{$data["groups"][$i]["name"]}</h1>
                <h2>{$data["groups"][$i]["start-date"]}</h2>";
        if(isset($data["groups"][$i]["thumbnail"]) && $data["groups"][$i]["thumbnail"]!="")
            echo "<img src='../{$data["groups"][$i]["thumbnail"]}' alt='{$data["name"]}'>";
        echo "</div>
        </a>
        ";
    }
    echo "
        <a href='group?group=new'>
            <div class='new'>
                <h1>Add New</h1>
            </div>
        </a>
    </main>";
    return;
}

$group_ID = $_GET["group"];
$group = "";
if($group_ID == "new") {
    // Create new page
    $group_ID = strval(count($data["groups"]));
    array_push($data["groups"], json_decode('{
        "page": "",
        "name": "",
        "description": "",
        "thumbnail": "",
        "members": [],
        "start-date": "",
        "end-date": "",
        "images": [],
        "builds": [],
        "events": []
    }'));
    $upl = fopen("../data.json", "w") or die("Unable to open file!");
    fwrite($upl, json_encode($data));
    fclose($upl);

    $data = json_decode(json_encode($data), true);
}
$group = $data["groups"][$group_ID];
echo "<a href='./group'>Back to groups</a><br>";
// if(file_exists("../".$group["page"].".php"))
echo "<a href='../group/".$group["page"]."'>View result</a>";
echo "
    <form action='group-form?group=".$group_ID."' method='post' enctype='multipart/form-data'>
        <label for='name'>Name:</label>
        <input id='name' name='name' type='text' value='".$group["name"]."' /><br>
        <label for='page'>Page URL:</label>
        <input id='page' name='page' type='text' value='".$group["page"]."' /><br>
        <label for='description'>Description:</label><br>
        <textarea id='description' name='description' rows='10' cols='100'>".$group["description"]."</textarea><br>
        <img id='thumbnail-img' src='../".$group["thumbnail"]."' alt='thumbnail'><br>
        <label for='thumbnail'>Thumbnail:</label>
        <input id='thumbnail' name='thumbnail' type='file' accept='image/png, image/jpeg, image/gif'><br>
        <label for='members'>Members:</label>
        
        <input id='members' name='members' type='text' value='";
        for($i = 0; $i < count($group["members"]); $i++) {
            echo $group["members"][$i];
            if($i < count($group["members"])-1)
                echo ", ";
        }
        echo"' /><br>

        <label for='builds'>Builds:</label>
        <input id='builds' name='builds' type='text' value='";
        for($i = 0; $i < count($group["builds"]); $i++) {
            echo $group["builds"][$i];
            if($i < count($group["builds"])-1)
                echo ", ";
        }
        echo"' /><br>

        <label for='events'>Events:</label>
        <input id='events' name='events' type='text' value='";
        for($i = 0; $i < count($group["events"]); $i++) {
            echo $group["events"][$i];
            if($i < count($group["events"])-1)
                echo ", ";
        }
        echo"' /><br>

        <label for='start-date'>Start Date:</label>
        <input id='start-date' name='start-date' type='date' value='".$group["start-date"]."' /><br>

        <label for='end-date'>End Date: (Leave empty/00-00-0000 if not applicable)</label>
        <input id='end-date' name='end-date' type='date' value='".$group["end-date"]."' /><br>
        
        <section id='images'>";
        for($i = 0; $i < count($group["images"]); $i++) {
            echo "
            <div class='img-container' id='container".$i."'>";

                if (str_ends_with($group["images"][$i]["src"], "mp4")) {
                    echo "<video autoplay muted loop><source src='../{$group["images"][$i]["src"]}' type='video/mp4'></video>";
                } else
                    echo "<img src='../{$group["images"][$i]["src"]}' alt='{$group["images"][$i]["caption"]}'><br>";

                echo "<label for='image$i'>Image #$i:</label>
                <input id='image$i' name='image$i' type='file' accept='image/png, image/jpeg, image/gif, video/mp4'><br>
                <label for='caption$i'>Caption #$i:</label><br>
                <textarea id='caption$i' name='caption$i' rows='3' cols='100'>{$group["images"][$i]["caption"]}</textarea><br>
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
<?php
$userJoined = $_GET['name'];
if($userJoined==null) {
    echo "Please supply a name! https://www.zandgall.com/data/post?name=zandgall";
} elseif($userJoined=="zandgall") {
    echo "Hello, that's me!";
}
$filepath = "data.json";
$file = json_decode(file_get_contents($filepath), true);
$file[$userJoined] = true;
file_put_contents($filepath, json_encode($file));
echo "Successfully added";
?>
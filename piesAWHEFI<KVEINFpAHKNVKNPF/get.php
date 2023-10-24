<?php
// $url = $_POST['url'];
$ffile = fopen("friends.json", "r") or die("death");
$fffile = fread($ffile,filesize("friends.json"));
fclose($ffile);
$friends = json_decode($fffile, true);
echo $fffile;
?>
<?php
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
$file = file_get_contents("php://input");
$data = json_decode($file, true);
file_put_contents("data.json", json_encode($data));

echo $file;

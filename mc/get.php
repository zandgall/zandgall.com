<?php

$x = 0;
$z = 0;
$w = 1;
$h = 1;
if(isset($_GET["x"]))
    $x = $_GET["x"];
if(isset($_GET["z"]))
    $z = $_GET["z"];
if(isset($_GET["w"]))
    $w = $_GET["w"];
if(isset($_GET["h"]))
    $h = $_GET["h"];

    
for ($rx = floor($x / 32); $rx <= floor(($x + $w) / 32); $rx++) {
    for ($rz = floor($z / 32); $rz <= floor(($z + $h) / 32); $rz++) {
        // print("Requires region r.$rx.$rz.mca\n");
        // print(min(max($x-$rx*32, 0), 31)." ".min(max($z-$rz*32, 0), 31)." ".(min(max($x+$w-$rx*32, 1), 32)-min(max($x-$rx*32, 0), 31))." ".(min(max($z+$h-$rz*32, 1), 32)-min(max($z-$rz*32, 0), 31))."\n");
        exec("parse.exe world/r.$rx.$rz.mca ".min(max($x-$rx*32, 0), 31)." ".min(max($z-$rz*32, 0), 31)." ".(min(max($x+$w-$rx*32, 1), 32)-min(max($x-$rx*32, 0), 31))." ".(min(max($z+$h-$rz*32, 1), 32)-min(max($z-$rz*32, 0), 31)));
        // print("parse.exe world/r.$rx.$rz.mca ".min(max($x-$rx*32, 0), 31)." ".min(max($z-$rz*32, 0), 31)." ".(min(max($x+$w-$rx*32, 1), 32)-min(max($x-$rx*32, 0), 31))." ".(min(max($z+$h-$rz*32, 1), 32)-min(max($z-$rz*32, 0), 31))."\n");
    }
}
$fp = file_get_contents('out.json');
// send the right headers
header("Content-Type: application/json");
echo json_encode(json_decode($fp));
?>
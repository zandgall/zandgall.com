<?php
ob_start();
include "get.php";
ob_end_clean();


$SCALE = 16;
$_X = 0;
$_Z = 0;
$_W = 1;
$_H = 1;
if(isset($_GET["x"]))
    $_X = $_GET["x"];
if(isset($_GET["z"]))
    $_Z = $_GET["z"];
if(isset($_GET["w"]))
    $_W = $_GET["w"];
if(isset($_GET["h"]))
    $_H = $_GET["h"];
if(isset($_GET["scale"]))
    $SCALE = $_GET["scale"];

// header("Content-Type: text/html; charset=UTF-8");
$image = imagecreatetruecolor($_W * 16 * $SCALE, $_H * 16 * $SCALE);

$colfile = fopen("cols.txt", "r");
$i = 0;
$blockColors = array();
if($colfile) {
    while(($line = fgets($colfile))!==false) {
        list($item, $r, $g, $b) = explode(" ", $line);
        $blockColors[$item] = array(intval($r), intval($g), intval($b));
    }
}

$json_file = file_get_contents("out.json");
$json_a = json_decode($json_file);
// echo print_r($json_a);

function getHeight($x, $z) {
    global $json_a;
    $bx = floor($x%16);
    $bz = floor($z%16);
    if($bx < 0)
        $bx += 16;
    if($bz < 0)
        $bz += 16;
    $chux = (floor($x/16.0)%32);
    $chuz = (floor($z/16.0)%32);
    if($chux < 0)
        $chux += 32;
    if($chuz < 0)
        $chuz += 32;
    $rx = floor($x/16/32);
    $rz = floor($z/16/32);
    // print("Attempting to get block $bx, $bz ($x, $z) from chunk $chux, $chuz from region $rx, $rz<br>");
    if (!isset($json_a->regions))
        return 512;
    if (!isset($json_a->regions->{"$rx.$rz"}))
        return 512;
    if (!isset($json_a->regions->{"$rx.$rz"}->{"$chux,$chuz"}))
        return 512;
    if (!isset($json_a->regions->{"$rx.$rz"}->{"$chux,$chuz"}->{"heightmap"}))
        return 512;
    if (!isset($json_a->regions->{"$rx.$rz"}->{"$chux,$chuz"}->{"heightmap"}[$bx+$bz*16]))
        return 512;
    return $json_a->regions->{"$rx.$rz"}->{"$chux,$chuz"}->{"heightmap"}[$bx+$bz*16];
}

function shadedRect($image, $x, $z, $r, $g, $b, $neighbors, $currHeight) {
    global $SCALE;


    for ($i = $x; $i < $x + $SCALE; $i++) {
        for ($j = $z; $j < $z + $SCALE; $j++) {
            $cr = $r;
            $cg = $g;
            $cb = $b;
            if($neighbors[0]>$currHeight) { # Top-left
                $rat = 1 - ((($j - $z) / $SCALE)*0.25 + 0.75); # Top gradient
                $rat -= 1 - (0.25-(($i - $x) / $SCALE)*0.25 + 0.75); # - Right gradient
                $rat = min(max(1-$rat, 0), 1);
                $cr *= $rat;
                $cg *= $rat;
                $cb *= $rat;
            }
            if($neighbors[1]>$currHeight) { # Top
                $cr *= (($j - $z) / $SCALE)*0.25 + 0.75;
                $cg *= (($j - $z) / $SCALE)*0.25 + 0.75;
                $cb *= (($j - $z) / $SCALE)*0.25 + 0.75;
            }
            if($neighbors[2]>$currHeight) { # Top-right
                $rat = 1 - ((($j - $z) / $SCALE)*0.25 + 0.75); # Top gradient
                $rat -= 1 - ((($i - $x) / $SCALE)*0.25 + 0.75); # - Left gradient
                $rat = min(max(1-$rat, 0), 1);
                $cr *= $rat;
                $cg *= $rat;
                $cb *= $rat;
            }
            if($neighbors[3]>$currHeight) { # Right
                $cr *= 0.25-(($i - $x) / $SCALE)*0.25 + 0.75;
                $cg *= 0.25-(($i - $x) / $SCALE)*0.25 + 0.75;
                $cb *= 0.25-(($i - $x) / $SCALE)*0.25 + 0.75;
            }
            if($neighbors[4]>$currHeight) { # Bottom-right
                $rat = 1 - (0.25-(($j - $z) / $SCALE)*0.25 + 0.75); # Bottom gradient
                $rat -= 1 - ((($i - $x) / $SCALE)*0.25 + 0.75); # - Left gradient
                $rat = min(max(1-$rat, 0), 1);
                $cr *= $rat;
                $cg *= $rat;
                $cb *= $rat;
            }
            if($neighbors[5]>$currHeight) { # Bottom
                $cr *= 0.25-(($j - $z) / $SCALE)*0.25 + 0.75;
                $cg *= 0.25-(($j - $z) / $SCALE)*0.25 + 0.75;
                $cb *= 0.25-(($j - $z) / $SCALE)*0.25 + 0.75;
            }
            if($neighbors[6]>$currHeight) { # Bottom-right
                $rat = 1 - (0.25-(($j - $z) / $SCALE)*0.25 + 0.75); # Bottom gradient
                $rat -= 1 - (0.25 - (($i - $x) / $SCALE)*0.25 + 0.75); # - Right gradient
                $rat = min(max(1-$rat, 0), 1);
                $cr *= $rat;
                $cg *= $rat;
                $cb *= $rat;
            }
            if($neighbors[7]>$currHeight) { # Left
                $cr *= (($i - $x) / $SCALE)*0.25 + 0.75;
                $cg *= (($i - $x) / $SCALE)*0.25 + 0.75;
                $cb *= (($i - $x) / $SCALE)*0.25 + 0.75;
            }

            $color = imagecolorallocate($image, $cr, $cg, $cb);
            imagesetpixel($image, $x + $i, $z + $j, $color);
        }
    }
}

function drawChunk($x, $z, $xoff, $zoff) {
    global $json_a, $blockColors, $image, $SCALE;
    $cx = $x % 32;
    $cz = $z % 32;
    if($cx < 0)
        $cx += 32;
    if($cz < 0)
        $cz += 32;
    
    if(!isset($json_a->regions->{floor($x/32).".".floor($z/32)}->{"$cx,$cz"}->{"palette"}))
        return;
    if(!isset($json_a->regions->{floor($x/32).".".floor($z/32)}->{"$cx,$cz"}->{"heightmap"}))
        return;
    if(!isset($json_a->regions->{floor($x/32).".".floor($z/32)}->{"$cx,$cz"}->{"oceanfloor"}))
        return;
    if(!isset($json_a->regions->{floor($x/32).".".floor($z/32)}->{"$cx,$cz"}->{"top blocks"}))
        return;
    if(!isset($json_a->regions->{floor($x/32).".".floor($z/32)}->{"$cx,$cz"}->{"ocean floor blocks"}))
        return;
    // print("Drawing chunk $x, $z ($cx, $cz)<br>");
    $palette = $json_a->regions->{floor($x/32).".".floor($z/32)}->{"$cx,$cz"}->{"palette"};
    $height = $json_a->regions->{floor($x/32).".".floor($z/32)}->{"$cx,$cz"}->{"heightmap"};
    $oceanheight = $json_a->regions->{floor($x/32).".".floor($z/32)}->{"$cx,$cz"}->{"oceanfloor"};
    $top = $json_a->regions->{floor($x/32).".".floor($z/32)}->{"$cx,$cz"}->{"top blocks"};
    $floor = $json_a->regions->{floor($x/32).".".floor($z/32)}->{"$cx,$cz"}->{"ocean floor blocks"};

    $lighting = 7;


    for ($i = 0; $i < 256; $i++) {
        $bx = $i % 16 + $x * 16;
        $bz = floor($i / 16) + $z * 16;
        $high = $blockColors[substr($palette[intval($top[$bz-($z*16) + ($bx-$x*16)*16])], 10)];
        $low = $blockColors[substr($palette[intval($floor[$bz-($z*16) + ($bx-$x*16)*16])], 10)];
        $diff = min(max(($height[$i] - $oceanheight[$i])/100.0, 0), 1)*0.5+0.5;

        // print("Drawing block $bx, $bx ($i) with lighting $light and block ".substr($palette[intval($top[$i])], 10)."<br>");

        $col = array(
            min(max(intval($high[0]*$diff + ($low[0]*(1-$diff))), 0), 255),
            min(max(intval($high[1]*$diff + ($low[1]*(1-$diff))), 0), 255),
            min(max(intval($high[2]*$diff + ($low[2]*(1-$diff))), 0), 255)
        );

        // $cola = imagecolorallocate($image, $col[0], $col[1], $col[2]);
        // imagesetpixel($image, $bx-$x * 16 + $xoff, $bz-$z * 16 + $zoff, $cola);
        shadedRect($image, ($bx-$x*16+$xoff*16)*$SCALE/2, ($bz-$z*16+$zoff*16)*$SCALE/2, $col[0], $col[1], $col[2], 
        array(getHeight($bx-1, $bz-1), getHeight($bx, $bz-1), getHeight($bx+1, $bz-1), getHeight($bx+1, $bz), getHeight($bx+1, $bz+1), getHeight($bx, $bz+1), getHeight($bx-1, $bz+1), getHeight($bx-1, $bz)), getHeight($bx, $bz));
    }
}
// print((-1%32)."<br><br>");
for($i = $_X; $i < $_X + $_W; $i++)
    for($j = $_Z; $j < $_Z + $_H; $j++) {
        drawChunk($i, $j, $i - $_X, $j - $_Z);
    }

// exit;
// echo $palette[0]." ".$palette[1]."\n";


header ('Content-Type: image/png');
imagepng($image);
imagedestroy($image);
?>
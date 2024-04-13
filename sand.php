<!DOCTYPE html>
<html lang="en">
<?php
$pagetitle = "Zandgall - Sand";
$pagedesc = "Little basic sand engine created by zandgall";
include "global/header.php"; ?>

<style>
.codeexample {
/*    width: 1000px; */
/*    margin: 10px auto 10px -100px; */
    border: inset 2px #000027; 
    background-color: #101020
}
.codeexample h3 {
    text-align:left; 
    margin: 5px; 
    color:#d8d8d8; 
    font-family:basicbit; 
    font-weight: normal;
}

.code-seg {
	width: 80vw; 
	max-width:1000px; 
	margin:1cm auto auto auto; 
	display:flex; 
	flex-direction:row;
}
</style>


<?php
$title = "SAND!";
$subtitle = "and fish and reeds and water and clouds and";
include "global/begin.php";

function stringIncludes($strings, $search) {
    for($i = 0; $i < sizeof($strings); $i++) {
        if($strings[$i] == "")
            continue;
        if(strpos($search, $strings[$i]) !== false) {
            return true;
        }
    }
    return false;
}
function strip($string) {
    $remove = array(" ", " ", ",", "(", ")", ":", "\n", "\r", "\r\n");
    foreach($remove as $toRem) {
        $string = str_replace($toRem, "", $string);
    }
    return $string;
}
function astrip($array) {
	$out = array();
	foreach($array as $element)
		if($element!="" && $element!=" ")
			array_push($out, $element);
	return $out;
}
function prepForSplit($string) {
    $remove = array(",", "(", ")");
    $string = str_replace(",", " , ", $string);
    $string = str_replace("(", " ( ", $string);
    $string = str_replace(")", " ) ", $string);
    return $string;
}
function sandCode($filepath) {
	$file = fopen($filepath, "r") or die("Unable to open code file!");
    $filesize = filesize($filepath);
    $indents = 0;
    $variables = array("*"=>"#aaaaaa");
    $variable_hue = 0;

    while(!feof($file)) {
    	$line = fgets($file);
        $words = astrip(explode(" ", prepForSplit($line)));

        for($i = 0; $i < $indents; $i++)
        	echo "&emsp;";

        if($line[0]=='#') {
        	list($r,$g,$b) = sscanf($words[0], "#%02x%02x%02x");
        	$luma = 0.2126 * $r + 0.7152 * $g + 0.0722 * $b;
        	$bg_col = $luma < 128 ? "#ffffff" : "rgba(0,0,0,0)";
        	$bg_col = "rgba(0,0,0,0);";
        	echo "<span style='background-color:$bg_col; color:".strip($words[0]).";'>$words[0] ";
        	for($i = 1; $i < sizeof($words); $i++)
        		echo "<span style='text-decoration:underline'>$words[$i]</span> ";
        	echo"</span><br>";
        	continue;
        }
       	if($line[0]=='-') {
       		echo "<span style='color:#aaaaaa'><i>$line</i></span><br>";
       		continue;
       	}

       	if(strip($words[0])=="rule") {
       		echo "<span style='color:#ffffff'><b>rule: ";
       		for($i = 1; $i < sizeof($words); $i++){
       			if(strip($words[$i])=="x")
       				echo "<span style='color:#aa4444'>$words[$i]</span> ";
       			elseif (strip($words[$i])=="y")
       				echo "<span style='color:#44aa44'>$words[$i]</span> ";
       			elseif (strip($words[$i])=="xy" || strip($words[$i])=="yx")
       				echo "<span style='color:#aaaa44'>$words[$i]</span> ";
       			elseif (str_ends_with(strip($words[$i]), "%"))
       				echo "<span style='color:#4444aa'>$words[$i]</span> ";
       			else echo $words[$i]." ";
       			
       		}
       		echo "</b></span><br>";
       		for($i = 0; $i < 5; $i++) {
       			$line = fgets($file);
       			$words = astrip(explode(" ", $line));
       			// var_dump($line);
       			// var_dump($words);

       			$j = 0;
       			for(; $j < 5; $j++) {
       				if(array_key_exists($words[$j], $variables))
       					echo "<span style='color:{$variables[$words[$j]]}'>$words[$j]</span> ";
       				else
       					echo "<span style='background-color:#ff0000; color:#aaaaaa'>$words[$j]</span> ";
       			}
       			if($i == 2) {
       				$j++;
       				echo "=> ";
       			} else {
	       			echo "&nbsp;&nbsp;&nbsp;";
	       		}
	       		for(; $j < sizeof($words); $j++) {
	       			if ($words[$j][0]=='(' && sizeof($words)>$j+1) {
	       				list($x) = sscanf($words[$j], "(%d");
	       				list($y) = sscanf($words[$j+1], "%d)");
	       				if($x<-1||$x>1||$y<-1||$y>1)
	       					echo "<span style='color:#aaccaa;'>$words[$j] {$words[$j+1]}</span> ";
	       				else {
	       					$arroys = array('↖', '↑', '↗', '←', '*', '→', '↙', '↓', '↘');
	       					$arrow = $arroys[$x+1+($y+1)*3];
	       					echo "<span style='color:#aaccaa; text-decoration:underline;' title='Literal: $words[$j] {$words[$j+1]}'>$arrow</span> ";
	       				}
	       				$j++;
	       			} elseif (array_key_exists(strip($words[$j]), $variables))
	       				echo "<span style='color:{$variables[strip($words[$j])]}'>$words[$j]</span> ";
	       		}
       			echo "<br>";
       			if(feof($file))
       				return;
       		}
       		continue;
       	}
       	if(sizeof($words)>1 && $words[1] == "=>") {
       		$variable_hue += 1.618;
       		$h = fmod($variable_hue, 1) * 360;
       		$variables[$words[0]] = "hsl($h,60%,70%)";
       		echo "<span style='color:hsl($h,60%,70%);'>$words[0] $words[1] $words[2]</span><br>";
       		continue;
       	}

        echo $line."<br>";
    }
} 

?>

<div style="width:80vmin; height:80vmin; position: relative; margin: auto auto calc(48pt + 1cm) auto;" width=80 height=80>
	<canvas id="sandvas" class="section" style="width:100%; height:100%" width=80 height=80></canvas>
	<p class="basictext"><i>A JavaScript port for easy access</i></p>
</div>

<div class="section" style="width: 60vw; max-width:800px; margin: auto">
	<h1 class="basictext outlinetext">Sand Engine</h1>
	<p class="basictext">The above is a port of the C program doing essentially the same thing out of the box, with one key difference.</p>
	<p class="basictext">The desktop C version of this programs comes with a single C file, and several rulesets. The C file is simply an engine, with the rulesets being written in custom scripting language.</p>
	<p class="basictext">The scripting language can define elements by giving a color, and listing properties of the element. These properties can then be used in rules to describe how elements with specified properties act. In order to simplify the rulewriting process, you can make shorthands for properties. Look through the following sections to get an idea of the syntax and how these rules work.</p>
</div>
<div class="section code-seg">
	<div style="flex-grow:1;">
	</div>
	<div class="codeexample" style="height:100%">
		<h3 class="basictext">
			<?php sandCode("assets/sand/element_definition"); ?>
		</h3>
	</div>
</div>
<div class="section code-seg">
	<div style="flex-grow:1;">
		<h1 class="basictext outlinetext">Sand</h1>
		<p class="basictext">
			
		</p>
	</div>
	<div class="codeexample" style="height:100%">
        <h3 class="basictext">
        	<?php sandCode("assets/sand/sand.ruleset"); ?>
        </h3>
    </div>
</div>

<script src="./scripts/sand.js"></script>

<?php include "global/end.php"?>
</html>

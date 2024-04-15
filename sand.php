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
    background-color: #101020;
}

.codeexample h3 {
    text-align:left; 
    margin: 5px; 
    color:#d8d8d8; 
    font-family:basicbit; 
    font-weight: normal;
}

.code-seg {
	display:flex; 
/*	flex-direction:row;*/
}

.section:has(.code-seg) {
	width: 80vw; 
	max-width:1000px; 
	margin:1cm auto auto auto; 
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
function sandCode($filepath, $preDefVars = array()) {
	$file = fopen($filepath, "r") or die("Unable to open code file!");
    $filesize = filesize($filepath);
    $indents = 0;
    $variables = array("*"=>"#aaaaaa");
    $variable_hue = 0;
    foreach($preDefVars as $var) {
   		$h = fmod($variable_hue, 1) * 360;
   		$variables[$var] = "hsl($h,60%,70%)";
    	$variable_hue += 1.618;
    }

    while(!feof($file)) {
    	$line = fgets($file);
        $words = astrip(explode(" ", $line));

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
	       			else
       					echo "<span style='background-color:#ff0000; color:#aaaaaa'>$words[$j]</span> ";
	       		}
       			echo "<br>";
       			if(feof($file))
       				return;
       		}
       		continue;
       	}
       	if(sizeof($words)>1 && $words[1] == "=>") {
       		$h = fmod($variable_hue, 1) * 360;
       		$variables[$words[0]] = "hsl($h,60%,70%)";
       		$variable_hue += 1.618;
       		echo "<span style='color:hsl($h,60%,70%);'>$line</span><br>";
       		continue;
       	}

        echo $line."<br>";
    }
} 

?>

<div style="width:80vmin; height:80vmin; position: relative; margin: auto auto calc(144pt + 1cm) auto;" width=80 height=80>
	<canvas id="sandvas" class="section" style="width:100%; height:100%; image-rendering: pixelated;" width=80 height=80></canvas>
	<p class="basictext outlinetext"><i>A JavaScript port for easy access</i></p>
	<p class="basictext outlinetext">s: sand, w: water, a: air, x: stone, 1: seed, e: fish egg</p>
	<p class="basictext outlinetext">ctrl: single place, up/down arrow: change place size</p>
</div>

<div class="section" style="width: 60vw; max-width:800px; margin: auto">
	<h1 class="basictext outlinetext">Sand Engine</h1>
	<p class="basictext">The above is a port of the C program doing essentially the same thing out of the box, with one key difference.</p>
	<p class="basictext">The desktop C version of this programs comes with a single C file, and several rulesets. The C file is simply an engine, with the rulesets being written in custom scripting language.</p>
	<p class="basictext">The scripting language can define elements by giving a color, and listing tags of the element. These tags can then be used in rules to describe how elements with specified tags act. In order to simplify the rulewriting process, you can make shorthands for terms. Look through the following sections to get an idea of the syntax and how these rules work.</p>
</div>
<div class="section">
	<h1 class="basictext outlinetext">Elements</h1>
	<p class="basictext">An element is defined as shown on the right. First, pick a color in hex. If you want the user to be able to draw the element to the canvas, you can add a single character to the end to denote a key the user can press to select it. The lines following the element start with a '-' and have strings that denote 'tags' of this element. These tags can be selected in rules and used to have elements interact with eachother.</p>
	<div class="code-seg">
		<div style="flex-grow:1;">
			<p class="basictext">Here we've defined a tan element with the keybind "s", it is tagged as "sand", "solid", "fallable", and "pileable". The solid tag can be used to make sure nothing falls through it. The fallable tag can be used to make sure it falls straight down, and pileable can be used to make elements form piles rather than pillars.</p>
		</div>
		<div class="codeexample" style="width:300px; min-width:300px;"><h3 class="basictext"><?php sandCode("assets/sand/element_definition"); ?></h3></div>
	</div>
</div>
<div class="section">
	<h1 class="basictext outlinetext">Symbols</h1>
	<p class="basictext">Symbols can be used in rule definitions in order to make rules more coherent. They can be defined by typing any character not including "#", "*" or " ". You assign it to an element tag, color, or reference, by adding a '=>' before a string containing the tag you want to use in shorthand.</p>
	<div class="code-seg">
		<div style="flex-grow: 1;">
			<p class="basictext">In this example, we add shorthand for "fallable", "passthrough", "solid", and "pileable" elements with the characters "f", "0", "s" and "p", and the color "#ff0000" with "r", and the reference (0, -1) with "^" which you can see being used in rules later on.</p>
		</div>
		<div class="codeexample" style="width:300px; min-width:300px;">
			<h3 class="basictext"><?php sandCode("assets/sand/shorthand_definition");?></h3>
		</div>
	</div>
</div>
<div class="section">
	<h1 class="basictext outlinetext">Rules</h1>
	<p class="basictext">Rules are initialized with the "rule:" phrase. They can include 3 flags in any order at any point in the line, "x", "y", and a "num%". The flags 'x' and 'y' tell the engine that the rule can be mirrored horizontally and/or vertically ("x" and "y" respectively). Say you want to select the pattern <span class="codeexample"><span style="color:hsl(0, 60%, 70%)">a</span> <span style="color:hsl(582, 60%, 70%)">b</span> <span style="color:hsl(1164, 60%, 70%)">c</span></span> in your rule, but would also want the same rule flipped to select <span class="codeexample"><span style="color:hsl(1164, 60%, 70%)">c</span> <span style="color:hsl(582, 60%, 70%)">b</span> <span style="color:hsl(0, 60%, 70%)">a</span></span> and perform the same action (<i>also</i> flipped) on it, you would just specify 'x'. The "num%" flag will make it so there's only a "num%" chance of it happening any given execution. This can be used to feign slowness or friction in certain rules.</p>
	<p class="basictext">
		The rules themselves are defined in two 5 by 5 series of character seperated by whitespaces. There must be a two character seperator in the 3rd row between the two 5x5 sides. I always put "=>" here, but the engine technically doesn't check <i>which</i> two characters you use. The first 5x5 set is the pattern selector. The engine will look for this pattern of elements in the world. Entries can be colors, tags, previously defined shorthand, or '*'. The '*' character will select anything.
	</p>
	<p class="basictext">
		The second 5x5 body is how the engine responds when it finds the pattern in the first block. In this block, the "*" character means "unchanged". A color means it will simply set that element in the selected pattern to that color. An element tag will select a random element with that tag, and place it there. And references, which will set it to an element in the pattern, using coordinates in relation to it. For example, if the response element in the middle is "(1, 1)", it will set itself to the element diagonally down and to the right.
	</p>
	<div class="code-seg">
		<div style="flex-grow:1;">
			<p class="basictext">
				The rule on the right uses the symbols previously defined to search the whole screen for a "pileable" element, that sits on top of a "solid" element, and has a "passthrough" element down and to the right, and it ignores all other elements in the 5x5 scanning area. It's mirror horizontally, and so this rule will work to the left as well. Recall that '\' was defined as a reference that points down 1 and right 1, and / as a reference that points up 1, and left 1. In this rule's response, the pileable element gets set to whatever was in the bottom right, i.e. the passthrough element. And the passthrough element gets set to whatever was up and left from it, i.e. the pileable element. The passthrough and pileable elements are effectively swapped, and it appears as the pileable element sliding off the solid element.
			</p>
		</div>
		<div class="codeexample" style="width:300px; min-width:300px;">
			<h3 class="basictext"><?php sandCode("assets/sand/rule_definition", array("f", "0", "s", "p", "r", "^", "\\", "/")); ?></h3>
		</div>
	</div>
	<p class="basictext">
		A visual representation can be seen here. The engine searches for the image on the left, where all white are ignored spaces, the tan is a sand element which has the tag "pileable", the grey is a stone element which has the tag "solid", and the blue is an air element which has the property "passthrough". The engine recognizes this as satisfying the rule, and swaps the sand and air.
	</p>
	<img src="assets/sand/rule.png" style="width:100%; height:auto; image-rendering: pixelated;">
</div>
<div class="section">
	<h1 class="basictext outlinetext">Sand</h1>
	<p class="basictext">I will now run you through the Sand ruleset. </p>
	<div class="code-seg">
		<div style="flex-grow:1;">
			<h3 class="basictext">
				In this first chunk, we define air, as a blue passthrough element with the keybind 'a'. Sand as a tan solid, fallable, and pileable element with the keybind 's'. Stone as a grey solid and fallable element with the keybind 'x', and water, a blue fallable, pileable, liquid element with the keybind 'w'.
			</h3>
		</div>
		<div class="codeexample" style="width:400px; min-width:400px;">
	        <h3 class="basictext">
	        	<?php sandCode("assets/sand/sand_1.ruleset"); ?>
	        </h3>
	    </div>
	</div>
	<div class="code-seg">
		<div style="flex-grow:1;">
			<h3 class="basictext">
				In this second section, we define 2 rules. Before we do so however, we create a few symbols to make the rules a bit more coherent. Ones for fallable, passthrough, solid, and pileable elements, as well as ones for references 1 tile down, 1 tile up, 1 tile down and right, and 1 tile up and left.
			</h3>
			<h3 class="basictext">
				This first rule defines how "fallable" elements behave. If they notice a passthrough element 1 tile below them, they swap positions with it, appearing as the tile falling.
			</h3>
			<h3 class="basictext">
				This second rule defines how "pileable" elements behave. We went over with this in the previous section, but it tells "pileable" elements to look for spaces diagonally down-right if there's a solid tile directly below, and swap with that space if it's a passthrough element. This rule is also mirrored horizontally so that pilable elements will search down to the left as well.
			</h3>
		</div>
		<div class="codeexample" style="width:400px; min-width:400px"><h3 class="basictext"><?php sandCode("assets/sand/sand_2.ruleset");?></h3></div>
	</div>
	<div class="code-seg">
		<div style="flex-grow:1;">
			<h3 class="basictext">
				In this third section, symbols are defined for "liquid" elements, along with a reference one tile to the right, and a reference one tile to the left.
			</h3>
			<h3 class="basictext">
				First we create a rule that allows liquid to slide across other liquids. If a liquid is on top of another liquid, and there is a passthrough element to the right, it will swap places with that passthrough element. This rule is mirrors horizontally so that liquid can slide leftwards as well.
			</h3>
			<h3 class="basictext">
				Second, we create a rule that allows liquid to slide across solids, similarly to liquids, if there's a passthrough element to the right, or to the left due to horizontal mirroring.
			</h3>
			<h3 class="basictext">
				Finally, we create a rule that allows fallables to fall through liquid. It's identical to the original fallable rule, with the only difference being the 20% rule chance. This means that every frame, there's only a 20% chance that any fallable in liquid will fall. This causes the appearance of fallables falling slower in water than they fall in air.
			</h3>
		</div>
		<div class="codeexample" style="width:400px; min-width:400px"><h3 class="basictext"><?php sandCode("assets/sand/sand_3.ruleset", array("f", "0", "s", "p", "v", "^", "\\", "/"));?></h3></div>
	</div>
</div>

<script src="./scripts/sand.js"></script>

<?php include "global/end.php"?>
</html>

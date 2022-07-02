<?php
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
    $remove = array(" ", " ", ",", "(", ")", "\n", "\r", "\r\n");
    foreach($remove as $toRem) {
        $string = str_replace($toRem, "", $string);
    }
    return $string;
}
function prepForSplit($string) {
    $remove = array(",", "(", ")");
    $string = str_replace(",", " , ", $string);
    $string = str_replace("(", " ( ", $string);
    $string = str_replace(")", " ) ", $string);
    return $string;
}
function basicCode($filepath, $keywords){
    $file = fopen($filepath, "r") or die("Unable to open code file!");
    $filesize = filesize($filepath);

    $isComment = false;
    $indents = 0;
    $reservedWords = array("Dim", "Shared", "As", "Integer", "Double", "String", "Do", "Loop", "While", "Sub", "Function", "End", "Color", "Or", "And", "If", "Then", "Call", "GoTo", "Else", "ElseIf", "Screen", "For", "Next", "To", "Type", "Single");
    $reservedFunct = array("Cls", "Sgn", "PSet", "_RGB", "_Display", "_NewImage", "Tan", "Sin", "Cos");
    $triggerIndent = array("Function", "Sub", "If", "Else", "ElseIf", "Do", "For", "Type");
    $functions = array();
    $variables = array();
    $sharedvariables = array();
    $functionParameters = array();
    while(!feof($file)) {
        // Read file line by line and do stuff with it
        $line = fgets($file);
        $words = explode(" ", prepForSplit($line));
        $isComment = false;
        $declaringFunction = false;
        $declaringVariable = false;
        $justEnded = false;
        $functionLine = false;
        $shared = false;
        if((in_array("End", $words) || in_array("Else", $words) || in_array("Else\r\n", $words) || in_array("ElseIf", $words) || in_array("Loop", $words) || in_array("Loop\r\n", $words) || in_array("Next", $words) || in_array("Next\r\n", $words)))        
            $indents--;
        for($j = 0; $j < $indents; $j++)
            echo "&emsp;";
        for($i = 0; $i < sizeof($words); $i ++) {
            if($declaringFunction == true) {
                $functionLine = true;
                array_push($functions, $words[$i]);
                $declaringFunction = false;
            }
            if($declaringVariable == true) {
                if($shared) {
                    // if(strip($words[$i]) =)
                        array_push($sharedvariables, strip($words[$i]));
                } else {
                    // if(strip($words[$i]) == $words[$i])
                        array_push($variables, strip($words[$i]));
                }
            }
            if(in_array(strip($words[$i]), $keywords)) {
                echo "<span style=\"color: #00d0ff\">".$words[$i]." </span>";
            } else if(substr($words[$i], 0, 1) == "'" || $isComment) {
                $isComment = true;
                echo "<span style=\"color: #626262\">".$words[$i]." </span>";
            } else if(in_array(strip($words[$i]), $reservedWords)) {
                echo "<span style=\"color: #457693\">".$words[$i]." </span>";
            } else if(in_array(strip($words[$i]), $reservedFunct)) {
                echo "<span style=\"color: #8abddb\">".$words[$i]." </span>";
            } else if(in_array(strip($words[$i]), $functions)) {
                echo "<span style=\"color: #55ce55\">".$words[$i]." </span>";
            } else if(in_array(strip($words[$i]), $sharedvariables)) {
                echo "<span style=\"color: #85cec5\">".$words[$i]." </span>";
            } else if(in_array(strip($words[$i]), $variables)) {
                echo "<span style=\"color: #d9b8d9\">".$words[$i]." </span>";
            } else if(in_array(strip($words[$i]), $functionParameters)) {
                echo "<span style=\"color: #e6c467\">".$words[$i]." </span>";
            } else if(is_numeric(strip($words[$i]))) {
                echo "<span style=\"color: #d8624e\">".$words[$i]." </span>";
            } else {
                if($functionLine && strip($words[$i])==$words[$i]) {
                    array_push($functionParameters, strip($words[$i]));
                    echo "<span style=\"color: #e6c467\">".$words[$i]." </span>";
                } else
                    echo "<span style=\"color: #d8d8d8\">".$words[$i]." </span>";
            }
            if($words[$i] == "End") {
                // print_r($functionParameters);
                if($words[$i+1]=="Sub" || $words[$i + 1] == "Function")
                    $functionParameters = array();
                $justEnded = true;
            }
            if($words[$i]=="Next")
                $justEnded = true;
            if(($words[$i] == "Function" || $words[$i] == "Sub") && !$justEnded) {
                $declaringFunction = true;
            }
            if($words[$i] == "Dim")
                $declaringVariable = true;
            if($words[$i]=="Shared")
                $shared = true;
            
            if(in_array(strip($words[$i]), $triggerIndent) && !$justEnded)
                $indents++;
            // foreach($reservedWords )

        }
        echo "<br>";
    }
}
?>
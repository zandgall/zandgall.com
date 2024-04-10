<?php
$ROOT = str_repeat("../", substr_count($_SERVER['REQUEST_URI'], "/"));

// Simply returns the image path with "_x0.25" inserted before ".png", for code shortening
function thumb($image_path) {
    return str_replace(".png", "_x.16.png", $image_path);
}

function format_no_links($text, $data) {
    $out = $text;
    for($left = strpos($out, "{"), $right = strpos($out, "}"); str_contains($out, "{"); $left = strpos($out, "{"), $right = strpos($out, "}")) {
        $content = explode(",", substr($out, $left+1, $right-$left-1));
        $replacement = "";
        switch($content[0]) {
            case "i":
                break;
            default:
                $replacement = $content[2];
        }
        $out = substr($out, 0, $left).$replacement.substr($out, $right+1);
    }
    return substr($out, 0, min(200, strlen($out))).(strlen($out)>200 ? "..." : "");
}

function format($text, $data, $element) {
    $out = str_replace("\r\n", "<br>", $text);
    for($left = strpos($out, "{"), $right = strpos($out, "}"); str_contains($out, "{"); $left = strpos($out, "{"), $right = strpos($out, "}")) {
        $content = explode(",", substr($out, $left+1, $right-$left-1));
        $replacement = "";
        for($i = 0; $i < count($content); $i++)
            $content[$i] = trim($content[$i]);
        switch($content[0]) {
            case "i":
                $replacement = "<sup><a href='#image".$content[1]."'>[".$content[1]."]</a></sup>";
                break;
            case "s":
                $replacement = (($element == "") ? "" : "</".$element.">") .
                "<a class='link' href='../server/".$data["servers"][$content[1]]["page"]."'>".$content[2].
                "<div class='description'>
                    <h1>".$content[1]."</h1>
                    <p>".format_no_links($data["servers"][$content[1]]["description"], $data)."</p>
                    <img src='../".$data["servers"][$content[1]]["thumbnail"]."' alt='".$content[1]." Thumbnail'>
                </div></a>" . (($element == "") ? "" : "<".$element.">");
                break;
            case "p":
                $replacement = (($element == "") ? "" : "</".$element.">") .
                "<a class='link' href='../person/".$content[1]."'>".$content[2]."<div class='description'>
                    <h1>".$content[1]."</h1>
                    <h2>a.k.a: ".$data["people"][$content[1]]["aka"]."</h2>
                    <p>".format_no_links($data["people"][$content[1]]["description"], $data)."</p>
                    <img src='../".$data["people"][$content[1]]["thumbnail"]."' alt='".$content[1]." Thumbnail'>
                </div></a>" . (($element == "") ? "" : "<".$element.">");
                break;
            case "b":
                $replacement = (($element == "") ? "" : "</".$element.">") .
                "<a class='link' href='../build/".$data["builds"][$content[1]]["page"]."'>".$content[2]."<div class='description'>
                    <h1>".$data["builds"][$content[1]]["name"]."</h1>
                    <p>".format_no_links($data["builds"][$content[1]]["description"], $data)."</p>
                    <img src='../".thumb($data["builds"][$content[1]]["thumbnail"])."' alt='".$data["builds"][$content[1]]["name"]." Thumbnail'>
                </div></a>" . (($element == "") ? "" : "<".$element.">");
                break;
            case "e":
                $replacement = (($element == "") ? "" : "</".$element.">") .
                "<a class='link' href='../event/".$data["events"][$content[1]]["page"]."'>".$content[2]."<div class='description'>
                    <h1>".$data["events"][$content[1]]["name"]."</h1>
                    <p>".format_no_links($data["events"][$content[1]]["description"], $data)."</p>
                    <img src='../".thumb($data["events"][$content[1]]["thumbnail"])."' alt='".$data["events"][$content[1]]["name"]." Thumbnail'>
                </div></a>" . (($element == "") ? "" : "<".$element.">");
                break;
            default:
                $replacement = $content[2];
        }
        $out = substr($out, 0, $left).$replacement.substr($out, $right+1);
    }
    return $out;
}

?>

<!DOCTYPE html>
<html>
    <head>
        <?php
        if(isset($title))
            echo "<title>$title</title>";
        ?>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <meta name="description" content="A ross wiki entry">
        <meta name="author" content="Zandgall">
        <link rel="icon" href="<?php echo $ROOT?>ross/Icon.png">
        <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="<?php echo $ROOT?>ross/style.css">
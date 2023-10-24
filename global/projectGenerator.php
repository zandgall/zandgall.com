<?php
function project($width, $height, $name, $description, $imagePath, $linkPath) {
    echo "<a href=\"$linkPath\">";
    echo "<div class=\"proj-container\" style=\"width:$width; height:$height; float:left; position:relative; overflow:visible\">";
    echo "<div class=\"proj\" style=\"width:100%; height:100%\">";
    echo "<img class=\"projimg\" src=\"$imagePath\" alt=\"$name\">";
    echo "<div class=\"splitter\" style=\"position:absolute; width:0%; margin-top:32px\"></div>";
    echo "<h1 class=\"basictext projtitle outlinetext\">$name</h1>";
    echo "<h1 class=\"basictext projsubtitle outlinetext\">$description</h1>";
    echo "<div class=\"projoverlay\"></div>";
    echo "</div>\n</div>\n</a>";
}

?>
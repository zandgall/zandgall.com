<?php
function project($width, $height, $name, $description, $imagePath, $linkPath, $section) {
    echo "<a href=\"$linkPath\">";
    echo "<div class=\"proj-container\" style=\"width:$width; height:{$height}px; float:left; position:relative; overflow:visible\">";
    $name_ = str_replace(" ", "_", $name);
    $name_ = str_replace("!", "_", $name_);
    echo "<div class=\"proj proj$name_\">";
    echo "<style>.proj$name_.active {margin: calc(-0.1 * {$height}px) -10%</style>";
    if($section)
        echo "<h1 class=\"basictext projtitle projsection\">$name</h1>";
    else {
        echo "<img class=\"projimg\" src=\"$imagePath\" alt=\"$name\">";
        echo "<h1 class=\"basictext projtitle\">$name</h1>";
    }
    echo "<div class=\"projoverlay\"></div>";
    echo "<div class=\"projsub projsub$name_\">";
    echo "<style>.projsub$name_ {margin-top: calc(1.2 * {$height}px); width: 66%;} .proj.active > .projsub$name_ {margin-top: calc(1.2 * {$height}px); width: 80%; transition: margin-top 0.5s}</style>";
    echo "<h1 class=\"basictext projsubtitle outlinetext\">$description</h1>";
    echo "</div></div>\n</div>\n</a>";
}

?>

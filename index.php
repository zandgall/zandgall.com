<!DOCTYPE html>
<html lang="en">
<?php
$pagetitle = "Zandgall - Home";
$pagedesc = "A website dedicated to projects created by Zandgall";
include "global/header.php" ?>

<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$title = "Welcome to the site!";
$subtitle = "A resource for Arvopia and other projects";
include "global/begin.php";
include "global/projectGenerator.php"; ?>
<h1 class="outlinetext basictext" style="margin: auto; margin-bottom: 20px">Project Directory</h1>
<div id="projectss" style="position: relative; width:60vw; max-width: 900px; height:calc(2850px * 1); margin:auto">
	<?php
	$projects = json_decode(file_get_contents("./content/projects.json"), true)["projects"];

	foreach ($projects as $key => $value) {
		if (array_key_exists("project", $value)) {
			$link = $value["mainLink"];
			if (array_key_exists("siteLink", $value))
			$link = $value["siteLink"];
			
			project($value["project"]["width"], $value["project"]["height"]*1, $value["name"], $value["tagline"], array_key_exists("thumbnail", $value["project"]) ? $value["project"]["thumbnail"] : "", $link, array_key_exists("section", $value["project"]));
		}
	}
	?>
</div>
	
<?php include "global/end.php" ?>

</html>

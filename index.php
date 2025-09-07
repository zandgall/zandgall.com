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
<div id="projectss" style="position: relative; width:60vw; max-width:900px; height:2850px; margin:auto">
	<?php
	$projects = json_decode(file_get_contents("./content/projects.json"), true)["projects"];

	foreach ($projects as $key => $value) {
		if (array_key_exists("project", $value)) {
			$link = $value["mainLink"];
			if (array_key_exists("siteLink", $value))
				$link = $value["siteLink"];
			project($value["project"]["width"], $value["project"]["height"], $value["name"], $value["tagline"], $value["project"]["thumbnail"], $link);
		}
	}
	?>
</div>

<div style="width:55vw; max-width:800px; height:780px; margin: 5cm auto 0 auto">
	<iframe style="border-radius:12px;" src="https://open.spotify.com/embed/album/0E6QUnse299lO788TWbE8t?utm_source=generator"
		width="100%" height="100%" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
</div>

<div style="width:55vw; max-width: 800px; margin: 5cm auto 0 auto; position: relative">
	<img width="960"
		style="image-rendering: pixelated; width: 120%; margin-top: -10%; margin-left: -10%; margin-bottom: 10%; position: relative"
		src="assets/thumbnail/NBT.png" alt="NBT Video Thumbnail">

	<h1 class="basictext outlinetext" style="font-size: 32pt;">NBT - Lost in the Shadows</h1>
	<h2 class="basictext outlinetext">Video essay on a lesser-known file format, and the general principals of File formats in general!</h2>

	<h3 class="basictext outlinetext">
		We have many different types of files with many different ways to store data. Some types of files try to be very general in the data you can store. One very popular general-data format is "JSON." However, I believe there are alternatives that do a better job of storing data for programs and devices, and one of these types is "NBT."
	</h3>

	<a href="https://youtu.be/12PAtF2Ih_c" style="text-decoration: none; width: 50%; height:90px;  ">
		<div class="section" style="width:30vw; margin: auto; height: 90px; position: relative">
			<h1 class="basictext" style="text-align:center; margin: auto; margin-top: 30px">Watch video</h1>
		</div>
	</a>
</div>

<div class="splitter" style="margin-top: 2cm;"></div>

<h2 class="basictext">
	<a href="https://twitter.com/zandgall?ref_src=twsrc%5Etfw" class="twitter-follow-button" data-size="large"
		data-show-screen-name="false" data-show-count="false">Follow @zandgall</a>
</h2>
<div class="splitter" style="margin-top: 2cm;"></div>
<?php include "global/end.php" ?>

</html>

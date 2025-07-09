<!DOCTYPE html>
<html lang="en">
<?php
$pagetitle = "Zandgall - OpenInsects";
$pagedesc = "A simple simulation of insects crawling around the page";
include "global/header.php" ?>

<script src="Funsies/OpenInsects/insect.js"></script>

<?php
$title = "Insects!";
$subtitle = "One of 5 differents types, keep refreshing for new ones!";
include "global/begin.php" ?>

<style>
	input {
		max-width: 6em;
	}

	form {
		margin: -4em auto auto auto;
		width: 10em;
		opacity: 10%;
		text-align: center;
	}

	form:hover {
		opacity: 80%;
	}
</style>

<form id="form">
	<label for="number" style="font-family:sans-serif"> Number:</label><br>
	<input type="number" id="number" value="100" /><br>
	<label for="size"> Size:</label><br>
	<input type="number" id="size" value="14" /><br>
	<label for="sizevariation"> Variation:</label><br>
	<input type="number" id="sizevariation" value="6" /><br>
	<label for="type"> Type:</label><br>
	<select id="type">
		<option>fly</option>
		<option>moth</option>
		<option>mantis</option>
		<option>ladybug</option>
		<option>bee</option>
	</select><br>
	<input type="submit" id="again" name="again" value="Again!" />
</form>

<canvas id="Canvas" class="bg" style="z-index: 1; pointer-events: none">Canvas is not supported</canvas>
<script src="Funsies/OpenInsects/openinsects.js"></script>

<?php include "global/end.php" ?>

</html>

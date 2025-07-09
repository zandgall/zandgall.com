<?php

ini_set('session.gc_maxlifetime', 36000);
session_set_cookie_params(36000);

session_start();

include "login.php";
if (!isset($_SESSION["logged"])) {
	return;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Translation</title>
	<link rel="stylesheet" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body>
	<form id="commandCenter">
		<input type="submit" value="⟳" />
		<input id="command" name="command" type="text" placeholder="command">
		<input id="project" name="project" type="hidden">
		<input id="filters" name="filters" type="text" placeholder="filters">
	</form>

	<main id="main">
		<section id="dictionary"></section>
	</main>
	<script src="source.js" type="application/javascript"></script>
</body>


</html>

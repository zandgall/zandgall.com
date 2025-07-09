<?php

if (isset($_POST["username"])) {
	if ($_POST["username"] == "zandgall" && $_POST["password"] == "Z3DavidGall")
		$_SESSION["logged"] = true;
	else if ($_POST["username"] == "crepecrabcakes" && $_POST["password"] == "crepeisyummy2")
		$_SESSION["logged"] = true;
	else {
		echo "
        <div>
            <h1>Incorrect</h1>
            <p>Sorry :)</p>
        </div>
        ";
	}
}

if (isset($_SESSION["logged"])) {
	return;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login</title>
	<style>
		form {
			margin: auto;
			text-align: center;
		}

		input {
			margin: 1mm;
		}
	</style>
</head>

<body>
	<form method="post">
		<input type="text" name="username" placeholder="Username"><br>
		<input type="password" name="password" placeholder="Password"><br>
		<input type="submit" value="Sign in">
	</form>
</body>

</html>

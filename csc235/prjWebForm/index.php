<?php 

/**
 * Nov 3rd, 2023
 * Zander Gall
 * CSC235 - Prof. Furtney
 */

session_start();?>

<!DOCTYPE html>
<html>
	<?php
		$data = array(
			array("Super Car", "Create a car with an assortment of nefarious attachments.", "Car, Gadgets, Massive laser beam", "$15,000,000"),
			array("Build Lair", "Build a lair to hold other projects and plot in.", "Digging equipment, spooky lights, home insurance", "$10,000,000"),
			array("Evil Clone", "Create an Evil Clone to rule with me.", "Cloning machine?", "$25,000,000"),
			array("Catch Nemesis", "Catch that rotten good-for-nothing \"Hero\" that keeps thwarting my plans.", "???", "???")
		);

		// Used for debugging
		//print_r($_POST);

		// First check if user wants to forget session.
		if(isset($_POST["hidFlag"]) && $_POST["hidFlag"]=="forget")
			session_unset(); 

		// If session present, use session's array. Otherwise update session variable local data.
		if(isset($_SESSION["data"]))
			$data = unserialize(urldecode($_SESSION["data"]));
		else
			$_SESSION["data"] = urlencode(serialize($data));

		// Unset the selected element of the $data array, then push to session memory
		function removeElement() {
			global $data;
			unset($data[$_POST["lstSelectedElement"]]);
			$_SESSION["data"] = urlencode(serialize($data));
		}

		// Add new element to $data using form $_POST data
		function addElement() {
			global $data;
			array_push($data, array($_POST["txtName"], $_POST["txtDescription"], $_POST["txtMaterials"], $_POST["txtCost"]));
			$_SESSION["data"] = urlencode(serialize($data));
		}

		// Handle remaining user input
		if(isset($_POST["hidFlag"])) {
			if($_POST["hidFlag"] == "del")
				removeElement();
			else if($_POST["hidFlag"] == "add")
				addElement();
		}
	?>
<!--Begin HTML response-->
<head>
	<title>Evil Plotting Website - DONT TOUCH!!!</title>
	<link rel="icon" href="graphic/icon.png">
	<link rel="stylesheet" href="style.css?v=2">

	<!-- Load the "Griffy" font family from Google Fonts API -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lugrasimo:wght@200..900">
</head>
<body>
	<header>
		<h1>connected to... <?php echo $_SERVER["SERVER_NAME"]?></h1>
		<h2>Evil plotting web page for evil plotting purposes only.</h2>
		<h3>If you aren't allowed here.. SCRAM!</h3>
	</header>
	<main>
		<image id="background" src="graphic/fire.gif"/>
		<table>
			<thead>
				<tr>
					<th>Name</th>
					<th>The Plan...</th>
					<th>Materials</th>
					<th>Estimated Cost</th>
				</tr>
			</thead>

			<tbody>
			<?php
			// Use PHP to fill in the rest of the table
			foreach($data as $plan) {
				echo "<tr>";
				foreach($plan as $entry) {
					echo "<td>".$entry."</td>";
				}
				echo "</tr>";
			}
			?>
			</tbody>
		</table>

		<!--An empty (or absent) action attribute will cause the page to request itself-->
		<!--Add Form: Takes in a name, description, and 'cost', and passes it to the PHP function "addElement", via a hidden switch flag-->
		<form method="POST" id="addForm">
			<fieldset>
				<legend>Add new plan with given details</legend>
				<div>
					<label for="txtName">Name:</label>
					<input type="text" name="txtName" value="Super Shrinkray">
				</div>
				<div>
					<label for="txtDescription">Plan Description:</label>
					<input type="text" name="txtDescription" value="Ray that shrinks everything down to the size of ants">
				</div>
				<div>
					<label for="txtMaterials">Materials:</label>
					<input type="text" name="txtMaterials" value="Antimatter, nerf gun">
				</div>
				<div>
					<label for="txtCost">Estimated Cost:</label>
					<input type="text" name="txtCost" value="$5,000,000">
				</div>
				<input type="hidden" name="hidFlag" value="add">
				<div class="submitParent">
					<input type="submit" name="submitAdd" value="Add" id="submitAdd">
				</div>
			</fieldset>
		</form>
		
		<form method="POST" id="deleteForm">
			<fieldset>
				<legend>Select plan to delete/mark complete</legend>
				<div style="width:fit-content; margin:auto">
					<label for="lstSelectedElement">Select</label>
					<select name="lstSelectedElement" size="1">
						<?php
						// Add an option for removal for every plan
						foreach($data as $index => $plan) {
							echo "<option value=\"$index\">{$plan[0]}</option>";
						}
						?>
					</select>
					<label for="submitDelete">and</label>
					<input type="hidden" name="hidFlag" value="del">
				</div>
				<div class="submitParent">
					<input type="submit" name="submitDelete" value="Delete/Mark Complete">
				</div>
			</fieldset>
		</form>
	</main>
	<footer>
		<form method="POST">
			<input type="hidden" name="hidFlag" value="forget">
			<div class="submitParent">
				<input type="submit" value="Forget Session" style="opacity: 0.5">
			</div>
		</form>
	</footer>
</body>
</html>
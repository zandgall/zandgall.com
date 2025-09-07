<!DOCTYPE html>
<html>
<?php
$pagetitle = "Zandgall - TicTacToe";
$pagedesc = "Just a normal average game of TicTacToe";
include "../global/header.php";
?>
<style>
	main {
		position: absolute;
		left: 0;
		top: 0;
		background-color: rgba(200, 200, 255, 0.5);
		width: 100%;
		display: flex;
		flex-direction: row;
		flex-wrap: wrap;
		justify-content: space-between
	}

	main section {
		margin: auto;
	}

	#templates button {
		padding: 5mm;
		font-size: 12pt;
		border: 1px solid black;
		border-radius: 5mm;
	}

	main div {
		display: block;
		padding: 5mm;
		margin: 5mm;
		border: 2px solid black;
		border-radius: 5mm;
		background-color: rgba(200, 200, 255, 0.5);
	}

	#viewRules {
		position: absolute;
		left: 0;
		top: 0;
		cursor: pointer;
		display: none;
	}
</style>
</head>

<body>
	<canvas style="width:100%; height:100%; display:block;" id="canvas"></canvas>
	<div id="viewRules">
		<p id="rules">Rules</p>
	</div>
	<main style="display:none">
		<section id="templates">
			<h1>Presets</h1>
			<button id="expansion" onclick="startTemplate({match:3,replacement:false,expanding:true,goal:10})">Expansion</button>
			<button id="conquest" onclick="startTemplate({match:3,width:10,height:10,replacement:true,expanding:false,goal:40})">Conquest</button>
		</section>
		<section id="options">
			<h1>Options</h1>
			<div>
				<input type=" checkbox" id="remember" name="remember" onclick="remember()">
				<label for="remember">Remember settings, and skip to menu on reload. (Uses cookies!)</label>
			</div>
			<div>
				<input type="number" id="width" name="width" value=3 min=1 onclick="inputWidth()">
				<label for="width">Grid Width</label>
			</div>
			<div>
				<input type="number" id="height" name="height" value=3 min=1 onclick="inputHeight()">
				<label for="height">Grid Height</label>
			</div>
			<div>
				<input type="number" id="match" name="match" value=3 min=1 onclick="inputMatch()">
				<label for="match">Length of a match</label>
			</div>
			<div>
				<input type="number" id="goal" name="goal" value=10 min=1 onclick="inputGoal()">
				<label for="goal">Matches to win</label>
			</div>
			<div>
				<input type="checkbox" id="expanding" name="expanding" checked onclick="inputExpanding()">
				<label for="expanding">Grid expands when full</label>
			</div>
			<div>
				<input type="checkbox" id="replacement" name="replacement" onclick="inputReplacement()">
				<label for="replacement">Allow replacing moves that aren't already a part of a match</label>
			</div>
			<div>
				<button id="start" onclick="start()">Start</button>
			</div>
		</section>
	</main>
	<script src="tictactoe.js?v=2"></script>
</body>

</html>

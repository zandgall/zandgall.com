<!DOCTYPE html>
<html>
<?php
$pagetitle = "Zandgall - Flow";
$pagedesc = "A detailed vector field on the web.";
include "../global/header.php";
?>
<style>
	main {
		position:absolute; 
		left:0; 
		top:0;
		background-color: rgba(200, 200, 255, 0.5);
		width:100%;
		display:flex;
		flex-direction:row;
		flex-wrap:wrap;
		justify-content:space-between
	}
	main>div {
		display:block;
		padding:5mm;
		margin:5mm;
		border:2px solid black;
		border-radius: 5mm;
		background-color: rgba(200, 200, 255, 0.5);
	}
</style>
<script
      src="https://cdnjs.cloudflare.com/ajax/libs/gl-matrix/2.8.1/gl-matrix-min.js"
      integrity="sha512-zhHQR0/H5SEBL3Wn6yYSaTTZej12z0hVZKOv3TwCUXT1z5qeqGcXJLLrbERYRScEDDpYIJhPC1fk31gqR783iQ=="
      crossorigin="anonymous"
      defer></script>
</head>
<body>
    <div style="width:100%; height:100%; position:fixed; display:none;" id="warning"><h1>Your device may not support WebGL. Failed to initialize.</h1></div>
	<canvas style="width:100%; height:100%; display:block;" id="canvas"></canvas>
	<script src="flow.js"></script>
</body>
</html>

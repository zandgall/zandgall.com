<?php 
$title = "Timeline of ROSS"; 
include "./gen/head.php";
$json_file = file_get_contents("../ross/data.json");
$data = json_decode($json_file, true);
$builds = $data["builds"];
$events = $data["events"];
$people = $data["people"];
$groups = $data["groups"];
?>
<link rel="stylesheet" href="<?php echo $ROOT?>ross/timeline.css">
	</head>
	<body>
		<section id='quicklinks'>
			<h1>Quick Links</h1>
			<a href="#20200402">Ross 2</a>
			<a href="#20220610">Ross 3</a>
			<a href="#20220610">Ross 4</a>
		</section>

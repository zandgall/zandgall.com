
<?php $title = "Timeline of ROSS"; include "./gen/head.php";?>
	<link rel="stylesheet" href="<?php echo $ROOT?>ross/timeline.css">
	</head>
	<body>
		<section id='quicklinks'>
			<h1>Quick Links</h1>
			<a href="#20200402">Ross 2</a>
			<a href="#20220610">Ross 3</a>
		</section>
<?php 
	$json_file = file_get_contents("../ross/data.json");
	$data = json_decode($json_file, true);
	$builds = $data["builds"];
	$events = $data["events"];
	$people = $data["people"];
	$groups = $data["groups"];

	$day_size = 100; // in pixels
	$time_period = new DatePeriod(new DateTime("2019-05-08"), new DateInterval("P1D"), new DateTime());
	$length = 0;
	foreach ($time_period as $date) {
		$occurances = [];
		foreach($people as $name => $person) {
			if(new DateTime($person["join-date"]) == $date)
				array_push($occurances, "{p,$name,$name joins}");
			if(new DateTime($person["leave-date"]) == $date)
				array_push($occurances, "{p,$name,$name leaves}");
		}
		foreach($groups as $group) {
			if(new DateTime($group["start-date"]) == $date)
				array_push($occurances, "{g,{$group["name"]},{$group["name"]} forms}");
			if(new DateTime($group["end-date"]) == $date)
				array_push($occurances, "{g,{$group["name"]},{$group["name"]} dibands}");
		}
		for($i = 0; $i < count($events); $i++)
			if(new DateTime($events[$i]["date"]) == $date)
				array_push($occurances, "{e,$i,{$events[$i]["name"]}}");
		for($i = 0; $i < count($builds); $i++)
			if(new DateTime($builds[$i]["constructed"]) == $date)
				array_push($occurances, "{b,$i,{$builds[$i]["name"]} is Built}");
		$length++;
		if (count($occurances)>0) {
			if($length % 2 == 0) {
				echo "<div class='container'><div class='marker' style='right:calc(50vw + 5px); top:".($day_size * $length)."px; border-bottom-left-radius:25px;'></div>
				<a href='#' class='next' style='right:calc(50vw + 5px); top:".($day_size * $length + 50)."px'>Next</a>
				<div class='day-text' style='right:calc(50vw + 5px); text-align: right; top:".($day_size * $length - 26)."px' id='{$date->format("Ymd")}'>{$date->format("F jS, Y")}</div>
				<div class='horizontal-indicator' style='right:calc(50vw + 55px); top:".($day_size * $length)."px'></div>
				<div class='day' style='left:0; top:".($day_size * $length+5)."px; width: calc(50vw - 55px); flex-direction: row-reverse;'>";
			} else 
				echo "<div class='container'><div class='marker' style='left:calc(50vw + 5px); top:".($day_size * $length)."px; border-bottom-right-radius:25px;'></div>
				<a href='#' class='next' style='left:calc(50vw + 5px); top:".($day_size * $length + 50)."px'>Next</a>
				<div class='day-text' style='left:calc(50vw + 5px); text-align: left; top:".($day_size * $length - 26)."px' id='{$date->format("Ymd")}'>{$date->format("F jS, Y")}</div>
				<div class='horizontal-indicator' style='left:calc(50vw + 55px); top:".($day_size * $length)."px'></div>
				<div class='day' style='right:0; top:".($day_size * $length+5)."px; width: calc(50vw - 55px);'>";
			for($i = 0; $i < count($occurances); $i++) {
				echo "<div class='occurance".(count($occurances)>3 ? " tight" : ""). "'>".format($occurances[$i], $data, "")."<div class='pointer' style='top:0'></div></div>";
			}
			echo "</div></div>";
		}
	}
	echo "<div id='line' style='height:".($length*$day_size)."px; position:absolute; left:calc(50vw - 5px); top:0; width:10px; background-color:#ff0000'></div>";
?>
<script>
	$(function() {
		$(".pointer").each(function() {
			let rect = this.parentElement.getBoundingClientRect();
			let uprect = this.parentElement.parentElement.getBoundingClientRect();
			$(this).css("left", (rect.width * 0.5 + (rect.x - uprect.x))+"px");
			console.log(this, this.parentElement);
			$(this).show();
		});
		let nextid = "";
		$($(".day-text").get().reverse()).each(function() {
			console.log(this, nextid);
			if(nextid!="")
				$(this).parent().children(".next").attr("href", "#"+nextid);
			nextid = $(this).attr("id");
		});
	});
</script>
<?php include "./gen/footer.php";?>

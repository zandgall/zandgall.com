<?php
$ROOT = str_repeat("../", substr_count($_SERVER['REQUEST_URI'], "/"));
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Reference Sheet</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <meta name="description" content="A ross wiki entry">
        <meta name="author" content="Zandgall">
        <link rel="icon" href="<?php echo $ROOT?>ross/Icon.png">
        <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="style.css">
        <style>
            table {
                font-family:sans-serif;
                border: 1px solid black;
            }
            td, th {
                padding: 2mm;
                margin:0;
                border: 1px solid black;
            }
            .n {
                font-weight:bold;
            }
            .i {
                font-style:italic;
            }
            .c {
                font-weight:lighter;
            }
        </style>
    </head>
    <body>
<?php
$json_file = file_get_contents("../data.json");
$data = json_decode($json_file, true);

echo "
<h1>Builds</h1>
<table>
<tr><th>Index</th><th>Name</th><th>Citation</th></tr>";
for($i = 0; $i < count($data["builds"]); $i++) {
    echo "<tr><td class='i'>$i</td><td class='n'>{$data['builds'][$i]['name']}</td><td class='c'>{b,$i,Link Text}</td></tr>";
}
echo "</table>
<h1>People</h1>
<table>
<tr><th>Name</th><th>Citation</th></tr>";
foreach($data["people"] as $name => $player) {
    echo "<tr><td class='n'>$name</td><td class='c'>{p,$name,Link Text}</td></tr>";
}
echo "</table>
<h1>Servers</h1>
<table>
<tr><th>Name</th><th>Citation</th>";
foreach($data["servers"] as $name => $server) {
    echo "<tr><td class='n'>$name</td><td class='c'>{s,$name,Link Text}</td></tr>";
}
echo "</table>
<h1>Events</h1>
<table>
<tr><th>Index</th><th>Name</th><th>Citation</th></tr>";
for($i = 0; $i < count($data["events"]); $i++) {
    echo "<tr><td class='i'>$i</td><td class='n'>{$data['events'][$i]['name']}</td><td class='c'>{e,$i,Link Text}</td></tr>";
}
?>
</table>
</body>
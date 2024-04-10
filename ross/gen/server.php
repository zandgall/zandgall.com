<?php
    $json_file = file_get_contents("../data.json");
    $data = json_decode($json_file, true);
    $servers = $data["servers"];
    $server = $servers[$SERVER_ID];
    echo "<title>Server - $SERVER_ID</title>";
?>
    <link rel="stylesheet" href="<?php echo $ROOT?>ross/gen/group.css">
</head>
<body>
    <main>
        <img id="thumbnail" src="../<?=$server["thumbnail"]?>">
        <h1 id="Name"><?=$SERVER_ID?></h1>
        <div class="text"><p id="Description"><?=format($server["description"], $data, "p")?></p></div>
        <div class="text"><p id="Date"><?=$server["beginning"]?> - <?=$server["ending"]?></p></div>
    </main>
    <h1>Members</h1>
    <section class="selection">
        <?php 
        for($i = 0; $i < count($server["members"]); $i++) {
            echo "<a class='select-link' href='../person/{$server["members"][$i]}'><div class='select mcbg'>
                <h1>{$server["members"][$i]}</h1>
                <img src='../skins/{$server["members"][$i]}.png' style='height:360px; width:auto; image-rendering:pixelated' alt=\"{$server["members"][$i]}'s skin\">
            </div></a>";
        }
        ?>
    </section>
    <h1>Events</h1>
    <section class="long-selection">
        <?php
        foreach($data["events"] as $event):
            if($event["server"]==$SERVER_ID):?>
                <a class='select-link' href='../event/<?=$event["page"]?>'><div class='select mcbg'>
                <h1><?=$event["name"]?></h1>
                <img src='../<?=$event["thumbnail"]?>' style='height:90px; width:90px; object-fit: cover; display: block; margin:5px;' alt="<?=$event["name"][$i]?>">
            </div></a>
        <?php endif;
        endforeach;?>
    </section>
    
    <h1>Builds</h1>
    <section class="long-selection">
        <?php
        foreach($data["builds"] as $build):
            if($build["server"]==$SERVER_ID):?>
                <a class='select-link' href='../build/<?=$build["page"]?>'><div class='select mcbg'>
                <h1><?=$build["name"]?></h1>
                <img src='../<?=$build["thumbnail"]?>' style='height:90px; width:90px; object-fit: cover; display: block; margin:5px;' alt="<?=$build["name"][$i]?>">
            </div></a>
        <?php endif;
        endforeach;?>
    </section>
</body>
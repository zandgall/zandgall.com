<?php
    $json_file = file_get_contents("../data.json");
    $data = json_decode($json_file, true);
    $builds = $data["builds"];
    $build = $builds[$BUILD_ID];
    echo "<title>{$build["server"]} - {$build["name"]}</title>";
?>
    <link rel="stylesheet" href="<?php echo $ROOT?>ross/gen/build.css">
</head>
<body>
    <main>
        <section id='card' class='mcbg'>
            <img id='thumbnail' src='../<?=$build["thumbnail"]?>'>
            <div>
                <div class='header'><p>Server:</p></div>
                <div class='text'><p><?=$build["server"]?></p></div>
            </div>
            <div>
                <div class='header'><p>Type:</p></div>
                <div class='text'><p><?=$build["type"]?></p></div>
            </div>
            <div>
                <div class='header'><p>Coordinates:</p></div>
                <div class='text'><p>(<?=$build["coordinates"][0]?>, <?=$build["coordinates"][1]?>, <?=$build["coordinates"][2]?>)</p></div>
            </div>
            <div>
                <div class='header'><p>Constructed:</p></div>
                <div class='text'><p><?=$build["constructed"]?></p></div>
            </div>
            <div>
                <div class='header'><p><?=count($build["builders"]) > 1 ? "Builders" : "Builder"?></p></div>
                <div class='text'><p>
                <?php for($i = 0; $i < count($build["builders"]); $i++) {
                    echo $build["builders"][$i];
                    echo $i<count($build["builders"]) - 1 ? ", " : "";
                } ?>
                </p></div>
            </div>
        </section>
        <h1 id="Name"><?=$build["name"]?></h1>
        <p id="Description"><?=format($build["description"], $data, "p")?></p>
    </main>
    <?php if(count($build["images"])>0): ?>

        <h2 id="Gallery">Gallery</h2>
        <section id="Images">
            <?php for($i = 0; $i < count($build["images"]); $i++):?>
                <div class='img-container' id='image<?=$i?>'>
                    <div class='overlay'></div>
                    <?php if(str_ends_with($build["images"][$i]["src"], "mp4")): ?>
                        <video autoplay muted loop><source src="../<?=$build["images"][$i]["src"]?>" type="video/mp4"></video>
                    <?php else: ?>
                        <img src="../<?=$build["images"][$i]["src"]?>" alt="<?=$build["images"][$i]["caption"]?>">
                    <?php endif; ?>
                    <p class="caption"><?=format($build["images"][$i]["caption"], $data, "p")?></p>
                </div>
            <?php endfor; ?>
        </section>

    <?php endif;?>
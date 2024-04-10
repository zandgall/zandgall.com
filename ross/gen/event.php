<link rel="stylesheet" href="<?php echo $ROOT?>ross/gen/build.css">
</head>
<body>
    <?php
        $json_file = file_get_contents("../data.json");
        $data = json_decode($json_file, true);
        $events = $data["events"];
        $event = $events[$EVENT_ID];
    ?>

    <main>
        <section id='card' class='mcbg'>
            <img id='thumbnail' src='../<?=$event["thumbnail"]?>'>
            <div>
                <div class='header'><p>Server:</p></div>
                <div class='text'><p><?=$event["server"]?></p></div>
            </div>
            <div>
                <div class='header'><p>Type:</p></div>
                <div class='text'><p><?=$event["type"]?></p></div>
            </div>
            <div>
                <div class='header'><p>Date:</p></div>
                <div class='text'><p><?=$event["date"]?></p></div>
            </div>
            <?php if($event["type"] == "Extended Event"):?>
                <div>
                    <div class='header'><p>Ending:</p></div>
                    <div class='text'><p><?=$event["ending"]?></p></div>
                </div>
            <?php endif; ?>
            <div>
                <div class='header'><p>Involved:</p></div>
                <div class='text'><p>
                <?php 
                for($i = 0; $i < count($event["involved"]); $i++) {
                    echo $event["involved"][$i];
                    if($i < count($event["involved"])-1)
                        echo ", ";
                } ?>
                </p></div>
            </div>
        </section>
        <h1 id='Name'><?=$event["name"]?></h1>
        <p id="Description"><?=format($event["description"], $data, "p")?></p>
    </main>
    <?php if(count($event["images"])>0): ?>
        <h2 id="Gallery">Gallery</h2>
        <section id="Images">
            <?php for($i = 0; $i < count($event["images"]); $i++): ?>
                <div class="img-container" id="image<?=$i?>">
                    <div class="overlay"></div>
                    <?php if(str_ends_with($event["images"][$i]["src"], "mp4")): ?>
                        <video autoplay muted loop><source src='../<?=$event["images"][$i]["src"]?>' type="video/mp4"></video>
                    <?php else: ?>
                        <img src="../<?=$event["images"][$i]["src"]?>" alt="<?=$event["images"][$i]["caption"]?>">
                    <?php endif; ?>
                    <p class="caption"><?=format($event["images"][$i]["caption"], $data, "p")?></p>
                </div>
            <?php endfor; ?>
        </section>
    <?php endif; ?>
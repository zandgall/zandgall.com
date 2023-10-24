<?php
$x = 0;
$z = 0;
$w = 1;
$h = 1;
$s = 16;
if(isset($_GET["x"]))
    $x = $_GET["x"];
if(isset($_GET["z"]))
    $z = $_GET["z"];
if(isset($_GET["w"]))
    $w = $_GET["w"];
if(isset($_GET["h"]))
    $h = $_GET["h"];
if(isset($_GET["scale"]))
    $s = $_GET["scale"];
?>


<body id="body">
    <script type="application/javascript">
        
        async function aaaa() {
            const options = {
                method: "GET"
            }
            <?php
            echo "let response = await fetch(\"image.php?x=$x&z=$z&w=$w&h=$h&scale=$s\", options)\n"
            ?>
            if (response.status === 200) {
                console.log("Updating!");
                const imageBlob = await response.blob()
                const imageObjectURL = URL.createObjectURL(imageBlob);

                if(document.getElementById("hello")==null) {
                    const image = document.createElement('img')
                    image.id = "hello";
                    image.src = imageObjectURL;
                    const container = document.getElementById("body")
                    container.append(image)
                } else {
                    const image = document.getElementById('hello')
                    image.src = imageObjectURL;
                }
                var current = new Date();
                if(document.getElementById("updated")==null) {
                    const up = document.createElement('p')
                    up.id = "updated";
                    up.innerHTML = "Updated " + current.toLocaleString();
                    const container = document.getElementById("body")
                    container.append(up)
                } else {
                    const up = document.getElementById("updated")
                    up.innerHTML = "Updated " + current.toLocaleString();
                }
            }
            else {
                console.log("HTTP-Error: " + response.status)
            }
        }
        async function loooop() {
            while(true)
                await aaaa();
        }
        loooop();
    </script>
</body>
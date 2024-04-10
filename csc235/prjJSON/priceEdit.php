<!-- 
    Zander Gall - galla@csp.edu
    CSC235 - Prof. Furtney

    12/4/23 - Jumping straight into the assignment to avoid crunch time, will go through learning materials if/when I don't understand something
            - Finished functionality
    12/9/23 - Added items ('shelf') display
 -->

<?php

session_start();

if(!isset($_SESSION["data"])) {
    // Take the data from priceData.json, decode it from JSON, serialize it, and the encode it into the $_SESSION variable
    // Very little I can do to make this line of code look pretty
    $_SESSION["data"] = urlencode( serialize( json_decode( file_get_contents("./priceData.json"), TRUE) ) );
}

// Take whatever is currently in the $_SESSION variable and decode and deserialize it into the $data variable
$data = unserialize(urldecode($_SESSION["data"]));

// Form logic
if(isset($_POST["hidIndex"])) {
    // Grab (shorten) index
    $i = $_POST["hidIndex"];
    // Update $data
    $data["products"][$i]["name"]=$_POST["txtName"];
    $data["products"][$i]["color"]=$_POST["txtColor"];
    $data["products"][$i]["price"]=$_POST["txtPrice"];
    $data["products"][$i]["description"]=$_POST["txtDescription"];

    // I dont see why we're using sessions if we're updating the actual file data, but
    // update session variable and write new data to priceData.json file
    $_SESSION["data"] = urlencode(serialize($data));
    file_put_contents("./priceData.json", json_encode($data));
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Price Edit</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <section id = "shelf">
            <!-- Using alt PHP syntax to add a curveball in here -->
            <?php foreach($data["products"] as $index=>$product): ?>
                <div>
                    <h1>#<?=$index?> - <?=$product["name"]?></h1>
                    <hr>
                    <h2>$<?=$product["price"]?></h2>
                    <h3><?=$product["color"]?></h3>
                    <hr>
                    <p><?=$product["description"]?></p>
                </div>
            <?php endforeach; ?>
        </section>
        <section>
            <?php        
            // For every product, echo a form with input for name, price, color, and description
            // Every input will have onchange=submit form
            foreach($data["products"] as $index=>$product) {
                echo "<form method='post' id='form$index'>\n
                        <label for='txtName'>Name: </label>\n
                        <input type='text' name='txtName' value='{$product["name"]}' onchange='this.form.submit()'>\n
                        <label for='txtPrice'>Price: $</label>\n
                        <input type='text' name='txtPrice' value='{$product["price"]}' onchange='this.form.submit()'>\n
                        <label for='txtColor'>Color: </label>\n
                        <input type='text' name='txtColor' value='{$product["color"]}' onchange='this.form.submit()'>\n
                        <label for='txtDescription'>Description: </label>\n
                        <input type='text' name='txtDescription' value='{$product["description"]}' onchange='this.form.submit()'>\n
                        <input type='hidden' name='hidIndex' value='$index'>\n
                    </form>";
            }
            ?>
        </section>
        <section>
            <p>Changes save automatically</p>
            <p>Apologies for the lack of content and creativity this week, I am trying to pool all of my creative effort into the final term project, as I do really want to get that done in a specific way.</p>
            <p>AJAX stands for Asynchronous JavaScript And XML. It doesn't really necessarily have anything to do with XML, only XMLHttpRequest. AJAX is the term for using XMLHttpRequests in JavaScript in order to request or post data from/to a server. </p>
            <p>AJAX will be used in my final project.</p>
            <p id="ajax">(Use the button to request data using JavaScript only)</p>
            <button onclick="doAjax()">Do AJAX</button>
        </section>
    </main>

    <script type="application/javascript">
        // Simple AJAX function
        // Creates XMLHR, adds a statechange listener, set the type (GET) and path, use no caching, and apply
        function doAjax() {
            let x = new XMLHttpRequest();
            x.onreadystatechange = function() {
                if(this.readyState == 4 && this.status == 200) {
                    document.getElementById("ajax").innerHTML = x.responseText;
                }
            }
            x.open("GET", "./priceData.json");
            x.setRequestHeader("Cache-Control", "no-cache"); // Make sure it's up to date
            x.send();
        }
    </script>
</body>
</html>
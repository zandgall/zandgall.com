<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="utf-8" />
   <title>Programming Truth #10</title>
   <style>
        body {
            font-family:optima, helvetica, arial, sans-serif;
        }
        h1 {
            background: #EEE; /* light gray */
            color: #000080; /* navy blue  */
            border: 1px solid #000080;
            padding: 10px;
        }
        img {
            border-radius: 15px;
        }
        img#inText {
             margin: 0 25px 0 0;
            width: 200px;
            float: left;
        }
    </style>

    <?php
        // set up a series of PHP variables
        // In the future versions this text 
        // might be extracted from a database.
        $whole  = "<strong>Whole picture thinking: </strong>";
        $focus  = "<strong>Focusing on details: </strong>";  
        $source = "<i>Images courtesy of StockSnap.io</i> 
                  <a href='https://stocksnap.io/search/eagle/sort/relevance/desc' target='_blank'>StockSnap.io</a>
                  <br />Licensed under public domain."
   ?>

    <!-- Add the JavaScript layer to the page -->
    <script>
        // Display list of questions
        function displayList( ) { 
            document.write("<ul>");
            document.write("<li><?php echo $whole;?>What is this program going to accomplish?</li>");
            document.write("<li><?php echo $focus;?>What will this line do right now?</li>");
            document.write("<li><?php echo $whole;?>How will the users react to this?</li>");
            document.write("<li><?php echo $focus;?>What is causing this variable to change?</li>");
            document.write("<li><?php echo $focus;?>What will happen next?</li>");
            document.write("</ul>");
       } // end of displayList( )
    </script>
</head>
<body>
    <h1>Programming Truth #10</h1>
    <h2>Programming is an exact science. Programming is an art.</h2>
    <p>
        <img id="inText" src="eagle.png" alt="Portrait of a Bald Eagle" />
        Eagles are known for their excellent vision. They can view things from afar
        and zoom in on details at the same time.
    </p>
    <p>
        Eagles have an angle of vision of about 300 degrees and can magnify any 
        given image up to eight times. They can scan an area of 30,000 hectares from
        4,500 feet up in the air. From this height, they can also see a rabbit in 
        the grass.
    </p>
    <p>
        As a programmer, you have to be able to do the same thing with your code. 
        You have to be able to understand the whole picture of the program while at 
        the same time being able to zoom in and focus on minute details.
    </p>
    <h2>Use your eagle eyes as you program.</h2>
    <script>
        displayList( );
    </script>
    <p>
        [This image displayed using PHP]
    </p>
    <?PHP echo "<img src='eagleEye.png' alt='Close up of eagle's eye' />";?>
    <br />
    <cite><?PHP echo $source ?></cite>
</body>
</html>
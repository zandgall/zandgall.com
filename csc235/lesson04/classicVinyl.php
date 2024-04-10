

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <!-- classicVinyl.html - Demonstrate using SELECT to display data
    Student Name
    Written:   Original Date
    Revised:   Current Date
    -->
    <title>Classic Vinyl</title>

    <link rel="stylesheet" type="text/css" href="classicVinyl.css">
    <?php

    // Set up constants for each table format
	define('SONG', '0');
	define('BAND', '1');
	define('SONG_ALBUM', '2');
	define('ARTIST_BAND', '3');
	$tableFormat = SONG;
	$sql = 'SELECT * FROM song';

	// Is this a return visit?
	if(array_key_exists('hidIsReturning',$_POST)) {
		echo '<h1>Welcome BACK to Classic Vinyl!</h1>';
		print_r($_POST);

        echo '<br />';

        // display the list of music works based on the selection
        if(isset($_POST['lstDisplay'])) {
            // Save item that was selected by the user
            $selection = $_POST['lstDisplay'];
            echo 'DEBUG $selection: ' . $selection . '<br />';
            switch($selection) {
                case "song": {
                    $tableFormat=SONG;
                    $sql = "SELECT * FROM song";
                    break;
                }
                case "band": {
                    $tableFormat=BAND;
                    $sql= "SELECT * FROM band ORDER BY name";
                    break;
                }
                case "songAlbum": {
                    $tableFormat=SONG_ALBUM;
                    $sql = "SELECT song.songTitle, song.url, album.albumTitle, album.price
                            FROM song
                            JOIN album
                            WHERE song.album_id = album.album_id
                            ORDER BY album.albumTitle";
                    break;
                }
                case "artistBand": {
                    $tableFormat=ARTIST_BAND;
                    $sql = "SELECT 
                                band.band_id, 
                                band.name, 
                                artistBand.band_id,
                                artistBand.artist_id,
                                artist.fName,
                                artist.lName
                            FROM band
                            JOIN artistBand
                            ON band.band_id = artistBand.band_id
                            JOIN artist
                            ON artist.artist_id = artistBand.artist_id
                            ORDER BY artist.lName";
                    break;
                }
                default: echo $selection . 
                    ' is not a valid choice from the list of displays<br />';
            }// end of switch( )
        } // if(isset( ))
	}
	else // or, a first time visitor?
	{
		echo '<h1>Welcome FIRST TIME to Classic Vinyl</h1>';
	} // end of if new else returning

    function displayData( ) {
		global $sql;
		global $tableFormat;
		echo 'DEBUG: $sql: ' . $sql . '<br />';
		// Create a database object
		// PARAMETERS:   server       user    password          database
		$db = new mysqli('localhost', 'remote', 'mysqlCSC235', 'classicVinyl');
	  
		if($db->connect_errno > 0){
		 die('Unable to connect to database [' . $db->connect_error . ']');
		}
		
		// Get the data from the database using SQL
		if(!$result = $db->query($sql)){
		 die('There was an error running the query [' . $db->error . ']');
		}
		
		// Display the list of titles
		// while($row = $result->fetch_assoc()){
		// 	echo $row['songTitle'] . '<br />';
		//  }
        switch($tableFormat) {
            case SONG:
            {
                echo '<h2>Song List</h2>';
                echo '<table>';
                echo '<tr>';
                echo '<th>Title</th>';
                echo '<th>Price</th>';
                echo '<th>Video</th>';
                echo '</tr>';
        
                while($row = $result->fetch_assoc( )){
                    echo '<tr>';
                    echo '<td><strong>' . $row['songTitle'] . '</strong></td>';
                    echo '<td>' . $row['price'] . '</td>';
                    $link = $row['url'];
                    echo '<td><a href="' . $link . '" target="_blank">'
                        . $link . '</a></td>';
                    echo '</tr>';
                }
                echo '</table>';
                break;
            }
        
         
            case BAND:
                {
                    echo '<h2>List of Bands</h2>';
                    echo '<table>';
                    echo '<tr>';
                    echo '<th>Band</th>';
                    echo '</tr>';
                
                    while($row = $result->fetch_assoc( )){
                        echo '<tr>';
                        echo '<td>' . $row['name'] . '</td>';
                        echo '</tr>';
                }
                echo '</table>';
                break;
            }
        
            case SONG_ALBUM:
                echo '<h2>Songs on Albums</h2>';
                echo '<table>';
                echo '<tr>';
                echo '<th>Album</th>';
                echo '<th>Song</th>';
                echo '<th>Album Price</th>';
                echo '<th>Video</th>';
                echo '</tr>';
            
                while($row = $result->fetch_assoc( )){
                    echo '<tr>';
                    echo '<td><strong>' . $row['albumTitle'] . '</strong></td>';
                    echo '<td>' . $row['songTitle'] . '</td>';
                    echo '<td>' . $row['price'] . '</td>';
                    $link = $row['url'];
                    echo '<td><a href="' . $link . '" target="_blank">'
                        . $link . '</a></td>';
                    echo '</tr>';
                }
                echo '</table>';
                break;
        
            case ARTIST_BAND:
            {
                echo '<h2>Artists in Bands</h2>';
                echo '<table>';
                echo '<tr>';
                echo '<th>Artist</th>';
                echo '<th>Band</th>';
                echo '</tr>';

                while($row = $result->fetch_assoc( )){
                    echo '<tr>';
                    echo '<td>' . $row['fName'] . ' ' . $row['lName'] . '</td>';
                    echo '<td>' . $row['name'] . '</td>';
                    echo '</tr>';
                }
                echo '</table>';
                break;
            }
        
            default:
            echo $tableFormat . ' is not a valid table format.<br />';
        } // end of switch( )

		// Close the database object
		$db->close();
	} // end of displayData( )
?>
</head>
<body>
<div id="frame">
   <h1>Classic Vinyl</h1>
   <form name="frmDBF"
        action='<?php echo htmlentities($_SERVER['PHP_SELF']); ?>'
		method="POST">
        <strong>What information would you like to view?</strong>
        <!-- Use JavaScript to automatically submit the selection -->
        <select name="lstDisplay" onchange="this.form.submit()">
            <option value="null">Select an item</option>
            <option value="song">Song</option>
            <option value="band">Band</option>
            <option value="songAlbum">Songs on an Album</option>
            <option value="artistBand">Artist in Band</option>
        </select>

        <!-- set up alternative button in case JavaScript is not active -->
        <noscript>
            &nbsp; &nbsp; &nbsp;
            <input type="submit" name="btnSubmit" value="View the list" />
            <br /><br />
        </noscript>

        <!-- Use a hidden field to tell server if return visitor -->
        <input type="hidden" name="hidIsReturning" value="true" />
    </form>
    <?php
        displayData( );
    ?>
</div>
</body>
</html>
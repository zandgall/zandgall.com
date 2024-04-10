<!-- 
    Zander Gall - galla@csp.edu
    CSC235 - Prof. Furtney

    11/16/23 - Using attemptQuery, createDatabase, and populateTable functions from prjCRUD (with modified content)
    11/17/23 - Added "Go Back" link
    11/19/23 - Cleaning up and refactoring comments. Switched from manual date for Users table, to mySQL's NOW() function
 -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Database</title>
</head>
<body>
    <?php 
    
    // Created new mysql user for this class
    $database = new mysqli('localhost', 'remote', 'mysqlCSC235');

    if($database->connect_error > 0) {
        die("Could not connect to the server database: ".$database->connect_error);
    }

    function attemptQuery($query) {
        global $database;
        if(!$result = $database->query($query))
            die("Error on '".$query."': ".$database->error);
        return $result;
    }

    function createDatabase() {
        // We will NOT be dropping the actual database, but a new one specific to this week's project portion
        // (I have already begun putting content in the dbdungeon database, wouldn't want it deleted as I prep for future development)
        attemptQuery("drop database if exists dbdungeonWeek3");
        attemptQuery("create database dbdungeonWeek3");
        attemptQuery("use dbdungeonWeek3");
       
        attemptQuery("CREATE TABLE Elements (
                        id int NOT NULL AUTO_INCREMENT,
                        slot tinyint NOT NULL,
                        element varchar(1024) NOT NULL,
                        primary key (id)
                    )");
        attemptQuery("CREATE TABLE DefaultData (
                        id int NOT NULL AUTO_INCREMENT,
                        `1` int, `2` int, `3` int, `4` int, `5` int, `6` int, `7` int, `8` int,
                        primary key (id),
                        foreign key (`1`) REFERENCES Elements (id),
                        foreign key (`2`) REFERENCES Elements (id),
                        foreign key (`3`) REFERENCES Elements (id),
                        foreign key (`4`) REFERENCES Elements (id),
                        foreign key (`5`) REFERENCES Elements (id),
                        foreign key (`6`) REFERENCES Elements (id),
                        foreign key (`7`) REFERENCES Elements (id),
                        foreign key (`8`) REFERENCES Elements (id)
                    )");
        attemptQuery("CREATE TABLE SortedData (
                        id int NOT NULL AUTO_INCREMENT,
                        `1` int, `2` int, `3` int, `4` int, `5` int, `6` int, `7` int, `8` int,
                        primary key (id),
                        foreign key (`1`) REFERENCES Elements (id),
                        foreign key (`2`) REFERENCES Elements (id),
                        foreign key (`3`) REFERENCES Elements (id),
                        foreign key (`4`) REFERENCES Elements (id),
                        foreign key (`5`) REFERENCES Elements (id),
                        foreign key (`6`) REFERENCES Elements (id),
                        foreign key (`7`) REFERENCES Elements (id),
                        foreign key (`8`) REFERENCES Elements (id)
                    )");

        // No use for backpack at the moment, leaving out of this assignment
        // attemptQuery("CREATE TABLE Backpack (
        //                 uuid char(36) NOT NULL,
        //                 1 int, 2 int, 3 int, 4 int, 5 int, 6 int, 7 int, 8 int,
        //                 primary key (uuid)
        //             )");
            
        attemptQuery("CREATE TABLE Home (
                        uuid char(36) NOT NULL,
                        `1` int, `2` int, `3` int, `4` int, `5` int, `6` int, `7` int, `8` int,
                        primary key (uuid),
                        foreign key (`1`) REFERENCES Elements (id),
                        foreign key (`2`) REFERENCES Elements (id),
                        foreign key (`3`) REFERENCES Elements (id),
                        foreign key (`4`) REFERENCES Elements (id),
                        foreign key (`5`) REFERENCES Elements (id),
                        foreign key (`6`) REFERENCES Elements (id),
                        foreign key (`7`) REFERENCES Elements (id),
                        foreign key (`8`) REFERENCES Elements (id)
                    )");
        attemptQuery("CREATE TABLE MoreWorms (
                        uuid char(36) NOT NULL,
                        `1` int, `2` int, `3` int, `4` int, `5` int, `6` int, `7` int, `8` int,
                        primary key (uuid),
                        foreign key (`1`) REFERENCES Elements (id),
                        foreign key (`2`) REFERENCES Elements (id),
                        foreign key (`3`) REFERENCES Elements (id),
                        foreign key (`4`) REFERENCES Elements (id),
                        foreign key (`5`) REFERENCES Elements (id),
                        foreign key (`6`) REFERENCES Elements (id),
                        foreign key (`7`) REFERENCES Elements (id),
                        foreign key (`8`) REFERENCES Elements (id)
                    )");
        attemptQuery("CREATE TABLE Users (
                        uuid char(36) NOT NULL,
                        updated timestamp NOT NULL,
                        immutable boolean NOT NULL,
                        primary key (uuid)
                    )");

    }

    function populateTable() {
        // Populate our elements table. All of this is HTML code, and can be better read by viewing the source code of the example pages for this week of the project
        // This particular block of mySQL code was generated using phpmyadmin and modified by me. But I hope you trust that I know how this code works.
        attemptQuery("INSERT INTO `Elements` (`slot`, `element`) VALUES
                        (1, '<h1>Worm fan page</h1>'),
                        (2, '<h2>Welcom to my worm fan website</h2>'),
                        (3, '<p>this site is all about, worms. i will tell u everything i kno about worms. first are earthworms and ragworms!!</p>'),
                        (4, '<h3>Earthworms</h3>'),
                        (5, '<p>earthworms are a very common kind of, worm. They have 5 hearts and a small brain and a big nervous system. its body is cut up into segments, which allow it to move by squeezing or stretching any segmen. this kind of worm does NOT have eyes BUt they can actually detect light towards the front of the worm.</p>'),
                        (6, '<h3>ragworms</h3>'),
                        (7, '<p>Ragworms live in water an have much bigger parapodia than the earthworm when in water, so they can swim better. these kinds of worms have pincer-like teeth, and a jaw of smaller conical teeth leading inside their mouths. </p>'),
                        (8, '<a href=\"moreworms\">click for more worms!!</a>'),
                        (1, '<h1>More worms!!</h1>'),
                        (2, '<h2>im happy u wanna learn so much about worms!!</h2>'),
                        (3, '<p>here u can learn abt moreworms like leeches and </p>'),
                        (4, '<h3>Leeches</h3>'),
                        (5, '<p>this family of worms are one of the most notorious parasites. they r usually marine dwelling, often in freshwater. they hook onto hosts and feed on their blood. the smallest species is only about a centimeter long, and the biggest is in the amazon</p>'),
                        (6, '<h3>Sipuncula</h3>'),
                        (7, '<p>this is another class of worxms that usually live in water. they typically live in shallows of oceans, but can burrow or live in muddy or sandy areas and under stones similar to earthworms. these worms usually eat by extending the narrower portion of their body towards food and pulling it into their mouth.</p>'),
                        (8, '<a href=\"home\">back home</a>')");
        
        // Populate the shuffled and sorted data keys. What the website 'is', and what it 'should be'
        attemptQuery("INSERT INTO `DefaultData` (`1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`) VALUES
                        (1, 10, 11, 4, 13, 14, 15, 8),
                        (9, 2, 3, 12, 5, 6, 7, 16)
                    ");
        attemptQuery("INSERT INTO `SortedData` (`1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`) VALUES
                        (1, 2, 3, 4, 5, 6, 7, 8),
                        (9, 10, 11, 12, 13, 14, 15, 16)
                    ");
        
        // Lets create some test users. One will have just started, and one will be at the end, so their data will replicate DefaultData and SortedData
        // The last will be invalid, but will be used to illustrate a possible puzzle mechanic/scenario.
        attemptQuery("INSERT INTO `Users` (`uuid`, `updated`, `immutable`) VALUES
                        ('00000000-0000-0000-0000-000000000000', NOW(), FALSE),
                        ('ffffffff-ffff-ffff-ffff-ffffffffffff', NOW(), TRUE),
                        ('invalid!-0000-0000-0000-000000000000', '2000-01-01 01:00:00', TRUE)
                    ");
        attemptQuery("INSERT INTO `Home` (`uuid`, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`) VALUES
                        ('00000000-0000-0000-0000-000000000000', 1, 10, 11, 4, 13, 14, 15, 8),
                        ('ffffffff-ffff-ffff-ffff-ffffffffffff', 1, 2, 3, 4, 5, 6, 7, 8),
                        ('invalid!-0000-0000-0000-000000000000', 1, 10, 11, 4, 13, 14, 16, 8)
                    ");
        attemptQuery("INSERT INTO `MoreWorms` (`uuid`, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8`) VALUES
                        ('00000000-0000-0000-0000-000000000000', 9, 2, 3, 12, 5, 6, 7, 16),
                        ('ffffffff-ffff-ffff-ffff-ffffffffffff', 9, 10, 11, 12, 13, 14, 15, 16),
                        ('invalid!-0000-0000-0000-000000000000', 9, 2, 3, 12, 5, 6, 7, 15)
                    ");
    }

    createDatabase();
    populateTable();
    
    ?>

    <a href="./" style="width:5cm; padding:5mm;">Go Back</a>

</body>
</html>
<!-- 
    Zander Gall - galla@csp.edu
    11/8-10/2023 - Created required design images.
    11/11/2023 - HTML Written to completion.
    11/12/2023 - Made images thumbnails, and wrote CSS

    CSC235 - Prof. Furtney
    Term Project - Week 2 - README

    12/2/23 Copied over
    12/3/23 Added notes for stored procedure
 -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>README</title>
    
    <!-- Load 'lato' from Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@300..900&display=swap" rel="stylesheet">
</head>
<body>
    <main>
        <h1>DBDungeon</h1>
        <h3>Zander Gall</h3>
        <a href="https://www.zandgall.com/dbdungeon" target="_blank" rel="noopener noreferrer">www.zandgall.com/dbdungeon</a>
        <hr>
        <p> For the term project, I will be creating an interactive puzzle 'game' that uses Databases and quirks of URLs and PHP in order to create puzzles. </p>
        <p> This site is for a general, albeit nerdy, audience. I wanted to create something on the entertaining and artistic side of things for this term project, and this is what came to mind. It will be hosted on my main website, as one of the many different gamelets you can play. I'm confused by the question 'when', as the answer is 'at the end of week 7.' Though I may, if motivated enough, extend development or add more features in my own time for my, and my friends' entertainment. </p>
        <section id="function">
            <h2>Function of the game</h2>
            <hr>
            <p> The player enters the website, and finds that it has been scrambled. Text that belongs on one page is on a different one entirely, links may be in the wrong place to use them, and information is spread across the jumbled website. The player has to follow any valid links they find in order to traverse the website. </p>
            <p> The player is given a 'backpack' that allows them to store page elements. This backpack retains its content across pages, and so the player can grab an element from one page, and place it on another page, in an effort to fix the website, and to discover new pages. </p>
            <p> Every page will have 8 element slots, facilitated by the database. Every element has an ID. Since there are only 8 elements per page, a page can only have elements with IDs 1 through 8, and each ID has to be unique within a page and database.</p>
            <p> A player will be assigned a UUID by the server. This UUID will be stored in the PHP 'session' variable. This UUID will be used to keep track of the state of the game for any given player. </p>
        </section>
        <section id="procedures">
            <h2>Stored Procedures</h2>
            <hr>
            <p> newUser(in uuid) - Takes the input UUID and adds rows to backpack, user, and page tables with default data. Nulls for Backpack, current timestamp for User, and copied from DefaultData for pages.</p>
            <p> There will likely be more procedures in the final version, but this is it for now.</p>
        </section>
        <div>
            <section id="database">
                <a href="graphic/database.png" target="_blank" rel="noopener noreferrer"><img src="graphic/database_thumb.png" alt="Design of the Database"></a>
                <h2>The Database Design</h2>
                <hr>
                <p>This is the database design. There will be an Elements table, which stores a list of all elements present within the entire game. Each row is an element, with it's HTML data, and the ID that it holds.</p>
                <p>In the DefaulData table, each row is a page, and columns "1"-"8" hold the 8 elements present on each respective page. Each entry is a row number from the "Elements" table. Any attempt to transfer an item to the page will check if an element already exists in the table with the same ID, ensuring that only one of each ID is present.</p>
                <p>The backpack can hold 8 items just like a page. The table for the backpack will have 8 columns for the items it can hold. Each row of the backpack is identified by a player UUID, meaning each row contains a player's backpack contents. The '1' column can only hold elements with id=1, '2' only id=2, and so on. Similar to the previous table, only one of each as well. Meaning the player will have to be clever to try and swap two page elements that have the same ID.</p>
                <p>The remaining (currently undecided) number of tables represent each page in the website, and are identical to the backpack in design and functionality. When player starts playing, a new row is created with their new UUID, and the contents of each page is set to the respective row on the 'DefaultData' table. The home/starting page would start with DefaulData's first row for example.</p>
                <p>For the backpack and page tables, an entry of '0' means that there is no element with the given ID.</p>
            </section>
            <section id="layout">
                <a href="graphic/layout.png" target="_blank" rel="noopener noreferrer"><img src="graphic/layout_thumb.png" alt="Layout of the Website"></a>
                <h2>Layout of the basic page</h2>
                <hr>
                <p>This is the default/UI page. This will be included on every webpage present in the game, (via PHP's include,) and it contains features that help the player navigate and use the main features of the game.</p>
                <p>At the bottom is the backpack. A little red bookmark will let the player hide or tuck away the backpack off the page to prevent obscuring the current page's content. It has 8 slots, showing what's present in each slot. Using JavaScript (or some other undecided method), the player can drag/select an element from the page and place it in the backpack, if it's valid.</p>
                <p>At the top-left of the screen is a page indicator. It will show what elements are on the page, and which elements actually belong on the page. </p>
                <p>At the top-right of the screen is a site map. This will display known links/paths to other pages relative to where you are on the website. It will also highlight different subdirectories, so that the player can better see that a link needs to be in the correct directory in order to work. Links can be highlighted as broken (404), correct, or working but belongs on a different page.</p>
                <p>Whenever the user hovers over an element, a box will unhide showing details about the element. It'll show its ID, and possibly hints to where it belongs, or how to get it where it needs to be.</p>
            </section>
        </div>
    </main>
</body>
</html>
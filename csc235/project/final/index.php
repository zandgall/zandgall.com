<!-- 
    Zander Gall - galla@csp.edu
    CSC235 - Prof. Furtney

    Overview of the project
 -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DBDungeon Final Submission</title>
    <link rel="stylesheet" href="indexStyles.css">
</head>
<body>
    <h1>DBDungeon</h1>
    <h2>A Server-side only web puzzle</h2>
    <p>I intended to create a puzzle game for my project this term. It uses SQL and databases in order to store each individual player's progress. Each user is given a UUID that is referenced to store or read their respective data.</p>
    <h2>Features</h2>
    <p>The user is intended to use the following features in order to transfer elements from one page to another.</p>
    <ul>
        <li>Page - A page that displays server-side data pertaining the the user.</li>
        <li>Backpack - A place to put elements that stays the same for a user across any page.</li>
        <li>Interface - A form that allows you to tell the server to swap an item from the backpack and the page.</li>
        <li>Dragging - Alternative to interface, the user can 'grab' an element with the mouse, and move it either to the page or to the backpack.</li>
        <li>Progress Indicator - Displays whether the elements currently on the page are correct (green), incorrect (red), missing (gray), or empty and supposed to be (grey with green outline).</li>
    </ul>
    <h2>Missing features</h2>
    <p>I want to take a moment to acknowlege that the intended site map feature is not present in this submitted final version. While I believe that this feature would significantly improve the experience (being able to navigate several pages over quickly, seeing if there's a page with an open slot that you need, etc.), I did not have enough time to produce this feature. This may come if I feel interested enough to develop this in my free time.</p>
    <p>Also intended, were abilities to apply specific styles and CSS to different pages as if they were rooms you could decorate to your personal preference. Similarly, adding 'stickers' for a similar reason. There would in relation be a 'sharing' feature, where someone could view your version of the website, seeing all your decoration and your progress.</p>
    <p>I also meant to create a short tutorial that would </p>
    <h2>Links</h2>
    <a href="./home">Play</a>
    <a href="reflection">Reflection</a>
    <a href="outline.html">All website content</a>
    <h2>Gallery</h2>
    <p>Notes, designs, and maps, showing the work going into creating the content of the 'game'</p>

    <section id="gallery">
        <div>
            <img src="resources/database.png" alt="Database">
            <p>The intended design of the database.</p>
        </div>
        <div>
            <img src="resources/layout.png" alt="Layout">
            <p>The intended layout of the UI, without the interface, and with the map that is missing from the actual project.</p>
        </div>
        <div>
            <img src="resources/map.png" alt="Map">
            <p>A 'map' of the website. Included are 'bonus' pages that you can still see hints for in the actual project. These would have these stickers and CSS styles to unlock.</p>
        </div>
        <div>
            <img src="resources/shuffle.png" alt="Shuffle">
            <p>The drawing that I used to plan out the initial puzzle state.</p>
        </div>
    </section>
</body>
</html>
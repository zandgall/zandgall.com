<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width:device-width, initial-scale=1.0">
    <title>Time Budgeting</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Fira+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body frame="week">
    <main>
        <div id="markers">
            <hr id="sunday">
            <hr id="saturday">
            <hr id="friday">
            <hr id="thursday">
            <hr id="wednesday">
            <hr id="tuesday">
            <hr id="monday">
        </div>
        <div id="budget" class="frame">
            <div class='header'>
                <h1>Budget</h1>
            </div>
        </div>
        <div class="weeksplit">
        </div>
        <div id="running" class="frame">
            <div class='header'>
                <h1>Current Week</h1>
            </div>
        </div>
        <div class="weeksplit">
            <h1>previous weeks</h1>
        </div>
    </main>

    <script src="source.js" type="application/javascript"></script>
    <style id="budget-style"></style>
</body>

</html>

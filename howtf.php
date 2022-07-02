<html>
    <head>
        <style>
            * {
            margin: 0;
            }

            html, body {
            height: 100%
            }

            main {
                position: relative;
                width: 100%;
                
                overflow-y: auto;
                overflow-x: hidden;
                height: 100vh;
                
                background-color: blue;
            }

            .static {
                min-height: 800px; 
            }

            .parallax-container {
                border: solid black 3px;
                height: 600px;
                width: 100%;
                position: relative;
            }

            .parallax-child {
                position: relative;
                width: 100%;
                height: 100%;
                z-index: -1;
            }

            #img-or-whatever {
                height: 900px;
                width: 100%;
                background-color: red;
                position: relative;
                z-index: -1;
            }
        </style>
    </head>
    <body>
        <main>
            <div class="static"></div>
                
            <div class="parallax-container">
                <div class="parallax-child">
                <div id="img-or-whatever"></div>
                </div>
            </div>

            <div class="static"></div>
        </main>
    </body>

</html>
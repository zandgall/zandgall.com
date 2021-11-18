<html lang="en">
    <style>
        hr{
            border:none; border-top: 2px dashed rgba(255, 255, 255, 0.5); position: absolute;
        }
        .round {
            width:6px; height:6px; border: 2px solid rgba(255, 255, 255, 0.5); border-radius:6px; background-color:rgba(100, 200, 255, 0.2); position: absolute;
        }
        .highlight {
            border: 1px solid rgba(100, 200, 255, 0.5); border-radius: 5px
        }

    </style>
<script src="https://polyfill.io/v3/polyfill.min.js?features=es6"></script>
<script type="text/javascript" id="MathJax-script" async
  src="https://cdn.jsdelivr.net/npm/mathjax@3/es5/tex-chtml.js">
</script>
<?php 
$pagetitle = "Zandgall - QB64 3D Rasterizer";
$pagedesc = "Overview of a program that can rasterize 3d graphics, written in QB64, a close recreation of BASIC";
include "global/head_.php";
function pointer($fromtop, $length, $isfromleft) {
    if($isfromleft) {
        echo "<hr style=\"left:255px; width:",$length,"px; top:",$fromtop,"\"/>";
        echo "<div class=\"round\" style=\"left:",(255 + $length),"px; top:",$fromtop+4,";\"></div>";
    } else {
        echo "<hr style=\"left:-",$length,"px; width:",($length-5),"px; top:",$fromtop,"\"/>";
        echo "<div class=\"round\" style=\"left:-",($length+10),"; top:",$fromtop+4,";\"></div>";
    }
}

?>

<body>
    <?php 
    $title = "Welcome to the site!";
    $subtitle = "A resource for Arvopia and other projects";
    include "global/head.php"?>

    <h1 class="basictext outlinetext" style="margin: 100px auto 50px auto; font-size: 48">3D Rasterizing in QB64</h1>
    <img src="assets/qb64 3d/thumb.png" style="width: 800px; height: auto; display: block; margin: 0px auto 150px auto; float: center; image-rendering: pixelated">
    <h3 class="basictext outline"></h3>

    <h3 class="basictext outlinetext" style="font-size: 24px; margin: auto auto 100px auto">
        <span style="text-decoration:underline; font-size:32">Contents</span><br>
        <a class="link basictext" href="#qb64">What is QB64?<a><br>
        <a class="link basictext" href="#raster">What is 3D Rasterizing?</a><br>
        <a class="link basictext" href="#triangles">Triangles 101</a><br>
        <a class="link basictext" href="#barycentric">Barycentric Coordinates</a><br>
        <a class="link basictext" href="#linear">Linear Algebra for the Faint of Heart</a><br>
        <a class="link basictext" href="#depth">Depth is Easier than it Seems</a><br>
        <a class="link basictext" href="#correctionbarycentric">Correcting Barycentric Coordinates with Depth</a><br>
        <a class="link basictext" href="#extra">Extra Little Detail</a><br>
        <a class="link basictext" href="#gallery">Gallery</a><br>
        <a class="link basictext" href="#resources">Further Resources</a><br>
    </h3>

    <h1 class="basictext outlinetext" style="margin: 100px auto 50px auto" id="qb64">What is QB64?</h1>
    <div class="" style="position: relative; margin: 0 auto auto auto; width: 800;">
        <h2 class="basictext outlinetext">In order to understand QB64, you must first know what BASIC is</h2>

        <h3 class="basictext outlinetext" style="text-align:left">&emsp;BASIC is a programming language developed in the late 60s and early 70s, becoming a mainstay as one of, if not the most influential programming languages of all time during the 80s. It was created to be a simple programming language that could be extremely easy to learn, but still really powerful as we'll soon see. During it's reign, an IDE called "Quick BASIC", or QBasic for short was created for DOS, accelerating BASIC's popularity and accessibility. Decades later, QBasic became the influence for QB64, a BASIC IDE for the 2000s. This became my IDE of choice, due to the modern OS compiling it brings, and it's simple project setup.</h3>
        <h3 class="basictext outlinetext" style="text-align:left">&emsp;Although being built for 64 bit systems, QB64 gives you similar capabilities that BASIC would have given you back in the day, another reason why I chose it. But one problem it does bring to the project, is that one of it's benefits lies in the realm of graphics. However, the extent at which it was used was very minimal, and did not harm the project or my learning experience in this field.</h3>
        <h3 class="basictext outlinetext" style="text-align:left">&emsp;More information about QB64 and it's capabilities can be found at the <a href="https://www.qb64.org" style="text-decoration: none">QB64 homepage</a></h3>
        <img src="assets/qb64 3d/uiexample.png" style="display: block; width: 800; height: auto; margin: auto">
    </div>
    <h1 class="basictext outlinetext" style="margin: 100px auto 50px auto" id="raster">What is 3D Rasterizating?</h1>
    <div class="" style="position: relative; margin: 0 auto auto auto; width: 800;">
        <h2 class="basictext outlinetext">3D Rasterization is a technique for drawing 3D scenes to a raster</h2>
        <h3 class="basictext outlinetext" style="text-align:left">&emsp;Rasterization in general is the practice of mapping vector graphics to a raster. A raster, like a screen, tends to be a list of colors, or 'pixels'. In 3D rasterization, these vector graphics are 3D objects projected onto a 2D plane, usually triangles onto a cross section of a virtual camera's viewport.</h3>
        <h3 class="basictext outlinetext" style="text-align:left">&emsp;But let's slow down here. Projecting and Rasterizing 3D objects is complicated to learn, but becomes simple to execute when understood. From here on, I shall describe only the processes I used, but there are numberous paths to achieve this same end point, many of which I do not understand at this given time.</h3>
        <h3 class="basictext outlinetext" style="text-align:left">&emsp;I chose to use triangles like many others for their efficiency in rasterization, helpfullness in transforming vertex attributes, and ability to form any other flat-faces 3d shape with them. They have a great deal of research and mathematical use behind them that makes them an extremely powerful and versitile shape, yet very efficient as well.</h3>
        <h3 class="basictext outlinetext" style="text-align:left">&emsp;Before we can work with triangles, we need to know how to project individual 3d points. Projecting onto the screen of a "Virtual Camera" sounds more complicated than is ever necessary. But it all comes down to some tricky calculations that are entirely handled by the computer. We will simplify our process a bit though by cutting out any movement or rotation of the camera, making the scene less interactive but simplifying and speeding things up a bit in comparison.</h3>
        <h3 class="basictext outlinetext" style="text-align:left">&emsp;Beyond transforming and projecting triangles, we need to make sure that we aren't drawing any objects or triangles on top of something that's supposed to be closer to the camera. Fortunately, if we store an array of the current depth at each pixel, we can check that array during rasterization to see if there is already a pixel there closer to the camera, or 'origin' in our case.</h3>
        <div class="section" style="position: absolute; left:-300; top:0; width:250">
            <h3 class="basictext outlinetext">Vector graphics consist of shapes and perfect lines, they are infinitely scalable and don't conform to a resolution, unlike images</h3>
            <?php pointer(48, 50, true)?>
        </div>
        <div class="section" style="position: absolute; left:850; top:250; width:250">
            <h3 class="basictext outlinetext"><a href="#triangles">Triangles 101</a></h3>
            <?php pointer(12, 140, false)?>
        </div>
        <div class="section" style="position: absolute; left:-300; top:340; width:250">
            <h3 class="basictext outlinetext"><a href="#linear">Linear Algebra for the Faint of Heart</a></h3>
            <?php pointer(28, 50, true)?>
        </div>
        <div class="section" style="position: absolute; left:850; top:540; width:250">
            <h3 class="basictext outlinetext"><a href="#depth">Depth is Easier than it Seems</a></h3>
            <?php pointer(25, 50, false)?>
        </div>
    </div>
    <h1 class="basictext outlinetext" style="margin: 100px auto 50px auto" id="triangles">Triangles 101</h1>
    <div class="" style="position: relative; margin: 0 auto auto auto; width: 800">
        <h2 class="basictext outlinetext">Before trying to understand the exact math and programming behind rasterizing a triangle, it's important to start thinking about triangles in these three ways.</h2>
        <h3 class="basictext outlinetext" style="text-align:left">&emsp;1: A set of 3 points, with lines connecting points 1 - 2, 2 - 3, and 3 - 1.<br>&emsp;2: A single point with two lines jetting out from it, being filled until a terminating line.<br>&emsp;3: A set of two triangles. With each of their terminating lines being horizontally flat.</h3>
        <img src="assets/qb64 3d/aspointswithlines.png" style="display:block; width: 300px;height:auto; margin-left:-50px; float:left">
        <img src="assets/qb64 3d/asoriginterminator.png" style="display:block; width: 300px;height:auto; float:left; position:relative; z-index:14">
        <img src="assets/qb64 3d/as2terminatingtriangles.png" style="display:block; width: 300px;height:auto;margin-right:-50px; float:left">
        <h3 class="basictext outlinetext" style="text-align:left; margin-top:350;">
        &emsp;With these three manners, we can split up the process of drawing the pixels of a triangle in simple steps.
        Firstly, drawing a triangle with a flat terminating line is much easier than one with a slanted terminating line.
        As with a triangle of this manner, we can loop from y positions from the terminating line to the source,
        and find the range of x values for every y position in said triangle.
        Knowing this, and assuming #3 is true, we can write the processes for a flat-terminating triangle, and be able to draw any triangle
        after figuring out how to split it up.<br><br>
        &emsp;As mentioned, the rasterization process of a flat-terminating triangle is as easy and as complicated as it sounds. 
        Knowing the highest y point, and lowest y point, (those being the y-point of the origin, and the y point of the terminator),
        we can loop through each y level that the triangle envelopes.</h3>
        <img src="assets/qb64 3d/yrangeoftri.png" style="display:block; width:800px; height:auto">
        <h3 class="basictext outlinetext" style="text-align:left;">
        &emsp;To know each x value, we can consider the two lines that run through the origin.
        Note that a line is given by the equation: "y = mx + b", and rewritten, we can find x when given y, using "x = (y - b)/m". 
        With this in mind, we can solve for the x-values of either side-line given the y position.
        Which can come straigh from our loop between the two y-limits of our triangles.</h3>
        <canvas class="section" id="lineExample_canvas" width=800 height=400 style="width:800; height:400;" onmousemove="lineExample_mouseMove(event);">Canvas Unsupported</canvas>
        <script type="application/javascript">
        {
        let can = $("#lineExample_canvas")[0];
        let ctx = can.getContext("2d");
        function lineExample_mouseMove(evt) {
            let rect = can.getBoundingClientRect();
            ctx = can.getContext("2d");
            let mouse = {
                x: evt.clientX - rect.left,
                y: evt.clientY - rect.top
            };
            let lineX = 500 + mouse.y/2; // Physical y is (mouse.y - 400)/-1, but considering that positive-y is towards the bottom, simplifying will do
            console.log("Drawing...", mouse, lineX, ctx, can);
            ctx.clearRect(0, 0, 800, 400);
            ctx.fillStyle = "blue";
            ctx.strokeStyle ="blue";
            ctx.lineWidth = 5;

            ctx.beginPath();
            ctx.moveTo(500, 0);
            ctx.lineTo(700,400);
            ctx.stroke();

            ctx.beginPath();
            ctx.ellipse(lineX, mouse.y, 10, 10, 0, 0, 2*Math.PI);
            ctx.fill();

            ctx.font = "bold 1.17em sans-serif";
            ctx.lineWidth = 4;
            ctx.fillStyle="white";
            ctx.strokeStyle="black";
            ctx.strokeText("y = mouseY", 10, 40);
            ctx.fillText("y = mouseY", 10, 40);
            ctx.strokeText("x = (mouseY - b)/m", 10, 70);
            ctx.fillText("x = (mouseY - b)/m", 10, 70);
        }
        }
        </script>
        <h3 class="basictext outlinetext" style="text-align:left;">&emsp;Before we drop in our loop and edge finders, let's simplify this "x = (y - b)/m".
        For our case, we do not need "b" in there at all, when we know what our original x value is, we can reason that for every change in y,
        x changes by the change in y times the inverse-slope. "Δy * 1/m". Secondly, we are able to find what "m" equals before we start any loop,
        and thus, can find 1/m to save calculations during our loop.</h3>
        <canvas class="section" id="lineWalkExample_canvas" width=800 height=400 style="width:800; height:400;">Canvas Unsupported</canvas>
        <script type="application/javascript">
        {
        let can = $("#lineWalkExample_canvas")[0];
        let ctx = can.getContext("2d");
        ctx.font = "bold 1.17em sans-serif";
        let lineWalk_step = -2;
        let lineWalk_y = 0;
        let lineWalk_x = 0;

        function canvas_arrow(context, fromx, fromy, tox, toy, r){
            var x_center = tox;
            var y_center = toy;

            var angle;
            var x;
            var y;

            context.beginPath();
            context.moveTo(fromx, fromy);
            context.lineTo(tox, toy);
            context.stroke();

            context.beginPath();

            angle = Math.atan2(toy-fromy,tox-fromx)
            x = r*Math.cos(angle) + x_center;
            y = r*Math.sin(angle) + y_center;

            context.moveTo(x, y);

            angle += (1/3)*(2*Math.PI)
            x = r*Math.cos(angle) + x_center;
            y = r*Math.sin(angle) + y_center;

            context.lineTo(x, y);

            angle += (1/3)*(2*Math.PI)
            x = r*Math.cos(angle) + x_center;
            y = r*Math.sin(angle) + y_center;

            context.lineTo(x, y);

            context.closePath();

            context.fill();
        } // Thanks stackoverflow! https://stackoverflow.com/questions/808826/draw-arrow-on-canvas-tag
        function lineWalk_update() {
            ctx.clearRect(0, 0, 800, 400);
            ctx.fillStyle="blue";
            ctx.strokeStyle="blue";
            ctx.beginPath();
            ctx.moveTo(500, 0);
            ctx.lineTo(700, 400);
            ctx.lineWidth = 5;
            ctx.stroke();
            ctx.beginPath();
            ctx.ellipse(lineWalk_x*50 + 500,  lineWalk_y*50, 10, 10, 0, 0, 2*Math.PI);
            ctx.fillStyle="blue";
            ctx.fill();
            switch(lineWalk_step) {
            case 0:
                ctx.beginPath();
                ctx.fillStyle="white";
                ctx.strokeStyle="white";
                canvas_arrow(ctx, lineWalk_x*50 + 500, lineWalk_y*50 + 10, lineWalk_x*50 + 500, lineWalk_y*50 + 50, 5);
                ctx.fillStyle= "white";
                ctx.strokeStyle="black";
                ctx.lineWidth = 4;
                ctx.strokeText("y+1", lineWalk_x*50 + 487, lineWalk_y*50 + 70);
                ctx.fillText("y+1", lineWalk_x*50 + 487, lineWalk_y*50 + 70);

                lineWalk_y++;
                break;
            case 2:
                ctx.beginPath();
                ctx.fillStyle="white";
                ctx.strokeStyle="white";
                canvas_arrow(ctx, lineWalk_x*50 + 510, lineWalk_y*50, lineWalk_x*50 + 525, lineWalk_y*50, 5);
                ctx.fillStyle= "white";
                ctx.strokeStyle="black";
                ctx.lineWidth = 4;
                ctx.strokeText("x+1/m", lineWalk_x*50 + 500, lineWalk_y*50 + 20);
                ctx.fillText("x+1/m", lineWalk_x*50 + 500, lineWalk_y*50 + 20);
                lineWalk_x+=1/2;
                break;
            case 4:
                break;
            default:
                break;
            }

            ctx.lineWidth = 4;
            ctx.strokeStyle="black";
            ctx.fillStyle=(lineWalk_step < 0 ? "yellow" : "white");
            ctx.strokeText("START", 10, 40);
            ctx.fillText("START", 10, 40);
            ctx.fillStyle=(((lineWalk_step == 0 || lineWalk_step == 1) && lineWalk_y <= 8) ? "yellow" : "white");
            ctx.strokeText("y = y + 1", 10, 70);
            ctx.fillText("y = y + 1", 10, 70);
            ctx.fillStyle=((lineWalk_step == 2 || lineWalk_step == 3) ? "yellow" : "white");
            ctx.strokeText("x = x + 1/m", 10, 100);
            ctx.fillText("x = x + 1/m", 10, 100);
            ctx.fillStyle=(lineWalk_y > 8 ? "#20ff60" : (lineWalk_step == 4 || lineWalk_step == 5) ? "yellow" : "white");
            ctx.strokeText("STOP WHEN (y ≥ terminator)", 10, 130);
            ctx.fillText("STOP WHEN (y ≥ terminator)", 10, 130);
            if(lineWalk_step == 5)
                lineWalk_step = -1;
            lineWalk_step++;
            if(lineWalk_y > 8 && lineWalk_step == 2) {
                lineWalk_y = 0;
                lineWalk_x = 0;
                lineWalk_step = -2;
            }
        }
        window.setInterval(lineWalk_update, 500);
        }
        </script>
        <h3 class="basictext outlinetext" style="text-align:left;">
        &emsp;In summary, we will loop through the y values, as there is a definite top and bottom. And for each y value,
        we will find the boundaries of x by solving for the x values of the lines that surround the triangle. 
        We will call our two resulting values, "left x" and "right x".<br><br>
        &emsp;Noting that we can find the slope of a line going through two points by (y2-y1)/(x2-x1),
        we can calculate the slopes of the two sides of the triangle that we need to know, given the 3 points of our triangle.
        And better yet, we can calculate the inverse slope, by calculating (x2-x1)/(y2-y1) instead of the original reciprocal.<br><br>
        &emsp;Given all that, we can now fully loop through every pixel inside of a flat-terminating-triangle. Making sure that we are finding a
        floored or rounded x and y value, because we need integer values for settings pixels and further calculations.</h3>

        <canvas class="section" id="flatTriangle_canvas" width=800 height=400 style="width:800; height:400;">Canvas Unsupported</canvas>
        <script>
        {
        let can = $("#flatTriangle_canvas")[0];
        let ctx = can.getContext("2d");
        ctx.font = "bold 1.17em sans-serif";

        function sleep(ms) { // Simple sleep promise
           return new Promise(resolve => setTimeout(resolve, ms));
        }
        let step = 1, gridSize = 20;
        let a = {x: 410, y: 20};
        let b = {x: 200, y: 380}; // Terminator is at y=380
        let c = {x: 700, y: 380};

        let a_b = (b.x-a.x)/(b.y-a.y);
        let a_c = (c.x-a.x)/(c.y-a.y);

        let left = {x: a.x, y:a.y}, right = {x:a.x, y:a.y};

        let raster = [];

        async function update() {
            if(raster.length === 0) {
                for(let i = 0; i < (800/gridSize)*(400/gridSize); i++) {
                    raster[i] = false;
                }
            }

            switch (step) {
            case 0:
                right.y+=gridSize;
                left.y+=gridSize;
                right.x += a_c*gridSize;
                left.x += a_b*gridSize;
                if(left.y >= b.y) {
                    for(let i = 0;  i < raster.length; i++)
                        raster[i] = false;
                    left.y = a.y;
                    left.x = a.x;
                    right.y = a.y;
                    right.x = a.x;
                }
                break;
            case 1:
                ctx.fillStyle="white";
                let _curlen = Math.floor(right.x/gridSize)+1 - Math.floor(left.x/gridSize);
                for(let i = Math.floor(left.x/gridSize); i < Math.ceil(right.x/gridSize); i++) {
                    raster[i + (left.y/gridSize)*(800/gridSize)] = true;
                    ctx.fillRect(i*gridSize, left.y, gridSize, gridSize);
                    await sleep(500/_curlen);
                }
                step = -1;
                break;
            }

            ctx.clearRect(0, 0, 800, 400);
            ctx.strokeStyle = "rgba(150, 150, 150, 0.5)"
            ctx.fillStyle = "white";
            ctx.lineWidth = 1;
            for(let x = 0; x < 800; x+=gridSize) {
                for(let y = 0; y < 400; y+=gridSize) {
                    if(raster[y/gridSize * 800/gridSize +  x/gridSize]) {
                        ctx.fillRect(x, y, gridSize, gridSize);
                    }
                    ctx.strokeRect(x, y, gridSize, gridSize);
                }
            }
            ctx.strokeStyle= "black";
            ctx.setLineDash([10,10]);
            ctx.beginPath();
            ctx.moveTo(0, b.y);
            ctx.lineTo(800, b.y);
            ctx.stroke();
            ctx.strokeStyle = "white";
            ctx.beginPath();
            ctx.moveTo(0, left.y);
            ctx.lineTo(800, left.y);
            ctx.stroke();
            ctx.setLineDash([]);
            ctx.strokeStyle= "black";
            ctx.beginPath();
            ctx.moveTo(a.x - (b.x-a.x)*2, a.y - (b.y - a.y)*2);
            ctx.lineTo(a.x + (b.x-a.x)*2, a.y + (b.y - a.y)*2);
            ctx.stroke();
            ctx.beginPath();
            ctx.moveTo(a.x - (c.x-a.x)*2, a.y - (c.y - a.y)*2);
            ctx.lineTo(a.x + (c.x-a.x)*2, a.y + (c.y - a.y)*2);
            ctx.stroke();

            ctx.fillStyle="blue";
            ctx.beginPath();
            ctx.ellipse(a.x, a.y, 10, 10, 0, 0, Math.PI*2);
            ctx.fill();
            ctx.beginPath();
            ctx.ellipse(b.x, b.y, 10, 10, 0, 0, Math.PI*2);
            ctx.fill();
            ctx.beginPath();
            ctx.ellipse(c.x, c.y, 10, 10, 0, 0, Math.PI*2);
            ctx.fill();

            ctx.beginPath();
            ctx.ellipse(left.x, left.y, 10, 10, 0, 0, Math.PI*2);
            ctx.fill();
            ctx.beginPath();
            ctx.ellipse(right.x, right.y, 10, 10, 0, 0, Math.PI*2);
            ctx.fill();
            ctx.fillStyle="white";
            ctx.strokeStyle="black";
            ctx.lineWidth = 4;
            ctx.strokeText("Left", left.x - 60, left.y+7);
            ctx.fillText("Left", left.x - 60, left.y+7);

            ctx.strokeText("Right", right.x + 20, left.y+7);
            ctx.fillText("Right", right.x + 20, left.y+7);
            
            ctx.strokeText("y", 10, left.y-10);
            ctx.fillText("y", 10, left.y-10);

            step++;
        }
            
        window.setInterval(update, 800);
        update();
        }
        </script>

        <div style="width: 800; margin: 10px auto 10px auto; border: inset 2px #A3C3A3; background-color: #A3C3A3">
        <h3 class="basictext" style="text-align:left; margin: 5px">
            LEFT = ORIGIN_X, RIGHT = ORIGIN_X<br>
            LEFT_SLOPE = (TERMINATOR_LEFT - ORIGIN_X) / (TERMINATOR_Y - ORIGIN_Y)<br>
            RIGHT_SLOPE = (TERMINATOR_RIGHT - ORIGIN_X) / (TERMINATOR_Y - ORIGIN_Y)<br>
            For Y = ORIGIN_Y To TERMINATOR_Y<br>
            &emsp;LEFT += LEFT_INV_SLOPE<br>
            &emsp;RIGHT += RIGHT_INV_SLOPE<br>
            &emsp;For X = LEFT To RIGHT<br>
            &emsp;&emsp;Set Pixel (X, Y)<br>
            &emsp;NEXT<br>
            NEXT<br>
            </h3>
        </div>

        <h3 class="basictext outlinetext" style="text-align:left;">
        &emsp;Given that we can now draw a triangle with flat terminators as detailed above,
        we simply need to check if any given triangle has a horizontally-flat edge somewhere, and draw  it using that method if it does.
        If it doesn't, we can figure out which point of said triangle lies in between the other two in terms of y. In BASIC, there is no quick easy way
        to find this middle point, so we shall insert a series of checks.<br><br>
        &emsp;But in order to define two triangles, we need to find the x position of the line across from our middle point. And we have two things in order to do that,
        we have the line that the x position lies on, and the y position that the x is found at. Using our x = (y - b) / m, we can solve for x.
        Thinking of our slope in terms of changes in y related to changes in x, we can find our new x in a slightly different way.
        By taking one of the points in the line, (lets call it x1, y1) and adding the inverse slope time the change in y to it, we can find the new x.
        </h3>

        <canvas class="section" id="triangleMidpoint_canvas" width=800 height=400 style="width:800; height:400;" onmousemove="triangleMidpoint_mousemove(event)" onmousedown="triangleMidpoint_mousedown(event)" onmouseup="triangleMidpoint_mouseup(event)">Canvas Unsupported</canvas>
        <script type="application/javascript">
        {
        let can = $("#triangleMidpoint_canvas")[0];
        let ctx = can.getContext("2d");
        ctx.font = "bold 1.17em sans-serif";
        let a = {x: 400, y: 20, name:"a"};
        let b = {x: 200, y: 380, name: "b"};
        let c = {x: 700, y: 220, name: "c"};
        let mouseX = 0, mouseY = 0, pmouseX = 0, pmouseY = 0;
        let selected = a, middle = c, lineMidpoint = 0, bottom = b, top = a;
        let mouseDown = false;

        function findMiddle() {
            if(a.y < b.y && a.y > c.y || a.y > b.y && a.y < c.y) {
                middle = a;
                lineMidpoint = b.x + (a.y - b.y) * (c.x - b.x) / (c.y - b.y);
                if(c.y > a.y) {
                    bottom = c;
                    top = b;
                } else {
                    bottom = b;
                    top = c;
                }
            } else if(b.y < a.y && b.y > c.y || b.y > a.y && b.y < c.y) {
                middle = b;
                lineMidpoint = a.x + (b.y - a.y) * (c.x - a.x) / (c.y - a.y);

                if(c.y > b.y) {
                    bottom = c;
                    top = a;
                } else {
                    bottom = a;
                    top = c;
                }
            } else if(c.y < b.y && c.y > a.y || c.y > b.y && c.y < a.y) {
                middle = c;
                lineMidpoint = b.x + (c.y - b.y) * (a.x - b.x) / (a.y - b.y);

                if(b.y > c.y) {
                    bottom = b;
                    top = a;
                } else {
                    bottom = a;
                    top = b;
                }
            }
        }
        function triangleMidpoint_mousemove(evt) {
            ctx.lineWidth = 1;
            let rect = can.getBoundingClientRect();
            pmouseX = mouseX;
            pmouseY = mouseY;
            mouseX = evt.clientX - rect.left;
            mouseY = evt.clientY - rect.top;

            if(mouseDown && selected!=undefined) {
                selected.x += mouseX - pmouseX;
                selected.y += mouseY - pmouseY;
            }
            ctx.clearRect(0, 0, 800, 400);

            findMiddle();

            ctx.beginPath();
            ctx.moveTo(bottom.x, bottom.y);
            ctx.lineTo(middle.x, middle.y);
            ctx.lineTo(lineMidpoint, middle.y);
            ctx.closePath();
            ctx.fillStyle = "rgba(255, 0, 0, 0.5)";
            ctx.fill();

            ctx.beginPath();
            ctx.moveTo(top.x, top.y);
            ctx.lineTo(middle.x, middle.y);
            ctx.lineTo(lineMidpoint, middle.y);
            ctx.closePath();
            ctx.fillStyle = "rgba(0, 0, 255, 0.5)";
            ctx.fill();

            ctx.beginPath();
            ctx.setLineDash([]);
            ctx.moveTo(a.x, a.y);
            ctx.lineTo(b.x, b.y);
            ctx.lineTo(c.x, c.y);
            ctx.strokeStyle = "black";
            ctx.closePath();
            ctx.stroke(); 

            ctx.setLineDash([10,10]);
            ctx.strokeStyle = "#ffff00";
            ctx.beginPath();
            ctx.moveTo(0, middle.y);
            ctx.lineTo(800, middle.y);
            ctx.stroke();

            ctx.fillStyle = "#0000ff";
            ctx.beginPath();
            ctx.ellipse(a.x, a.y, 4, 4, 0, 0, 2*Math.PI);
            ctx.fill();
            ctx.fillText("a", a.x+10, a.y+10);

            ctx.beginPath();
            ctx.ellipse(b.x, b.y, 4, 4, 0, 0, 2*Math.PI);
            ctx.fill();
            ctx.fillText("b", b.x+10, b.y+10);

            ctx.beginPath();
            ctx.ellipse(c.x, c.y, 4, 4, 0, 0, 2*Math.PI);
            ctx.fill();
            ctx.fillText("c", c.x+10, c.y+10);

            ctx.fillStyle = "#ffff00";
            if(selected!=undefined) {
                ctx.beginPath();
                ctx.ellipse(selected.x, selected.y, 4, 4, 0, 0, 2*Math.PI);
                ctx.fill();
                ctx.fillText(selected.name, selected.x+10, selected.y+10);
            }
            ctx.beginPath();
            ctx.ellipse(lineMidpoint, middle.y, 4, 4, 0, 0, 2*Math.PI);
            ctx.fill();
            ctx.fillText("(x, y)", lineMidpoint + 10, middle.y + 10);

            ctx.fillStyle = "rgba(255, 255, 255, 0.6)";
            ctx.strokeStyle = "rgba(0,0,0,0.3)";
            ctx.lineWidth = 4;
            ctx.setLineDash([]);
            ctx.strokeText(`y = ${middle.name}.y`, 10, 370);
            ctx.fillText(`y = ${middle.name}.y`, 10, 370);
            ctx.strokeText(`x = ${top.name}.x + (${middle.name}.y - ${top.name}.y) * (${bottom.name}.x - ${top.name}.x)/(${bottom.name}.y - ${top.name}.y)`, 10, 340);
            ctx.fillText(`x = ${top.name}.x + (${middle.name}.y - ${top.name}.y) * (${bottom.name}.x - ${top.name}.x)/(${bottom.name}.y - ${top.name}.y)`, 10, 340);
            ctx.strokeText(`x = ${top.name}.x + (y difference from ${middle.name} to ${top.name}) * inverse slope of ${bottom.name} to ${top.name}`, 10, 310);
            ctx.fillText(`x = ${top.name}.x + (y difference from ${middle.name} to ${top.name}) * inverse slope of ${bottom.name} to ${top.name}`, 10, 310);
        }
        function triangleMidpoint_mousedown(evt) {
            if((mouseX-a.x)*(mouseX-a.x)+(mouseY-a.y)*(mouseY-a.y) < 32)
                selected = a;
            else if((mouseX-b.x)*(mouseX-b.x)+(mouseY-b.y)*(mouseY-b.y) < 32)
                selected = b;
            else if((mouseX-c.x)*(mouseX-c.x)+(mouseY-c.y)*(mouseY-c.y) < 32)
                selected = c;
            else selected = undefined;
            mouseDown = true;
        }

        function triangleMidpoint_mouseup(evt) {
            mouseDown = false;
            selected = undefined;
        }

        }
        </script>
        <h3 class="basictext outlinetext">Try moving points around, observe what calculations are used to find (x, y)</h3>

        <h3 class="basictext outlinetext" style="text-align: left">
        &emsp;Given all this, we can now draw any 2 dimensional triangle to the screen by splitting it into two flat-terminating triangles and drawing each of them with our flat-terminating triangle method.
        </h3>

        <div style="width: 800; border: inset 2px #A3C3A3; background-color: #A3C3A3">
            <h3 class="basictext" style="text-align:left; margin:5px; color:#202030">
            Sub flat_triangle(x1, y1, x2, x3, term) <span style="color:#602060">A is (x1, y1), B is (x2, term), and C is (x3, term)<br></span>
            <span style="color:#602060">&emsp;Declare inverse slops from a to b, and a to c<br></span>
            &emsp;a_m = (x2 - x1) / (term - y1)<br>
            &emsp;b_m = (x3 - x1) / (term - y1)<br><br>

            <span style="color:#602060">&emsp;Declare the y "scanline", set it to the terminator and work up to the origin<br></span>
            &emsp;fty = term<br>
            <span style="color:#602060"><br>&emsp;Declare the two x values that walk the lines from the terminator to the origin<br></span>
            &emsp;lx = x2<br>
            &emsp;rx = x3<br>
            <span style="color:#602060">&emsp;Sign dictates whether rx is in the positive-x or negative-x direction from lx<br></span>
            &emsp;sign = Sgn(rx-lx)<br>
            <span style="color:#602060">&emsp;Same with ysign and y1-terminator<br></span>
            &emsp;ysign = Sgn(y1-term)<br><br>
            &emsp;Do<br>
            <span style="color:#602060">&emsp;&emsp;Increment y towards the origin<br></span>
            &emsp;&emsp;fty = fty + ysign<br>
            <span style="color:#602060">&emsp;&emsp;Travel lx down line a, (x2, bottom)->(x1, y1), and rx down line b<br></span>
            &emsp;&emsp;lx = lx + a_m<br>
            &emsp;&emsp;rx = rx + b_m<br>
            <span style="color:#602060">&emsp;&emsp;Declare the current x position that we will plot a pixel at<br></span>
            &emsp;&emsp;ftx = lx<br>
            &emsp;&emsp;Do<br>
            &emsp;&emsp;&emsp;PSet (ftx + xoff, fty + yoff) <span style="color:#602060">Set the pixel!</span><br>
            <span style="color:#602060">&emsp;&emsp;&emsp;Increment ftx in the direction of rx<br></span>
            &emsp;&emsp;&emsp;ftx = ftx + sign<br>
            <span style="color:#602060">&emsp;&emsp;&emsp;Do this until the current x surpasses rx.<br>
            &emsp;&emsp;&emsp;Sign is checked in order to tell if ftx surpasses rx when it's greater, or lower<br></span>
            &emsp;&emsp;Loop While ((sign = 1 And ftx < rx) Or (sign = -1 And ftx > rx))<br>
            &emsp;Loop While ((ysign = 1 And ftx < y1) Or (ysign = -1 And ftx > y1))<br>
            End Sub
            </h3>
        </div>
        <div style="width: 800; border: inset 2px #A3C3A3; background-color: #A3C3A3">
            <h3 class="basictext" style="text-align:left; margin:5px; color:#202030">
            Sub triangle (x1, y1, x2, y2, x3, y3)<br>
            <span style="color:#602060">&emsp;If any two y coordinates are equal, then draw a flat triangle<br></span>
            &emsp;If y1 = y2 Then<br>
            &emsp;&emsp;Call flat_triangle(x3, y3, x1, x2, y1): GoTo ft2dskip<br>
            &emsp;ElseIf y2 = y3 Then<br>
            &emsp;&emsp;Call flat_triangle(x1, y1, x2, x3, y2): GoTo ft2dskip<br>
            &emsp;ElseIf y3 = y1 Then<br>
            &emsp;&emsp;Call flat_triangle(x2, y2, x1, x3, y1): GoTo ft2dskip<br>
            &emsp;End If<br><br>

            <span style="color:#602060">&emsp;Find the middle y-coordinate and split the triangle into 2 flat triangles<br>
            &emsp;And for each point, find the missing x value opposite of the middle<br>
            &emsp;During the explanation, I used the top point to find the missing midpoint.<br>
            &emsp;But it can be found even if we interchange the bottom and top point,<br>
            &emsp;so we can avoid figuring out which is the top and find the midpoint directly from<br>
            &emsp;one of the non-middle points<br><br></span>
            &emsp;If (y1 < y2 And y1 > y3) Or (y1 > y2 And y1 < y3) Then<br>
            &emsp;&emsp;m = x2 + (y1 - y2) * (x3 - x2) / (y3 - y2)<br>
            &emsp;&emsp;Call flat_triangle(x3, y3, x1, m, y1)<br>
            &emsp;&emsp;Call flat_triangle(x2, y2, x1, m, y1)<br>
            &emsp;&emsp;GoTo ft2dskip<br>
            &emsp;ElseIf (y2 < y1 And y2 > y3) Or (y2 > y1 And y2 < y3) Then<br>
            &emsp;&emsp;m = x1 + (y2 - y1) * (x3 - x1) / (y3 - y1)<br>
            &emsp;&emsp;Call flat_triangle(x3, y3, x2, m, y2)<br>
            &emsp;&emsp;Call flat_triangle(x1, y1, x2, m, y2)<br>
            &emsp;&emsp;GoTo ft2dskip<br>
            &emsp;ElseIf (y3 < y1 And y3 > y2) Or (y3 > y1 And y3 < y2) Then<br>
            &emsp;&emsp;m = x1 + (y3 - y1) * (x2 - x1) / (y2 - y1)<br>
            &emsp;&emsp;Call flat_triangle(x2, y2, x3, m, y3)<br>
            &emsp;&emsp;Call flat_triangle(x1, y1, x3, m, y3)<br>
            &emsp;End If<br><br>
            &emsp;ft2dskip:<br>
            End Sub<br>
            </h3>
        </div>

        

        <div class="section" style="position: absolute; left:900; top:100; width:250">
            <h3 class="basictext outlinetext">The only time a triangle can't be split up this way, is if it already has a horizontally-flat edge; In the program we will test for these cases and use them to speed up our rasterization.</h3>
            <?php pointer(50, 130, false)?>
        </div>

        <div class="section" style="position: absolute; left:825; top:3300; width:350">
            <h3 class="basictext outlinetext" style="text-align: left; margin: 5px">If y1 < y2 and y1 > y3 Then<br>&emsp;y1 is middle<br>&emsp;y2 is bottom (y-positive is down)<br>&emsp;y3 is top<br><br>Etc.</h3>
            <?php pointer(48, 340, false)?>
        </div>
    </div>

    <h1 class="basictext outlinetext" style="margin: 100px auto 50px auto" id="barycentric">Barycentric Coordinates</h1>
    <div class="" style="position: relative; margin: 0 auto auto auto; width: 800">
        <h3 class="basictext outlinetext" style="text-align:left">
        &emsp;Barycentric coordinates are a system of coordinates
        that, for triangles, gives you the area of 3 sub-triangles in relation to the area of the original triangle given point P.
        This is used to blend vertex attributes, such as color or depth. We will need barycentric coordinates for depth, but we can also use it to make our
        triangles look a little more interesting, by binding point 1 of our triangle to the color red, point 2 to green, and point 3 to blue, and then
        using barycentric coordinates to find the color of any given pixel in between.
        </h3>
        <!-- <img src="assets/qb64 3d/barycentric.png" style="width:100%"> -->
        <video width="100%" height="auto" autoplay loop muted>
            <source src="assets/qb64 3d/UVWfromArea.mp4" type="video/mp4" />
        </video>
        <h3 class="basictext outlinetext" style="text-align:left">
        &emsp;Calculating the barycentric coordinates are just as they're defined. We take a point we wish to take the barycentric coordinates of, say P.
        Then, with triangle, ΔABC, the barycentric coordinates would be denoted as
        &emsp;&emsp;$$\left(\frac{\mathrm{area of} ΔPBC}{\mathrm{area of} ΔABC}, \frac{\mathrm{area of} ΔPAC}{\mathrm{area of} ΔABC}, \frac{\mathrm{area of} ΔPAB}{\mathrm{area of} ΔABC}\right).$$<br>
        &emsp;As we are given our 3 triangle points during rendering, and we find our point P (the x and y of the pixel we're writing to), we just need to
        solve for a few areas in order to gather the barycentric coordinates of our pixel.
        </h3>
        <h2 class="basictext outlinetext">Triangle Area via Cross Product</h2>
        <h3 class="basictext outlinetext" style="text-align:left">
            &emsp;The method we will use for solving the area of a triangle, will be the cross product. Note that the magnitude of the cross product
            of 2 vectors is equal to the area of a parallelogram formed by those two vectors. Also take note that the area of a triangle is half of
            that of a parallelogram formed by two of it's sides. Knowing this brings us to the conclusion that solving the area of a triangle given 3 points
            is as simple as forming 2 vectors from it's 3 points, making one the origin, and cross multiplying. Taking the absolute value of the result,
            and taking one half of it.  
        </h3>
        <!-- <img src="assets/qb64 3d/acrossb.png" style="width:100%"> -->
        <h3 class="basictext outlinetext" style="text-align:left">
            &emsp;The nature for this is enveloped in linear algebra, but the cross product takes two vectors and finds a vector perpendicular to both,
            with said magnitude being the area of a parallelogram. This is convenient for us, as we are working with 2d triangles, meaning that the perpendicular
            vector will be in either the positive or negative z direction, with x and y components being 0. Therefore, we just need to calculate the z component
            of the cross product between two vectors made from our triangle.
        </h3>
        <video width="100%" height="auto" autoplay loop muted>
            <source src="assets/qb64 3d/areafromcross.mp4" type="video/mp4" />
        </video>

        <h3 class="basictext outlinetext" style="text-align:left">
            &emsp;Calculating the z component of the cross product between two 2D vectors relies on linear algebra, but getting straight to the calculations we get;
            $$a_x * b_y - a_y * b_x$$
            Or, given 3 points;
            $$\left(x_2-x_1\right) * \left(y_3-y_1\right) - \left(y_2-y_1\right) * \left(x_3-x_1\right) $$
            Or, finding triangle area;
            $$\frac{\left(x_2-x_1\right) * \left(y_3-y_1\right) - \left(y_2-y_1\right) * \left(x_3-x_1\right)}{2}$$
            <br>
            &emsp;Then, when taking the barycentric coordinates, (denoted u, v, and w), we replace \(x_1\) with our sample point's x, \(p_x\) and we replace
            \(y_1\) with \(p_y\), then replacing \(x_2\) and \(y_2\) with our point, and finally \(x_3\) and \(y_3\), giving us:
            $$a = \frac{\left(x_2-x_1\right) * \left(y_3-y_1\right) - \left(y_2-y_1\right) * \left(x_3-x_1\right)}{2}$$
            $$u = \frac{\left(x_2-p_x\right) * \left(y_3-p_y\right) - \left(y_2-p_y\right) * \left(x_3-p_x\right)}{2a}$$
            $$v = \frac{\left(p_x-x_1\right) * \left(y_3-y_1\right) - \left(p_y-y_1\right) * \left(x_3-x_1\right)}{2a}$$
            $$w = \frac{\left(x_2-x_1\right) * \left(p_y-y_1\right) - \left(y_2-y_1\right) * \left(p_x-x_1\right)}{2a}$$
            
        </h3>

        <h3 class="basictext outlinetext" style="text-align:left">
            &emsp;The resulting \(u\), \(v\), and \(w\) can be thought of as percentages that can be used to interpolate values between vertices. For instance,
            if \(u\) is 1, then the pixel point lies at vertex 1, and the equivelent subtriangle for u is equal to the total area. But if \(u\) is 0, the pixel point
            is as far away from \(u\) it can be, and should inherit no value from vertex 1. This makes points with \(u\) values of 0.5 inherit half of it's data
            from vertex 1, and the rest of it's data from vertices 2 and 3.<br>
            &emsp;If we assign color to points with \(u\) resulting in red, \(v\) in green, and \(w\) in blue, we can create a gradient of colors being more red near
            vertex 1, green near vertex 2, and blue near vertex 3, and a mixture of all three throughout the triangle.
        </h3>
        <video width="100%" height="auto" autoplay loop muted>
            <source src="assets/qb64 3d/usinguvw.mp4" type="video/mp4" />
        </video>

        <h3 class="basictext outlinetext" style="text-align: left">
            &emsp;The same can be applied to texture coordinates. Say that each vertex lies at a certain point on an image, you can use barycentric coordinates to
            figure out where each pixel lands on that given image.
        </h3>
        <!-- <img src="assets/qb64 3d/rainbowtextureexample.png" style="width:50%; height: auto; display:block; margin: auto" /> -->
        <video autoplay loop muted style="display: block; margin: auto">
            <source src="assets/qb64 3d/uvtotexture.mp4" type="video/mp4" />
        </video>

        <div class="section" style="position: absolute; left:-300; top:1350; width:250">
            <h3 class="basictext outlinetext">To learn why that is, check out Grant Sanderson/3blue1brown's <a href="https://www.youtube.com/watch?v=eu6i7WJeinw">video on cross products</a></h3>
            <?php pointer(20, 20, true)?>
        </div>
        <div class="section" style="position: absolute; left:900; top:2150; width:250">
            <h3 class="basictext outlinetext">You may simplify \(\frac{...}{2a}\) with \(\frac{...}{a}\) by not dividing \(a\) by 2, however you will need to keep in mind that \(a\) is now twice the area of the triangle.</h3>
            <?php pointer(40, 260, false)?>
            <?php pointer(110, 260, false)?>
        </div>
    </div>
    
    <h1 class="basictext outlinetext" style="margin: 100px auto 50px auto" id="linear">Linear Algebra for the Faint of Heart</h1>
    <div class="" style="position: relative; margin: 0 auto auto auto; width: 800">
        <h3 class="basictext outlinetext">For a more in-depth and general approach, I recommend Grand Sanderson/3blue1brown's series:
            <a href="https://youtu.be/fNk_zzaMoSs?list=PLZHQObOWTQDPD3MizzM2xVFitgF8hE_ab">Essence of Linear Algebra</a>
            It goes through everything visually and can teach anyone with any amount of knowledge a general understanding of what Linear Algebra is.
        </h3>
        <h3 class="basictext outlinetext" style="text-align: left">
            &emsp;Our usage of Linear Algebra revolves around using Matrices to transform Vectors. But firstly, we shall define those terms.
            A Matrix, (plural Matrices) is a # by # series of numbers, typically used to describe a transformation. For instance, a matrix might stretch/scale
            all x values out by a factor of 2.
            $$\begin{bmatrix}2 & 0\\ 0 & 1\end{bmatrix}$$
            <span style="text-align:center">Or</span>
            $$x' = 2*x + 0*y$$
            $$y' = 0*x + 1*y$$
        </h3>
        <video width="100%" height="auto" autoplay loop muted>
            <source src="assets/qb64 3d/matrixExample.mp4"/>
        </video>
        <h3 class="basictext outlinetext" style="text-align: left">
            &emsp;A vector, in the way we define it, is an arrow with the tail end sitting on the Origin, (the coordinates 0, 0), and the tip sitting at
            a given coordinate. It is defined only by it's tip's coordinates, as the tail will never be anywhere besides the origin.<br>
            &emsp;And so matrix multiplication can be thought of as a global transformer. You can plug any vector or coordinate in and get a resulting coordinate
            that follows the rules. This is useful to us as we can then create a transformation that say, rotates all vectors. Or one that projects all vectors from 3d to 2d. 
        </h3>
        <video width="100%" height="auto" autoplay loop muted>
            <source src="assets/qb64 3d/vectormatrixexample.mp4"/>
        </video>
        <h3 class="basictext outlinetext">
            &emsp;The Matrices used above are as follows
            $$\begin{bmatrix}2 & 0\\ 0 & 1\end{bmatrix}$$
            $$\begin{bmatrix}cos(90^{\circ}) & -sin(90^{\circ})\\sin(90^{\circ}) & cos(90^{\circ})\end{bmatrix}$$
            And
            $$\begin{bmatrix}1 & 1\\ 0 & 1\end{bmatrix}$$            
        </h3>

        <h3 class="basictext outlinetext" style="text-align:left">
            &emsp;The Matrices we use will be based off of Column Vectors. Meaning that we will write our vectors standing upright as so
            $$\begin{bmatrix}x\\y\\z\\w\end{bmatrix}$$
            &emsp;This matters as the process of multiplying a Row Vector with a matrix, and a Column Vector with a matrix changes the output, even though
            the only difference between Row and Column Vectors is notation.
            $$\begin{bmatrix}x\\y\\z\\w\end{bmatrix}\begin{bmatrix}\color{red}a_0 & \color{red}a_1 & \color{red}a_2 & \color{red}a_3\\\color{green}b_0&\color{green}b_1&\color{green}b_2&\color{green}b_3\\\color{blue}c_0&\color{blue}c_1&\color{blue}c_2&\color{blue}c_3\\\color{yellow}d_0&\color{yellow}d_1&\color{yellow}d_2&\color{yellow}d_3\end{bmatrix}$$
            $$=$$
            $$x' = x\textcolor{red}{a_0} + y\textcolor{red}{a_1} + z\textcolor{red}{a_2} + w\textcolor{red}{a_3}$$
            $$y' = x\textcolor{green}{b_0} + y\textcolor{green}{b_1} + z\textcolor{green}{b_2} + w\textcolor{green}{b_3}$$
            $$z' = x\textcolor{blue}{c_0} + y\textcolor{blue}{c_1} + z\textcolor{blue}{c_2} + w\textcolor{blue}{c_3}$$
            $$w' = x\textcolor{yellow}{d_0} + y\textcolor{yellow}{d_1} + z\textcolor{yellow}{d_2} + w\textcolor{yellow}{d_3}$$

            $$\begin{bmatrix}x&y&z&w\end{bmatrix}\begin{bmatrix}\color{red}a_0 & \color{red}a_1 & \color{red}a_2 & \color{red}a_3\\\color{green}b_0&\color{green}b_1&\color{green}b_2&\color{green}b_3\\\color{blue}c_0&\color{blue}c_1&\color{blue}c_2&\color{blue}c_3\\\color{yellow}d_0&\color{yellow}d_1&\color{yellow}d_2&\color{yellow}d_3\end{bmatrix}$$
            $$=$$
            $$x' = x\textcolor{red}{a_0} + y\textcolor{green}{b_0} + z\textcolor{blue}{c_0} + w\textcolor{yellow}{d_0}$$
            $$y' = x\textcolor{red}{a_1} + y\textcolor{green}{b_1} + z\textcolor{blue}{c_1} + w\textcolor{yellow}{d_1}$$
            $$z' = x\textcolor{red}{a_2} + y\textcolor{green}{b_2} + z\textcolor{blue}{c_2} + w\textcolor{yellow}{d_2}$$
            $$w' = x\textcolor{red}{a_3} + y\textcolor{green}{b_3} + z\textcolor{blue}{c_3} + w\textcolor{yellow}{d_3}$$
            <!--&emsp;Now that we've established what Matrix with Vector multiplication is and how it works, we can define exactly what we will use it for.
            In the program I built, I have used it for two things, Projection, and Rotation. It can be used for Translation, i.e. moving an object around, 
            but as cutting as many corners as we can is important for us, I have left translation up to simply adding numbers to the X, Y, and Z coordinates.<br>
            &emsp;Starting things off with Projection, projection is the process of taking an n-Dimensional scene and bringing it down to a (n-1)-Dimensional
            representation. Like casting a shadow of one to the other. And so, 3D projection involves taking a 3D scene and bringing it down to a 2D one. You
            may recall from personal experience that things appear smaller as the distance from your eye(s) and the thing increases. And so we want a matrix
            that scales down an object as it gets further away from whatever is looking at it. But what IS the distance?<br>
            &emsp; We can describe our "viewpoint" as whatever we're looking through to see the object. Let's place this at the origin, or (0, 0, 0) as we're in
            3 Dimensions. X, Y, and Z. But what's W then? Well, in 3D graphics, W is a assisting dimension that's almost always equal to 1. This is useful for
            Translation, as in our column vector example, \(x'\) adds \(w * a_3\), and if w is always 1, then \(x'\) is just adding \(a_3\).<br>
            &emsp;But back to projection, recall that scaling a scene is done through multiplication. And if we want our 2D x and y coordinates to decrease
            in scale, we must be specifically dividing by \(z\), or multiplying by \(1\over z\). This starts our illusion that we desire.-->
        </h3>
        <h3 class="basictext outlinetext" style="text-align:left">
            &emsp;3D rendering of all sorts relies around transforming from one coordinate space to another. But what is a coordinate space?
            You may recall that your screen is a series
            of pixels given at a certain resolution. This can give you the coordinates for each pixel. Generally 2D integers coordinates, such as (100, 240) or
            (145, 23). The coordinates we will be supplying our 3D projector is abstract units that could be integers or have decimals or whatever scale you,
            the programmer and artist of this project, chooses. Our projector will then transform these coordinates into "screenspace coordinates", which are
            2 dimensional coordinates ranging from (-1, -1) to (1, 1). And finally, we must convert this range of numbers to pixel coordinates in order to show
            the image we desire.<br>
            &emsp;The first transforming Matrix we will use, is;
            $$\begin{bmatrix}\color{red}F_x & 0 & 0 & 0\\0 & \color{red}F_y & 0 & 0\\0 & 0 & \color{yellow}Z_m & \color{yellow}Z_a \\ 0 & 0 & \color{blue}-1 & 0 \\\end{bmatrix}$$
            &emsp;And the second one we will use is;
            $$\begin{bmatrix}\color{red}1/z'&0&0&0\\0&\color{red}1/z'&0&0\\0&0&1&0\\0&0&0&1\end{bmatrix}$$
            &emsp;Or, simply:
            $$x'' = x' / z'$$
            $$y'' = y' / z'$$
            &emsp;The first prepares for projection, and the second does the projection in scaling as the distance, (i.e. the z value) changes. But let's
            discuss each operation as they're happening.
        </h3>
        <h3 class="basictext outlinetext" style="text-align:left">
            &emsp;\(F_x\) and \(F_y\) each transform the x coordinates and the y coordinates based on a defined FOV and ratio between the width and height
            of the display. As, if scaled equally, the x and the y would appear squished if the width was greater than the height of the display, and
            stretched if the height is greater than the width. The FOV is calculated through \(\cot(\frac{\theta}{2})\)
            And it represents the plane at which everything is projected onto being scaled up and down as the FOV of the "viewpoint" looking at it increases.
            In order to take into account the display width-height ratio, we would scale \(\theta\) for \(F_x\) and \(F_y\) differently according to the width
            height ratio.<br>
            &emsp;So in conclusion, \(F_x\) and \(F_y\) scale the x and y coordinates based on a Field of View angle and width-height ratio.<br>
            &emsp;\(Z_m\) and \(Z_a\) are more about setting a maximum and minimum z-value, otherwise known as the Far and Near Clipping Planes. We want a Z
            that originally is equal to the Far plane, to stay equal to the far plane. And a Z that is equal to the near plane, to be equal to 0. For this we
            can set.
            $$ Z_m = \mp\frac{F}{F-N} $$ 
            $$ Z_a = -\frac{F \times N}{F-N} $$
            &emsp;Whether or not \(Z_m\) is positive or negative depends on which z-direction is forward. It's typically negative, as, following the right
            hand coordinate system, Z-negative is "forward". \(Z_a\) is ultimately added to the input z (after multiplying it by \(Z_m\)) as z will be equal to
            \(x \times 0 + y \times 0 + z \times Z_m + w \times Z_a\) where we've already established that w = 1.
            And such, we have a final Matrix of
            $$\begin{bmatrix}cot(\frac{\theta}{2}) & 0 & 0 & 0 \\ 0 & cot(\frac{\theta}{2} \times \frac{W}{H}) & 0 & 0 \\ 0 & 0 & -\frac{F}{F-N} & -\frac{F \times N}{F-N} \\ 0 & 0 & -1 & 0 \end{bmatrix}$$
            Where \(\theta\) is the angle of FOV, \(W\) and \(H\) are the dimensions of the display, and \(F\) and \(N\) being the Near and Far clipping planes respectively.<br>
            &emsp;When programming in a high-maintenance environment like BASIC, it's important to pre-compute as much as possible. So it's helpful that we
            should define all these numbers before any triangles have started rasterizing. With this in mind, lets step out of Matrix notation and show each
            computation that needs to genuinely be done.
            $$ z' = z \times Z_m + Z_a $$
            $$ x' = \frac{x \times cot(\frac{\theta}{2})}{z'} $$
            $$ y' = \frac{y \times cot(\frac{\theta}{2} \times \frac{W}{H})}{z'} $$ 
            This gives us 2D x and y values \(x'\) and \(y'\) ranging from -1 to 1. We can translate these to pixel coordinates by simply
            $$ x'' = (x' \times 0.5 + 0.5) \times W $$
            $$ y'' = (y' \times 0.5 + 0.5) \times H $$
            But we've almost forgotten something. You see that -1 in row 4 column 3 of the perspective matrix? That means that after multiplying a vector with it,
            \(w' = -z\). This is used to preserve the original Z coordinates. And since negative-z direction is 'forward', we make it negative in order to prime for
            depth testi
            ng. We've converted to 2 Dimensions, we still need to make sure things closer to the viewpoint are shown over things further from it.
        </h3>

        <div class="section" style="position: absolute; left:110%; top:1600; width:250">
            <h3 class="basictext outlinetext">
                Simplifies to
                $$\begin{bmatrix}0 & -1\\1 & 0\end{bmatrix}$$
                <?php pointer(30, 360, false)?>
            </h3>
        </div>
        
    </div>
    <h1 class="basictext outlinetext" style="margin: 100px auto 50px auto" id="depth">Depth is Easier than it Seems</h1>
    <div class="" style="position: relative; margin: 0 auto auto auto; width: 800">
        <h3 class="basictext outlinetext" style="text-align:left">
            &emsp;Even though we have managed to project 3d points into 2d ones, and use them to draw triangles, we still need to keep ahold of their distance
            from the viewpoint, (or depth as it's called) otherwise pixels would be shown in whatever order the triangles are drawn. Making far away triangles
            possibly show up in front of near-by triangles. This is actually quite simple, as we just need to test if the original z value is closer or further
            to 0.<br>
            &emsp;But if it didn't need any explanation, I wouldn't have dedicated a section to it. There's a bit of a trickiness to it. As it turns out, we
            need to gather the depth of each pixel. And here's a hint, we can do this with barycentric coordinates.<br>
            &emsp;Unfortunately, unlike colors and other linear vertex attributes, we can't just do
            $$depth = depth_u * u + depth_v * v + depth_w * w$$
            We instead need to do
            $$\frac{1}{depth} = u\frac{1}{depth_u} + v\frac{1}{depth_v} + w\frac{1}{depth_w}$$
            &emsp;You'll find that by attempting to use the first equation over the latter to calculate depth will result in strange curves when geometry
            intersects eachother. The reasoning for this lies in how depth actually effects coordinates. Each x and y value are divided by their depth,
            rather than simply translated. This ends in every x and y value not being transformed equally, the depth of a triangle per-pixel would appear
            more like this, rather than this.
        </h3>
        <img src="assets/qb64 3d/triangledepth.png" alt="triangle depth 'graphs'"/>
        <h3 class="basictext outlinetext" style="text-align:left">
            &emsp;You can think about it as if a point is traveling an inch per every second along a triangle before it's projected. From the projection's perspective (pun intended)
            the point travels slower and slower as it gets further away, but we know it's still physically moving an inch per second. This shows us that
            although the pixels at which the point is projected to may change slower and slower over time, but it's still changing distance, and this is lost
            with simple 2d barycentric coordinates.<br>
            &emsp;We can see that using reciprocals fights that linear bias, and results in a more realistic interpolated depth. You can think about it as
            when the Z value of a point increases, the reciprocal shrinks, but it doesn't shrink as fast when Z is changing from 9 to 10, than when it changes
            from 1 to 2.
        </h3>
        <h3 class="basictext outlinetext" style="text-align: left">
            &emsp;Now we have taken the depth of every pixel, it's time we should compare them. The method I have dedicated towards my program is by holding two seperate buffers
            for each pixel, one dedicated to depth, and one to the time a pixel was last updated. And thus the method for every pixel will be this:<br>
            &emsp;&emsp;For every pixel, determine it's depth, and take note of which frame it is being drawn on.<br>
            &emsp;&emsp;Check the depth and time buffers. Draw the pixel if either it has a distance less than that in the depth buffer, or if it's time is greater (newer) than the time stored at that pixel in the time buffer<br>
            &emsp;This allows pixels to be drawn in the correct order, and for older pixels to be ignored without having to clear any buffer.
        </h3>
        <h3 class="basictext outlinetext">
            \[\begin{gather*}
            depth[W*H]\\
            times[W*H]\\
            currenttime = 0\\
            ...\\
            every\ frame: currenttime = currenttime + 1\\
            ...\\
            for\ every\ triangle\ pixel\ p:\\
            if\ \left(p_{depth} < depth[p_y * W + p_x]\; or\; currenttime < times[p_y * W + p_x]\right):\\
                then \\
                depth[p_y * W + p_x] = p_{depth}\\
                times[p_y * W + p_x] = currenttime\\
                draw\ pixel\ p.\\
            \end{gather*}\]
        </h3>
        <h3 class="basictext outlinetext" style="text-align: left">
            &emsp;It's reasonable then to check for depth as soon as we can in our final triangle rasterizer. As we don't want to waste any computational time
            on unseen pixels.
        </h3>
    </div>
    <h1 class="basictext outlinetext" id="correctionbarycentric">Correcting Barycentric Coordinates with Depth</h1>
    <div class="" style="position: relative; margin: 0 auto auto auto; width: 800">
        <h3 class="basictext outlinetext" style="text-align:left">
            &emsp;Now there is nothing wrong with our barycentric coordinates directly. I haven't lied to you about how we get barycetric coordinates.
            But you might find that as you plug in all these formulas that something seems off about the triangles. They all look 2D. This is a weird
            claim to make but it makes sense with an explanation. With the barycentric coordinates we have now, the triangle uses the 2D center
            of the triangle we have given it, when in reality, the center of a 3D triangle depends on the depth of each of its points.<br>
            &emsp;This is showcased by Scratchapixel in this graphic displaying the difference between "naive" barycentric interpolation, and perspective
            correct interpolation.
        </h3>
        <img src="assets/qb64 3d/perspectivecorrection.png" style="width:100%">
        <h3 class="basictext outlinetext" style="text-align: left">
            &emsp;You'll see in the image that the triangle on the left appears 2 Dimensional and flat, whereas it's easier to gather the depth from the
            second triangle. This is how things will appear after depth correction of the vertex attributes.<br>
            &emsp;This problem is more apparent when using textures as images will hold straight lines, whereas simple gradients might hide misteps.
        </h3>
        <img src="assets/qb64 3d/naivevscorrect.png" style="width:100%">
        <h3 class="basictext outlinetext" style="text-align:left">
            &emsp;The answer lies simply in using the depths of each vertex in comparison to the current depth of the pixel.    
        </h3>
    </div>

    <!--
        Resources:
        3blue1brown cross product: relation to the area of a parallelogram
        https://www.youtube.com/watch?v=eu6i7WJeinw

        Correct way to interpolate depth from Scratchapixel; Overall great resource for 3d rendering/rasterizing
        https://www.scratchapixel.com/lessons/3d-basic-rendering/rasterization-practical-implementation/visibility-problem-depth-buffer-depth-interpolation

        Another scratchapixel source to show why and how we correct UVW to fit perspective
        https://www.scratchapixel.com/lessons/3d-basic-rendering/rasterization-practical-implementation/perspective-correct-interpolation-vertex-attributes

        Scratchapixel overview for projection matrices
        https://www.scratchapixel.com/lessons/3d-basic-rendering/perspective-and-orthographic-projection-matrix/building-basic-perspective-projection-matrix
    -->
    <!-- Required to end Universal and "cut" divs -->
    </div>
    </div>
</body>

</html>
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
    <img src="assets/qb64 3d/thumb.png" style="width: 800px; height: auto; display: block; margin: 0px auto 150px auto; float: center">
    <h3 class="basictext outline"></h3>

    <h3 class="basictext outlinetext" style="font-size: 24px; margin: auto auto 100px auto">
        <span style="text-decoration:underline; font-size:32">Contents</span><br>
        <a class="link basictext" href="#qb64">What is QB64?<a><br>
        <a class="link basictext" href="#raster">What is 3D Rasterizing?</a><br>
        <a class="link basictext" href="#triangles">Triangles 101</a><br>
        <a class="link basictext" href="#linear">Linear Algebra for the Faint of Heart</a><br>
        <a class="link basictext" href="#depth">Depth is Easier than it Seems</a><br>
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
        <canvas class="section" id="lineExample_canvas" width=800 height=400 style="width:800; height:400;" onmousemove="lineExample_mouseMove(event);"></canvas>
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
        <canvas class="section" id="lineWalkExample_canvas" width=800 height=400 style="width:800; height:400;"></canvas>
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

        <canvas class="section" id="flatTriangle_canvas" width=800 height=400 style="width:800; height:400;"></canvas>
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

        <canvas class="section" id="triangleMidpoint_canvas" width=800 height=400 style="width:800; height:400;" onmousemove="triangleMidpoint_mousemove(event)" onmousedown="triangleMidpoint_mousedown(event)" onmouseup="triangleMidpoint_mouseup(event)"></canvas>
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

        <div class="section" style="position: absolute; left:900; top:100; width:250">
            <h3 class="basictext outlinetext">The only time a triangle can't be split up this way, is if it already has a horizontally-flat edge; In the program we will test for these cases and use them to speed up our rasterization.</h3>
            <?php pointer(50, 130, false)?>
        </div>

        <div class="section" style="position: absolute; left:900; top:3300; width:350">
            <h3 class="basictext outlinetext" style="text-align: left; margin: 5px">If y1 < y2 and y1 > y3 Then<br>&emsp;y1 is middle<br>&emsp;y2 is bottom (y-positive is down)<br>&emsp;y3 is top<br><br>Etc.</h3>
            <?php pointer(48, 340, false)?>
        </div>
    </div>

    <!-- Required to end Universal and "cut" divs -->
    </div>
    </div>
</body>

</html>
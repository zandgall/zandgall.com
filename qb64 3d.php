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
include "global/header.php";
include "assets/qb64 3d/code/codereader.php";
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
<style>
.section {
    background: linear-gradient(rgba(124, 182, 229, 0.5), rgba(114, 142, 224, 0.5));
    border-radius: 15px;
    border: 2px solid rgba(59, 99, 163, 0.5);
    box-shadow: 0 0 8px 0px #22222c;
}

.section.night {
    background: linear-gradient(rgba(56, 56, 78, 0.5), rgba(44, 46, 64, 0.5));
    border-radius: 15px;
    border: 2px solid rgba(3, 9, 52, 0.5);
    box-shadow: 0 0 8px 0px #22222c;
}
.codeexample {
    width: 1000; 
    margin: 10px auto 10px -100px; 
    border: inset 2px #000027; 
    background-color: #000027
}
.codeexample.h3 {
    font-family: basicbit2
}
</style>


<?php 
$title = "Welcome to the site!";
$subtitle = "A resource for Arvopia and other projects";
include "global/begin.php"?>

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
        <a class="link basictext" href="#alltogether">Putting the Code All Together</a><br>
        <a class="link basictext" href="#optimization">Rotation with Optimization</a><br>
        <a class="link basictext" href="#extra">Going Forward with Graphics</a><br>
        <a class="link basictext" href="#resources">Further Resources</a><br>
    </h3>

    <h1 class="basictext outlinetext" style="margin: 100px auto 50px auto" id="qb64">What is QB64?</h1>
    <div class="" style="position: relative; margin: 0 auto auto auto; width: 800;">
        <h2 class="basictext outlinetext">In order to understand QB64, you must first know what BASIC is</h2>

        <h3 class="basictext outlinetext" style="text-align:left">&emsp;BASIC is a programming language developed in the late 60s and early 70s, becoming a mainstay as one of, if not the most influential programming languages of all time during the 80s. It was created to be a simple programming language that could be extremely easy to learn, but still really powerful as we'll soon see. During it's reign, an IDE called "Quick BASIC", or QBasic for short was created for DOS, accelerating BASIC's popularity and accessibility. Decades later, QBasic became the influence for QB64, a BASIC IDE for the 2000s. This became my IDE of choice, due to the modern OS compiling it brings, and it's simple project setup.</h3>
        <h3 class="basictext outlinetext" style="text-align:left">&emsp;Although being built for 64 bit systems, QB64 doesn't give you many more capabilities that BASIC would have given you back in the day. However, it does bring benefits in the realm of graphics, but this did not impede the project or learning experience.</h3>
        <h3 class="basictext outlinetext" style="text-align:left">&emsp;More information about QB64 and it's capabilities can be found at the <a href="https://www.qb64.org" style="text-decoration: none">QB64 homepage</a></h3>
        <img src="assets/qb64 3d/uiexample.png" style="display: block; width: 800; height: auto; margin: auto">
    </div>
    <h1 class="basictext outlinetext" style="margin: 100px auto 50px auto" id="raster">What is 3D Rasterization?</h1>
    <div class="" style="position: relative; margin: 0 auto auto auto; width: 800;">
        <h2 class="basictext outlinetext">3D Rasterization is a technique for drawing 3D scenes to a raster</h2>
        <h3 class="basictext outlinetext" style="text-align:left">
        &emsp;Rasterization in general is the practice of mapping vector graphics to a raster. A raster, like a screen, tends to be a list of colors, or 'pixels'.
        In 3D rasterization, these vector graphics are 3D objects projected onto a 2D plane, usually triangles onto a cross section of a virtual camera's viewport.
        That is, given a list of 3d objects and attributes of each of those objects, 3d rasterizing is a method that takes in that information and results in an image with
        a finite resolution.</h3>
        <h3 class="basictext outlinetext" style="text-align:left">
        &emsp;Projecting and Rasterizing 3D objects is complicated to learn, but becomes simple to execute when understood.
        There are numerous paths to achieve the desired result, and the paths this project took will be the only ones discussed here.
        This project, like many others, relies on triangles for their efficiency in rasterization, use of vertex attributes,
        and ability to form any other flat-faced 3d shape. There is a great deal of research and mathematical use behind triangles that makes them an
        extremely powerful and versitile shape, while being very efficient to draw to a screen.</h3>
        <h3 class="basictext outlinetext" style="text-align:left">
        &emsp;But before the project can display a full triangle, it needs to know how to project individual 3d points. It all comes down to some basic calculations,
        but the origins and explanations behind which are fascinating. The process will be simplified by cutting out any unnecessary details and features, this will result in a less
        interactive scene, but it cuts out many intermediate computations.</h3>
        <h3 class="basictext outlinetext" style="text-align:left">
        &emsp;After the process knows how to transform and project triangles, it needs to know how to avoid drawing anything on top of something that's
        supposed to be appear in front of it. Fortunately, it is an extremely simple process to include once the project is already drawing everything pixel-by-pixel.</h3>
        <div class="section" style="position: absolute; left:-300; top:0; width:250">
            <h3 class="basictext outlinetext">Vector graphics consist of shapes and perfect lines, they are infinitely scalable and don't conform to a resolution, unlike images</h3>
            <?php pointer(48, 50, true)?>
        </div>
        <div class="section" style="position: absolute; left:850; top:250; width:250">
            <h3 class="basictext outlinetext"><a href="#triangles">Triangles 101</a></h3>
            <?php pointer(15, 45, false)?>
        </div>
        <div class="section" style="position: absolute; left:-300; top:343; width:250">
            <h3 class="basictext outlinetext"><a href="#linear">Linear Algebra for the Faint of Heart</a></h3>
            <?php pointer(28, 50, true)?>
        </div>
        <div class="section" style="position: absolute; left:850; top:475; width:250">
            <h3 class="basictext outlinetext"><a href="#depth">Depth is Easier than it Seems</a></h3>
            <?php pointer(25, 50, false)?>
        </div>
    </div>
    <h1 class="basictext outlinetext" style="margin: 100px auto 50px auto" id="triangles">Triangles 101</h1>
    <div class="" style="position: relative; margin: 0 auto auto auto; width: 800">
        <h2 class="basictext outlinetext">Before trying to understand the exact math and programming behind rasterizing a triangle, it's important to define triangles in these three ways.</h2>
        <h3 class="basictext outlinetext" style="text-align:left">&emsp;1: A set of 3 points, with lines connecting points 1 - 2, 2 - 3, and 3 - 1.<br>&emsp;2: A single point with two lines jetting out from it, being filled until a terminating line.<br>&emsp;3: A set of two triangles. With each of their terminating lines being horizontally flat.</h3>
        <img src="assets/qb64 3d/aspointswithlines.png" style="display:block; width: 300px;height:auto; margin-left:-50px; float:left">
        <img src="assets/qb64 3d/asoriginterminator.png" style="display:block; width: 300px;height:auto; float:left; position:relative; z-index:14">
        <img src="assets/qb64 3d/as2terminatingtriangles.png" style="display:block; width: 300px;height:auto;margin-right:-50px; float:left">
        <h3 class="basictext outlinetext" style="text-align:left; margin-top:350;">
        &emsp;With these three manners, we can split up the process of drawing a triangle into simple steps.
        Firstly, drawing a triangle with a flat terminating line is much easier than one with a slanted terminating line.
        That is because, given a triangle of this manner, we can loop through every y position from the terminating line to the source.
        And given a y-value in a triangle, we can find the range of x values that form a horizontal slice of the triangle.
        Knowing this, we can write the processes for a flat-terminating triangle and be able to draw any triangle
        given that we can split it into it's top-triangle and bottom triangle as defined by definition #3.</h3>
        <img src="assets/qb64 3d/yrangeoftri.png" style="display:block; width:800px; height:auto">
        <h3 class="basictext outlinetext" style="text-align:left;">
        &emsp;To know each x value, we can consider the two lines that run through the origin, as defined by definition #2.
        Note that a line is given by the equation: "y = mx + b", and rewritten, we can find x when given y, using "x = (y - b)/m". 
        With this in mind, we can solve for the x-values of either line running through the origin when given the y position.
        Which can come straigh from our loop between the two y-limits of our triangles. We can simplify this however. We do not know b in our example, so let's replace this equation with
        "x = (y-offset.y)/m  + offset.x". This equation means that we are using the difference in y to find the difference in x, since we know that both x and y start at our offset.</h3>
        <canvas class="section" id="lineExample_canvas" width=800 height=400 style="width:800; height:400;" onmousemove="lineExample_mouseMove(event);">Canvas Unsupported</canvas>
        <script type="application/javascript">
            {
                let can = $("#lineExample_canvas")[0];
                let ctx = can.getContext("2d");
                function lineExample_mouseMove(evt) {
                    let rect = can.getBoundingClientRect();
                    ctx = can.getContext("2d");
                    let mouse;
                    if(evt == undefined) {
                        mouse = {x: 0, y: 0}
                    } else {
                        mouse = {
                            x: evt.clientX - rect.left,
                            y: evt.clientY - rect.top
                        };
                    }
                    let lineX = 500 + mouse.y/2;
                    let lineX2 = 575 + mouse.y/-1; // Physical y is (mouse.y - 400)/-1, but considering that positive-y is towards the bottom, simplifying will do
                    // console.log("Drawing!");
                    ctx.clearRect(0, 0, 800, 400);
                    ctx.fillStyle = "blue";
                    ctx.strokeStyle ="blue";
                    ctx.lineWidth = 5;

                    ctx.beginPath();
                    ctx.moveTo(500, 0);
                    ctx.lineTo(700,400);
                    ctx.moveTo(575, 0);
                    ctx.lineTo(175,400);
                    ctx.stroke();
                    ctx.setLineDash([10,10]);
                    ctx.strokeStyle = "white";
                    ctx.beginPath();
                    ctx.moveTo(0, 350);
                    ctx.lineTo(800, 350);
                    ctx.stroke();
                    ctx.setLineDash([]);

                    ctx.beginPath();
                    ctx.ellipse(lineX, mouse.y, 10, 10, 0, 0, 2*Math.PI);
                    ctx.ellipse(lineX2, mouse.y, 10, 10, 0, 0, 2*Math.PI);
                    ctx.fill();
                    ctx.beginPath();
                    ctx.ellipse(525, 50, 10, 10, 0, 0, 2*Math.PI);
                    ctx.fill();

                    ctx.font = "bold 1.17em sans-serif";
                    ctx.lineWidth = 4;
                    ctx.fillStyle="white";
                    ctx.strokeStyle="black";
                    ctx.strokeText("y = mouseY", 10, 40);
                    ctx.fillText("y = mouseY", 10, 40);
                    ctx.strokeText("x = (y-origin.y)/m + origin.x", 10, 70);
                    ctx.fillText("x = (y-origin.y)/m + origin.x", 10, 70);
                    ctx.strokeText("Origin", 540, 60);
                    ctx.fillText("Origin", 540, 60);
                    ctx.strokeText("Terminator", 10, 345);
                    ctx.fillText("Terminator", 10, 345);
                }
                $(document).ready(function() {
                    lineExample_mouseMove(undefined);
                });
            }
        </script>
        <h3 class="basictext outlinetext" style="text-align:left;">
        &emsp;From this idea of using the difference in y to find difference in x, we can simplify this process for the computer. For our end product, we will be looping through every pixel in a triangle,
        and for every y position included in the triangle, we find the range of x values included for the equivelent horizontal slice. We can loop through all y values very easily by setting an initial y value
        to the highest y coordiante of the triangle, and incrementing it until it surpasses the lowest y coordinate of the triangle. This is even easier with a horizontal-terminator triangle, as it just needs
        to loop between the y coordinate of the origin and the y coordinate of the terminator.<br>
        &emsp;This also makes calculating the x range much simpler. As we can set an initial x value to the x coordinate of the origin, and every time we increment the y value, we add 1/m to our x value. 
        We use 1/m as it is the derivative of "x = (y - origin.x)/m + origin.x" (more specifically the dx/dy). Essentially, the difference between "x = (y - origin.x)/m + origin.x" and "x = (y + 1 - origin.x)/m + origin.x"
        is just 1/m.</h3>
        <canvas class="section" id="lineWalkExample_canvas" width=800 height=400 style="width:800; height:400;">Canvas Unsupported</canvas>
        <script type="application/javascript">
            {
            let can = $("#lineWalkExample_canvas")[0];
            let ctx = can.getContext("2d");
            ctx.font = "bold 1.17em sans-serif";
            let lineWalk_step = -3;
            let lineWalk_y = 1;
            let lineWalk_x = 0.5;
            let lineWalk_x2 = -1;

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
                ctx.moveTo(575, 0);
                ctx.lineTo(175, 400);
                ctx.lineWidth = 5;
                ctx.stroke();
                ctx.beginPath();
                ctx.ellipse(lineWalk_x*50 + 500,  lineWalk_y*50, 10, 10, 0, 0, 2*Math.PI);
                ctx.ellipse(lineWalk_x2*50 + 575,  lineWalk_y*50, 10, 10, 0, 0, 2*Math.PI);
                ctx.fillStyle="blue";
                ctx.fill();
                ctx.beginPath();
                ctx.ellipse(525, 50, 10, 10, 0, 0, 2*Math.PI);
                ctx.fill();
                switch(lineWalk_step) {
                case 0:
                    ctx.beginPath();
                    ctx.fillStyle="white";
                    ctx.strokeStyle="white";
                    canvas_arrow(ctx, lineWalk_x*50 + 500, lineWalk_y*50 + 10, lineWalk_x*50 + 500, lineWalk_y*50 + 50, 5);
                    canvas_arrow(ctx, lineWalk_x2*50 + 575, lineWalk_y*50 + 10, lineWalk_x2*50 + 575, lineWalk_y*50 + 50, 5);
                    ctx.fillStyle= "white";
                    ctx.strokeStyle="black";
                    ctx.lineWidth = 4;
                    ctx.strokeText("y+1", lineWalk_x*50 + 487, lineWalk_y*50 + 70);
                    ctx.fillText("y+1", lineWalk_x*50 + 487, lineWalk_y*50 + 70);
                    ctx.strokeText("y+1", lineWalk_x2*50 + 562, lineWalk_y*50 + 70);
                    ctx.fillText("y+1", lineWalk_x2*50 + 562, lineWalk_y*50 + 70);

                    lineWalk_y++;
                    break;
                case 2:
                    ctx.beginPath();
                    ctx.fillStyle="white";
                    ctx.strokeStyle="white";
                    canvas_arrow(ctx, lineWalk_x*50 + 510, lineWalk_y*50, lineWalk_x*50 + 525, lineWalk_y*50, 5);
                    canvas_arrow(ctx, lineWalk_x2*50 + 565, lineWalk_y*50, lineWalk_x2*50 + 525, lineWalk_y*50, 5);
                    ctx.fillStyle= "white";
                    ctx.strokeStyle="black";
                    ctx.lineWidth = 4;
                    ctx.strokeText("x+1/m", lineWalk_x*50 + 500, lineWalk_y*50 + 20);
                    ctx.fillText("x+1/m", lineWalk_x*50 + 500, lineWalk_y*50 + 20);
                    ctx.strokeText("x+1/m", lineWalk_x2*50 + 515, lineWalk_y*50 + 20);
                    ctx.fillText("x+1/m", lineWalk_x2*50 + 515, lineWalk_y*50 + 20);
                    lineWalk_x+=0.5;
                    lineWalk_x2-=1;
                    break;
                // case 4:
                //     break;
                default:
                    break;
                }

                ctx.lineWidth = 4;
                ctx.setLineDash([10,10]);
                ctx.strokeStyle = "white";
                ctx.beginPath();
                ctx.moveTo(0, 350);
                ctx.lineTo(800, 350);
                ctx.stroke();
                ctx.setLineDash([]);
                ctx.strokeStyle="black";
                ctx.fillStyle=(lineWalk_step == -3 ? "yellow" : "white");
                ctx.strokeText("START", 10, 40);
                ctx.fillText("START", 10, 40);
                ctx.fillStyle=(lineWalk_step == -2 ? "yellow" : "white");
                ctx.strokeText("y = origin.y", 10, 70);
                ctx.fillText("y = origin.y", 10, 70);
                ctx.strokeText("x = origin.x", 10, 100);
                ctx.fillText("x = origin.x", 10, 100);
                ctx.fillStyle=(lineWalk_step == -1 ? "yellow" : "white");
                ctx.strokeText("LOOP", 10, 130);
                ctx.fillText("LOOP", 10, 130);
                ctx.fillStyle=(((lineWalk_step == 0 || lineWalk_step == 1) && lineWalk_y <= 8) ? "yellow" : "white");
                ctx.strokeText("y = y + 1", 30, 160);
                ctx.fillText("y = y + 1", 30, 160);
                ctx.fillStyle=((lineWalk_step == 2 || lineWalk_step == 3) ? "yellow" : "white");
                ctx.strokeText("x = x + 1/m", 30, 190);
                ctx.fillText("x = x + 1/m", 30, 190);
                ctx.fillStyle=((lineWalk_step == 4) ? (lineWalk_y >= 7 ? "#20ff60" : "yellow") : "white");
                ctx.strokeText("UNTIL (y ≥ terminator)", 10, 220);
                ctx.fillText("UNTIL (y ≥ terminator)", 10, 220);
                ctx.fillStyle = (lineWalk_step == 5 || lineWalk_step == 6) ? "yellow" : "white";
                ctx.strokeText("STOP", 10, 250);
                ctx.fillText("STOP", 10, 250);

                ctx.fillStyle = "white";
                ctx.strokeText("Origin", 540, 60);
                ctx.fillText("Origin", 540, 60);
                ctx.strokeText("Terminator", 10, 345);
                ctx.fillText("Terminator", 10, 345);
                if(lineWalk_step == 4)
                    lineWalk_step = -2;
                lineWalk_step++;
                if(lineWalk_step == -1 && lineWalk_y >= 7)
                    lineWalk_step = 5;
                else if(lineWalk_step == 6 && lineWalk_y >= 7)
                    lineWalk_step = -3;
                else if(lineWalk_step == -2) {
                    lineWalk_y = 1;
                    lineWalk_x = 0.5;
                    lineWalk_x2 = -1;
                }
            }
            window.setInterval(lineWalk_update, 500);
            }
        </script>
        <h3 class="basictext outlinetext" style="text-align:left;">
        &emsp;In summary, we can draw a flat-terminating triangle by looping through it's included y values, and for y value,
        finding the boundaries of x by solving for the x values of the left and right edge lines. We will call our two resulting x-values, "left x" and "right x".
        We can find the slope of a line going through two points by calculating "m = (y2-y1)/(x2-x1)".
        By calculating (x2-x1)/(y2-y1) instead of the original reciprocal, we can find the inverse slope or, in other words, the value we increment x by for every increment in y.<br><br>
        &emsp;Given that, we simply loop through y values, finding the left and right x values along the way, and then loop between the left and right x in order
        to get or set every pixel inside of the flat-terminating triangle.</h3>

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

        <div class="codeexample">
            <h3 class="basictext" style="text-align:left; margin: 5px; color:d8d8d8; font-family:basicbit2; font-weight: normal;">
                <?php basicCode("assets/qb64 3d/code/triangleEdgeRiding.txt", array("LEFT", "RIGHT", "ORIGIN_X", "ORIGIN_Y")) ?>
            </h3>
        </div>

        <h3 class="basictext outlinetext" style="text-align:left;">
        &emsp;Given that we can now draw a triangle with a flat terminator as detailed above,
        we need to then check if <i>any</i> given triangle has a horizontally-flat edge somewhere, drawing it using that method if it does,
        and forming two flat-terminating triangles out of it if it doesn't. We can find this by splitting the given triangle horizontally along the middle-y coordinate. What is meant by this, is
        finding which of the 3 points of the triangle lies in between the other two in terms of y values, and setting that as our y coordinate to split on.
        In BASIC, there is no quick easy way to find this middle point, so we shall insert a series of checks.<br><br>
        &emsp;In order to define the two triangles, we need to find a missing point on the line opposite of our middle point. And we have two things in order to do that,
        we have the line that the point lies on, and the y position of the point. Using our x = (y - b) / m, we can solve for x.
        Thinking of our slope in terms of changes in y related to changes in x, we can find our new x with "x = (y - y1) * m + x1". With (y1, x1) being either end point of our target line,
        and m being the inverse slope; (x2 - x1)/(y2 - y1). This shows us our mystery point to be ((middlePoint.y-y1)*(x2-x1)/(y2-y1) + x1, middlePoint.y). While this is rather hefty in terms of a small computation,
        it is only needed at maximum once for every time a triangle is drawn.
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
        Here is a code example with comments.
        </h3>

        <div class="codeexample">
            <h3 class="basictext" style="text-align:left; margin:5px; color:#d8d8d8; font-family:basicbit2; font-weight: normal;">
                <?php basicCode("assets/qb64 3d/code/flatTriangle.txt", array()) ?>
            </h3>
        </div>
        <div class="codeexample">
            <h3 class="basictext" style="text-align:left; margin:5px; color:#d8d8d8; font-family:basicbit2; font-weight: normal;">
                <?php basicCode("assets/qb64 3d/code/triangleSub.txt", array("flat_triangle")) ?>
            </h3>
        </div>

        

        <div class="section" style="position: absolute; left:900; top:100; width:250">
            <h3 class="basictext outlinetext">The only time a triangle can't be split up this way, is if it already has a horizontally-flat edge; In the program we will test for these cases to avoid errors and unecessary computations.</h3>
            <?php pointer(50, 130, false)?>
        </div>

        <div class="section" style="position: absolute; left:825; top:3500; width:350">
            <h3 class="basictext outlinetext" style="text-align: left; margin: 5px">If y1 < y2 and y1 > y3 Then<br>&emsp;y1 is middle<br>&emsp;y2 is bottom (y-positive is down)<br>&emsp;y3 is top<br><br>Etc.</h3>
            <?php pointer(65, 650, false)?>
        </div>
    </div>

    <h1 class="basictext outlinetext" style="margin: 100px auto 50px auto" id="barycentric">Barycentric Coordinates</h1>
    <div class="" style="position: relative; margin: 0 auto auto auto; width: 800">
        <h3 class="basictext outlinetext" style="text-align:left">
        &emsp;Barycentric coordinates are a system of coordinates that, given a triangle ΔABC and a point P inside that triangle, defines it's values as the areas of subtriangles ΔPBC, ΔAPC, and ΔABP all divided by the total area of ΔABC.
        This is used to blend vertex attributes, attributes given each vertice of a triangle, such as color or depth. Barycentric coordinates are needed for depth, but as in the mention of color, we can use 
        them to make our triangles look a little more interesting. Say that for point A of our triangle, we give it an attribute for color, and set it to red. Point B set to green, and point C to blue. 
        Using barycentric coordinates, we can find the blended color for a point on the triangle. This creates the visual of a gradient where, as a point gets closer to point A, it appears more red. But closer to B or C,
        it appears more green or blue.<br>
        &emsp;The calculation of barycentric coordinates, notated as UV and W.<br>
        &emsp;&emsp;$$\left(U, V, W\right) = \left(\frac{\mathrm{area of} ΔPBC}{\mathrm{area of} ΔABC}, \frac{\mathrm{area of} ΔAPC}{\mathrm{area of} ΔABC}, \frac{\mathrm{area of} ΔABP}{\mathrm{area of} ΔABC}\right).$$<br>
        &emsp;And for our color mixing example,<br>
        &emsp;&emsp;$$COLOR = RED * U + GREEN * V + BLUE * W$$
        </h3>
        <!-- <img src="assets/qb64 3d/barycentric.png" style="width:100%"> -->
        <video width="100%" height="auto" autoplay loop muted>
            <source src="assets/qb64 3d/UVWfromArea.mp4" type="video/mp4" />
        </video>
        <h2 class="basictext outlinetext">Triangle Area via Cross Product</h2>
        <h3 class="basictext outlinetext" style="text-align:left">
            &emsp;In order to solve barycentric coordinates of a point/pixel in a triangle, we need an efficient way to solve the area of a triangle. The method used for this is the cross product.
            The cross product is an operation that takes in two vectors, and it returns a 3rd vector that is perpendicular to the input vectors. A result of the cross product is that the output vector
            has a length (magnitude) equivelant to the area of a parallelogram formed by the two input vectors. Now what "parallelogram formed by the two input vectors" means is that if you picture a copy of
            each vector placed at the tip of the other vector, it forms a parallelogram. And this is what we will get the area of.<br>
        </h3>
        <!-- <img src="assets/qb64 3d/acrossb.png" style="width:100%"> -->
        <h3 class="basictext outlinetext" style="text-align:left">
            &emsp;Working in 2 dimensions, the cross product is extremely easy to compute. Given that the computation returns a vector perpendicular to the two input vectors, and our input vectors only exist 
            on the x-y plane, we can conclude that the cross product will only point in either z-direction, meaning that we only have to calculate the z-component of any 2d cross product. Furthermore, the area
            of a triangle formed by the two input vectors is half the area of the parallelogram. This is easier seen visually, however it is evident that cutting a parallelogram diagonally across two of it's vertices
            splits it in half. The triangles formed are similar as they have the same length sides, meaning that two times the area of one of the triangles gives you the area of the parallelogram.
        </h3>
        <video width="100%" height="auto" autoplay loop muted>
            <source src="assets/qb64 3d/areafromcross.mp4" type="video/mp4" />
        </video>

        <h3 class="basictext outlinetext" style="text-align:left">
            &emsp;Calculating the z component of the cross product between two 2D vectors is as follows:
            $$z = a_x * b_y - a_y * b_x$$
            Or, given 3 points;
            $$\left(x_2-x_1\right) * \left(y_3-y_1\right) - \left(y_2-y_1\right) * \left(x_3-x_1\right) $$
            Thus the triangle area from three points;
            $$\frac{\left(x_2-x_1\right) * \left(y_3-y_1\right) - \left(y_2-y_1\right) * \left(x_3-x_1\right)}{2}$$
            <br>
            &emsp;When taking the barycentric coordinates (u, v, w), we procedurally check new points of the triangle with the point we want to sample inside the triangle.
            In our process, that would be the x and y of the pixel we are setting; \(p_x\) and \(p_y\). In order to preserve vertex order, we must write the calculations in the way specified below.
            Think of it as, for every next barycentric coordinate, we increment every point we're subtracting p from; e.i. \(x_1 -> x_2; x_2 -> x_3; x_3 -> x_1\). The following gives us \(a\) as the
            full area of the triangle triangle, as well as \(u\), \(v\), and \(w\) as the barycentric coordinates, in the range (0-1).
            $$a = \frac{\left(x_3-x_1\right) * \left(y_2-y_1\right) - \left(y_3-y_1\right) * \left(x_2-x_1\right)}{2}$$
            $$u = \frac{\left(x_3-p_x\right) * \left(y_2-p_y\right) - \left(y_3-p_y\right) * \left(x_2-p_x\right)}{2a}$$
            $$v = \frac{\left(x_1-p_x\right) * \left(y_3-p_y\right) - \left(y_1-p_y\right) * \left(x_3-p_x\right)}{2a}$$
            $$w = \frac{\left(x_2-p_x\right) * \left(y_1-p_y\right) - \left(y_2-p_y\right) * \left(x_1-p_x\right)}{2a}$$
            
        </h3>

        <h3 class="basictext outlinetext" style="text-align:left">
            &emsp;The resulting \(u\), \(v\), and \(w\) can be thought of as percentages declaring how close a point is two the 3 vertices of a triangle. For instance,
            if \(u = 1\), then the point lies at vertex \(a\), with the subtriangle for u being equal to the full triangle. But if \(u = 0\), the point
            lies on the edge opposite to vertex \(a\), and should inherit none of \(a\)'s attributes.<br>
            &emsp;Essentially, the attributes of any given point or pixel inside of a triangle is equal to the sum the attributes of each vertice, multiplied by their associated barycentric component. I.e;
            $$pixel_{attribute} = a_{attribute} * u + b_{attribute} * v + c_{attribute} * w$$
            &emsp;Here is a visual example, where vertex \(a\) has a color attribute of red, \(b\) with green, and \(c\) with blue.
        </h3>
        <video width="100%" height="auto" autoplay loop muted>
            <source src="assets/qb64 3d/usinguvw.mp4" type="video/mp4" />
        </video>

        <h3 class="basictext outlinetext" style="text-align: left">
            &emsp;This allows us to step into the more modern territory of shading and triangle rasterization. For instance, if we give each vertice of a triangle coordinates that represent a point in an image,
            it allows us to blend these coordinates across the triangle, and use them to grab data from an image. This is known as texture mapping. Here is an example of a rainbow pattern being mapped onto a triangle.
        </h3>
        <!-- <img src="assets/qb64 3d/rainbowtextureexample.png" style="width:50%; height: auto; display:block; margin: auto" /> -->
        <video autoplay loop muted style="display: block; margin: auto">
            <source src="assets/qb64 3d/uvtotexture.mp4" type="video/mp4" />
        </video>

        <h3 class="basictext outlinetext" style="text-align: left">
            &emsp;If you do not have an understanding of how this would be put together, here is a code example of a function that takes in 3 points of a triangle, and a 4th point to get the Barycentric coordinates of.
        </h3>
        <div class="codeexample">
            <h3 class="basictext" style="text-align:left; margin:5px; color:#d8d8d8; font-family:basicbit2; font-weight: normal;">
                <?php basicCode("assets/qb64 3d/code/uvw.txt", array()) ?>
            </h3>
        </div>

        <div class="section" style="position: absolute; left:-300; top:985; width:250">
            <h3 class="basictext outlinetext">For more visual explanations, check out Grant Sanderson/3blue1brown's <a href="https://www.youtube.com/watch?v=eu6i7WJeinw">video on cross products.</a> For more on what vectors actually are and what they're used for, go down to <a href="#linear">Linear Algebra for the Faint of Heart</a></h3>
            <?php pointer(110, 20, true)?>
        </div>
        <!-- <div class="section" style="position: absolute; left:900; top:2150; width:250">
            <h3 class="basictext outlinetext">You may simplify \(\frac{...}{2a}\) with \(\frac{...}{a}\) by not dividing \(a\) by 2, however you will need to keep in mind that \(a\) is now twice the area of the triangle.</h3>
            <?php //pointer(40, 260, false)?>
            <?php //pointer(110, 260, false)?>
        </div> -->
    </div>
    
    <h1 class="basictext outlinetext" style="margin: 100px auto 50px auto" id="linear">Linear Algebra for the Faint of Heart</h1>
    <div class="" style="position: relative; margin: 0 auto auto auto; width: 800">
        <h3 class="basictext outlinetext">For a more in-depth and general purpose approach, I recommend Grand Sanderson/3blue1brown's series:
            <a href="https://youtu.be/fNk_zzaMoSs?list=PLZHQObOWTQDPD3MizzM2xVFitgF8hE_ab">Essence of Linear Algebra</a>
            It goes through everything visually and can teach anyone a general understanding of what Linear Algebra is.
        </h3>
        <h3 class="basictext outlinetext" style="text-align: left">
            &emsp;Our usage of Linear Algebra revolves around using Matrices to transform Vectors. But firstly, we shall define those terms.
            A Matrix, (plural Matrices) is a 2 dimensional series of numbers, with \(n\) number of columns and \(m\) number of rows. Matrices are typically used to describe a "transformation". 
            For instance, a matrix might stretch/scale all x values out by a factor of 2. And it would look like this;
            $$\begin{bmatrix}2 & 0\\ 0 & 1\end{bmatrix}$$
            <span style="text-align:center">With the computation looking like this.</span>
            $$x' = 2*x + 0*y$$
            $$y' = 0*x + 1*y$$
            &emsp;This means that for any given x and y, the resulting x (\(x'\)) is two times the input x, and the resulting y \(y'\)) staying the same as the input y.
        </h3>
        <video width="100%" height="auto" autoplay loop muted>
            <source src="assets/qb64 3d/matrixExample.mp4"/>
        </video>
        <h3 class="basictext outlinetext" style="text-align: left">
            &emsp;A vector, in the way we visualize it, is an arrow with the tail end sitting on the origin (the coordinates 0, 0), and the tip sitting at
            a given coordinate. A vector is typically only defined by its tip's coordinates, as the tail will never be anywhere besides the origin. However, a vector can also be thought of as just a point existing
            at its defining coordinates. It's just that with that definition, it is harder to visualize transformations happening to it. But still keep note that vectors in 3d graphics are often used to just store
            coordinates, but the same transformations can be applied to them.<br>
            &emsp;These transformations happen through matrix multiplication. You can plug any vector or coordinate in and get a resulting coordinate
            that follows the rules defined by the matrix. This is extremely useful in 3d graphics as it allows for all sorts of transformations and even traslations. We could then create a matrix
            that rotates all vectors, or one that projects all input 3d vectors into 2 dimension. This idea of projection is extremely important, and will be discussed again shortly.
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
            &emsp;Projection in 3d graphics is the idea of transforming a vector from the 3d coordinate space into the 2d coordinate space, in a way that retains visual information that shows depth,
            such as foreshortening. You may recall that your screen is a series of pixels given at a certain resolution. This can give you the coordinates for each pixel. Generally 2D integers coordinates,
            such as (100, 240) or (145, 23). The 3d vectors used as an input for a 3D projector can use any kind of units. These could be integers or decimals at any given scale.<br>

            &emsp;Our projector will transform these coordinates into "screenspace coordinates", coordinates ranging from (-1, -1, -1) to (1, 1, 1), in a way that preserves the window's display ratio
            (i.e. 16:9, 4:3, 2:1, etc.) After doing so, it can bring the coordinates from 3d into 2d in a way that shows foreshortening. From there it must convert this range of numbers to actual 
            pixel coordinates in order to show the image we desire.<br>
            &emsp;The first transforming Matrix we will use, is;
            $$\begin{bmatrix}\color{red}F_x & 0 & 0 & 0\\0 & \color{red}F_y & 0 & 0\\0 & 0 & \color{yellow}Z_m & \color{yellow}Z_a \\ 0 & 0 & \color{blue}-1 & 0 \\\end{bmatrix}$$
            &emsp;For foreshortening, we will use:
            $$\begin{bmatrix}\color{red}1/z&0\\0&\color{red}1/z\end{bmatrix}$$
            &emsp;Or, simply:
            $$x' = x / z$$
            $$y' = y / z$$
            &emsp;And finally, transforming the coordinates into pixel coordinates; (The input z is required to be 1; \(S_w\) and \(S_h\) are the width and height of whatever is being displayed to.)
            $$\begin{bmatrix}\color{red}\frac{1}{2}S_w & 0 & \color{yellow}\frac{1}{2}S_w \\ 0 & \color{red}\frac{1}{2}S_h & \color{yellow}\frac{1}{2}S_h \\ 0 & 0 & 1 \end{bmatrix}$$
            &emsp;Or even more simply;
            $$x' = \frac{S_w}{2}\left(x + 1\right)$$
            $$y' = \frac{S_h}{2}\left(y + 1\right)$$
            &emsp;If we expand each of these transformations, we may simplify things down into an easy-to-digest calculation.
        </h3>
        <h3 class="basictext outlinetext" style="text-align:left">
            &emsp;Our first matrix takes in a 4 dimensional vector. We haven't suddenly switched from 3d rendering to 4d rendering, instead we are passing (x, y, z, 1) into the matrix. The 4th component, w
            (not to be confused with barycentric's w), is typically 1 for many 3d transformation matrices. This allows for translation as You'll see with further expansion.<br>
            &emsp;Our first matrix sets the output x to \(x * F_x\), and output y to \(y * F_y\). \(F_x\) and \(F_y\) scale the x and y values based on two factors.<br>
            &emsp;&emsp;Firstly, the width-height ratio of the display.<br>
            &emsp;&emsp;And second, the prefered field of view, or FOV.<br><br>
            &emsp;Since we are transforming a physical space into a screen space and then stretching it onto the screen, we need to be prepared for any squishing or stretching that happens
            as our (-1,-1)-(1, 1) space transforms into a (0, 0)-(1920, 1080) or whatnot. If say, our display has a width-height ratio of 16:9, just like in one that's 1920 - 1080, the x values are being stretched out 16/9 times more
            than the y is being stretched by. In order to combat this, we can either stretch the y by width/height, or stretch the x by height/width. E.i; \(F_x = \frac{h}{w}\) or \(F_y = \frac{w}{h}\) (But not both).<br><br>
            &emsp;But there is more to add for \(F_x\) and \(F_y\). The FOV is a scalar that scales everything equally, and this scale is chosen rather than found. But that doesn't mean it can be any number,
            it technically could but in order to create the effect of a "Field of View" you can calculate the FOV scalar from and angle through \(FOV = \cot(\frac{1}{2}\theta)\). Now we could combine this with the w/h ratio by directly multiplying,
            but instead we will multiply the \(\theta\) angle instead.
            Thus we can put this together to create our final \(F_x\) and \(F_y\) values.
            $$F_x = \cot(\frac{1}{2}\theta_{FOV})$$
            $$F_y = \cot(\frac{1}{2}\theta_{FOV} \times \frac{W}{H})$$
            &emsp;Now we've transformed our x and y values, what more can we do? Well, \(Z_m\) and \(Z_a\) in the matrix are for setting a maximum and minimum z-value, otherwise known as the Far and Near Clipping Planes.
            When transforming our z-coordinates, e.i. distance to the viewpoint, we want to map Z from a range of (near-clip, far-clip) to a range of (0, far-clip). Doing this just takes multiplication to stretch or squish
            z-values to the right range of values. And an addition(/subtraction) to set the proper minimum value 0.
            $$ Z_m = \mp\frac{F}{F-N} $$ 
            $$ Z_a = -\frac{F \times N}{F-N} $$
            &emsp;Whether or not \(Z_m\) is positive or negative depends on which z-direction is forward. It's typically negative, as, following the right
            hand coordinate system, Z-negative is "forward". \(Z_a\) is ultimately added to the input z (after multiplying it by \(Z_m\)) as, writing out the multiplication of our matrix, we get,
            \(z' = x \times 0 + y \times 0 + z \times Z_m + w \times Z_a\) where we've already established that w = 1.
            And such, we have a final Matrix of
            $$\begin{bmatrix}cot(\frac{\theta}{2}) & 0 & 0 & 0 \\ 0 & cot(\frac{\theta}{2} \times \frac{W}{H}) & 0 & 0 \\ 0 & 0 & -\frac{F}{F-N} & -\frac{F \times N}{F-N} \\ 0 & 0 & -1 & 0 \end{bmatrix}$$
            Where \(\theta\) is the angle of FOV, \(W\) and \(H\) are the dimensions of the display, and \(F\) and \(N\) being the Near and Far clipping planes respectively.<br><br>
            &emsp;You'll notice that there's also a -1 in the \(w' = x \times 0 + y \times 0 + z * -1 + w \times 0\) spot. This is used to store distance, as z can be thought of the distance between a point and the viewpoint.
            But the 'forward' direction, is z-negative, hence why we're multiplying z by -1 instead of just 1. In the end, w is the distance of a point to the viewpoint. If it's negative, it's behind the viewing area (z-positive direction), and thus shouldn't be drawn.<br><br>
            &emsp;We have now created a selection of geometry to draw. Multiplying a vector with this matrix, it tells us whether a point will (or should) be drawn. That being, outputs with x and y values between -1 and 1, z-values between 0 and the far-clipping plane, and positive w values.<br><br>
            &emsp;That is all the harder to grasp concepts out of the way. It also prepares us for foreshortening, as, in order to create this effect of foreshortening, we simply divide our x and y values by z.
            This means that if a point has a small z value below 1, dividing by z will stretch it out, making an object seem to get bigger when really close. But as z increases, dividing by z will make x and y much smaller, making objects appear smaller as they are further.
            With this in mind, we can write out our final computations. Check back earlier to matrix multiplication if you need to remember how to do this step.<br>
            $$ z' = z \times Z_m + Z_a $$ Done first as we need to divide x and y by it.
            $$ x' = \frac{x}{z'} \times cot(\frac{\theta}{2}) $$
            $$ y' = \frac{y}{z'} \times cot(\frac{\theta}{2} \times \frac{W}{H}) $$ 
            $$ w' = z * -1$$ Notice that this is z, not z'.<br>
            These gives us 2D foreshortened x and y values \(x'\) and \(y'\). We can translate these to pixel coordinates simply, but through this method any
            x or y outside of the (-1, 1) range will be off the screen, therefore we should check for these cases to make sure we do not attempt to wrongfully draw these cases.
            $$ x'' = (x' \times 0.5 + 0.5) \times W $$
            $$ y'' = (y' \times 0.5 + 0.5) \times H $$
            And thus (x'', y'') are our final pixel coordinates, with w' being the point's distance from the viewpoint.<br><br>
            Putting these concepts together, we can write code for a Function (Sub) that takes in the 3D coordinates of a point, and fills in the pixel of said point.
        </h3>

        <div class="codeexample">
            <h3 class="basictext" style="text-align:left; margin:5px; color:#d8d8d8; font-family:basicbit2; font-weight: normal;">
                <?php basicCode("assets/qb64 3d/code/projectXYZ.txt", array()) ?>
            </h3>
        </div>

        <div class="section" style="position: absolute; left:110%; top:1815; width:250">
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
            &emsp;If you were to take all the processes that have been given so far you could try to draw a cube. First by taking all the points of a cube and project them into 2d.
            Then, using the 2d points to rasterize 2d triangles, you could form an image of a cube. However, something would be off. You might be able to get it right the first time, you'll probably notice that
            some triangles are drawing themselves in front of triangles that they are supposed to be behind, breaking the effect and making the cube less recognizable.<br>
            &emsp;In order to prevent triangles from being placed in front of trangles they're supposed to behind, we do something called depth testing. Depth Testing, as we will use it, will be
            the storage of two arrays, with an element for every pixel. The first array will store the distance of a pixel from the viewpoint. The second, will store a number representing the last frame a pixel was updated.<br>
            &emsp;I.e, our code for this should execute something along these lines; (W and H are display dimensions)
        </h3>
        <div class="codeexample">
            <h3 class="basictext" style="text-align:left; margin:5px; color:#d8d8d8; font-family: basicbit2; font-weight:normal">
                <?php basicCode("assets/qb64 3d/code/depthFramework.txt", array()) ?>
            </h3>
        </div>
        <h3 class="basictext outlinetext" style="text-align:left">
            &emsp;In order to execute the above, we need to find two values. The "index" of a pixel, and the depth of a pixel.<br>
            &emsp;The index of a pixel is rather simple. We have arrays with room for every pixel. Width times height, area of a rectangle. Think about labeling every pixel from left to right
            and top to bottom. When you start, you are labeling every pixel 0, 1, 2, 3, etc. and if you think about it, you are essentially labeling every pixel with its x position. When you have hit the end of the first line,
            you wrap back around. The first element of the second line will have its index be the same as the Width of the display. That is because we started with index 0, so when we hit the pixel at the end of the first row, its index is Width - 1.
            If we go another row, our pixel at (0, 2) will be 2 * Width. After another row it's 3 * width, and etc. With each pixel, we have a unique index equal to (x + y * Width). And this is how we find the index of a pixel.
            <br>
            &emsp;So pixel index = pixel x + pixel y * display width. What about pixel depth?<br><br>
            &emsp;Well here's a hint, through our projection, we have the depth of the vertices of the triangle we want to draw, and we need to interpolate to find the depth per pixel. Think barycentric coordinates.<br>
            &emsp;Unfortunately, unlike colors and other linear vertex attributes, we can't just do
            $$depth = depth_a * u + depth_b * v + depth_c * w$$
            We instead need to do
            $$\frac{1}{depth} = u\frac{1}{depth_a} + v\frac{1}{depth_b} + w\frac{1}{depth_c}$$
            &emsp;You'll find that by attempting to use the first equation over the latter to calculate depth will result in strange curves when geometry
            intersects eachother. The reasoning for this lies in how depth actually effects coordinates. Each x and y value are divided by their depth,
            this ends in every x and y value not being transformed equally. 
        </h3>
        <img src="assets/qb64 3d/triangledepth.png" style="width:100%"/>
        <h3 class="basictext outlinetext" style="text-align:left">
            &emsp;Imagine an ant walking along a triangle, and viewing the projection of that triangle. From the projection's perspective (pun intended)
            the ant travels slower and slower as it gets further away, even if it's physically moving the same speed. This shows us how depth is not linear, and thus why we need to find depth differently
            than we would with normal vertex attributes.<br>
            &emsp;Shouldn't this depth distortion affect other attributes? Well it does, and you can see the effects and solutions in the <a href="#correctionbarycentric">next section</a>
            <br><br>
            &emsp;We have the ability to take the depth of every pixel, it's time we should compare them. You may find the merging of pixel indexing and depth interpolation in this following code example.
        </h3>
        <video width="100%" height="auto" autoplay loop muted>
            <source src="assets/qb64 3d/depth example.mp4"/>
        </video>
        <div class="codeexample">
            <h3 class="basictext" style="text-align:left; margin: 5px; font-family: basicbit2; color:#d8d8d8; font-weight: normal;">
                <?php basicCode("assets/qb64 3d/code/depthDetail.txt", array()) ?>
            </h3>
        </div>
    </div>
    <h1 class="basictext outlinetext" id="correctionbarycentric" style="margin:100px">Correcting Barycentric Coordinates with Depth</h1>
    <div class="" style="position: relative; margin: 0 auto auto auto; width: 800">
        <h3 class="basictext outlinetext" style="text-align:left">
            &emsp;We are not quite at the finish line, if we use all of these methods, we can draw 3d shapes with no problem. But if we attempt to draw anything on the faces using barycentric coordinates,
            we will find that the triangles appear normal, but everything will look just off every so slightly. This graphic by scratchapixel will show what it would appear like.
        </h3>
        <img src="assets/qb64 3d/perspectivecorrection.png" style="width:100%">
        <h3 class="basictext outlinetext" style="text-align: left">
            &emsp;You'll see in the image that the triangle on the left appears 2 Dimensional and flat, whereas it's easier to gather the depth from the
            second triangle. This is how things will appear after depth correction of the vertex attributes.<br>
            &emsp;This problem is more apparent when using textures because images will hold straight lines, whereas simple gradients might hide misteps.
        </h3> 
        <img src="assets/qb64 3d/naivevscorrect.png" style="width:100%">
        <h3 class="basictext outlinetext" style="text-align:left">
            &emsp;The reasoning for this distortion is the same as the reason for grabbing depth needing more than simple barycentric interpolation. Fortunately, after grabbing the new depth, 
            we can compute the new attributes of each pixel rather easily. How we achieve this is by just dividing each vertex attribute by its vertex's depth, then we use barycentric coordinates
            to interpolate the resulting values. Then, multiplying them by the current pixel's depth, we have our final attribute.<br>
            &emsp;Equations that show what's going on here would look like this. Where d is the depth of each vertice and of the current pixel, and a is an attribute of a vertex like color or whatnot, and our barycentric coordinates, u, v, and w.
            $$d_{pixel} = \frac{1}{\frac{u}{d_1} + \frac{v}{d_2} + \frac{w}{d_3}}$$ 
            $$a_{pixel} = \left(u\frac{a_1}{d_1} + v\frac{a_2}{d_2} + w\frac{a_3}{d_3}\right)d_{pixel}$$
            &emsp;This helps as the attribute not only relies on barycentric coordinates, but also depth. A pixel will not just appear like a vertice as it's barycentric coords approach it, but its depth needs to approach it as well.<br>
            &emsp;The following hypothetical code will 
        </h3>
        <div class="codeexample">
            <h3 class="basictext" style="text-align:left; margin: 5px; font-family: basicbit2; color:#d8d8d8; font-weight: normal;">
                <?php basicCode("assets/qb64 3d/code/depthMore.txt", array()) ?>
            </h3>
        </div>
    </div>
    <h1 class="basictext outlinetext" id="alltogether">Putting the Code All Together</h1>
    <h3 class="basictext">The following code will work in QB64</h3>
    <div class="" style="position: relative; margin: 0 auto auto auto; width: 800">
        <div class="codeexample">
            <h3 class="basictext" style="text-align:left; margin: 5px; font-family: basicbit2; color:#d8d8d8; font-weight: normal;">
            <?php basicCode("assets/qb64 3d/code/full.txt", array())?>
            </h3>
            
            <h3 class="basictext outlinetext"><a href="assets/qb64 3d/code/full.txt" download>Download Code</a></h3>
    </div>
    </div>
    <div class="" style="position: relative; margin: 10px auto auto auto; width: 800">
        <img src="assets/qb64 3d/full example output.png" style="width:100%; margin:auto">
    </div>
    <h1 class="basictext outlinetext" id="optimization">Rotation and Optimization</h1>

    <div class="" style="position: relative; margin: 0 auto auto auto; width: 800">
        <h3 class="basictext outlinetext" style="text-align:left">
            &emsp;While the given code above will run, it isn't that exciting. There are many adjustments we can make to give more to look at, as well as adjustments we can make to 
            speed up rendering quite substantially.<br><br>
            &emsp;Firstly, one of the biggest changes you can make to improve the look of a 3d program is to introduce rotation. Without it you would be stuck moving a still shape across the screen. Rotation is mathematically tedius,
            but it's much easier to understand with Matrix Transformation. If you take a vector as a point in 3d space, you can rotate it around the origin (0, 0, 0) with the following (column vector) matrices.
            $$R_x(\theta) = \begin{bmatrix}1 & 0 & 0\\0 & cos\theta & sin\theta\\0 & -sin\theta & cos\theta\end{bmatrix}$$
            $$R_y(\theta) = \begin{bmatrix}cos\theta & 0 & -sin\theta\\0 & 1 & 0\\sin\theta & 0 & cos\theta\end{bmatrix}$$
            $$R_z(\theta) = \begin{bmatrix}cos\theta & sin\theta & 0\\-sin\theta & cos\theta & 0\\0 & 0 & 1\end{bmatrix}$$
            What each of these mean is that, say for \(R_x(\theta)\), given angle \(\theta\), the transformation will rotate a vector around the X axis by this angle. Thus there are 3 axes of rotation, each around
            their respective 3D axis.<br>
            <video width="30%" height="auto" autoplay loop muted>
                <source src="assets/qb64 3d/xrotation.mp4" type="video/mp4" />
            </video>
            <video width="30%" height="auto" autoplay loop muted>
                <source src="assets/qb64 3d/yrotation.mp4" type="video/mp4" />
            </video>
            <video width="30%" height="auto" autoplay loop muted>
                <source src="assets/qb64 3d/zrotation.mp4" type="video/mp4" />
            </video><br>
            (In order left-to-right: X-rotation; Y-rotation; Z-rotation)<br><br>
            <!-- There are 6 ways to "combine" 3 matrices, however this seems to be the most accepted way to combine the three rotational matrices. 
            Combining matrices is just multiplying them together, however matrix * matrix multiplication is a thick branch on the same tree as vector * matrix multiplication.
            But if you would like to learn more detail about it, you can check out the 3Blue1Brown video on it <a href="https://youtu.be/XkY2DOUCWMU">here</a>, 
            or if you'd like to read instead, you can check out <a href="https://en.wikipedia.org/wiki/Matrix_multiplication">the wikipedia page</a>
            or this <a href="https://www.mathsisfun.com/algebra/matrix-multiplying.html">Math is Fun page</a><-->
            &emsp;Combining these matrices, you end up with one matrix you can use to rotate any vector in all 3 axes at the same time;
            $$R_{xyz}(\alpha, \beta, \gamma) = \begin{bmatrix}\cos\alpha \cos\beta & \sin\alpha \cos\beta &  -\sin\beta \\ \cos\alpha \sin\beta \sin\gamma - \sin\alpha \cos\gamma & \sin\alpha \sin\beta \sin\gamma + \cos\alpha \cos\gamma & \cos\beta \sin\gamma \\ \cos\alpha \sin\beta \cos\gamma + \sin\alpha \sin\gamma & \sin\alpha \sin\beta \cos\gamma - \cos\alpha \sin\gamma & \cos\beta \cos\gamma \end{bmatrix}$$
            &emsp;Where \(\alpha\) is the angle around the Z axis, \(\beta\) around the Y axis, and \(\gamma\) around the X axis. Implementing this into BASIC is rather easy, but it is also rather tedious as there
            is no easy way to simplify the computations. However, we can make our code a little neater and clean using a <a href="https://www.qbasic.net/en/reference/qb11/Statement/TYPE.htm">User Defined Type (UDT)</a>. Like a struct or class for QBASIC.
            We will create a UDT called "vector". It will store 4 numbers, for an x, y, z and w coordinate.<br>
            And as we cannot return more than one number per function, (i.e, we cannot return a UDT in QB64, we can only return a built-in type, like a number or string), we will set a universal vector the be the set "output"
            of some functions. Given all that, let me show you what our rotation function will look like, with a vector UDT defined.
        </h3>
        <div class="codeexample">
            <h3 class="basictext" style="text-align:left; margin: 5px; font-family: basicbit2; color:#d8d8d8; font-weight: normal;">
                <?php basicCode("assets/qb64 3d/code/rotation.bas", array("vector")) ?>
            </h3>
        </div>
        <h3 class="basictext outlinetext" style="text-align:left">
            &emsp;In order to substantially speed up the program, we can think about all the computations happening in our program, and thinking about their necessity and how it
            might be possible to cut things down. If we look at an outline of the program so far, we can see some critical points where computation is heavy.<br><br>
            For every triangle:<br>
            Call projection for every coordinate of all 3 points<br>
            Find flat triangles<br><br>
            For each flat triangle:<br>
            Calculate the slopes of the sides of the flat triangle<br>
            For every y value in the triangle's y value range:<br>
            Increment ends of x range by their slopes<br><br>
            For every pixel in the triangle:<br>
            Calculate u, v, and w barycentric coordinates<br>
            Calculate depth (and index) of current pixel<br>
            Compare to depth and time array<br>
            Draw pixel<br><br>
            &emsp;Through this we can see that the heaviest load is during the pixel drawing process. As those calculations are repeated the most often: For every pixel in every triangle.
            But it seems as though we can't clean it up any further without sacrificing depth testing and barycentric coordinates. However, we can still simplify it using derivatives.<br>
            &emsp;Take our barycentric coordinate calculations. They seem pretty complicated, however note that the only thing changing in them is the x and the y position of the pixel. And each time the values change, they change by exactly 1.
            If we use the derivative of these equations in respect to x and y, and depending on what we're incrementing at that current moment, add them to running barycentric coordinate variables.<br>
            Given our UVW calculations:<br>
            $$u = \frac{\left(x_3-p_x\right) * \left(y_2-p_y\right) - \left(y_3-p_y\right) * \left(x_2-p_x\right)}{2a}$$
            $$v = \frac{\left(x_1-p_x\right) * \left(y_3-p_y\right) - \left(y_1-p_y\right) * \left(x_3-p_x\right)}{2a}$$
            $$w = \frac{\left(x_2-p_x\right) * \left(y_1-p_y\right) - \left(y_2-p_y\right) * \left(x_1-p_x\right)}{2a}$$<br>
            We find that the derivatives of such in respect to x and y are as follows:<br>
            $$\frac{du}{dx} = \frac{y_3-y_2}{2a}$$
            $$\frac{dv}{dx} = \frac{y_1-y_3}{2a}$$
            $$\frac{dw}{dx} = \frac{y_2-y_1}{2a}$$
            $$\frac{du}{dy} = \frac{x_2-x_3}{2a}$$
            $$\frac{dv}{dy} = \frac{x_3-x_1}{2a}$$
            $$\frac{dw}{dy} = \frac{x_1-x_2}{2a}$$
            Given that these computations only rely on the positions of the three vertices of the triangle, they can be calculated once per triangle.
            Whenever we increment x, we must increment u by 'du/dx' times what our change in x is, typically 1, and the same goes for increments in y with 'du/dy'.<br>
            &emsp;It is possible to take and use the derivative of the depth calculation, however it would be more trouble than it's worth.<br><br>
            &emsp;Given rotation and our optimization, below you'll find yet another fully working version of this project. Using arrow keys to control rotation.
        </h3>
        <div class="codeexample">
            <h3 class="basictext" style="text-align:left; margin: 5px; font-family: basicbit2; color:#d8d8d8; font-weight: normal;">
                <?php basicCode("assets/qb64 3d/code/optimized.bas", array("vector")) ?>
            </h3>
            <h3 class="basictext outlinetext"><a href="assets/qb64 3d/code/optimized.bat" download>Download Code</a></h3>
        </div>
    </div>

    <h1 class="basictext outlinetext" id="extra">Going Forward with Graphics</h1>
    <div class="" style="position: relative; margin: 0 auto auto auto; width: 800">
    <h3 class="basictext outlinetext" style="text-align:left">
        &emsp;It's great having a real-time example of 3d graphics built in BASIC, but what if we wanted to do more? If we had no regard for speed, what could we accomplish with what we've made?<br>
        &emsp;You might recall earlier in this paper when I provided images of cubes displaying textures. How exactly do we make this possible, and what more does that allow us to do?
        More often than not, barycentric coordinates are used to interpolate between texture coordinates. Unhelpfully denoted with U and V. (Sometimes even W.) This coordinate
        system is used to represent points on an image, typically spanning from 0 to 1.<br>
        &emsp;If we give our barycentric coordinates texture coordinates to interpolate, we can take the resulting texture coordinate and use it to grab a color from an image.
        We can then draw this color directly to the screen, or we can do more processing with it.<br>
        &emsp;A lot of modern graphics rely on clever usage of textures in order to create different lighting conditions and produce a pixel based on a combination of
        factors. And this is most commonly done through shaders.<br><br>
        &emsp;A shader is a routine that is used to transform a set of input values to output values for the sake of 3d rendering. There are different types of shaders:
        vertex shaders which take in vertex attributes and tells the computer where it should lie on the screen or raster, geometry shaders which take in as much as whole
        3d shapes and is able to transform existing and create new geometry, and finally fragment shaders, which take in anything given to them and output a color that
        is pushed to the raster. We have already done the work of the vertex shader, don't really need geometry shaders in our example, and pushing the barycentric 
        coordinates to the screen is enough to constitute as a fragment shader, but lets push it further.<br>
        &emsp;Fragment shaders can do as little as giving the same color to every pixel it's assigned to, or as complicated as simulating virtual light to immitate
        realistic lighting as best it can. All the abilities are covered quite in depth elsewhere, so I won't be digging deeper into lighting. However, take note
        that QB64 allows you to load textures and access their colors, and these colors can be used to manipulate normal vectors and control how strong lighting effects are.
        So take this last piece of BASIC code with you, and go learn more about the concepts of 3D rendering.
    </h3>
    <div class="codeexample">
        <h3 class="basictext" style="text-align:left; margin: 5px; font-family: basicbit2; color:#d8d8d8; font-weight: normal;">
            <?php basicCode("assets/qb64 3d/code/full3dEngine.bas", array()) ?>
        </h3>
        
        <h3 class="basictext outlinetext"><a href="assets/qb64 3d/code/full3dEngine.bas" download>Download Code</a></h3>
    </div>
    <h3 class="basictext outlinetext" style="text-align: left">The output of the above code, sped up for your viewing pleasure.</h3>
    <video width="100%" height="auto" autoplay loop muted>
        <source src="assets/qb64 3d/qb64 3d.mp4" type="video/mp4" />
    </video>
    </div>

    <h1 class="basictext outlinetext" id="resources">Reources</h1>
    <h2 class="basictext outlinetext">
        For more on the math behind matrices:<br>
        <a href="https://www.youtube.com/channel/UCYO_jab_esuFRV4b17AJtAw">3blue1brown</a><br>
        <a href="https://www.youtube.com/playlist?list=PLZHQObOWTQDPD3MizzM2xVFitgF8hE_ab">A very visual approach to linear algebra</a><br>
        
        <br>
        For more on the math behind 3D Computer graphics:<br>
        <a href="https://www.scratchapixel.com">Scratchapixel</a><br>
        <a href="https://www.scratchapixel.com/lessons/3d-basic-rendering/perspective-and-orthographic-projection-matrix/building-basic-perspective-projection-matrix
">An explanation of perspective matrices</a><br>
        <a href="https://www.scratchapixel.com/lessons/3d-basic-rendering/rasterization-practical-implementation/visibility-problem-depth-buffer-depth-interpolation
">An explanation of correct depth interpolation</a><br>
        <a href="https://www.scratchapixel.com/lessons/3d-basic-rendering/rasterization-practical-implementation/perspective-correct-interpolation-vertex-attributes
">An explanation of Barycentric coordinate correction based on depth</a><br><br>
        
        For more on shading, from simple to complex 3D lighting:<br>
        <a href="https://learnopengl.com">LearnOpenGL</a><br>
        While centered on OpenGL, LearnOpenGL provides a lot more details behind plenty of shading techniques<br>
        <a href="https://learnopengl.com/Lighting/Basic-Lighting">Basic lighting</a><br>
        <a href="https://learnopengl.com/Lighting/Lighting-maps">Lighting maps</a><br>
        <a href="https://learnopengl.com/Advanced-Lighting/Normal-Mapping">Normal Mapping</a><br><br>
        
    </h2>
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

        LearnOpengl:
        A Great resource for learning about shading and 3d graphics. While mainly useful for OpenGL of course, you can adapt a lot of the concepts to make good looking
        BASIC 3d rendering
        https://learnopengl.com/
    -->
    <!-- Required to end Universal and "cut" divs -->
<?php include "global/end.php"?>
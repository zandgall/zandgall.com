<html lang="en">
    <style>
        hr{
            border:none; border-top: 2px dashed white; position: absolute;
        }
        .round {
            width:6px; height:6px; border: 2px solid white; border-radius:6px; background-color:rgba(100, 200, 255, 0.2); position: absolute;
        }

    </style>
<?php 
$pagetitle = "Zandgall - QB64 3D Rasterizer";
$pagedesc = "Overview of a program that can rasterize 3d graphics, written in QB64, a close recreation of BASIC";
include "global/head_.php"?>

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
        <a class="link basictext" href="#linear">Linear Algebra for the faint of heart</a><br>
        <a class="link basictext" href="#depth">Depth is easier than it seems</a><br>
        <a class="link basictext" href="#extra">Extra little details</a><br>
        <a class="link basictext" href="#gallery">Gallery</a><br>
        <a class="link basictext" href="#resources">Further Resources</a><br>
    </h3>

    <h1 class="basictext outlinetext" style="margin: 100px auto 50px auto" id="qb64">What is QB64?</h1>
    <div class="" style="position: relative; margin: 0 auto auto auto; width: 800;">
        <h2 class="basictext outlinetext">In order to understand QB64, you must first learn what BASIC is</h2>

        <h3 class="basictext outlinetext" style="text-align:left">&emsp;BASIC is a programming language developed in the late 60s and early 70s, becoming a mainstay as one of, if not the most influential programming languages of all time. It was created to be a simple programming language that could be extremely easy to learn, but still really powerful as we'll soon see. During it's reign, an IDE called "Quick BASIC", or QBasic for short was created for DOS, accelling BASIC's popularity and accessibility. Decades later, QBasic became the influence for QB64, a BASIC IDE for the 2000s. This became my IDE of choice, due to the modern OS compiling it brings, and it's simple project setup.</h3>
        <h3 class="basictext outlinetext" style="text-align:left">&emsp;Although being built and given support for 64 bit systems, QB64 gives you similar capabilities that BASIC would have given you back in the day, another reason why I chose it. But one problem with this choice however, is that one of the benefits it <i>does</i> bring, is in the realm of graphics. However, the extent at which it was used was very minimal and did not harm my learning experience in this field.</h3>
        <h3 class="basictext outlinetext" style="text-align:left">&emsp;More information about QB64 and it's capabilities can be found at the <a href="https://www.qb64.org" style="text-decoration: none">QB64 homepage</a></h3>
        <img src="assets/qb64 3d/uiexample.png" style="display: block; width: 800; height: auto; margin: auto">
    </div>
    <h1 class="basictext outlinetext" style="margin: 100px auto 50px auto" id="raster">What is 3D Rasterizating?</h1>
    <div class="" style="position: relative; margin: 0 auto auto auto; width: 800;">
        <h2 class="basictext outlinetext">3D Rasterization is a technique for drawing 3D scenes to a raster</h2>
        <h3 class="basictext outlinetext" style="text-align:left">&emsp;Rasterization in general is the practice of mapping vector graphics to a raster. A raster, like a screen, tends to be a list of colors, or 'pixels'. In 3D rasterization, these vector graphics are 3D objects projected onto a 2D plane, usually triangles onto a cross section of a virtual camera's viewport.</h3>
        <h3 class="basictext outlinetext" style="text-align:left">&emsp;But let's slow down here. Projecting and Rasterizing 3D objects is complicated to learn, but becomes simple to execute when understood. From here on, I shall describe only the processes I used, but there are numberous paths to achieve this same end point, many of which I do not understand at this given time.</h3>
        <h3 class="basictext outlinetext" style="text-align:left">&emsp;I chose to use <span class="highlight">triangles</span> like many others for their efficiency in rasterization, helpfullness in transforming vertex attributes, and ability to form any other flat-faces 3d shape with them. They have a great deal of research and mathematical use behind them that makes them an extremely powerful and versitile shape, yet very efficient as well.</h3>
        <h3 class="basictext outlinetext" style="text-align:left">&emsp;Before we can work with triangles, we need to know how to project individual 3d points. Projecting onto the screen of a "Virtual Camera" sounds more complicated than is ever necessary. But it all comes down to some tricky calculations that are entirely handled by the computer. We will simplify our process a bit though by cutting out any movement or rotation of the camera, making the scene less interactive but simplifying and speeding things up a bit in comparison.</h3>
        <h3 class="basictext outlinetext" style="text-align:left">&emsp;Beyond transforming and projecting triangles, we need to make sure that we aren't drawing any objects or triangles on top of something that's supposed to be closer to the camera. Fortunately, if we store an array of the current depth at each pixel, we can check that array during rasterization to see if there is already a pixel there closer to the camera, or 'origin' in our case.</h3>
        <div class="section" style="position: absolute; left:-300; top:0; width:250">
            <h3 class="basictext outlinetext">Vector graphics consist of shapes and perfect lines, they are infinitely scalable and don't conform to a resolution, unlike images</h3>
            <hr style="left:255px; width:575px; top:30"/>
            <div class="round" style="left:830px; top:33;"></div>
        </div>
        <div class="section" style="position: absolute; left:850; top:200; width:250">
            <h3 class="basictext outlinetext"><a href="#triangles" style="text-decoration: none">Triangles 101</a></h3>
            <hr style="left:-660px; width:655px; top:40"/>
            <div class="round" style="left:-670; top:43;"></div>
        </div>
    </div>
    <h1 class="basictext outlinetext" style="margin: 100px auto 50px auto" id="triangles">Triangles 101</h1>
    <div class="" style="position: relative; margin: 0 auto auto auto; width: 800">
        <h2 class="basictext outlinetext">Before trying to understand the exact math and programming behind rasterizing a triangle, it's important to start thinking about triangles in these three ways.</h2>
        <h3 class="basictext outlinetext" style="text-align:left">&emsp;1: A set of 3 points, with lines connecting points 1 - 2, 2 - 3, and 3 - 1.<br>&emsp;2: A single point with two lines jetting out from it, being filled until a terminating line.<br>&emsp;3: A set of two triangles. With each of their terminating lines being horizontally flat.</h3>
        <h3 class="basictext outlinetext" style="text-align:left">&emsp;With these three manners, we can split up the process of drawing the pixels of a triangle in simple steps. Firstly, drawing a triangle with a flat terminating line is much easier than one with a slanted terminating line. As with a triangle of this manner, we can loop from y positions from the terminating line to the source, and find the range of x values for every y position in said triangle. Knowing this, and assuming #3 is true, we can write the processes for a flat-terminating triangle, and be able to draw any triangle after figuring out how to split it up.</h3>
        <h3 class="basictext outlinetext" style="text-align:left">&emsp;As mentioned, the rasterization process of a flat-terminating triangle is as easy and as complicated as it sounds. Knowing the highest y point, and lowest y point, (those being the y-point of the origin, and the y point of the terminator), we can loop through each y level.</h3>
        <h3 class="basictext outlinetext" style="text-align:left"><br>&emsp;To know each x value, we can consider the two lines that run through the origin. Note that a line is given by the equation: "y = mx + b", and rewritten, we can find x when given y, using "x = (y - b)/m". With this in mind, we can solve for the x-values of either side-line given the y position. Which can come straigh from our loop between the two y-limits of our triangles.<br>Before we drop in our loop and edge finders, let's simplify this "x = (y - b)/m". For our case, we do not need "b" in there at all, when we know what our original x value is, we can reason that for every change in y, x changes by the change in y times the inverse-slope. "Δy * 1/m". Secondly, we are able to find what "m" equals before we start any loop, and thus, can find 1/m to save calculations during our loop.</h3>
        <h3 class="basictext outlinetext" style="text-align:left"><br>&emsp;In summary, we will loop through the y values, as there is a definite top and bottom. And for each y value, we will find the boundaries of x by solving for the x values of the lines that surround the triangle. We will call our two resulting values, "left x" and "right x". (Although there is no garauntee that one is left and one is right, as performing that check wastes processing time).</h3>
        <h3 class="basictext outlinetext" style="text-align:left"><br>&emsp;Noting that we can find the slope of a line going through two points by (y2-y1)/(x2-x1), we can calculate the slopes of the two sides of the triangle that we need to know, given the 3 points of our triangle. And better yet, we can calculate the inverse slope, by calculating (x2-x1)/(y2-y1) instead of the original reciprocal.</h3>
        <h3 class="basictext outlinetext" style="text-align:left">Given all that, we can now fully loop through every pixel inside of a triangle. Making sure that we are finding a floored or rounded x and y value, because we need integer values for settings pixels and further calculations.</h3>
    </div>

    <!-- Required to end Universal and "cut" divs -->
    </div>
    </div>
</body>

</html>
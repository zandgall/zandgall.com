<html lang="en">
<?php 
$pagetitle = "Zandgall - QB64 3D Rasterizer";
$pagedesc = "Overview of a program that can rasterize 3d graphics, written in QB64, a close recreation of BASIC";
include "global/head_.php"?>

<body>
    <?php 
    $title = "Welcome to the site!";
    $subtitle = "A resource for Arvopia and other projects";
    include "global/head.php"?>

    <h1 class="basictext outlinetext" style="margin: 100px auto 200px auto; font-size: 48">3D Rasterizing in QB64</h1>

    <h3 class="basictext outline"></h3>

    <h3 class="basictext outlinetext" style="font-size: 24px; margin: auto auto 100px auto">
        <span style="text-decoration:underline; font-size:32">Contents</span><br>
        <a class="link basictext" href="#qb64">What is QB64?<a><br>
        <a class="link basictext" href="#raster">What is 3D Rasterizing?</a><br>
        <a class="link basictext" href="#triangles">Triangles 101</a><br>
        <a class="link basictext" href="#linear">Linear Algebra for the faint of heart</a><br>
        <a class="link basictext" href="#depth">Depth is easier than it seems</a><br>
        <a class="link basictext" href="#extra">Extra little details</a><br>
        <!-- <a class="link basictext" href="#gallery">Gallery</a><br> -->
        <a class="link basictext" href="#resources">Further Resources</a><br>
    </h3>

    <h1 class="basictext outlinetext" style="margin: 100px auto 50px auto" id="qb64">What is QB64?</h1>
    <div class="" style="position: relative; margin: 0 auto auto auto; width: 800;">
        <h2 class="basictext outlinetext">In order to understand QB64, you must first learn what BASIC is</h2>

        <h3 class="basictext outlinetext" style="text-align:left">&emsp;BASIC is a programming language developed in the late 60s and early 70s, becoming a mainstay as one of, if not the most influential programming languages of all time. It was created to be a simple programming language that could be extremely easy to learn, but still powerful. An IDE was created for it for DOS called "Quick BASIC", or QBasic for short. This became the influence for QB64 in the 2000s when it released. It allows the creation and compilation of BASIC programs for modern Operating Systems.</h3>
        <h3 class="basictext outlinetext" style="text-align:left">&emsp;Although being built and given support for 64 bit systems, QB64 gives you a similar amount of power that BASIC would have given you back in the day, and that's why I chose it. One problem with this choice however, is that one of the benefits it <i>does</i> give you, is in the realm of graphics. But the extent at which I used it, was very minimal and did not harm my learning experience in this field.</h3>
    </div>

    <!-- Required to end Universal and "cut" divs -->
    </div>
    </div>
</body>

</html>
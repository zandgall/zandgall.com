<html lang="en">
<?php $pagetitle = "Zandgall - Vector Field";
$pagedesc = "Information about Vector Fields and an implementation of them";
include "global/header.php"?>

<?php $title = "Welcome to the site!";
    $subtitle = "A resource for Arvopia and other projects";
include "global/begin.php"?>

<div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm">
    <!-- Parent has no display style, so give it one here, but with a lower opacity. Not applied to parent so that other children won't have a default opacity of 0.92 -->
    <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div>
    <!--STUFF HERE-->
    <h1 class="basictext outlinetext" style="font-size: 72">Vector Fields</h1>
    <h2 class="basictext" style="text-align: left; text-indent: 2em">
        Vector Fields are a very fun little subject that can have a variety of uses. A lot of the time it is used in simulating, but in our case it will be used for artistic purposes.
    </h2>
    <img class="section" src="assets/vector fields/field example.png" style="width: 98%; margin-left: 1%">
    <h2 class="basictext" style="text-align: left; text-indent: 2em">
        This is an example of a vector field, however in a more standard vector field there will be different sizes to each line, giving them a different impact on particles. But that's getting ahead of myself.<br/>
    </h2>
    <h2 class="basictext" style="text-align: left; text-indent: 2em">
        A vector field is a set of vectors (unbelievable I'm sure) that usually form based on a specific pattern or path. Each vector is spaced equally from a vector to it's right, it's left, and the top and bottom, in a grid-like fashion.<br>
    </h2>
    <h2 class="basictext" style="text-align: left; text-indent: 2em">
        Using a vector field is as simple as putting a particle in it, and having the particle accelerate depending on how the vector field tells it to. If it's directly on a vector pointing to the right, the particle will accellerate to the right, however if it is directly in the middle between a vector pointing right, and a vector pointing left (both the same magnitude), it will not accelerate at all.
    </h2>
    <img class="section" src="assets/vector fields/particle example.gif" style="width: 98%; margin-left: 1%">
    <h2 class="basictext" style="text-align: left; text-indent: 2em">
        Sounding simple yet? Don't worry, it get's worse. This usage of vector fields (known more commonly, as "flow fields") is used in some smaller yet complicated simulations like visualizing magnetic fields, or pathfinding. But it can also be used in big big major projects like Fluid Simulation and Aerodynamics.
    </h2>
    <img class="section" src="assets/vector fields/pathfinding example.jpg" style="width: 98%; margin-left: 1%">
    <img class="section" src="assets/vector fields/fluid example.jpg" style="width: 98%; margin-left: 1%">

    <h2 class="basictext" style="text-align: left; text-indent: 2em">
        Fortunately for us, we don't need all this big tech physics magic. We just want to make something that looks cool. So all we really have to do, is drop in a bunch of particles with certain settings. 
    </h2>

    <img class="section" src="assets/vector fields/settings.png" style="width: 98%; margin-left: 1%">

    <h2 class="basictext" style="text-align: left; text-indent: 2em">
        This is how my program's option menu looks. Most of the options are self explanatory, such as Particle Opacity, Particle Size, Particle Amount, Particle Speed, and Color Variety (as well as the color selector at the bottom). However, there's a few that might need some explanation.<br>
    </h2>
    <h2 class="basictext" style="text-align: left; text-indent: 2em">
        Blending, is a little similar to a "motion blur" effect. It draws a rectangle that's completely black, with a certain opacity based on "blending", making everything fade out over time. Update speed is only effective to "Noise Field" (more on that later), changing the field over time. Rand Variation, makes particles go to any random position, higher values making it happen more often. Field Cells changes how large a "cell" is, or how much space a vector takes up.<br><br>
        The Reset button clears the screen and starts drawing particles again. The Debug button shows particles and vectors similar to the first two screenshots at the top of the page. And the last slider changes what type of generation is used to make a vector field.
    </h2>

    <img class="section" src="assets/vector fields/Title.png" style="width: 98%; margin-left: 1%">

    <h2 class="basictext" style="text-align: left; text-indent: 2em">
        The vector field types are as follows. A Noise field, like a smoothly random generation. Gravity, just pulling particles towards the center of the screen. Rotation, everything orbiting the center of the screen. Strand, a strange generation with everything being pushed around quite frequently. Mouse repel is everything being pushed away from the mouse, Mouse Attract is things pulled towards the ouse, Mouse Orbit is everything orbiting around the mouse.<br><br>
        Mouse Path will point a vector in the direction that the mouse is moving, if the mouse if hovered over it.
    </h2>
    <h2 class="basictext">
        This game was actually based on another project that I made, here on this website. You can check it out <a href="Flowfield">here</a>.
    </h2>
    <a href="Downloads/Vector Field.zip"><div class="section" style="width:75%; margin-left: auto; margin-right: auto; margin-bottom: 20;"><h1 class="basictext outlinetext">Vector Field.zip - 10MB</h1></div></a>
    <div class="splitter"></div>
    <a href="index"><div class="section" style="width:50%; margin-left: auto; margin-right: auto; margin-bottom: 20; margin-top: 20"><h1 class="basictext outlinetext">Home</h1></div></a>
</div>
<?php include "global/end.php"?>
</html>
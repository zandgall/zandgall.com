<!DOCTYPE html>
<html lang="en">
<?php 
$pagetitle = "Zandgall - About";
$pagedesc = "All about the omnipotent toddler who learnt how to use a computer";
include "global/header.php"?>

<?php 
$title = "Welcome to the site!";
$subtitle = "A resource for Arvopia and other projects";
include "global/begin.php"?>

<div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm">
    <!-- Parent has no display style, so give it one here, but with a lower opacity. Not applied to parent so that other children won't have a default opacity of 0.92 -->
    <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div>
    <!--STUFF HERE-->
    <!-- General questions, who what when how why? -->
    <h1 class="basictext outlinetext" style="font-size: 32pt">General</h1>
    <h1 class="basictext">Who are you?</h1>
    <h3 class="basictext">I'm Zander Gall, a young-yet-aging tech nerd who's focused on programming. I have a whole host of projects that anyone can take a look at.</h3>
    <h1 class="basictext">What do you do?</h1>
    <h3 class="basictext">
        Like I said above, I spend my time programming, but I also make <a href="music">music</a> and should be making <a href="https://www.youtube.com/channel/UCYsx5ufS_hoJlfYH9pQKK9A">videos</a>.
    </h3>
    <h1 class="basictext">How do you do that?</h1>
    <h3 class="basictext">
        I program using tools like <a href="https://www.jetbrains.com/idea/">IntelliJ IDEA (Java)</a>, and <a href="https://www.sublimetext.com/">Sublime
            Text</a>. For making music I use, <a
            href="https://www.image-line.com/flstudio/">FL Studio</a>.
    </h3>
    <h1 class="basictext">Why do you do that?</h1>
    <h3 class="basictext">
        I started on Khanacademy when I was homeschooled. I had found their Coding lessons and I got hooked and made
        a few projects over <a href="https://www.khanacademy.org/profile/zandgall/projects">there</a>. I had also
        used Scratch to make a few <a href="https://scratch.mit.edu/users/Zandgall/">projects</a> before I moved on
        to Java where I began to learn serious code. At first, obviously I wasn't very good, but I still wanted to
        make something big. So I started work on a little game called "Arvopia."
    </h3>
    <!-- Arvopia -->
    <h1 class="basictext outlinetext" style="font-size: 32pt">Arvopia</h1>
    <h1 class="basictext">What's Arvopia?</h1>
    <h3 class="basictext">
        Arvopia was my first big project way back in November 2017. It was a little sandbox-esque game, with some
        survival and RPG elements. It didn't get very far content wise,
        but it taught me a lot about Java, coding in general, and the game making process. If you would like to see
        the full history and more information,
        you can read more on it <a href="arvopia">here.</a>
    </h3>
    <h1 class="basictext">When is it going to continue?</h1>
    <h3 class="basictext">
        Arvopia was developed through a series of updates, but for the time being it is on pause while I focus on my
        main education, and develop my skills as a programmer
        before I consider picking it up again. If I do pick it up, Arvopia will almost certainly be reworked in C++,
        a huge change to make, but it would be best to
        completely rewrite it from scratch anyways.
    </h3>
    <!-- Project managing -->
    <h1 class="basictext outlinetext" style="font-size: 32pt">Other projects</h1>
    <h1 class="basictext">What else do you work on?</h1>
    <h3 class="basictext">
        I have a whole host of projects available to look at from my <a href="index">homepage</a> as well as by looking through the list of projects and resources you can find in the menu that you can open at the top-right corner.
        I make games, little tools and programs. I also have a few online JavaScript things you can check out on my <a href="funstuff">'funsies page'</a>
    </h3>
</div>
<?php include "global/end.php"?>a
</html>
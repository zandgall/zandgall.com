<!DOCTYPE html>
<html lang="en">
<?php 
$pagetitle = "Zandgall - Resumé";
$pagedesc = "A Resume web page for Alexander Gall";
include "global/header.php"?>

<style>
    h1 {
        color: rgb(244, 242, 255);
        text-shadow: -1.5px -1.5px 0 #000, 1.5px -1.5px 0 #000, -1.5px 1.5px 0 #000, 1.5px 1.5px 0 #000, 0px -1.5px 0 #000, 0px 1.5px 0 #000, -1.5px 0px 0 #000, 1.5px 0px 0 #000;
        position: relative;
        font-family: sans-serif;
        font-weight: bold;
        text-align: center;
        text-decoration: none;
        font-size: 64px;
    }
    h2 {
        color: rgb(244, 242, 255);
        text-shadow: -1.5px -1.5px 0 #000, 1.5px -1.5px 0 #000, -1.5px 1.5px 0 #000, 1.5px 1.5px 0 #000, 0px -1.5px 0 #000, 0px 1.5px 0 #000, -1.5px 0px 0 #000, 1.5px 0px 0 #000;
        position: relative;
        font-family: sans-serif;
        font-weight: bold;
        text-align: center;
        text-decoration: none;
        font-size: 48px;
    }
    h3 {
        position: relative;
        font-family: sans-serif;
        font-weight: bold;
        text-align: center;
        text-decoration: none;
        font-size: 36px;
    }
    h4 {
        position: relative;
        font-family: sans-serif;
        font-weight: bold;
        text-align: center;
        text-decoration: none;
        font-size: 24px;
    }
    h5 {
        position: relative;
        font-family: sans-serif;
        font-weight: bold;
        text-align: center;
        text-decoration: none;
        font-size: 12px;
    }
</style>

<?php 
$title = "Resumé!";
$subtitle = "You are free to explore the rest of my site";
include "global/begin.php"?>

<div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(1200px, 80vw); margin-bottom: 2cm">
    <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div>
    <!--STUFF HERE-->
    <h1 style="font-family: 'Mate SC', serif;">Alexander Gall</h1>
    <div class="splitter" style="margin-top: -40px"></div>
    <h3 style="margin-top: 5px">Human Born; Computer Raised</h3>
    <img src="assets/resume/me.png" height=620 style="margin-left: 50px; margin-top: 10px; filter: drop-shadow(0px 0px 10px rgb(100, 120, 255)); float: left;" alt="Me">
    
    <h1>All about me</h1>
    
    <h4>I am looking for an Internship for Software Development, I have a wide range of technological skills and knowlege.</h4>
    
    <div class="splitter" style="margin-left: 50%; margin-top: 50px; width: 40%"></div>
    
    <h2>Education and Employment</h2>
    
    <h4 style="text-align: left"><br>Educated at Cyber Village Academy - Junior - 768 Hamline Ave. S, St. Paul, MN 55116 - 2017 to Current</h4>
    <h4>Educated at Concordia University Saint Paul - PSEO Student First Year (done) - 1282 Concordia Avenue, St. Paul, MN 55104 - 2021 to Current</h4>
    
    <h4>Previously Employed at INWYK Partners as a Researcher from 2018 to 2020.</h4>
    <h4>Previously Employed at Caltronics as a Manufacturer from June through August 2021</h4>
    <h4>Previously Employed at Conny's Creamy Cone as a part time worker, May 2021 to November 2022.</h4>
    <div class="splitter" style="margin-top:100px"></div>
    <h2>Languages I am familiar with</h2>
    <h3>Given in order from most familiar to least.</h3>
    <h3 style="text-align:left; width:800px; margin:auto">
        - C++<br>
        <span style="font-size:12pt">&emsp;<i>Memory management and low level coding, proficient in pointers and references, C-based allocation, and the C++ standard library. Very familiar with Procedural Programming</i><br></span>
        - Java<br>
        <span style="font-size:12pt">&emsp;<i>Extensively familiar with the Java AWT libraries, as well as the JDK standard overall. Very familiar with Object Oriented Programming</i><br></span>
        - Python<br>
        <span style="font-size:12pt">&emsp;<i>Familiar with Scripting/Interpreted languages, iterators and general Python syntax. As well as creating Interpreters for other languages, I’ve done one for the simple esoteric language, <a href="https://esolangs.org/wiki/Brainfuck">"brainf***"</a></i><br></span>
        - JavaScript<br>
        <span style="font-size:12pt">&emsp;<i>Familiar with both web Client applications (as well as using JQuery), as well as Node.js server+general applications.</i><br></span>
        - CSS and HTML<br>
        <span style="font-size:12pt">&emsp;<i>Though they aren't programming languages, I am very familiar with using them nonetheless.</i><br></span>
        - PHP<br>
        <span style="font-size:12pt">&emsp;<i>I am generally familiar with basic web protocols and how to use them, my website is hosted on my machine as an Apache server, and uses PHP to deliver (server side) dynamic webpages. I have also been able to make HTTPS requests to PHP, and this website, in various other languages.</i><br></span>
        - Generic BASIC + QuickBasic<br>
        <span style="font-size:12pt">&emsp;<i>Although I highly doubt I will be using BASIC professionally, it's worth mentioning that I have used Basic (and QB64, a fork of it that allows for very basic 64 bit graphics) to build a 3D renderer. I wrote a <a href="qb64%203d">paper</a> detailing the steps, from Linear Algebra and 3D space transformation, Shaders and 3D data, to Triangles and Rasterization.</i></span>
    </h3>
    <h2>Notable Topics I am capable of</h2>
    <h4 style="text-align:left; width:1000px; margin:auto">
    - I/O, creating and/or using file specifications<br><br>
    - Data Structures and Data manipulation; Binary, String encodings (i.e. UTF and Unicode), reading and writing using new file specifications, etc.<br><br>
    - Computer Graphics, either using an external or built in library, or building from the ground up.<br><br>
    - Linear Algebra, visual mathematics and problem solving <br><br>
    - Teaching others about the things I create and communicate even the technical details in an understandable way
    </h4>
    <h5 style="text-align:left; width:1000px; margin:auto">
        <i>
            See <a href="https://youtu.be/12PAtF2Ih_c">this video</a> for an example
        </i>
    </h5>
    <h4 style="text-align:left; width:1000px; margin:auto">
    <br><br>- Using various Open Source libraries*, like OpenGL, ZLib, Curl, Freetype, OpenAL and many others.
    </h4>
    <h5 style="text-align:left; width:1000px; margin:auto">
        <i>
            *Some, if not all of these aren't technically considered libraries, say for example OpenGL, which is a series of specifications that a graphics driver should provide if it is to support OpenGL. The developers of the driver then provide the actual library for computers to use.
        </i>
    </h5>

    <div class="splitter" style="margin-top:100px"></div>
    <img src="assets/resume/me2.png" height=620 style="margin-right: 50px; margin-top: 10px; filter: drop-shadow(0px 0px 10px rgb(100, 120, 255)); float: right;" alt="Me 2">
    <h1>References</h1>
    <h2>Frank Leo</h2>
    <h4 style="margin-top:-30px">Science and Technology Instructor at CVA<br>(651)-494-4375</h4>
    <h2>Nick Rice</h2>
    <h4 style="margin-top:-30px">Assistant Director of Teaching and Learning at CVA<br>Work: (651)-523-7170 ext. 141; Cell: (651)-278-7544</h4>
    <h2>Kyle Belshan</h2>
    <h4 style="margin-top:-30px">Mathematics Instructor at CVA<br>(612)-213-1257</h4>
    <div class="splitter" style="margin-top: 20px"></div>
    <h4>1295 St. Albans St. N ∙ St. Paul, Minnesota ∙ 55117
    <br><br>651∙246∙1786 ∙ Alexanderdgall@gmail.com
    <br><br><a href="https://www.zandgall.com">www.zandgall.com</a></h4>
</div>
<?php include "global/end.php"?>
</html>
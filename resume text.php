<html lang="en">
<?php 
$pagetitle = "Zandgall - Resumé";
$pagedesc = "A Resume web page for Alexander Gall";
?>
<head>
    
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="layers.js"></script>
    <title><?php echo $pagetitle?></title>
    <meta name="description" content="<?php echo $pagedesc?>">
    <meta name="author" content="Zandgall">
    
    <link rel="icon" href="assets/Icon.png">
    
    <link href="https://fonts.googleapis.com/css?family=Signika" rel="stylesheet" type="text/css">
    <style>
        @font-face {
            font-family: basicbit2;
            src: url("assets/basicbit2.ttf");
        }
    </style>
    
    <link rel="stylesheet" href="../style.css">
    <link rel="stylesheet" href="../scroll.css">
    <link rel="stylesheet" href="../global/parallax.css">
<!-- Head is ended in begin, to allow for page-specific head elements -->
</head>


<body>

<div id = "cut" style="height:100vh; top: 0; left: 0; overflow: hidden">
    <div id="universal" class = "p-container" style="height: 100vh; overflow-y: scroll; overflow-x:hidden; position:relative">
   
    <!-- <div id="titleholder"> -->
    <h1 class="title" style="text-align: center; width:800px; margin: auto; margin-top:1cm;"><a href=".." class="title"style="text-decoration: none">Zandgall.com</a></h1>
    <h1 style='font-family: monospace; width:800px; margin: auto; text-align: center;'>Resumé!</h1>
    <h1 style='font-family: monospace; width:800px; margin: auto; text-align: center; font-style: italic;font-size: 14; margin-bottom:2cm;'>You are free to explore the rest of my site</h1>
    <!-- </div> -->

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

<div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(1200px, 80vw); margin-bottom: 2cm">
    <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div>
    <!--STUFF HERE-->
    <h1 style="font-family: 'Mate SC', serif;">Alexander Gall</h1>
    <div class="splitter" style="margin-top: -40"></div>
    <h3 style="margin-top: 5">Human Born; Computer Raised</h3>
    <h4 style="margin-top: 5">Converted from web page, view original <a href="https://www.zandgall.com/resume">here!</a></h4>
    <div style="display: flex; flex-direction:row; justify-items: center;">
        <img src="assets/resume/me.png" height=620 style="margin-left: 50px; margin-top: 10px; filter: drop-shadow(0px 0px 10px rgb(100, 120, 255));" alt="Me">
        
        <div>
            <h1>All about me</h1>
            
            <h4>I am looking for an Internship for Software Development, I have a wide range of technological skills and knowlege, and experience in picking up new technological skills rather quickly. Good at collaborating with, teaching, and learning from fellow students. </h4>
        </div>
    </div>
    
    <div class="splitter" style="margin-top: 50px; width: 80%"></div>
    
    <h2>Education and Employment</h2>
    
    <div class="splitter" style="margin-top: 50px; width: 80%"></div>
    <h4>Cyber Village Academy<br>3810 E 56th Street, Minneapolis, MN 55417<br> 2017 - 2023</h4>
    <h4>Concordia University Saint Paul<br>1282 Concordia Avenue, St. Paul, MN 55104<br>
PSEO: 2021 - 2023<br>Full-Time Student: 2023 - Current<br>
Computer Science Major, Mathematics Minor</h4>
    <div class="splitter" style="margin-top: 100px"></div>
    <h4>INWYK Partners, Researcher: 2018 - 2020.</h4>
    <h4>Caltronics, Manufacturer: June 2021 - August 2021</h4>
    <h4>Conny's Creamy Cone, Employee: May 2021 - November 2022.</h4>
    <h4>Concordia University Saint Paul, IT Technician: June 2023 - Current </h4>
    <div class="splitter" style="margin-bottom:100px"></div>
    <h2>Languages and Frameworks</h2>
    <h3>From most familiar to least.</h3>
    <h3 style="text-align:left; width:800px; margin:auto">
        - C<br>
        <span style="font-size:12pt">&emsp;<i>Memory management and low level coding, proficient in pointers and references, C-based allocation, state-based frameworks. Very familiar with Procedural Programming. Creating, using, and manipulating data structures within main memory and other locations.</i><br></span>
        - C++<br>
        <span style="font-size:12pt">&emsp;<i>Extending on C, familiar with the C++ standard library.</i><br></span>
        - Java<br>
        <span style="font-size:12pt">&emsp;<i>Extensively familiar with the Java AWT libraries, as well as the JDK standard overall. Very familiar with Object Oriented Programming</i><br></span>
        - Assembly<br>
        <span style="font-size:12pt">&emsp;<i>Working in x86-64 assembly, writing analogs for C standard library functions. Also learning assembly for the Nintendo GameBoy, learning to make games on it using GBASM. Experimenting with writing compilers for simple language, I’ve done one for the esoteric language, <a href="https://esolangs.org/wiki/Brainfuck">"brainf***"</a></i></span><br>
        - Python<br>
        <span style="font-size:12pt">&emsp;<i>Familiar with Scripting/Interpreted languages, iterators and general Python syntax. As well as creating Interpreters for other languages.</i><br></span>
        - Apache<br>
        <span style="font-size:12pt">&emsp;<i>You are (likely) viewing this on my website, which is hosted using Apache2 on my own computer. This server utilizes SSL and PHP, pointed to by Cloudflare. There are many different levels of server and client side features, such as the graphical backgrounds, and form-post content.</i></span><br>
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
    - Teaching others about the things I create and communicate even the technical details in an understandable way<br><br>
    - Learning from others and asking for help when I don't understand something, or am out of my depth.
    </h4>
    <h5 style="text-align:left; width:1000; margin:auto">
        <i>
            *Some, if not all of these aren't technically considered libraries, say for example OpenGL, which is a series of specifications that a graphics driver should provide if it is to support OpenGL. The developers of the driver then provide the actual library for computers to use.
        </i>
    </h5>

    <div class="splitter" style="margin-top:100px"></div>
    <img src="assets/resume/me2.png" height=620 style="margin-right: 50px; margin-top: 10px; filter: drop-shadow(0px 0px 10px rgb(100, 120, 255)); float: right;">
    <h1>References</h1>
    <h2>Frank Leo</h2>
    <h4 style="margin-top:-30">Science and Technology Instructor at CVA<br>(651)-494-4375</h4>
    <h2>Nick Rice</h2>
    <h4 style="margin-top:-30">Assistant Director of Teaching and Learning at CVA<br>Work: (651)-523-7170 ext. 141; Cell: (651)-278-7544</h4>
    <h2>Kyle Belshan</h2>
    <h4 style="margin-top:-30">Mathematics Instructor at CVA<br>(612)-213-1257</h4>
    <div class="splitter" style="margin-top: 20"></div>
    <h4>1295 St. Albans St. N ∙ St. Paul, Minnesota ∙ 55117
    <br><br>651∙246∙1786 ∙ Alexanderdgall@gmail.com
    <br><br><a href="https://www.zandgall.com">www.zandgall.com</a></h4>
</div>
</div>
</div>
</body>
</html>
<!--<div style="margin:auto; width: 766; height: 60">
    <canvas id="links" width=766 height=232 style="z-index: -20; position:relative; width:766; height:232; margin-left: auto; margin-right: auto">
    </canvas>
    
</div>-->
<!-- <canvas id="BackgroundC" class="bg" syle="position: fixed;margin: 0;width: 100%;height: 100%">Canvas is not supported</canvas> -->

<div style="left: 128px; top: 100px; position: absolute; width: 100; height: 100; visibility: visibe; overflow: hidden; -webkit-transform-style: preserve-3d; transform-style: preserve-3d; -webkit-transform: translateZ(10px); transform: translateZ(10px); z-index: 9;">
    <img class="sunmoon" style="height:32px; width: 32px; left:32px; top:32px; filter: drop-shadow(0px 0px 10px rgba(255, 255, 200, 0.5))" value="sun" onclick="togglenight()" src="assets/background/Sun.png" alt="Sun">
</div>

<div class = "parallax__group" style="margin: 0; position: absolute; width: inherit;">
    <div class = "parallax__layer parallax__layer--deep" style="top: -1080px; left:-100vw; width:inherit; height: inherit">
        <div class = "parallaxgradient"></div>
        <img class = "parallaximg" src = "assets/background/bg2.png" alt="hills" style="top:240px; position:absolute; image-rendering: pixelated; object-fit: cover; height: 4644; object-position: -100vw 0">
        <img class = 'paracloud pacl0' src = 'assets/background/Cloud1.png' style="height: 144" alt="cloud">
        <img class = 'paracloud pacl0' src = 'assets/background/Cloud2.png' style="height: 144" alt="cloud">
        <img class = 'paracloud pacl0' src = 'assets/background/Cloud3.png' style="height: 144" alt="cloud">
        <img class = 'paracloud pacl0' src = 'assets/background/Cloud4.png' style="height: 144" alt="cloud">
        <img class = 'paracloud pacl0' src = 'assets/background/Cloud1.png' style="height: 144" alt="cloud">
        <img class = 'paracloud pacl0' src = 'assets/background/Cloud2.png' style="height: 144" alt="cloud">
        <img class = 'paracloud pacl0' src = 'assets/background/Cloud3.png' style="height: 144" alt="cloud">
        <img class = 'paracloud pacl0' src = 'assets/background/Cloud4.png' style="height: 144" alt="cloud">
        
        <!-- <div style="left: 100px; top: 240px; position: absolute; width: inherit; height: inherit; visibility: visible">
            <img class="sunmoon" style="height:120px; width: 120px; cursor: pointer; filter: drop-shadow(0px 0px 10px rgba(255, 255, 200, 0.5)); z-index: 100" value="sun" src="assets/background/Sun.png">
        </div> -->
    </div>
    <div class = "parallax__layer parallax__layer--back" style="top: 0vh; width:inherit; height:inherit; left: -100vw">
        <div class = "parallaxgradient"></div>
        <img class = "parallaximg" src = "assets/background/bg1.png" alt="more hills" style="image-rendering: pixelated; object-fit: cover; height: 3483">
        <img class = 'paracloud pacl1' src = 'assets/background/Cloud1.png' style="height: 108" alt="cloud">
        <img class = 'paracloud pacl1' src = 'assets/background/Cloud2.png' style="height: 108" alt="cloud">
        <img class = 'paracloud pacl1' src = 'assets/background/Cloud3.png' style="height: 108" alt="cloud">
        <img class = 'paracloud pacl1' src = 'assets/background/Cloud4.png' style="height: 108" alt="cloud">
        <img class = 'paracloud pacl1' src = 'assets/background/Cloud1.png' style="height: 108" alt="cloud">
        <img class = 'paracloud pacl1' src = 'assets/background/Cloud2.png' style="height: 108" alt="cloud">
        <img class = 'paracloud pacl1' src = 'assets/background/Cloud3.png' style="height: 108" alt="cloud">
        <img class = 'paracloud pacl1' src = 'assets/background/Cloud4.png' style="height: 108" alt="cloud">
    </div>
    <div class = "parallax__layer parallax__layer--base" style="top: 2564px; height: inherit; width:230vw; left: -100vw; background-image: url('assets/background/BGImg36.png'); background-repeat:repeat;">
        <div class = "parallaxgradient"></div>
        <img class = "parallaximg" src = "assets/background/bg0.png" alt="even more hills" style="image-rendering: pixelated; object-fit: cover; height: 1044; margin-top:-1044px; filter:none">
        <!-- <img class = "parallaximg" alt="lots o' dirt" width=7140 height=7424 style="border:0; background-image: url('assets/background/BGImg36.png'); background-repeat: repeat; image-rendering: pixelated; object-fit: cover; filter: none; visibility:none"> -->
        <img class = 'paracloud pacl2' src = 'assets/background/Cloud1.png' style="height: 72" alt="cloud">
        <img class = 'paracloud pacl2' src = 'assets/background/Cloud2.png' style="height: 72" alt="cloud">
        <img class = 'paracloud pacl2' src = 'assets/background/Cloud3.png' style="height: 72" alt="cloud">
        <img class = 'paracloud pacl2' src = 'assets/background/Cloud4.png' style="height: 72" alt="cloud">
        <img class = 'paracloud pacl2' src = 'assets/background/Cloud1.png' style="height: 72" alt="cloud">
        <img class = 'paracloud pacl2' src = 'assets/background/Cloud2.png' style="height: 72" alt="cloud">
        <img class = 'paracloud pacl2' src = 'assets/background/Cloud3.png' style="height: 72" alt="cloud">
        <img class = 'paracloud pacl2' src = 'assets/background/Cloud4.png' style="height: 72" alt="cloud">
    </div>
    <div class = "parallax__layer parallax__layer--fore" style="top: 130vh; height: 10000; width:inherit">
        <div class = "parallaxgradient"></div>
    </div>
    <div class = "parallax__layer parallax__layer--deep nightoverlay" style="left: -100vw; top: -100vh; z-index: 6;"></div>
</div>

<!-- <a class="option" href="#" style="top: 220px; z-index: 10; " onclick="killclouds()"><h3 class="basictext" style="margin: auto">Toggle Clouds</h3></a>
<a class="option" href="#" style="top: 250px; z-index: 10;" onclick="killlayers()"><h3 class="basictext" style="margin: auto">Toggle Layers</h3></a>
<a class="option" href="#" style="top: 280px; z-index: 10" onclick="killstars()"><h3 class="basictext" style="margin: auto">Toggle Stars</h3></a> -->

<script type="application/javascript">
    function f(x) {
        return parseFloat(x);
    }
    var cloudToggled = (localStorage["zandgall.cloud"] || "true") === "true";
    var layerToggled = (localStorage["zandgall.layer"] || "true") === "true";
    let menuout = false;
    if(!layerToggled)
        $(".parallax__layer").css("visibility", "hidden");

    function killclouds() {
        if(cloudToggled) {
            $(".paracloud").css("visibility", "hidden");
            localStorage["zandgall.cloud"] = "false";
        } else {
            $(".paracloud").css("visibility", "visible");
            localStorage["zandgall.cloud"] = "true";
        }
        cloudToggled = !cloudToggled; 
    }

    function killlayers() {
        if(layerToggled) {
            $(".parallax__layer").css("visibility", "hidden");
            localStorage["zandgall.layer"] = "false";
        } else {
            $(".parallax__layer").css("visibility", "visible");
            localStorage["zandgall.layer"] = "true";
        }
        layerToggled = !layerToggled;
    }

    function killstars() {
        localStorage["zandgall.stars"] = (localStorage["zandgall.stars"] || "true") === "false"
    }

    function togglenight() {
        night = !night;
        if(night) {
            $(".sunmoon").attr("src", "assets/background/Moon.png");
            $(".sunmoon").attr("alt", "( o)")
            $("*").addClass("night");
        }
        else {
            $(".sunmoon").attr("src", "assets/background/Sun.png");
            $(".sunmoon").attr("alt", "☼");
            $("*").removeClass("night");
        }
        document.documentElement.style.setProperty("--night", night ? 1 : 0);
    }

    function p(str) {
        if(str.endsWith("px"))
            return str.substr(0, str.length-2);
        else return str;
    }

    let menu = $(".bmenu");
    let blindex = 0, bhindex = 0, boffset = [];

    function parallaxheightupdate() {
        if(document.body.clientWidth>=850)
            $(".__links__").css("width", "850px");
        else $(".__links__").css("width", "100%");

        $(".__links__").css("left", (document.body.clientWidth-parseInt($(".__links__").css("width"), 10))/2);
        $(".parallax__group").css("height", $("#universal")[0].scrollHeight);
        if($("#universal")[0].scrollHeight > 4644)
            $(".parallaxgradient").css("height", $("#universal")[0].scrollHeight);
        $(".nightoverlay").css("height", $("#universal")[0].scrollHeight*4);
        if(menu.length == 0)
            load();
        for(let i = 0; i < boffset.length; i++) {

            if(boffset[i].on) {
                boffset[i].current = boffset[i].current*0.8 + boffset[i].max*0.2;
            } else {
                boffset[i].current = boffset[i].current*0.8;
            }

            if(i==0)
            boffset[i].total= boffset[i].current;
            else boffset[i].total = boffset[i].current + boffset[i-1].total;
        }
        if(menuout) {
            for(let i = 0; i < menu.length; i++) {
                if($(menu[i]).attr("class").includes("bline")) {
                    let bwidth = p($(menu[i]).css("--bwidth"));
                    $(menu[i]).css("left", (775 - bwidth) * 0.2 + p($(menu[i]).css("left")) * 0.8);
                    $(menu[i]).css("width", bwidth * 0.2 + p($(menu[i]).css("width")) * 0.8);
                    $(menu[i]).css("top", (i-blindex+1-$(menu[i]).css("--bindex"))*55 + 10 + ($(menu[i]).css("--bindex")==0 ? 0 : boffset[$(menu[i]).css("--bindex")-1].total));
                } else if($(menu[i]).attr("class").includes("bholder")) {
                    $(menu[i]).css("top", (i-bhindex+2)*55 + 10 + ((i-bhindex)==0 ? 0 : boffset[i-bhindex-1].total));
                    $(menu[i]).css("height", boffset[i-bhindex].current);
                    $(menu[i]).css("left", 475 * 0.2 + p($(menu[i]).css("left")) * 0.8);
                } else {
                    $(menu[i]).css("margin-right", p($(menu[i]).css("margin-right")) * 0.8+5);
                    $(menu[i]).css("margin-top", (i+1)*55 + 10 + (i==0 ? 0 : boffset[i-1].total));
                }
            }
            // $(".bmenu").css("margin-right") = $(".bmenu").css("margin-right") * 0.8;
        } else {
            for(let i = 0; i < menu.length; i++) {
                if($(menu[i]).attr("class").includes("bline")) {
                    let bwidth = p($(menu[i]).css("--bwidth"));
                    $(menu[i]).css("left", 775 * 0.2 + p($(menu[i]).css("left")) * 0.8);
                    $(menu[i]).css("width", p($(menu[i]).css("width")) * 0.8);
                    $(menu[i]).css("top", (i-blindex+1-$(menu[i]).css("--bindex"))*55 + 10 + ($(menu[i]).css("--bindex")==0 ? 0 : boffset[$(menu[i]).css("--bindex")-1].total));
                } else if($(menu[i]).attr("class").includes("bholder")) {
                    $(menu[i]).css("top", (i-bhindex+2)*55 + 10 + ((i-bhindex)==0 ? 0 : boffset[i-bhindex-1].total));
                    $(menu[i]).css("height", boffset[i-bhindex].current);
                    $(menu[i]).css("left", 875 * 0.2 + p($(menu[i]).css("left")) * 0.8);
                } else {
                    $(menu[i]).css("margin-right", p($(menu[i]).css("margin-right")) * 0.8-200*0.2);
                    $(menu[i]).css("margin-top", (i+1)*55 + 10 + (i==0 ? 0 : boffset[i-1].total));
                }
            }
            // $(".bmenu").css("margin-right") = $(".bmenu").css("margin-right") * 0.8 + -200*0.2;
        }

        // var s = $(".sunmoon");        
        // if(lmouseX>32&&lmouseX<72&&lmouseY>80-$("#universal").scrollTop()/4&&lmouseY<120-$("#universal").scrollTop()/4){  // If mouse over sun/moon
        //     $("html,body").css("cursor", "pointer");
        // } else {
        //     $("html,body").css("cursor", "");
        // }

        if(lmouseX<300) {
            var x = $(".option").offset().left;
            $(".option").css("left", x + desire(10, x));
        } else {
            var x = $(".option").offset().left;
            $(".option").css("left", x + desire(-200, x));
        }

        if(!cloudToggled)
            return;
        var clouds = $(".paracloud");
        for(var i = 0; i < clouds.length; i++) {
            var rat = 1;
            if($(clouds[i]).is(".pacl0"))
                rat = 3;
            if($(clouds[i]).is(".pacl1"))
                rat = 2;
                // $(clouds[i]).css("left", f($(clouds[i]).css("left"))+f($(clouds[i]).data("data-speed")));
            var trans = $(clouds[i]).css("transform") || $(clouds[i]).css("-webkit-transform") || $(clouds[i]).css("-moz-transform") || $(clouds[i]).css("-mz-transform") || $(clouds[i]).css("-o-transform");
            var mat = (trans.replace(/[^0-9\-.,]/g, '').split(','));
            var x = f(mat[12] || mat[4] || 0) + f($(clouds[i]).data("data-speed"));
            $(clouds[i]).css("transform", "translateX("+ x + "px)");
            $(clouds[i]).css("-webkit-transform", "translateX("+ x + "px)");
            $(clouds[i]).css("-moz-transform", "translateX("+ x + "px)");
            $(clouds[i]).css("-mz-transform", "translateX("+ x + "px)");
            $(clouds[i]).css("-o-transform", "translateX("+ x + "px)");
            if(x>f($("body").width())*rat - f($(clouds[i]).parent().css("left"))){
                $(clouds[i]).css("transform", "translateX(-400px)");
                $(clouds[i]).css("top", Math.random()*1000*rat);
            }
        }
        lmouseClicked = false;
    }

    var clouds = $(".paracloud");
    for(var i = 0; i < clouds.length; i++) {
        if(!cloudToggled)
            $(clouds[i]).css("visibility", "hidden");
        var rat = 1;
        if($(clouds[i]).is(".pacl0"))
            rat = 3;
        if($(clouds[i]).is(".pacl1"))
            rat = 2;
        var z = Math.random()*4;
        
        $(clouds[i]).css("transform", "translateX("+(Math.random()*f($("body").width())*rat)+"px)");
        $(clouds[i]).css("-webkit-transform", "translateX("+(Math.random()*f($("body").width())*rat)+"px)");
        $(clouds[i]).css("-moz-transform", "translateX("+(Math.random()*f($("body").width())*rat)+"px)");
        $(clouds[i]).css("-mz-transform", "translateX("+(Math.random()*f($("body").width())*rat)+"px)");
        $(clouds[i]).css("-o-transform", "translateX("+(Math.random()*f($("body").width())*rat)+"px)");
        $(clouds[i]).css("top", Math.random()*1000*rat);
        $(clouds[i]).data("data-speed", z/2.0+1.5);
    }

    window.setInterval(parallaxheightupdate, 64);
    function load() {
        // Handle menu setting
        for(let i = 0; i < /*Set menus*/ 10; i++)
            boffset.push({max: 10, current: 0, total:0, on: false});
        menu = $(".bmenu");
        for(let i = 0; i < menu.length; i++) {
            if($(menu[i]).attr("class").includes("bline")) {
                if(blindex==0)
                    blindex = i;
            } else if($(menu[i]).attr("class").includes("bholder")) {
                if(bhindex==0)
                    bhindex = i;
                for(let j = 0; j < $(menu[i]).children().length; j++) {
                    $($(menu[i]).children()[j]).css("margin-top", j*40);
                }
                boffset[i-bhindex].max = $(menu[i]).children().length*40 + 10;
            }
            else {
                boffset[i].max = $(menu[i]).css("--bsize");
            }
        }

        if ((localStorage["zandgall_dayNight"] || "day") == "night") {
            togglenight();
        }
    }

    function menuSelected(i) {
        // i is the index of the menu. Home = 0, Projects = 1, Resources = 2, etc.
        boffset[i].on = !boffset[i].on;
        if(boffset[i].on) {
            $($(".linkpages")[i]).children().css("color", "#344065");
        } else {
            $($(".linkpages")[i]).children().css("color", "#6880cb");
        }
    }

    function openmenu() {
        menuout = !menuout;
    }
</script>

<header class="title" style="text-align: center; position:relative;">Zandgall.com</header>

<div class = "splitter"></div>

<?php
    echo "<h1 style='font-family: monospace;margin: 0;text-align: center;position: relative;'>" . $title . "</h1>";
    echo "<h1 style='font-family: monospace;margin: 0;text-align: center;font-style: italic;font-size: 14;position: relative;'>" . $subtitle . "</h1>";
?>

<div class = "splitter"></div>
<!-- <div style="position: relative; margin: auto; width: 100%; height:200;"></div> -->
<!-- <div class="__links__"style="position: absolute; top: 110; margin:0; width: 850px; height: 10; display: flex; z-index: 2">
    <div class = "link" style="width: 100" tabindex = "0">
        <div class = "linktop"></div>
        <h1 class = "basictext">Home</h1>
        <div class = "linkbottom"></div>
        <a class = "linkpages" href = "index">Homepage</a>
        <a class = "linkpages" href = "about">About</a>
    </div>

    <div class = "link" style="width: 160" tabindex = "0">
        <div class = "linktop"></div>
        <h1 class = "basictext">Download</h1>
        <div class = "linkbottom" style="width: inherit"></div>
        <a class = "linkpages" href = "arvopiadownload">Arvopia</a>
        <a class = "linkpages" href = "levelcreatordownload">LevelCreator</a>
        <a class = "linkpages" href = "arvopiabuilddownload">Arvopia Builds</a>
        <a class = "linkpages" href = "otherdownload">Other Projects</a>
    </div>

    <div class = "link" style="width: 190" tabindex = "0">
        <div class = "linktop"></div>
        <h1 class = "basictext">What's new</h1>
        <div class = "linkbottom"></div>
        <a class = "linkpages" href = "teasers">Teasers</a>
        <a class = "linkpages" href = "futureplans">Future plans</a>
    </div>

    <div class = "link" style="width: 120" tabindex = "0">
        <div class = "linktop"></div>
        <h1 class = "basictext">Contact</h1>
        <div class = "linkbottom"></div>
        <a class = "linkpages" href = "socialmedia">Social Media</a>
    </div>

    <div class = "link" style="width: 170" tabindex = "0">
        <div class = "linktop"></div>
        <h1 class = "basictext">Resources</h1>
        <div class = "linkbottom"></div>
        <a class = "linkpages" href = "music">Music</a>
        <a class = "linkpages" href = "funstuff">Fun stuff</a>
    </div>
</div> -->

<div style="position: relative; margin: auto; width: 800px; height:200px; float: right">
    <a href="#" onclick="openmenu()"><div id="hamburger" style="width:50px; height:50px; position: absolute; top:25px; left: 725px">
        <div id="top bun" width=inherit style="height: 10px; position: relative; border: solid 0px; background-color:#6880cb; border-radius: 20px"></div>
        <div id="meat" width=inherit style="height: 10px; position: relative; border: solid 0px; background-color:#6880cb; margin-top: 10px; border-radius: 20px"></div>
        <div id="bottom bun" width=inherit style="height: 10px; position: relative; border: solid 0px; background-color:#6880cb; margin-top: 10px; border-radius: 20px"></div>
    </div></a>
    <div class="bmenu" style="--bsize: 100; margin-right: -200px; margin-left: -200;">
        <a class = "linkpages" href="#" onclick="menuSelected(0)"><h5 class="basictext link" style="font-size: 2em; color:#6880cb">Home</h5></a>
    </div>
    <div class="bmenu" style="--bsize: 410; margin-right: -200px; margin-left: -200">
        <a class = "linkpages" href="#" onclick="menuSelected(1)"><h5 class="basictext link" style="font-size: 2em; color:#6880cb">Projects</h5></a>
    </div>
    <div class="bmenu" style="--bsize: 100; margin-right: -200px; margin-left: -200">
        <a class = "linkpages" href="#" onclick="menuSelected(2)"><h5 class="basictext link" style="font-size: 2em; color:#6880cb">Resources</h5></a>
    </div>
    <div class="bmenu" style="--bsize: 100; margin-right: -200px; margin-left: -200">
        <a class = "linkpages" href="#" onclick="menuSelected(3)"><h5 class="basictext link" style="font-size: 2em; color:#6880cb">Misc</h5></a>
    </div>
    <div class="bmenu bline" style="position: absolute; --bindex:0; --bwidth:100; height: 10"></div>
    <div class="bmenu bline" style="position: absolute; --bindex:0; --bwidth:100;  height: 10"></div>
    <div class="bmenu bline" style="position: absolute; --bindex:1; --bwidth:140;  height: 10"></div>
    <div class="bmenu bline" style="position: absolute; --bindex:1; --bwidth:140;  height: 10"></div>
    <div class="bmenu bline" style="position: absolute; --bindex:2; --bwidth:185;  height: 10"></div>
    <div class="bmenu bline" style="position: absolute; --bindex:2; --bwidth:185;  height: 10"></div>
    <div class="bmenu bline" style="position: absolute; --bindex:3; --bwidth:100;  height: 10"></div>
    <div class="bmenu bline" style="position: absolute; --bindex:3; --bwidth:100;  height: 10"></div>
    <div class="bmenu bline" style="position: absolute; --bindex:4; --bwidth:100;  height: 10"></div>
    <div class="bmenu bholder">
        <a class="linkpages" href="index"><h3 class="basictext link linkpages">Homepage</h3></a>
        <a class="linkpages" href="about"><h3 class="basictext link linkpages">About</h3></a>
    </div>
    <div class="bmenu bholder">
        <a class="linkpages" href="arvopia"><h3 class="basictext link linkpages">Arvopia</h3></a>
        <a class="linkpages" href="bubblecannons"><h3 class="basictext link linkpages">BubbleCannons</h3></a>
        <a class="linkpages" href="solarglyphs"><h3 class="basictext link linkpages">SolarGlyphs</h3></a>
        <a class="linkpages" href="marbo"><h3 class="basictext link linkpages">Marbo</h3></a>
        <a class="linkpages" href="lants"><h3 class="basictext link linkpages">Lants</h3></a>
        <a class="linkpages" href="schute"><h3 class="basictext link linkpages">Schute!</h3></a>
        <a class="linkpages" href="fallingmine"><h3 class="basictext link linkpages">Falling Mine</h3></a>
        <a class="linkpages" href="mapcreator"><h3 class="basictext link linkpages">Map creator</h3></a>
        <a class="linkpages" href="normalbuddy"><h3 class="basictext link linkpages">Normal Buddy</h3></a>
        <a class="linkpages" href="miscarvopiatools"><h3 class="basictext link linkpages">Misc Arvopia Tools</h3></a>
    </div>
    <div class="bmenu bholder">
        <a class="linkpages" href="funstuff"><h3 class="basictext link linkpages">Fun stuff</h3></a>
        <a class="linkpages" href="otherdownload"><h3 class="basictext link linkpages">Project Downloads</h3></a>
        <a class="linkpages" href="arvopiadownload"><h3 class="basictext link linkpages">Arvopia Downloads</h3></a>
        <a class="linkpages" href="music"><h3 class="basictext link linkpages">Music</h3></a>
        <!-- <a class="linkpages" href="resume"><h3 class="basictext link linkpages">Resume</h3></a> -->
    </div>
    <div class="bmenu bholder">
        <a class="linkpages" href="#" onclick="killclouds()"><h3 class="basictext link linkpages">Toggle Clouds</h3></a>
        <a class="linkpages" href="#" onclick="killlayers()"><h3 class="basictext link linkpages">Toggle Layers</h3></a>
        <a class="linkpages" href="#" onclick="killstars()"><h3 class="basictext link linkpages">Toggle Stars</h3></a>
        <a class="linkpages" href="arvopialevelcreator"><h3 class="basictext link linkpages">Arvopia Level Creator</h3></a>
        <a class="linkpages" href="arvopialevelcreatordownload"><h3 class="basictext link linkpages">ALC Download</h3></a>
    </div>
</div>
 <!-- <div style="position: relative; margin: auto; width: 100%; height:200;"></div> -->
<script>

var ROOT = "<?php echo $ROOT?>";

// Global variables
var mouseX, mouseY, mouseDown;

function f(x) {
    return parseFloat(x);
}

function px(str) {
    if (str.endsWith("px"))
    return str.substr(0, str.length - 2);
    else return str;
}

let night = (localStorage["zandgall.night"] || "true") === "true";
var cloudToggled = (localStorage["zandgall.cloud"] || "true") === "true";
var layerToggled = (localStorage["zandgall.layer"] || "true") === "true";

// Initial layer toggle, if necessary
if (!layerToggled)
    $(".paralayer").css("visibility", "hidden");


/* Toggle Options from Menu */
function kill_clouds() {
    if (cloudToggled) {
        $(".cloud").css("visibility", "hidden");
        localStorage["zandgall.cloud"] = "false";
    } else {
        $(".cloud").css("visibility", "visible");
        localStorage["zandgall.cloud"] = "true";
    }
    cloudToggled = !cloudToggled;
}

function kill_layers() {
    if (layerToggled) {
        $(".paralayer").css("visibility", "hidden");
        localStorage["zandgall.layer"] = "false";
    } else {
        $(".paralayer").css("visibility", "visible");
        localStorage["zandgall.layer"] = "true";
    }
    layerToggled = !layerToggled;
}

function kill_stars() {
    localStorage["zandgall.stars"] = (localStorage["zandgall.stars"] || "true") === "false"
}

function toggle_night() {
    night = !night;
    if (night) {
        if((localStorage["zandgall.stars"] || "true")=="true")
            $("#cut").css("background", "url('"+ROOT+"assets/background/spacebg.png')");
        $(".sunmoon").attr("src", ROOT+"assets/background/Moon.png");
        $(".sunmoon").attr("alt", "( o)")
        $("*").addClass("night");
        $($(".paralayer")[0]).css("background-image", `url("${ROOT}assets/background/background 2n.png")`);
        $($(".paralayer")[1]).css("background-image", `url("${ROOT}assets/background/background 1n.gif")`);
        $($(".paralayer")[2]).css("background-image", `url("${ROOT}assets/background/background 0n.gif")`);
        $($(".paralayer")[3]).css("background-image", `url("${ROOT}assets/background/dirtn.png")`);
    } else {
        $("#cut").css("background", "transparent");
        $(".sunmoon").attr("src", ROOT+"assets/background/Sun.png");
        $(".sunmoon").attr("alt", "☼");
        $("*").removeClass("night");
        $($(".paralayer")[0]).css("background-image", `url("${ROOT}assets/background/background 2.png")`);
        $($(".paralayer")[1]).css("background-image", `url("${ROOT}assets/background/background 1.gif")`);
        $($(".paralayer")[2]).css("background-image", `url("${ROOT}assets/background/background 0.gif")`);
        $($(".paralayer")[3]).css("background-image", `url("${ROOT}assets/background/dirt.png")`);
    }
    document.documentElement.style.setProperty("--night", night ? 1 : 0);
    localStorage["zandgall.night"] = night ? "true" : "false";
}

let menu = $(".bmenu");
let blindex = 0,
    bhindex = 0,
    boffset = [];
let menuOut = false;

function menu_update() {
    if($("#menu_toast").length) {
        let mto = parseFloat($("#menu_toast").css("opacity"));
        let c = 1-mto;
        mto-=0.01 * c + 0.0005;
        $("#menu_toast").css("opacity", mto);
        if(mto<=0)
            $("#menu_toast").remove();
    }
    if (boffset.length == 0)
        load();
    
    // Update main menu tabs opening animation
    for (let i = 0; i < boffset.length; i++) {
        if (boffset[i].on)
            boffset[i].current = boffset[i].current * 0.8 + boffset[i].max * 0.2;
        else
            boffset[i].current = boffset[i].current * 0.8;

        if (i == 0)
            boffset[i].total = boffset[i].current;
        else 
            boffset[i].total = boffset[i].current + boffset[i - 1].total;
    }

    // Update burger opening or closing animation
    if (menuOut) {
        for (let i = 0; i < menu.length; i++) {
            if ($(menu[i]).attr("class").includes("bline")) {
                let bwidth = px($(menu[i]).css("--bwidth"));
                $(menu[i]).css("left", (775 - bwidth) * 0.2 + px($(menu[i]).css("left")) * 0.8);
                $(menu[i]).css("width", bwidth * 0.2 + px($(menu[i]).css("width")) * 0.8);
                $(menu[i]).css("top", (i - blindex + 1 - $(menu[i]).css("--bindex")) * 50 + 15 + ($(menu[i]).css("--bindex") == 0 ? 0 : boffset[$(menu[i]).css("--bindex") - 1].total));
            } else if ($(menu[i]).attr("class").includes("bholder")) {
                $(menu[i]).css("top", (i - bhindex + 2) * 50 + 15 + ((i - bhindex) == 0 ? 0 : boffset[i - bhindex - 1].total));
                $(menu[i]).css("height", boffset[i - bhindex].current);
                $(menu[i]).css("left", 475 * 0.2 + px($(menu[i]).css("left")) * 0.8);
                $(menu[i]).children(".linkpages").css("position", "relative"); // Force update the text to show
            } else {
                $(menu[i]).css("margin-right", px($(menu[i]).css("margin-right")) * 0.8 + 5);
                $(menu[i]).css("margin-top", (i + 1) * 50 + 15 + (i == 0 ? 0 : boffset[i - 1].total));
                $(menu[i]).css("left", 750 * 0.2 + px($(menu[i]).css("left")) * 0.8);
            }
        }
    } else {
        for (let i = 0; i < menu.length; i++) {
            if ($(menu[i]).attr("class").includes("bline")) {
                let bwidth = px($(menu[i]).css("--bwidth"));
                $(menu[i]).css("left", 775 * 0.2 + px($(menu[i]).css("left")) * 0.8);
                $(menu[i]).css("width", px($(menu[i]).css("width")) * 0.8);
                $(menu[i]).css("top", (i - blindex + 1 - $(menu[i]).css("--bindex")) * 50 + 15 + ($(menu[i]).css("--bindex") == 0 ? 0 : boffset[$(menu[i]).css("--bindex") - 1].total));
            } else if ($(menu[i]).attr("class").includes("bholder")) {
                $(menu[i]).css("top", (i - bhindex + 2) * 50 + 15 + ((i - bhindex) == 0 ? 0 : boffset[i - bhindex - 1].total));
                $(menu[i]).css("height", boffset[i - bhindex].current);
                $(menu[i]).css("left", 875 * 0.2 + px($(menu[i]).css("left")) * 0.8);
            } else {
                $(menu[i]).css("margin-right", px($(menu[i]).css("margin-right")) * 0.8 - 200 * 0.2);
                $(menu[i]).css("margin-top", (i + 1) * 50 + 15 + (i == 0 ? 0 : boffset[i - 1].total));
                $(menu[i]).css("left", 1000 * 0.2 + px($(menu[i]).css("left")) * 0.8);
            }
        }
    }
}

// Set function intervals
// window.setInterval(parallax_height_update, 64);
window.setInterval(menu_update, 13);

// Load menu defaults
function load() {
    // Handle menu setting
    menu = $(".bmenu");
    for (let i = 0; i < menu.length; i++)
        boffset.push({ max: 10, current: 0, total: 0, on: false });
    // 
    for (let i = 0; i < menu.length; i++) {
        if ($(menu[i]).attr("class").includes("bline") && blindex == 0)
            blindex = i;
        else if ($(menu[i]).attr("class").includes("bholder")) {
            if (bhindex == 0)
                bhindex = i;

            for (let j = 0; j < $(menu[i]).children().length; j++)
                $($(menu[i]).children()[j]).css("margin-top", j * 30);

            boffset[i - bhindex].max = $(menu[i]).children().length * 30 + 10;
        } else
            boffset[i].max = $(menu[i]).css("--bsize");
        
    }

    if (night) {
        night = !night; // quickly flip to 'true' and use the function to toggle it on
        toggle_night();
    }
    
}

function menuSelected(i) {
    // i is the index of the menu. Home = 0, Projects = 1, Resources = 2, etc.
    boffset[i].on = !boffset[i].on;
    if (boffset[i].on) {
        $($(".linkpages")[i]).children().addClass("selected");
    } else {
        $($(".linkpages")[i]).children().removeClass("selected");
    }
}

function open_menu() {
    menuOut = !menuOut;
}


/* Poject (".proj") Update  */
function desire(desire, current) {
    if(Math.abs(desire - current) < Math.max(desire, 1) * 0.01)
        return desire - current;
    return ((desire - current) * 0.3);
}

function desires(desire, current, speed) {
    if(Math.abs(desire - current) < Math.max(desire, 1) * 0.01)
        return desire - current;
    return ((desire - current) * speed);
}

function project_update() {
    var projs = document.querySelectorAll(".proj");

    for (var i = 0; i < projs.length; i++) {
        var clientRect = projs[i].parentElement.getBoundingClientRect();
        var link = projs[i].parentElement.parentElement;

        if ((mouseX > clientRect.left && mouseX <= clientRect.right && mouseY > clientRect.top && mouseY <= clientRect.bottom) || $(link).is(':focus')) {
            link.removeAttribute("disabled");
            $(projs[i]).addClass("active"); 
        } else {
            link.setAttribute("disabled", false);
            $(projs[i]).removeClass("active"); 
        }
    }
}

$("document").ready(function() {
    window.setInterval(project_update, 32);
  
    document.addEventListener("mouseup", function(ev) {
        mouseDown = false;
    }, false);

    document.addEventListener("mousedown", function(ev) {
        mouseDown = true;
    }, false);

    document.addEventListener("mousemove", function(ev) {
        mouseX = ev.pageX;
        mouseY = ev.pageY;
    }, false);
});

/* Disableable links */

$("a").on("click", function(event) {
    if ($(this).is("[disabled]")) {
        event.preventDefault();
    }
});

</script>

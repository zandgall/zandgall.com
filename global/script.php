<script type="application/javascript">
function f(x) {
    return parseFloat(x);
}
var cloudToggled = (localStorage["zandgall.cloud"] || "true") === "true";
var layerToggled = (localStorage["zandgall.layer"] || "true") === "true";
let menuout = false;
if (!layerToggled)
    $(".paralayer").css("visibility", "hidden");

function killclouds() {
    if (cloudToggled) {
        $(".cloud").css("visibility", "hidden");
        localStorage["zandgall.cloud"] = "false";
    } else {
        $(".cloud").css("visibility", "visible");
        localStorage["zandgall.cloud"] = "true";
    }
    cloudToggled = !cloudToggled;
}

function killlayers() {
    if (layerToggled) {
        $(".paralayer").css("visibility", "hidden");
        localStorage["zandgall.layer"] = "false";
    } else {
        $(".paralayer").css("visibility", "visible");
        localStorage["zandgall.layer"] = "true";
    }
    layerToggled = !layerToggled;
}

function killstars() {
    localStorage["zandgall.stars"] = (localStorage["zandgall.stars"] || "true") === "false"
}

function togglenight() {
    night = !night;
    if (night) {
        $(".sunmoon").attr("src", "assets/background/Moon.png");
        $(".sunmoon").attr("alt", "( o)")
        $("*").addClass("night");
        $($(".paralayer")[0]).css("background-image", `url("assets/background/bg 2n.png")`);
        $($(".paralayer")[1]).css("background-image", `url("assets/background/bg 1n.png")`);
        $($(".paralayer")[2]).css("background-image", `url("assets/background/bg 0n.png")`);
        $($(".paralayer")[3]).css("background-image", `url("assets/background/BGImgn.png")`);
    } else {
        $(".sunmoon").attr("src", "assets/background/Sun.png");
        $(".sunmoon").attr("alt", "☼");
        $("*").removeClass("night");
        $($(".paralayer")[0]).css("background-image", `url("assets/background/bg 2.png")`);
        $($(".paralayer")[1]).css("background-image", `url("assets/background/bg 1.png")`);
        $($(".paralayer")[2]).css("background-image", `url("assets/background/bg 0.png")`);
        $($(".paralayer")[3]).css("background-image", `url("assets/background/BGImg.png")`);
    }
    document.documentElement.style.setProperty("--night", night ? 1 : 0);
}

function p(str) {
    if (str.endsWith("px"))
        return str.substr(0, str.length - 2);
    else return str;
}

let menu = $(".bmenu");
let blindex = 0,
    bhindex = 0,
    boffset = [];

function parallaxheightupdate() {
    if (document.body.clientWidth >= 850)
        $(".__links__").css("width", "850px");
    else $(".__links__").css("width", "100%");

    $(".__links__").css("left", (document.body.clientWidth - parseInt($(".__links__").css("width"), 10)) / 2);
    $(".parallax__group").css("height", $("#universal")[0].scrollHeight);
    if ($("#universal")[0].scrollHeight > 4644)
        $(".parallaxgradient").css("height", $("#universal")[0].scrollHeight);
    $(".nightoverlay").css("height", $("#universal")[0].scrollHeight * 4);

    if (!cloudToggled)
        return;
    var clouds = $(".paracloud");
    for (var i = 0; i < clouds.length; i++) {
        var rat = 1;
        if ($(clouds[i]).is(".pacl0"))
            rat = 3;
        if ($(clouds[i]).is(".pacl1"))
            rat = 2;
        var trans = $(clouds[i]).css("transform") || $(clouds[i]).css("-webkit-transform") || $(clouds[i]).css("-moz-transform") || $(clouds[i]).css("-mz-transform") || $(clouds[i]).css("-o-transform");
        var mat = (trans.replace(/[^0-9\-.,]/g, '').split(','));
        var x = f(mat[12] || mat[4] || 0) + f($(clouds[i]).data("data-speed"));
        $(clouds[i]).css("transform", "translateX(" + x + "px)");
        $(clouds[i]).css("-webkit-transform", "translateX(" + x + "px)");
        $(clouds[i]).css("-moz-transform", "translateX(" + x + "px)");
        $(clouds[i]).css("-mz-transform", "translateX(" + x + "px)");
        $(clouds[i]).css("-o-transform", "translateX(" + x + "px)");
        if (x > f($("body").width()) * rat - f($(clouds[i]).parent().css("left"))) {
            $(clouds[i]).css("transform", "translateX(-400px)");
            $(clouds[i]).css("top", Math.random() * 1000 * rat);
        }
    }
    lmouseClicked = false;
}

function menuupdate() {
    if (boffset.length == 0)
        load();
    for (let i = 0; i < boffset.length; i++) {

        if (boffset[i].on) {
            boffset[i].current = boffset[i].current * 0.8 + boffset[i].max * 0.2;
        } else {
            boffset[i].current = boffset[i].current * 0.8;
        }

        if (i == 0)
            boffset[i].total = boffset[i].current;
        else boffset[i].total = boffset[i].current + boffset[i - 1].total;
    }
    if (menuout) {
        for (let i = 0; i < menu.length; i++) {
            if ($(menu[i]).attr("class").includes("bline")) {
                let bwidth = p($(menu[i]).css("--bwidth"));
                $(menu[i]).css("left", (775 - bwidth) * 0.2 + p($(menu[i]).css("left")) * 0.8);
                $(menu[i]).css("width", bwidth * 0.2 + p($(menu[i]).css("width")) * 0.8);
                $(menu[i]).css("top", (i - blindex + 1 - $(menu[i]).css("--bindex")) * 55 + 10 + ($(menu[i]).css("--bindex") == 0 ? 0 : boffset[$(menu[i]).css("--bindex") - 1].total));
            } else if ($(menu[i]).attr("class").includes("bholder")) {
                $(menu[i]).css("top", (i - bhindex + 2) * 55 + 10 + ((i - bhindex) == 0 ? 0 : boffset[i - bhindex - 1].total));
                $(menu[i]).css("height", boffset[i - bhindex].current);
                $(menu[i]).css("left", 475 * 0.2 + p($(menu[i]).css("left")) * 0.8);
            } else {
                $(menu[i]).css("margin-right", p($(menu[i]).css("margin-right")) * 0.8 + 5);
                $(menu[i]).css("margin-top", (i + 1) * 55 + 10 + (i == 0 ? 0 : boffset[i - 1].total));
                $(menu[i]).css("left", 750 * 0.2 + p($(menu[i]).css("left")) * 0.8);
            }
        }
    } else {
        for (let i = 0; i < menu.length; i++) {
            if ($(menu[i]).attr("class").includes("bline")) {
                let bwidth = p($(menu[i]).css("--bwidth"));
                $(menu[i]).css("left", 775 * 0.2 + p($(menu[i]).css("left")) * 0.8);
                $(menu[i]).css("width", p($(menu[i]).css("width")) * 0.8);
                $(menu[i]).css("top", (i - blindex + 1 - $(menu[i]).css("--bindex")) * 55 + 10 + ($(menu[i]).css("--bindex") == 0 ? 0 : boffset[$(menu[i]).css("--bindex") - 1].total));
            } else if ($(menu[i]).attr("class").includes("bholder")) {
                $(menu[i]).css("top", (i - bhindex + 2) * 55 + 10 + ((i - bhindex) == 0 ? 0 : boffset[i - bhindex - 1].total));
                $(menu[i]).css("height", boffset[i - bhindex].current);
                $(menu[i]).css("left", 875 * 0.2 + p($(menu[i]).css("left")) * 0.8);
            } else {
                $(menu[i]).css("margin-right", p($(menu[i]).css("margin-right")) * 0.8 - 200 * 0.2);
                $(menu[i]).css("margin-top", (i + 1) * 55 + 10 + (i == 0 ? 0 : boffset[i - 1].total));
                $(menu[i]).css("left", 1000 * 0.2 + p($(menu[i]).css("left")) * 0.8);
            }
        }
    }
}

var clouds = $(".paracloud");
for (var i = 0; i < clouds.length; i++) {
    if (!cloudToggled)
        $(clouds[i]).css("visibility", "hidden");
    var rat = 1;
    if ($(clouds[i]).is(".pacl0"))
        rat = 3;
    if ($(clouds[i]).is(".pacl1"))
        rat = 2;
    var z = Math.random() * 4;

    $(clouds[i]).css("transform", "translateX(" + (Math.random() * f($("body").width()) * rat) + "px)");
    $(clouds[i]).css("-webkit-transform", "translateX(" + (Math.random() * f($("body").width()) * rat) + "px)");
    $(clouds[i]).css("-moz-transform", "translateX(" + (Math.random() * f($("body").width()) * rat) + "px)");
    $(clouds[i]).css("-mz-transform", "translateX(" + (Math.random() * f($("body").width()) * rat) + "px)");
    $(clouds[i]).css("-o-transform", "translateX(" + (Math.random() * f($("body").width()) * rat) + "px)");
    $(clouds[i]).css("top", Math.random() * 1000 * rat);
    $(clouds[i]).data("data-speed", z / 2.0 + 1.5);
}

window.setInterval(parallaxheightupdate, 64);
window.setInterval(menuupdate, 13);

function load() {
    // Handle menu setting
    for (let i = 0; i < /*Set menus*/ 10; i++)
        boffset.push({ max: 10, current: 0, total: 0, on: false });
    menu = $(".bmenu");
    for (let i = 0; i < menu.length; i++) {
        if ($(menu[i]).attr("class").includes("bline")) {
            if (blindex == 0)
                blindex = i;
        } else if ($(menu[i]).attr("class").includes("bholder")) {
            if (bhindex == 0)
                bhindex = i;
            for (let j = 0; j < $(menu[i]).children().length; j++) {
                $($(menu[i]).children()[j]).css("margin-top", j * 40);
            }
            boffset[i - bhindex].max = $(menu[i]).children().length * 40 + 10;
        } else {
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
    if (boffset[i].on) {
        $($(".linkpages")[i]).children().addClass("selected");
    } else {
        $($(".linkpages")[i]).children().removeClass("selected");
    }
}

function openmenu() {
    menuout = !menuout;
}</script>
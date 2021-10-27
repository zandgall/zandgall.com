// @ts-nocheck
var o1 = -150,
    o2 = -50,
    o3 = 100;
var r1 = 8,
    r2 = 4,
    r3 = 1.75,
    r4 = 16;
var s1 = Math.random() + 1,
    s2 = Math.random() + 1,
    s3 = Math.random() + 1,
    s4 = Math.random() + 1;

var stars = [{
    x: -10,
    y: -10,
    w: 1
}];

var cloudImgs = [];

var clouds = [{
    x: -60,
    y: -36,
    t: 1,
    o: 1
}];

var night = false,
    exfx = true,
    layerbackground = false;
var lmenu0 = 20000;

var lmouseX = 0,
    lmouseY = 0;

var canw = {
    width: 0,
    height: 0
};

var lmX = 0,
    lmY = 0;

var lmouseDown = false,
    lmouseLeft = false,
    lmouseRight = false,
    lmouseClicked = false,
    lmouseDBLClicked = false;
var initiated = false;

var layerCan = document.getElementById("BackgroundC");

var ix = 0;
var iy = 30;
var iw = 100;
var is = 20;
var ih = false;

var dx = 0;
var dw = 100;
var ds = 20;
var dh = false;

var nx = 0;
var nw = 100;
var ns = 20;
var nh = false;

var cx = 0;
var cw = 100;
var cs = 20;
var ch = false;

var mx = 0;
var mw = 100;
var ms = 20;
var mh = false;
var img0, img1, img2, img3;

function display() {
    layerCan = document.getElementById("BackgroundC");

    if (clouds.length == 1) {
        canw.width = layerCan.width;
        canw.height = layerCan.height;
        initStars();
        initClouds();
    }

    var c = layerCan.getContext("2d");

    c.canvas.width = window.innerWidth;
    c.canvas.height = window.innerHeight;

    // c.clearRect(0,0,layerCan.width,layerCan.height);

    if (night) {
        c.fillStyle = "rgb(13, 4, 38)";
        c.fillRect(0, 0, layerCan.width, layerCan.height);
        if (exfx)
            for (var i = 0; i < 50; i++) {
                c.fillStyle = "rgba(200, 200, 255, 0.002)";
                c.beginPath();
                c.ellipse(50 * s4 + 18, 80 - scrollY / r4 + 18, i * 4, i * 4, 0, 0, 180, false);
                c.fill();
            }
    }

    if (!img0) {
        img0 = new Image();
        img0.src = "BGImg0.png";
        img1 = new Image();
        img1.src = "BGImg1.png";
        img2 = new Image();
        img2.src = "BGImg2.png";
        img3 = new Image();
    }
    img3.src = "assets/Sun.png";
    if (night) {
        img3.src = "assets/Moon.png";

        c.fillStyle = "rgb(100, 100, 120)";
        for (var i = 0; i < 100; i++) {
            c.fillRect(stars[i].x * layerCan.width, stars[i].y * layerCan.height, stars[i].w, stars[i].w);
        }
    }

    c.drawImage(img3, 50 * s4, 80 - scrollY / r4);

    if (layerbackground) {
        c.drawImage(img0, layerCan.width - 3240 * s1, o1 - scrollY / r1, 6480, 2322);
        c.drawImage(img1, layerCan.width - 3440 * s2, o2 - scrollY / r2, 6880, 2722);
        c.drawImage(img2, layerCan.width - 3640 * s3, o3 - scrollY / r3, 7280, 3122);
        c.drawImage(img0, layerCan.width - 3240 * s1, o1 - scrollY / r1 + 2322, 6480, -2322);
        c.drawImage(img1, layerCan.width - 3440 * s2, o2 - scrollY / r2 + 2722, 6880, -2722);
    }

    if (!night && exfx) {
        for (var i = 0; i < clouds.length; i++) {
            clouds[i].x += (0.001 / clouds[i].o);
            if (clouds[i].x > 1)
                clouds[i].x = -0.1;
            c.drawImage(cloudImgs[clouds[i].t], clouds[i].x * layerCan.width, clouds[i].y * layerCan.height - scrollY / clouds[i].o, 74 - clouds[i].o * 2, 56 - clouds[i].o * 2);
        }
    }

    if (layerbackground)
        c.drawImage(img2, layerCan.width - 3640 * s3, o3 - scrollY / r3 + 3122, 7280, -3122);

    if (night) {
        c.fillStyle = "rgba(15, 8, 33, 0.2)";

        c.fillRect(0, 0, layerCan.width, layerCan.height);

    }
    if (night) {
        c.fillStyle = "rgba(20, 10, 50, " + (scrollY / Math.max(layerCan.height) * 0.1 + 0.2) + ")";
    } else {
        c.fillStyle = "rgba(20, 50, 100, " + (scrollY / Math.max(layerCan.height) * 0.1) + ")";
    }

    c.fillRect(0, 0, layerCan.width, layerCan.height);

    c.font = "20px monospace";

    if (lmouseX > layerCan.width - 100)
        lmenu0 += desire(layerCan.width - 80, lmenu0);
    else lmenu0 += desire(layerCan.width, lmenu0);
    outText(c, "Layers", lmenu0 + 10, 20 - scrollY, "rgba(0, 0, 255, 0.05)", 1, exfx ? "rgba(255, 255, 255, 0.05)" : "rgba(0, 0, 0, 0.05)");
    outText(c, "ExtraFX", lmenu0, 40 - scrollY, "rgba(0, 0, 255, 0.05)", 1, exfx ? "rgba(255, 255, 255, 0.05)" : "rgba(0, 0, 0, 0.05)");

    if (lmouseX > s4 * 50 - 5 && lmouseX < s4 * 50 + 31) {
        if (lmouseY - scrollY > 50 - scrollY / r4 - 5 && lmouseY - scrollY < 80 - scrollY / r4 + 31) {
            c.drawImage(img3, 50 * s4, 80 - scrollY / r4);
            document.body.style.cursor = "pointer";
            if (lmouseClicked) {
                night = !night;
                lmouseClicked = false;
                cssNight();
                display();
            }
        } else {
            document.body.style.cursor = "";
        }
    } else {
        document.body.style.cursor = "";
        if (lmouseX > layerCan.width - 100 && lmouseY < 20) {
            document.body.style.cursor = "pointer";
            outText(c, "Layers", lmenu0 + 10, 20 - scrollY, "rgba(0, 0, 255, 0.59)", 1, layerbackground ? "#ffffff" : "rgba(0,0,0,0)");
            if (lmouseClicked) {
                layerbackground = !layerbackground;
            }
        } else if (lmouseX > layerCan.width - 100 && lmouseY < 40 && lmouseY > 20) {
            document.body.style.cursor = "pointer";
            outText(c, "ExtraFX", lmenu0, 40 - scrollY, "rgba(0, 0, 255, 0.59)", 1, exfx ? "#ffffff" : "rgba(0,0,0,0)");
            if (lmouseClicked) {
                exfx = !exfx;
            }
        }
    }

    lmouseClicked = false;
}

function outText(c, string, x, y, stroke, s, fill) {
    c.fillStyle = stroke;
    c.fillText(string, x - s, y - s);
    c.fillText(string, x, y - s);
    c.fillText(string, x + s, y - s);
    c.fillText(string, x - s, y);
    c.fillText(string, x, y);
    c.fillText(string, x + s, y);
    c.fillText(string, x - s, y + s);
    c.fillText(string, x, y + s);
    c.fillText(string, x + s, y + s);
    c.fillStyle = fill;
    c.fillText(string, x, y);
}

function mesh(a, b, r) {
    var nr = 1.0 - r;
    return a * r + b * nr;
}

function desire(desire, current) {
    return ((desire - current) * 0.3);
}

function desires(desire, current, speed) {
    return ((desire - current) * speed);
}

function proj() {
    var projs = document.querySelectorAll(".proj");

    for (var i = 0; i < projs.length; i++) {
        var r = projs[i].getBoundingClientRect();
        var over = projs[i].querySelector(".projoverlay");
        var img = projs[i].querySelector(".projimg");
        if (night) over.style.background = "#405066";
        else over.style.background = "#8090ee";
        if (over.style.opacity == "")
            over.style.opacity = 0.2;
        if (img.style.border == "")
            img.style.border = "1px solid rgba(75, 175, 220, 0)";

        var w = parseFloat(projs[i].style.width);
        var h = parseFloat(projs[i].style.height);

        if ($(projs[i]).data("defwidth") == undefined) {
            $(projs[i]).data("defwidth", w);
            $(projs[i]).data("defheight", h);
        }

        var l = projs[i].style.marginLeft == "" ? 0 : parseFloat(projs[i].style.marginLeft);
        var ri = projs[i].style.marginRight == "" ? 0 : parseFloat(projs[i].style.marginRight);
        var t = projs[i].style.marginTop == "" ? 0 : parseFloat(projs[i].style.marginTop);
        var b = projs[i].style.marginBottom == "" ? 0 : parseFloat(projs[i].style.marginBottom);
        var c = img.style.borderColor == "" ? "rgba(75,175,220,0.1)" : img.style.borderColor;
        var bo = parseFloat(c.replace(/^rgba?\(|\s+|\)$/g, '').split(',')[3]);
        var ra = img.style.borderRadius == "" ? 1 : parseFloat(img.style.borderRadius);
        var o = parseFloat(over.style.opacity);
        var split = projs[i].querySelector(".splitter");
        var s = parseFloat(split.style.width);
        var so = projs[i].querySelector(".projsubtitle").style.opacity == "" ? 1 : parseFloat(projs[i].querySelector(".projsubtitle").style.opacity);

        if (w > parseFloat($(projs[i]).data("defwidth"))) {
            projs[i].parentElement.removeAttribute("disabled");
        } else {
            projs[i].parentElement.setAttribute("disabled", false);
        }

        if ((lmouseX > r.left - ((l / 100.0) * 800) && lmouseX <= r.left + (((w + l) / 100.0) * 800) && lmouseY > r.top - t + scrollY && lmouseY <= r.bottom + b + scrollY) || $(projs[i].parentElement).is(':focus')) {
            over.style.opacity = o + desire(0, o);
            h += desire(parseFloat($(projs[i]).data("defheight")) * 1.2, h);
            w += desire(parseFloat($(projs[i]).data("defwidth")) * 1.2, w);
            projs[i].style.width = (w) + "%";
            projs[i].style.height = h;
            projs[i].style.marginTop = (parseFloat($(projs[i]).data("defheight")) - h) / 2;
            projs[i].style.marginBottom = (parseFloat($(projs[i]).data("defheight")) - 1 - h) / 2;
            projs[i].style.marginLeft = (parseFloat($(projs[i]).data("defwidth")) - (w)) / 2 + "%";
            projs[i].style.marginRight = (parseFloat($(projs[i]).data("defwidth")) - (w)) / 2 + "%";
            projs[i].querySelector(".projimg").setAttribute("hovered", "true");

            bo += desire(0.1, bo);
            if (night) {
                img.style.borderColor = "rgba(75,175,220," + bo + ")";
            } else {
                img.style.borderColor = "rgba(20,30,60," + bo + ")";
            }
            img.style.borderRadius = (ra + desire(5, ra)) + "px";

            s += desires(75, s, 0.2);
            split.style.width = s + "%";
            var splitMargin = (100 - s) / 2;
            split.style.marginLeft = splitMargin + "%";
            split.style.marginRight = splitMargin + "%";
            so += desires(1, so, 0.1);
            projs[i].querySelector(".projsubtitle").style.opacity = so;

            projs[i].style.zIndex = 10;
            img.style.zIndex = 10;
            over.style.zIndex = 10;
            split.style.zIndex = 10;
            projs[i].querySelector(".projtitle").style.zIndex = 10;
            projs[i].querySelector(".projsubtitle").style.zIndex = 10;
        } else {
            projs[i].querySelector(".projimg").setAttribute("hovered", "false");
            over.style.opacity = o + desire(0.4, o);
            h += desire(parseFloat($(projs[i]).data("defheight")), h);
            w += desire(parseFloat($(projs[i]).data("defwidth")), w);
            projs[i].style.width = (w) + "%";
            projs[i].style.height = h;
            projs[i].style.marginTop = (parseFloat($(projs[i]).data("defheight")) - h) / 2;
            projs[i].style.marginBottom = (parseFloat($(projs[i]).data("defheight")) - 1 - h) / 2;
            projs[i].style.marginLeft = (parseFloat($(projs[i]).data("defwidth")) - (w)) / 2 + "%";
            projs[i].style.marginRight = (parseFloat($(projs[i]).data("defwidth")) - (w)) / 2 + "%";

            bo += desire(0.0, bo);
            if (night) img.style.borderColor = "rgba(75,175,220," + bo + ")";
            else img.style.borderColor = "rgba(175,230,255," + bo + ")";
            s += desires(0, s, 0.1);
            split.style.width = s + "%";
            var splitMargin = (100 - s) / 2;
            split.style.marginLeft = splitMargin + "%";
            split.style.marginRight = splitMargin + "%";
            so += desires(0, so, 0.1);
            projs[i].querySelector(".projsubtitle").style.opacity = so;

            projs[i].style.zIndex = 0;
            img.style.zIndex = 0;
            over.style.zIndex = 0;
            split.style.zIndex = 0;
            projs[i].querySelector(".projtitle").style.zIndex = 0;
            projs[i].querySelector(".projsubtitle").style.zIndex = 0;
            img.style.borderRadius = (ra + desire(0, ra)) + "px";
        }
    }
}

function desirestyle(object, data, value) {
    var s = parseFloat($(object).css(data));
    $(object).css(data, s + desire(value, s));
}

function desiresstyle(object, data, value, speed) {
    var s = parseFloat($(object).css(data));
    $(object).css(data, s + desires(value, s, speed));
}

function link() {
    var links = $(".link");

    for (var i = 0; i < links.length; i++) {
        var width = $(links[i]).width();
        var height = $(links[i]).height();
        var x = $(links[i]).offset().left;
        var y = $(links[i]).offset().top;
        var hovered = lmouseX > x && lmouseX < x + width && lmouseY > y && lmouseY < y + height + 20;

        if (hovered || $(links[i]).is(":focus") || $(links[i]).find(".linkpages").is(":focus")) {
            desirestyle($(links[i]).find(".linkbottom"), "margin-top", 0);
            desirestyle($(links[i]).find(".linktop"), "margin-bottom", 0);
            desirestyle($(links[i]).find(".linktop"), "margin-top", 0);
            desirestyle($(links[i]).find(".linkpages"), "margin-top", 0);
            desiresstyle($(links[i]).find(".linkpages"), "opacity", 1, 0.6);
        } else {
            desirestyle($(links[i]).find(".linkbottom"), "margin-top", -20);
            desirestyle($(links[i]).find(".linktop"), "margin-bottom", -20);
            desirestyle($(links[i]).find(".linktop"), "margin-top", 20);
            desirestyle($(links[i]).find(".linkpages"), "margin-top", -20);
            desiresstyle($(links[i]).find(".linkpages"), "opacity", 0, 0.6);
        }
    }

    window.localStorage['zandgall_dayNight'] = night ? "night" : "day";
}

function ldraw() {
    proj();
    var van = document.getElementById("links");
    var c = van.getContext("2d");
    c.clearRect(0, 0, layerCan.width, layerCan.height);

    c.font = '30px monospace';
    if (night) c.fillStyle = "rgb(149, 177, 222)";
    else c.fillStyle = "rgb(36, 84, 162)";
    iw = c.measureText("Home").width;
    dw = c.measureText("Download").width;
    nw = c.measureText("What's New").width;
    cw = c.measureText("Contact").width;
    mw = c.measureText("Resource").width;

    ix = van.width / 2 - (iw + dw + nw + cw + mw) / 2;
    dx = ix + iw + 10;
    nx = dx + dw + 10;
    cx = nx + nw + 10;
    mx = cx + cw + 10;

    c.fillText("Home", ix, iy + 10);
    c.fillText("Download", dx, iy + 10);
    c.fillText("What's New", nx, iy + 10);
    c.fillText("Contact", cx, iy + 10);
    c.fillText("Resource", mx, iy + 10);

    c.font = '16px monospace';
    if (ih) {
        if (exfx)
            is += desire(55, is);
        else is = 55;

        outText(c, "Homepage", ix, iy + is - 14, "#a6ebff", 1, "#0000ff");
        outText(c, "About", ix, iy + is + 4, "#a6ebff", 1, "#0000ff");

        c.fillStyle = "#ffff00";
        if (lmY > iy + is - 34 && lmY < iy + is - 14)
            c.fillText("Homepage", ix, iy + is - 14);
        else if (lmY > iy + is - 14 && lmY < iy + is + 4)
            c.fillText("About", ix, iy + is + 4);
    } else {
        if (exfx)
            is += desire(30, is);
        else is = 30;
    }
    if (dh) {
        if (exfx)
            ds += desire(55, ds);
        else ds = 55;

        outText(c, "Arvopia", dx, iy + ds - 14, "#a6ebff", 1, "#0000ff");
        outText(c, "LevelCreator", dx, iy + ds + 4, "#a6ebff", 1, "#0000ff");
        outText(c, "Arvopia Builds", dx, iy + ds + 22, "#a6ebff", 1, "#0000ff");
        outText(c, "Other Projects", dx, iy + ds + 40, "#a6ebff", 1, "#0000ff");

        c.fillStyle = "#ffff00";
        if (lmY > iy + ds - 34 && lmY < iy + ds - 14)
            c.fillText("Arvopia", dx, iy + ds - 14);
        else if (lmY > iy + ds - 14 && lmY < iy + ds + 4)
            c.fillText("LevelCreator", dx, iy + ds + 4);
        else if (lmY > iy + ds + 4 && lmY < iy + ds + 22)
            c.fillText("Arvopia Builds", dx, iy + ds + 22);
        else if (lmY > iy + ds + 22 && lmY < iy + ds + 40)
            c.fillText("Other Projects", dx, iy + ds + 40);
    } else {
        if (exfx)
            ds += desire(30, ds);
        else ds = 30;
    }
    if (nh) {
        if (exfx)
            ns += desire(55, ns);
        else ns = 55;

        outText(c, "Teasers", nx, iy + ns - 14, "#a6ebff", 1, "#0000ff");
        outText(c, "Future Plans", nx, iy + ns + 4, "#a6ebff", 1, "#0000ff");
        outText(c, "History", nx, iy + ns + 22, "#a6ebff", 1, "#0000ff");

        c.fillStyle = "#ffff00";
        if (lmY > iy + ns - 34 && lmY < iy + ns - 14)
            c.fillText("Teasers", nx, iy + ns - 14);
        else if (lmY > iy + ns - 14 && lmY < iy + ns + 4)
            c.fillText("Future Plans", nx, iy + ns + 4);
        else if (lmY > iy + ns + 4 && lmY < iy + ns + 22)
            c.fillText("History", nx, iy + ns + 22);
    } else {
        if (exfx)
            ns += desire(30, ns);
        else ns = 30;
    }
    if (ch) {
        if (exfx)
            cs += desire(55, cs);
        else cs = 55;
        outText(c, "Social Media", cx, iy + cs - 14, "#a6ebff", 1, "#0000ff");

        c.fillStyle = "#ffff00";
        if (lmY > iy + cs - 34 && lmY < iy + cs - 14)
            c.fillText("Social Media", cx, iy + cs - 14);
    } else {
        if (exfx)
            cs += desire(30, cs);
        else cs = 30;
    }
    if (mh) {
        if (exfx)
            ms += desire(55, ms);
        else ms = 55;
        outText(c, "Music", mx, iy + ms - 14, "#a6ebff", 1, "#0000ff");
        outText(c, "Fun stuff", mx, iy + ms + 4, "#a6ebff", 1, "#0000ff");
        c.fillStyle = "#ffff00";
        if (lmY > iy + ms - 34 && lmY < iy + ms - 14)
            c.fillText("Music", mx, iy + ms - 14);
        else if (lmY > iy + ms - 14 && lmY < iy + ms + 4)
            c.fillText("Fun stuff", mx, iy + ms + 4);
    } else {
        if (exfx)
            ms += desire(30, ms);
        else ms = 30;
    }

    if ((nh || dh || ih || ch || mh) && lmY > iy + Math.max(ms, cs, ns, is, ds) - 34)
        document.body.style.cursor = "pointer";
    else document.body.style.cursor = document.body.style.cursor;

    c.lineJoin = "round";
    c.lineWidth = 3;

    if (night)
        c.strokeStyle = "rgb(149, 177, 222)";
    else
        c.strokeStyle = "rgb(36, 84, 162)";

    c.strokeRect(ix, iy - is / 2, iw, 0);
    c.strokeRect(ix, iy + is / 2, iw, 0);

    c.strokeRect(dx, iy - ds / 2, dw, 0);
    c.strokeRect(dx, iy + ds / 2, dw, 0);

    c.strokeRect(nx, iy - ns / 2, nw, 0);
    c.strokeRect(nx, iy + ns / 2, nw, 0);

    c.strokeRect(cx, iy - cs / 2, cw, 0);
    c.strokeRect(cx, iy + cs / 2, cw, 0);

    c.strokeRect(mx, iy - ms / 2, mw, 0);
    c.strokeRect(mx, iy + ms / 2, mw, 0);
}

function cssNight() {
    if (night && localStorage["zandgall.stars"] == "false")
        $("#cut").css("background", "transparent");
    else $("#cut").css("background", "url('assets/background/spacebg.png')");
}

function layerInit() {
    initiated = true;
    console.log("Setting up mouse move");
    document.addEventListener("mousemove", lmove, false);
    console.log("Setting up mouse click");
    document.addEventListener("click", lclick, false);
    console.log("Setting up mousedown");
    document.addEventListener("mousedown", lmousedown, false);
    console.log("Setting up mouseup");
    document.addEventListener("mouseup", lmouseup, false);

    console.log("INITIATE");

    // window.setInterval(display, 32);
    window.setInterval(proj, 32);
    window.setInterval(link, 32);
    window.setInterval(cssNight, 32);

    cloudImgs[0] = new Image();
    cloudImgs[0].src = "assets/background/Cloud1.png";
    cloudImgs[1] = new Image();
    cloudImgs[1].src = "assets/background/Cloud2.png";
    cloudImgs[2] = new Image();
    cloudImgs[2].src = "assets/background/Cloud3.png";
    cloudImgs[3] = new Image();
    cloudImgs[3].src = "assets/background/Cloud4.png";
    cssNight();
}

function initStars() {
    for (var i = 0; i < 100; i++) {
        stars[i] = {
            x: Math.random(),
            y: Math.random(),
            w: Math.random() * 3
        };
    }
}

function initClouds() {
    for (var i = 0; i < 20; i++) {
        clouds[i] = {
            x: Math.random(),
            y: Math.random(),
            t: Math.floor(Math.random() * 4),
            o: (20 - i) / 20.0 * 5 + 1
        };
    }
}

function oldLinksMouse() {

    var van = document.getElementById("links");

    lmX = lmouseX - van.offsetLeft;
    lmY = lmouseY - van.offsetTop;


    ih = (lmX >= ix && lmX < ix + iw && lmY > 0 && lmY < is + iy + 4);

    dh = (lmX >= dx && lmX < dx + dw && lmY > 0 && lmY < ds + iy + (dh ? 40 : -ds / 2));

    nh = (lmX >= nx && lmX < nx + nw && lmY > 0 && lmY < ns + iy + (nh ? 22 : -ns / 2));

    ch = (lmX >= cx && lmX < cx + cw && lmY > 0 && lmY < cs + iy - 14);

    mh = (lmX >= mx && lmX < mx + mw && lmY > 0 && lmY < ms + iy + 4);
}

function lmove(ev) {

    var x, y;

    x = ev.pageX;
    y = ev.pageY;

    lmouseX = x;
    lmouseY = y;

    // oldLinksMouse();
}

function lclick(e) {
    // lmouseClicked = true;

    if (ih) {
        if (lmY > iy + is - 14)
            window.location.href = "about.html";
        else if (lmY > iy + is - 34 && lmY < iy + is - 14) window.location.href = "index.html";
    }
    if (dh) {
        if (lmY > iy + ds - 14 && lmY < iy + ds + 4)
            window.location.href = "levelcreatordownload.html";
        else if (lmY > iy + ds + 4 && lmY < iy + ds + 22)
            window.location.href = "arvopiabuilddownload.html";
        else if (lmY > iy + ds - 34 && lmY < iy + ds - 14) window.location.href = "arvopiadownload.html";
        else if (lmY > iy + ds + 22 && lmY < iy + ds + 40) window.location.href = "otherdownload.html";
    }
    if (nh) {
        if (lmY > iy + ns - 14 && lmY < iy + ns + 4)
            window.location.href = "futureplans.html";
        else if (lmY > iy + ns + 4 && lmY < iy + ns + 22)
            window.location.href = "history.html";
        else if (lmY > iy + ns - 34 && lmY < iy + ns - 14) window.location.href = "teasers.html";
    }
    if (ch) {
        if (lmY > iy + cs - 34 && lmY < iy + cs - 14) window.location.href = "socialmedia.html";
    }
    if (mh) {
        if (lmY > iy + ms - 34 && lmY < iy + ms - 14)
            window.location.href = "music.html";
        else if (lmY > iy + ms - 14 && lmY < iy + ms + 4)
            window.location.href = "funstuff.html";
    }
}

function lmousedown(ev) {
    lmouseDown = true;
}

function lmouseup(ev) {
    lmouseDown = false;
    lmouseClicked = false;
}

function set(no1, no2, no3, nr1, nr2, nr3) {
    o1 = no1;
    o2 = no2;
    o3 = no3;
    r1 = nr1;
    r2 = nr2;
    r3 = nr3;
}

$("document").ready(function() {
    console.log("Supposedly initiating");
    layerInit();
    cssNight();
});

$("a").on("click", function(event) {
    if ($(this).is("[disabled]")) {
        event.preventDefault();
    }
});
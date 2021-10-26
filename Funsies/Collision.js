// @ts-nocheck

var colCan = document.getElementById("Canvas");

var mouseDown = false,
    mouseLeft = false,
    mouseRight = false,
    mouseClicked = false,
    mouseDBLClicked = false;

var keyTyped=false, keyPressed=false;
var keys = [false];

var colMouseX, colMouseY;

function init() {
    document.addEventListener("mousemove", on_mousemove, false);
    document.addEventListener("click", on_click, false);
    document.addEventListener("dblclick", dblClick, false);
    document.addEventListener("mousedown", mousedown, false);
    document.addEventListener("mouseup", mouseup, false);

    document.addEventListener("keydown", keyDown, false);
    document.addEventListener("keyup", keyUp, false);

    window.setInterval(colDraw, 100);
    console.log("INITIATE");
}

var vecList = []; 


var l = new Shape(vecList);
var particle = new Vec(200, 200);

let ll = function(x1, y1, x2, y2, x3, y3, x4, y4) {

    // calculate the direction of the lines
    let uA = ((x4-x3)*(y1-y3) - (y4-y3)*(x1-x3)) / ((y4-y3)*(x2-x1) - (x4-x3)*(y2-y1));
    let uB = ((x2-x1)*(y1-y3) - (y2-y1)*(x1-x3)) / ((y4-y3)*(x2-x1) - (x4-x3)*(y2-y1));

    // if uA and uB are between 0-1, lines are colliding
    if (uA >= 0 && uA <= 1 && uB >= 0 && uB <= 1) {
      return true;
    }
    return false;
}

let lb = function(x1, y1, x2, y2, x, y, w, h) {
    return ll(x1, y1, x2, y2, x, y, x+w, y) || ll(x1, y1, x2, y2, x+w, y, x+w, y) || ll(x1, y1, x2, y2, x, y+h, x+w, y+h) || ll(x1, y1, x2, y2, x, y, x, y+h);
}

function colDraw() {
    var c = colCan.getContext("2d");
    
    c.clearRect(0, 0, colCan.width, colCan.height);
    var mouseX = colMouseX;
    var mouseY = colMouseY;

    c.lineWidth = 1;
    c.strokeStyle=rgba(0,0,0,1);

    c.strokeRect(100, 100, 50, 50);

    c.beginPath();
    c.moveTo(0, 100);
    c.lineTo(mouseX, mouseY);
    if(lb(0, 100, mouseX, mouseY, 100, 100, 50, 50))
        c.strokeStyle="#00ff00";
    else c.strokeStyle="#ff0000";
    c.stroke();

    return;
    if(mouseLeft)
        new Vec(mouseX, mouseY).drawPos(c, "rgba(255, 0, 0, 0.5)");
    //DO STUFF HERE
    var s = new Shape(vecList);
    c.lineWidth = 1;
    s.close();
    c.strokeStyle = rgba(0, 0, 0, 0.5);
    c.fillStyle=rgba(0, 255, 0, 0.1);
    if(s.isInside(new Vec(mouseX, mouseY)))
        c.fillStyle=rgba(255, 0, 0, 0.1);
    s.fill(c);
    s.stroke(c);

    if(keys[32]) {
        var n = window.performance.now();
        l = s.createConvexHull();
        console.log("Convex hull took: ", (window.performance.now()-n));
        l.close();
    }

    if(keys[78]) {
        var n = window.performance.now();
        s.isInside(new Vec(mouseX, mouseY));
        console.log("Test detection: ", (window.performance.now()-n));
    }
    if(keys[77]) {
        particle = new Vec(mouseX, mouseY);
    }
    c.fillStyle=rgba(0, 0, 255, 0.1);
    // l.close();
    l.fill(c);
    l.stroke(c);

    c.fillStyle = rgb(255, 0, 0);
    s.markVertices(c, 4);
    c.lineWidth = 10;
    s.center.drawPos(c, "#ff00ff", 4, "center");

    s.furthest.drawPos(c, "#0000ff", 4, "furthest");

    new Vec(mouseX-particle.x, mouseY-particle.y).draw(c, particle.x, particle.y, rgba(0, 255, 255, 0.5));
    
    if(s.isInside(new Vec(mouseX, mouseY))) {
        var e = s.closestEdgeIndex(particle);
        var e0 = s.points[s.edges[e][0]];
        var e1 = s.points[s.edges[e][1]];
        var con = getLineIntersection(new Vec(mouseX, mouseY), particle, e0, e1);
        console.log(con.x, con.y);
        con.drawPos(c, "#ffffff", 10, "");
    }
    
    var max = AREATIME + BARYCENTRICTIME + SAMESIDETIME;
    // c.fillText(Math.floor((AREATIME / max) * 1000) / 10 + "%", 20, 400);
    
    c.fillText(AREATIME, 20, 400);
    
    c.fillText(BARYCENTRICTIME, 20, 410);
    // c.fillText(Math.floor((BARYCENTRICTIME / max) * 1000) / 10 + "%", 20, 410);
    
    c.fillText(Math.floor((SAMESIDETIME / max) * 1000) / 10 + "%", 20, 420);

    mouseClicked = false;
    mouseDBLClicked = false;
}

function rgb(r, g, b) {
    return "rgb(" + Math.min(Math.max(r, 0), 255) + ", " + Math.min(Math.max(g, 0), 255) + ", " + Math.min(Math.max(b, 0), 255) + ")";
}

function rgba(r, g, b, a) {
    return "rgba(" + Math.min(Math.max(r, 0), 255) + ", " + Math.min(Math.max(g, 0), 255) + ", " + Math.min(Math.max(b, 0), 255) + ", " + Math.min(Math.max(a, 0), 255) + ")";
}

function dist(x1, y1, x2, y2) {
    return Math.sqrt(Math.pow(x2 - x1, 2) + Math.pow(y2 - y1, 2));
}

function col(x1, y1, w1, h1, x2, y2, w2, h2) {
    var b1 = (x1 + w1 > x2);
    var b2 = (x1 < x2 + w2);
    var b3 = (y1 + h1 > y2);
    var b4 = (y1 < y2 + h2);
    return b1 && b2 && b3 && b4;
}

function move(ev) {
    var x, y;

    var posX = colCan.getBoundingClientRect().left; 
    var posY = colCan.getBoundingClientRect().top; 
    
    // posX=can.offsetLeft;
    // posY=can.offsetTop;
    
    x = ev.pageX-posX;
    y = ev.pageY-posY;

    colMouseX = x;
    colMouseY = y;
}

function click(e) {
    console.log(colMouseX, colMouseY, e.button);
    if(e.button==0) {
        vecList.push(new Vec(colMouseX, colMouseY));
    }
    mouseClicked = true;
}


function dblClick(e) {
    mouseDBLClicked = true;
}

function on_mousemove(ev) {
    move(ev);
}


function mousedown(ev) {
    mouseDown = true;
    if(ev.button==0)
        mouseLeft = true;
    else mouseRight = true;
}


function mouseup(ev) {
    mouseDown = false;
    mouseClicked = false;

    if(ev.button==0)
        mouseLeft = false;
    else mouseRight = false;
}

function on_click(e) {
    click(e);
}

function keyDown(e) {
    console.log("Key pressed: ", e.key, e.keyCode);
    keys[e.keyCode] = true;
    keyPressed = true;
    currentKey = e.key;
}

function keyUp(e) {
    keys[e.keyCode] = false;
    keyPressed = false;
}


$("document").ready(new function () {
    init();
    colDraw();
});
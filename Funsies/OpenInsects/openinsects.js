// @ts-nocheck
var can = document.getElementById("Canvas");

var mouseDown = false, mouseLeft = false, mouseRight=false, mouseClicked = false, mouseDBLClicked = false;
var mouseX = 0, mouseY = 0;

var keyTyped=false, keyPressed=false;
var keys = [false], currentKey = "w";

var kode = {
    arrowright: false,
    arrowleft: false,
    arrowup: false,
    arrowdown: false,
    a: false,
    d: false,
    s: false,
    w: false,
    space: false,

    set: function() {
        kode.arrowright=keys[39];
        kode.arrowleft=keys[37];
        kode.arrowup=keys[38];
        kode.arrowdown=keys[40];

        kode.w=keys[87];
        kode.a=keys[65];
        kode.s=keys[83];
        kode.d=keys[68];
        kode.space=keys[32];
    }
}

function init() {
    document.addEventListener("mousemove", on_mousemove, false);
    document.addEventListener("click", on_click, false);
    document.addEventListener("dblclick", dblClick, false);
    document.addEventListener("mousedown", mousedown, false);
    document.addEventListener("mouseup", mouseup, false);

    document.addEventListener("keydown", keyDown, false);
    document.addEventListener("keyup", keyUp, false);

    window.setInterval(draw, 16);
    console.log("INITIATE");

    var type = types[Math.floor(Math.random()*types.length)];
    setupinsects(10, 14, 6, type);
}

function setupinsects(number, size, sizevariation, type) {
  insects = [];
  for(var i = 0; i<number; i++) {
    insects[i] = new insect(Math.random()*window.innerWidth, Math.random()*window.innerHeight, Math.random()*sizevariation + size, type);
  }
}

var types = ["fly", "moth", "mantis", "ladybug", "bee"];
var insects = [];

function draw(){

    var c = can.getContext("2d");

    c.canvas.width  = window.innerWidth;
    c.canvas.height = window.innerHeight;

    c.clearRect(0, 0, can.width, can.height);

    //DO STUFF HERE
    kode.set();
    for(var i = 0; i<insects.length; i++) {
        insects[i].tick(insects);
        insects[i].render(c);
    }

    mouseClicked=false;
    mouseDBLClicked=false;
}

function rgb(r, g, b){
    return "rgb("+Math.min(Math.max(r, 0), 255)+", "+Math.min(Math.max(g, 0), 255)+", "+Math.min(Math.max(b, 0), 255)+")";
}

function rgba(r, g, b, a){
    return "rgba("+Math.min(Math.max(r, 0), 255)+", "+Math.min(Math.max(g, 0), 255)+", "+Math.min(Math.max(b, 0), 255)+", "+Math.min(Math.max(a, 0), 255)+")";
}

function dist(x1, y1, x2, y2) {
    return Math.sqrt(Math.pow(x2-x1, 2)+Math.pow(y2-y1, 2));
}

function col(x1, y1, w1, h1, x2, y2, w2, h2) {
    var b1 = (x1+w1>x2);
    var b2 = (x1<x2+w2);
    var b3 = (y1+h1>y2);
    var b4 = (y1<y2+h2);
    return b1 && b2 && b3 && b4;
}

function move(ev) {
    var x, y;

    x = ev.pageX-can.offsetLeft;
    y = ev.pageY-can.offsetTop;

    mouseX=x;
    mouseY=y;
}
function click(e) {
    console.log(mouseX, mouseY, e.button);

    mouseClicked=true;
}
function dblClick(e) {
    mouseDBLClicked=true;
}
function on_mousemove(ev) {
    move(ev);
}
function mousedown(ev) {
    mouseDown=true;
}
function mouseup(ev){
    mouseDown=false;
    mouseClicked=false;
}
function on_click(e) {
    click(e);
}
function keyDown(e) {
    console.log("Key pressed: ", e.key, e.keyCode)
    keys[e.keyCode]=true;
    keyPressed=true;
    currentKey=e.key;
}
function keyUp(e) {
    keys[e.keyCode]=false;
    keyPressed=false;
}

$("document").ready(new function(){
    init();
    draw();
});

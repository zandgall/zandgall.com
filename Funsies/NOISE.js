// @ts-nocheck
var perlin = document.getElementById("Perlin");

var mouseDown = false, mouseLeft = false, mouseRight=false, mouseClicked = false, mouseDBLClicked = false;

var keyTyped=false, keyPressed=false;
var keys = [false], currentKey = "w";

//var path = new PATHS(100);
//path.smooth();
//path.smooth();

var zOff = 0;

//var path2d = new SINENOISE(1, 100, 100);
//path2d.smooth();
//path2d.smooth();

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
    
    window.setInterval(draw, 100);
    console.log("INITIATE");
}

function draw(){
    
    var c = perlin.getContext("2d");
    
    c.clearRect(0, 0, perlin.width, perlin.height);
    
    c.beginPath();
    c.moveTo(0, 200);
    for(var i = 0; i<100; i++) {
        c.lineTo(i*10, noise1(i/10)*100+200);
    }
    c.strokeStyle="#ff0000";
    c.stroke();
    c.closePath();
    
    for(var x = 0; x<100; x++) {
        for(var y = 0; y<100; y++) {
//            c.fillStyle=rgb(path2d.array[x][y]*255,path2d.array[x][y]*255,path2d.array[x][y]*255);
            var v = (noise3(x /16, y/16, zOff)+0.25);
//            console.log(v); 
            var a = 0.4*(noise3(x/8, y/8, zOff)+0.25);
            var b = 0.25*(noise3(x/4, y/4, zOff)+0.25);
            var c1 = 0.1*(noise3(x/2, y/2, zOff)+0.25);
            v=v+a+b+c1;
            
            c.fillStyle=rgba(255, 255, 255, 0.8-v); 
            c.fillRect(x*2, y*2+400, 2, 2); 
//            c.fillStyle=rgba(255, 255, 100, 0.4-v);
//            c.fillRect(x*2, y*2+400, 2, 2);
//            c.fillStyle=rgba(20, 150, 50, 0.02-v);
//            c.fillRect(x*2, y*2+400, 2, 2);
//            
//            c.fillStyle=rgba(255, 255, 255, v); 
//            c.fillRect(x*2, y*2+600, 2, 2);
            
        }
    }
    
    zOff+=0.1;
    
    //DO STUFF HERE
    kode.set();
    
    mouseClicked=false;
    mouseDBLClicked=false;
}

function drawPerlin() {
    var c = perlin.getContext("2d");
    
    c.clearRect(0, 0, can.width, can.height);
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
                    
    x = ev.pageX-perlin.offsetLeft;
    y = ev.pageY-perlin.offsetTop;
    
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

window.onload = function() {
    init();
    draw();
}
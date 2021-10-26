// @ts-nocheck
var can = document.getElementById("Canvas");

var mouseDown = false, mouseLeft = false, mouseRight=false, mouseClicked = false, mouseDBLClicked = false;

var keyTyped=false, keyPressed=false;
var keys = [false], currentKey = "w";

var spikesu = [0, 100, 300, 600, 1000];
var spikesd = [0, 100, 300, 600, 1000];

var spikesur = [100, 200, 300, 400, 500];
var spikesdr = [100, 200, 300, 400, 500];

var score = 0;

var coin = {
    x: 0,
    y: 0,
    
    tick: function() {
        if(collide(coin.x, coin.y, 20, 30, player.x, player.y, size, size)) {
            score++;
            coin.x=Math.random()*can.width;
            coin.y=Math.random()*can.height;
        }
    }
}

function drawCoin(c) {
    var grd = c.createLinearGradient(coin.x, coin.y, coin.x, coin.y+30);
    grd.addColorStop(0, "#aaaa00");
    grd.addColorStop(1, "#333300");
    c.fillStyle=grd;
    
    c.beginPath();
    c.ellipse(coin.x+10, coin.y+15, 20, 30, 0, 0, 180, false);
    c.fill();
}

var life = {
    x: 0,
    y: 0,
    
    tick: function() {
        if(collide(life.x, life.y, 30, 30, player.x, player.y, size, size)) {
            player.health++;
            life.x=Math.random()*can.width;
            life.y=Math.random()*can.height;
        }
    }
}

function drawLife(c) {
    var grd = c.createLinearGradient(life.x, life.y, life.x, life.y+30);
    grd.addColorStop(0, "#cc0000");
    grd.addColorStop(1, "#aa0000");
    c.fillStyle=grd;
    
    c.fillRect(life.x, life.y, 30, 30);
}

var ticks = 0, speed = 0;
var size = can.width/10, soff = 0;

var kode = {
    arrowright: false,
    arrowleft: false,
    arrowup: false,
    arrowdown: false,
    a: false,
    d: false,
    s: false,
    w: false,
    
    set: function() {
        kode.arrowright=keys[39];
        kode.arrowleft=keys[37];
        kode.arrowup=keys[38];
        kode.arrowdown=keys[40];
        
        kode.w=keys[87];
        kode.a=keys[65];
        kode.s=keys[83];
        kode.d=keys[68];
    }
}

var player = {
    
    x: 0,
    y: 0,
    
    health: 3,
    regen: 300,
    
    xMove:0,
    yMove:0,
    
    ydirection:0,
    xdirection:0,
    
    tick: function() {
        var x = player.x;
        var y = player.y;
        var xMove = player.xMove;
        var yMove = player.yMove;
        var ydirection = player.ydirection;
        var xdirection = player.xdirection;
        
        player.regen--;
        player.regen=Math.max(0, player.regen);
        
        if(kode.arrowup){
            yMove-=0.5+speed/50;
        } else if(kode.arrowdown){ 
            yMove+=0.5+speed/50;
        }
        if(kode.arrowleft){
            xMove-=0.5+speed/50;
        } else if(kode.arrowright){ 
            xMove+=0.5+speed/50;
        }
        
        if(y>can.height-size){
            yMove=0;
            y=can.height-size;
        }
        if(y<0){
            yMove=0;
            y=0;
        }
        if(x>can.width-size){
            xMove=0;
            x=can.width-size;
        }
        if(x<0){
            xMove=0;
            x=0;
        }
        
        if(player.health==0) {
            window.alert("GAME OVER");
            window.location.reload();
        }
        
        yMove*=0.9;
        xMove*=0.9;
        
        yMove=Math.max(Math.min(yMove, 10*(1+speed/100)), -10*(1+speed/100));
        xMove=Math.max(Math.min(xMove, 10*(1+speed/100)), -10*(1+speed/100));
        
        y+=yMove;
        x+=xMove;
        player.setLocal(x, y, xMove, yMove, ydirection, xdirection);
    },
    
    setLocal: function(x, y, xMove, yMove, ydirection, xdirection) {
//        console.log(x, y, xMove, yMove, ydirection, xdirection);
        player.y=y;
        player.x=x;
        player.yMove=yMove;
        player.xMove=xMove;
        player.ydirection=ydirection;
        player.xdirection=xdirection;
    },
    
    harm: function() {
        if(player.regen<=0) {
            player.health--;
            player.regen=300-speed/20;
        }
    }
    
}

function drawSpike(x, y, d, c) {
    var grd = c.createLinearGradient(x, y, x, y+size*d);
    grd.addColorStop(0, "#aaaaaa");
    grd.addColorStop(1, "#333333");
    var grd1 = c.createLinearGradient(x, y, x, y+size*d);
    grd1.addColorStop(0, "#888888");
    grd1.addColorStop(1, "#000000");
    c.fillStyle=grd;
    c.strokeStyle=grd1;
    c.beginPath();
    c.moveTo(x, y+size*d);
    c.lineTo(x+size/2, y);
    c.lineTo(x+size, y+size*d);
    c.lineTo(x, y+size*d);
    c.fill();
    c.stroke();
    
    if(d==1)
        if(collide(x, y, size, size, player.x, player.y, size, size)) {
            console.log("KILL HIM!!!");
            player.harm();
        }
    if(d==-1)
        if(collide(x, y-size, size, size, player.x, player.y, size, size)) {
            console.log("KILL HIM!!!");
            player.harm();
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
    
    window.setInterval(draw, 1000/60);
    console.log("INITIATE");
}

function draw(){
    
    
    ticks++;
    speed+=0.01;
    soff+=0.01;
    
    size = can.width/10-soff;
    
    var c = can.getContext("2d");
    
    c.canvas.width  = window.innerWidth;
    c.canvas.height = window.innerHeight;
    
    c.clearRect(0, 0, can.width, can.height);
    
    //DO STUFF HERE
    kode.set();
    
    console.log(speed, player.xMove, player.yMove);
    
    player.tick();
    coin.tick();
    life.tick();
    ren(c);
    drawCoin(c);
    drawLife(c);
    var out = size*(1+speed/10);
    for(var i = 0; i<5; i++) {
        if(Math.sin(spikesur[i] + ticks/(100-Math.min(speed, 99)))>0.5)
            spikesu[i]=Math.random()*can.width;
        drawSpike(spikesu[i],size-Math.sin(spikesur[i] + ticks/(100-Math.min(speed, 99)))*out-out/2,-1,c);
        if(Math.sin(spikesdr[i] + ticks/(100-Math.min(speed, 99)))>0.5)
            spikesd[i]=Math.random()*can.width;
        drawSpike(spikesd[i],can.height+Math.sin(spikesdr[i] + ticks/(100-Math.min(speed, 99)))*out-out/2,1,c);
    }
    c.fillStyle="#ff0000";
    c.fillRect(200, 200, 40, 40);
    
    mouseClicked=false;
    mouseDBLClicked=false;
}

function ren(c) {
    var grd = c.createLinearGradient(player.x, player.y, player.x, player.y+size);
    grd.addColorStop(0, "#0aafff");
    grd.addColorStop(1, "#001aff");
    c.fillStyle=grd;
    if(player.regen<=0 || player.regen%10>5)
        c.fillRect(player.x, player.y, size, size);
    
    c.fillStyle="#ff0000";
    for(var i = 0; i<player.health; i++){
        c.fillRect(10+i*40, can.height-40, 30, 30);
    }
    
    c.fillRect(0, 0, score, 20);
    c.fillText(score, score+10, 10, 100);
}

function collide(x1, y1, width1, height1, x2, y2, width2, height2) {
    var b1 = (x1+width1>x2);
    var b2 = (x1<x2+width2);
    var b3 = (y1+height1>y2);
    var b4 = (y1<y2+height2);
//    console.log(b1, b2, b3, b4);
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

window.onload = function() {
    init();
    draw();
}
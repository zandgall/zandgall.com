// @ts-nocheck
var can = document.getElementById("Canvas");

var mouseDown = false, mouseLeft = false, mouseRight=false, mouseClicked = false, mouseDBLClicked = false;

var bmouseX = 0, bmouseY=0;

var round = 0;

var towersmenuview = false;

var TOWERPLACE = -1;

var towersmenu = new CannonMenus(["Spinning Sprayer", "Sniper"],["", ""], [200, 500]);

var DIRECTIONSALPHA = 3;

var cannon0s = [];
var cannon1s = [];

var pathSkeleton = [
    {x:-60, y:-60},
    {x:200, y:40},
    {x:240, y:240},
    {x:240, y:400},
    {x:440, y:440},
    {x:770, y:770},
];

var path = [
    {x:-40, y:-60},
    {x:-40, y:-60},
    {x:20, y:40},
    {x:60, y:540},
    {x:100, y:600},
    {x:200, y:540},
    {x:140, y:400},
    {x:250, y:400},
    {x:500, y:10},
    {x:560, y:50},
    {x:500, y:430},
    {x:370, y:570},
    {x:625, y:550},
    {x:700, y:600},
    {x:770, y:770},
];

function chopCornersOfPath() {
    for(var i = 0; i<path.length; i++) {
        pathSkeleton[i]=path[i];
    }
    var index = 0;
    for(var i = 0; i<pathSkeleton.length-1; i++) {
        var a = pathSkeleton[i].x;
        var b = pathSkeleton[i+1].x;

        var y = pathSkeleton[i].y;
        var z = pathSkeleton[i+1].y;

        var Qx = a*(3/4)+b*(1/4);
        var Qy = y*(3/4)+z*(1/4);
        
        var Rx = a*(1/4)+b*(3/4);
        var Ry = y*(1/4)+z*(3/4);
        
//        if((Qx>0&&Qy>0)||(Rx>0&&Ry>0)){
            path[index]={x:Qx, y:Qy};
            index++;
            path[index]={x:Rx, y:Ry};
            index++;
//        }
    }
    path[index]={x:pathSkeleton[pathSkeleton.length-1].x, y:pathSkeleton[pathSkeleton.length-1].y}
}

var enemies = [
];

resetupEnemies();

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
    c: false,
    
    set: function() {
        kode.arrowright=keys[39];
        kode.arrowleft=keys[37];
        kode.arrowup=keys[38]; 
        kode.arrowdown=keys[40];
        
        kode.w=keys[87];
        kode.a=keys[65];
        kode.s=keys[83];
        kode.d=keys[68];

	    kode.space=keys[32] || (mouseClicked && (bmouseX<can.width-290 || CURRENTMENU==null));
        
        kode.c = keys[67];
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
    for(var i =0; i<3; i++) {
        chopCornersOfPath();
    }
}

function draw(){
    can = document.getElementById("Canvas");
    var c = can.getContext("2d");
    
    if(power<0) {
        alert("GAME OVER");
        power = 100000;
    }
        
    if(power==100000){
        window.location.reload();
        return;
    }
    
    c.clearRect(0, 0, can.width, can.height);
    
    //DO STUFF HERE
    kode.set();
    
    c.fillStyle="#0affa0";
    c.fillRect(0, 0, can.width, can.height);
    
    c.beginPath();
    c.strokeStyle="#f8e596";
    c.lineWidth=20;
    c.lineJoin="round";
    c.moveTo(path[0].x, path[1].y);
    for(var i = 0; i<path.length; i++) {
        c.strokeStyle="#f8e596";
        c.lineTo(path[i].x, path[i].y);
    }
    c.stroke();
    
    if(kode.space) {
        towersmenu.setOn(col(bmouseX, bmouseY, 10, 10, 450, can.height-30, 100, 30));
    }
    
    var i = towersmenu.tick();
    if(i!=-1) {
        TOWERPLACE = i;
    }
    
    if(kode.space) {
        if(TOWERPLACE!=-1){
            switch(TOWERPLACE) {
                case 0:
                    cannon0s[cannon0s.length] = new Cannon0(bmouseX, bmouseY);
                    TOWERPLACE=-1;
                    money-=200;
                    break;
                case 1:
                    cannon1s[cannon1s.length] = new Cannon1(bmouseX, bmouseY);
                    TOWERPLACE=-1;
                    money-=500;
                    break;
            }
        }
    }
    
    if(towersmenu.on)
        towersmenu.render(c);
    
    bcptick(bmouseX, bmouseY);
    bcpren(c);
    
    for(var i = 0; i<cannon0s.length; i++) {
        cannon0s[i].tick();
        cannon0s[i].ren(c);
    }
    for(var i = 0; i<cannon1s.length; i++) {
        cannon1s[i].tick();
        cannon1s[i].ren(c);
    }
    
    var done = true;
    
    for(var i = 0; i<enemies.length; i++) {
        if(enemies[i]!=null &&enemies[i].life>0) {
            done=false;
            enemies[i].tick();
            enemies[i].render(c);
            if(enemies[i].life<0) {
                enemies[i]=null;
            }
            if(enemies[i].reachedPos()) {
                if(enemies[i].destId==path.length) {
                    power-=enemies[i].life; 
                    enemies[i]=null;
                } else 
                    enemies[i].setDest(path[enemies[i].destId].x, path[enemies[i].destId].y);
            }
        }
    }
    
    
    
    if(done){
        round++;
        resetupEnemies();
    }
    
    c.strokeStyle="#999999";
    c.fillStyle="#aaaaaa";
    c.fillRect(450, can.height-40, 100, 30);
    c.strokeRect(450, can.height-40, 100, 30);
    c.fillStyle="#000000";
    c.textAlign="center";
    c.fillText("Towers", 500, can.height-20, 100);
    
    c.textAlign="left";
    c.fillStyle=rgba(0, 0, 0, DIRECTIONSALPHA);
    c.fillText("To upgrade, press space with the mouse over yourself or another tower", 10, 30, 1000);
    c.fillText("WASD", 10, 50, 1000);
    c.fillText("Mouse to aim and shoot", 10, 70, 1000);

    
    DIRECTIONSALPHA-=0.05;
    
    mouseClicked=false;
    mouseDBLClicked=false;
}

function resetupEnemies() {
    if(round<ROUNDATA.length) {
        var index = 0;
        for(var r = 0; r<ROUNDATA[round].length; r++) {
            for(var i = 0; i<ROUNDATA[round][r]; i++) {
                enemies[index]=new Enemy(-40, -30, INDEXDATA[round][r]);
                enemies[index].x=path[0].x*((i+1)+r*enemies[index].speed);
                enemies[index].y=path[0].y*((i+1)+r*enemies[index].speed);
                enemies[index].setDest(path[1].x, path[1].y);
                index++;
            }
        }
    } else {
        round=0;
        alert("YOU WON!");
    }
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
    
    var posX = can.getBoundingClientRect().left; 
    var posY = can.getBoundingClientRect().top; 
    
    // posX=can.offsetLeft;
    // posY=can.offsetTop;
    
    x = ev.pageX-posX;
    y = ev.pageY-posY;
    
    bmouseX=x;
    bmouseY=y;
}
function click(e) {
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
var starcan = document.getElementById("Canvas");

var mouseDown = false, mouseLeft = false, mouseRight=false, mouseClicked = false, mouseDBLClicked = false;

var keyTyped=false, keyPressed=false;
var keys = [false], currentKey = "w";

// @ts-ignore
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
    shift: false,
    
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
        kode.shift=keys[16];
    }
}

var time = 0.1;

var scale = 10, offX=0, offY=0, scaleVel = 0, offXVel = 0, offYVel = 0;

// @ts-ignore
class Vector {
    constructor(x, y, z, velocity){
        this.x=x*velocity;
        this.y=y*velocity;
        this.z=z*velocity;
        this.velocity=velocity;
    }
    
    add(vec) {
        this.x+=vec.x;
        this.y+=vec.y;
        this.z+=vec.z;
    }
    
    sub(vec) {
        this.x-=vec.x;
        this.y-=vec.y;
        this.z-=vec.z;
    }
}

class Star {
    
    constructor(x, y, originX, originY, speed, color, glows, size, glow) {
        this.oriX=originX;
        this.oriY=originY;
        
        var d = dist(x, y, originX, originY);
        if(d==0)
            d=1;
        this.d=d;
        // @ts-ignore
        this.vec = new Vector((y-originY)/d, (x-originX)/d, 0, 10);
        // @ts-ignore
        this.pos = new Vector(x, y, 0, 1);
        this.x=x;
        this.y=y;
        
        this.speed = speed;
        this.color=color;
        this.size=size;
        this.glows=glows;
        this.glow=glow;
    }
    
    tick() {
        // @ts-ignore
        this.pos.add(new Vector(this.vec.x, this.vec.y, this.vec.z, time));
        var d = dist(this.pos.x, this.pos.y, this.oriX, this.oriY);
        if(d==0)
            d=1;
        // @ts-ignore
        var pull = new Vector((this.pos.x-this.oriX)/d, (this.pos.y-this.oriY)/d, 0, this.speed*time);
        this.vec.sub(pull);
    }
    
    renderGlow(c){
        c.fillStyle=this.color+(this.glow<10 ? "0" : "")+this.glow;
        for(var y = 1; y<20; y++){
            c.beginPath();
            var x = (this.pos.x)*scale;
            var k = (this.pos.y)*scale;
            c.ellipse(x, k, y, y, 0, 0, 360, false);
            if(this.glows){
                c.ellipse(x, k, Math.pow(y, 2), (20-y)/2, 0, 0, 360, false);
                c.ellipse(x, k, 20-y, Math.pow(y, 2)/2, 0, 0, 360, false);
            }
            c.closePath();
            c.fill();
        }
    }
    
    render(c) {        
        c.fillStyle=this.color;
        c.beginPath();
        c.ellipse(this.pos.x, this.pos.y, this.size, this.size, 0, 0, 360, false);
        c.closePath();
        c.fill();
    }
}

var star;

function init() {
    document.addEventListener("keydown", keyDown, false);
    document.addEventListener("keyup", keyUp, false);
    
    window.setInterval(draw, 16);
    console.log("INITIATE");
    
    star = [];
    star.push(new Star(0, 0, 0, 0, 0, "#ffc607", true, 0.86434, 5));
    star.push(new Star(36, 0, 0, 0, 100/36, "#ddceac", false, 1.003032, 2));
    star.push(new Star(67, 0, 0, 0, 100/67, "#ebd39c", false, 1.007521, 3));
    star.push(new Star(93, 0, 0, 0, 100/93, "#3affa4", false, 1.007926, 1));
    star.push(new Star(117, 0, 0, 0, 100/117, "#f03e08", false, 1.004221, 2));
    star.push(new Star(208, 0, 0, 0, 100/208, "#f59e67", false, 1.088846, 2));
}

function draw(){
    
    // @ts-ignore
    var c = starcan.getContext("2d");
    
    // @ts-ignore
    c.canvas.width  = starcan.width;
    // @ts-ignore
    c.canvas.height = starcan.height;
    
    // @ts-ignore
    c.clearRect(0, 0, starcan.width, starcan.height);
    
    c.fillStyle="#000000";
    // @ts-ignore
    c.fillRect(0, 0, starcan.width, starcan.height);
    
    //DO STUFF HERE
    kode.set();

    console.log(scale);
    
    if(kode.arrowup||kode.w){
        if(kode.shift){
            scaleVel+=Math.min(0.001*scale, 1);
        }else{
            offYVel+=scale/10;
        }
    } else if(kode.arrowdown||kode.s){
        if(kode.shift){
            scaleVel-=Math.min(0.001*scale, 1);
        }else{
            offYVel-=scale/10;
        }
    }
    
    scale = Math.max(scale+scaleVel, 0.01);
    
    if(kode.arrowright||kode.d){
        offXVel-=scale/10;
    } else if(kode.arrowleft||kode.a){
        offXVel+=scale/10;
    }
    
    offY+=offYVel;
    offX+=offXVel;

    offYVel*=0.8;
    offXVel*=0.8;
    scaleVel*=0.8;
    
    // @ts-ignore
    c.translate(starcan.width/2+offX, starcan.height/2+offY);
    
    for(var s =0; s<star.length; s++)
        star[s].renderGlow(c);
    c.scale(scale, scale);
    for(var s =0; s<star.length; s++)
        star[s].tick();
    
    for(var s =0; s<star.length; s++)
        star[s].render(c);
    
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

// @ts-ignore
$("document").ready(new function(){
    init();
    draw();
});
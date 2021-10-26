var tankimage;
var x = 200, y = 200;
var mouseAngle = 0;

var keys = [];

function setup() {
    const canvas = createCanvas(850, 750);
    canvas.parent("canvasDiv");
    tankimage = loadImage("nat/game 1/tank.png");
}

function keyPressed() {
    keys[keyCode] = true;
}

function keyReleased() {
    keys[keyCode] = false;
}

function draw() {
    background(11, 219, 35);
    if(keys[65]) {
        x-=2;
    }
    if(keys[68]) {
        x+=2;
    }
    if(keys[83]) {
        y+=2;
    }
    if(keys[87]) {
        y-=2;
    }
    
    stroke(0);
    
    strokeWeight(5);
    
    fill(185, 201, 237);
    
    rect(680, 100, 200, 100);
    textSize(20);
    text("faster bullet 150$", 690, 150);
          
    stroke(185, 201, 237);
    
    strokeWeight(5)
   
    stroke(255, 200, 100);
    
    strokeWeight(50);
    
    line(400, 0, 100, 150);
    line(100, 150, 400, 300);
    line(400, 300, 600, 100);
    line(600, 100, 650, 350);
    line(650, 350, 400, 500);
    line(400, 500, 100, 350);
    line(100, 350, 100, 500);
    line(100, 500, 700, 700);
    line(700, 700, 0, 700);
    
    mouseAngle = Math.atan2(y-mouseY, x-mouseX);
    push();
    translate(x, y);
    rotate(mouseAngle-3.14159265/2);
    image(tankimage, -40, -40, 80, 80);
    pop();
}
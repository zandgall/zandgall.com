// @ts-nocheck
var mouseX = 0, mouseY = 0;
var can = document.getElementById("Canvas");

var boids = [];

function init() {
    for(let i = 0; i<100; i++) {
        boids.push(new boid());
    }

    window.addEventListener("mousemove", (e) => {
        bc_mouseX = e.clientX;
        bc_mouseY = e.clientY;
    });

    window.setInterval(draw, 13);
}

function draw() {
    var c = can.getContext("2d");
    
    c.canvas.width  = window.innerWidth;
    c.canvas.height = window.innerHeight;
    
    c.clearRect(0, 0, can.width, can.height);

    c.beginPath();
    // c.ellipse(mouseX, mouseY, 100, 100, 0, 0, 2*Math.PI);
    c.fill();

    for(let b of boids) {
        b.update(boids);
        b.draw(c);
    }
}


$("document").ready(new function(){
    init();
    draw();
});
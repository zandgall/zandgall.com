//@ts-nocheck
// const Victor = require("../victor");
class boid {
    constructor() {
        // Consts
        this.maxForce = 0.2;
        this.maxSpeed = 2;

        // Movement
        this.position = new Victor(Math.random()*document.body.clientWidth, Math.random()*document.body.clientHeight);
        this.velocity = new Victor(Math.random()-0.5, Math.random()-0.5);
        this.velocity.normalize().multiplyScalar(this.maxSpeed);
        this.acceleration = new Victor(0, 0);
    }

    /**
     * 
     * @param {boid[]} boids 
     */
    update(boids) {
        let matchedVelocity = new Victor(0, 0);
        let center = new Victor(0, 0);
        let avoid = new Victor(0, 0);
        let count = 0, acount = 0;
        for(let b of boids) {
            if(b!=this && this.position.distance(b.position)<100){
                matchedVelocity.add(b.velocity);
                center.add(b.position);
                if(this.position.distance(b.position)<50) {
                    let nVoid = b.position.clone();
                    nVoid.subtract(this.position).invert();//.multiplyScalar(1 - this.position.distance(b.position)/50.0);
                    avoid.add(nVoid);
                    acount++;
                }
                count++;
            }
        }

        if(count>0) {
            matchedVelocity.divideScalar(count).normalize().multiplyScalar(this.maxSpeed).subtract(this.velocity).normalize().multiplyScalar(this.maxForce);

            center.divideScalar(count).subtract(this.position).normalize().multiplyScalar(this.maxSpeed).subtract(this.velocity).normalize().multiplyScalar(this.maxForce);
            if(acount>0)
                avoid.divideScalar(acount).normalize().multiplyScalar(this.maxSpeed).subtract(this.velocity).normalize().multiplyScalar(this.maxForce);
        }
        this.acceleration = new Victor(0, 0);
        this.acceleration.add(matchedVelocity.multiplyScalar(0.125));
        this.acceleration.add(center.multiplyScalar(0.07125));
        this.acceleration.add(avoid.multiplyScalar(0.25));
        if(this.position.distance({x:mouseX, y:mouseY})<100) {
            // let angleTo = Math.atan2(this.position.y-mouseY, this.position.x-mouseX);
            // let nAngleP = (this.velocity.horizontalAngle()-(angleTo+Math.PI/2) + Math.PI)%(2*Math.PI) - Math.PI;
            // nAngleP += (nAngleP < -Math.PI ? Math.PI*2 : 0);
            // let nAngleN = (this.velocity.horizontalAngle()-(angleTo-Math.PI/2) + Math.PI)%(2*Math.PI) - Math.PI;
            // nAngleN += (nAngleN < -Math.PI ? Math.PI*2 : 0);
            // let nAngle = 0;
            // if(nAngleP<nAngleN)
            //     nAngle = nAngleP;
            // else nAngle = nAngleN;

            // if(this.position.clone().add(new Victor(Math.cos(nAngle), Math.sin(nAngle))).distance({x:mouseX, y:mouseY})<this.position.clone().add(this.velocity).distance({x:mouseX, y:mouseY}))
            //     this.velocity.add(new Victor(Math.cos(nAngle), Math.sin(nAngle)));
        }
        this.position.add(this.velocity);
        this.velocity.add(this.acceleration);
        // if(this.velocity.magnitude() > this.maxSpeed)
        this.velocity.normalize().multiplyScalar(this.maxSpeed);

        this.position.x = (this.position.x < 0 ? this.position.x + can.width : this.position.x%can.width);
        this.position.y = (this.position.y < 0 ? this.position.y + can.height : this.position.y%can.height);
    }

    /**
     * 
     * @param {CanvasRenderingContext2D} c 
     */
    draw(c) {
        c.fillStyle = "#ff0000";
        // c.fillRect(this.position.x, this.position.y, 8, 8);

        c.save();

        c.translate(this.position.x, this.position.y);
        c.rotate(Math.atan2(this.velocity.y, this.velocity.x));

        c.beginPath();
        c.moveTo(-30, -15);
        c.lineTo(0, 0);
        c.lineTo(-30, 15);
        c.lineTo(-20, 0);
        c.fill();

        c.restore();
    }
}
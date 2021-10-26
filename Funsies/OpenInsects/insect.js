
// @ts-nocheck
class insect {

  constructor(x, y, size, type) {

    this.still = new Image();
    this.still.src = "Funsies/OpenInsects/"+type+"0.png?"+new Date().getTime();
    this.fly = new Image();
    this.fly.src = "Funsies/OpenInsects/"+type+"1.png?"+new Date().getTime();
    this.maxSpeed = 4;
    this.type = type;
    this.angle = Math.random()*Math.PI*2;
    this.xv = Math.cos(this.angle)*this.maxSpeed;
    this.yv = Math.sin(this.angle)*this.maxSpeed;
    this.x=x;
    this.y=y;
    this.size =0.002*size;

    this.i=0;
    this.chased = false;

    this.flying = false;

  }

  defaultAiMove() {
    
    // Move 10 times as if you're taking 10 steps;
    if(this.i<10) {
      // Turn slightly 50% of the time. In the range of -+ 0.2 radians
      this.angle+=(Math.random()-0.5)*0.4 * (Math.random()>0.5);
      
      // Move in the angle you're facing
      this.xv+=Math.cos(this.angle);
      this.yv+=Math.sin(this.angle);
      this.x += this.xv;
      this.y += this.yv;
      this.xv*=0.8;
      this.yv*=0.8;

      // Screen wrap
      this.x%=can.width+50;
      this.y%=can.height+50;
      this.x += can.width * (this.x<-50);
      this.y += can.height * (this.y<-50);

      // Step increment
      this.i++;
    } else if(Math.random()<0.02)
      this.i=0;

    // Switch to flying every 0.1% of the time
    this.flying = (Math.random()<0.001);
  }

  flyAiMove() {
    // Turn slightly 50% of the time. In the range of -+ 0.2 radians
    this.angle+=(Math.random()-0.5)*0.4 * (Math.random()>0.5);

    // Move in the angle you're facing
    this.xv+=Math.cos(this.angle);
    this.yv+=Math.sin(this.angle);
    this.x += this.xv;
    this.y += this.yv;
    this.xv*=0.8;
    this.yv*=0.8;

    

    // Index increment
    this.i++;

    // Switch out of flying mode 1% of the time
    this.flying = (Math.random()<0.99);
  }

  runAiMove() {
    this.angle = Math.atan2(mouseY - this.y, mouseX - this.x)+Math.PI;
    // Move in the angle you're facing
    this.xv+=Math.cos(this.angle);
    this.yv+=Math.sin(this.angle);
    this.x += this.xv;
    this.y += this.yv;
    this.xv*=0.8;
    this.yv*=0.8;
  }

  /**
   * 
   * @param {insect[]} insects 
   */
  tick(insects) {
    if((mouseX-this.x)*(mouseX-this.x)+(mouseY-this.y)*(mouseY-this.y)<(this.chased ? 10000 : 2500)){
      this.chased = true;
      this.flying = true;
      this.runAiMove();
    } else {
      this.chased = false;
      if(this.flying) {
        this.flyAiMove();
      } else {
        this.defaultAiMove();
      }
    }
    this.x = (this.x < 0 ? this.x + can.width : this.x%can.width);
    this.y = (this.y < 0 ? this.y + can.height : this.y%can.height);
    return;
  }
  /**
   * 
   * @param {CanvasRenderingContext2D} c 
   */
  render(c) {
    let image = this.still;
    if((this.chased||this.flying))
      image = this.fly;
    c.save();
    c.translate(this.x, this.y);
    c.rotate(this.angle);
    c.drawImage(image, -image.width*this.size, -image.height*this.size, image.width*this.size, image.height*this.size);
    c.restore();
  }

}

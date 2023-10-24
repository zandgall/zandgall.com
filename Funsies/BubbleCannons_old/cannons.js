
class Cannon0 {
    constructor(x, y) {
        this.x=x;
        this.y=y;
        this.rotation=0;
        this.bullets = [{x:0, y:0, t:0, d:0, l:-1, s:10, cr:200, cg:170, cb:170, dead:1, respawning: true}];
        this.bulletAmmount = 2;
        this.rotationSpeed=1;
        
        this.circleR=30;
        this.circleG=80;
        this.circleB=250;
        
        this.scopeR=200;
        this.scopeG=170;
        this.scopeB=170;
        
        this.size=30;
        
        this.level = 0;
        
        this.upgrader=new UpgradeMenu(["Slow and Steady", "Fire it all!", "No spacing", "100%"], ["","","",""], [100, 250, 500, 1000]);
        
        this.bulletSpace = 20;
    }
    
    tick() {
        this.rotation+=this.rotationSpeed;
        
        if(this.level>=3) {
            for(var i = 0; i<this.bulletAmmount; i++) {
                if(this.bullets[i]==null)
                    this.bullets[i]={x:0, y:0, t:0, d:0, l:-1, s:10, cr:200, cg:170, cb:170, dead:1, respawning: true};
                if(this.bullets[i+1]==null)
                    this.bullets[i+1]={x:0, y:0, t:0, d:0, l:-1, s:10, cr:200, cg:170, cb:170, dead:1, respawning: true};

                    if(this.bullets[i].l<0 && this.bullets[i+1].l<0 && this.bulletSpace<0) {
                        if(i%2==0) {
                            this.bullets[i].x=this.x+Math.cos(this.rotation)*30;
                            this.bullets[i].y=this.y+Math.sin(this.rotation)*30;
                            this.bullets[i].l=20;
                            this.bullets[i].d=this.rotation;
                            this.bullets[i].respawning=false;
                            this.bullets[i].dead=-1;
                            this.bullets[i].s=10;
                            this.bullets[i].t=1;

                            this.bulletSpace=20;
                        } else {
                            this.bullets[i].x=this.x-Math.cos(this.rotation)*30;
                            this.bullets[i].y=this.y-Math.sin(this.rotation)*30;
                            this.bullets[i].l=20;
                            this.bullets[i].d=this.rotation+Math.PI;
                            this.bullets[i].respawning=false;
                            this.bullets[i].dead=-1;
                            this.bullets[i].s=10;
                            this.bullets[i].t=1;
                        }
                    }
                
                tickBullet(this.bullets[i]);
                
                this.bulletSpace--;
            
            }
        } else {
            for(var i = 0; i<this.bulletAmmount; i++) {
                if(this.bullets[i]==null)
                    this.bullets[i]={x:0, y:0, t:0, d:0, l:-1, s:10, cr:200, cg:170, cb:170, dead:1, respawning: true};

                if(this.bullets[i].l<0&& this.bulletSpace<0) {
                    this.bullets[i].x=this.x+Math.cos(this.rotation)*30;
                    this.bullets[i].y=this.y+Math.sin(this.rotation)*30;
                    this.bullets[i].l=20;
                    this.bullets[i].d=this.rotation;
                    this.bullets[i].respawning=false;
                    this.bullets[i].dead=1;
                    this.bullets[i].s=10;
                    this.bullets[i].t=1;
                    this.bulletSpace=10;
                }


                tickBullet(this.bullets[i]);
                this.bulletSpace--;
            }
        }
        
        
        if(kode.space)this.upgrader.setOn(col(this.x, this.y, this.size, this.size, bmouseX, bmouseY, 10, 10));
        
        if(this.upgrader.on) {
            this.upgrade();
        }
        
    }
    
    upgrade() {
        if(this.upgrader.tick()) {
            this.level++;
            money-=this.upgrader.values[this.upgrader.finished-1];
            switch(this.level){
                case 1:
                    this.bulletAmmount = 4;
                    this.rotationSpeed=0.5;

                    this.circleR=30;
                    this.circleG=250;
                    this.circleB=250;

                    this.scopeR=200;
                    this.scopeG=170;
                    this.scopeB=170;

                    this.size=30;
                    break;
                case 2:
                    this.bulletAmmount = 8;
                    this.rotationSpeed=0.5;

                    this.circleR=30;
                    this.circleG=250;
                    this.circleB=250;

                    this.scopeR=200;
                    this.scopeG=170;
                    this.scopeB=170;

                    this.size=30;
                    break;
                case 3:
                    this.bulletAmmount = 16;
                    this.bulletLife=20;
                    this.bulletSpeed=20;

                    this.circleR=30;
                    this.circleG=250;
                    this.circleB=250;

                    this.scopeR=200;
                    this.scopeG=100;
                    this.scopeB=255;

                    this.size=30;
                    break;
                case 4:
                    this.bulletAmmount = 55;
                    this.bulletSpace=30;
                    this.bulletLife=20;
                    this.bulletSpeed=20;

                    this.circleR=255;
                    this.circleG=50;
                    this.circleB=50;

                    this.scopeR=200;
                    this.scopeG=100;
                    this.scopeB=255;

                    this.size=30;
                    break;
                             }
        }
    }
    
    ren(c) {
        
         //Set gradients for use
        var circleGradient = c.createRadialGradient(0, 0, 1, 0, 0, this.size);
        circleGradient.addColorStop(0, rgb(this.circleR, this.circleG, this.circleB));
        circleGradient.addColorStop(1, rgb(this.circleR*0.6, this.circleG*0.6, this.circleB*0.6));

        var scopeGradient = c.createLinearGradient(0, -this.size/4, 0, this.size/4);
        scopeGradient.addColorStop(0, rgb(this.scopeR*0.5, this.scopeG*0.5, this.scopeB*0.5));
        scopeGradient.addColorStop(0.5, rgb(this.scopeR, this.scopeG, this.scopeB));
        scopeGradient.addColorStop(1, rgb(this.scopeR*0.5, this.scopeG*0.5, this.scopeB*0.5));

        c.save();
        c.beginPath();

        c.translate(this.x, this.y);
        c.rotate(this.rotation);
        
        //Draw Scope
        c.beginPath();
        c.fillStyle=scopeGradient;
        if(this.level>=3) {
            c.rect(-this.size, -this.size/4, this.size*2, this.size/2);
        } else {
            c.rect(this.size/4, -this.size/4, this.size, this.size/2);
        }
        c.fill();

        //Draw Hump
        c.beginPath();
        c.fillStyle=circleGradient;
        c.ellipse(0, 0, this.size/2, this.size/2, 0, 0, 180, false);
        c.strokeStyle="#555555";
        
        c.fill();

        c.restore();
        
        for(var i = 0; i<this.bulletAmmount; i++) {
            renderBullet(this.bullets[i], c);
        }
        
        if(this.upgrader.on) {
            this.upgrader.render(c);
        }
    }
}

class Cannon1 {
    constructor(x, y) {
        this.x=x;
        this.y=y;
        this.rotation=0;
        this.bullets = [{x:0, y:0, t:0, d:0, l:-1, s:10, cr:200, cg:170, cb:170, dead:1, respawning: true}];
        this.bulletAmmount = 1;
        this.bulletLife=20;
        this.bulletSpeed=5;
        this.bulletEfficiency=1;
        
        
        this.circleR=30;
        this.circleG=200;
        this.circleB=250;
        
        this.scopeR=200;
        this.scopeG=170;
        this.scopeB=170;
        
        this.size=30;
        
        this.level = 0;
        
        this.upgrader=new UpgradeMenu(["Faster is better", "Power Shot", "Predictor", "Rapid Fire"], ["","","",""], [100, 250, 500, 1000]);
        
        this.bulletSpace = 20;
    }
    
    tick() {
        var cancel = true;
        
        for(var i = 0; i<this.bulletAmmount; i++) {
            if(this.bullets[i]==null)
                this.bullets[i]={x:0, y:0, t:0, d:0, l:-1, s:10, cr:200, cg:170, cb:170, dead:1, respawning: true};

            if(this.bullets[i].l<0&& this.bulletSpace<0) { 
                for(var a = 0; a<enemies.length; a++) {
                    if(enemies[a]!=null && dist(enemies[a].x, enemies[a].y, this.x, this.y)<this.bulletLife*this.bulletSpeed*2){
                        if(this.level<=2) {
                            this.rotation=Math.atan2(enemies[a].y-this.y, enemies[a].x-this.x);
                        }
                        cancel=false;
                        break;
                    }
                }
                if(!cancel) {
                    this.bullets[i].x=this.x+Math.cos(this.rotation)*30;
                    this.bullets[i].y=this.y+Math.sin(this.rotation)*30;
                    this.bullets[i].l=this.bulletLife;
                    this.bullets[i].d=this.rotation;
                    this.bullets[i].respawning=false;
                    this.bullets[i].dead=this.bulletEfficiency;
                    this.bullets[i].s=this.bulletSpeed;
                    this.bullets[i].t=1;
                    this.bulletSpace=10;
                }
            }

            tickBullet(this.bullets[i]);
            this.bulletSpace--;
        }
        
        
        if(kode.space)this.upgrader.setOn(col(this.x, this.y, this.size, this.size, bmouseX, bmouseY, 10, 10));
        
        if(this.upgrader.on) {
            this.upgrade();
        }
        
    }
    
    upgrade() {
        if(this.upgrader.tick()) {
            this.level++;
            money-=this.upgrader.values[this.upgrader.finished-1];
            switch(this.level){
                case 1:
                    this.bulletAmmount = 1;
                    this.bulletLife=10;
                    this.bulletSpeed=20;
                    
                    this.circleR=30;
                    this.circleG=250;
                    this.circleB=100;

                    this.scopeR=200;
                    this.scopeG=170;
                    this.scopeB=170;

                    this.size=30;
                    break;
                case 2:
                    this.bulletAmmount = 3;
                    this.bulletLife=10;
                    this.bulletSpeed=25;
                    this.bulletEfficiency=2;
                    
                    this.circleR=30;
                    this.circleG=250;
                    this.circleB=100;

                    this.scopeR=180;
                    this.scopeG=70;
                    this.scopeB=250;

                    this.size=30;
                    break;
                case 3:
                    this.bulletAmmount = 4;
                    this.bulletLife=10;
                    this.bulletSpeed=25;
                    this.bulletEfficiency=2;

                    this.circleR=30;
                    this.circleG=150;
                    this.circleB=50;

                    this.scopeR=180;
                    this.scopeG=70;
                    this.scopeB=250;

                    this.size=30;
                    break;
                case 4:
                    this.bulletAmmount = 16;
                    this.bulletLife=5;
                    this.bulletSpeed=30;
                    this.bulletEfficiency=2;

                    this.circleR=30;
                    this.circleG=150;
                    this.circleB=100;

                    this.scopeR=255;
                    this.scopeG=70;
                    this.scopeB=50;

                    this.size=40;
                    break;
                             }
        }
    }
    
    ren(c) {
        
         //Set gradients for use
        var circleGradient = c.createRadialGradient(0, 0, 1, 0, 0, this.size);
        circleGradient.addColorStop(0, rgb(this.circleR, this.circleG, this.circleB));
        circleGradient.addColorStop(1, rgb(this.circleR*0.6, this.circleG*0.6, this.circleB*0.6));

        var scopeGradient = c.createLinearGradient(0, -this.size/6, 0, this.size/6);
        scopeGradient.addColorStop(0, rgb(this.scopeR*0.5, this.scopeG*0.5, this.scopeB*0.5));
        scopeGradient.addColorStop(0.5, rgb(this.scopeR, this.scopeG, this.scopeB));
        scopeGradient.addColorStop(1, rgb(this.scopeR*0.5, this.scopeG*0.5, this.scopeB*0.5));

        c.save();
        c.beginPath();

        c.translate(this.x, this.y);
        c.rotate(this.rotation);
        
        //Draw Scope
        c.beginPath();
        c.fillStyle=scopeGradient;
        c.rect(this.size/4, -this.size/6, this.size, this.size/3);
        c.fill();

        //Draw Hump
        c.beginPath();
        c.fillStyle=circleGradient;
        c.ellipse(0, 0, this.size/2, this.size/2, 0, 0, 180, false);
        c.strokeStyle="#555555";
        
        c.fill();

        c.restore();
        
        for(var i = 0; i<this.bulletAmmount; i++) {
            renderBullet(this.bullets[i], c);
        }
        
        if(this.upgrader.on) {
            this.upgrader.render(c);
        }
    }
}


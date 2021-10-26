class Enemy {
    
    constructor(xpos, ypos, type) {
        this.type=type;
        
        this.enemybullets = [{x:0, y:0, t:0, d:0, l:-1, s:10, cr:200, cg:170, cb:170, dead:1, respawning: true}];
        
        this.x=xpos;
        this.y=ypos;
        
        this.xMove=0;
        this.yMove=0;
        
        this.type=type;
        
        this.size=30;
        this.rotation=0;
        
        this.destId=0;
        
        this.life=1;
        this.maxLife = 1;
        
        this.speed=2;
        
        this.bulletTimer = 0;
        
        this.circleR=255;
        this.circleG=60;
        this.circleB=20;
        
        this.scopeR=200;
        this.scopeG=170;
        this.scopeB=170;
        
        if(type==1){
            this.circleR=255;
            this.circleG=60;
            this.circleB=20;
            
            this.scopeR=200;
            this.scopeG=170;
            this.scopeB=170;
        }
        if(type==2){
            this.circleR=255;
            this.circleG=200;
            this.circleB=20;
            
            this.size=40;
            
            this.scopeR=200;
            this.scopeG=170;
            this.scopeB=170;
            
            this.life=2;
            this.maxLife = 2;
            this.speed=4;
        }
        if(type==3){
            this.circleR=80;
            this.circleG=255;
            this.circleB=20;
            
            this.size=30;
            
            this.scopeR=200;
            this.scopeG=170;
            this.scopeB=170;
            
            this.life=4;
            this.maxLife = 4;
            this.speed=3.5;
            this.bulletTimer=10;
        }
        if(type==4){
            this.circleR=80;
            this.circleG=255;
            this.circleB=200;
            
            this.size=20;
            
            this.scopeR=170;
            this.scopeG=80;
            this.scopeB=250;
            
            this.life=3;
            this.maxLife = 3;
            this.speed=6;
            this.bulletTimer=10;
        }
        if(type==5){
            this.circleR=200;
            this.circleG=200;
            this.circleB=200;
            
            this.size=50;
            
            this.scopeR=200;
            this.scopeG=170;
            this.scopeB=170;
            
            this.life=20;
            this.maxLife = 20;
            this.speed=5;
            this.bulletTimer=10;
        }
        if(type==6){
            this.circleR=180;
            this.circleG=255;
            this.circleB=20;
            
            this.size=35;
            
            this.scopeR=200;
            this.scopeG=170;
            this.scopeB=170;
            
            this.life=5;
            this.maxLife = 5;
            this.speed=4;
            this.bulletTimer=10;
        }
        if(type==7){
            this.circleR=200;
            this.circleG=200;
            this.circleB=200;
            
            this.size=50;
            
            this.scopeR=200;
            this.scopeG=170;
            this.scopeB=170;
            
            this.life=20;
            this.maxLife = 25;
            this.speed=4;
            this.bulletTimer=10;
        }
    }
    
    setDest(destX, destY) {
        this.destX=destX;
        this.destY=destY;
        this.destId++;
    }
    
    tick() {
        var angle = (Math.atan2(this.destY - this.y, this.destX - this.x )+this.rotation)/2;
        if(this.type==3 || this.type==6)
            angle = (Math.atan2(this.destY - this.y, this.destX - this.x ));
        this.rotation = angle;
        
//        console.log(this.destX, this.destY, angle);
        
        this.xMove = Math.cos(this.rotation)*(this.speed*(this.life/this.maxLife)+1.5);
        this.yMove = Math.sin(this.rotation)*(this.speed*(this.life/this.maxLife)+1.5);
        
        if(this.type==7 && this.life<=bulletEfficeincy){
            this.life=-1;
            for(var i = 0; i<5; i++) {
                enemies[enemies.length]=new Enemy(this.x+this.xMove*i*4, this.y+this.yMove*i*4, 4);
                enemies[enemies.length-1].setDest(this.destX, this.destY);
                enemies[enemies.length-1].destId=this.destId;
            }
        }
        if(this.x>0&&this.y>0){
            if(this.type==3){
                this.rotation = Math.atan2(y-this.y, x-this.x);
                for(var i = 0; i<1; i++) {
                    if(this.enemybullets[i].l<=0){
                        this.enemybullets[i].x=this.x+Math.cos(this.rotation)*(this.size-2);
                        this.enemybullets[i].y=this.y+Math.sin(this.rotation)*(this.size-2);
                        this.enemybullets[i].d=this.rotation;
                        this.enemybullets[i].l=45;
                        this.enemybullets[i].s=10;
                        this.enemybullets[i].dead=1;
                        this.enemybullets[i].respawning=false;
                        this.enemybullets[i].t=1;
                    }
                    tickEnemyBullet(this.enemybullets[i]);
                }
                this.bulletTimer--;
            } else if(this.type==6){
                this.rotation = Math.atan2(y-this.y, x-this.x);
                for(var i = 0; i<3; i++) {
                    if(this.enemybullets[i]==null)
                        this.enemybullets[i]={x:0, y:0, t:0, d:0, l:-1, s:10, cr:200, cg:170, cb:170, dead:1, respawning: true};
                    if(this.enemybullets[i].l<=0 && this.bulletTimer<0){
                        this.enemybullets[i].x=this.x+Math.cos(this.rotation)*(this.size-2);
                        this.enemybullets[i].y=this.y+Math.sin(this.rotation)*(this.size-2);
                        this.enemybullets[i].d=this.rotation;
                        this.enemybullets[i].l=45;
                        this.enemybullets[i].s=20;
                        this.enemybullets[i].dead=2;
                        this.enemybullets[i].respawning=false;
                        this.enemybullets[i].t=2;
                        this.bulletTimer=3;
                    }
                    tickEnemyBullet(this.enemybullets[i]);
                }
                this.bulletTimer--;
            }
        }
        
        if(!this.reachedPos()) {
            this.x+=this.xMove;
            this.y+=this.yMove;
        }
        
        
    }
    
    render(c) {
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
        c.rect(this.size/4, -this.size/4, this.size, this.size/2);
        c.fill();

        //Draw Hump
        c.beginPath();
        c.fillStyle=circleGradient;
        c.ellipse(0, 0, this.size/2, this.size/2, 0, 0, 180, false);
        c.strokeStyle="#555555";
        if(this.type==3 || this.type==6){
            c.stroke();
        }
        c.fill();

        c.restore();
        
        if(this.type==3)
            for(var i = 0; i<1; i++) {
                renderBullet(this.enemybullets[i], c);
            }
        else if(this.type==6)
            for(var i = 0; i<3; i++) {
                if(this.enemybullets[i]==null)
                        this.enemybullets[i]={x:0, y:0, t:0, d:0, l:-1, s:10, cr:200, cg:170, cb:170, dead:1, respawning: true};
                renderBullet(this.enemybullets[i], c);
            }
    }
    
    reachedPos() {
//        console.log(Math.abs(this.x-this.destX)<=10, Math.abs(this.y-this.destY)<=10, this.x, this.y, this.destX, this.destY);
        return Math.abs(this.x-this.destX)<=10 && Math.abs(this.y-this.destY)<=10;
    }
}















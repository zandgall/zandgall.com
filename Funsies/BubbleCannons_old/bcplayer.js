// @ts-nocheck

var x = 200;
var y = 200;

var xMove=0;
var yMove=0;
var speed = 1;
var friction = 0.8;

var rotation = 0;
var preRot = 0;

var level = 0;

var squareR = 255;
var squareG = 20;
var squareB = 20;

var circleR = 255;
var circleG = 230;
var circleB = 20;

var scopeR = 200;
var scopeG = 170;
var scopeB = 170;

var size = 30;

var money = 0;

var power = 100;

var playerupgrader = new UpgradeMenu(["Speedier", "Plasma Gun", "Power Barrel", "Laser"], ["Speeds up your character as well as reload time", "Strengthens and extends bullet life", "Adds a power attachment to your barrel", "Switches from bullets to laser"], [100, 200, 400, 1500]); 

var maxBullets = 1, bulletLives=20,bulletSpeed=10, bulletEfficeincy = 1; 
var bullets = [{x:0, y:0, t:0, d:0, l:-1, s:10, cr:200, cg:170, cb:170, dead:1, respawning: true}]; 

function bcptick() {
    if(kode.w){
        yMove-=speed;
    } else if(kode.s){
        yMove+=speed;
    }
    if(kode.a) {
        xMove-=speed;
    } else if(kode.d) {
        xMove+=speed;
    }
        
    x+=xMove;
    y+=yMove;
    yMove*=friction;
    xMove*=friction;
    
    if(mouseClicked){
        for(var i = 0; i<maxBullets; i++){
            if(bullets[i]==null)
                bullets[i]={x:0, y:0, t:0, d:0, l:-1, s:10, cr:200, cg:170, cb:170};
            if(bullets[i].l<0){
                bullets[i].x=x+Math.cos(rotation)*(size-2);
                bullets[i].y=y+Math.sin(rotation)*(size-2);
                bullets[i].d=rotation;
                bullets[i].l=bulletLives;
                bullets[i].s=bulletSpeed;
                bullets[i].dead=bulletEfficeincy;
                bullets[i].respawning=false;
                bullets[i].t=level;
                break;
            }
        }
    }
    
    for(var i = 0; i<maxBullets; i++){
        if(bullets[i]==null)
                bullets[i]={x:0, y:0, t:0, d:0, l:-1, s:10, cr:200, cg:170, cb:170};
        tickBullet(bullets[i]);
    }

    
    var angle = Math.atan2(bmouseY - y, bmouseX - x );
    
    preRot=rotation;
    rotation = angle;
//    rotation = angle * (180/Math.PI);
    
    if(kode.space)playerupgrader.setOn(col(x, y, size, size, bmouseX, bmouseY, 10, 10));
    
    if(playerupgrader.on) {
        bcpupgrade();
    }
    
}

function tickEnemyBullet(b) {
    if(b.l>=0) {
        b.x+=Math.cos(b.d)*b.s;
        b.y+=Math.sin(b.d)*b.s;
        
        if(!b.respawning)
            if(col(b.x-b.s/2, b.y-b.s/2, b.s, b.s, x-size/2, y-size/2, size, size)) {
                power--;
                b.dead--;
                if(b.dead<=0){
                    b.respawning=true;
                }
            }
        
        switch(b.t){
            case 0:
                b.cr=200;
                b.cg=170;
                b.cb=170;
                break;
            case 1:
                b.cr=200;
                b.cg=170;
                b.cb=170;
                break;
            case 2:
                b.cr=40;
                b.cg=200;
                b.cb=255;
                break;
            case 3:
                b.cr=80;
                b.cg=140;
                b.cb=200;
                break;
            case 4:
                b.cr=255;
                b.cg=40;
                b.cb=100;
                break;
        }
        
        b.l--;
    }
}

function tickBullet(b) {
    if(b.l>=0) {
        b.x+=Math.cos(b.d)*b.s;
        b.y+=Math.sin(b.d)*b.s;
        
        if(!b.respawning)
            for(var i = 0; i<enemies.length; i++) {
                if(enemies[i]!=null && enemies[i].life>0) {
                    var e = enemies[i];
                    if(col(b.x-(b.s/2)*(b.t==3 ? 2:1), b.y-b.s/2, b.s*(b.t==3 ? 2:1), b.s, e.x-e.size/2, e.y-e.size/2, e.size, e.size)){
                        enemies[i].life--;
                        if(enemies[i].life<=0){
                            enemies[i]=null;
                        }
                        b.dead--;
                        if(b.dead<=0){
                            b.respawning=true;
                        }
                        money+=10;
                        break;
                    }
                }
            }
        
        switch(b.t){
            case 0:
                b.cr=200;
                b.cg=170;
                b.cb=170;
                break;
            case 1:
                b.cr=200;
                b.cg=170;
                b.cb=170;
                break;
            case 2:
                b.cr=40;
                b.cg=200;
                b.cb=255;
                break;
            case 3:
                b.cr=80;
                b.cg=140;
                b.cb=200;
                break;
            case 4:
                b.cr=255;
                b.cg=40;
                b.cb=100;
                break;
        }
        
        b.l--;
    }
}

function bcpupgrade() {
    if(playerupgrader.tick()) {
        level++;
        money-=playerupgrader.values[playerupgrader.finished-1];
        switch(level) {
            case 1:
                maxBullets=2;
                speed=2;
                bulletSpeed=12;
                friction=0.8;
                
                bulletLives=25;
                
                squareR = 50;
                squareG = 200;
                squareB = 100;
                
                circleR = 255;
                circleG = 230;
                circleB = 20;

                scopeR = 200;
                scopeG = 170;
                scopeB = 170;
                
                break;
            case 2:
                maxBullets=5;
                speed=2.5;
                friction=0.75;
                bulletSpeed=16;
                
                bulletLives=45;
                
                squareR = 50;
                squareG = 200;
                squareB = 100;
                
                circleR = 255;
                circleG = 230;
                circleB = 20;
                
                scopeR = 100;
                scopeG = 20;
                scopeB = 255;
                
                break;
            case 3:
                maxBullets=8;
                speed=4.25;
                friction=0.7;
                bulletSpeed=16;
                
                bulletLives=45;
                
                squareR = 50;
                squareG = 40;
                squareB = 255;
                
                circleR = 100;
                circleG = 255;
                circleB = 255;
                
                scopeR = 100;
                scopeG = 20;
                scopeB = 255;
                
                break;
            case 4:
                maxBullets=8;
                speed=6;
                friction=0.6;
                bulletSpeed=20;
                bulletEfficeincy=2;
                
                bulletLives=40;
                
                squareR = 50;
                squareG = 40;
                squareB = 255;
                
                circleR = 100;
                circleG = 255;
                circleB = 255;
                
                scopeR = 255;
                scopeG = 20;
                scopeB = 60;
                
                break;
        }
    }
}

function bcprestore() {
    x = can.width/2;
    y = can.height/2;

    xMove=0;
    yMove=0;

    rotation = 0;
    preRot = 0;

    level = 0;

    squareR = 255;
    squareG = 20;
    squareB = 20;

    circleR = 255;
    circleG = 230;
    circleB = 20;

    scopeR = 200;
    scopeG = 170;
    scopeB = 170;
    

    size = 30;

    money = 0;

    power = 100;

    maxBullets = 1;
    bulletEfficeincy=1;
    bulletLives=20;
    bulletSpeed=10;
}

function renderBullet(b, c) {
    if(b.l<0 || b.respawning)
        return;
    
    var bulletGradient = c.createRadialGradient(0, 0, 1, 0, 0, 10);
    bulletGradient.addColorStop(0, rgb(b.cr,b.cg,b.cb));
    bulletGradient.addColorStop(1, rgb(b.cr*0.5,b.cg*0.5,b.cb*0.5));
    
    c.fillStyle=bulletGradient;
    
    switch(b.t){
        case 0:
            c.save();
            c.beginPath();
            c.translate(b.x, b.y);
            c.rotate(b.d);

            c.moveTo(-4, -4);
            c.lineTo(4, -4);
            c.arcTo(6, -4, 6, 0, 4);
            c.arcTo(6, 4, -4, 4, 4);
            c.lineTo(-4, 4);
            c.lineTo(-4, -4);
            
            c.fill();
            break;
        case 1:
            c.save();
            c.beginPath();
            c.translate(b.x, b.y);
            c.rotate(b.d);

            c.moveTo(-4, -4);
            c.lineTo(4, -4);
            c.arcTo(6, -4, 6, 0, 4);
            c.arcTo(6, 4, -4, 4, 4);
            c.lineTo(-4, 4);
            c.lineTo(-4, -4);
            
            c.strokeStyle="#0aff0a";
            c.lineWidth=2;
            c.stroke();
            c.fill();
            break;
        case 2:
            c.save();
            c.beginPath();
            c.translate(b.x, b.y);
            c.rotate(b.d);

            c.moveTo(-4, -4);
            c.lineTo(4, -4);
            c.arcTo(6, -4, 6, 0, 4);
            c.arcTo(6, 4, -4, 4, 4);
            c.lineTo(-4, 4);
            c.lineTo(-4, -4);
            
            c.strokeStyle="#0afffa";
            c.lineWidth=2;
            c.stroke();
            c.fill();
            break;
        case 3:
            c.save();
            c.beginPath();
            c.translate(b.x, b.y);
            c.rotate(b.d);

            c.moveTo(-4, -4);
            c.lineTo(4, -4);
            c.arcTo(6, -4, 6, 0, 4);
            c.arcTo(6, 4, -4, 4, 4);
            c.lineTo(-4, 4);
            c.lineTo(-4, -4);
            
            c.strokeStyle="#0afffa";
            c.lineWidth=2;
            c.stroke();
            c.fill();
            break;
        case 4:
            c.save();
            c.beginPath();
            c.translate(b.x, b.y);
            c.rotate(b.d);

            c.moveTo(-10, -4);
            c.lineTo(10, -4);
            c.lineTo(10, 4);
            c.lineTo(-10, 4);
            c.lineTo(-10, -4);
            c.lineWidth=2;
            c.strokeStyle="#ff0afa";
            c.stroke();
            c.fill();
            break;
    }
    c.restore();
}

function bcpren(c) {
    
//    console.log("RENDERING");
    
    var reload = 300;
    
    var j = 0;
    
    //Render bullets
    for(var i = 0; i<maxBullets; i++){
        renderBullet(bullets[i], c);
        reload = Math.min(reload, bullets[i].l);
        if(bullets[i].l<0){
            renderBullet({x:15, y:can.height-87-j*10, t:bullets[i].t, d:0, l:2, s:10, cr:bullets[i].cr, cg:bullets[i].cg, cb:bullets[i].cb}, c);
//                renderBullet(
            j++;
        }
    }
    c.strokeStyle="#1166ff";
    c.lineWidth=2;
    c.fillStyle="#fffa10";
    c.fillRect(10,can.height-80, 100*((bulletLives-reload-1)/bulletLives), 20);
    c.strokeRect(10, can.height-80, 100, 20);
    
    //Set gradients for use
    var squareGradient = c.createRadialGradient(0, 0, 1, 0, 0, size);
    squareGradient.addColorStop(0, rgb(squareR, squareG, squareB));
    squareGradient.addColorStop(1, rgb(squareR*0.8, squareG*0.8, squareB*0.8));
    
    var circleGradient = c.createRadialGradient(0, 0, 1, 0, 0, size);
    circleGradient.addColorStop(0, rgb(circleR, circleG, circleB));
    circleGradient.addColorStop(1, rgb(circleR*0.6, circleG*0.6, circleB*0.6));
    
    var scopeGradient = c.createLinearGradient(0, -size/4, 0, size/4);
    scopeGradient.addColorStop(0, rgb(scopeR*0.5, scopeG*0.5, scopeB*0.5));
    scopeGradient.addColorStop(0.5, rgb(scopeR, scopeG, scopeB));
    scopeGradient.addColorStop(1, rgb(scopeR*0.5, scopeG*0.5, scopeB*0.5));
    
    c.save();
    c.beginPath();
    
    c.translate(x, y);
    c.rotate(rotation);
    
    //Draw Base
    c.fillStyle=squareGradient;
    c.rect(-size/2, -size/2, size, size);
    c.fill();
    
    //Draw Scope
    c.beginPath();
    c.fillStyle=scopeGradient;
    c.rect(size/4, -size/4, size, size/2);
    c.fill();
    
    //Draw Hump
    c.beginPath();
    c.fillStyle=circleGradient;
    c.ellipse(0, 0, size/2, size/2, 0, 0, 180, false);
    c.fill();
    
    if(level>=1){
        c.beginPath();
        c.strokeStyle="#00a000";
        c.fillStyle="#0aff0a";
        c.lineWidth=1;
        c.moveTo(0, -size/2);
        c.lineTo(size/2, 0);
        c.lineTo(0, size/2);
        c.lineTo(0, -size/2);
        c.fill();
        c.stroke();
        
        c.fillStyle="#000000"
        c.fillRect(size/2, -1, size-size/4, 2);
    }
    
    
    c.restore();
    
    c.fillStyle="#aaddff";
    c.strokeStyle="#1166ff";
    c.lineWidth=5;
    c.lineJoin="round";
    c.fillRect(10, can.height-50, 60, 40);
    c.strokeRect(10, can.height-50, 60, 40);
    
    c.fillStyle="#000000";
    c.font="bold 20px Arial"
    c.fillText(power+"", 20, can.height-20, 100);
    
    c.strokeStyle="#000000";
    c.strokeRect(80, can.height-40, 100, 20);
    c.fillStyle="#ff0000";
    c.fillRect(80, can.height-40, 100, 20);
    c.fillStyle="#00ff00";
    c.fillRect(80, can.height-40, power, 20);
    
    c.fillStyle="#ffee44";
    c.strokeText("$"+money, 200, can.height-20, 100);
    c.fillText("$"+money, 200, can.height-20, 100);
    
    c.strokeText("Round: " + round, 300, can.height-20, 100);
    c.fillText("Round: " + round, 300, can.height-20, 100);
    
    if(playerupgrader.on) playerupgrader.render(c);
    
}

















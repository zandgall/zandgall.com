

/// JEFFREYTHOMPSON.ORG - > http://www.jeffreythompson.org/collision-detection/line-rect.php

const TYPE_BRONZE = 2, TYPE_TRANSPARENT = 3, TYPE_SADDENED =  4, TYPE_ARROW = 5, TYPE_DESPAIRED = 6, TYPE_GOLDEN = 7, TYPE_PLATINUM = 8, TYPE_SMALL = 9, TYPE_SHOOTER = 10, TYPE_BIG = 11;

class BubbleEnemy {
    /**
     * @param {number} type 
     */
    constructor(type, sheet) {
        this.index = 0;
        let p = path[0].get(0);
        this.x = p.x;
        this.y = p.y;
        this.rotation = 0.0;

        this.uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
          });

        //Type specific
        this.type = type;
        this.speed = 1.5;
        this.life = 1;
        this.resistance = 1;
        this.w = 52;
        this.h = 52;
        this.hitEffect = 0;

        this.bulletsHitBy = [];
        this.body = new Image();
        this.head = new Image();
        this.barrel = new Image();
        this.bullet = new Image();

        let ut = document.getElementById("utilcan");
        ut.width = 128;
        ut.height = 128;
        let c = ut.getContext("2d");
        c.drawImage(sheet, -512, 0);
        this.body.src = ut.toDataURL();

        // Head
        c.clearRect(0, 0, 128, 128);
        c.drawImage(sheet, -640, 0);
        this.head.src = ut.toDataURL();
        
        // Barrel
        c.clearRect(0, 0, 128, 128);
        c.drawImage(sheet, -768, 0);
        this.barrel.src = ut.toDataURL();

        // Bullet
        c.clearRect(0, 0, 128, 128);
        c.drawImage(sheet, -896, 0);
        this.bullet.src = ut.toDataURL();
        switch (type) {
            case TYPE_BRONZE: // Orange armored
                this.life = 2;
                this.speed = 2;
                // Head
                c.clearRect(0, 0, 128, 128);
                c.drawImage(sheet, -640, -128);
                this.head.src = ut.toDataURL();
                break;
            case TYPE_TRANSPARENT: // Transparent
                c.clearRect(0, 0, 128, 128);
                c.drawImage(sheet, -640, -256);
                this.head.src = ut.toDataURL();
                c.clearRect(0, 0, 128, 128);
                c.drawImage(sheet, -768, -256);
                this.barrel.src = ut.toDataURL();
                this.speed = 4;
                break;
            case TYPE_SADDENED: // Sad guys
                c.clearRect(0, 0, 128, 128);
                c.drawImage(sheet, -640, -128*3);
                this.head.src = ut.toDataURL();
                this.barrel = new Image(128, 128);
                this.life = 3;
                this.preLife = 3;
                this.speed = 2;
                this.sheet = sheet;
                break;
            case TYPE_ARROW: // Arrows
                this.steps = 0;
                this.mx = this.x;
                this.my = this.y;
                c.clearRect(0, 0, 128, 128);
                c.drawImage(sheet, -640, -128*4);
                this.step0 = new Image(128, 128);
                this.step0.src = ut.toDataURL();
                c.clearRect(0, 0, 128, 128);
                c.drawImage(sheet, -640-128, -128*4);
                this.step1 = new Image(128, 128);
                this.step1.src = ut.toDataURL();
                c.clearRect(0, 0, 128, 128);
                c.drawImage(sheet, -640-256, -128*4);
                this.step2 = new Image(128, 128);
                this.step2.src = ut.toDataURL();
                c.clearRect(0, 0, 128, 128);
                c.drawImage(sheet, -640-128*3, -128*4);
                this.step3 = new Image(128, 128);
                this.step3.src = ut.toDataURL();
                this.speed = 5;
                break;
            case TYPE_DESPAIRED: // Cryer Guys
                c.clearRect(0, 0, 128, 128);
                c.drawImage(sheet, -640, -128*5);
                this.head.src = ut.toDataURL();
                this.barrel = new Image(128, 128);
                this.life = 3;
                this.preLife = 3;
                this.speed = 4;
                this.sheet = sheet;
                break;
            case TYPE_GOLDEN: // Light-Golden armored guys
                this.life = 4;
                this.speed = 4;
                // Head
                c.clearRect(0, 0, 128, 128);
                c.drawImage(sheet, -768, -128);
                //@ts-ignore
                this.head.src = ut.toDataURL();
                break;
            case TYPE_PLATINUM: // Bluish (platinum?) armored guys
                this.life = 8;
                this.speed = 8;
                // Head
                c.clearRect(0, 0, 128, 128);
                c.drawImage(sheet, -896, -128);
                this.head.src = ut.toDataURL();
                break;
            case TYPE_SMALL: // Little guys
                this.speed = 12;
                // Head
                c.clearRect(0, 0, 128, 128);
                c.drawImage(sheet, -640, -768);
                this.head.src = ut.toDataURL();
                c.clearRect(0, 0, 128, 128);
                c.drawImage(sheet, -768, -768);
                this.barrel.src = ut.toDataURL();
                this.w=26;
                this.h=26;
                break;
            case TYPE_SHOOTER: // First shooter guys
                this.reloadInd = 5*Math.random();
                this.life = 2;
                // Head
                c.clearRect(0, 0, 128, 128);
                c.drawImage(sheet, -640, -896);
                this.head.src = ut.toDataURL();
                c.clearRect(0, 0, 128, 128);
                c.drawImage(sheet, -768, -896);
                this.barrel.src = ut.toDataURL();
                c.clearRect(0, 0, 128, 128);
                c.drawImage(sheet, -896, -896);
                this.bullet.src = ut.toDataURL();
                break;
            case TYPE_BIG: // Big guy....
                this.life = 100;
                this.speed = 0.8;
                ut.width = 256;
                ut.height = 256;
                // Head
                c.clearRect(0, 0, 256, 256);
                c.drawImage(sheet, -640, -1024);
                this.head.src = ut.toDataURL();
                ut.width = 128;
                ut.height = 128;
                this.barrel = new Image();
                break;
        } 
    }

    tick() {
        if(this.hitEffect>0)
            this.hitEffect -= 2;
        let p = path[Math.floor(this.index)].get(this.index%1);
        let d = path[Math.floor(this.index+0.1)].get((this.index+0.1)%1);
        this.index = Math.floor(this.index) + path[Math.floor(this.index)].increment(this.index%1, this.speed*(100-this.hitEffect)/100.0);
        switch(this.type) {
        case TYPE_ARROW:
            this.steps+=0.1;
            if(this.steps>=4) {
                this.steps = 0;
                this.x = p.x;
                this.y = p.y;
                this.rotation = Math.atan2(d.y-p.y,d.x-p.x);
            }
            break;
        case TYPE_SHOOTER:
            this.x = p.x;
            this.y = p.y;
            this.rotation = Math.atan2(player.y-this.y, player.x-this.x);
            break;
        default:
            this.x = p.x;
            this.y = p.y;
            this.rotation = Math.atan2(d.y-p.y,d.x-p.x);
        }
        if(Math.floor(this.index+0.1) >= path.length) {
            player.life-=this.life;
            return true;
        }

        for(let i = 0; i < projectiles.length; i++) {
            if(projectiles[i].player && !this.bulletsHitBy.includes(projectiles[i].uuid)) {
                p = projectiles[i];
                if(lb(p.x-26, p.y-26, p.v.x, p.v.y, this.x-this.w/2-p.w, this.y-this.h/2-p.h, this.w+p.w*2, this.h+p.h*2)) {
                    money+= 10*Math.min(p.power, this.life);
                    this.life-=p.power;
                    this.hitEffect = 100;
                    projectiles[i].impact(this.resistance);
                    this.bulletsHitBy.push(projectiles[i].uuid);
                    if(projectiles[i].life<=0) {
                        projectiles.splice(i, 1);
                        i--;
                    }
                    if(this.life<=0) {
                        return true;
                    }
                }
            }
        }

        switch(this.type) {
            case TYPE_BRONZE:
            case TYPE_GOLDEN:
            case TYPE_PLATINUM:
                this.speed = this.life;
                break;
            case TYPE_SADDENED:
                if(this.preLife!=this.life) {
                    let ut = document.getElementById("utilcan");
                    ut.width = 128;
                    ut.height = 128;
                    let c = ut.getContext("2d");
                    c.clearRect(0, 0, 128, 128);
                    c.drawImage(this.sheet, -640 - (128*(3-this.life)), -128*3);
                    this.preLife = this.life;
                    this.speed = 5-this.life;
                    this.head.src = ut.toDataURL();
                    c.clearRect(0, 0, 128, 128);
                }
                break;
            case TYPE_DESPAIRED:
                if(this.preLife!=this.life) {
                    let ut = document.getElementById("utilcan");
                    ut.width = 128;
                    ut.height = 128;
                    let c = ut.getContext("2d");
                    c.clearRect(0, 0, 128, 128);
                    c.drawImage(this.sheet, -640 - (128*(3-this.life)), -128*5);
                    this.preLife = this.life;
                    this.speed = 7-this.life;
                    this.head.src = ut.toDataURL();
                    c.clearRect(0, 0, 128, 128);
                }
                break;
            case TYPE_SHOOTER:
                this.reloadInd-=1/60;
                if(this.reloadInd<=0) {
                    this.reloadInd = 5;
                    projectiles.push(new Projectile(this.x + Math.cos(this.rotation)*26, this.y+Math.sin(this.rotation)*26, this.rotation, 5, 1, "default", false, this.bullet));                    
                }
                break;
        }
        return false;
    }

    /**
     * 
     * @param {CanvasRenderingContext2D} c 
     */
    draw(c) {
        c.filter = `contrast(${100-this.hitEffect}%) brightness(${100+this.hitEffect}%)`;
        switch(this.type) {
            case 5:
                c.save();
                c.translate(this.x, this.y);
                c.rotate(this.rotation);
                if(this.steps<1)
                    c.drawImage(this.step0, -26, -26, 52, 52);
                else if(this.steps<2)
                    c.drawImage(this.step1, -26, -26, 52, 52);
                else if(this.steps<3)
                    c.drawImage(this.step2, -26, -26, 52, 52);
                else if(this.steps<4)
                    c.drawImage(this.step3, -26, -26, 52, 52);
                c.restore();
                break;    
            case 11:
                c.drawImage(this.head, this.x-52, this.y-52, 104, 104);
                break;
            default:
                c.drawImage(this.body, this.x-26, this.y-26, 52, 52);
                c.save();
                c.translate(this.x, this.y);
                c.rotate(this.rotation);
                c.drawImage(this.barrel, this.w*0.38, -26, 52, 52);
                c.restore();
                c.drawImage(this.head, this.x-26, this.y-26, 52, 52);
        }
        c.filter = "none";
    }

}


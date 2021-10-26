let ut, c;
class BubblePlayer {
    handleImg() {
        ut = document.getElementById("utilcan");
        ut.width = 128;
        ut.height = 128;
        c = ut.getContext("2d");

        // Body
        c.clearRect(0, 0, 128, 128);
        c.drawImage(this.sheet, 0, 0);
        this.bodyID = "default"; // Reset handleImg() flag
        this.body.src = ut.toDataURL();

        // Head
        c.clearRect(0, 0, 128, 128);
        c.drawImage(this.sheet, -128, 0);
        this.head.src = ut.toDataURL();
        
        // Barrel
        c.clearRect(0, 0, 128, 128);
        c.drawImage(this.sheet, -256, 0);
        this.barrel.src = ut.toDataURL();

        // Bullet
        c.clearRect(0, 0, 128, 128);
        c.drawImage(this.sheet, -384, 0);
        this.bullet.src = ut.toDataURL();
        c.clearRect(0, 0, 128, 128);
    }
    constructor() {
        // Set player movement values
        this.x = 400;
        this.y = 400;
        this.xv = 0;
        this.yv = 0;
        this.w = 52;
        this.h = 52;
        this.rotation = 0.0;

        // Set images to new Images
        this.sheet = new Image();
        this.sheet.src = "Funsies/BubbleCannons/sheet.png";
        this.body = new Image();
        this.head = new Image();
        this.barrel = new Image();
        this.bullet = new Image();

        // Factors to upgrade :: Names self explanatory
        this.speed = 0.7;
        this.reloadspeed = 1;
        this.bulletSpeed = 10;
        this.bulletPower = 1;
        this.barrelLength = 26; 
        this.life = 10;
        this.maxLife = 10;
        this.resistance = 1;
        this.regeneration = 0;

        // A set of objects with a .tick() and .draw(c) functions. Used for Missiles, Bombs, Lasers, etc.
        this.customs = [];

        // Helper values, are used to apply above factors
        this.bulletInd = 0;
        
        this.barrelID = "default";
        this.bodyID = "unset";
        this.headID = "default";
        this.bulletID = "default";
        this.bulletsHitBy = [];
    }

    tick() {
        this.rotation = Math.atan2(mouseY-this.y,mouseX-this.x);
        if(this.bodyID === "unset")
            this.handleImg();
        
        if(keys["w"])
            this.yv-=this.speed;
        if(keys["s"])
            this.yv+=this.speed;
        if(keys["a"])
            this.xv-=this.speed;
        if(keys["d"])
            this.xv+=this.speed;
        this.yv*=0.8;
        this.xv*=0.8;
        this.x+=this.xv;
        this.y+=this.yv;
        this.bulletInd-=1/60.0;

        for(let i = 0; i < projectiles.length; i++) {
            if(!projectiles[i].player && !this.bulletsHitBy.includes(projectiles[i].uuid)) {
                let p = projectiles[i];
                if(lb(p.x-26, p.y-26, p.v.x, p.v.y, this.x-this.w/2-p.w, this.y-this.h/2-p.h, this.w+p.w*2, this.h+p.h*2)) {
                    this.life-=p.power;
                    projectiles[i].impact(this.resistance);
                    this.bulletsHitBy.push(projectiles[i].uuid);
                    if(projectiles[i].life<=0) {
                        projectiles.splice(i, 1);
                        i--;
                    }
                }
            }
        }

        if(leftPress && this.bulletInd<=0) {
            switch(this.bodyID) {
                case "daredevil":
                    this.customs.push(new daredevillaser(this.x+Math.cos(this.rotation)*this.barrelLength, this.y+Math.sin(this.rotation)*this.barrelLength, this.rotation));
                    this.bulletInd = this.reloadspeed; 
                    break;
                case "bomblauncher":
                    this.customs.push(new bomb(this.x, this.y, mouseX, mouseY, this.sheet, this.bulletPower));
                    if(this.barrelID=="bombtrio") {
                        let d = Math.sqrt((mouseX-this.x)*(mouseX-this.x) + (mouseY-this.y)*(mouseY-this.y));
                        this.customs.push(new bomb(this.x, this.y, this.x + Math.cos(this.rotation+0.3)*d, this.y + Math.sin(this.rotation+0.3)*d, this.sheet, this.bulletPower));
                        this.customs.push(new bomb(this.x, this.y, this.x + Math.cos(this.rotation-0.3)*d, this.y + Math.sin(this.rotation-0.3)*d, this.sheet, this.bulletPower));
                    }
                    this.bulletInd = this.reloadspeed;
                    break;
                case "rockets":
                case "heatseeking":
                case "nuke":
                    this.customs.push(new missile(this.x, this.y, this.rotation, this.bodyID != "rockets", this.bullet, this.bulletPower));
                    if(this.barrelID=="bombtrio") {
                        this.customs.push(new missile(this.x, this.y, this.rotation+0.3, this.bodyID != "rockets", this.bullet, this.bulletPower));
                        this.customs.push(new missile(this.x, this.y, this.rotation-0.3, this.bodyID != "rockets", this.bullet, this.bulletPower));
                    }
                    this.bulletInd = this.reloadspeed;
                    break;
                default:
                    projectiles.push(new Projectile(this.x+26+Math.cos(this.rotation)*this.barrelLength, this.y+26+Math.sin(this.rotation)*this.barrelLength, this.rotation+0.1*(Math.random()-0.5), this.bulletSpeed, this.bulletPower, this.bulletID, true, this.bullet));
                    this.bulletInd = this.reloadspeed; 
                    break;
            }
        }
        for(let i = 0; i < this.customs.length; i++) {
            if(this.customs[i].tick()) {
                this.customs.splice(i, 1);
                i--;
            }
        }
    }

    upgrade(id) {
        c.clearRect(0, 0, 128, 128);
        switch(id) {
            case "fatbarrel":
                c.drawImage(this.sheet, -256, -384);
                
                this.barrel.src = ut.toDataURL();
                c.clearRect(0, 0, 128, 128);
                c.drawImage(this.sheet, -384, -384);
                
                this.bullet.src = ut.toDataURL();
                this.reloadspeed = 1.5;
                this.bulletID = "2life";
                break;
            case "sharpbullets":
                c.drawImage(this.sheet, -384, -128);
                
                this.bullet.src = ut.toDataURL();
                this.bulletSpeed*=1.1;
                this.bulletPower = 2;
                break;
            case "sharperbullets":
                c.drawImage(this.sheet, -384, -128);
                
                this.bullet.src = ut.toDataURL();
                this.bulletSpeed*=1.1;
                this.bulletID = "2life";
                break;
            case "heavyduty":
                c.drawImage(this.sheet, -384, -512);
                
                this.bullet.src = ut.toDataURL();
                this.bulletID = "3life";
                break;
            case "highvelocity":
                c.drawImage(this.sheet, -256, -512);
                
                this.barrel.src = ut.toDataURL();
                this.reloadspeed /= 2;
                this.bulletSpeed *= 2;
                break;
            case "thebigone":
                c.drawImage(this.sheet, -256, -128*5);
                
                this.barrel.src = ut.toDataURL();
                this.reloadspeed /= 2;
                this.bulletSpeed *= 2;
                break;
            case "shellshock":
                c.drawImage(this.sheet, -384, -128*5);
                
                this.bullet.src = ut.toDataURL();
                this.bulletPower += 1;
                break;
            case "barrel100":
                c.drawImage(this.sheet, -256, -128);
                
                this.barrel.src = ut.toDataURL();
                c.clearRect(0, 0, 128, 128);
                this.reloadspeed *= 0.75;
                break;
            case "barrel400":
                c.drawImage(this.sheet, -256, -256);
                 
                this.barrel.src = ut.toDataURL();
                c.clearRect(0, 0, 128, 128);
                this.reloadspeed *= 0.75;
                break;
            case "barrel750":
                // c.drawImage(this.sheet, -256, -768);
                 
                // this.barrel.src = ut.toDataURL();
                // c.clearRect(0, 0, 128, 128);
                this.reloadspeed *= 0.75;
                break;
            case "semiauto":
                c.drawImage(this.sheet, -256, -768);
                 
                this.barrel.src = ut.toDataURL();
                c.clearRect(0, 0, 128, 128);
                this.reloadspeed /= 5;
                break;
            case "daredevil":
                this.bodyID = "daredevil"; 
                c.drawImage(this.sheet, -1920, 0);
                
                this.body.src = ut.toDataURL();
                this.speed = 2;
                break;
            case "bomblauncher":
                this.bodyID = "bomblauncher"; 
                c.drawImage(this.sheet, -256, -1024);
                
                this.barrel.src = ut.toDataURL();
                break;
            case "bombtrio":
                this.barrelID = "bombtrio"; 
                c.drawImage(this.sheet, -256, -1408);
                
                this.barrel.src = ut.toDataURL();
                break;
            case "3squared":
                c.drawImage(this.sheet, -256, -1408);
                
                this.reloadspeed/=2;
                break;
            case "rockets":
                this.bodyID = "rockets"; 
                c.drawImage(this.sheet, -384, -1536);
                
                this.bullet.src = ut.toDataURL();
                break;
            case "heatseeking":
                this.bodyID = "heatseeking"; 
                c.drawImage(this.sheet, -384, -1680);
                
                this.bullet.src = ut.toDataURL();
                break;
            case "nuke":
                this.bodyID = "nuke";
                c.drawImage(this.sheet, -384, -1408);
                
                this.bullet.src = ut.toDataURL();
                this.bulletPower = 3;
                break;
            case "thickskin":
                c.drawImage(this.sheet, 0, -128);
                this.body.src = ut.toDataURL();
                this.maxLife+=10;
                this.life=(this.life/10)*this.maxLife;
                break;
            case "fasttreads":
                c.drawImage(this.sheet, -128, -128);
                this.head.src = ut.toDataURL();
                this.speed = 1;
                break;
            }
        c.clearRect(0, 0, 128, 128);
    }

    /**
     * 
     * @param {CanvasRenderingContext2D} c 
     */
    render(c) {
        for(let i = 0; i < this.customs.length; i++) {
            this.customs[i].draw(c);
        }
        // c.putImageData(this.body, this.x, this.y);
        // c.drawImage(this.body, this.x, this.y);
        if(this.bulletInd>0) {
            c.fillStyle = "rgba(0, 0, 0, 0.4)";
            c.fillRect(mouseX-5, mouseY-10, 20 - 20.0 * (this.bulletInd / this.reloadspeed), 5);
            c.strokeStyle = "rgba(0, 0, 0, 0.4)";
            c.strokeRect(mouseX-5, mouseY-10, 20, 5);
        }
        switch(this.bodyID) {
            case "daredevil":
                c.save();
                c.translate(this.x, this.y);
                c.rotate(this.rotation);
                c.drawImage(this.body, -26, -26, 52, 52);
                c.restore();
                break;
            default:
                c.drawImage(this.body, this.x-26, this.y-26, 52, 52);
                c.save();
                c.translate(this.x, this.y);
                c.rotate(this.rotation);
                c.drawImage(this.barrel, 20, -26, 52, 52);
                c.drawImage(this.head, -26, -26, 52, 52);
                c.restore();
                c.drawImage(this.head, this.x-26, this.y-26, 52, 52);
                break;
        }
    }
}

class missile {
    constructor(x, y, dir, heatseeking, image, power) {
        this.image = image;
        this.power = power;
        this.x = x;
        this.y = y;
        this.dir = dir;
        this.heatseeking = heatseeking;
        this.speed = 20;
        this.v = {x: Math.cos(dir)*this.speed, y: Math.sin(dir)*this.speed}

        if(heatseeking) {
            this.target = this.getTarget();
        }

        this.currentTick = 1;
        this.blast = new Image(256, 256);
        let ut = document.getElementById("utilcan");
        
        let c = ut.getContext("2d");
        
        ut.width = 256;
        
        ut.height = 256;
        c.clearRect(0, 0, 256, 256);
        c.drawImage(sheet, -256, -768-128*3);
        
        this.blast.src = ut.toDataURL();
        c.clearRect(0, 0, 256, 256);
        
        ut.width = 128;
        
        ut.height = 128;
    }

    getTarget() {
        let d = Infinity;
        let c = null;
        for(let i = 0; i < enemies.length; i++) {
            let f = (enemies[i].x - this.x)*(enemies[i].x - this.x) + (enemies[i].y - this.y)*(enemies[i].y - this.y);
            if(f < d) { 
                d = f;
                c = enemies[i];     
            }
        }
        return c;
    }

    tick() {
        switch(this.currentTick) {
        case 0:
            if(this.heatseeking) {
                this.target = this.getTarget();
            }
            if(this.target!=null) {
                let nd = Math.atan2(this.target.y-this.y, this.target.x-this.x);
                if(Math.abs(this.dir - (-Math.PI*2 + nd)) < Math.abs(this.dir - nd))
                    nd = (-Math.PI*2 + nd);
                else if(Math.abs(this.dir - (Math.PI*2 + nd)) < Math.abs(this.dir - nd))
                    nd = (Math.PI*2 + nd);
                this.dir = 0.1 * nd + 0.9 * this.dir;
                if(this.dir < 0)
                    this.dir += Math.PI*2;
                if(this.dir > Math.PI*2)
                    this.dir -= Math.PI*2;
            }
            this.v = {x: Math.cos(this.dir)*this.speed, y: Math.sin(this.dir)*this.speed};
            this.currentTick = 1;
            this.x += this.v.x;
            this.y += this.v.y;
            break;
        case 1:
            if(this.heatseeking)
                this.currentTick = 0;
            for(let i = 0; i < enemies.length; i++) {
                if(this.x-26<=enemies[i].x+enemies[i].w/2&&this.y-26<=enemies[i].y+enemies[i].h/2&&this.x+26>=enemies[i].x-enemies[i].w/2&&this.y+26>=enemies[i].y-enemies[i].h/2) {
                    this.currentTick = 2;
                    break;
                }
            }
            this.x += this.v.x;
            this.y += this.v.y;
            break;
        default:
            if(this.currentTick==2)
                for(let i = 0; i < enemies.length; i++) {
                    if(this.x-52<=enemies[i].x+enemies[i].w/2&&this.y-52<=enemies[i].y+enemies[i].h/2&&this.x+52>=enemies[i].x-enemies[i].w/2&&this.y+52>=enemies[i].y-enemies[i].h/2) {
                        money+= 10*Math.min(this.power, enemies[i].life);
                        prm = money;
                        enemies[i].life-=this.power;
                        if(enemies[i].life<=0) {
                            enemies.splice(i, 1);
                            i--;
                        }
                    }
                }

            this.currentTick++;
            return (this.currentTick>10);
        }
        return (this.x > 1200 || this.y > 1200 || this.x<-400 || this.y<-400);
    }

    draw(c) {
        c.save();
        c.translate(this.x, this.y);
        c.rotate(this.dir);
        if(this.currentTick>1)
            c.drawImage(this.blast, -52, -52, 104, 104);
        else
            c.drawImage(this.image, -26, -26, 52, 52);
        c.restore();
    }
}

class bomb {
    constructor(x, y, destinationX, destinationY, sheet, power) {
        this.x = x;
        this.power = power;
        this.y = y;
        this.destinationX = destinationX;
        this.destinationY = destinationY;
        this.fuse = 0.1;
        this.fTimer = 0;
        this.rotation = Math.random()*3.14159265*2;
        this.images = [];
        this.images.push(new Image(128, 128));
        this.images.push(new Image(128, 128));
        this.images.push(new Image(128, 128));
        this.images.push(new Image(256, 256));
        let ut = document.getElementById("utilcan");
        
        ut.width = 128;
        
        ut.height = 128;
        
        let c = ut.getContext("2d");
        c.drawImage(sheet, -384, -768);
        
        this.images[2].src = ut.toDataURL();
        c.clearRect(0, 0, 128, 128);
        c.drawImage(sheet, -384, -768-128);
        
        this.images[0].src = ut.toDataURL();
        c.clearRect(0, 0, 128, 128);
        c.drawImage(sheet, -384, -768-256);
        
        this.images[1].src = ut.toDataURL();
        
        ut.width = 256;
        
        ut.height = 256;
        c.clearRect(0, 0, 256, 256);
        c.drawImage(sheet, -256, -768-128*3);
        
        this.images[3].src = ut.toDataURL();
        c.clearRect(0, 0, 256, 256);
        
        ut.width = 128;
        
        ut.height = 128;
    }

    tick() {
        this.fuse*=1.1;
        this.x = this.x * 0.8 + this.destinationX*0.2;
        this.y = this.y * 0.8 + this.destinationY*0.2;
        this.rotation+=0.01*Math.max(Math.abs(this.destinationX-this.x) + Math.abs(this.destinationY-this.y), 0);
        if(this.fuse>=10&&this.fuse<=11) {
            for(let i = 0; i < enemies.length; i++) {
                if(this.x-52<=enemies[i].x+enemies[i].w/2&&this.y-52<=enemies[i].y+enemies[i].h/2&&this.x+52>=enemies[i].x-enemies[i].w/2&&this.y+52>=enemies[i].y-enemies[i].h/2) {
                    money+= 10*Math.min(this.power, enemies[i].life);
                    prm = money;
                    enemies[i].life-=this.power;
                    if(enemies[i].life<=0) {
                        enemies.splice(i, 1);
                        i--;
                    }
                }
            }

        }
        return (this.fuse>=15);
    }

    /**
     * 
     * @param {CanvasRenderingContext2D} c 
     */
    draw(c) {
        c.save();
        c.translate(this.x, this.y);
        c.rotate(this.rotation);
        if(this.fuse >= 10) {
            c.drawImage(this.images[3], -52, -52, 104, 104);
        } else {
            if(this.fTimer!=Math.floor(this.fuse*5)) {
                this.fTimer = Math.floor(this.fuse*5);
                c.drawImage(this.images[2], -26, -26, 52, 52);
            } else {
                c.drawImage(this.images[Math.floor(new Date().getTime())%2], -26, -26, 52, 52);
            }
        }
        c.restore();
    }
}

class daredevillaser {
    constructor(x, y, direction) {
        this.x = x;
        this.y = y;
        this.dir = direction;
        this.time = 1.6;
        this.enemiesHit = [];
    }

    tick() {
        this.time-=0.02;
        if(this.time<=0)
            return true;
        if(this.time<=0.8)
            return false;
        for(let i = 0; i < enemies.length; i++) {
            if(!this.enemiesHit.includes(enemies[i].uuid) && lb(this.x, this.y, Math.cos(this.dir)*1200, Math.sin(this.dir)*1200, enemies[i].x-39, enemies[i].y-39, 78, 78)) {
                this.enemiesHit.push(enemies[i].uuid);
                enemies[i].life-=1;
                money+=10;
                prm = money;
                if(enemies[i].life<=0) {
                    enemies.splice(i, 1);
                    i--;
                }
            }
        }
        return false;
    }

    /**
     * 
     * @param {CanvasRenderingContext2D} c 
     */
    draw(c) {
        c.save();
        c.translate(this.x, this.y);
        c.rotate(this.dir);
        let grad = c.createLinearGradient(0, -13, 0, 13);
        let r = 255-200*(1.6-this.time);
        let g = 100*(1.6-this.time);
        grad.addColorStop(0, "rgba("+r + ","+g+", 0, "+(Math.sin(this.time*this.time)*this.time*Math.min(1, this.time)) + ")");
        grad.addColorStop(0.5, "rgba("+r + ","+g+", 0, "+((1+Math.cos(this.time*this.time)*(this.time/20))*Math.min(1, this.time))+")");
        grad.addColorStop(1, "rgba("+r + ","+g+", 0, "+(Math.sin(this.time*this.time)*this.time*Math.min(1, this.time)) + ")");
        let grad2 = c.createRadialGradient(0, 0, 0, 0, 0, 13);
        grad2.addColorStop(0, "rgba("+r + ","+g+", 0, "+((1+Math.cos(this.time*this.time)*(this.time/20))*Math.min(1, this.time))+")");
        grad2.addColorStop(1, "rgba("+r + ","+g+", 0, "+(Math.sin(this.time*this.time)*this.time*Math.min(1, this.time)) + ")");
        c.fillStyle = grad;
        c.fillRect(0, -13, 1200, 26);
        c.fillStyle = grad2;
        c.fillRect(-13, -13, 13, 26);
        c.restore();
    }
}
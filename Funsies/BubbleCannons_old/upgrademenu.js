// @ts-nocheck
var CURRENTMENU = null;

class UpgradeMenu {
    constructor(names, descriptions, values) {
        this.finished = 0;
        this.names=names;
        this.descriptions=descriptions;
        this.values=values;
        this.on=false;
    }
    
    setOn(newon) {
        this.on=newon;
        if(newon) {
            CURRENTMENU=this;
            kode.space=false;
        }
        else if(CURRENTMENU==this)
            CURRENTMENU=null;
    }
    
    buy(money) {
        if(money>=this.values[this.finished]){
            return true;
        }
        else return false;
    }
    
    tick() {
        if(CURRENTMENU!=this) {
            this.on=false;
        }
        for(var i = 0; i<this.names.length; i++) {
            if(bmouseX>can.width-290 && bmouseX<can.width && bmouseY>0 && bmouseY<can.height) {
                if(bmouseY>i*50+20 && bmouseY<i*50+70 && i==this.finished){
                    if(mouseClicked && this.buy(money)){
                        this.finished++;
                        return true;
                    }
                }
            }
        }
        return false;
    }
    
    render(c){
        for(var i = 0; i<Math.min(this.finished, this.names.length); i++) {
            c.strokeStyle="#556677";
            c.strokeRect(can.width-290, i*50+20, 280, 40);
            c.fillStyle="#8899aa";
            c.fillRect(can.width-290, i*50+20, 280, 40);
            c.fillStyle="#000000";
            c.fillText(this.names[i]+"  $" + this.values[i], can.width-270, i*50+50, 300);
        }
        for(var i = this.finished; i<this.names.length; i++) {
            c.strokeStyle="#996677";
            c.strokeRect(can.width-290, i*50+20, 280, 40);
            c.fillStyle="#cc99aa";
            c.fillRect(can.width-290, i*50+20, 280, 40);
            c.fillStyle="#999999";
            c.fillText(this.names[i]+"  $" + this.values[i], can.width-270, i*50+50, 300);
        }
        
        if(this.finished<this.names.length) {
            c.strokeStyle="#8899aa";
            c.strokeRect(can.width-290, this.finished*50+20, 280, 40);
            c.fillStyle="#aabbcc";
            c.fillRect(can.width-290, this.finished*50+20, 280, 40);
            c.fillStyle="#999999";
            if(this.buy(money)){
                c.fillStyle="#000000";
            }
            c.fillText(this.names[this.finished]+"  $" + this.values[this.finished], can.width-270, this.finished*50+50, 300);
        }
    }
}

class CannonMenus {
    constructor(names, descriptions, values) {
        this.finished = 0;
        this.names=names;
        this.descriptions=descriptions;
        this.values=values;
        this.on=false;
    }
    
    buy(money) {
        if(money>=this.values[this.finished]){
            return true;
        }
        else return false;
    }
    
    setOn(newon) {
        this.on=newon;
        if(newon) {
            CURRENTMENU=this;
            kode.space=false;
        }
        else if(CURRENTMENU==this)
            CURRENTMENU=null;
    }
    
    tick() {
        if(CURRENTMENU!=this) {
            this.on=false;
            return -1;
        }
        for(var i = 0; i<this.names.length; i++) {
            if(bmouseX>can.width-290 && bmouseX<can.width && bmouseY>0 && bmouseY<can.height) {
                if(bmouseY>i*100+20 && bmouseY<i*100+110){
                    this.finished=i;
                    if(mouseClicked && this.buy(money)){
                        return i;
                    }
                }
            }
        }
        return -1;
    }
    
    render(c){
        c.lineWidth=5;
        for(var i = 0; i<this.names.length; i++) {
            if(i<this.names.length) {
                c.strokeStyle="#8899aa";
                c.strokeRect(can.width-290,i*100+20, 280, 90);
                c.fillStyle="#aabbcc";
                c.fillRect(can.width-290, i*100+20, 280, 90);
                c.fillStyle="#999999";
                this.finished=i;
                if(this.buy(money)){
                    c.fillStyle="#000000";
                }
                c.fillText(this.names[i]+"  $" + this.values[i], can.width-270, i*100+50, 300);
            }
        }
        
        if(TOWERPLACE!=-1)
            switch(TOWERPLACE){
                case 0:
                    c.fillStyle="#aaaaaa11";
                    c.beginPath();
                    c.ellipse(bmouseX, bmouseY, 450, 450, 0, 0, 180, false);
                    var ca = new Cannon0(bmouseX, bmouseY);
                    ca.tick();
                    ca.ren(c);
                    break;
                case 1:
                    c.fillStyle="#aaaaaa11";
                    c.beginPath();
                    c.ellipse(bmouseX, bmouseY, 450, 450, 0, 0, 180, false);
                    var ca = new Cannon1(bmouseX, bmouseY);
                    ca.tick();
                    ca.ren(c);
                    break;
                             }
        
    }
}
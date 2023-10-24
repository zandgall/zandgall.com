class Projectile {
    /**
     * 
     * @param {number} x 
     * @param {number} y 
     * @param {number} dir 
     * @param {string} id 
     * @param {boolean} player 
     */
    constructor(x, y, dir, speed, power, id, player, image) {
        this.player = player;
        this.x = x;
        this.y = y;
        this.v = {x: Math.cos(dir)*speed, y: Math.sin(dir)*speed};
        this.w = 10;
        this.h = 10;
        this.power = power;
        this.speed = speed;
        this.dir = dir;
        this.id = id;
        this.life = 1;
        this.image = image;
        this.uuid = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, function(c) {
            var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
            return v.toString(16);
          });
        
        switch(id) {
            case "2life":
                this.life = 2;
                break;
            case "3life":
                this.life = 3;
                break;
        }
        if(this.power==0)
            this.power = 1;
    }
    travel() {
        switch(this.id){
            default:
                this.x += this.v.x;
                this.y += this.v.y;
                break;
        }
    }
    impact(power) {
        this.life-=power;
    }
    /**
     * @param {CanvasRenderingContext2D} c 
     */
    draw(c) {
        c.save();
        c.translate(this.x - 26, this.y - 26);
        c.rotate(this.dir);
        c.drawImage(this.image, -26, -26, 52, 52);
        c.restore();
    }
}
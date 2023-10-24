class PathSegment {
    /**
     * 
     * @param {string} code 
     * @param {number} x 
     * @param {number} y 
     */
    constructor(code, x, y) {
        console.log(code);
        this.type = code[0];
        this.points = []; 
        if(this.type!="M")
            this.points.push({x: x, y: y});
        code = code.substr(1);
        for(let i = 0; i < code.split(" ").length; i++) {
            this.points.push({x: parseFloat(code.split(" ")[i].split(",")[0] )+x, y: parseFloat(code.split(" ")[i].split(",")[1])+y});
        }
        this.length = 0;
        if(this.type == "L")
            this.length = Math.sqrt((this.points[1].x-this.points[0].x)*(this.points[1].x-this.points[0].x) + (this.points[1].y-this.points[0].y)*(this.points[1].y-this.points[0].y));
        else if(this.type=="c") {
            let a = this.points[0];
            let b = this.points[1];
            let c = this.points[2];
            let d = this.points[3];

            this.v1 = {x: -3*(a.x-x) + 9*(b.x-x) - 9*(c.x-x) + 3*(d.x-x), y: -3*(a.y-y)+9*(b.y-y) - 9*(c.y-y) + 3*(d.y-y)};
            this.v2 = {x: 6*(a.x-x) - 12*(b.x-x) + 6*(c.x-x), y: 6*(a.y-y)-12*(b.y-y)+6*(c.y-y)};
            this.v3 = {x: -3*(a.x-x) + 3*(b.x-x), y: -3*(a.y-y) + 3*(b.y-y)};
        }
    }

    get(index) {
        switch(this.type) {
        case "M":
            return this.points[0];
        case "L":
            return {x: (this.points[0].x*(1-index) + index*this.points[1].x), y: (this.points[0].y*(1-index) + index*this.points[1].y)};
        case "c":
            let ab = {x: (this.points[0].x*(1-index) + index*this.points[1].x), y: (this.points[0].y*(1-index) + index*this.points[1].y)};
            let bc = {x: (this.points[1].x*(1-index) + index*this.points[2].x), y: (this.points[1].y*(1-index) + index*this.points[2].y)};
            let cd = {x: (this.points[2].x*(1-index) + index*this.points[3].x), y: (this.points[2].y*(1-index) + index*this.points[3].y)};
            
            let abbc = {x: ab.x*(1-index) + bc.x * index, y: ab.y*(1-index) + bc.y * index};
            let bccd = {x: bc.x*(1-index) + cd.x * index, y: bc.y*(1-index) + cd.y * index};

            return {x: abbc.x * (1-index) + bccd.x * index, y: abbc.y * (1-index) + bccd.y * index};
        }
    }

    increment(index, speed) {
        switch(this.type) {
            case "M": return 1;
            case "L":
                // return 1;
                return index + speed / this.length;
            case "c":
                let t = index;
                for(let i = 0; i < 100; i++) {
                    let fin = {x:(t*t*this.v1.x)+(t*this.v2.x) + (this.v3.x), y: (t*t*this.v1.y)+(t*this.v2.y) + (this.v3.y)};
                    let l = Math.sqrt(fin.x*fin.x + fin.y*fin.y);
                    t = t + (speed/100) / l;
                }
                return t;
        }
    }

}
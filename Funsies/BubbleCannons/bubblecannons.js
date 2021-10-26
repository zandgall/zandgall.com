// @ts-ignore
let player = new BubblePlayer();
let lastlife = 1;
let lifedisplaytime = 1;
// @ts-ignore
let enemies = [];
let increment = -1;
let lvlenms = [];
// @ts-ignore
let can = document.getElementById("Canvas");
currentCanvas = can;

let sheet = new Image();
sheet.src = "Funsies/BubbleCannons/sheet.png";

/// Level stuff
let levels, playing = false;
var toLevels = function(response) {
    levels = response; 
}
let currentWorld = "world1";
let currentLevel = -1;

var background = undefined;

var projectiles = [];
// @ts-ignore
var path = [];

/// Money and upgrades 
let prm = 0; // Switch to "let" later on to prevent cheated money
var money = 0;

function countMoneyUntilRound(round) {
    var out = 0;
    for(var i = 0; i < round && i < levels[currentWorld].length; i++) {
        for(var j = 0; j < levels[currentWorld][i].enemies.length; j++) {
            out += new BubbleEnemy(levels[currentWorld][i].enemies[j].id, sheet).life;
        }
    }
    return out*10;
}

/**
 * 
 * @param {number} x1 
 * @param {number} y1 
 * @param {number} x2 
 * @param {number} y2 
 * @param {number} x3 
 * @param {number} y3 
 * @param {number} x4 
 * @param {number} y4 
 */
// @ts-ignore
var ll = function(x1, y1, x2, y2, x3, y3, x4, y4) {

    // calculate the direction of the lines
    let uA = ((x4-x3)*(y1-y3) - (y4-y3)*(x1-x3)) / ((y4-y3)*(x2-x1) - (x4-x3)*(y2-y1));
    let uB = ((x2-x1)*(y1-y3) - (y2-y1)*(x1-x3)) / ((y4-y3)*(x2-x1) - (x4-x3)*(y2-y1));

    // if uA and uB are between 0-1, lines are colliding
    if (uA >= 0 && uA <= 1 && uB >= 0 && uB <= 1) {
      return true;
    }
    return false;
}
// @ts-ignore
var lb = function(x1, y1, x2, y2, x, y, w, h) {
    return ll(x1, y1, x1+x2, y1+y2, x, y, x+w, y) || ll(x1, y1, x1+x2, y1+y2, x+w, y, x+w, y+h) || ll(x1, y1, x1+x2, y1+y2, x, y+h, x+w, y+h) || ll(x1, y1, x1+x2, y1+y2, x, y, x, y+h);
}

// Next level (+world if applicable)
function iterate() {
    currentLevel++;
}

function getPath() {
    // return levels[currentWorld][currentLevel].path;
    let paths = levels[currentWorld][0].path.split("~");
    let cx = 0, cy = 0;
    for(let i = 0; i < paths.length; i++) {
        // @ts-ignore
        path.push(new PathSegment(paths[i], cx, cy));
        cx = path[i].points[path[i].points.length-1].x;
        cy = path[i].points[path[i].points.length-1].y;
    }
}

function getImage() {
    var img = new Image(800, 800);
    img.src = levels[currentWorld][0].img;
    return img;
}

/// Main loop
async function main() {
    if(background==undefined) {
        await Promise.resolve(fetch("Funsies/BubbleCannons/bclvls.json").then(response => response.json()).then(toLevels));
        // await fetch("Funsies/BubbleCannons/bclvls.json").then(response => response.json()).then(toLevels);
        background = getImage();
        if(path.length == 0) {
            getPath();
        }
    }


    if(playing) {
        if(increment==-1) {
            lvlenms = levels[currentWorld][currentLevel].enemies;
        }
        for(let i = 0; i < lvlenms.length; i++) {
            if(lvlenms[i].time == increment) {
                enemies.push(new BubbleEnemy(lvlenms[i].id, sheet));
                lvlenms.splice(i, 1);
                i--;
            }
        }
        increment++;
    }
    
    can = document.getElementById("Canvas");
    // @ts-ignore
    let c = can.getContext("2d");
    // c.imageSmoothingEnabled = false;
    c.clearRect(0, 0, 800, 800);
    c.drawImage(background, 0, 0);

    if(prm!=money) {
        console.log("Oh you silly little hacker");
        money = prm;
    }
    for(let i = 0; i < enemies.length; i++) {
        if(enemies[i].tick()) {
            enemies.splice(i, 1);
            i--;
            continue;
        }
        enemies[i].draw(c);
    }

    for(let i = 0; i < projectiles.length; i++) {
        projectiles[i].travel();
        if(projectiles[i].x > 852 || projectiles[i].x < -52 || projectiles[i].y > 852 || projectiles[i].y < -52) {
            projectiles.splice(i, 1);
            i--;
            continue;
        }
        projectiles[i].draw(c);
    }

    if(enemies.length == 0 && lvlenms.length == 0)
        playing = false;
    prm = money;

    player.tick();
    player.render(c);
    if(player.life!=lastlife && lastlife>0){
        lifedisplaytime=1;
        lastlife = player.life;
    }

    if(player.life<=0) {
        lifedisplaytime+=0.03;
        c.fillStyle="rgba(0, 0, 0, " + (lifedisplaytime-1)+")";
        c.fillRect(0, 0, 800, 800);
        c.fillStyle="#ffffff";
        if(lifedisplaytime>3)
            c.fillText("Sorry...", 100, 100);
        if(lifedisplaytime>5)
            c.fillText("You lose! Round "+currentLevel, 100, 150);
        
    }

    if(lifedisplaytime>0 || player.life<=0) {
        lifedisplaytime-=0.02;
        c.fillStyle="rgba(0, 255, 0, "+lifedisplaytime+")";
        c.fillRect(0, 0, 800*(player.life/player.maxLife), 10);
        c.fillStyle="rgba(255, 0, 0, "+lifedisplaytime+")";
        c.fillRect(Math.max(0, 800*(player.life/player.maxLife)), 0, 800, 10);
    }

    c.fillStyle="#ffff00";
    c.strokeStyle="#000000";
    c.font = "32px Arial";
    c.strokeText("$"+money.toLocaleString(), 10, 40);
    c.fillText("$"+money.toLocaleString(), 10, 40);
    let v = c.measureText(player.life.toLocaleString()+"/"+player.maxLife.toLocaleString());
    c.strokeText(player.life.toLocaleString()+"/"+player.maxLife.toLocaleString(), 790-v.width, 40);
    c.fillText(player.life.toLocaleString()+"/"+player.maxLife.toLocaleString(), 790-v.width, 40);
}

// @ts-ignore
$(document).ready(function() {
    window.setInterval(main, 1000/60);
    document.getElementById("universal").scrollTop = 290;
});
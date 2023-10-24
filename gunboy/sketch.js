let xVel = 0;
let yVel = 0;
let x = 200;
let y = 655;
let bulletxVel = 0;
let bulletx = 200
let bullety = 680
let bosshealth = 0
let bossx = 590
let bossy = 637
let bossw = 150
let bossh = 150
let healthbarx = 512.5
let healthbary = 530
let healthbarw = 150
let bossattackx = 590
let bossattacky = 637
let shoot = 0
let bossattackVelx = 0
let startx = 380
let startx2 = 389
let checkifshoot = 0
let hp = 3;
let invincibility = 0;
let playbutton = 0
let selectedlevel = 0
let show = 0
let natpng;
let polex = 550
let flagx = 505
let menux = 100
let menux1 = 125
let menux2 = 425
let menux3 = 210
let menux4 = 508
let leavebutton = 0
let youwin = 0
let phase = 0
let weapon = 1
let bulletx2 = x
let bullety2 = y
let bulletx2Vel = 0

function setup() {
  createCanvas(800, 800);
  natpng = loadImage("nat.png");
  natcrouchpng = loadImage("natcrouch.png")
  natjumppng = loadImage("natjump.png")
}

function draw() {
  background(0, 255, 255);
  
  stroke(0, 0, 0);
  
  if(keyIsDown(49)) {
    weapon = 1
  }
  
  if(keyIsDown(50)) {
    weapon = 2
  }
  
  if(keyIsDown(68))
    xVel+=0.5;
  
  if(keyIsDown(65))
    xVel+=-0.5;
  
  if(keyIsDown(87) && y >= 655)
    yVel = - 15;
  
  if(keyIsDown(32) && y >= 655)
    yVel = - 15;

  
  if(mouseIsPressed && bulletxVel == 0 && shoot == 1 && selectedlevel == 1 && weapon == 1 && phase == 1) { 
    bulletxVel = 15;
    bulletx = x;
    bullety = y;
  }
   
  if(mouseIsPressed && bulletxVel == 0 && shoot == 1 && selectedlevel == 1 && weapon == 1 && phase == 2) { 
    bulletxVel = 15;
    bulletx = x;
    bullety = y;
  }
  
  if(weapon == 2) {
  fill(0, 0, 0); 
  ellipse (bulletx2, bullety2, 10, 10);
  }
  
  if(mouseIsPressed && bulletx2Vel == 0 && shoot == 1 && selectedlevel == 1 && weapon == 2) { 
    bulletx2Vel = 10;
    bulletx2 = x - 0;
    bullety2 = y;
  }
  
  if(bulletx2 >= 540 && phase == 1 && bulletx2Vel == 10) {
    bulletx2 = x;
    bullety2 = y;
    bulletx2Vel = 0;
    bosshealth += 1.5
    healthbarw -= 7.5
  }
  
  if(bulletx2 >= 465 && phase == 2 && bulletx2Vel == 10) {
    bulletx2 = x;
    bullety2 = y;
    bulletx2Vel = 0;
    bosshealth += 1
    healthbarw -= 5
  }
  
  bulletx2 += bulletx2Vel
  xVel = xVel * 0.9;
  x+=xVel;
  
  bulletx += bulletxVel
  xVel = xVel * 0.9;
  x+=xVel;
  
  yVel += 0.95;
  yVel = yVel * 0.995;
  y+=yVel;
  if(y >= 655) {
    y = 655;
    yVel = 0;
  }
  
  if(mouseIsPressed && shoot == 0) {
    startx = 99999999
    startx2 = 99999999
    shoot = 1
    checkifshoot = 1
  }
  
  fill(97, 94, 93);
  rect(startx, 380, 70, 47);
  
  fill(0, 255, 110);
  textSize(25)
  text("Start", startx2, 394, 100, 100);
  
  if(x >= 480 && invincibility <= 0 && selectedlevel == 1 && phase == 1) {
    hp--;
    invincibility = 60;
  }
  invincibility --;
  if(bulletx >= 540 && phase == 1) {
    bulletx = x;
    bullety = y;
    bulletxVel = 0;
    bosshealth += 1
    healthbarw -= 5
  }
  
  if(shoot == 1 && checkifshoot == 1 && selectedlevel == 1 && youwin == 0 && phase == 1) {
    bossattackx -= 1
    bossattackVelx = -5;
  }
  bossattackx+=bossattackVelx
  if(bossattackx <= -100 && youwin == 0 && selectedlevel == 1 && phase == 1) {
    bossattackx = 590
    bossattacky = random(600, 700);
  }
    
  if(bosshealth == 30 && selectedlevel == 1){
  bossx = 99999999
  bossattacky = -99999999
  }
  
  if(invincibility <= 0 && bossattackx >= x - 20 && bossattackx <= x + 20 && selectedlevel == 1) {
    if(keyIsDown(83)) {
      if(bossattacky <= y + 50 && bossattacky >= y + 10) {
        invincibility = 60;
        hp--;
      }
    } else if(bossattacky <= y + 50 && bossattacky >= y - 50) {
      invincibility = 60;
      hp--;
    }
  }
  
  if(x >= 440 && phase == 2 && youwin == 0 && invincibility <= 0) {
    invincibility = 60;
    hp--;
  }
  
  if(hp <= 0) {
    fill(999, 999, 999);
    textSize(80)
    text("YOU DIED", 300, 300, 200, 200);
    return;
  }
  
  if(bosshealth >= 30)
  healthbarx = 99999999
  
  if(bosshealth >= 30 && youwin == 0 && phase == 2) {
  youwin = 1
  fill(999, 999, 999);
  textSize(80);
  text("YOU WIN!", 300, 300, 200, 200)
  selectedlevel = 0
  bossx = 99999999
  bossattacky = 99999999
  }
  
  fill(0, 255, 0);
  rect(-1, 700, 801, 800);
  
  fill(0, 0, 0);
  if(bulletxVel != 0)
    ellipse(bulletx, bullety, 17, 5);
  
  fill(999, 999, 999);
  if(keyIsDown(83))
    image(natcrouchpng, x-80/2, y-70/2-10, 80, 100)
  else if(keyIsDown(87))
    image(natjumppng, x-80/2, y-70/2-10, 80, 100)
  else
    image(natpng, x-80/2, y-100/2, 80, 100);

  if(hp==3)
    fill(207, 219, 31);
  else if(hp==2)
    fill(252, 152, 45);
  else
    fill(255, 0, 0);
  rect(20, 765, 55, 25);
  
  fill(0, 0, 0);
  textSize(16)
  text(hp + " hp", 30, 780);
  
  // Flag
  noStroke();
  if(selectedlevel == 0) {
    fill(255, 0, 0);
    if(youwin == 1)
      fill(250, 238, 2);
    rect(polex, 600, 15, 100);
    stroke(0, 0, 0);
    fill(255, 255, 255);
    rect(flagx, 580, 60, 40);
  }
   
  if(youwin == 1 && hp >= 2) {
      fill(250, 238, 2);
    rect(polex, 600, 15, 100);
    stroke(0, 0, 0);
    fill(255, 255, 255);
    rect(flagx, 580, 60, 40);
 }
  
  if(youwin == 1 && hp == 1) {
    fill(255, 0, 0);
    rect(polex, 600, 15, 100);
    stroke(0, 0, 0);
    fill(255, 255, 255);
    rect(flagx, 580, 60, 40);
  }
    
  if(selectedlevel == 0 && hp == 1 && youwin == 1) {
    rect(flagx, 580, 60, 40)
    text("B", 530, 605);
  }
    
  if(selectedlevel == 0 && hp == 2 && youwin == 1) {
    rect(flagx, 580, 60, 40)
    text("A", 530, 605);
  }
    
  if(selectedlevel == 0 && hp == 3 && youwin == 1) {
    rect(flagx, 580, 60, 40)
    text("A+", 527, 605);
  }
  
  if(bulletx2Vel == 0) {
    bulletx2 = x - 17.5
    bullety2 = y + 15
  }
  
  if(show == 1) {
  fill(0, 0, 0);
  rect(menux, 350, 600, 250);
  fill(255, 0, 0);
  rect(menux1, 420, 250, 100);
  rect(menux2, 420, 250, 100);
  fill(0, 255, 0);
  textSize(40);
  text("Start", menux3, 484);
  text("leave", menux4, 484);
  }
  
  if(mouseIsPressed && mouseX <= 565 && mouseX >= 505 && mouseY <= 620 && mouseY >= 580 && selectedlevel == 0) {
    show = 1
  }
  
  if(mouseIsPressed && mouseX <= 565 && mouseX >= 550 && mouseY <= 700 && mouseY >= 580 && selectedlevel == 0) {
    show = 1
  }
  
  if(mouseIsPressed && mouseX <= menux1 + 250 && mouseX >= menux1 && mouseY <= 520 && mouseY >= 420 && show == 1) {
    
    playbutton = 1
    
    selectedlevel = 1
    
    youwin = 0
    
    show = 0
    polex = 99999999
    flagx = 99999999
    
    bosshealth = 0
    
    hp = 3
    
    bossx = 590
       
    healthbarx = 512.5
    healthbary = 530
    healthbarw = 150
    
    phase = 1
  }
  
  if(phase == 1) {
    bossx = 590
    bossy = 637
    bossw = 150
    bossh = 150
    healthbarx = 512.5
    healthbary = 530
  if(bulletx >= 540) {
    bulletx = x
    bullety = y
    bosshealth += 1
    healthbarw -= 5
  }
    bossattackx -= 1;
    bossattackVelx = -5;
  }
  
  if(bosshealth >= 15) {
    phase = 2
  }
  
  if(phase == 2 && youwin == 0) {
    bossw = 200
    bossh = 200
    bossx = 565
    bossy = 617
    healthbarx = 487.5
    healthbary = 485
    if(bulletx >= 465 && bulletxVel == 15){
    bulletx = x;
    bullety = y;
    bulletxVel = 0
    bosshealth += 0.5;
    healthbarw -= 2.5;
  }
    bossattackx -= 1;
    bossattackVelx = -10;
    if(bossattackx <= -801 && youwin == 0 && selectedlevel == 1 && phase == 2) {
    bossattackx = bossx
    bossattacky = random(500, 700);
  }
  }

  if(mouseIsPressed && mouseX <= menux2 + 250 && mouseX >= menux2 && mouseY <= 520 && mouseY >= 420 && show == 1) {
    
    show = 0
  }
  
  if(playbutton == 1) {
  
  stroke(0, 0, 0);  
  
  fill(0, 0, 0);
  ellipse(bossattackx, bossattacky, 60, 35);
  
    
  if((bulletx >= 450 || bulletx2 >= 525) && youwin == 0 && (bulletxVel == 15 || bulletx2Vel == 10) && selectedlevel == 1 && playbutton == 1 && phase == 1) { 
  fill(255, 255, 255);
  }else if((bulletx >= 450 || bulletx2 >= 450) && youwin == 0 && (bulletxVel == 15 || bulletx2Vel == 10) && selectedlevel == 1 && playbutton == 1 && phase == 2) { 
  fill(255, 255, 255);}
  else{
  fill(237, 90, 250);
  }
    
  ellipse(bossx, bossy, bossw, bossh); 
  
  fill(166, 163, 162);
  rect(healthbarx, healthbary, 150, 15);
  
  fill(255, 51, 0);
  rect(healthbarx, healthbary, healthbarw, 15);
  }
  
  polex = 550
  flagx = 505
  
  if(youwin == 2 && hp >= 2) {
      fill(250, 238, 2);
    rect(polex, 600, 15, 100);
    stroke(0, 0, 0);
    fill(255, 255, 255);
    rect(flagx, 580, 60, 40);
 }
  
  if(youwin == 2 && hp == 1) {
    fill(255, 0, 0);
    rect(polex, 600, 15, 100);
    stroke(0, 0, 0);
    fill(255, 255, 255);
    rect(flagx, 580, 60, 40);
  }
    
  if(selectedlevel == 0 && hp == 1 && youwin == 2) {
    rect(flagx, 580, 60, 40)
    text("B", 530, 605);
  }
    
  if(selectedlevel == 0 && hp == 2 && youwin == 2) {
    rect(flagx, 580, 60, 40)
    text("A", 530, 605);
  }
    
  if(selectedlevel == 0 && hp == 3 && youwin == 2) {
    rect(flagx, 580, 60, 40)
    text("A+", 527, 605);
  }
  
  if(show == 1) {
  fill(0, 0, 0);
  rect(menux, 350, 600, 250);
  fill(255, 0, 0);
  rect(menux1, 420, 250, 100);
  rect(menux2, 420, 250, 100);
  fill(0, 255, 0);
  textSize(40);
  text("Start", menux3, 484);
  text("leave", menux4, 484);
  }
}
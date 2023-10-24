let canvas = document.getElementById("c");
let region_painting_canvas = document.getElementById("paint");
let WIDTH = document.body.clientWidth;
let HEIGHT = document.body.clientHeight;
let mouseX, mouseY, mouseLeft, mouseRight, mouseMiddle, mouseClicked = false;
let mapXOffset = 0, mapYOffset = 0, mapZoom = 1;

let mapTiles = {}, mapBorder = new Image();

let tool = "marking";

let msk0 = new Image();
msk0.src = "icons/msk0.png";

let pause = false;
let mapMarkerIcons = {}, selectedMarker = -1, movingMarker = false;
let selectedRegion = -1, paintRadius = 5, region_images = [], region_borders = [], erasing = false;
let map;
fetch("./map.json", {cache: "no-store"}).then((response) => response.json()).then((json) => map = json).then((json) => init_map_stuff(json));

let menu = {on: false, x:0, y:0, blockX: 0, blockY: 0, transformed: false};

function addMapMarker(type) {
    mapMarkerIcons[type] = new Image();
    mapMarkerIcons[type].src = "icons/markers/"+type+".png";
}

function createBorder(img, col) {
    let out = new Image();
    let pctx = region_painting_canvas.getContext("2d", {willReadFrequently: true});
    pctx.drawImage(img, 0, 0);
    let pixels = pctx.getImageData(0, 0, 3456, 3712);
    let npixel = pctx.createImageData(3456, 3712);
    let color = new Color(col);
    console.log(col, color);
    for(let y = 0; y < pixels.height; y++)
        for(let x = 0; x < pixels.width; x++) {        
            let i = ((y*pixels.width)+x);
            pixels.data[i*4+3] = (pixels.data[i*4+3] >= 200 ? 255 : 0); // Clip transparency
            if(pixels.data[4*i+3] > 0 && 
                (pixels.data[4*(i-1)+3] < 200 || pixels.data[4*(i+1)+3]<200 || pixels.data[4*(i-pixels.width)+3]<200 || pixels.data[4*(i+pixels.width)+3]<200  || pixels.data[4*(i-pixels.width-1)+3]<200 || pixels.data[4*(i-pixels.width+1)+3]<200 || pixels.data[4*(i+pixels.width-1)+3]<200 || pixels.data[4*(i+pixels.width+1)+3]<200)) {
                npixel.data[4*i] = color.coords[0]*255;
                npixel.data[4*i+1] = color.coords[1]*255;
                npixel.data[4*i+2] = color.coords[2]*255;
                npixel.data[4*i+3] = 255;
                npixel.data[4*(i-1)] = color.coords[0]*255;
                npixel.data[4*(i-1)+1] = color.coords[1]*255;
                npixel.data[4*(i-1)+2] = color.coords[2]*255;
                npixel.data[4*(i-1)+3] = 255;
                npixel.data[4*(i+1)] = color.coords[0]*255;
                npixel.data[4*(i+1)+1] = color.coords[1]*255;
                npixel.data[4*(i+1)+2] = color.coords[2]*255;
                npixel.data[4*(i+1)+3] = 255;
                npixel.data[4*(i-pixels.width)] = color.coords[0]*255;
                npixel.data[4*(i-pixels.width)+1] = color.coords[1]*255;
                npixel.data[4*(i-pixels.width)+2] = color.coords[2]*255;
                npixel.data[4*(i-pixels.width)+3] = 255;
                npixel.data[4*(i+pixels.width)] = color.coords[0]*255;
                npixel.data[4*(i+pixels.width)+1] = color.coords[1]*255;
                npixel.data[4*(i+pixels.width)+2] = color.coords[2]*255;
                npixel.data[4*(i+pixels.width)+3] = 255;
                npixel.data[4*(i-pixels.width-1)] = color.coords[0]*255;
                npixel.data[4*(i-pixels.width-1)+1] = color.coords[1]*255;
                npixel.data[4*(i-pixels.width-1)+2] = color.coords[2]*255;
                npixel.data[4*(i-pixels.width-1)+3] = 255;
                npixel.data[4*(i-pixels.width+1)] = color.coords[0]*255;
                npixel.data[4*(i-pixels.width+1)+1] = color.coords[1]*255;
                npixel.data[4*(i-pixels.width+1)+2] = color.coords[2]*255;
                npixel.data[4*(i-pixels.width+1)+3] = 255;
                npixel.data[4*(i+pixels.width-1)] = color.coords[0]*255;
                npixel.data[4*(i+pixels.width-1)+1] = color.coords[1]*255;
                npixel.data[4*(i+pixels.width-1)+2] = color.coords[2]*255;
                npixel.data[4*(i+pixels.width-1)+3] = 255;
                npixel.data[4*(i+pixels.width+1)] = color.coords[0]*255;
                npixel.data[4*(i+pixels.width+1)+1] = color.coords[1]*255;
                npixel.data[4*(i+pixels.width+1)+2] = color.coords[2]*255;
                npixel.data[4*(i+pixels.width+1)+3] = 255;
            }
        }
    
    pctx.putImageData(npixel, 0, 0, 0, 0, 3456, 3712);
    out.src = region_painting_canvas.toDataURL();
    pctx.clearRect(0, 0, 3456, 3712);
    return out;
}

function init_map_stuff(json) {
    for(r in json["regions"]) {
        region_images.push(new Image());
        region_images[r].addEventListener('load', function(event) {
            console.log("Creating border...");
            region_borders.push(createBorder(this, json.regions[r].color));
            console.log("Created border!");
        }, { once: true });
        region_images[r].src = "regions/"+r+".png";
        $('<button id="r'+r+'" type="button" style="margin-left:10px; appearance:initial; width:50; height:50; background-color:'+map.regions[r].color+'" onclick="set_selected_region('+r+');"></button>').insertBefore("#addNewRegion");
    }
}

function map_tile_setup() {
    addMapMarker("default");
    addMapMarker("important-place");
    addMapMarker("exclamation");
    addMapMarker("question");
    addMapMarker("house");
    addMapMarker("tree");
    addMapMarker("pin");

    mapBorder.src = "border.png";
    for(x = 0; x < 27; x++) {
        for(z = -14; z < 15; z++) {
            mapTiles["x"+x+"z"+z] = new Image();
            mapTiles["x"+x+"z"+z].src = "baseTiles/map."+x+"."+z+".png";
        }
    }
}

CanvasRenderingContext2D.prototype.outlineText = function(text, x, y) {
    // let fs = this.fillStyle;
    // fillStyle = this.strokeStyle;
    this.strokeText(text, x, y);
    this.fillText(text, x, y);
}

async function map_post(data) {
    await fetch("post.php", {
        method: 'POST',
        headers: {
            'Accept': "application/json",
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    }).then(response => response.text()).then(response=>console.log(response));
}

function placeMarker(x, z, type) {
    console.log(x, z, type);
    map["markers"].push({"x": x, "z": z, "type": type, "name": "Name", "description": ""});
    selectedMarker = map["markers"].length - 1;
    map_post({"key": "add_marker", "value": map.markers[selectedMarker]});
    $("#nameInput").val(map.markers[selectedMarker].name);
    $("#descInput").val(map.markers[selectedMarker].description);
    $("#input").css("visibility", "visible");
    $("#toolbar").css("visibility", "hidden");
}

function map_draw() {
    if(pause)
        return;
    let WIDTH = document.body.clientWidth;
    let HEIGHT = document.body.clientHeight;
    canvas.width = WIDTH;
    canvas.height = HEIGHT;

    let context = canvas.getContext("2d");
    context.font = "24px sans-serif";
    context.imageSmoothingEnabled = false;
    context.lineWidth = 1;
    context.clearRect(0, 0, WIDTH, HEIGHT);
    context.save();
    context.translate(WIDTH / 2, HEIGHT / 2);
    context.scale(mapZoom, mapZoom);
    context.translate(-WIDTH / 2, -HEIGHT / 2);
    context.translate(mapXOffset, mapYOffset);
    let t = context.getTransform();
    
    // let detran = (x, y) {
    //     return [Math.floor((x - t.e) / t.a), Math.floor((y - t.f) / t.d)];
    // }

    // console.log(t);
    for(x = Math.max(0, Math.floor((-t.e / t.a) / 128)); x < Math.min(27, Math.ceil(((-t.e + WIDTH) / t.a) / 128)); x++) {
        for(z = Math.max(-14, Math.floor((-t.f / t.d) / 128)); z < Math.min(15, Math.ceil(((-t.f + HEIGHT) / t.d) / 128)); z++) {
            context.drawImage(mapTiles["x"+x+"z"+z], x * 128, z * 128);
        }
    }
    let coordX = (bc_mouseX - t.e) / t.a;
    let coordZ = (bc_mouseY - t.f) / t.d;
    
    for(r in map["regions"]) {
        if(tool=="region-painting") {
            context.globalCompositeOperation = "screen";
            context.drawImage(region_images[r], 0, - 128*14, 3456, 3712);
            context.globalCompositeOperation = "overlay";
            context.drawImage(region_images[r], 0, - 128*14, 3456, 3712);
            context.globalCompositeOperation = "source-over";
        }
        context.drawImage(region_borders[r], 0, - 128*14, 3456, 3712);
    }

    context.lineWidth = 2/mapZoom;
    context.strokeStyle = "#000000";
    context.fillStyle = "#ffffff";
    context.strokeRect(Math.floor(coordX), Math.floor(coordZ), 1, 1);
    if(tool=="marking" && movingMarker && selectedMarker!=-1) {
        map.markers[selectedMarker].x = Math.floor(coordX)+0.5;
        map.markers[selectedMarker].z = Math.floor(coordZ)+0.5;
    }
    if(tool=="region-painting") {
        context.beginPath();
        context.ellipse(coordX, coordZ, paintRadius, paintRadius, 0, 0, 3.14159265*2);
        context.stroke();
    }
    if(tool=="marking" && mouseClicked) {
        if(movingMarker)
            map_post({"key": "marker_move", "marker": selectedMarker, "x": map.markers[selectedMarker].x, "z": map.markers[selectedMarker].z});
        movingMarker = false;
        selectedMarker = -1;
        $("#input").css("visibility", "hidden");
        $("#toolbar").css("visibility", "visible");
    }
    context.drawImage(mapBorder, 0, -14 * 128);
    if(map!=undefined && "markers" in map) {
        for(m in map["markers"]) {
            let marker = map["markers"][m];
            if(!(marker["type"] in mapMarkerIcons))
                marker["type"] = "default";
            let s = 32 / mapZoom;
            context.drawImage(mapMarkerIcons[marker["type"]], marker["x"]-s/2, marker["z"] - s/2, s, s);
            
            if(m==selectedMarker || (coordX >= marker["x"] - s/2 && coordX <= marker["x"] + s/2 && coordZ >= marker["z"] - s/2 && coordZ <= marker["z"] + s/2)) {
                context.font = 24 / mapZoom + "px sans-serif";
                context.outlineText(marker["name"], marker["x"] - context.measureText(marker["name"]).width / 2, marker["z"]-s);
                context.font = 18 / mapZoom + "px sans-serif";
                context.outlineText(marker["description"], marker["x"] - context.measureText(marker["description"]).width / 2, marker["z"]+s+12/mapZoom);
                context.fillStyle = "rgba(220, 220, 220, 0.9)";
                context.outlineText("("+(marker["x"]-64.5)+", "+(marker["z"]-64.5)+")", marker["x"] - context.measureText("("+(marker["x"]-64.5)+", "+(marker["z"]-64.5)+")").width / 2, marker["z"]-s-24/mapZoom);
                if(tool=="marking" && mouseClicked) {
                    selectedMarker = m;
                    $("#nameInput").val(map.markers[selectedMarker].name);
                    $("#descInput").val(map.markers[selectedMarker].description);
                    $("#input").css("visibility", "visible");
                    $("#toolbar").css("visibility", "hidden");
                }
            }
        }
    }
    
        
    coordX = Math.floor(coordX);
    coordZ = Math.floor(coordZ);
    
    if(tool=="marking" && menu.on) {
        if(!menu.transformed) {
            menu.blockX = Math.floor((menu.blockX - t.e) / t.a);
            menu.blockZ = Math.floor((menu.blockZ - t.f) / t.d);
            menu.transformed = true;
        }
        context.strokeStyle = "#ffff00";
        context.strokeRect(menu.blockX, menu.blockZ, 1, 1);
    }
    
    context.restore();
    context.fillStyle="rgba(128, 128, 128, 0.5)";
    context.fillRect(0, 0, WIDTH, 40);
    context.font = "24px sans-serif";

        
    
    context.strokeStyle = "#000000";
    context.fillStyle = "#ffffff";
    context.outlineText((coordX-64) + ", " + (coordZ-64), 6, 24);

    if(menu.on) {
        context.beginPath();
        context.fillStyle="rgba(128, 128, 128, 0.8)";
        context.strokeStyle="rgba(64, 64, 64, 0.8)";
        context.roundRect(menu.x - 100, menu.y - 200, 200, 180, 10);
        context.fill();
        context.stroke();

        if(tool=="marking") {
            context.strokeStyle = "#000000";
            context.fillStyle = "#ffffff";
            context.outlineText((menu.blockX-64) + ", " + (menu.blockZ-64), menu.x-context.measureText((menu.blockX-64)+", "+(menu.blockZ-64)).width/2, menu.y-180);

            let iconX = 0, iconY = 0;
            for(m in mapMarkerIcons) {
                context.drawImage(mapMarkerIcons[m], menu.x - 90 + iconX, menu.y - 160 + iconY, 32, 32);
                if(bc_mouseX >= menu.x - 90 + iconX && bc_mouseX <= menu.x - 90 + iconX + 32 && bc_mouseY >= menu.y - 160 + iconY && bc_mouseY <= menu.y - 160 + iconY + 32) {
                    context.outlineText(m, menu.x - context.measureText(m).width/2, menu.y - 210);
                    if(mouseClicked) {
                        console.log("Placing marker!");
                        placeMarker(menu.blockX+0.5, menu.blockZ+0.5, m);
                    }
                }
                iconX+=36;
                if(iconX >= 180) {
                    iconX = 0;
                    iconY += 36;
                }
            }
        }
    }

    if(mouseClicked)
        menu.on = false;
    mouseClicked = false;
}
function update_current_region() {
    pause = false;
    if(selectedRegion == -1 || selectedRegion >= region_images.length)
        return;
    
    let pctx = region_painting_canvas.getContext("2d", {willReadFrequently: true});
    if(!erasing)
        pctx.drawImage(region_images[selectedRegion], 0, 0);
    let pixels = pctx.getImageData(0, 0, 3456, 3712);
    let npixel = pctx.createImageData(3456, 3712);
    let color = new Color(map.regions[selectedRegion].color);
    for(let y = 0; y < pixels.height; y++)
        for(let x = 0; x < pixels.width; x++) {        
            let i = ((y*pixels.width)+x);
            pixels.data[i*4+3] = (pixels.data[i*4+3] >= 200 ? 255 : 0); // Clip transparency
            if(pixels.data[4*i+3] > 0 && (pixels.data[4*(i-1)+3] < 200 || pixels.data[4*(i+1)+3]<200 || pixels.data[4*(i-pixels.width)+3]<200 || pixels.data[4*(i+pixels.width)+3]<200  || pixels.data[4*(i-pixels.width-1)+3]<200 || pixels.data[4*(i-pixels.width+1)+3]<200 || pixels.data[4*(i+pixels.width-1)+3]<200 || pixels.data[4*(i+pixels.width+1)+3]<200)) {
                npixel.data[4*i] = color.coords[0]*255;
                npixel.data[4*i+1] = color.coords[1]*255;
                npixel.data[4*i+2] = color.coords[2]*255;
                npixel.data[4*i+3] = 255;
                npixel.data[4*(i-1)] = color.coords[0]*255;
                npixel.data[4*(i-1)+1] = color.coords[1]*255;
                npixel.data[4*(i-1)+2] = color.coords[2]*255;
                npixel.data[4*(i-1)+3] = 255;
                npixel.data[4*(i+1)] = color.coords[0]*255;
                npixel.data[4*(i+1)+1] = color.coords[1]*255;
                npixel.data[4*(i+1)+2] = color.coords[2]*255;
                npixel.data[4*(i+1)+3] = 255;
                npixel.data[4*(i-pixels.width)] = color.coords[0]*255;
                npixel.data[4*(i-pixels.width)+1] = color.coords[1]*255;
                npixel.data[4*(i-pixels.width)+2] = color.coords[2]*255;
                npixel.data[4*(i-pixels.width)+3] = 255;
                npixel.data[4*(i+pixels.width)] = color.coords[0]*255;
                npixel.data[4*(i+pixels.width)+1] = color.coords[1]*255;
                npixel.data[4*(i+pixels.width)+2] = color.coords[2]*255;
                npixel.data[4*(i+pixels.width)+3] = 255;
                npixel.data[4*(i-pixels.width-1)] = color.coords[0]*255;
                npixel.data[4*(i-pixels.width-1)+1] = color.coords[1]*255;
                npixel.data[4*(i-pixels.width-1)+2] = color.coords[2]*255;
                npixel.data[4*(i-pixels.width-1)+3] = 255;
                npixel.data[4*(i-pixels.width+1)] = color.coords[0]*255;
                npixel.data[4*(i-pixels.width+1)+1] = color.coords[1]*255;
                npixel.data[4*(i-pixels.width+1)+2] = color.coords[2]*255;
                npixel.data[4*(i-pixels.width+1)+3] = 255;
                npixel.data[4*(i+pixels.width-1)] = color.coords[0]*255;
                npixel.data[4*(i+pixels.width-1)+1] = color.coords[1]*255;
                npixel.data[4*(i+pixels.width-1)+2] = color.coords[2]*255;
                npixel.data[4*(i+pixels.width-1)+3] = 255;
                npixel.data[4*(i+pixels.width+1)] = color.coords[0]*255;
                npixel.data[4*(i+pixels.width+1)+1] = color.coords[1]*255;
                npixel.data[4*(i+pixels.width+1)+2] = color.coords[2]*255;
                npixel.data[4*(i+pixels.width+1)+3] = 255;
            }
            pixels.data[i*4] = color.coords[0]*255;
            pixels.data[i*4+1] = color.coords[1]*255;
            pixels.data[i*4+2] = color.coords[2]*255;
        }
    
    pctx.putImageData(pixels, 0, 0, 0, 0, 3456, 3712);
    let durl = region_painting_canvas.toDataURL();
    map_post({"key": "region_image", "region": selectedRegion, "value": durl});
    region_images[selectedRegion].src = durl;
    pctx.putImageData(npixel, 0, 0, 0, 0, 3456, 3712);
    region_borders[selectedRegion].src = region_painting_canvas.toDataURL();
    pctx.clearRect(0, 0, 3456, 3712);
}
let pdx = 0, pdy = 0;
function paint_on_region() {
    if(selectedRegion==-1)
        return;
    pause = true;
    let pctx = region_painting_canvas.getContext("2d");
    pctx.save();
    pctx.translate(WIDTH / 2, HEIGHT / 2);
    pctx.scale(mapZoom, mapZoom);
    pctx.translate(-WIDTH / 2, -HEIGHT / 2);
    pctx.translate(mapXOffset, mapYOffset);
    let t = pctx.getTransform();
    let coordX = (bc_mouseX - t.e) / t.a;
    let coordZ = (bc_mouseY - t.f) / t.d + 14*128;
    pctx.restore();
    if(erasing) {
        pctx.beginPath();
        pctx.arc(coordX, coordZ, paintRadius, 0, 3.14159265 * 2, false);
        pctx.save();
        pctx.clip();
        pctx.clearRect((coordX-paintRadius), (coordZ-paintRadius), paintRadius*2, paintRadius*2);
        pctx.restore();
    }
    else {
        pctx.beginPath();
        pctx.fillStyle = "#ffffff";
        pctx.ellipse(coordX, coordZ, paintRadius, paintRadius, 0, 0, 3.14159265*2);
        pctx.fill();
    }
    
    let ctx = canvas.getContext("2d");
    ctx.fillStyle = map.regions[selectedRegion].color;
    if(erasing)
        ctx.fillStyle = "#000000";
    ctx.strokeStyle = "#000000";
    ctx.beginPath();
    ctx.ellipse(pdx, pdy, paintRadius*mapZoom+1, paintRadius*mapZoom+1, 0, 0, 3.14159265*2);
    ctx.fill();
    ctx.beginPath();
    ctx.ellipse(bc_mouseX, bc_mouseY, paintRadius*mapZoom, paintRadius*mapZoom, 0, 0, 3.14159265*2);
    ctx.fill();
    ctx.stroke();
    pdx = bc_mouseX;
    pdy = bc_mouseY;
}
let space_pressed = false;
$(document).keydown((event) => {if(event.originalEvent.code=="Space")space_pressed = true;});
$(document).keyup((event) => {if(event.originalEvent.code=="Space")space_pressed = false;});
canvas.addEventListener('mousemove', function(event) {
    if(mouseLeft && tool=="region-painting"&&!space_pressed) {
        paint_on_region();
    } else if (mouseMiddle || mouseRight || mouseLeft) {
        mapXOffset += (event.x - bc_mouseX) / mapZoom;
        mapYOffset += (event.y - bc_mouseY) / mapZoom;
    }
    bc_mouseX = event.x;
    bc_mouseY = event.y;
});

canvas.addEventListener('mousedown', function (event) {
    if(bc_mouseY > 40) {
        if(event.button==0) {
            if(tool=="region-painting"&&!space_pressed) {
                if(erasing) {
                    let pctx = region_painting_canvas.getContext("2d", {willReadFrequently: true});
                    pctx.drawImage(region_images[selectedRegion], 0, 0);
                }
                pdx = bc_mouseX;
                pdy = bc_mouseY;
                paint_on_region();
            }
            mouseLeft = true;
        } else if(event.button==1)
            mouseMiddle=true;
        else if(event.button==2)
            mouseRight = true;
    }
});

canvas.addEventListener('mouseup', function(event) {
    if(event.button==0) {
        mouseLeft = false;
        if(tool=="region-painting"&&!space_pressed) {
            paint_on_region();
            update_current_region();
        }
    }
    else if(event.button==1)
        mouseMiddle = false;
    else if(event.button==2)
        mouseRight = false;
    if(event.button==0 && bc_mouseY > 48)
        mouseClicked = true;
});

let pdr = paintRadius;
canvas.addEventListener('wheel', function(event) {
    if(event.shiftKey || pause && tool=="region-painting") {
        if(pause) {
            pctx = canvas.getContext("2d");
            pctx.fillStyle = map.regions[selectedRegion].color;
            pctx.strokeStyle = "#000000";
            pctx.beginPath();
            pctx.ellipse(bc_mouseX, bc_mouseY, paintRadius*mapZoom+2, paintRadius*mapZoom+2, 0, 0, 3.14159265*2);
            pctx.fill();
            pctx.beginPath();
            pctx.ellipse(bc_mouseX, bc_mouseY, (paintRadius-event.deltaY * 0.001 * paintRadius)*mapZoom, (paintRadius-event.deltaY * 0.001 * paintRadius)*mapZoom, 0, 0, 3.14159265*2);
            pctx.fill();
            pctx.stroke();
        }
        paintRadius -= event.deltaY * 0.001 * paintRadius;
        paintRadius = Math.max(0.25, paintRadius);
    }
    else
        mapZoom -= event.deltaY * 0.001 * mapZoom;
    menu.on = false;
});

canvas.addEventListener('contextmenu', function(event) {
    event.preventDefault();
    if(tool=="region-painting")
        return;
    menu.on = true;
    menu.x = Math.max(100, Math.min(WIDTH-100, bc_mouseX));
    menu.y = Math.max(200, Math.min(HEIGHT, bc_mouseY));
    menu.transformed = false;
    menu.blockX = bc_mouseX;
    menu.blockZ = bc_mouseY;
});

function set_selected_region(newsel) {
    selectedRegion = newsel;
    if(newsel==-1)
        return;
    $("#r_nameInput").val(map.regions[selectedRegion].name);
    $("#r_descInput").val(map.regions[selectedRegion].description);
    $("#r_color").val(map.regions[selectedRegion].color);
}

$("#nameInput").keyup((event) => {
    if(selectedMarker!=-1) {
        map.markers[selectedMarker].name = $("#nameInput").val();
        map_post({"key": "marker_name", "marker": selectedMarker, "value": map.markers[selectedMarker].name});
    }
});
$("#descInput").keyup((event) => {
    if(selectedMarker!=-1) {
        map.markers[selectedMarker].description = $("#descInput").val();
        map_post({"key": "marker_description", "marker": selectedMarker, "value": map.markers[selectedMarker].description});
    }
});
$("#deleteMarker").click((event) => {
    if(selectedMarker!=-1) {
        map.markers.splice(selectedMarker, 1);
        map_post({"key": "marker_delete", "value": selectedMarker});
        selectedMarker = -1;
    }
});
$("#moveMarker").click(() => {
    movingMarker = true;
});

$("#r_nameInput").keyup((event) => {
    if(selectedRegion!=-1) {
        map.regions[selectedRegion].name = $("#r_nameInput").val();
        map_post({"key": "region_name", "region": selectedRegion, "value": map.regions[selectedRegion].name});
    }
});
$("#r_descInput").keyup((event) => {
    if(selectedRegion!=-1) {
        map.regions[selectedRegion].description = $("#r_descInput").val();
        map_post({"key": "region_description", "region": selectedRegion, "value": map.regions[selectedRegion].description});
    }
});
$("#r_deleteRegion").click((event) => {
    if(selectedRegion!=-1) {
        map.regions.splice(selectedRegion, 1);
        region_images.splice(selectedRegion, 1);
        region_borders.splice(selectedRegion, 1);
        $("#r"+selectedRegion).remove();
        map_post({"key": "region_delete", "value": selectedRegion});
        selectedRegion = -1;
    }
});
$(window).mousedown(() => {r_color_mcheck = true;}) 
$(window).mouseup(() => {r_color_mcheck = false;}) 
$("#r_color").on('input', function(event){
    if(selectedRegion!=-1) {
        map.regions[selectedRegion].color = $("#r_color").val();
        $("#r"+selectedRegion).css("background-color", $("#r_color").val());
        if(!r_color_mcheck) {
            update_current_region();
            map_post({"key": "region_color", "region": selectedRegion, "value": map.regions[selectedRegion].color});
        }
    }
});

$("#r_eraser").click(() => {erasing = true;});
$("#r_brush").click(() => {erasing = false;});

$("#icon_default").click(() => {
    if(selectedMarker!=-1) {
        map.markers[selectedMarker].type="default"; 
        map_post({"key":"marker_type", "marker":selectedMarker, "value":"default"})
    }
});
$("#icon_important-place").click(() => {
    if(selectedMarker!=-1) {
        map.markers[selectedMarker].type="important-place"; 
        map_post({"key":"marker_type", "marker":selectedMarker, "value":"important-place"})
    }
});
$("#icon_exclamation").click(() => {
    if(selectedMarker!=-1) {
        map.markers[selectedMarker].type="exclamation"; 
        map_post({"key":"marker_type", "marker":selectedMarker, "value":"exclamation"})
    }
});
$("#icon_house").click(() => {
    if(selectedMarker!=-1) {
        map.markers[selectedMarker].type="house"; 
        map_post({"key":"marker_type", "marker":selectedMarker, "value":"house"})
    }
});
$("#icon_tree").click(() => {
    if(selectedMarker!=-1) {
        map.markers[selectedMarker].type="tree"; 
        map_post({"key":"marker_type", "marker":selectedMarker, "value":"tree"})
    }
});
$("#icon_pin").click(() => {
    if(selectedMarker!=-1) {
        map.markers[selectedMarker].type="pin"; 
        map_post({"key":"marker_type", "marker":selectedMarker, "value":"pin"})
    }
});

$("#addNewRegion").click(async () => {
    region_images.push(new Image());
    region_images[region_images.length-1].addEventListener('load', function(event) {
        console.log("Creating border...");
        region_borders.push(createBorder(region_images[region_images.length-1], "#ff00ff"));
        console.log("Created border!");
    }, { once: true });
    await map_post({"key": "add_region", "region": region_images.length-1, "value": {"name": "Region", "description": "Description", "color": "#ff00ff"}});
    region_images[region_images.length-1].src = "regions/"+(region_images.length-1)+".png";
    $('<button id="r'+(region_images.length-1)+'" type="button" style="margin-left:10px; appearance:initial; width:50; height:50; background-color:#ff00ff" onclick="set_selected_region('+(region_images.length-1)+');"></button>').insertBefore("#addNewRegion");
    await fetch("./map.json", {cache: "no-store"}).then((response) => response.json()).then((json) => map = json);
    set_selected_region(region_images.length - 1);
});

$("#tool_marking").click(()=>{tool="marking";$("#region-palette").css("visibility", "hidden");$("#r_input").css("visibility", "hidden");})
$("#tool_region-painting").click(()=>{tool="region-painting";$("#region-palette").css("visibility", "visible");$("#r_input").css("visibility", "visible");set_selected_region(selectedRegion);})
$("#tool_cartography").click(()=>{tool="cartography";$("#region-palette").css("visibility", "hidden");$("#r_input").css("visibility", "hidden");})

map_tile_setup();
window.setInterval(map_draw, 13);
window.setInterval(() => {
    fetch("./map.json", {cache: "no-store"}).then((response) => response.json()).then((json) => map = json);
}, 500);
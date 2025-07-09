var can = document.getElementById("canvas")

var hidden = document.getElementById("hidden")

let monkey_image_src = document.getElementById("monkey")
let skybox_back_src = document.getElementById("skybox_back")
let skybox_front_src = document.getElementById("skybox_front")
let skybox_bottom_src = document.getElementById("skybox_bottom")
let skybox_top_src = document.getElementById("skybox_top")
let skybox_left_src = document.getElementById("skybox_left")
let skybox_right_src = document.getElementById("skybox_right")

var WIDTH = 250
var HEIGHT = 250
var ZG_AFFINE = false
can.width = WIDTH
can.height = HEIGHT

let surface
let frame_buff = new Array(WIDTH*HEIGHT)
let depth_buff = new Array(WIDTH*HEIGHT)
let frame = 1

var monkey, cube, plane, pawn, hqcube
var monkey_image, skybox, persp, tf_monkey, tf_cube2, tf_cube3, tf_monkey2, tf_plane, tf_pawn, tf_skybox, mvp_uni, skybox_uni, monkey_uni, cam_center, cam_dir, cam_dist, cam

function main() { 
    let context = can.getContext("2d")
    surface = context.getImageData(0, 0, WIDTH, HEIGHT)

    hidden_context = hidden.getContext("2d")
    hidden.width = monkey_image_src.width
    hidden.height = monkey_image_src.height // I think setting the canvas width and height manually resets the context transform
    hidden_context.scale(1, -1)
    hidden_context.drawImage(monkey_image_src, 0, -hidden.height)

    monkey_image = new sampler2D()
    monkey_image.w = monkey_image_src.width
    monkey_image.h = monkey_image_src.height
    monkey_image.data = hidden_context.getImageData(0, 0, monkey_image.w, monkey_image.h).data

    hidden.width = skybox_back_src.width
    hidden.height = skybox_back_src.height // skybox images all have the same dimensions so we dont need to update this anymore for the rest of the skybox images
    hidden_context.scale(1, -1)
    skybox = new cubemap()

    // Take a lot of pixel data out of loaded images
    hidden_context.drawImage(skybox_back_src, 0, -hidden.height)
    skybox.sides[0].w = hidden.width
    skybox.sides[0].h = hidden.height
    skybox.sides[0].data = hidden_context.getImageData(0, 0, hidden.width, hidden.height).data

    hidden_context.drawImage(skybox_front_src, 0, -hidden.height)
    skybox.sides[1].w = hidden.width
    skybox.sides[1].h = hidden.height
    skybox.sides[1].data = hidden_context.getImageData(0, 0, hidden.width, hidden.height).data
    
    hidden_context.drawImage(skybox_bottom_src, 0, -hidden.height)
    skybox.sides[2].w = hidden.width
    skybox.sides[2].h = hidden.height
    skybox.sides[2].data = hidden_context.getImageData(0, 0, hidden.width, hidden.height).data

    hidden_context.drawImage(skybox_top_src, 0, -hidden.height)
    skybox.sides[3].w = hidden.width
    skybox.sides[3].h = hidden.height
    skybox.sides[3].data = hidden_context.getImageData(0, 0, hidden.width, hidden.height).data
    
    hidden_context.drawImage(skybox_left_src, 0, -hidden.height)
    skybox.sides[4].w = hidden.width
    skybox.sides[4].h = hidden.height
    skybox.sides[4].data = hidden_context.getImageData(0, 0, hidden.width, hidden.height).data

    hidden_context.drawImage(skybox_left_src, 0, -hidden.height)
    skybox.sides[4].w = hidden.width
    skybox.sides[4].h = hidden.height
    skybox.sides[4].data = hidden_context.getImageData(0, 0, hidden.width, hidden.height).data

    hidden_context.drawImage(skybox_right_src, 0, -hidden.height)
    skybox.sides[5].w = hidden.width
    skybox.sides[5].h = hidden.height
    skybox.sides[5].data = hidden_context.getImageData(0, 0, hidden.width, hidden.height).data

    hidden_context.drawImage(monkey_image_src, 0, -hidden.height)
    
    // Build uniform variables to pass to shaders
    persp = perspective(3.14159265 / 2, WIDTH / HEIGHT, 0.1, 100.0)
    tf_monkey = new matrix()
    tf_monkey.rotate(0.72, {x:0,y:1,z:0})
    tf_monkey.rotate(0.6, {x:1,y:0,z:0})
    tf_monkey.translate({x:0,y:0.5,z:0})

    tf_monkey2 = new matrix()
    tf_monkey2.rotate(2.72, {x:0,y:1,z:0})
    tf_monkey2.rotate(0.6, {x:1,y:0,z:0})
    tf_monkey2.translate({x:-3,y:0.5,z:-2})

    tf_plane = new matrix()
    tf_plane.scale({x:5,y:1,z:5})
    tf_plane.rotate(0.72, {x:0,y:1,z:0})
    
    tf_cube2 = new matrix()
    tf_cube2.rotate(-1.22, {x:1,y:0,z:0})
    tf_cube2.rotate(0.72, {x:0,y:1,z:0})
    tf_cube2.translate({x:-4,y:4.5,z:0})

    tf_cube3 = new matrix()
    tf_cube3.rotate(-0.42, {x:0,y:1,z:0})
    tf_cube3.scale({x:0.5,y:0.5,z:1.7})
    tf_cube3.translate({x:3,y:0.5,z:2})

    tf_pawn = new matrix()
    tf_pawn.translate({x:3,y:1,z:-6})

    tf_skybox = new matrix()

    mvp_uni = {m: new matrix(), v: new matrix(), p: persp}

    skybox_uni = {
        cubemap: skybox,
        cam_pos: {x:0,y:0,z:0}
    }

    monkey_uni = { 
        cubemap: skybox,
        texture: monkey_image,
        light_pos: {x:-10000, y:20000, z:-10000},
        cam_pos: {x:0, y:0, z:0},
        diffuse_color: {x:0,y:0.5,z:1},
        ambient_color: {x:0,y:0,z:0.1},
        specular_color: {x:1,y:1,z:0.9},
        reflect_amount: 0
    }

    cam_center = {x:0,y:0,z:0}
    cam_dir = v3normalize({x:1,y:1,z:1})
    cam_dist = 5

    cam = camera(v3add(cam_center, v3scale(cam_dir, cam_dist)), v3scale(cam_dir, -1), {x:0,y:1,z:0})

    monkey = loadObj("monkey.obj")
    cube = loadObj("cube.obj")
    plane = loadObj("plane.obj")
    pawn = loadObj("pawn.obj")
    hqcube = loadObj("hqcube.obj") 
}

function loop() {
    if(!$("#rasterizer_run").is(":checked")) {
        setTimeout(loop, 1000)
        return
    }

    ZG_AFFINE = $("#affine").is(":checked")
    let context = can.getContext("2d")
    ZG_DISABLE_CULLING = false
    skybox_uni.cam_pos = v3add(v3scale(cam_center, 1), v3scale(cam_dir, cam_dist))
    monkey_uni.cam_pos = v3add(v3scale(cam_center, 1), v3scale(cam_dir, cam_dist))
    monkey_uni.texture = monkey_image
    mvp_uni.p = persp
    mvp_uni.v = cam
    mvp_uni.m = tf_monkey
    monkey_uni.reflect_amount = 0.1
    monkey_uni.diffuse_color = {x:0, y:0.5, z:1}
    // console.log("MONKEY")
    drawObject(monkey, vs_mvp, mvp_uni, fs_monkey, monkey_uni)
    mvp_uni.m = tf_cube2
    // console.log("CUBE2")
    drawObject(cube, vs_mvp, mvp_uni, fs_monkey, monkey_uni)
    monkey_uni.texture = new sampler2D()
    mvp_uni.m = tf_plane
    // console.log("PLANE")
    drawObject(plane, vs_mvp, mvp_uni, fs_monkey, monkey_uni)

    let a = frame * 2 * 3.14159265 / 256
    let c = Math.cos(a), s = Math.sin(a)

    let rotation = new matrix()
    rotation.a = {x:c, y:0, z:-s, w:0}
    rotation.b = {x:0, y:1, z:0, w:0}
    rotation.c = {x:s, y:0, z:c, w:0}
    rotation.d = {x:0, y:0, z:0, w:1}

    rotation.translate({x:-3, y:-6, z:2})
    mvp_uni.m = rotation
    // console.log("CUBE")
    drawObject(cube, vs_mvp, mvp_uni, fs_monkey, monkey_uni)

    monkey_uni.reflect_amount = 0.8
    monkey_uni.diffuse_color = {x:1, y:0.9, z:0.8}
    mvp_uni.m = tf_cube3
    // console.log("CUBE3")
    drawObject(cube, vs_mvp, mvp_uni, fs_monkey, monkey_uni)

    mvp_uni.m = tf_monkey2
    // console.log("MONKEY2")
    drawObject(monkey, vs_mvp, mvp_uni, fs_refract, skybox_uni)

    mvp_uni.m = tf_pawn
    // console.log("PAWN")
    drawObject(pawn, vs_mvp, mvp_uni, fs_refract, skybox_uni)

    tf_skybox = cam.clone()
    tf_skybox.d = {x:0, y:0, z:0, w:1}
    mvp_uni.m = m_mult(persp, tf_skybox)
    ZG_DISABLE_CULLING = true
    if(ZG_AFFINE && $("#hqcube").is(":checked"))
        drawObject(hqcube, vs_skybox, mvp_uni, fs_skybox, skybox_uni)
    else 
        drawObject(cube, vs_skybox, mvp_uni, fs_skybox, skybox_uni)

    can.width = WIDTH
    can.height = HEIGHT
    context.putImageData(surface, 0, 0)

    frame++
    setTimeout(loop, 0)
}

window.addEventListener('load', function() {
    main();
})

var mouse_left = false, mouse_right = false

function mouseMove(ev) {
    if(mouse_right) {
        let f = v3scale(v3normalize(cam_dir), -1)
        let r = v3cross(f, {x:0, y:1, z:0})
        let u = v3cross(r, f)
        cam_center = v3add(cam_center, v3add(v3scale(r, -ev.movementX*0.01), v3scale(u, ev.movementY*0.01)))
        cam = camera(v3add(cam_center, v3scale(cam_dir, cam_dist)), v3scale(cam_dir, -1), {x:0,y:1,z:0})
    } else if(mouse_left) {
        let m = new matrix()
        m.rotate(ev.movementX*0.01, {x:0, y:1, z:0})
        cam_dir = v3normalize(transform3x3(m, cam_dir))
        m = new matrix()
        m.rotate(ev.movementY*0.01, v3cross({x:0, y:1, z:0}, cam_dir))
        cam_dir = v3normalize(transform3x3(m, cam_dir))
        cam = camera(v3add(cam_center, v3scale(cam_dir, cam_dist)), v3scale(cam_dir, -1), {x:0,y:1,z:0})
    }
}

function mouseWheel(ev) {
    cam_dist += cam_dist * Math.min(0.001 * ev.deltaY, 1)
    cam = camera(v3add(cam_center, v3scale(cam_dir, cam_dist)), v3scale(cam_dir, -1), {x:0,y:1,z:0})
    ev.preventDefault()
}  

$(document).on("ajaxStop", function() {
    console.log("AjaxStop")
    document.addEventListener("mousedown", (ev) => {
        if(ev.button == 0)
            mouse_left = true
        else
            mouse_right = true
    })
    document.addEventListener("mouseup", (ev) => {
        if(ev.button == 0)
            mouse_left = false
        else
            mouse_right = false
    })
    document.addEventListener("mousemove", mouseMove)
    document.addEventListener("wheel", mouseWheel)
    loop()

    $("#blur").change(function() {
        if (this.checked)
            $("#canvas").css("image-rendering", "smooth")
        else $("#canvas").css("image-rendering", "pixelated")
    })

    $("#affine").change(function() {
        if (this.checked) {
            $("#hqcube").css("visibility", "visible")
            $("#hqcubelabel").css("visibility", "visible")
        } else {
            $("#hqcube").css("visibility", "hidden")
            $("#hqcubelabel").css("visibility", "hidden")
        }
    })

    $("#quality").on("input", function(ev) {
        $("#quality-value").text(ev.target.value)
        WIDTH = ev.target.value
        HEIGHT = ev.target.value

        can.width = WIDTH
        can.height = HEIGHT

        let context = can.getContext("2d")
        surface = context.getImageData(0, 0, WIDTH, HEIGHT)
        frame_buff = new Array(WIDTH*HEIGHT)
        depth_buff = new Array(WIDTH*HEIGHT)
    })
})

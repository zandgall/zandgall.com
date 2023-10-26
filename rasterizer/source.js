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

function tri_draw_func(x, y, z, input) {
    if (y < 0 || y >= HEIGHT || x < 0 || x >= WIDTH)
        return
    // If the current pixel (x, y) was drawn this frame, and is closer to the camera, don't draw over it
    if(frame_buff[y*WIDTH + x] == frame && depth_buff[y * WIDTH + x] < z)
        return
    if(isNaN(input.x))
        throw new Error("Input is NaN: " + input)
    surface.data[((HEIGHT-1-y)*WIDTH + x) * 4 + 0] = Math.min(Math.max(input.x, 0), 1)*255
    surface.data[((HEIGHT-1-y)*WIDTH + x) * 4 + 1] = Math.min(Math.max(input.y, 0), 1)*255
    surface.data[((HEIGHT-1-y)*WIDTH + x) * 4 + 2] = Math.min(Math.max(input.z, 0), 1)*255
    surface.data[((HEIGHT-1-y)*WIDTH + x) * 4 + 3] = 255
    frame_buff[y*WIDTH + x] = frame
    depth_buff[y*WIDTH + x] = z
}

var monkey, cube, plane, pawn, hqcube
var monkey_image, skybox, persp, tf_monkey, tf_cube2, tf_cube3, tf_monkey2, tf_plane, tf_pawn, tf_skybox, mvp_uni, skybox_uni, monkey_uni, cam_center, cam_dir, cam_dist, cam

function main() {
    console.log("Running!")
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
    
    persp = perspective(3.14159265 / 2, WIDTH / HEIGHT, 0.1, 100.0)
    tf_monkey = new matrix()
    tf_monkey.rotate(0.72, new vec3(0,1,0))
    tf_monkey.rotate(0.6, new vec3(1,0,0))
    tf_monkey.translate(new vec3(0, 0.5, 0))

    tf_monkey2 = new matrix()
    tf_monkey2.rotate(2.72, new vec3(0, 1, 0))
    tf_monkey2.rotate(0.6, new vec3(1, 0, 0))
    tf_monkey2.translate(new vec3(-3, 0.5, -2))

    tf_plane = new matrix()
    tf_plane.scale(new vec3(5, 1, 5))
    tf_plane.rotate(0.72, new vec3(0, 1, 0))
    
    tf_cube2 = new matrix()
    tf_cube2.rotate(-1.22, new vec3(1, 0, 0))
    tf_cube2.rotate(0.72, new vec3(0, 1, 0))
    tf_cube2.translate(new vec3(-4, 4.5, 0))

    tf_cube3 = new matrix()
    tf_cube3.rotate(-0.42, new vec3(0, 1, 0))
    tf_cube3.scale(new vec3(0.5, 0.5, 1.7))
    tf_cube3.translate(new vec3(3, 0.5, 2))

    tf_pawn = new matrix()
    tf_pawn.translate(new vec3(3, 1, -6))

    tf_skybox = new matrix()

    mvp_uni = {m: new matrix(), v: new matrix(), p: persp}

    skybox_uni = {
        cubemap: skybox,
        cam_pos: new vec3(0,0,0)
    }

    monkey_uni = { 
        cubemap: skybox,
        texture: monkey_image,
        light_pos: new vec3(-10000, 20000, -10000),
        cam_pos: new vec3(0, 0, 0),
        diffuse_color: new vec3(0,0.5,1),
        ambient_color: new vec3(0,0,0.1),
        specular_color: new vec3(1,1,0.9),
        reflect_amount: 0
    }

    cam_center = new vec3(0,0,0)
    cam_dir = v3normalize(new vec3(1,1,1))
    cam_dist = 5

    cam = camera(v3add(cam_center, v3scale(cam_dir, cam_dist)), v3scale(cam_dir, -1), new vec3(0,1,0))

    monkey = load_obj("monkey.obj")
    cube = load_obj("cube.obj")
    plane = load_obj("plane.obj")
    pawn = load_obj("pawn.obj")
    hqcube = load_obj("hqcube.obj")

    // loop()
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
    monkey_uni.diffuse_color = new vec3(0, 0.5, 1)
    // console.log("MONKEY")
    draw_object(monkey, vs_mvp, mvp_uni, fs_monkey, monkey_uni)
    monkey_uni.texture = new sampler2D()
    mvp_uni.m = tf_plane
    // console.log("PLANE")
    draw_object(plane, vs_mvp, mvp_uni, fs_monkey, monkey_uni)
    mvp_uni.m = tf_cube2
    // console.log("CUBE2")
    draw_object(cube, vs_mvp, mvp_uni, fs_monkey, monkey_uni)

    let a = frame * 2 * 3.14159265 / 256
    let c = Math.cos(a), s = Math.sin(a)

    let rotation = new matrix()
    rotation.a = new vec4(c, 0, -s, 0)
    rotation.b = new vec4(0, 1, 0, 0)
    rotation.c = new vec4(s, 0, c, 0)
    rotation.d = new vec4(0, 0, 0, 1)

    rotation.translate(new vec3(-3, -6, 2))
    mvp_uni.m = rotation
    // console.log("CUBE")
    draw_object(cube, vs_mvp, mvp_uni, fs_monkey, monkey_uni)

    monkey_uni.reflect_amount = 0.8
    monkey_uni.diffuse_color = new vec3(1, 0.9, 0.8)
    mvp_uni.m = tf_cube3
    // console.log("CUBE3")
    draw_object(cube, vs_mvp, mvp_uni, fs_monkey, monkey_uni)

    mvp_uni.m = tf_monkey2
    // console.log("MONKEY2")
    draw_object(monkey, vs_mvp, mvp_uni, fs_refract, skybox_uni)

    mvp_uni.m = tf_pawn
    // console.log("PAWN")
    draw_object(pawn, vs_mvp, mvp_uni, fs_refract, skybox_uni)

    tf_skybox = cam.clone()
    tf_skybox.d = new vec4(0, 0, 0, 1)
    mvp_uni.m = m_mult(persp, tf_skybox)
    ZG_DISABLE_CULLING = true
    // console.log("SKYBOX")
    if(ZG_AFFINE && $("#hqcube").is(":checked"))
        draw_object(hqcube, vs_skybox, mvp_uni, fs_skybox, skybox_uni)
    else 
        draw_object(cube, vs_skybox, mvp_uni, fs_skybox, skybox_uni)

    can.width = WIDTH
    can.height = HEIGHT
    // console.log("IMAGING")
    context.putImageData(surface, 0, 0)

    frame++
    // console.log("Frame: ", frame)
    console.log("Frame")
    setTimeout(loop, 0)
}

window.addEventListener('load', function() {
    main();
})

var mouse_left = false, mouse_right = false

function mouseMove(ev) {
    if(mouse_right) {
        let f = v3scale(v3normalize(cam_dir), -1)
        let r = v3cross(f, new vec3(0, 1, 0))
        let u = v3cross(r, f)
        cam_center = v3add(cam_center, v3add(v3scale(r, -ev.movementX*0.01), v3scale(u, ev.movementY*0.01)))
        cam = camera(v3add(cam_center, v3scale(cam_dir, cam_dist)), v3scale(cam_dir, -1), new vec3(0,1,0))
    } else if(mouse_left) {
        let m = new matrix()
        m.rotate(ev.movementX*0.01, new vec3(0, 1, 0))
        cam_dir = transform3x3(m, cam_dir)
        m = new matrix()
        m.rotate(ev.movementY*0.01, v3cross(new vec3(0, 1, 0), cam_dir))
        cam_dir = transform3x3(m, cam_dir)
        cam = camera(v3add(cam_center, v3scale(cam_dir, cam_dist)), v3scale(cam_dir, -1), new vec3(0,1,0))
    }
}

function mouseWheel(ev) {
    cam_dist += cam_dist * Math.min(0.001 * ev.deltaY, 1)
    cam = camera(v3add(cam_center, v3scale(cam_dir, cam_dist)), v3scale(cam_dir, -1), new vec3(0,1,0))
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
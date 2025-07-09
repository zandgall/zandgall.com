var LARGE = 1.0e10

// Called by clipping.js -> shade_clip_tri
function shadeTriangle(vertices, fragment_shader, f_uni) {

    /**
     * vertices can be given to us in any order here. What we need to do, is find the top, bottom, and middle points (in terms of y).
     * It doesn't have to be in terms of y, but that's what we chose, arbitrarily
    */

    let t = undefined, m = undefined, b = undefined

    // Calculate the screenspace y-position of each arg, in order to compare them and find the top, middle, and bottom point
    let a0y = vertices[0].pos.y / vertices[0].pos.w
    let a1y = vertices[1].pos.y / vertices[1].pos.w
    let a2y = vertices[2].pos.y / vertices[2].pos.w

    // Find the top point
    if (a0y <= a1y && a0y <= a2y) {
        t = vertices[0];

        m = vertices[1];
        b = vertices[2];
    } else if (a1y <= a2y && a1y <= a0y) {
        t = vertices[1];

        m = vertices[2];
        b = vertices[0];
    } else {
        t = vertices[2];

        m = vertices[0];
        b = vertices[1];
    }

    // If middle and bottom aren't set correctly yet, swap them
    if (m.pos.y/m.pos.w > b.pos.y/b.pos.w) {
        let _ = b;
        b = m;
        m = _;
    }

    /**
     * We now have the top, middle, and bottom points.
     * We will now create new vertices to represent the screen position.
     * We only need 6 values, the on-screen (x, y) positions of each of the 3 points
     * We will store as a float because we do exclusively floating point math with them
    */

    let st_x = Math.floor(WIDTH * 0.5 * (t.pos.x/t.pos.w+1))
    if(st_x <= -LARGE || st_x >= LARGE) // Check to prevent infinite loops
        return;
    let st_y = Math.floor(HEIGHT * 0.5 * (t.pos.y/t.pos.w + 1))
    if(st_y <= -LARGE || st_y >= LARGE) // Check to prevent infinite loops
        return;

    let sm_x = Math.floor(WIDTH * 0.5 * (m.pos.x/m.pos.w + 1))
    if(sm_x <= -LARGE || sm_x >= LARGE) // Check to prevent infinite loops
        return;
    let sm_y = Math.floor(HEIGHT * 0.5 * (m.pos.y/m.pos.w + 1))
    if(sm_y <= -LARGE || sm_y >= LARGE) // Check to prevent infinite loops
        return;
        
    let sb_x = Math.floor(WIDTH * 0.5 * (b.pos.x/b.pos.w + 1))
    if(sb_x <= -LARGE || sb_x >= LARGE) // Check to prevent infinite loops
        return;
    let sb_y = Math.floor(HEIGHT * 0.5 * (b.pos.y/b.pos.w + 1))
    if(sb_y <= -LARGE || sb_y >= LARGE) // Check to prevent infinite loops
        return;

    /**
     * We use barycentric coordinates to aide in shading our triangles.
     * Barycentric calculations require "/ area of full triangle"
     * So we will compute 1 over the area of the triangle
    */
    let inv_area = 1 / ((sb_x - st_x) * (sm_y - st_y) - (sb_y - st_y) * (sm_x - st_x))
    if (inv_area == Infinity || inv_area == -Infinity || inv_area == 0) // If this triangle is impossible to draw, (or infinitesmal) then just return
        return;

    /**
     * Now, we shall calculate the slopes of each line.
     * tb being top->bottom slope, tm = top->middle slope, mb = middle->bottom slope
     * 
     * KEEP NOTE:
     * These slopes are X / Y, so they are technically "inverse slopes", but for every y+=1, we will increase x values by these slopes.
     * They are the change in x over the change in y
    */
    let tb = (sb_x - st_x) / (sb_y - st_y)
    let tm = (sm_x - st_x) / (sm_y - st_y)
    let mb = (sb_x - sm_x) / (sb_y - sm_y)

    /**
     * During the rasterization, we will have one point that travels from the top to the bottom, and one that travels from the top to the middle
     * We will call them ants, and they only need to be represented by their x-position
     * As we scan down from y=st_y to y=sm_y, the "straight_ant" will be updated by the top->bottom slope
     * and the "switch_ant" will be updated by the top->middle slope
     * Once we hit y=sm_y, the straight_ant will continue to be updated by top->bottom, but
     * switch_ant will be updated by middle->bottom slope
    */
    let straight_ant = st_x, switch_ant = st_x

    /**
     * If the top of the triangle is flat, (i.e. the top->middle slope is +- infinity)
     * then we need to skip directly to the middle->bottom half of the triangle.
     * In this instance, switch_ant needs to have the x-position of the middle point at the beginning
    */
    if (tm == Infinity || tm == -Infinity || tm === undefined) // Flat top
        switch_ant = sm_x

    // Declaring and allocating our current vertex
    let current_vertice = {pos:{x:0,y:0,z:0,w:1}}

    // The y-loop. Loop from y = st_y, to sm_y. Along the way, increment straight and switch ant by their respective slopes
    for (let y = Math.floor(st_y); y < sm_y; y++, straight_ant += tb, switch_ant += tm)
        if (y >= 0 && y < HEIGHT) { // only proceed if inside the screen. (In case of clip failure, or rounding errors that cause a point to exist off screen)
            // The x-loop, loop from the minimum x, to either straight_ant or switch_ant (continue until x is smaller than neither of them)
            for (let x = Math.floor(Math.min(straight_ant, switch_ant)); x < straight_ant || x < switch_ant; x++)
                if (x >= 0 && x < WIDTH) { // only proceed if inside the screen
                    // Calculate UVW (barycentric) coordinates.
                    let u = ((sb_x - x) * (sm_y - y) - (sb_y - y) * (sm_x - x)) * inv_area
                    let v = ((sb_x - st_x) * (y - st_y) - (sb_y - st_y) * (x - st_x)) * inv_area
                    let w = ((x - st_x) * (sm_y - st_y) - (y - st_y) * (sm_x - st_x)) * inv_area

                    // Calculate current point's distance from the "camera"
                    let d = 1.0 / (u / t.pos.w + v / m.pos.w + w / b.pos.w)
                    if(ZG_AFFINE)
                        for (const key in t) {
                            if (Object.keys(t[key]).length == 4)
                                current_vertice[key] = v4add(v4add(v4scale(t[key], u), v4scale(m[key], v)), v4scale(b[key], w))
                            else if (Object.keys(t[key]).length == 3)
                                current_vertice[key] = v3add(v3add(v3scale(t[key], u), v3scale(m[key], v)), v3scale(b[key], w))
                            else if (Object.keys(t[key]).length == 2)
                                current_vertice[key] = v2add(v2add(v2scale(t[key], u), v2scale(m[key], v)), v2scale(b[key], w))
                        }
                    else
                        for (const key in t)
                            if (Object.keys(t[key]).length == 4)
                                current_vertice[key] = v4scale(v4add(v4add(v4scale(t[key], u / t.pos.w), v4scale(m[key], v / m.pos.w)), v4scale(b[key], w / b.pos.w)), d)
                            else if (Object.keys(t[key]).length == 3)
                                current_vertice[key] = v3scale(v3add(v3add(v3scale(t[key], u / t.pos.w), v3scale(m[key], v / m.pos.w)), v3scale(b[key], w / b.pos.w)), d)
                            else if (Object.keys(t[key]).length == 2)
                                current_vertice[key] = v2scale(v2add(v2add(v2scale(t[key], u / t.pos.w), v2scale(m[key], v / m.pos.w)), v2scale(b[key], w / b.pos.w)), d)

                    let z = current_vertice.pos.z / current_vertice.pos.w
                    // If the current pixel (x, y) was drawn this frame, and is closer to the camera, don't draw over it
                    if(frame_buff[y*WIDTH + x] == frame && depth_buff[y * WIDTH + x] < z)
                        continue

                    // Call the given shade function with the interpolated vertex attributes, x and y screen position, and draw function
                    let input = fragment_shader(current_vertice, f_uni)
                    surface.data[((HEIGHT-1-y)*WIDTH + x) * 4 + 0] = Math.min(Math.max(input.x, 0), 1)*255
                    surface.data[((HEIGHT-1-y)*WIDTH + x) * 4 + 1] = Math.min(Math.max(input.y, 0), 1)*255
                    surface.data[((HEIGHT-1-y)*WIDTH + x) * 4 + 2] = Math.min(Math.max(input.z, 0), 1)*255
                    surface.data[((HEIGHT-1-y)*WIDTH + x) * 4 + 3] = 255
                    frame_buff[y*WIDTH + x] = frame
                    depth_buff[y*WIDTH + x] = z
                }
        }
    
    // See previous loop. Only difference here is y looping from sm_y to sb_y, and switch_ant being incremented by mb
    for (let y = Math.floor(sm_y); y < sb_y; y++, straight_ant += tb, switch_ant += mb)
        if (y >= 0 && y < HEIGHT) {
            for (let x = Math.floor(Math.min(straight_ant, switch_ant)); x < straight_ant || x < switch_ant; x++)
                if (x >= 0 && x < WIDTH) {
                    let u = ((sb_x - x) * (sm_y - y) - (sb_y - y) * (sm_x - x)) * inv_area
                    let v = ((sb_x - st_x) * (y - st_y) - (sb_y - st_y) * (x - st_x)) * inv_area
                    let w = ((x - st_x) * (sm_y - st_y) - (y - st_y) * (sm_x - st_x)) * inv_area

                    let d = 1.0 / (u / t.pos.w + v / m.pos.w + w / b.pos.w)

                    if(ZG_AFFINE)
                        for (const key in t) {
                            if (Object.keys(t[key]).length == 4)
                                current_vertice[key] = v4add(v4add(v4scale(t[key], u), v4scale(m[key], v)), v4scale(b[key], w))
                            else if (Object.keys(t[key]).length == 3)
                                current_vertice[key] = v3add(v3add(v3scale(t[key], u), v3scale(m[key], v)), v3scale(b[key], w))
                            else if (Object.keys(t[key]).length == 2)
                                current_vertice[key] = v2add(v2add(v2scale(t[key], u), v2scale(m[key], v)), v2scale(b[key], w))
                        }
                    else
                        for (const key in t)
                            if (Object.keys(t[key]).length == 4)
                                current_vertice[key] = v4scale(v4add(v4add(v4scale(t[key], u / t.pos.w), v4scale(m[key], v / m.pos.w)), v4scale(b[key], w / b.pos.w)), d)
                            else if (Object.keys(t[key]).length == 3)
                                current_vertice[key] = v3scale(v3add(v3add(v3scale(t[key], u / t.pos.w), v3scale(m[key], v / m.pos.w)), v3scale(b[key], w / b.pos.w)), d)
                            else if (Object.keys(t[key]).length == 2)
                                current_vertice[key] = v2scale(v2add(v2add(v2scale(t[key], u / t.pos.w), v2scale(m[key], v / m.pos.w)), v2scale(b[key], w / b.pos.w)), d)

                    let z = current_vertice.pos.z / current_vertice.pos.w
                    // If the current pixel (x, y) was drawn this frame, and is closer to the camera, don't draw over it
                    if(frame_buff[y*WIDTH + x] == frame && depth_buff[y * WIDTH + x] < z)
                        continue

                    // Call the given shade function with the interpolated vertex attributes, x and y screen position, and draw function
                    let input = fragment_shader(current_vertice, f_uni)
                    surface.data[((HEIGHT-1-y)*WIDTH + x) * 4 + 0] = Math.min(Math.max(input.x, 0), 1)*255
                    surface.data[((HEIGHT-1-y)*WIDTH + x) * 4 + 1] = Math.min(Math.max(input.y, 0), 1)*255
                    surface.data[((HEIGHT-1-y)*WIDTH + x) * 4 + 2] = Math.min(Math.max(input.z, 0), 1)*255
                    surface.data[((HEIGHT-1-y)*WIDTH + x) * 4 + 3] = 255
                    frame_buff[y*WIDTH + x] = frame
                    depth_buff[y*WIDTH + x] = z
                }
        }
}

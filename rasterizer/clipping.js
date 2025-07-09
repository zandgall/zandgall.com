var THRESHOLD = 0.001 // Account for floating point errors
var ZG_DISABLE_CULLING = false

function clipTriangleAugment(a, b, c, a_coord, b_coord, c_coord, fs, f_uni) {
    let ratio_ac = a_coord / (a_coord - c_coord);
	let ratio_bc = b_coord / (b_coord - c_coord);
	let seg1 = {pos:{x:0,y:0,z:0,w:1}}
	
    let seg2 = {pos:{x:0,y:0,z:0,w:1}}
	
	// Clip a->c
	for (const key in a)
		if (Object.keys(a[key]).length == 4)
			seg1[key] = v4add(v4scale(a[key], 1-ratio_ac), v4scale(c[key], ratio_ac))
		else if (Object.keys(a[key]).length == 3)
			seg1[key] = v3add(v3scale(a[key], 1-ratio_ac), v3scale(c[key], ratio_ac))
		else if (Object.keys(a[key]).length == 2)
			seg1[key] = v2add(v2scale(a[key], 1-ratio_ac), v2scale(c[key], ratio_ac))
	
	// Clip b->c
	for (const key in a)
		if (Object.keys(a[key]).length == 4)
			seg2[key] = v4add(v4scale(b[key], 1-ratio_bc), v4scale(c[key], ratio_bc))
		else if (Object.keys(a[key]).length == 3)
			seg2[key] = v3add(v3scale(b[key], 1-ratio_bc), v3scale(c[key], ratio_bc))
		else if (Object.keys(a[key]).length == 2)
			seg2[key] = v2add(v2scale(b[key], 1-ratio_bc), v2scale(c[key], ratio_bc))
	
	let drawable = [ seg1, seg2, c ]
	clipAndShadeTriangle(drawable, fs, f_uni)
	return true;
}

function clipTriangleCreate(a, b, c, a_coord, b_coord, c_coord, fs, f_uni) {
    let ratio_ab = b_coord / (b_coord - a_coord);
	let ratio_ac = c_coord / (c_coord - a_coord);

	let seg1 = {pos:{x:0,y:0,z:0,w:1}}
	
    let seg2 = {pos:{x:0,y:0,z:0,w:1}}

    // Clip a->b
	for (const key in a) {
		if (Object.keys(a[key]).length == 4)
			seg1[key] = v4add(v4scale(b[key], 1-ratio_ab), v4scale(a[key], ratio_ab))
		else if (Object.keys(a[key]).length == 3)
			seg1[key] = v3add(v3scale(b[key], 1-ratio_ab), v3scale(a[key], ratio_ab))
		else if (Object.keys(a[key]).length == 2)
			seg1[key] = v2add(v2scale(b[key], 1-ratio_ab), v2scale(a[key], ratio_ab))
	}

    let drawable = [ seg1, b, c ]
    clipAndShadeTriangle(drawable, fs, f_uni)

    // Clip a->c
	for (const key in a)
		if (Object.keys(a[key]).length == 4)
			seg2[key] = v4add(v4scale(c[key], 1-ratio_ac), v4scale(a[key], ratio_ac))
		else if (Object.keys(a[key]).length == 3)
			seg2[key] = v3add(v3scale(c[key], 1-ratio_ac), v3scale(a[key], ratio_ac))
		else if (Object.keys(a[key]).length == 2)
			seg2[key] = v2add(v2scale(c[key], 1-ratio_ac), v2scale(a[key], ratio_ac))

    drawable[1] = c
    drawable[2] = seg2
    clipAndShadeTriangle(drawable, fs, f_uni)
    return true
}

// Called by 
function clipTriangleAgainstPlane(a, b, c, a_coord, b_coord, c_coord, fs, f_uni) {
    if (a_coord < -THRESHOLD && b_coord < -THRESHOLD && c_coord < -THRESHOLD)
        return true // Reject triangle all points are outside clipping plane
    if (a_coord >= -THRESHOLD && b_coord >= -THRESHOLD && c_coord >= -THRESHOLD)
        return false // Draw as is, all points are inside the clipping plane
    if (a_coord < 0 && b_coord < 0 && c_coord >= 0) // Two points are outside, no new geometry is needed, just augment the given triangle
		return clipTriangleAugment(a, b, c, a_coord, b_coord, c_coord, fs, f_uni) // Done with this triangle
	if (b_coord < 0 && c_coord < 0 && a_coord >= 0)
		return clipTriangleAugment(b, c, a, b_coord, c_coord, a_coord, fs, f_uni)
	if (c_coord < 0 && a_coord < 0 && b_coord >= 0)
		return clipTriangleAugment(c, a, b, c_coord, a_coord, b_coord, fs, f_uni)

	if (a_coord < 0 && b_coord >= 0 && c_coord >= 0) // One point is outside, requires new geometry to be constructed
		return clipTriangleCreate(a, b, c, a_coord, b_coord, c_coord, fs, f_uni) // Done with this triangle
	if (b_coord < 0 && c_coord >= 0 && a_coord >= 0)
		return clipTriangleCreate(b, c, a, b_coord, c_coord, a_coord, fs, f_uni)
	if (c_coord < 0 && a_coord >= 0 && b_coord >= 0)
		return clipTriangleCreate(c, a, b, c_coord, a_coord, b_coord, fs, f_uni)
	return false
}

// Called by clipping.js -> draw
function clipAndShadeTriangle(vertices, fs, f_uni) {
	// Clip triangle across x=-w | w+x=0 plane
    if (clipTriangleAgainstPlane(vertices[0], vertices[1], vertices[2], vertices[0].pos.w + vertices[0].pos.x, vertices[1].pos.w + vertices[1].pos.x, vertices[2].pos.w + vertices[2].pos.x, fs, f_uni))
		return // Left
	// Clip triangle across x=w | w-x=0 plane
	if (clipTriangleAgainstPlane(vertices[0], vertices[1], vertices[2], vertices[0].pos.w - vertices[0].pos.x, vertices[1].pos.w - vertices[1].pos.x, vertices[2].pos.w - vertices[2].pos.x, fs, f_uni))
		return // Right
	// Clip triangle across y=-w | w+y=0 plane
	if (clipTriangleAgainstPlane(vertices[0], vertices[1], vertices[2], vertices[0].pos.w + vertices[0].pos.y, vertices[1].pos.w + vertices[1].pos.y, vertices[2].pos.w + vertices[2].pos.y, fs, f_uni))
		return // Bottom
	// Clip triangle across y=w | w-y=0 plane
	if (clipTriangleAgainstPlane(vertices[0], vertices[1], vertices[2], vertices[0].pos.w - vertices[0].pos.y, vertices[1].pos.w - vertices[1].pos.y, vertices[2].pos.w - vertices[2].pos.y, fs, f_uni))
		return // Top
	// Clip triangle across z=0 plane
	if (clipTriangleAgainstPlane(vertices[0], vertices[1], vertices[2], vertices[0].pos.z, vertices[1].pos.z, vertices[2].pos.z, fs, f_uni))
		return // Near
	// Clip triangle across z=w | w-z=0 plane
	if (clipTriangleAgainstPlane(vertices[0], vertices[1], vertices[2], vertices[0].pos.w - vertices[0].pos.z, vertices[1].pos.w - vertices[1].pos.z, vertices[2].pos.w - vertices[2].pos.z, fs, f_uni))
		return // Far

	if(!ZG_DISABLE_CULLING)
		// Check the cross product between (v1-v0) and (v2-v0), in order to see if it's facing towards or away from the camera
		if((vertices[1].pos.x/vertices[1].pos.w - vertices[0].pos.x/vertices[0].pos.w)*(vertices[2].pos.y/vertices[2].pos.w - vertices[0].pos.y/vertices[0].pos.w)
		 - (vertices[1].pos.y/vertices[1].pos.w - vertices[0].pos.y/vertices[0].pos.w)*(vertices[2].pos.x/vertices[2].pos.w - vertices[0].pos.x/vertices[0].pos.w) < 0)
		return	// Face is clockwise (facing away from camera)

	shadeTriangle(vertices, fs, f_uni)
}

// Draw triangle to the screen, take in the vertices, vertex and fragment shaders and uniform variables
function draw(vertices, vs, v_uni, fs, f_uni) {
	// Run verticies through vertex shader
	let a = vs(vertices[0], v_uni)
	let b = vs(vertices[1], v_uni)
	let c = vs(vertices[2], v_uni)

	// Send it through the pipe, clipping next
	let transformed = [ a, b, c ]
	clipAndShadeTriangle(transformed, fs, f_uni)
}

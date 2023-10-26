var THRESHOLD = 0.001 // Account for floating point errors
var ZG_DISABLE_CULLING = false

function shade_clip_plane_augment(a, b, c, a_coord, b_coord, c_coord, fs, f_uni) {
    let ratio_ac = a_coord / (a_coord - c_coord);
	let ratio_bc = b_coord / (b_coord - c_coord);
	let seg1 = vertex();
	
    let seg2 = vertex();
	
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
	shade_clip_tri(drawable, fs, f_uni)
	return true;
}

function shade_clip_plane_create(a, b, c, a_coord, b_coord, c_coord, fs, f_uni) {
    let ratio_ab = b_coord / (b_coord - a_coord);
	let ratio_ac = c_coord / (c_coord - a_coord);

	let seg1 = vertex();
	
    let seg2 = vertex();

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
    shade_clip_tri(drawable, fs, f_uni)

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
    shade_clip_tri(drawable, fs, f_uni)
    return true
}

function shade_clip_plane(a, b, c, a_coord, b_coord, c_coord, fs, f_uni) {
    if (a_coord < -THRESHOLD && b_coord < -THRESHOLD && c_coord < -THRESHOLD)
        return true // Reject triangle all points are outside clipping plane
    if (a_coord >= -THRESHOLD && b_coord >= -THRESHOLD && c_coord >= -THRESHOLD)
        return false // Draw as is, all points are inside the clipping plane
    if (a_coord < 0 && b_coord < 0 && c_coord >= 0) // Two points are outside, no new geometry is needed, just augment the given triangle
		return shade_clip_plane_augment(a, b, c, a_coord, b_coord, c_coord, fs, f_uni) // Done with this triangle
	if (b_coord < 0 && c_coord < 0 && a_coord >= 0)
		return shade_clip_plane_augment(b, c, a, b_coord, c_coord, a_coord, fs, f_uni)
	if (c_coord < 0 && a_coord < 0 && b_coord >= 0)
		return shade_clip_plane_augment(c, a, b, c_coord, a_coord, b_coord, fs, f_uni)

	if (a_coord < 0 && b_coord >= 0 && c_coord >= 0) // One point is outside, requires new geometry to be constructed
		return shade_clip_plane_create(a, b, c, a_coord, b_coord, c_coord, fs, f_uni) // Done with this triangle
	if (b_coord < 0 && c_coord >= 0 && a_coord >= 0)
		return shade_clip_plane_create(b, c, a, b_coord, c_coord, a_coord, fs, f_uni)
	if (c_coord < 0 && a_coord >= 0 && b_coord >= 0)
		return shade_clip_plane_create(c, a, b, c_coord, a_coord, b_coord, fs, f_uni)
	return false
}

function shade_clip_tri(args, fs, f_uni) {
    if (shade_clip_plane(args[0], args[1], args[2], args[0].pos.w + args[0].pos.x, args[1].pos.w + args[1].pos.x, args[2].pos.w + args[2].pos.x, fs, f_uni))
		return // Left
	if (shade_clip_plane(args[0], args[1], args[2], args[0].pos.w - args[0].pos.x, args[1].pos.w - args[1].pos.x, args[2].pos.w - args[2].pos.x, fs, f_uni))
		return // Right
	if (shade_clip_plane(args[0], args[1], args[2], args[0].pos.w + args[0].pos.y, args[1].pos.w + args[1].pos.y, args[2].pos.w + args[2].pos.y, fs, f_uni))
		return // Bottom
	if (shade_clip_plane(args[0], args[1], args[2], args[0].pos.w - args[0].pos.y, args[1].pos.w - args[1].pos.y, args[2].pos.w - args[2].pos.y, fs, f_uni))
		return // Top
	if (shade_clip_plane(args[0], args[1], args[2], args[0].pos.z, args[1].pos.z, args[2].pos.z, fs, f_uni))
		return // Near
	if (shade_clip_plane(args[0], args[1], args[2], args[0].pos.w - args[0].pos.z, args[1].pos.w - args[1].pos.z, args[2].pos.w - args[2].pos.z, fs, f_uni))
		return // Far

	if(!ZG_DISABLE_CULLING)
	if((args[1].pos.x/args[1].pos.w - args[0].pos.x/args[0].pos.w)*(args[2].pos.y/args[2].pos.w - args[0].pos.y/args[0].pos.w)
	 - (args[1].pos.y/args[1].pos.w - args[0].pos.y/args[0].pos.w)*(args[2].pos.x/args[2].pos.w - args[0].pos.x/args[0].pos.w) < 0)
		return	// Face must be clockwise, or facing away from camera

	shade_triangle(args, fs, f_uni)
}

function draw(args, vs, v_uni, fs, f_uni) {
    let a = vs(args[0], v_uni)
	let b = vs(args[1], v_uni)
	let c = vs(args[2], v_uni)
	// console.log(a, b, c)

	let trans = [ a, b, c ]
	shade_clip_tri(trans, fs, f_uni)
}
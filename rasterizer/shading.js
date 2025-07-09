// Image data
class sampler2D {
    constructor() {
        this.data = []
        this.w = 0
        this.h = 0
    }
}

// 6 images, cube mapping
class cubemap {
    constructor() {
        this.sides = [new sampler2D(), new sampler2D(), new sampler2D(), new sampler2D(), new sampler2D(), new sampler2D()]
    }
}

/* A BUNCH OF SHADERS
 * these functions will be used to transform verticies, or to define pixel data
 */

// An "MVP" transformation, that also passes a 'normal', world position, and uv data to the next fs shader
function vs_mvp(input, uni) {
    let out = {pos:{x:0,y:0,z:0,w:1}}
    out.pos = transform(uni.m, input.pos)
    out.normal = transform3x3(inverseTranspose3x3(uni.m), input.normal)
    out.worldPos = {x:out.pos.x, y:out.pos.y, z:out.pos.z}
    out.pos = transform(uni.p, transform(uni.v, out.pos))
    out.uv = input.uv
    return out
}

// A skybox transformation that keeps everything within the z=w maximum clip distance, and passes 3d texture uvw to the next fs shader
function vs_skybox(input, uni) {
    let out = {pos:{x:0,y:0,z:0,w:1}}
    out.pos = transform(uni.m, input.pos)
    out.pos.z = out.pos.w
    out.uvw = {x:input.pos.x, y:input.pos.y, z:input.pos.z}
    return out
}

// FRAGMENT SHADERS

// Helper function that just samples a texture
function texture2D(s, x, y) {
    let xi = Math.floor(Math.max(Math.min(x, 1), 0)*(s.w - 1))
    let yi = Math.floor(Math.max(Math.min(y, 1), 0)*(s.h - 1))
    let out = {x:s.data[(yi*s.w + xi)*4 + 0]/255, y:s.data[(yi*s.w + xi)*4 + 1]/255, z:s.data[(yi*s.w + xi)*4 + 2]/255, w:1}
    if(isNaN(out.x)) {
        console.log("Texture error:",out, xi, yi, s, s.data[(yi*s.w + xi) * 4 + 0], s.data[(yi*s.w + xi) * 4 + 1], s.data[(yi*s.w + xi) * 4 + 2], s.data[(yi*s.w + xi) * 4 + 3])
    }

    return out
}

// Helper function that samples a cubemap, picking a face depending on which coordinate has the greatest |absolute| value
function textureCubemap(s, x, y, z) {
    let m = Math.max(Math.abs(x), Math.abs(y), Math.abs(z))
    if(x/m==-1)
        return texture2D(s.sides[0], 0.5-z/m*0.5, 0.5+y/m*0.5)
    if(x/m==1)
        return texture2D(s.sides[1], 0.5+z/m*0.5, 0.5+y/m*0.5)
    if(y/m==-1)
        return texture2D(s.sides[2], 0.5+z/m*0.5, 0.5+x/m*0.5)
    if(y/m==1)
        return texture2D(s.sides[3], 0.5+z/m*0.5, 0.5-x/m*0.5)
    if(z/m==-1)
        return texture2D(s.sides[4], 0.5+x/m*0.5, 0.5+y/m*0.5)
    return texture2D(s.sides[5], 0.5-x/m*0.5, 0.5+y/m*0.5)
}

// just returns red
function fs_red(input, uni) {
    return {x:1, y:0, z:0, w:1}
}

// grayscale color based on depth
function fs_depth(input, uni) {
    return {x:input.pos.z, y:input.pos.z, z:input.pos.z, w:1}
}

// color based on position
function fs_pos(input, uni) {
    return {x:input.pos.x, y:input.pos.y, z:input.pos.z, w:1}
}

// color based on normal data
function fs_norm(input, uni) {
    return {x:input.normal.x, y:input.normal.y, z:input.normal.z, w:1}
}

// color based on uv texture data
function fs_uv(input, uni) {
    return {x:input.uv.x, y:input.uv.y, z:1, w:1}
}

// returns the sample of a texture
function fs_texture(input, uni) {
    return texture2D(uni.texture, input.uv.x, input.uv.y)
}

// shader used for the monkey obj, has specular reflection, reflects the skybox, texture data, ambient lighting, and diffuse lighting
function fs_monkey(input, uni) {
    let nnorm = v3normalize(input.normal)

    let light_dir = v3normalize(v3add(uni.light_pos, v3scale(input.worldPos, -1)))
    let view_dir = v3normalize(v3add(input.worldPos, v3scale(uni.cam_pos, -1)))
    let reflection = v3reflect(view_dir, nnorm)
    let reflect_sample = textureCubemap(uni.cubemap, reflection.x, reflection.y, reflection.z)
    let sky_bright = Math.sqrt(reflect_sample.x * reflect_sample.x + reflect_sample.y * reflect_sample.y + reflect_sample.z + reflect_sample.z)
    let diff = Math.max(v3dot(nnorm, light_dir) + sky_bright*0.2, 0)
    let diffuse = {x:0,y:0,z:0}
    let ambient = {x:0,y:0,z:0}
    if(uni.texture.w == 0 || uni.texture.h == 0) {
        diffuse = v3scale(uni.diffuse_color, diff)
        ambient = uni.ambient_color
    } else {
        let s = texture2D(uni.texture, input.uv.x, input.uv.y)
        diffuse = {x:diff*s.x, y:diff*s.y, z:diff*s.z}
        ambient = v3add({x:0.1*s.x, y:0.1*s.y, z:0.1*s.z}, uni.ambient_color)
    }

    let spec_reflect = v3reflect(v3scale(light_dir, -1), nnorm)
    let spec = Math.pow(Math.max(v3dot(v3scale(view_dir, -1), spec_reflect), 0.0), 32)
    let specular = v3scale(uni.specular_color, spec*0.5)

    base = {x:ambient.x + diffuse.x + specular.x, y:ambient.y + diffuse.y + specular.y, z:ambient.z + diffuse.z + specular.z, w:1}
    let out = v4add(v4scale(base, 1-uni.reflect_amount), v4scale(reflect_sample, uni.reflect_amount))
    return out
}

// Refracts the skybox
function fs_refract(input, uni) {
    let nnorm = v3normalize(input.normal)
    let view_dir = v3normalize(v3add(input.worldPos, v3scale(uni.cam_pos, -1)))

    // Air -> Glass IR = 0.658
    let refraction = v3refract(view_dir, nnorm, 0.658)
    let refract_sample = textureCubemap(uni.cubemap, refraction.x, refraction.y, refraction.z)
    let reflection = v3reflect(view_dir, nnorm)
    let reflect_sample = textureCubemap(uni.cubemap, reflection.x, reflection.y, reflection.z)

    let d = v3cross(view_dir, nnorm)
    let reflection_amount = d.x * d.x + d.y * d.y + d.z * d.z
    return v4add(v4scale(v4add(v4scale(reflect_sample, reflection_amount), v4scale(refract_sample, 1-reflection_amount)), 0.25*reflection_amount+0.75), {x:0.25*reflection_amount+0.25, y:0.25*reflection_amount+0.25, z:0.25*reflection_amount+0.25, w:0.25*reflection_amount+0.25})
}

// Samples the cubemap for the skybox
function fs_skybox(input, uni) {
    return textureCubemap(uni.cubemap, input.uvw.x, input.uvw.y, input.uvw.z)
}

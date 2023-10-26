class sampler2D {
    constructor() {
        this.data = []
        this.w = 0
        this.h = 0
    }
}

class cubemap {
    constructor() {
        this.sides = [new sampler2D(), new sampler2D(), new sampler2D(), new sampler2D(), new sampler2D(), new sampler2D()]
    }
}

function vs_mvp(input, uni) {
    let out = vertex()
    out.pos = transform(uni.m, input.pos)
    out.normal = transform3x3(inverseTranspose3x3(uni.m), input.normal)
    out.worldPos = new vec3(out.pos.x, out.pos.y, out.pos.z)
    out.pos = transform(uni.p, transform(uni.v, out.pos))
    out.uv = input.uv
    return out
}

function vs_skybox(input, uni) {
    let out = vertex()
    out.pos = transform(uni.m, input.pos)
    out.pos.z = out.pos.w
    out.uvw = new vec3(input.pos.x, input.pos.y, input.pos.z)
    return out
}

// FRAGMENT SHADERS

function texture2D(s, x, y) {
    let xi = Math.floor(Math.max(Math.min(x, 1), 0)*(s.w - 1))
    let yi = Math.floor(Math.max(Math.min(y, 1), 0)*(s.h - 1))
    let out = new vec4(s.data[(yi*s.w + xi)*4 + 0]/255, s.data[(yi*s.w + xi)*4 + 1]/255, s.data[(yi*s.w + xi)*4 + 2]/255, 1)
    if(isNaN(out.x)) {
        console.log("Texture error:",out, xi, yi, s, s.data[(yi*s.w + xi) * 4 + 0], s.data[(yi*s.w + xi) * 4 + 1], s.data[(yi*s.w + xi) * 4 + 2], s.data[(yi*s.w + xi) * 4 + 3])
    }

    return out
}

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

function fs_red(input, uni) {
    return new vec4(1, 0, 0, 1)
}

function fs_depth(input, uni) {
    return new vec4(input.pos.z, input.pos.z, input.pos.z, 1)
}

function fs_pos(input, uni) {
    return new vec4(input.pos.x, input.pos.y, input.pos.z, 1)
}

function fs_norm(input, uni) {
    return new vec4(input.normal.x, input.normal.y, input.normal.z, 1)
}

function fs_uv(input, uni) {
    return new vec4(input.uv.x, input.uv.y, 1, 1)
}

function fs_texture(input, uni) {
    return texture2D(uni.texture, input.uv.x, input.uv.y)
}

function fs_monkey(input, uni) {
    let nnorm = v3normalize(input.normal)

    let light_dir = v3normalize(v3add(uni.light_pos, v3scale(input.worldPos, -1)))
    let view_dir = v3normalize(v3add(input.worldPos, v3scale(uni.cam_pos, -1)))
    let reflection = v3reflect(view_dir, nnorm)
    let reflect_sample = textureCubemap(uni.cubemap, reflection.x, reflection.y, reflection.z)
    let sky_bright = Math.sqrt(reflect_sample.x * reflect_sample.x + reflect_sample.y * reflect_sample.y + reflect_sample.z + reflect_sample.z)
    let diff = Math.max(v3dot(nnorm, light_dir) + sky_bright*0.2, 0)
    let diffuse = new vec3(0,0,0)
    let ambient = new vec3(0,0,0)
    if(uni.texture.w == 0 || uni.texture.h == 0) {
        diffuse = v3scale(uni.diffuse_color, diff)
        ambient = uni.ambient_color
    } else {
        let s = texture2D(uni.texture, input.uv.x, input.uv.y)
        diffuse = new vec3(diff*s.x, diff*s.y, diff*s.z)
        ambient = v3add(new vec3(0.1*s.x, 0.1*s.y, 0.1*s.z), uni.ambient_color)
    }

    let spec_reflect = v3reflect(v3scale(light_dir, -1), nnorm)
    let spec = Math.pow(Math.max(v3dot(v3scale(view_dir, -1), spec_reflect), 0.0), 32)
    let specular = v3scale(uni.specular_color, spec*0.5)

    base = new vec4(ambient.x + diffuse.x + specular.x, ambient.y + diffuse.y + specular.y, ambient.z + diffuse.z + specular.z, 1)
    let out = v4add(v4scale(base, 1-uni.reflect_amount), v4scale(reflect_sample, uni.reflect_amount))
    return out
}

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
    return v4add(v4scale(v4add(v4scale(reflect_sample, reflection_amount), v4scale(refract_sample, 1-reflection_amount)), 0.25*reflection_amount+0.75), new vec4(0.25*reflection_amount+0.25, 0.25*reflection_amount+0.25, 0.25*reflection_amount+0.25, 0.25*reflection_amount+0.25))
}

function fs_skybox(input, uni) {
    return textureCubemap(uni.cubemap, input.uvw.x, input.uvw.y, input.uvw.z)
}
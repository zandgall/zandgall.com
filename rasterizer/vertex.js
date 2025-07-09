// Variety of linear algebra calculation functions!

function v4add(a, b) {
    return {x: a.x + b.x, y: a.y + b.y, z: a.z + b.z, w: a.w + b.w}
}

function v3add(a, b) {
    return {x: a.x + b.x, y: a.y + b.y, z: a.z + b.z}
}

function v2add(a, b) {
    return {x: a.x + b.x, y: a.y + b.y}
}

function v4scale(a, b) {
    return {x: a.x * b, y: a.y * b, z: a.z * b, w: a.w * b}
}

function v3scale(a, b) {
    return {x: a.x * b, y: a.y * b, z: a.z * b}
}

function v2scale(a, b) {
    return {x: a.x * b, y: a.y * b}
}

function v3dot(a, b) {
    return a.x * b.x + a.y * b.y + a.z * b.z
}

function v3cross(a, b) {
    return {x: a.y * b.z - a.z * b.y, y: a.z * b.x - a.x * b.z, z: a.x * b.y - a.y * b.x}
}

function v3normalize(a) {
    if (a.x == 0 && a.y == 0 && a.z == 0)
        return {x: Infinity, y: Infinity, z: Infinity}
    return v3scale(a, 1.0/Math.sqrt(a.x*a.x + a.y*a.y + a.z*a.z))
}

function v3reflect(a, n) {
    return v3add(a, v3scale(n, -2*v3dot(a,n))) // a - 2(a dot n) n
}

// https://registry.khronos.org/OpenGL-Refpages/gl4/html/refract.xhtml
function v3refract(a,n,eta) {
    let k = 1.0 - eta * eta * (1.0 - v3dot(n,a)*v3dot(n,a))
    if(k < 0)
        return {x: 0, y: 0, z: 0}
    return v3add(v3scale(a,eta), v3scale(n,eta * v3dot(n,a)+Math.sqrt(k)))
}

/// MATRICES

class matrix {
    constructor() {
        this.a = {x:1,y:0,z:0,w:0}
        this.b = {x:0,y:1,z:0,w:0}
        this.c = {x:0,y:0,z:1,w:0}
        this.d = {x:0,y:0,z:0,w:1}
    }

    clone() {
        let out = new matrix()
        out.a = {...this.a}
        out.b = {...this.b}
        out.c = {...this.c}
        out.d = {...this.d}
        return out
    }

    translate(translation) {
        this.d.x += translation.x
        this.d.y += translation.y
        this.d.z += translation.z
    }

    scale(scalar) {
        this.a = v4scale(this.a, scalar.x)
        this.b = v4scale(this.b, scalar.y)
        this.c = v4scale(this.c, scalar.z)
    }

    // Translated from https://github.com/g-truc/glm/blob/master/glm/ext/matrix_transform.inl
    rotate(angle, axis) {
        let c = Math.cos(angle)
        let s = Math.sin(angle)

        let temp = v3scale(axis, 1 - c)
        let r = new matrix()
        r.a.x = c + temp.x * axis.x
        r.b.x = temp.x * axis.y + s * axis.z
        r.c.x = temp.x * axis.z - s * axis.y

        r.a.y = temp.y * axis.x - s * axis.z
        r.b.y = c + temp.y * axis.y
        r.c.y = temp.y * axis.z + s * axis.x

        r.a.z = temp.z * axis.x + s * axis.y
        r.b.z = temp.z * axis.y - s * axis.x
        r.c.z = c + temp.z * axis.z

        let t = this.clone()
        this.a = v4add(v4add(v4scale(t.a, r.a.x), v4scale(t.b, r.a.y)), v4scale(t.c, r.a.z))
        this.b = v4add(v4add(v4scale(t.a, r.b.x), v4scale(t.b, r.b.y)), v4scale(t.c, r.b.z))
        this.c = v4add(v4add(v4scale(t.a, r.c.x), v4scale(t.b, r.c.y)), v4scale(t.c, r.c.z))
    }
}

function transform3x3(a, b) {
    let out4 = v4add(v4add(v4scale(a.a, b.x), v4scale(a.b, b.y)), v4scale(a.c, b.z))
    return {x:out4.x, y:out4.y, z:out4.z}
}

function transform(a, b) {
    if(b==undefined)
        console.log(a, b)
    return v4add(v4add(v4add(v4scale(a.a, b.x), v4scale(a.b, b.y)), v4scale(a.c, b.z)), v4scale(a.d, b.w))
}

function inverseTranspose3x3(a) {
    let out = new matrix()
    let determinant = + a.a.x * (a.b.y * a.c.z - a.b.z * a.c.y) - a.a.y * (a.b.x * a.c.z - a.b.z * a.c.x) + a.a.z * (a.b.x * a.c.y - a.b.y * a.c.x)

    out.a.x = + (a.b.y * a.c.z - a.c.y * a.b.z) / determinant
    out.a.y = - (a.b.x * a.c.z - a.c.x * a.b.z) / determinant
    out.a.z = + (a.b.x * a.c.y - a.c.x * a.b.y) / determinant
    out.b.x = - (a.a.y * a.c.z - a.c.y * a.a.z) / determinant
    out.b.y = + (a.a.x * a.c.z - a.c.x * a.a.z) / determinant
    out.b.z = - (a.a.x * a.c.y - a.c.x * a.a.y) / determinant
    out.c.x = + (a.a.y * a.b.z - a.b.y * a.a.z) / determinant
    out.c.y = - (a.a.x * a.b.z - a.b.x * a.a.z) / determinant
    out.c.z = + (a.a.x * a.b.y - a.b.x * a.a.y) / determinant

    return out
}

function m_mult(a, b) {
    let out = new matrix()
    out.a = transform(a, b.a)
    out.b = transform(a, b.b)
    out.c = transform(a, b.c)
    out.d = transform(a, b.d)
    return out
}

function transpose(a) {
    let out = new matrix()
    out.a = {x:a.a.x, y:a.b.x, z:a.c.x, w:a.d.x}
    out.b = {x:a.a.y, y:a.b.y, z:a.c.y, w:a.d.y}
    out.c = {x:a.a.z, y:a.b.z, z:a.c.z, w:a.d.z}
    out.d = {x:a.a.w, y:a.b.w, z:a.c.w, w:a.d.w}
    return out
}

function perspective(FOV, aspect, znear, zfar) {
    let tan_half_fov = Math.tan(FOV / 2.0)
    let out = new matrix()
    out.a.x = 1 / (aspect * tan_half_fov)
    out.b.y = 1 / tan_half_fov
    out.c.z = zfar / (znear - zfar)
    out.c.w = -1
    out.d.z = -(zfar * znear) / (zfar - znear)
    out.d.w = 0
    return out
}

function camera(pos, forward, up) {
    let f = v3normalize(v3scale(forward, -1))
    let s = v3normalize(v3cross(up, f))
    let u = v3cross(f, s)
    let out = new matrix()
    
    out.a.x = s.x
    out.b.x = s.y
    out.c.x = s.z
    out.a.y = u.x
    out.b.y = u.y
    out.c.y = u.z
    out.a.z = f.x
    out.b.z = f.y
    out.c.z = f.z
    
    out.d.x =-v3dot(s, pos)
    out.d.y =-v3dot(u, pos)
    out.d.z =-v3dot(f, pos)
    
    return out
}

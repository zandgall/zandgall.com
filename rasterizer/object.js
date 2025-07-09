// Obj face data, stores index to position, uv, and normal data in obj
class face {
    constructor() {
        this.a_v = -1, this.a_vt = -1, this.a_vn = -1
        this.b_v = -1, this.b_vt = -1, this.b_vn = -1
        this.c_v = -1, this.c_vt = -1, this.c_vn = -1
    }
}

class object {
    constructor() {
        this.vertices = []
        this.uvs = []
        this.normals = []
        this.faces = []
    }
}

// Load (specific kind of) .obj file
function loadObj(filepath) {

    let out = new object()
    $.ajax({
        url: filepath,
        beforeSend: function(xhr) {
            xhr.overrideMimeType("text/plain;")
        }
    }).done(function(data) {
        lines = data.split(/\r?\n/)
        for(let line_number = 0; line_number < lines.length; line_number++) {
            line = lines[line_number]
            if(line.startsWith("v ")) { // Vec3 position
                // find all decimals, ensure there's 3
                let nums = [...line.matchAll(/-?\d+\.\d*/g)]
                if (nums.length < 3)
                    console.error("Error: vertex at line #" + line_number + " doesn't have 3 or more coordinates")
                // We deal with Vec4s for our positions, default w=1
                out.vertices.push({x:parseFloat(nums[0]), y:parseFloat(nums[1]), z:parseFloat(nums[2]), w:1})
            } else if(line.startsWith("vt ")) { // Vec2 uv texture data
                let nums = [...line.matchAll(/-?\d+\.\d*/g)]
                if (nums.length < 2)
                    console.error("Error: vertex texture at line #" + line_number + " doesn't have 2 or more coordinates")
                out.uvs.push({x:parseFloat(nums[0]), y:parseFloat(nums[1])})
            } else if(line.startsWith("vn ")) { // Vec3 normal data
                let nums = [...line.matchAll(/-?\d+\.\d*/g)]
                if (nums.length < 3)
                    console.error("Error: vertex normal at line #" + line_number + " doesn't have 3 or more coordinates")
                out.normals.push({x:parseFloat(nums[0]), y:parseFloat(nums[1]), z:parseFloat(nums[2])})
            } else if (line.startsWith("f ")) { // Face indice data
                let nums = [...line.matchAll(/\d+/g)]
                let f = out.faces.length
                out.faces.push(new face())
                // Initialize different indices depending on what kinds of data has been read
                if(out.uvs.length + out.normals.length == 0) {
                    out.faces[f].a_v = parseFloat(nums[0]) - 1
                    out.faces[f].b_v = parseFloat(nums[1]) - 1
                    out.faces[f].c_v = parseFloat(nums[2]) - 1
                } else if(out.normals.length == 0) {
                    out.faces[f].a_v = parseFloat(nums[0])-1
                    out.faces[f].a_vt = parseFloat(nums[1])-1
                    out.faces[f].b_v = parseFloat(nums[2])-1
                    out.faces[f].b_vt = parseFloat(nums[3])-1
                    out.faces[f].c_v = parseFloat(nums[4])-1
                    out.faces[f].c_vt = parseFloat(nums[5])-1
                } else if(out.uvs.length == 0) {
                    out.faces[f].a_v = parseFloat(nums[0])-1
                    out.faces[f].a_vn = parseFloat(nums[1])-1
                    out.faces[f].b_v = parseFloat(nums[2])-1
                    out.faces[f].b_vn = parseFloat(nums[3])-1
                    out.faces[f].c_v = parseFloat(nums[4])-1
                    out.faces[f].c_vn = parseFloat(nums[5])-1
                } else {
                    out.faces[f].a_v = parseFloat(nums[0])-1
                    out.faces[f].a_vt = parseFloat(nums[1])-1
                    out.faces[f].a_vn = parseFloat(nums[2])-1
                    out.faces[f].b_v = parseFloat(nums[3])-1
                    out.faces[f].b_vt = parseFloat(nums[4])-1
                    out.faces[f].b_vn = parseFloat(nums[5])-1
                    out.faces[f].c_v = parseFloat(nums[6])-1
                    out.faces[f].c_vt = parseFloat(nums[7])-1
                    out.faces[f].c_vn = parseFloat(nums[8])-1
                }
            }
        }
    })
    return out
}

// Takes an object, and draws all of its triangles
function drawObject(obj, vs, v_uni, fs, f_uni) {

    // Constructs list of verticies we'll send through the pipeline
    let verts = [{pos:{x:0,y:0,z:0,w:1}}, {pos:{x:0,y:0,z:0,w:1}}, {pos:{x:0,y:0,z:0,w:1}}]
    for (let i = 0; i < obj.faces.length; i++) {
        verts[0].pos = obj.vertices[obj.faces[i].a_v]
        verts[1].pos = obj.vertices[obj.faces[i].b_v]
        verts[2].pos = obj.vertices[obj.faces[i].c_v]
        if(verts[2].pos==undefined) {
            console.log(verts[2], obj.vertices, obj.faces, i, obj.faces[i], obj.faces[i].c_v)
        }

        if(obj.faces[i].a_vt==-1) {
            verts[0]["uv"] = {x:0,y:0}
            verts[1]["uv"] = {x:0,y:0}
            verts[2]["uv"] = {x:0,y:0}
        } else {
            verts[0]["uv"] = obj.uvs[obj.faces[i].a_vt]
            verts[1]["uv"] = obj.uvs[obj.faces[i].b_vt]
            verts[2]["uv"] = obj.uvs[obj.faces[i].c_vt]
        }

        if(obj.faces[i].a_vn==-1) {
            verts[0]["normal"] = {x:0,y:0,z:0}
            verts[1]["normal"] = {x:0,y:0,z:0}
            verts[2]["normal"] = {x:0,y:0,z:0}
        } else {
            verts[0]["normal"] = obj.normals[obj.faces[i].a_vn]
            verts[1]["normal"] = obj.normals[obj.faces[i].b_vn]
            verts[2]["normal"] = obj.normals[obj.faces[i].c_vn]
        }

        draw(verts, vs, v_uni, fs, f_uni)
    }
}

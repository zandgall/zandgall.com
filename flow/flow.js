var cvs = $("#canvas")[0]

let mouse = {
	x: 0,
	y: 0,
	left: false,
	middle: false,
	right: false
}

const vsSource = `
attribute vec4 position;
uniform mat4 projection;

void main() {
    gl_Position = projection * position;
}`
const fsSource = `
void main() {
    gl_FragColor = vec4(1, 0, 0, 1);
}`

var gl, shader, shaderInfo, rect

function init() {
    gl = cvs.getContext("webgl2")

    if (gl === null) {
        $("#warning").css("display", "block")
        return;
    }

    gl.clearColor(0, 0, 0, 1)
    gl.clear(gl.COLOR_BUFFER_BIT)

    const vertShader = gl.createShader(gl.VERTEX_SHADER)
    gl.shaderSource(vertShader, vsSource)
    gl.compileShader(vertShader)
    if(!gl.getShaderParameter(vertShader, gl.COMPILE_STATUS)) {
        alert(`An error occured compiling vertex shader: ${gl.getShaderInfoLog(vertShader)}`)
        gl.deleteShader(vertShader)
    }
    const fragShader = gl.createShader(gl.FRAGMENT_SHADER)
    gl.shaderSource(fragShader, fsSource)
    gl.compileShader(fragShader)
    if(!gl.getShaderParameter(fragShader, gl.COMPILE_STATUS)) {
        alert(`An error occured compiling fragment shader: ${gl.getShaderInfoLog(fragShader)}`)
        gl.deleteShader(fragShader)
    }

    shader = gl.createProgram()
    gl.attachShader(shader, vertShader)
    gl.attachShader(shader, fragShader)
    gl.linkProgram(shader)

    if(!gl.getProgramParameter(shader, gl.LINK_STATUS)) {
        alert(`Unable to initialize the shader: ${gl.getProgramInfoLog(shader)}`)
        shader = null
    }
    shaderInfo = {
        program: shader,
        attribPosition: gl.getAttribLocation(shader, "position"),
        uniProjection: gl.getUniformLocation(shader, "projection"),
    }

    rect = gl.createBuffer()
    gl.bindBuffer(gl.ARRAY_BUFFER, rect)
    const positions = [1, 1, -1, 1, 1, -1, -1, -1]
    gl.bufferData(gl.ARRAY_BUFFER, new Float32Array(positions), gl.STATIC_DRAW)
    
}

function main() {
    cvs.width = $(window).width()
	cvs.height= $(window).height()
    gl.clearColor(0, 0, 0, 1)
    gl.clear(gl.COLOR_BUFFER_BIT)
    
    const projectionMatrix = mat4.create()
    mat4.ortho(projectionMatrix, -2, 2, -2, 2, 0, 10)

    gl.useProgram(shader)
    gl.uniformMatrix4fv(shaderInfo.uniProjection, false, projectionMatrix)

    gl.bindBuffer(gl.ARRAY_BUFFER, rect)
    gl.vertexAttribPointer(shaderInfo.attribPosition, 2, gl.FLOAT, false, 0, 0)
    gl.enableVertexAttribArray(shaderInfo.attribPosition)

    gl.drawArrays(gl.TRIANGLE_STRIP, 0, 4)
}

$(document).ready(function() {
	cvs.addEventListener("mousemove", (ev) => {
		mouse.x = ev.clientX
		mouse.y = ev.clientY
	})

	cvs.addEventListener("mousedown", (ev) => {
		if(ev.button == 0)
			mouse.left = true
		else if(ev.button == 1)
			mouse.middle = true
		else if(ev.button == 2)
			mouse.right = true
	})
	cvs.addEventListener("mouseup", (ev) => {
		if(ev.button == 0)
			mouse.left = false
		else if(ev.button == 1)
			mouse.middle = false
		else if(ev.button == 2)
			mouse.right = false
	})
	cvs.addEventListener("wheel", (ev) => {
		// grid.zoom -= (grid.zoom * ev.deltaY * 0.001)
	})
    init()
	setInterval(main, 20)
})
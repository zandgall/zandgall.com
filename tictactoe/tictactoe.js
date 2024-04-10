var cvs = $("#canvas")[0]

let mouse = {
	x: 0,
	y: 0,
	tile: {
		x: 0,
		y: 0
	},
	left: false,
	middle: false,
	right: false
}

var grid = {
	zoom: 50, // zoom is pixels per tile
	
	// (x,y) -> center of grid, default: (width/2, height/2)
	x: 1.5, // in terms of tile
	y: 1.5, // in terms of tile
	
	// Grid size
	width: 3,
	height: 3,
	
	// Grid pixel position elements
	left: 0,
	right: 0,
	top: 0,
	bottom: 0,
	
	// What values are actually placed
	tiles: {}
}

var game_rules = {
	match: 3,
	replacement: false,
	expanding: true,
	spread: 0,
	goal: 10
}

let wins = [], plotted = 0

var FIRST_PLAYTHROUGH = (localStorage.getItem("zandgall.tictactoe.firstPlaythrough") || "true") == "true", adjust_zoom = 50
var REMEMBERING = (localStorage.getItem("zandgall.tictactoe.remember") != null)
var MENU = !FIRST_PLAYTHROUGH

let WON_ANIM_VAR = -1
let WON_ANIM_LIST = [{pos: 200, vel: 0}, {pos: 210, vel: 0}, {pos: 220, vel: 0}, {pos: 230, vel: 0}]

function main() {

	// Update canvas size

	cvs.width = $(window).width()
	cvs.height= $(window).height()
	let ctx = cvs.getContext("2d")
	
	// Update grid visible properties
	
	grid.zoom = grid.zoom * 0.98 + adjust_zoom * 0.02

	grid.left = (grid.x-grid.width)*grid.zoom+cvs.width/2
	grid.right = (grid.width-grid.x)*grid.zoom+cvs.width/2
	grid.top = (grid.y-grid.height)*grid.zoom+cvs.height/2
	grid.bottom = (grid.height-grid.y)*grid.zoom+cvs.height/2

	// Find the range of visible tiles

	let min_tile_x = Math.max(Math.floor(-grid.left/grid.zoom), 0)
	let max_tile_x = Math.min(Math.floor((cvs.width-grid.left)/grid.zoom), grid.width-1)
	let min_tile_y = Math.max(Math.floor(-grid.top/grid.zoom), 0)
	let max_tile_y = Math.min(Math.floor((cvs.height-grid.top)/grid.zoom), grid.height-1)

	// If this is the first playthrough, show only the first 3x3 grid when grid expands for the first time
	if(FIRST_PLAYTHROUGH && (plotted == 9 || plotted == 10)) {
		min_tile_x = 1
		max_tile_x = 3
		min_tile_y = 1
		max_tile_y = 3
	}

	// Pixel versions of grid range
	let bound_left = (min_tile_x)*grid.zoom + grid.left
	let bound_right = (max_tile_x+1)*grid.zoom + grid.left
	let bound_top = (min_tile_y)*grid.zoom + grid.top
	let bound_bottom = (max_tile_y+1)*grid.zoom + grid.top

	ctx.clearRect(0, 0, cvs.width, cvs.height)
	ctx.fillStyle = "#000000"
	for(let tile_x = bound_left; tile_x < bound_right+grid.zoom*0.5; tile_x+=grid.zoom)
		ctx.fillRect(tile_x-1, bound_top, 2, bound_bottom-bound_top)
	for(let tile_y = bound_top; tile_y < bound_bottom+grid.zoom*0.5; tile_y+=grid.zoom)
		ctx.fillRect(bound_left, tile_y-1, bound_right-bound_left, 2)

	// On first playthrough + first expansion, make sure we're showing the AI's first 5x5 placement
	if(FIRST_PLAYTHROUGH && (plotted == 9 || plotted == 10)) {
		min_tile_x = 0
		max_tile_x = 4
		min_tile_y = 0
		max_tile_y = 4
	}

	// Draw all placements
	ctx.lineWidth = Math.max(grid.zoom / 10, 2)
	for(let tile_x = min_tile_x; tile_x <= max_tile_x; tile_x++) // Working in actual tile coords now 
		for(let tile_y = min_tile_y; tile_y <= max_tile_y; tile_y++)
			if(tile_y in grid.tiles && tile_x in grid.tiles[tile_y]) {

				// Grab and run animation logic
				let bounce = (Math.pow(grid.tiles[tile_y][tile_x].x+4,2) - 16)*grid.zoom / 50
				if(grid.tiles[tile_y][tile_x].x < 0) {
					// On first playthrough, first grid expansion is in "slow motion"
					if(FIRST_PLAYTHROUGH && (plotted == 9 || plotted == 10) && grid.tiles[tile_y][tile_x].value==2) {
						grid.tiles[tile_y][tile_x].x += 0.1
						if(grid.tiles[tile_y][tile_x].x>=0)
							FIRST_PLAYTHROUGH = false
					}
					else
						grid.tiles[tile_y][tile_x].x += 0.4 // normal animation speed
				}

				// Draw x if x, o if o
				switch(grid.tiles[tile_y][tile_x].value) {
				case 1:
					ctx.strokeStyle = "#0000ff"
					ctx.beginPath()
					ctx.moveTo((tile_x+0.1)*grid.zoom + grid.left, (tile_y+0.1)*grid.zoom+grid.top + bounce)
					ctx.lineTo((tile_x+0.9)*grid.zoom + grid.left, (tile_y+0.9)*grid.zoom+grid.top + bounce)
					ctx.moveTo((tile_x+0.9)*grid.zoom + grid.left, (tile_y+0.1)*grid.zoom+grid.top + bounce)
					ctx.lineTo((tile_x+0.1)*grid.zoom + grid.left, (tile_y+0.9)*grid.zoom+grid.top + bounce)
					ctx.stroke()
					break
				case 2:
					ctx.strokeStyle = "#ff0000"
					ctx.beginPath()
					ctx.ellipse((tile_x+0.5)*grid.zoom+grid.left, (tile_y+0.5)*grid.zoom+grid.top + bounce, 0.4*grid.zoom, 0.4*grid.zoom, 0, 0, 2*3.2)
					ctx.closePath()
					ctx.stroke()
					break
				}
			}
	
	// If mouse is in grid, highlight tile it's over
	if(mouse.tile.x >= 0 && mouse.tile.x < grid.width && mouse.tile.y >= 0 && mouse.tile.y < grid.height) {
		ctx.fillStyle="rgba(255, 255, 255, 0.1)"
		ctx.fillRect(mouse.tile.x*grid.zoom + grid.left, mouse.tile.y*grid.zoom + grid.top, grid.zoom, grid.zoom)
	}
	
	// Draw all connections
	ctx.lineWidth = Math.max(grid.zoom / 7.5, 2.5)
	ctx.lineCap = "round"
	for(i in wins) {
		let win = wins[i]
		ctx.beginPath()
		ctx.moveTo((win.x+0.5) * grid.zoom + grid.left, (win.y+0.5) * grid.zoom + grid.top)
		if(win.player==1)
			ctx.strokeStyle = "#000080"
		if(win.player==2)
			ctx.strokeStyle = "#800000"
		switch(win.type) {
		case "horizontal":
			ctx.lineTo((win.x+0.5) * grid.zoom + grid.left + win.length * grid.zoom, (win.y+0.5) * grid.zoom + grid.top)
			break
		case "vertical":
			ctx.lineTo((win.x+0.5) * grid.zoom + grid.left, (win.y+0.5) * grid.zoom + grid.top + win.length * grid.zoom)
			break
		case "diagonal":
			ctx.lineTo((win.x+0.5) * grid.zoom + grid.left + win.length * grid.zoom, (win.y+0.5) * grid.zoom + grid.top + win.length * grid.zoom)
			break
		case "antidiagonal":
			ctx.lineTo((win.x+0.5) * grid.zoom + grid.left + win.length * grid.zoom, (win.y+0.5) * grid.zoom + grid.top - win.length * grid.zoom)
			break
		}
		ctx.stroke()

		// Animation logic, including slower first_playthrough connection (if applicable)
		if(FIRST_PLAYTHROUGH && (plotted == 9 || plotted == 10) && win.player == 2)
			win.length = win.length * 0.92 + (game_rules.match-1) * 0.08
		else
			win.length = win.length * 0.9 + (game_rules.match-1) * 0.1
	}

	// Draw points at bottom of screen
	ctx.lineJoin = "round"
	ctx.strokeStyle = "#000000"
	ctx.font = "bold 48px signika"
	ctx.lineWidth = 5
	ctx.fillStyle = "#0000ff"
	ctx.textAlign = "right"
	ctx.strokeText(Player.points, cvs.width/2 - 10, cvs.height-20)
	ctx.fillText(Player.points, cvs.width/2 - 10, cvs.height-20)
	ctx.fillStyle = "#ff0000"
	ctx.textAlign = "left"
	ctx.strokeText(AI.points, cvs.width/2 + 10, cvs.height-20)
	ctx.fillText(AI.points, cvs.width/2 + 10, cvs.height-20)

	// If someone won, run winning animation
	if(AI.points >= game_rules.goal || Player.points >= game_rules.goal) {
		WON_ANIM_VAR += 1
		let x_off = cvs.width/2-Math.pow(Math.max(WON_ANIM_VAR - 100, 0), 2)
		ctx.font = "bold 128px signika"
		ctx.strokeStyle = "#000000"
		ctx.lineWidth = 20
		ctx.textAlign = "left"
		for(i in WON_ANIM_LIST) {
			WON_ANIM_LIST[i].pos += WON_ANIM_LIST[i].vel
			if(WON_ANIM_LIST[i].pos < 0) {
				WON_ANIM_LIST[i].vel *= -0.5
				WON_ANIM_LIST[i].pos *= -1
				// console.log("bounce", i, WON_ANIM_LIST[i].vel, WON_ANIM_LIST[i].pos)
				if(Math.abs(WON_ANIM_LIST[i].vel) < 0.1) {
					WON_ANIM_LIST[i].vel = 0
					WON_ANIM_LIST[i].pos = 0
				}
			}
			if(WON_ANIM_LIST[i].vel != 0 || WON_ANIM_LIST[i].pos != 0) {
				WON_ANIM_LIST[i].vel -= 0.4
			}
		}
		if(Player.points >= game_rules.goal) {
			x_off -= ctx.measureText("X WON").width/2
			ctx.fillStyle = "#0000ff"
			ctx.strokeText("X", x_off, cvs.height/2 - WON_ANIM_LIST[0].pos)
			ctx.fillText("X", x_off, cvs.height/2 - WON_ANIM_LIST[0].pos)
			x_off += ctx.measureText("X ").width
		} else {
			x_off -= ctx.measureText("O WON").width/2
			ctx.fillStyle = "#ff0000"
			ctx.strokeText("O", x_off, cvs.height/2 - WON_ANIM_LIST[0].pos)
			ctx.fillText("O", x_off, cvs.height/2 - WON_ANIM_LIST[0].pos)
			x_off += ctx.measureText("O ").width
		}
		ctx.strokeText("W", x_off, cvs.height/2 - WON_ANIM_LIST[1].pos)
		ctx.fillText("W", x_off, cvs.height/2 - WON_ANIM_LIST[1].pos)
		x_off += ctx.measureText("W").width
		ctx.strokeText("O", x_off, cvs.height/2 - WON_ANIM_LIST[2].pos)
		ctx.fillText("O", x_off, cvs.height/2 - WON_ANIM_LIST[2].pos)
		x_off += ctx.measureText("O").width
		ctx.strokeText("N", x_off, cvs.height/2 - WON_ANIM_LIST[3].pos)
		ctx.fillText("N", x_off, cvs.height/2 - WON_ANIM_LIST[3].pos)
		if(x_off < -100) {
			MENU = true
			WON_ANIM_VAR = -1
			WON_ANIM_LIST = [{pos: 200, vel: 0}, {pos: 210, vel: 0}, {pos: 220, vel: 0}, {pos: 230, vel: 0}]
			AI.points = 0
			Player.points = 0
			$("main").css("display", "flex")
		}
	}

	ctx.lineCap = "butt"
}

let drag = false

let AI = {
	activeRadius: 32,
	difficulty: 10.0,
	points: 0
}

let Player = {
	move: true,
	last_x: 1,
	last_y: 1,
	points: 0
}

function expandGrid() {
	let new_tiles = {}
	for(let y=0; y<grid.height; y++) {
		new_tiles[y+1] = {}
		for(let x=0; x<grid.width; x++) {
			new_tiles[y+1][x+1] = grid.tiles[y][x]
		}
	}

	for(i in wins) {
		wins[i].x++
		wins[i].y++
	}

	grid.x++
	grid.y++
	adjust_zoom = grid.zoom * grid.width / (grid.width+2)
	grid.width+=2
	grid.height+=2

	mouse.tile.x++
	mouse.tile.y++

	grid.tiles = new_tiles
}


function isValid(tile_x, tile_y) {
	if(tile_x < 0 || tile_x >= grid.width || tile_y < 0 || tile_y >= grid.height)
		return false
	if(!game_rules.replacement && tile_y in grid.tiles && tile_x in grid.tiles[tile_y])
		return false
	return true
}
function exists(tile_x, tile_y) {
	if(tile_x < 0 || tile_x >= grid.width || tile_y < 0 || tile_y >= grid.height)
		return false
	return tile_y in grid.tiles && tile_x in grid.tiles[tile_y]
}

function weighMove(x,y,power) {
	let xh_val = 0.1, oh_val = 0.1, xv_val = 0.1, ov_val = 0.1, xd_val = 0.1, od_val = 0.1, xa_val = 0.1, oa_val = 0.1

	// console.log("Weighing", x, y)
	for(let i = -game_rules.match + 1; i < game_rules.match; i++) {
		if(exists(x+i, y)) {
			if(grid.tiles[y][x+i].value==1 && !grid.tiles[y][x+i].horizontal)
				xh_val *= 2
			if(grid.tiles[y][x+i].value==2 && !grid.tiles[y][x+i].horizontal)
				oh_val *= 2
		}
		if(exists(x, y+i)) {
			if(grid.tiles[y+i][x].value==1 && !grid.tiles[y+i][x].vertical)
				xv_val *= 2
			if(grid.tiles[y+i][x].value==2 && !grid.tiles[y+i][x].vertical)
				ov_val *= 2
		}
		if(exists(x+i, y+i)) {
			if(grid.tiles[y+i][x+i].value==1 && !grid.tiles[y+i][x+i].diagonal)
				xd_val *= 2
			if(grid.tiles[y+i][x+i].value==2 && !grid.tiles[y+i][x+i].diagonal)
				od_val *= 2
		}
		if(exists(x+i, y-i)) {
			if(grid.tiles[y-i][x+i].value==1 && !grid.tiles[y-i][x+i].antidiagonal)
				xa_val *= 2
			if(grid.tiles[y-i][x+i].value==2 && !grid.tiles[y-i][x+i].antidiagonal)
				oa_val *= 2
		}
	}
	// console.log(xh_val, oh_val, xv_val, ov_val, xd_val, od_val, xa_val, oa_val)
	return Math.pow(xh_val, power)+Math.pow(oh_val, power)+Math.pow(xv_val, power)+Math.pow(ov_val, power)+Math.pow(xd_val, power)+Math.pow(od_val, power)+Math.pow(xa_val, power)+Math.pow(oa_val, power)
}

function plot(x, y, value) {
	if(!(y in grid.tiles))
		grid.tiles[y] = {}
	if(!(x in grid.tiles[y]))
		plotted++
	grid.tiles[y][x] = {value: value, x: -8, horizontal: false, vertical: false, diagonal: false, antidiagonal: false}
	for(let offset = -game_rules.match+1; offset <= 0; offset++) {
		let horizontal = true, vertical = true, diagonal = true, antidiagonal = true

		for(let i = offset; i < offset + game_rules.match; i++) {
			horizontal &= (exists(x+i, y) && grid.tiles[y][x+i].value == value && !grid.tiles[y][x+i].horizontal)
			vertical &= (exists(x, y+i) && grid.tiles[y+i][x].value == value && !grid.tiles[y+i][x].vertical)
			diagonal &= (exists(x+i, y+i) && grid.tiles[y+i][x+i].value == value && !grid.tiles[y+i][x+i].diagonal)
			antidiagonal &= (exists(x+i, y-i) && grid.tiles[y-i][x+i].value == value && !grid.tiles[y-i][x+i].antidiagonal)
		}

		if(horizontal) {
			if(value == 1)
				Player.points++
			else AI.points++
			wins.push({"x": x+offset, "y": y, length: 0, player: value, type: "horizontal"})
			for(let i = offset; i < offset + game_rules.match; i++)
				grid.tiles[y][x+i].horizontal = true;
		}
		if(vertical) {
			if(value == 1)
				Player.points++
			else AI.points++
			wins.push({"x": x, "y": y+offset, length: 0, player: value, type: "vertical"})
			for(let i = offset; i < offset + game_rules.match; i++)
				grid.tiles[y+i][x].vertical = true;
		}
		if(diagonal) {
			if(value == 1)
				Player.points++
			else AI.points++
			wins.push({"x": x+offset, "y": y+offset, length: 0, player: value, type: "diagonal"})
			for(let i = offset; i < offset + game_rules.match; i++)
				grid.tiles[y+i][x+i].diagonal = true;
		}
		if(antidiagonal) {
			if(value == 1)
				Player.points++
			else AI.points++
			wins.push({"x": x+offset, "y": y-offset, length: 0, player: value, type: "antidiagonal"})
			for(let i = offset; i < offset + game_rules.match; i++)
				grid.tiles[y-i][x+i].antidiagonal = true;
		}
	}
	if(plotted >= grid.width * grid.height)
		expandGrid()
}

function aiTurn() {

	let options = {}
	let max_weight = 0

	for (let x = Math.max(0, Player.last_x-AI.activeRadius); x < Math.max(grid.width, Player.last_x+AI.activeRadius); x++) {
		for(let y = Math.max(0, Player.last_y-AI.activeRadius); y < Math.max(grid.height, Player.last_y+AI.activeRadius); y++) {
			if(isValid(x, y)) {
				if(!(y in options))
					options[y] = {}
				options[y][x] = weighMove(x,y,AI.difficulty*grid.width*grid.height)
				max_weight += options[y][x]
			}
		}
	}

	console.log(options, max_weight)

	let pick = Math.random()*max_weight, running = 0
	for(y in options)
		for(x in options[y]) {
			if(running + options[y][x] >= pick) {
				plot(parseInt(x), parseInt(y), 2)
				Player.move = true
				return
			}
			running += options[y][x]
		}

	console.log("Something went wrong", pick, max_weight, running, options)
}

let pointerCache = [], prevDiff = -1

$(document).ready(function() {
	let min_dim = Math.min($(window).height(), $(window).width())
	grid.zoom = min_dim/3.8
	adjust_zoom = min_dim/4
	cvs.addEventListener("mousemove", (ev) => {
		mouse.x = ev.clientX
		mouse.y = ev.clientY
		mouse.tile.x = Math.floor((mouse.x - $(window).width() / 2) / grid.zoom + grid.width - grid.x)
		mouse.tile.y = Math.floor((mouse.y - $(window).height() / 2) / grid.zoom + grid.height - grid.y)
		
		if(mouse.left) {
			drag = true
			grid.x += ev.movementX / grid.zoom
			grid.y += ev.movementY / grid.zoom
		}
	})

	cvs.addEventListener("click", (ev) => {
		if (drag || !Player.move || MENU || !isValid(mouse.tile.x, mouse.tile.y))
			return
		plot(mouse.tile.x, mouse.tile.y, 1)
		Player.move = false
		setTimeout(aiTurn, 1000)
	})

	cvs.addEventListener("mousedown", (ev) => {
		drag = false
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
		adjust_zoom -= (adjust_zoom * ev.deltaY * 0.001)
		grid.zoom = adjust_zoom
		mouse.tile.x = Math.floor((mouse.x - $(window).width() / 2) / grid.zoom + grid.width - grid.x)
		mouse.tile.y = Math.floor((mouse.y - $(window).height() / 2) / grid.zoom + grid.height - grid.y)
	})
	setInterval(main, 20)
	if(MENU) {
		$("main").css("display", "flex")
		$("#remember").prop("checked", "true")
		$("#width").val(localStorage.getItem("zandgall.tictactoe.width") || grid.width)
		$("#height").val(localStorage.getItem("zandgall.tictactoe.height") || grid.height)
		$("#match").val(localStorage.getItem("zandgall.tictactoe.match") || game_rules.match)
		$("#goal").val(localStorage.getItem("zandgall.tictactoe.goal") || game_rules.goal)
		$("#expanding")[0].checked = localStorage.getItem("zandgall.tictactoe.expanding")=="true"
		$("#replacement")[0].checked = localStorage.getItem("zandgall.tictactoe.replacement")=="true"
	}
})

function start() {
	if(!MENU)
		return

	FIRST_PLAYTHROUGH = false
	grid.width = parseInt($("#width").val())
	grid.height = parseInt($("#height").val())
	grid.x = grid.width/2
	grid.y = grid.height/2
	let min_dim = Math.min($(window).height(), $(window).width())
	adjust_zoom = min_dim / (Math.max(grid.width, grid.height)+1)
	grid.zoom = adjust_zoom * 1.9 / 2
	game_rules.match = parseInt($("#match").val())
	game_rules.goal = parseInt($("#goal").val())
	game_rules.expanding = $("#expanding").val()=="on"
	game_rules.replacement = $("#replacement").val()=="on"
	
	for(const prop of Object.getOwnPropertyNames(grid.tiles)) delete grid.tiles[prop]
	for(const prop of Object.getOwnPropertyNames(wins)) delete wins[prop]

	plotted = 0

	$("main").css("display", "none")
	MENU = false
}

function remember() {
    if($("#remember").prop("checked")) {
        localStorage.setItem("zandgall.tictactoe.remember", "true")
        localStorage.setItem("zandgall.tictactoe.firstPlaythrough", "false")
        localStorage.setItem("zandgall.tictactoe.width", $("#width").val())
        localStorage.setItem("zandgall.tictactoe.height", $("#height").val())
        localStorage.setItem("zandgall.tictactoe.match", $("#match").val())
        localStorage.setItem("zandgall.tictactoe.goal", $("#goal").val())
        localStorage.setItem("zandgall.tictactoe.expanding", $("#expanding").val())
        localStorage.setItem("zandgall.tictactoe.replacement", $("#replacement").val())
        REMEMBERING = true
    } else {
        localStorage.removeItem("zandgall.tictactoe.remember")
        localStorage.removeItem("zandgall.tictactoe.firstPlaythrough")
        localStorage.removeItem("zandgall.tictactoe.width")
        localStorage.removeItem("zandgall.tictactoe.height")
        localStorage.removeItem("zandgall.tictactoe.connect")
        localStorage.removeItem("zandgall.tictactoe.goal")
        localStorage.removeItem("zandgall.tictactoe.expanding")
        localStorage.removeItem("zandgall.tictactoe.replacement")
        REMEMBERING = false
    }
}

function inputWidth() {if(REMEMBERING) localStorage.setItem("zandgall.tictactoe.width", $("#width").val())}
function inputHeight() {if(REMEMBERING) localStorage.setItem("zandgall.tictactoe.height", $("#height").val())}
function inputMatch() {if(REMEMBERING) localStorage.setItem("zandgall.tictactoe.match", $("#match").val())}
function inputGoal() {if(REMEMBERING) localStorage.setItem("zandgall.tictactoe.goal", $("#goal").val())}
function inputExpanding() {if(REMEMBERING) localStorage.setItem("zandgall.tictactoe.expanding", $("#expanding").val())}
function inputReplacement() {if(REMEMBERING) localStorage.setItem("zandgall.tictactoe.replacement", $("#replacement").val())}
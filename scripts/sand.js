let canvas = $("#sandvas")[0]

const WIDTH = 80, HEIGHT = 80

const ITERATIONS = 4
const STEPPING = 2

const identities = {
	"air": [
		"9bd7e8"
	],
	"sand": [
		"f2d994"
	],
	"stone": [
		"808080"
	],
	"water": [
		"0080ff"
	],
	"passthrough": [
		"9bd7e8"
	],
	"solid": [
		"f2d994",
		"808080"
	],
	"fallable": [
		"f2d994",
		"808080",
		"0080ff"
	],
	"pileable": [
		"f2d994",
		"0080ff"
	],
	"liquid": [
		"0080ff"
	]
}

const keybinds = {
	"a": "9bd7e8",
	"s": "f2d994",
	"x": "808080",
	"w": "0080ff"
}

/*
pattern key:
	0 - anything
	1 - identity
	2 - color
	3 - 
*/
let rules = [
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,"fallable",0,0,
			0,0,"passthrough",0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,[0,1],0,0,
			0,0,[0,-1],0,0,
			0,0,0,0,0
		]
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,"pileable",0,0,
			0,0,"solid","passthrough",0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,[1,1],0,0,
			0,0,0,[-1,-1],0,
			0,0,0,0,0
		],
		"x":true
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,"liquid","passthrough",0,
			0,0,"liquid",0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,[1,0],[-1,0],0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		"x":true
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,"liquid","passthrough",0,
			0,0,"solid",0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,[1,0],[-1,0],0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		"x":true
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,"fallable",0,0,
			0,0,"liquid",0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,[0,1],0,0,
			0,0,[0,-1],0,0,
			0,0,0,0,0
		],
		"chance": 0.2
	}
]

let pixels = [];

function matches(rule, x, y) {
	if ("chance" in rule && rule.chance > Math.random())
		return false;
	for (let j = 0; j < 5; j++)
		for(let i = 0; i < 5; i++) {
			if(rule.pattern[j*5+i]===0)
				continue; // Wildcard, matches anything including border
			if(i+x < 0 || i + x >= WIDTH || j + y < 0 || j + y >= HEIGHT) // Out of bounds
				return false;
			if(!(pixels[x+i + (y+j)*WIDTH] in identities[rule.pattern[j*5+i]]))
				return false;
		}
	return true;
}
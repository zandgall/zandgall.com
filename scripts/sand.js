let canvas = $("#sandvas")[0]

const WIDTH = 80, HEIGHT = 80

const ITERATIONS = 4
const STEPPING = 2
let step = 0;

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
	"seed": [
		"bf7c3d"
	],
	"dry cloud": [
		"e9ecf2"
	],
	"rain cloud": [
		"808296"
	],
	"egg": [
		"f2eee6"
	],
	"fish head": [
		"ff4646"
	],
	"fish body": [
		"ed7979"
	],
	"fish tail": [
		"de9090"
	],
	"reed": [
		"1e983c",
		"1ea03c",
		"1ea83c",
		"1eb03c",
		"1eb83c",
		"1ec03c",
		"1ec83c",
		"1ed03c",
	],
	"passthrough": [
		"9bd7e8",
		"e9ecf2",
		"808296"
	],
	"solid": [
		"f2d994",
		"808080",
		"bf7c3d",
		"1e903c",
		"1e983c",
		"1ea03c",
		"1ea83c",
		"1eb03c",
		"1eb83c",
		"1ec03c",
		"1ec83c",
		"1ed03c",
		"f2eee6",
		"ff4646",
		"ed7979",
		"de9090"
	],
	"fallable": [
		"f2d994",
		"808080",
		"0080ff",
		"bf7c3d",
		"f2eee6",
	],
	"pileable": [
		"f2d994",
		"0080ff"
	],
	"liquid": [
		"0080ff"
	],
	"plant": [
		"1e903c",
		"1e983c",
		"1ea03c",
		"1ea83c",
		"1eb03c",
		"1eb83c",
		"1ec03c",
		"1ec83c",
		"1ed03c",
		"bf7c3d"
	],
	"cloud": [
		"e9ecf2",
		"808296"
	],
	"fish": [
		"ff4646",
		"ed7979",
		"de9090"
	],
	"animal": [
		"ff4646",
		"ed7979",
		"de9090"
	],
	"living": [
		"ff4646",
		"ed7979",
		"de9090"
	]
}

const keybinds = {
	"a": "9bd7e8",
	"s": "f2d994",
	"x": "808080",
	"w": "0080ff",
	"1": "bf7c3d",
	"e": "f2eee6"
}

let selectedElement = "f2d994";
let paintSize = 1;

let rules = [
	{
		pattern: [ // 0 = anything, "string" = identity
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,"fallable",0,0,
			0,0,"passthrough",0,0,
			0,0,0,0,0
		],
		response: [ // 0 = do nothing, "string" = random identity, [list] = reference
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,[0,1],0,0,
			0,0,[0,-1],0,0,
			0,0,0,0,0
		]
	}, // Fallables fall
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
		]
	}, // Pileables Pile
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,"pileable",0,0,
			0,"passthrough","solid",0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,[-1,1],0,0,
			0,[1,-1],0,0,0,
			0,0,0,0,0
		]
	}, // mirror of previous
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
		]
	}, // Liquids slide on liquid
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,"passthrough","liquid",0,0,
			0,0,"liquid",0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,[1,0],[-1,0],0,0,
			0,0,0,0,0,
			0,0,0,0,0
		]
	}, // mirror of previous
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
		]
	}, // Liquids slide on solids
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,"passthrough","liquid",0,0,
			0,0,"solid",0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,[1,0],[-1,0],0,0,
			0,0,0,0,0,
			0,0,0,0,0
		]
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
		chance: 0.2 // only has a 20% chance of happening every execution
	}, // Fallables fall (slowly) in liquid 
	{
		pattern: [
			0,0,0,0,0,
			0,0,"water",0,0,
			0,0,"seed",0,0,
			0,0,"sand",0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,"reed",0,0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		chance: 0.005
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,"water",0,0,
			0,0,"water",0,0,
			0,0,"reed",0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,[0,1,0,-8,0],0,0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		chance: 0.01
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,"passthrough",0,0,
			0,0,"water",0,0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,"dry cloud",0,0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		chance: 0.001
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,"passthrough",0,0,
			0,0,"passthrough",0,0,
			0,0,"dry cloud",0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,[0,1],0,0,
			0,0,[0,-1],0,0,
			0,0,0,0,0
		],
		chance: 0.2
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,"rain cloud",0,0,
			0,0,"dry cloud",0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,[0,1],0,0,
			0,0,[0,-1],0,0,
			0,0,0,0,0
		],
		chance: 0.5
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,"dry cloud","passthrough",0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,[1,0],[-1, 0],0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		chance: 0.005
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,"passthrough", "dry cloud",0,0,0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,[1,0],[-1, 0],0,0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		chance: 0.005
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,"dry cloud","dry cloud","dry cloud",0,
			0,"dry cloud","dry cloud","dry cloud",0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,"rain cloud",0,0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		chance: 0.005
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,"passthrough",0,0,
			0,0,"passthrough",0,0,
			0,0,"rain cloud",0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,[0,1],0,0,
			0,0,[0,-1],0,0,
			0,0,0,0,0
		],
		chance: 0.05
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,"rain cloud","passthrough",0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,[1,0],[-1, 0],0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		chance: 0.005
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,"passthrough","rain cloud",0,0,0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,[1,0],[-1, 0],0,0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		chance: 0.005
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,"rain cloud",0,0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,"water",0,0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		chance: 0.00002
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,"rain cloud","rain cloud","rain cloud",0,
			0,0,"rain cloud",0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,"water",0,0,
			0,0,"water",0,0,
			0,0,0,0,0
		],
		chance: 0.01
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,"water",0,0,
			0,0,"rain cloud",0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,"water",0,0,
			0,0,0,0,0
		]
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,"egg","liquid",0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,"fish head","fish tail",0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		chance: 0.001
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,"liquid","egg",0,0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,"fish tail","fish head",0,0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		chance: 0.001
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,"liquid","liquid",0,
			0,0,"liquid","liquid",0,
			0,0,"fish head","fish tail",0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,[0,1],[0,1],0,
			0,0,[0,-1],[0,-1],0,
			0,0,0,0,0
		],
		chance: 0.01
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,"liquid","liquid",0,
			0,0,"liquid","liquid",0,
			0,0,"fish tail","fish head",0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,[0,1],[0,1],0,
			0,0,[0,-1],[0,-1],0,
			0,0,0,0,0
		],
		chance: 0.01
	},
	{
		pattern: [
			0,0,0,0,0,
			0,"liquid","liquid","liquid",0,
			0,"liquid","liquid","liquid",0,
			0,"fish head","fish body","fish tail",0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,[0,1],[0,1],[0,1],0,
			0,[0,-1],[0,-1],[0,-1],0,
			0,0,0,0,0
		],
		chance: 0.01
	},
	{
		pattern: [
			0,0,0,0,0,
			0,"fish tail","fish body","fish head",0,
			0,"liquid","liquid","liquid",0,
			0,"liquid","liquid","liquid",0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,[0,1],[0,1],[0,1],0,
			0,[0,-1],[0,-1],[0,-1],0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		chance: 0.01
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,"liquid","fish head","fish tail",0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,[1,0],[1,0],[-2,0],0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		chance: 0.5
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,"fish tail","fish head","liquid",0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,[2,0],[-1,0],[-1,0],0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		chance: 0.5
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,"solid","fish head","fish tail",0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,0,[1,0],[-1,0],0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		chance: 0.25
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,"fish tail","fish head","solid",0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,[1,0],[-1,0],0,0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		chance: 0.25
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,"liquid","fish head","fish tail",0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,[1,0],"fish body",0,0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		chance: 0.001
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			"liquid","fish head","fish body","fish tail",0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			[1,0],[1,0],[1,0],[-3,0],0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		chance: 0.5
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,"fish tail","fish body","fish head","liquid",
			0,0,0,0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,[3,0],[-1,0],[-1,0],[-1,0],
			0,0,0,0,0,
			0,0,0,0,0
		],
		chance: 0.5
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			"solid","fish head","fish body","fish tail",0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,[2,0],0,[-2,0],0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		chance: 0.25
	},
	{
		pattern: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,"fish tail","fish body","fish head","solid",
			0,0,0,0,0,
			0,0,0,0,0
		],
		response: [
			0,0,0,0,0,
			0,0,0,0,0,
			0,[2,0],0,[-2,0],0,
			0,0,0,0,0,
			0,0,0,0,0
		],
		chance: 0.25
	}
]
let ruleList = Array.apply(null, Array(rules.length)).map(function(x,i){return i;});

let pixels = Array(WIDTH*HEIGHT).fill("9bd7e8");

let smouseX, smouseY, smouseLeft, paintOnce;

function matches(rule, x, y) {
	if ("chance" in rule && rule.chance < Math.random())
		return false;
	for (let j = 0; j < 5; j++)
		for(let i = 0; i < 5; i++) {
			if(rule.pattern[j*5+i]===0)
				continue; // Wildcard, matches anything including border
			if(i+x < 0 || i + x >= WIDTH || j + y < 0 || j + y >= HEIGHT) // Out of bounds
				return false;
			if(!(rule.pattern[j*5+i] in identities))
				console.log("unknown identity:", rule.pattern[j*5+i]);
			if(!identities[rule.pattern[j*5+i]].includes(pixels[x+i + (y+j)*WIDTH]))
				return false;

		}
	return true;
}

function enforce(rule, x, y) {
	let source = Array(5*5).fill(0);
	for(let j = 0; j < 5; j++)
		for(let i = 0; j+y>=0 && j+y<HEIGHT && i<5; i++) {
			if(rule.response[j * 5 + i]===0 || i + x < 0 || i + x >= WIDTH)
				continue;
			if(Array.isArray(rule.response[j * 5 + i])) {
				let res = rule.response[j * 5 + i];
				source[j * 5 + i] = pixels[i+x+res[0] 
					+ (j+y+res[1])*WIDTH];
				if(res.length > 2) {
					let num = Number("0x"+source[j * 5 + i]);
					let r = ((num&0x00ff0000) >> 16) + res[2];
					let g = ((num&0x0000ff00) >> 8) + res[3];
					let b = (num&0x000000ff) + res[4];
					source[j * 5 + i] = Number((r<<16)+(g<<8)+b).toString(16);
				}
				continue;
			}
			if(rule.response[j * 5 + i] in identities) {
				let identity = identities[rule.response[j*5+i]];
				source[j*5+i] = identity[Math.floor(Math.random()*identity.length)];
				continue;
			}
			source[j*5+i] = rule.response[j*5+i];
		}

	for(let j = 0; j < 5; j++)
		for(let i = 0; j + y >= 0 && j+y < HEIGHT && i < 5; i++)
			if(rule.response[j*5+i]!==0 && i+x>=0 && i + x < WIDTH)
				pixels[i+x+(j+y)*WIDTH] = source[j*5+i];
}

function main() {
	console.log("main!");

	if(smouseLeft && smouseX >= 0 && smouseX < WIDTH && smouseY >= 0 && smouseY < HEIGHT) {
		for(let x = Math.max(smouseX + 1 - Math.floor(paintSize), 0); x < WIDTH && x < smouseX + paintSize; x++)
			for(let y = Math.max(smouseY + 1 - Math.floor(paintSize), 0); y < HEIGHT && y < smouseY + paintSize; y++)
				pixels[y * WIDTH + x] = selectedElement;
		if(paintOnce)
			smouseLeft = false;
	}

	for(let iter = 0; iter < ITERATIONS; iter++) {
		let ystart = HEIGHT + 3 - Math.floor(step/STEPPING);
		let xstart = Math.floor(-4 + (step%STEPPING));
		for(let j = ystart; j > -5; j-=STEPPING)
			for(let i = (step % 2==0 ? xstart:WIDTH-xstart); i < WIDTH + 5 && i > -5; i+=(step%2==0?1:-1)*STEPPING)
				for(let r = 0; r < rules.length; r++)
					if(matches(rules[ruleList[r]], i, j))
						enforce(rules[ruleList[r]], i, j);
		let shuffle_a = Math.floor(Math.random() * rules.length);
		let shuffle_b = Math.floor(Math.random() * rules.length);
		let shuffle_z = ruleList[shuffle_a];
		ruleList[shuffle_a] = ruleList[shuffle_b];
		ruleList[shuffle_b] = shuffle_z;
		step++;
		if(step >= STEPPING * STEPPING)
			step = 0;
	}


	let ctx = canvas.getContext("2d");
	ctx.clearRect(0, 0, WIDTH, HEIGHT);
	for(let j = 0; j < HEIGHT; j++)
		for(let i = 0; i < WIDTH; i++) {
			ctx.fillStyle = "#"+pixels[j*WIDTH + i];
			ctx.fillRect(i,j,1,1);
		}
	let num = Number("0x"+selectedElement);
	let r = Math.min(((num&0x00ff0000) >> 16) + 10, 255);
	let g = Math.min(((num&0x0000ff00) >> 8) + 10, 255);
	let b = Math.min((num&0x000000ff) + 10, 255);
	ctx.fillStyle = "rgba("+r+","+g+","+b+", 0.5)";
	ctx.fillRect(smouseX+1-Math.floor(paintSize),smouseY+1-Math.floor(paintSize),Math.floor(paintSize)*2 - 1,Math.floor(paintSize)*2 - 1);
}

function key(e) {
	console.log(e.key, e.keyCode);
	if(e.key.toLowerCase() in keybinds)
		selectedElement = keybinds[e.key.toLowerCase()];
	else if(e.keyCode===17)
		paintOnce = true;
	else if(e.keyCode===38)
		paintSize++;
	else if(e.keyCode===40) {
		paintSize--;
		if(paintSize<1)paintSize = 1;
	}
}

function keyUp(e) {
	if(e.keyCode===17)
		paintOnce = false;
}

function scroll(e) {
	paintSize+=paintSize * e.scrollY * 0.1;
	if(paintSize < 1) paintSize = 1;
}

$(document).ready(function() {
	console.log("Ready");

	$(canvas).mousedown(function() {smouseLeft = true; console.log("click!");});
	$(canvas).mouseup(function() {smouseLeft = false; console.log("not click!");});
	$(canvas).mousemove(function(e) {
		let rect = canvas.getBoundingClientRect();
		smouseX = Math.floor((e.pageX - rect.x) * WIDTH / rect.width);
		smouseY = Math.floor((e.pageY - rect.y) * HEIGHT / rect.height);
	});
	$(document).keydown(key);
	$(document).keyup(keyUp);
	$(document).scroll(scroll);
	window.setInterval(main, 100);
});
var dictionary = {}
var charIcons = {}
var canvas = document.getElementById("can")
var sentence = []
var isPlaying = false
var playPosition = 0

const voice = new Tone.Sampler({
	urls: {
		"A4": "A4.wav",
		"Bb4": "Bb4.wav",
		"B4": "B4.wav",
		"C4": "C4.wav",
		"Db4": "Db4.wav",
		"D4": "D4.wav",
		"Eb4": "Eb4.wav",
		"E4": "E4.wav",
		"F4": "F4.wav",
		"Gb4": "Gb4.wav",
		"G4": "G4.wav",
		"Ab5": "Ab5.wav",
		"A5": "A5.wav",
		"Bb5": "Bb5.wav",
		"B5": "B5.wav",
		"C5": "C5.wav",
		"Db5": "Db5.wav",
		"D5": "D5.wav",
		"Eb5": "Eb5.wav",
		"E5": "E5.wav",
		"F5": "F5.wav",
		"Gb5": "Gb5.wav",
		"G5": "G5.wav",
		"Ab6": "Ab6.wav",
		"A6": "A6.wav",
		"Bb6": "Bb6.wav",
		"B6": "B6.wav",
	},
	release: 1,
	volume: -6,
	baseUrl: "../assets/audio/ocarina/"
}).toDestination()

var spoken = new Tone.Players().toDestination()

$(function() {
	let $tokens = $("#tokens")

	$.getJSON("dictionary.json?v="+Date.now(), function(data) {
		dictionary = data
		console.log(dictionary["characters"])
		let consonants = "szflktdgpbvm"
		for(const key in dictionary["characters"]) {
			console.log(key)
			charIcons[key] = new Image(38, 38)
			charIcons[key].src = `./alphabet/${key}.svg`
			for(i in consonants) {
				let word = consonants[i] + dictionary["characters"][key]["spoken"][1]
				spoken.add(word, `../assets/audio/canti/${word}.wav`)
			}
			consonants = consonants.substr(1)
			$tokens.append(`<div class='token'><button onclick='token("${key}")'><image src='alphabet/${key}.svg'></button></div>`)
		}
	})

	charIcons["dash"] = new Image(38, 38)
	charIcons["dash"].src = "./alphabet/dash.svg"

	$tokens.append(`<div class='token'><button onclick='token("remove")'>X</button></div>`)
	$tokens.append(`<div class='token'><button onclick='token("space")'><image src='alphabet/dash.svg' width=38 height = 38></button></div>`)

	window.setInterval(playing, 500)
	redraw()
})


function token(id) {
	console.log("token", id)
	if(id == "remove") {
		if(sentence.length > 0)
			sentence.pop()
		redraw()
		return
	}
	if(id == "space") {
		sentence.push(" ")
		redraw()
		return
	}
	if(!(id in dictionary["characters"]))
		return
	sentence.push(id)
	let sound = dictionary["characters"][id]["sound"]
	voice.triggerAttack(sound)
	spoken.player(dictionary["characters"][id]["spoken"]).start()
	redraw()
}

function play() {
	playPosition = 0
	isPlaying = !isPlaying
}

function playing() {
	if(playPosition >= sentence.length) {
		isPlaying = false
		redraw()
	}
	if(!isPlaying)
		return

	redraw()

	let moon = sentence[playPosition]
	console.log("attempting to play ", playPosition, sentence[playPosition])
	if(moon == " ") {
		playPosition += 1
		return
	}

	let sun = sentence[Math.min(playPosition + 1, sentence.length - 1)]
	if(sun == " ") {
		playPosition -= 1
		sun = moon
	}

	let moonSound = dictionary["characters"][moon]["sound"]
	let sunSound = dictionary["characters"][sun]["sound"]
	if(sun != moon)
		voice.triggerAttackRelease([moonSound, sunSound], 0.5)
	else
		voice.triggerAttackRelease(moonSound, 0.5)

	let vowelPriority = "ūouāiēeawīhx";
	let consoPriority = "szflktdgpbvm";
	let moonSpoken = dictionary["characters"][moon]["spoken"]
	let sunSpoken = dictionary["characters"][sun]["spoken"]
	let vowel = vowelPriority[Math.min(vowelPriority.indexOf(moonSpoken[1]), vowelPriority.indexOf(sunSpoken[1]))]
	let consonant = consoPriority[Math.max(consoPriority.indexOf(moonSpoken[0]), consoPriority.indexOf(sunSpoken[0]))]
	console.log(consonant + vowel)
	if(!spoken.has(consonant + vowel))
		spoken.add(consonant + vowel, `../assets/audio/canti/${consonant}${vowel}.wav`, () => spoken.player(consonant + vowel).start())
	else
		spoken.player(consonant + vowel).start()

	playPosition += 2
}

function redraw() {
	let c = canvas.getContext("2d")
	c.canvas.width  = window.innerWidth
	c.canvas.height = 114

	c.clearRect(0, 0, canvas.width, canvas.height)
	c.strokeStyle = "#999"
	for(let i = 0; i < canvas.width; i+=38) {
		c.beginPath()
		c.setLineDash([5,15])
		c.moveTo(i, 0)
		c.lineTo(i, 114)
		c.stroke()
	}

	let xPos = 0
	let playXPos = -38
	for(let i = 0; i < sentence.length; i+=2) {

		if(playPosition == i)
			playXPos = xPos

		if(sentence[i] == " ") {
			i -= 1
			c.drawImage(charIcons["dash"], xPos, 38, 38, 38)
			xPos += 38
			continue
		}
		c.drawImage(charIcons[sentence[i]], xPos, 38, 38, 38)

		if(i + 1 >= sentence.length)
			continue
		
		if(sentence[i + 1] == " ") {
			i -= 1
			xPos += 38
			continue
		}

		c.drawImage(charIcons[sentence[i + 1]], xPos, 38, 38, 38)

		xPos += 38
	}
	c.fillStyle = "rgba(255, 0, 0, 0.25)"
	c.fillRect(xPos, 0, 38, 114)
	if(isPlaying) {
		c.fillStyle = "rgba(0, 255, 0, 0.25)"
		c.fillRect(playXPos, 0, 38, 114)
	}
}

$("body").on("keydown", function(event) {
	console.log(event)
	if(event.which == 8)
		token("remove")
	else if(event.which == 32)
		token("space")
	else
		token(event.key)
})

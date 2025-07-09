$.ajaxSetup({async: false})

$("#commandCenter").off("submit").on("submit", commandEvent)
function commandEvent(e) {
	command($("#command").val())
	$("#command").val("")
	e.preventDefault()
}

var dictionary = {}

$(function() {
	$.getJSON("dictionary.json?v="+Date.now(), function(data) {
		dictionary = data
	})
	transcribeDictionary()
})

function transcribeDictionary() {
	$dictionary = $("#dictionary")
	for(canti in dictionary.words) {
		$entry = $("<div class='entry'></div>")
		$cantiDiag = $("<div class='canti'></div>")
		for(let i = 0; i < canti.length; i++) {
			let glyph = canti[i]
			if(i + 1 < canti.length) {
				i++
				if(canti[i] != " ")
					glyph += canti[i]
			}
			let img = new Image()
			img.addEventListener('error', function tryrev() {
				let pre = img.src.lastIndexOf("/")
				console.log(img.src, img.src[pre], pre)
				img.src = "alphabet/" + img.src[pre + 2] + img.src[pre + 1] + ".svg"
				img.removeEventListener('error', tryrev)
			})
			img.src = "alphabet/" + glyph + ".svg";
			$cantiDiag.append(img)
			//style='margin-top:" + off + "px'
		}
		$entry.append($cantiDiag)
		for(word of dictionary.words[canti])
			$entry.append("<h1>" + word + "</h1>")
		$dictionary.append($entry)
	}
}

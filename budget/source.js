var WEEK_TOTAL = 168

$.ajaxSetup({async:false})

var known_styles = {}

$(function() {
	setInterval(parseData, 100)
	parseData()
})

function parseData() {
	$.getJSON("data.json?v="+Date.now(), function(data) {

		let dBudget = data["budget"]
		let dRunning = data["running"]
		let budgetTotal = 0, totalBudgetMatch = 0, overbudget = 0
		$("#budget>.spent").remove()
		for (key in dBudget) {
			let runningValue = key in dRunning ? dRunning[key] : 0
			$("#budget").append(getSpent(key, dBudget[key]))
			budgetTotal += dBudget[key]
			let remainder = dBudget[key] - runningValue
			totalBudgetMatch += Math.max(remainder, 0)
			overbudget += Math.max(-remainder, 0)
		}
		$("#budget").append(getSpent("not budgeted", WEEK_TOTAL - budgetTotal))

		let runningTotal = 0
		let totalBudgetUnmatch = 0
		$("#running>.spent").remove()
		for (key in dRunning) {
			$("#running").append(getSpent(key, dRunning[key]))
			runningTotal += dRunning[key]
			if (!(key in dBudget)) {
				totalBudgetUnmatch += dRunning[key]
			}
		}
		$("#running").append(getSpent("budgeted", totalBudgetMatch))

		let currDay = Math.floor(runningTotal / 24)
		let currHour = runningTotal % 24
		$("#running > .header").html(`<h1>Curr - ${currDay}d${currHour}hr</h1>`)
		// $("#running").append(getSpent("overbudget", overbudget))
		$("#running").append(getSpent("free time", (WEEK_TOTAL - budgetTotal) - totalBudgetUnmatch - overbudget))
		
		$(".previous").remove()
		for(week in data) {
			if(!week.startsWith("week"))
				continue;
			$("main").append(`<div class='previous frame' id='building'><div class='header'><h1>${week}</h1></div></div>`)
			runningTotal = 0
			for(key in data[week]) {
				$("#building").append(getSpent(key, data[week][key]))
				runningTotal += data[week][key]
			}
			$("#building").append(getSpent("unknown", 168-runningTotal))
			$("#building").removeAttr("id")
		}

	}).fail(() => {
		console.log(":(")
	})
}

function checkSpentKey(key) {
	if(key in known_styles)
		return

	let i = key.length
	let total = 0
	while(i--) {
		total += (key.charCodeAt(i) - 97) / (i+1)
	}

	let hue = (total % 12) * 30
	let sat = 100 - Math.floor(total / 6) * 10
	let hsl = `hsl(${hue}, ${sat}%, 50%)`
	known_styles[key] = hsl
	$("#budget-style").append(`.${key} {background-color: ${hsl};}`)
	$("#budget-style").append(`.${key}.unfulfilled {background-color: ${hsl};}`)
	hsl = `hsl(${hue}, ${sat}%, 25%)`
	$("#budget-style").append(`.${key}.fulfilled {background-color: ${hsl};}`)

	console.log(key, "has text value", total)
}

function getSpent(key, data) {
	checkSpentKey(key)
	let textSize = Math.min(data * 2, 12)
	let subtext = ""
	if(key == "budgeted")
		subtext = "<p>time left in the week that is accounted for in budget</p>"
	if(key == "free time")
		subtext = "<p>time left in the week that is not accounted for in budget</p>"
	return `<div class='spent ${key}' style='flex: ${data}; font-size: ${textSize}pt'><h1>${key} - ${data}</h1>${subtext}</div>`
}

function getSpentRemainder(key, data, value) {
	let $spent = $(getSpent(key, data))
	$spent.addClass("unfulfilled")
	let percentage = Math.floor(value/data * 100);
	$spent.prepend(`<div class='${key} fulfilled' style='height: ${percentage}%'></div>`)
	return $spent;
}

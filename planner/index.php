<?php

ini_set('session.gc_maxlifetime', 36000);
session_set_cookie_params(36000);

session_start();

include "login.php";
if (!isset($_SESSION["logged"])) {
	return;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>PlannerJS</title>
	<link rel="stylesheet" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>

<body class="notEditing">
	<main>
		<section id="classes" class="editElement">
			<h2>Classes</h2>

		</section>
		<h2 style="display:inline">Assignments</h2>
		<button id="toggleWriting" onclick="toggleWriting()"><img src="quill.png" width="20"></button>

		<div class='step' id='stepBase'>
			<form class='stepDone'>
				<input type='submit' value='✓'>
				<label class='nonEditElement' for='chkStep'>Step</label>
			</form>
			<form class='editElement stepName'>
				<input type='text' size='40' name='txtStep' value='Step'>
			</form>
			<form class='editElement stepDelete'>
				<input type='submit' value='X'>
			</form>
		</div>

		<div class='assignment' id='base'>
			<div class='color-id'>
				<form class='editElement editAssignment'>
					<input type='text' size='30' name='txtName' value='Assignment'>
					<input type='datetime-local' name='dtDue' step='1'>
					<br>
					<select name="newClass">
					</select>
					<input type="submit" value="✓">
				</form>
				<form class='editElement deleteAssignment'>
					<input type='submit' value='X' title='Delete Assignment' onclick='return confirm("Are you sure?")'>
				</form>
				<div class="nonEditElement">
					<h1>Assignment</h1>
					<h2>Class ID - Class name</h2>
				</div>
			</div>
			<div class='steps'>
				<form class='editElement addStep'>
					<input type='text' size='40' name='txtStep'>
					<input type='submit' value='+'>
				</form>
			</div>
			<form class='completeAssignment'>
				<input type="submit" value='Done!' />
			</form>
			<p class='due'>Due: Sometime</p>
		</div>

		<form id="addAssignment" style="margin-bottom:10mm">
			<input type="submit" value="+" title="Add Assignment">
		</form>

		<section id="assignments">

		</section>
	</main>

	<script>
		var edit = false

		function toggleWriting() {
			if (edit) {
				document.body.classList.remove("editing")
				document.body.classList.add("notEditing")
				edit = false
			} else {
				document.body.classList.remove("notEditing")
				document.body.classList.add("editing")
				edit = true
			}
		}

		var classdata = {}

		var $assignmentElements = []

		var $assignment, assignmentEdit, assignmentDelete, assignmentDisplay;

		var assignmentData = []

		$.getJSON("data.json", function(data) {
			classdata = data

			firstClass = Object.keys(classdata)[0]

			for (className in classdata) {
				$("#base .editAssignment select").append("<option value='" + className + "'>" + classdata[className]["name"] + "</option>")
			}

			$assignment = $("#base")
			$("#base").attr("className", firstClass)
			$("#base .color-id").css("background-color", data[firstClass]["color"])
			$("#base .nonEditElement h2").html(firstClass + " - " + data[firstClass]["name"])

			for (className in classdata) {
				console.log(className)
				for (i in classdata[className]["assignments"]) {
					assignment = classdata[className]["assignments"][i]
					if (assignment["done"])
						continue
					console.log(assignment["name"], assignment["done"])
					$assignmentElem = $assignment.clone()
					$("#assignments").append($assignmentElem)
					updateAssignmentElementFromData($assignmentElem, className, i)
				}
			}

			sortAssignments()
		})

		function updateAssignmentElementFromData($assignmentElem, className, assignmentID) {
			id = className.replace(" ", "_") + "assignment" + assignmentID
			$assignmentElem.attr("assignment", assignmentID)
			$assignmentElem.attr("className", className)
			$assignmentElem.attr("id", id)
			assignment = classdata[className]["assignments"][assignmentID]
			dueDate = new Date()
			dueDate.setTime(assignment["due"] * 1000)
			$assignmentElem.attr("due", assignment["due"])
			id = "#" + id
			$(id + " .color-id").css("background-color", classdata[className]["color"])
			$(id + " .color-id input[name='txtName']").attr("value", assignment["name"])
			$(id + " .color-id input[name='dtDue']").val(dueDate.toISOString().slice(0, 16))
			$(id + " .nonEditElement h1").html(assignment["name"])
			$(id + " .nonEditElement h2").html(className + " - " + classdata[className]["name"])
			$(id + " .editAssignment select").val(className)
			fixedDate = new Date()
			fixedDate.setTime(fixedDate.getTime() - new Date().getTimezoneOffset() * 60000)
			if (dueDate < fixedDate)
				$(id).addClass("late")
			else
				$(id).removeClass("late")
			$(id + " .due").html("Due: " + dueDate.getUTCFullYear() + "/" + (dueDate.getUTCMonth() + 1) + "/" + dueDate.getUTCDate() + " " + dueDate.getUTCHours() + ":" + dueDate.getUTCMinutes())

			for (j in assignment["steps"]) {
				sid = id + "step" + j
				step = assignment["steps"][j]
				$step = $(sid)
				if ($step.length == 0)
					$step = $("#stepBase").clone().attr("id", sid.substring(1)).attr("step", j)
				$(id + " .steps .addStep").before($step)
				if (step["done"])
					$(sid + " .stepDone input").attr("value", "✓")
				else
					$(sid + " .stepDone input").attr("value", "")
				$(sid + " .stepName input").attr("value", step["name"])
				$(sid + " .stepDone label").html(step["name"])

				$(sid + " .stepDone").off("submit").on("submit", toggleStep)
				$(sid + " .stepName").off("submit").on("submit", renameStep)
				$(sid + " .stepDelete").off("submit").on("submit", deleteStep)
			}

			$(id + " .steps .addStep").off("submit").on("submit", addStep)
			$(id + " .editAssignment").off("submit").on("submit", editAssignment)
			$(id + " .deleteAssignment").off("submit").on("submit", deleteAssignment)
			$(id + " .completeAssignment").off("submit").on("submit", completeAssignment)
		}

		$("#addAssignment").submit((e) => {
			$newAss = $("#base").clone()
			$("#assignments").append($newAss)

			classdata[$newAss.attr("className")]["assignments"].push({
				"name": "Assignment",
				"due": Math.floor(new Date().getTime() / 1000),
				"steps": [],
				"done": false
			})

			if (!edit)
				toggleWriting()

			updateAssignmentElementFromData($newAss, $newAss.attr("className"), classdata[$newAss.attr("className")]["assignments"].length - 1)
			updateData()
			sortAssignments()

			e.preventDefault()
		})

		function sinceMonday(date) {
			if (date.getDay() == 0)
				return 6
			else return date.getDay() - 1
		}

		function sortAssignments() {
			var sort_by_due = function(a, b) {
				anum = Number.parseInt($(a).attr("due"))
				bnum = Number.parseInt($(b).attr("due"))
				return anum < bnum ? -1 : (anum > bnum ? 1 : 0)
			}

			$(".week").remove()

			var list = $("#assignments > .assignment").get()
			list.sort(sort_by_due)
			lastDate = new Date()
			firstAssignment = true
			for (i in list) {
				date = new Date()
				date.setTime(Number($(list[i]).attr("due")) * 1000)
				console.log(i, lastDate.getDate(), date.getDate(), lastDate.getDay(), date.getDay(), $(list[i]).attr("due"))
				if (lastDate < date && (sinceMonday(date) < sinceMonday(lastDate) || (sinceMonday(date) == sinceMonday(lastDate) && date.getDate() != lastDate.getDate()))) {
					if (firstAssignment)
						$(list[i].parentNode).append($("<div class='week'><div><img src='party-popper.svg' width='20mm'/><p>Woo! You made it through the week! Take some time to relax.</p></div><hr></div>"))
					else
						$(list[i].parentNode).append($("<div class='week'><hr></div>"))
				}

				list[i].parentNode.appendChild(list[i])
				firstAssignment = false
				lastDate = date
			}
		}

		function addStep(e) {
			form = e.target
			assignment = form.parentElement.parentElement

			className = $(assignment).attr("className")
			assNum = Number($(assignment).attr("assignment"))

			newStep = Object.fromEntries(new FormData(form))["txtStep"]

			classdata[className]["assignments"][assNum]["steps"].push({
				name: newStep,
				done: false
			})

			updateAssignmentElementFromData($(assignment), className, assNum)
			updateData()

			e.preventDefault()
		}

		function renameStep(e) {
			form = e.target
			step = form.parentElement
			assignment = step.parentElement.parentElement

			newStep = Object.fromEntries(new FormData(form))["txtStep"]

			className = $(assignment).attr("className")
			assNum = Number($(assignment).attr("assignment"))
			stepNum = Number($(step).attr("step"))

			classdata[className]["assignments"][assNum]["steps"][stepNum]["name"] = newStep

			updateAssignmentElementFromData($(assignment), className, assNum)
			updateData()

			e.preventDefault()
		}

		function toggleStep(e) {
			form = e.target
			step = form.parentElement
			assignment = step.parentElement.parentElement

			className = $(assignment).attr("className")
			assNum = Number($(assignment).attr("assignment"))
			stepNum = Number($(step).attr("step"))

			classdata[className]["assignments"][assNum]["steps"][stepNum]["done"] = !classdata[className]["assignments"][assNum]["steps"][stepNum]["done"]

			updateAssignmentElementFromData($(assignment), className, assNum)
			updateData()

			e.preventDefault()
		}

		function deleteStep(e) {
			form = e.target
			step = form.parentElement
			assignment = step.parentElement.parentElement

			className = $(assignment).attr("className")
			assNum = Number($(assignment).attr("assignment"))
			stepNum = Number($(step).attr("step"))

			$(step).remove()

			classdata[className]["assignments"][assNum]["steps"].splice(stepNum, 1)
			for (i = stepNum; i < classdata[className]["assignments"][assNum]["steps"].length; i++) {
				idTemplate = className.replace(" ", "_") + "assignment" + assNum + "step"
				$("#" + idTemplate + (i + 1)).attr("step", i)
				$("#" + idTemplate + (i + 1)).attr("id", idTemplate + i)
			}

			updateData()

			e.preventDefault()
		}

		function deleteAssignment(e) {
			form = e.target
			assignment = form.parentElement.parentElement

			className = $(assignment).attr("className")
			assNum = Number($(assignment).attr("assignment"))


			$(assignment).remove()

			classdata[className]["assignments"].splice(assNum, 1)
			for (i = assNum; i < classdata[className]["assignments"].length; i++) {
				idTemplate = className.replace(" ", "_") + "assignment"
				classdata[className]["assignments"][i].assignmentNum = i
				$("#" + idTemplate + (i + 1)).attr("assignment", i)
				$("#" + idTemplate + (i + 1)).attr("id", idTemplate + i)
			}

			updateData()
			e.preventDefault()
		}

		function completeAssignment(e) {
			form = e.target
			assignment = form.parentElement

			className = $(assignment).attr("className")
			assNum = Number($(assignment).attr("assignment"))

			console.log(className, assNum, classdata[className])

			$(assignment).remove()

			classdata[className]["assignments"][assNum]["done"] = true

			updateData()

			e.preventDefault()
		}

		function editAssignment(e) {
			form = e.target
			assignment = form.parentElement.parentElement

			currClass = $(assignment).attr("className")
			assNum = Number($(assignment).attr("assignment"))

			formData = Object.fromEntries(new FormData(form))
			newClass = formData["newClass"]

			console.log(currClass, newClass, newClass != currClass)

			if (newClass != currClass) {
				assignmentData = classdata[currClass]["assignments"][assNum]
				console.log("Got", assignmentData, "from", currClass, assNum, classdata[currClass]["assignments"])
				classdata[currClass]["assignments"].splice(assNum, 1)
				console.log("Spliced", classdata[currClass]["assignments"])
				assNum = classdata[newClass]["assignments"].length
				classdata[newClass]["assignments"].push(assignmentData)
				console.log("Put", assignmentData, "into", newClass, assNum, classdata[newClass]["assignments"])
			}

			classdata[newClass]["assignments"][assNum]["name"] = formData["txtName"]
			dueDate = new Date(formData["dtDue"])
			// Account for timezone offset between html date input and UTC date object
			dueDate.setTime(dueDate.getTime() - new Date().getTimezoneOffset() * 60000)
			classdata[newClass]["assignments"][assNum]["due"] = dueDate.getTime() / 1000

			updateAssignmentElementFromData($(assignment), newClass, assNum)
			updateData()
			sortAssignments()

			e.preventDefault()
		}

		function updateData() {
			$.post("upload.php", JSON.stringify(classdata), function(data) {
				console.log(data);
			})
		}
	</script>
</body>

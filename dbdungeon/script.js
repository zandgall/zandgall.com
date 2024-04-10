/*
    Zander Gall
    For my Computer Science Class
    Professor Furtney

    12/7/23 - Wrote backpack and interface toggling, form validation, submission, and draggable elements
    12/9/23 - Fixed dragging for backpack slot
            - Submit transaction now only reloads the page if the response was 200 - OK
*/

var backpackHovered = false

function mouseEnteredBackpack(){backpackHovered = true}
function mouseLeftBackpack(){backpackHovered = false}

// 'trigger reflow' in order to restart animations - referencing https://css-tricks.com/restart-css-animation/
function toggle(elementQuery) {
    let out     = $(elementQuery).hasClass("out")
    let remove  = out ? "out" : "in",
        add     = out ? "in" : "out"
    $(elementQuery).removeClass(remove)
    void $(elementQuery)[0].offsetWidth
    $(elementQuery).addClass(add)
}

function validateForm() {
    // Grab form values
    let slot = $("#lstSlot").val()-1, type = $("input[name='radType']:checked").val();
    
    let valid = (type=="toBackpack" && BACKPACK[slot] == "Empty" && PAGE[slot] != "Empty") ||
                (type=="fromBackpack"&&BACKPACK[slot] != "Empty" && PAGE[slot] == "Empty")
    
    if(valid)
        $("#interfaceSubmit").removeAttr("disabled")
    else
        $("#interfaceSubmit").attr("disabled", "true")

    return valid
}

function submitTransaction(e) {
    // Prevent default submission, make a fetch api post request with form data to "dbdungeon/post.php", and reload the page

    e.preventDefault()
    fetch(DBDUNGEON_DIR+"post", {
        method: "POST",
        body: new FormData($("#interfaceForm")[0])
    }).then(response => {
        if(response.status==200)
            location.reload()
        else 
            console.log("Try again?")
    })
}
$("#interfaceForm").on("submit", submitTransaction)

// Verify form on load
window.onload = validateForm

for(let i = 1; i <= 8; i++) {
    if(document.getElementById("page."+i+".header")!=null)
        moveElement(document.getElementById("page."+i+".header"))
    if(document.getElementById("backpack."+i+".header")!=null)
        moveElement(document.getElementById("backpack."+i+".header"))
}

// Referenced https://www.w3schools.com/howto/howto_js_draggable.asp
function moveElement(header) {
    let element = header.parentElement
    header.onmousedown = mouseDown

    let offset = {x:0, y:0}
    function mouseDown(e) {
        e.preventDefault()

        // Mark begin position
        let rect = element.getBoundingClientRect()
        offset.x = e.clientX - rect.left
        offset.y = e.clientY - rect.top
        
        if(element.classList.contains("backpackSlot")) {
            offset.x += element.parentElement.parentElement.offsetLeft
            offset.y += element.parentElement.parentElement.offsetTop
        }

        // Add 'dragging' class to element
        element.classList.add("dragging")

        // Add function handles for moving and letting go of the mouse
        document.onmouseup = letGo
        document.onmousemove = move
    }

    function move(e) {
        e.preventDefault()

        element.style.top = Math.floor(- offset.y + e.clientY) + "px";
        element.style.left = Math.floor(- offset.x + e.clientX) + "px";
    }

    function letGo() {
        $("#lstSlot").val(element.getAttribute("slot"))

        if(backpackHovered && element.classList.contains("pageSlot")) {
            document.getElementById("toBackpack").checked = true
            if(validateForm())
                submitTransaction(new Event("submit"))
        } else if(!backpackHovered && element.classList.contains("backpackSlot")) {
            document.getElementById("fromBackpack").checked = true
            if(validateForm())
                submitTransaction(new Event("submit"))
        }
        element.classList.remove("dragging")
        element.style.removeProperty("top")
        element.style.removeProperty("left")
        document.onmouseup = null
        document.onmousemove = null
    }
}
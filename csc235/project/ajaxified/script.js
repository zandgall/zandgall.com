/*
    Zander Gall - galla@csp.edu
    CSC235 - Prof. Furtney

    11/25 - Added toggle functions
    11/26 - Began form validation
    11/27 - Finalized form validation, added draggability
    ---- WEEK 5 ----
    12/2  - Copied over, started editing to allow clicking links without switching to dragging right away
*/

let backpackOut = true;
function toggleBackpack() {
    // Need to 'trigger reflow' https://css-tricks.com/restart-css-animation/ (bottom of page)
    if(backpackOut) {
        document.getElementById("backpack").classList.remove("out");
        void document.getElementById("backpack").offsetWidth;
        document.getElementById("backpack").classList.add("in");
    } else {
        document.getElementById("backpack").classList.remove("in");
        void document.getElementById("backpack").offsetWidth;
        document.getElementById("backpack").classList.add("out");
    }

    backpackOut = !backpackOut;
}

let interfaceOut = false;
function toggleInterface() {
    // See toggleBackpack
    if(interfaceOut) {
        document.getElementById("interface").classList.remove("out");
        void document.getElementById("interface").offsetWidth;
        document.getElementById("interface").classList.add("in");
    } else {
        document.getElementById("interface").classList.remove("in");
        void document.getElementById("interface").offsetWidth;
        document.getElementById("interface").classList.add("out");
    }

    interfaceOut = !interfaceOut;
}

function validateTransaction() {
    // Called whenever the interface form is updated.
    // the Server will provide JavaScript arrays with page and backpack content, to tell if a slot on the page or backpack is empty
    
    // Grab form data
    let slot = document.getElementById("lstSlot").value-1; // Convert from 1-8 to 0-7 index range 
    let type = document.querySelector('input[name="radType"]:checked').value; // https://stackoverflow.com/a/24886483

    if(type=="toBackpack" && BACKPACK[slot] == "Empty" && PAGE[slot] != "Empty") {
        document.getElementById("interfaceSubmit").removeAttribute("disabled");
        return true;
    }
    else if(type=="fromBackpack" && BACKPACK[slot] != "Empty" && PAGE[slot] == "Empty") {
        document.getElementById("interfaceSubmit").removeAttribute("disabled");
        return true;
    }
    // else
    document.getElementById("interfaceSubmit").setAttribute("disabled", "disabled");

    return false;
}

// JavaScript Post request rather than form submission (helps with forwards-backwards navigation)
function submitTransaction(e) {
    console.log("Running transaction", e)
    e.preventDefault();

    // Using the simpler 'fetch' api
    // https://www.freecodecamp.org/news/javascript-post-request-how-to-send-an-http-post-request-in-js/
    const form = new FormData(document.getElementById("interfaceForm"));
    fetch(POST_SCRIPT, {
        method:"POST",
        body: form
    }).then(response => response.text()).then(data => console.log(data));

    // Refresh page
    // location.reload();
}
document.getElementById("interfaceForm").onsubmit = submitTransaction;

// Verify interface state on load
window.onload = validateTransaction;



/*      DRAGGABLE ELEMENTS HANDLING         */
// Functions to detect whether the mouse is over the backpack or not
let mouseOverBackpack = false;
function mouseEnteredBackpack() {mouseOverBackpack = true;console.log("Backpack!");}
function mouseLeftBackpack() {mouseOverBackpack = false;console.log("Not Backpack :(");}

// Add move triggers for all elements and slots
for(let i = 1; i<=8; i++) {
    if(document.getElementById("element"+i+".header")!=null)
        moveElement(document.getElementById("element" + i+".header"));
    if(document.getElementById("slot"+i+".header")!=null)
        moveElement(document.getElementById("slot" + i+".header"));
}

// Referencing https://www.w3schools.com/howto/howto_js_draggable.asp
function moveElement(header) {
    let element = header.parentElement;
    header.onmousedown = dragMouseDown;

    let start = {x:0, y:0};
    function dragMouseDown(e) {
        e.preventDefault(); // Prevents selecting text

        // Mark begin position
        let rect = element.getBoundingClientRect();
        start.x = e.clientX - rect.left;
        start.y = e.clientY - rect.top;
        if(element.classList.contains("slot")) {
            start.x += element.parentElement.parentElement.offsetLeft;
            start.y += element.parentElement.parentElement.offsetTop;
        }

        // Add 'dragging' class to element
        element.classList.add("dragging");

        // Add function handles for moving and letting go of the mouse
        document.onmouseup = letGo;
        document.onmousemove = move;
    }

    function move(e) {
        e.preventDefault(); // Prevents selecting text

        element.style.top = Math.floor(element.offsetTop*0 - start.y + e.clientY) + "px";
        element.style.left = Math.floor(element.offsetLeft*0 - start.x + e.clientX) + "px";
    }

    function letGo(e) {
        // Modify the form
        document.getElementById("lstSlot").value = element.getAttribute("slot");
        
        if(mouseOverBackpack && element.classList.contains("element")) {
            // Select the toBackpack radio button, verify that the current settings are valid, and submit the transaction if valid
            document.getElementById("toBackpack").checked = true;
            if(validateTransaction())
                document.getElementById("interfaceForm").submit();
        } else if(!mouseOverBackpack && element.classList.contains("slot")) {
            // Select the fromBackpack radio button, verify that the current settings are valid, and submit the transaction if valid
            document.getElementById("fromBackpack").checked = true;
            if(validateTransaction())
                document.getElementById("interfaceForm").submit();
        }
        element.classList.remove("dragging");
        element.style.removeProperty("top");
        element.style.removeProperty("left");
        document.onmouseup = null;
        document.onmousemove = null;
    }
}
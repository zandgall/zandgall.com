/// Mouse
// Mouse button input
var leftPress = false, rightPress = false, middlePress = false, leftClick = false, rightClick = false, middleClick = false,
leftDblClick = false, rightDblClick = false, middleDblClick = false, leftRelease = false, rightRelease = false, middleRelease = false;
// Mouse movement input, mouse scroll and glided mouse scroll (pretty much just "smooth scrolling")
var mouseX = 0, mouseY = 0, mouseScroll = 0, mouseScroll_g = 0;

/// Keyboard
// Keys
// @ts-ignore
var keys = new Map(), typed = new Map();
var currentCanvas;

// Events
/**
 * @param {MouseEvent} ev
 */
function mousemove(ev) {
    mouseX = ev.pageX - currentCanvas.getBoundingClientRect().left;
    mouseY = ev.pageY - currentCanvas.getBoundingClientRect().top;
}
/**
 * @param {MouseEvent} ev
 */
function click(ev) {
    switch(ev.button) {
        case 0:
            leftClick = true;
            break;
        case 1:
            rightClick = true;
            break;
        case 2:
            middleClick = true;
            break;
    }
}

function dblClick(ev) {
    switch(ev.button) {
        case 0:
            leftDblClick = true;
            break;
        case 1:
            rightDblClick = true;
            break;
        case 2:
            middleDblClick = true;
            break;
    }
}

function mousedown(ev) {
    switch(ev.button) {
        case 0:
            leftPress = true;
            leftClick = false;
            leftDblClick = false;
            break;
        case 1:
            rightPress = true;
            rightClick = false;
            rightDblClick = false;
            break;
        case 2:
            middlePress = true;
            middleClick = false;
            middleDblClick = false;
            break;
    }
}

function mouseup(ev) {
    switch(ev.button) {
        case 0:
            leftPress = false;
            leftClick = false;
            leftDblClick = false;
            break;
        case 1:
            rightPress = false;
            rightClick = false;
            rightDblClick = false;
            break;
        case 2:
            middlePress = false;
            middleClick = false;
            middleDblClick = false;
            break;
    }
}

/**
 * 
 * @param {KeyboardEvent} ev 
 */
function keydown(ev) {
    keys[ev.key] = true;
    typed[ev.key] = false;
}

/**
 * 
 * @param {KeyboardEvent} ev 
 */
function keyup(ev) {
    keys[ev.key] = false;
    typed[ev.key] = false;
}

/**
 * 
 * @param {KeyboardEvent} ev 
 */
function keypress(ev) {
    typed[ev.key] = true;
}

// Linking events to document
window.onload = function() {
    document.addEventListener("mousemove", mousemove);
    document.addEventListener("click", click);
    document.addEventListener("dblclick", dblClick);
    document.addEventListener("mousedown", mousedown);
    document.addEventListener("mouseup", mouseup);
    document.addEventListener("keydown", keydown);
    document.addEventListener("keyup", keyup);
    document.addEventListener("keypress", keypress);
}
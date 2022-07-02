function draw() {
    var can = document.getElementById("canv");
    var c = can.getContext("2d");
    c.clearRect(0, 0, 800, 800);
    $.getJSON('get.php', function(data) {

    });
}

$("document").ready(function() {
    console.log("Init");
    window.setInterval(draw, 1000);
});
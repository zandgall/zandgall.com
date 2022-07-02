<html lang="en">
<?php 
$pagetitle = "Zandgall - Lants";
$pagedesc = "An overview of Langton's Ant, and my implementation of it";
include "global/header.php"?>

<?php 
$title = "Lants!";
$subtitle = "LLRRRLRLRLLR";
include "global/begin.php"?>

<div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm">
    <!-- Parent has no display style, so give it one here, but with a lower opacity. Not applied to parent so that other children won't have a default opacity of 0.92 -->
    <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div>
    <!--STUFF HERE-->
    <img class="section" width=880 style="image-rendering: pixelated; margin-top: 40; margin-left: -40; margin-bottom: 10; position: relative; width: 880; height: auto;" src="assets/lants/0.png">

    <h1 class="basictext">
        Lants
    </h1>

    <h2 class="basictext">
        What is Lants?
    </h2>

    <h3 class="basictext">
        Lants is a simulation of Langton's Ant. A Cellular Automaton that produces emergent behaviour. But all that is explained below, here's a summary of what the game is.
        <br><br>
        Opening the file, you will see one ant: The 'convolutional ant' (One of the exmple ant rules given by Langton's Ant Wikipedia page). Clicking anywhere will spawn a Lant, with the original rules: RL.
    </h3>

    <img class="section" width = 880 style="image-rendering: pixelated; margin-top: 40; margin-left: -40; margin-bottom: 10; position: relative; width: 880; height: auto;" src="assets/lants/convolution.gif">

    <h2 class="basictext">
        Langton's Ant, and Cellular Automaton.
    </h2>

    <h3 class="basictext">
        Cellular Automaton is a study model in "automata theory". Where, a set of cells are able to interact with eachother, and (if conditions are good) produce 'emergent behavior'. Emergent behavior is an outcome that is greater than the sum of it's parts. Examples of such include fractal-like snowflakes emerging from freezing water, or a large metropolis emerging from individual humans, or even an ant colony with tunnels that stretch over a continent.
        <br><br>
        The exact specifics of Cellular Automaton is not relevant, the only thing to note is that Langton's ant is one of the more game-like fun uses of Cellular Automaton. It is similar to John Conway's Game of Life, a more well known example of a Cellular Automaton game.
    </h3>

    <img class="section" width = 880 style="image-rendering: pixelated; margin-top: 40; margin-left: -40; margin-bottom: 10; position: relative; width: 880; height: auto;" src="assets/lants/the ant.gif">

    <h2 class="basictext">
        The rules.
    </h2>

    <h3 class="basictext">
        Langton's Ant stars an Ant, and this ant lives on an infinite plane of Cells. The cells can be either black on white, and there are 2 rules. If the ant is on a white tile, turn to the left and flip the tile to black. If it was black, do the opposite. Turning to the right and switching the tile to white.
        <br><br>
        This is called 'RL' as it has two tiles, one that turns the ant right, and the other that turns the ant left. As you might guess from this and the "convolutional ant" from earlier, these rules can be altered. And when they are, they can give many more interesting properties.
    </h3>

    <img class="section" width = 880 style="image-rendering: pixelated; margin-top: 40; margin-left: -40; margin-bottom: 10; position: relative; width: 880; height: auto;" src="assets/lants/chunks and highways.gif">

    <h2 class="basictext">
        The 'Infinite' Plane
    </h2>

    <h3 class="basictext">
        This game is chunk-based, what this means is that there's a list of squares, each with 32 * 32 cells in them. Each chunk has a texture, and that texture is drawn over every time a tile is changed. When an ant passes into a chunk that's not part of the currently available chunks, it creates a new one and sets it's new position to where it was loaded.
        <br><br>
        How an ant traverses this plane, is up to the rules given to it. The default rule, RL, develops highways as seen above. It will start moving outward after a certain amount of iterations, when the tile pattern it hits allows it to repeat itself as seen.
        <br><br>
        This changes from rule to rule, some rules might have highways, others might not. The <a href="https://en.wikipedia.org/wiki/Langton%27s_ant">Wikipedia page</a> gives some examples of some good rules down near the bottom.
    </h3>


    <h1 class = "basictext">Interesting Phenomenon</h1>

    <img class="section" width = 880 style="image-rendering: pixelated; margin-top: 40; margin-left: -40; margin-bottom: 10; position: relative; width: 880; height: auto;" src="assets/lants/oscillator.gif">
    <h2 class = "basictext">Similar to John Conway's Game of Life, there are oscillators that can be created here. Putting two ants next to eachother will cause this.</h2>
    <img class="section" width = 880 style="image-rendering: pixelated; margin-top: 40; margin-left: -40; margin-bottom: 10; position: relative; width: 880; height: auto;" src="assets/lants/dual oscillator.gif">
    <h2 class = "basictext">Putting two oscillators diaganolly to eachother will create this dual oscillator, which acts almost as a co/sine wave every x iterations.</h2>

    <img class="section" width = 880 style="image-rendering: pixelated; margin-top: 40; margin-left: -40; margin-bottom: 10; position: relative; width: 880; height: auto;" src="assets/lants/growing diamond.gif">
    <h2 class = "basictext">Putting two ants one on top of the other, will start forming this diamond shape,</h2>

    <img class="section" width = 880 style="image-rendering: pixelated; margin-top: 40; margin-left: -40; margin-bottom: 10; position: relative; width: 880; height: auto;" src="assets/lants/eating.gif">
    <h2 class = "basictext">The reverse of highways, eating. While a highway is being built, an ant might hit it, dash to the end, and force the highway ant to reverse itself and start eating it's own highway. Almost like a retreat signal.</h2>

    <img class="section" width = 880 style="image-rendering: pixelated; margin-top: 40; margin-left: -40; margin-bottom: 10; position: relative; width: 880; height: auto;" src="assets/lants/building and eating.gif">
    <h2 class = "basictext">Another example of building and eating</h2>

    <a href="Downloads/Lants v.1.0.0.zip"><div class="section" style="width:75%; margin-left: auto; margin-right: auto; margin-bottom: 20;"><h1 class="basictext outlinetext">Download Lants v1.0.0.zip</h1></div></a>
    <div class="splitter" style="margin-bottom:10;"></div>
    <a href="index" style="position:absolute; align-content: center; text-align: center; float: left; left: 50%; margin-left: auto; margin-right: auto; margin-bottom: 10;"><div style="margin-left: -50%;"><h3 class="basictext">Back</h3></div></a>

</div>
<?php include "global/end.php"?>
</html>
<!DOCTYPE html>
<html lang="en">
<?php 
$pagetitle = "Zandgall - NBT C++";
$pagedesc = "A Showcase of the features and examples of an NBT Library written in C++";
include "global/header.php"?>

<?php 
$title = "NBT!";
$subtitle = "The underutilized format, brought to C++";
include "global/begin.php"?>

<!-- <div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm"> -->
    <!-- Parent has no display style, so give it one here, but with a lower opacity. Not applied to parent so that other children won't have a default opacity of 0.92 -->
    <!-- <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div> -->
    <!--STUFF HERE-->
<h1 class="basictext outlinetext" style="margin: 100px auto 50px auto" id="qb64">What is NBT?</h1>
<div class="" style="position: relative; margin: 0 auto auto auto; width: 800px;">
    <h2 class="basictext outlinetext">NBT is an efficient file type used to store ambiguous data</h2>
</div>

<h1 class="basictext outlinetext" style="margin: 100px auto 50px auto">What is the Library?</h1>
<div class="" style="position: relative; margin: 0 auto auto auto; width: 800px;">
    <h2 class="basictext outlinetext">This library is a header-only C++ file that allows you to read, write, and interact with NBT data structures.</h2>
</div>

<h1 class="basictext outlinetext" style="margin: 100px auto 50px auto">How do I implement it?</h1>
<div class="" style="position: relative; margin: 0 auto auto auto; width: 800px;">
    <h2 class="basictext outlinetext">Go to <a href="https://github.com/zandgall/NBT">https://github.com/zandgall/NBT</a> and download "nbt.hpp"</h2>
    <h2 class="basictext outlinetext">When you include it in your project, first #define NBT_INCLUDE to allow access to all the features</h2>
</div>

<h1 class="basictext outlinetext" style="margin: 100px auto 50px auto">How do I use it?</h1>
<div class="" style="position: relative; margin: 0 auto auto auto; width: 800px;">
    <h2 class="basictext outlinetext">Everything in this library is under a namespace called "nbt". Each tag is defined as a class, nbt::tag (ambiguous), nbt::compound, nbt::bytetag, etc.</h2>
    <h2 class="basictext outlinetext">Each tag has a load, write, value_bytes(), and discard function. Load will take in a pointer to memory and an offset, and read it's data from it. If the class of the tag and the id given in the data don't match, throwr an "invalid_tag_id_exception".
        Write takes either a vector of bytes, or a pointer to memory with an offset. Value Bytes will return the payload of the tag, and discard will free any memroy held by the tag.
    </h2>
    <h2 class="basictext outlinetext">Each class will publically store their value. For example, nbt::bytetag has a public attribute int8_t "data". There are two general tags, Primitive tag, and Primitive Array tag. Byte, Short, Int, Long, Float, and Double tags are derived from primitive tag. Whereas Byte, Int, and Long array tags are derived from primitive arrays.
        You can create your own primitive and primitive array tags, however at this point in time, you cannot read custom tags from NBT file data.
    </h2>
    <h2 class="basictext outlinetext">Once you read your NBT file data, you can pass it into the load function of a compound tag, this will read all the data of the file into a coumpound tag.</h2>
</div>
<h1 class="basictext outlinetext" style="width: 800px">Example code to show the basic usage of NBT c++ and GZNBT.</h1>
<img style = "position: relative; width: 800px" src="assets/nbt%20example.png" alt="NBT Example Code">
<!-- </div> -->
<h2 class="basictext outlinetext">WIP MORE INFORMATION COMING SOON</h2>
<!-- </div> -->
<?php include "global/end.php"?>
</html>
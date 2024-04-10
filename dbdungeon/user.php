<?php 
/*
    Zander Gall - galla@csp.edu
    CSC235 - Prof. Furtney

    12/5/23     - Wrote user session starter
    12/19/23    - Modified user creation to only populate pages when they're loaded. (i.e, when this script is called, if there is no entry for the current user on the current page, add it)
*/

// We keep the current UUID in the $_SESSION["user"] variable. If it isn't there, generate a new one.
if(!isset($_SESSION["user"])) {
    // Because my server is on linux, I can use this neat built in uuid generator
    $newUser = exec('uuidgen -r');

    attemptPrep("call newUser(?)", "s", $newUser);
    $_SESSION["user"] = $newUser;
}

$userPageData = attemptPrep("SELECT * FROM $pageTable WHERE $pageTable.uuid = ?", "s", $_SESSION["user"])->fetch_assoc();
if($userPageData == null || !key_exists('1', $userPageData)) {
    attemptPrep("INSERT INTO $pageTable SELECT ?, `1`, `2`, `3`, `4`, `5`, `6`, `7`, `8` FROM DefaultData WHERE DefaultData.id=?", "si", $_SESSION["user"], $pageIndex);
}
?>
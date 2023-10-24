function createUpgrade(id, name, value, functionPath, img, unlock, locks) {
    var unlockFunc = "";
    for (let i = 0; i < unlock.length; i++) {
        // unlockFunc+="$('#"+unlock[i]+"').css('display', 'block'); $('#"+unlock[i]+"').insertAfter('#begin'); ";
        unlockFunc += "makeVisible('" + unlock[i] + "'); ";
    }
    for (let i = 0; i < locks.length; i++) {
        unlockFunc += "$('#" + locks[i] + "').remove(); ";
    }
    var link = "<a href=\"#\" onclick=\"if(money>=" + value + "){" + functionPath + "; money-=" + value + "; prm-=" + value + "; $('#" + id + "').remove(); " + unlockFunc + "}\" id = " + id + " style=\"positive:relative;\"><img style=\"position:relative; filter: brightness(1)\" src=\"Funsies/BubbleCannons/upg/" + img + "\" title=\"" + name + "\"></a>";
    // @ts-ignore
    $("#upgrade").append(link);
    // @ts-ignore
    $("#" + id).css("display", "none");
}

function createPlayerUpgrade(name, description, value, unlock, locks) {
    createUpgrade(name, description, value, "player.upgrade('" + name + "')", name + ".png", unlock, locks);
}

function makeVisible(id) {
    $("#" + id).css("display", "block");
    let children = $("#upgrade").children();
    for (var i = 0; i < children.length; i++) {
        if ($(children[i]).css("dislay") === 'none') {
            $(children[i]).before($("#" + id));
            return;
        }
    }
}

// @ts-ignore
$(document).ready(function() {
    createUpgrade("barrel100", "Reloads 25% faster", 100, "player.upgrade('barrel100')", "fasterbarrel.png", ["barrel400", "sharpbullets"], ["fatbarrel", "daredevil", "bomblauncher"]);
    createUpgrade("fatbarrel", "Shoots Cannonballs that can hit through two different tanks", 200, "player.upgrade('fatbarrel')", "fatbarrel.png", ["heavyduty", "highvelocity"], ["barrel100", "daredevil", "bomblauncher"]);
    createUpgrade("bomblauncher", "Spits out bombs instead of bullets", 250, "player.upgrade('bomblauncher')", "bomblauncher.png", ["rockets", "bombtrio"], ["daredevil", "barrel100", "fatbarrel"]);
    createUpgrade("sharpbullets", "Flies faster and pierces 2 health from each tanks", 300, "player.upgrade('sharpbullets')", "sharpbullets.png", ["sharperbullets"], ["fatbarrel", "daredevil", "bomblauncher"]);
    createUpgrade("rockets", "Fires explosive rockets instead of bombs", 1000, "player.upgrade('rockets')", "rockets.png", ["heatseeking"], []);
    createUpgrade("heatseeking", "Targets onto the closest enemy and explodes it", 2500, "player.upgrade('heatseeking')", "heatseeking.png", ["nuke"], []);
    createUpgrade("nuke", "Destroys anything it explodes", 5000, "player.upgrade('nuke')", "nuke.png", [], []);
    createUpgrade("bombtrio", "Shoots 3 bombs at once", 400, "player.upgrade('bombtrio')", "bombtrio.png", ["3squared"], []);
    createUpgrade("3squared", "Reloads twice as fast", 2500, "player.upgrade('3squared')", "3squared.png", [], []);
    createUpgrade("heavyduty", "Bullets can hit through three different tanks", 600, "player.upgrade('heavyduty')", "heavyduty.png", ["shellshock"], []);
    createUpgrade("highvelocity", "Reloads twice as fast, and bullets move faster", 1000, "player.upgrade('highvelocity')", "highvelocity.png", ["thebigone"], []);
    createUpgrade("thebigone", "Reloads twice as fast, bullets move even faster", 2500, "player.upgrade('thebigone')", "thebigone.png", ["ultracannon"], []);
    createUpgrade("ultracannon", "Reloads at an incredibly fast rate", 4000, "player.upgrade('ultracannon')", "ultracannon.png", [], []);
    createUpgrade("shellshock", "Bullets take 2 health away from each tank they hit", 1000, "player.upgrade('shellshock')", "shellshock.png", [], []);
    createUpgrade("sharperbullets", "Flies faster and tears through 2 different tanks", 1000, "player.upgrade('sharperbullets')", "sharperbullets.png", [], []);
    createUpgrade("barrel400", "Reloads 25% faster", 400, "player.upgrade('barrel400')", "evenfasterbarrel.png", ["barrel750"], []);
    createUpgrade("barrel750", "Reloads 25% faster", 750, "player.upgrade('barrel750')", "dangerfastbarrel.png", ["semiauto"], []);
    createPlayerUpgrade("semiauto", "Reloads 5x faster", 1000, [], []);
    createPlayerUpgrade("thickskin", "Increases health by 10!", 250, [], ["daredevil"]);
    createPlayerUpgrade("fasttreads", "Increases speed by 30%", 150, [], ["daredevil"]);
    createUpgrade("daredevil", "...?", 1610, "player.upgrade('daredevil')", "daredevil.png", [], ["fatbarrel", "barrel100", "sharpbullets", "bomblauncher", "thickskin", "fasttreads"]);

    makeVisible("barrel100");
    makeVisible("fatbarrel");
    makeVisible("bomblauncher");
    makeVisible("thickskin");
    makeVisible("fasttreads");
    makeVisible("daredevil");
});
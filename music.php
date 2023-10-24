<!DOCTYPE html>
<html lang="en">
<?php 
$pagetitle = "Zandgall - Music";
$pagedesc = "A collection of Zandgall's music";
include "global/header.php"?>

<?php 
$title = "Music!";
$subtitle = "From listenable to less so";
include "global/begin.php"?>

<!-- <div style="position: relative; margin-left: auto; margin-right: auto; margin-top: 0; width: min(800px, 80vw); margin-bottom: 2cm"> -->
    <!-- Parent has no display style, so give it one here, but with a lower opacity. Not applied to parent so that other children won't have a default opacity of 0.92 -->
    <!-- <div class="section" style="position:absolute; width:100%; height:100%; margin-top: 0; opacity: 0.92"></div> -->
    <!--STUFF HERE-->
    <!-- <a style="color: rgba(0,0,0,0)" href=https://zandgall.bandcamp.com/releases target="_blank">Bandcamp</a></p> -->

    <div style="width:55vw; max-width:800px; height:780px; margin: 5cm auto 0 auto">
        <iframe style="border-radius:12px;" src="https://open.spotify.com/embed/album/0E6QUnse299lO788TWbE8t?utm_source=generator" 
            width="100%" height="100%" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
    </div>

    <div style="margin: auto; text-align: center">
        <iframe style="border: 0; width: 700px; height: 1136px;" src="https://bandcamp.com/EmbeddedPlayer/album=2644588502/size=large/bgcol=333333/linkcol=0f91ff/transparent=true/" seamless><a href="https://zandgall.bandcamp.com/album/revopia">Revopia by Zandgall</a></iframe>
        <iframe style="border: 0; width: 700px; height: 1136px;" src="https://bandcamp.com/EmbeddedPlayer/album=2506980105/size=large/bgcol=333333/linkcol=0f91ff/transparent=true/" seamless><a href="http://zandgall.bandcamp.com/album/zzzzzzzz">Zzzzzzzz by Zandgall</a></iframe>
        <iframe style="border: 0; width: 700px; height: 1136px;" src="https://bandcamp.com/EmbeddedPlayer/album=1757049274/size=large/bgcol=333333/linkcol=0f91ff/transparent=true/" seamless><a href="http://zandgall.bandcamp.com/album/arvopia-01-10">Arvopia 0.1-1.0 by Zandgall</a></iframe>
        <iframe style="border: 0; width: 700px; height: 1136px;" src="https://bandcamp.com/EmbeddedPlayer/album=1499950768/size=large/bgcol=333333/linkcol=0f91ff/transparent=true/" seamless><a href="http://zandgall.bandcamp.com/album/electicity">Electricity by Zandgall</a></iframe>
    </div>
<!-- </div> -->

<?php include "global/end.php"?>
</html>
<script>

    $("#universal").on("scroll", function(){
        let scroll = $("#universal").scrollTop();
        let par = $("#parallax");
        par.find("#back").css("transform", `translate3D(0, ${-scroll * 0.1}px, 0)`)
        par.find("#mid").css("transform", `translate3D(0, ${-scroll * 0.2}px, 0)`)
        par.find(".front").css("transform", `translate3D(0, ${-scroll * 0.4}px, 0)`)
        if (cloudToggle) {
            let clouds = $(".cloud");
            for (let i = 0; i < clouds.length; i++) {
                var trans = $(clouds[i]).css("transform") || $(clouds[i]).css("-webkit-transform") || $(clouds[i]).css("-moz-transform") || $(clouds[i]).css("-mz-transform") || $(clouds[i]).css("-o-transform");
                var mat = (trans.replace(/[^0-9\-.,]/g, '').split(','));
                var x = parseFloat(mat[12] || mat[4] || 0);
                var y = parseFloat($(clouds[i]).data("data-y")) - scroll * (parseFloat($(clouds[i]).data("data-z")) * 0.4*0.25 + 0.1);
                var scale = parseFloat(mat[0] || 1);

                $(clouds[i]).css("transform", `translate(${x}px, ${y}px) scale(${scale})`)
                if(x > parseFloat($("body").width()))
                    setupcloud(clouds[i], true);
            }
        }
    });

    var cloudToggle = (localStorage["zandgall.cloud"] || "true") === "true";

    var wIndex = 0.5; // Hahahahahahahahahahahahahahah
    var wind = perlin.get(wIndex, 0);

    function setupcloud(cloud, reset) {
        var z = Math.random() * 4;
        
        var zind = 0;
        var zspeed = (z * 0.4*0.25 + 0.1);
        let scroll = $("#universal").scrollTop();
       
        if(zspeed < 0.1) {
            zind = -4;
            $(cloud).data("data-y", Math.random()*200);
        }
        else if (zspeed < 0.2) {
            zind = -3;
            $(cloud).data("data-y", Math.random()*400);
        }
        else if(zspeed < 0.4) {
            zind = -2;
            $(cloud).data("data-y", Math.random()*800);
        }
        else {
            zind = 0;
            $(cloud).data("data-y", Math.random()*1600);
        }
        $(cloud).data("data-z", z);
        $(cloud).css("transform", `translate(${reset ? (wind < 0 ? parseFloat($("body").width()) : -400) : (Math.random()) * parseFloat($("body").width())}px, ${parseFloat($(cloud).data("data-y")) - scroll * (z * 0.4*0.25 + 0.1)}px) scale(${z*0.125+0.125})`);
        $(cloud).css("filter", `opacity(${z*0.25 + Math.random()*0.01})`);
        $(cloud).css("z-index", zind);
    }

    function cloudsetup() {
        let clouds = $(".cloud");
        for (let i = 0; i < clouds.length; i++)
            setupcloud(clouds[i], false);
    }

    function cloudupdate() {
        if (cloudToggle) {
            wIndex += 0.0001;
            wind = perlin.get(wIndex, 0);
            let clouds = $(".cloud");
            for (let i = 0; i < clouds.length; i++) {
                var trans = $(clouds[i]).css("transform") || $(clouds[i]).css("-webkit-transform") || $(clouds[i]).css("-moz-transform") || $(clouds[i]).css("-mz-transform") || $(clouds[i]).css("-o-transform");
                var mat = (trans.replace(/[^0-9\-.,]/g, '').split(','));
                var x = parseFloat(mat[12] || mat[4] || 0) + parseFloat($(clouds[i]).data("data-z")) * wind;
                var y = parseFloat(mat[13] || mat[5] || 0);
                var scale = parseFloat(mat[0] || 1);

                $(clouds[i]).css("transform", `translate(${x}px, ${y}px) scale(${scale})`)
                if(x > parseFloat($("body").width()) || x < -400)
                    setupcloud(clouds[i], true);
            }
        }
    }
    cloudsetup();

    window.setInterval(cloudupdate, 13);

</script>

    <script>
        $(".link").mouseover(function() {
            let description = this.lastChild;
            var rect = this.getBoundingClientRect();
            $(description).css("left", rect.left);
            let em = parseFloat(getComputedStyle(this).fontSize);
            let wind_height = window.innerHeight;
            $(description).show();
            let desc_height = description.getBoundingClientRect().height;
            if(desc_height + rect.y + 1.5*em>= wind_height)
                $(description).css("top", "calc("+(rect.top-desc_height)+"px - 3em)");
            else 
                $(description).css("top", "calc("+rect.top+"px + 1.5em)");
        }).mouseout(function() {
            $(this).children(".description").hide();
        });
    </script>

</body>
</html>
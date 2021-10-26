
<html>
   <body>
   <form action="compiler.php" method="POST" enctype="multipart/form-data">
        <input type="file" name="file">
        <input type="submit" name="submit">
        <input type="range" id="scale" name="scale" value=1 min=0.05 max=1 step=0.05 oninput="this.nextElementSibling.value = this.value">
        <output>1</output>
        <label for="scale">Scale</label>
        <input type="checkbox" id="indexed" name="indexed" value = false>
        <label for="indexed">Indexed</label>
    </form>
   </body>
</html>
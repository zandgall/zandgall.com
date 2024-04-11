<?php
    // Simply puts the content from 'data_templace.json' into 'data.json'
    file_put_contents("data.json", file_get_contents("data_template.json"));
?>
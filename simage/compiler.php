<?php 
    header("Access-Control-Allow-Origin: *");
    header('Content-Type: application/txt');
    header('Content-Disposition: attachment; filename="downloaded.txt"');
    if(isset($_POST['submit'])){
        $name       = $_FILES['file']['name'];  
        $temp_name  = $_FILES['file']['tmp_name'];  
        if(isset($name) and !empty($name)){
            $location = '../uploads/';      
            if(move_uploaded_file($temp_name, $location.$name)){
                if(is_image($location.$name))
                    magic($location.$name);
                else {
                    echo 'Please upload an image as PNG or JPEG/JPG!';
                }
            }
        } else {
            echo 'You should select a file to upload !!';
        }
    } else {
        $_POST["scale"] = 0.1;
        magic("../uploads/image.png");
    }
    function magic($path) {
        $ims = getimagesize($path);
        $image;
        if($ims[2]==IMAGETYPE_JPEG)
            $image = imagecreatefromjpeg($path);
        else $image = imagecreatefrompng($path);
        $width = $ims[0] * $_POST["scale"];
        $height = $ims[1] * $_POST["scale"];
        $indexes = [];
        echo (array_key_exists("indexed", $_POST) && $_POST["indexed"] ? 1 : 0)."\n".floor($width)."\n".floor($height);
        for($y = 0; $y < $ims[1]; $y+=1/$_POST["scale"]) {
            for($x = 0; $x < $ims[0]; $x+=1/$_POST["scale"]) {
                $coli = imagecolorat( $image, floor($x), floor($y));
                $colors = imagecolorsforindex( $image, $coli);
                $color = (($colors["red"]<<24)+($colors["green"]<<16)+($colors["blue"]<<8)+floor(2.01*(127-$colors["alpha"])));
                if(array_key_exists("indexed", $_POST) && $_POST["indexed"]) {
                    if(!in_array($color, $indexes))
                        $indexes[count($indexes)] = $color;
                    echo "\n".array_search($color, $indexes);
                } else
                    echo "\n".$color;
                // echo ','.$colors["red"].','.$colors["green"].','.$colors["blue"].','.floor(2.01*(127-$colors["alpha"]));
            }
            // echo "\n";
        }
        if(array_key_exists("indexed", $_POST) && $_POST["indexed"]) {
            for($i = 0; $i < count($indexes); $i++) {
                echo "\n".$indexes[$i];
            }
        }
    }
    function is_image($path) {
        $a = getimagesize($path);
        $image_type = $a[2];
        
        if(in_array($image_type , array(IMAGETYPE_JPEG ,IMAGETYPE_PNG))) {
            return true;
        }
        return false;
    }

?>
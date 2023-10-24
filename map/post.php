<?php
    $message = json_decode(file_get_contents("php://input"));
    if(!isset($message) || !isset($message->key))
        exit;

    $jsondata = file_get_contents("map.json");
    if(!isset($jsondata))
        exit;
    $map = json_decode($jsondata);
    if(!isset($map) || !isset($map->markers) || !isset($map->regions) || !isset($map->deleted_markers) || !isset($map->deleted_regions))
        exit;
    
    var_dump($message);
    // var_dump($map);
    switch ($message->key) {
    case 'add_marker':
        array_push($map->markers, $message->value);
        break;
    case 'marker_move':
        if(!isset($message->marker) || !isset($message->x) || !isset($message->z) || $message->marker==-1) {
            echo "{'message': 'Fail'}";
            exit;
        }
        $map->markers[$message->marker]->x = $message->x;
        $map->markers[$message->marker]->z = $message->z;
        break;
    case 'marker_name':
        if(!isset($message->marker) || !isset($message->value) || $message->marker==-1) {
            echo "{'message': 'Fail'}";
            exit;
        }
        $map->markers[$message->marker]->name = $message->value;
        break;
    case 'marker_description':
        if(!isset($message->marker) || !isset($message->value) || $message->marker==-1) {
            echo "{'message': 'Fail'}";
            exit;
        }
        $map->markers[$message->marker]->description = $message->value;
        break;
    case 'marker_delete':
        if(!isset($message->value)) {
            exit;
        }
        array_push($map->deleted_markers, $map->markers[$message->value]);
        array_splice($map->markers, $message->value, 1);
        break;
    case 'marker_type':
        if(!isset($message->marker) || !isset($message->value) || $message->marker==-1) {
            echo "{'message': 'Fail'}";
            exit;
        }
        $map->markers[$message->marker]->type = $message->value;
        break;
    case 'region_name':
        if($message->region==-1) {
            echo "{'message': 'Fail'}";
            exit;
        }
        $map->regions[$message->region]->name = $message->value;
        break;
    case 'region_description':
        if($message->region==-1) {
            echo "{'message': 'Fail'}";
            exit;
        } else {
            $map->regions[$message->region]->description = $message->value;
        }
        break;
    case 'region_color':
        if($message->region==-1) {
            echo "{'message': 'Fail'}";
            exit;
        }
        $map->regions[$message->region]->color = $message->value;
        break;
    case 'region_image':
        $data = $message->value;
        list($type, $data) = explode(';', $data);
        list(, $data)      = explode(',', $data);
        $data = base64_decode($data);
        file_put_contents('regions/'.$message->region.'.png', $data);
        break;
    case 'region_delete':
        array_push($map->deleted_regions, $map->regions[$message->value]);
        array_splice($map->regions, $message->value, 1);
        break;
    case 'add_region':
        array_push($map->regions, $message->value);
        $data = base64_decode("iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mNkYAAAAAYAAjCB0C8AAAAASUVORK5CYII=");
        file_put_contents('regions/'.$message->region.'.png', $data);
        break;
    }
        
    $jsonout = json_encode($map, JSON_PRETTY_PRINT);
    $fp = fopen("map.json", 'w');
    fwrite($fp, $jsonout);
    fclose($fp);
    echo "{'message': 'Success'}";
?>
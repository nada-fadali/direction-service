<?php
    
    $fullPath = $_GET['download_file'];

    if ($fd = fopen($fullPath, "r")){ 
         


    $fsize = filesize($fullPath);
    $path_parts = pathinfo($fullPath);
    
    header("Content-type: application/octet-stream");
    header("Content-Disposition: filename=\"".$path_parts["basename"]."\"");
    header("Content-length: $fsize");
    header("Cache-control: private"); //use this to open files directly
    
    while(!feof($fd)) {
        $buffer = fread($fd, 2048);
        echo $buffer;
    }
    }
    fclose ($fd);
    exit;
?>
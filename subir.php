<?php
    require("api.imgbb.easyprojects.php");
    $apiImgBB = new ApiImgBB;
    
    if ($apiImgBB->isImg($_FILES['imagen'])) {
        $apiImgBB->upload();

        $url = $apiImgBB->getUrl();

        echo $url;
    }
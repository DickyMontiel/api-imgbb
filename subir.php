<?php
    require "api.imgbb.easyprojects.php";

    $imgBB = new ApiImgBB;

    if($imgBB->isImg($_FILES['imagen'])){
        //$imgBB->setName("KipuStudios");
        $imgBB->upload();
        echo $imgBB->getUrl();
    }else{
        echo "No es una imagen";
    }

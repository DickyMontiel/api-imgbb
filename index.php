<?php
    require("api.imgbb.easyprojects.php");

    if(isset($_FILES['file'])){
        $file = $_FILES['file'];

        //Envia el archivo que se subió
        $apiImgBB = new ApiImgBB($file);

        $json = $apiImgBB->getJson();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <input type="file" name="file">
        <br><br>
        <button type="submit">Enviar</button>
    </form>
    <br><br><br>

    <?php if(isset($_FILES['file'])): ?>
        <img src="<?= $json['data']['url'] ?>">
        <a href="<?= $json['data']['url'] ?>">Ir a Imagen</a>
        <input type="url" value="<?= $json['data']['url'] ?>">
    <?php endif; ?>
</body>
</html>
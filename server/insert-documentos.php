<?php
    require("../conexion.php");

    error_reporting(0);
    $nombre = $_POST["nombre"];

    $insert = "INSERT INTO _cat_documentos VALUES (null, '$nombre', null, null, 1)";
    $resInsert = mysqli_query($conexion, $insert);

    if ($resInsert) {
        header ("Location: ../documentos.php");
    } else {
        header ("Location: ../documentos.php");
    }
    
    mysqli_close($conexion);
?>
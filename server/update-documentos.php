<?php
    require("../conexion.php");

    error_reporting(0);
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];

    $update = "UPDATE _cat_documentos SET nombre = '" .$nombre. "' WHERE id_documento = '" .$id. "'";
    $resUpdate = mysqli_query($conexion, $update);

    if ($resUpdate) {
        header ("Location: ../documentos.php");
    } else {
        header ("Location: ../documentos.php");
    }
    
    mysqli_close($conexion);
?>
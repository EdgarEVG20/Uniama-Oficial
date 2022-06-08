<?php
    require("../conexion.php");

    error_reporting(0);
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];

    $update = "UPDATE _cat_ausencias SET nombre = '" .$nombre. "' WHERE id_ausencia = '" .$id. "'";
    $resUpdate = mysqli_query($conexion, $update);

    if ($resUpdate) {
        header ("Location: ../ausencias.php");
    } else {
        header ("Location: ../ausencias.php");
    }
    
    mysqli_close($conexion);
?>
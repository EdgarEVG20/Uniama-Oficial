<?php
    require("../conexion.php");

    error_reporting(0);
    $nombre = $_POST["nombre"];

    $insert = "INSERT INTO _cat_ausencias VALUES (null, '$nombre', null, null, null, 1)";
    $resInsert = mysqli_query($conexion, $insert);

    if ($resInsert) {
        header ("Location: ../ausencias.php");
    } else {
        header ("Location: ../ausencias.php");
    }
    
    mysqli_close($conexion);
?>
<?php
    require("../conexion.php");

    error_reporting(0);
    $clave = $_POST["clave"];
    $nombre = $_POST["catalogo"];
    $nombre = $_POST["nombre"];

    $insert = "INSERT INTO _cat_estados VALUES (null, '$nombre', '$catalogo', '$clave', 1)";
    $resInsert = mysqli_query($conexion, $insert);

    if ($resInsert) {
        header ("Location: ../estados.php");
    } else {
        header ("Location: ../estados.php");
    }
    
    mysqli_close($conexion);
?>
<?php
    require("../conexion.php");

    error_reporting(0);
    $clave = $_POST["clave"];
    $codigo = $_POST["codigoP"];
    $nombre = $_POST["nombre"];

    $insert = "INSERT INTO _cat_colonias VALUES (null, '$clave', '$codigo','$nombre', 1)";
    $resInsert = mysqli_query($conexion, $insert);

    if ($resInsert) {
        header ("Location: ../colonias.php");
    } else {
        header ("Location: ../colonias.php");
    }
    
    mysqli_close($conexion);
?>
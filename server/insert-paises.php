<?php
    require("../conexion.php");

    error_reporting(0);
    $clave = $_POST["clave"];
    $nombre = $_POST["nombre"];

    $insert = "INSERT INTO _cat_pais VALUES (null, '$clave', '$nombre', 1)";
    $resInsert = mysqli_query($conexion, $insert);

    if ($resInsert) {
        header ("Location: ../paises.php");
    } else {
        header ("Location: ../paises.php");
    }
    
    mysqli_close($conexion);
?>
<?php
    require("../conexion.php");

    error_reporting(0);
    $nombre = $_POST["nombre"];

    $consultaNombre = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM corporativo WHERE nombre = '$nombre'"));

    if ($consultaNombre == 0) {
        $insert = "INSERT INTO corporativo VALUES (null, '$nombre', 1)";
        $resInsert = mysqli_query($conexion, $insert);

        if ($resInsert) {
            header ("Location: ../nuevoCorporativo.php");
        } else {
            header ("Location: ../nuevoCorporativo.php");
        }
    } else {
        echo '<script> alert("Ya existe un corporativo con el mismo nombre."); window.history.go(-1); </script>';
    }
    
    mysqli_close($conexion);
?>
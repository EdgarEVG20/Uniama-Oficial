<?php
    require("../conexion.php");

    error_reporting(0);
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $dependeDe = $_POST["dependeDe"];
    $jerarquia = $_POST["jerarquia"];

    $consultaNombre = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM catalogo_departamentos WHERE nombre = '$nombre' AND id_empresa = '$id'"));

    if ($consultaNombre == 0) {
        if (empty($dependeDe)) {
            $insert = "INSERT INTO catalogo_departamentos VALUES (null, '$id', '$nombre', 0, '$jerarquia', 1)";
            $resInsert = mysqli_query($conexion, $insert);
        } else {
            $insert = "INSERT INTO catalogo_departamentos VALUES (null, '$id', '$nombre', '$dependeDe', '$jerarquia', 1)";
            $resInsert = mysqli_query($conexion, $insert);
        }

        if ($resInsert) {
            header ("Location: ../adminDepartamentos.php");
        } else {
            header ("Location: ../adminDepartamentos.php");
        }
    } else {
        echo '<script> alert("Ya existe un departamento con el mismo nombre."); window.history.go(-1); </script>';
    }
    
    mysqli_close($conexion);
?>
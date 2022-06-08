<?php
    require("../conexion.php");

    error_reporting(0);
    $id = $_POST["id"];
    $departamento = $_POST["departamento"];
    $nombre = $_POST["nombre"];

    $consulta = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM catalogo_puestos WHERE nombre_puesto = '$nombre' AND id_empresa = '$id'"));

    if ($consulta == 0) {
        $insert = "INSERT INTO catalogo_puestos VALUES (null, '$id', '$departamento', '$nombre', 1)";
        $resInsert = mysqli_query($conexion, $insert);

        if ($resInsert) {
            header ("Location: ../adminPuestos.php");
        } else {
            header ("Location: ../adminPuestos.php");
        }
    } else {
        echo '<script> alert("Ya existe un puesto con el mismo nombre."); window.history.go(-1); </script>';
    }
    
    mysqli_close($conexion);
?>
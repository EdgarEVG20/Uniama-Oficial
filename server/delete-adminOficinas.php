<?php
    require("../conexion.php");

    $id = $_POST["id"];
    $idOficina = $_POST["idOficina"];

    $consultaOficinasUsuariosPerfiles = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM usuarios_perfiles WHERE cl_oficina = '$idOficina' AND id_empresa = '$id'"));

    if ($consultaOficinasUsuariosPerfiles == 0) {
        $delete = "DELETE FROM empresas_oficinas WHERE id_oficina = '$idOficina' AND id_empresa = '$id'";

        $resDelete = mysqli_query($conexion, $delete);

        if ($resDelete) {
            header ("Location: ../adminOficinas.php");
        } else {
            header ("Location: ../adminOficinas.php");
        }
    } else {
        echo '<script> alert("Esta oficina está actualmente en uso, no se puede eliminar."); window.history.go(-1); </script>';
    }
    mysqli_close($conexion);
?>
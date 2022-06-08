<?php
    require("../conexion.php");

    $id = $_POST["id"];
    $idPuesto = $_POST["idPuesto"];

    $consultaPuestosUsuariosPerfiles = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM usuarios_perfiles WHERE il_puesto = '$idPuesto' AND id_empresa = '$id'"));

    if ($consultaPuestosUsuariosPerfiles == 0) {
        $delete = "DELETE FROM catalogo_puestos WHERE id_puesto = '$idPuesto' AND id_empresa = '$id'";

        $resDelete = mysqli_query($conexion, $delete);

        if ($resDelete) {
            header ("Location: ../adminPuestos.php");
        } else {
            header ("Location: ../adminPuestos.php");
        }
    } else {
        echo '<script> alert("Este puesto está actualmente en uso, no se puede eliminar."); window.history.go(-1); </script>';
    }
    
    mysqli_close($conexion);
?>
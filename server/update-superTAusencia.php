<?php
    require("../conexion.php");

    error_reporting(0);
    $id = $_POST["id2"];
    $idVerUsuario = $_POST["idVerUsuario2"];
    $idAusencia = $_POST["idAusencia2"];
    $aprobacion = $_POST["aprobacion2"];

    $update = "UPDATE ausencias SET estatus = '" .$aprobacion. "' WHERE id_ausencia = '" .$idAusencia. "' AND id_usuario = '" .$idVerUsuario. "' AND id_empresa = '" .$id. "'";
    $resUpdate = mysqli_query($conexion, $update);

    if ($resUpdate) {
        header ("Location: ../superVerAusenciasT.php");
    } else {
        header ("Location: ../superVerAusenciasT.php");
    }
    
    mysqli_close($conexion);
?>
<?php
    require("../conexion.php");

    error_reporting(0);
    
    $id = $_POST["id"];
    $idU = $_POST["idU"];
    $fechaBaja = $_POST["fechaBaja"];
    $motivoSeparacion = $_POST["motivoSeparacion"];
    $recontratacion = $_POST["recontratacion"];

    $update = "UPDATE usuarios_perfiles SET baja_fecha_baja = '" .$fechaBaja. "', baja_motivo_separacion = '" .$motivoSeparacion. "', baja_recontratacion = '" .$recontratacion. "' WHERE id_empresa = '" .$id. "' AND id_usuario = '" .$idU. "'";
    $changeEstatus = mysqli_query($conexion, "UPDATE usuarios SET estatus = 2 WHERE id_empresa = '" .$id. "' AND id_usuario = '" .$idU. "'");

    $resUpdate = mysqli_query($conexion, $update);
    
    if ($resUpdate) {
        header ("Location: ../adminVerMiPerfilT.php?idU=".$idU);
    } else {
        header ("Location: ../adminVerMiPerfilT.php?idU=".$idU);
    }
    
    mysqli_close($conexion);
?>
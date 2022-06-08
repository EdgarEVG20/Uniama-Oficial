<?php
    require("../conexion.php");

    error_reporting(0);
    
    $id = $_POST["id"];
    $idU = $_POST["idU"];
    $contactoEmergencia = $_POST["contactoEmergencia"];
    $telefonoEmergencia = $_POST["telefonoEmergencia"];
    $tipoSangre = $_POST["tipoSangre"];

    $update = "UPDATE usuarios_perfiles SET ide_contacto_emergencia = '" .$contactoEmergencia. "', ide_telefono_emergencia = '" .$telefonoEmergencia. "', ide_tipo_sangre = '" .$tipoSangre. "' WHERE id_empresa = '" .$id. "' AND id_usuario = '" .$idU. "'";

    $resUpdate = mysqli_query($conexion, $update);
    
    if ($resUpdate) {
        header ("Location: ../adminVerMiPerfilT.php?idU=".$idU);
    } else {
        header ("Location: ../adminVerMiPerfilT.php?idU=".$idU);
    }
    
    mysqli_close($conexion);
?>
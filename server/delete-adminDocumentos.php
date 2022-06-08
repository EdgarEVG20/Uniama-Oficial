<?php
    require("../conexion.php");

    $id = $_POST["id"];
    $idDocumento = $_POST["idDocumento"];

    $consultaDocumentoArchivos = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM archivos_documentos WHERE id_documento = '$idDocumento' AND id_empresa = '$id'"));
    
    if ($consultaDocumentoArchivos == 0) {
        $delete = "DELETE FROM catalogo_documentos WHERE id_documento = '$idDocumento' AND id_empresa = '$id'";

        $resDelete = mysqli_query($conexion, $delete);

        if ($resDelete) {
            header ("Location: ../adminDocumentos.php");
        } else {
            header ("Location: ../adminDocumentos.php");
        }
    } else {
        echo '<script> alert("Este documento está actualmente en uso, no se puede eliminar."); window.history.go(-1); </script>';
    }

    mysqli_close($conexion);
?>
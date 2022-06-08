<?php
    require("../conexion.php");

    $id = $_POST['id'];
    $idU = $_POST['idU'];
    //$rfc = $_POST['rfc'];
    $idDocumento = $_POST["idDocumento"];
    $nombreDocumento = $_POST["nombreDocumento"];

    $delete = "DELETE FROM archivos_documentos WHERE id_documento = '$idDocumento' AND id_usuario = '$idU'";

    $resDelete = mysqli_query($conexion, $delete);

    if ($resDelete) {
        $path = "../Clientes/".$id."/empleados/".$idU."/".$nombreDocumento.".pdf"; //"_".$rfc.
        unlink($path);
        header ("Location: ../tDocumentos.php");
    } else {
        header ("Location: ../tDocumentos.php");
    }
    
    mysqli_close($conexion);
?>
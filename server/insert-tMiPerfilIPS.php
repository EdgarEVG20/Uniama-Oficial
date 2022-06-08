<?php
    require("../conexion.php");

    error_reporting(0);
    
    $id = $_POST["id"];
    $idU = $_POST["idU"];
    $numeroIdentificacion = $_POST["numeroIdentificacion"];
    $rfc = $_POST["rfc"];
    $curp = $_POST["curp"];
    $numeroIMSS = $_POST["numeroIMSS"];

    $update = "UPDATE usuarios_perfiles SET ips_no_identificacion = '" .$numeroIdentificacion. "', ips_rfc = '" .$rfc. "', ips_curp = '" .$curp. "', ips_no_imss = '" .$numeroIMSS. "' WHERE id_empresa = '" .$id. "' AND id_usuario = '" .$idU. "'";

    $resUpdate = mysqli_query($conexion, $update);
    
    if ($resUpdate) {
        header ("Location: ../tMiPerfil.php");
    } else {
        header ("Location: ../tMiPerfil.php");
    }
    
    mysqli_close($conexion);
?>
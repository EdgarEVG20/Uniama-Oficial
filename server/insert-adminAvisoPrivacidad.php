<?php
    require("../conexion.php");

    error_reporting(0);
    $id = $_POST["id"];
    $finesSecundarios = $_POST["finesSecundarios"];
    $transferenciaDatos = $_POST["transferenciaDatos"];
    $cambiosAviso = $_POST["cambiosAviso"];
    $avisoLeidoAceptado = $_POST["avisoLeidoAceptado"];
    $apellidoMaterno = $_POST["apellidoMaterno"];
    $apellidoPaterno = $_POST["apellidoPaterno"];
    $nombre = $_POST["nombre"];
    $telefono = $_POST["telefono"];
    $domicilio = $_POST["domicilio"];
    $correo = $_POST["correo"];

    if (isset($finesSecundarios)) {
        $confirmFinesSecundarios = 1;
    } else {
        $confirmFinesSecundarios = 2;
    }

    if (isset($transferenciaDatos)) {
        $confirmTransferenciaDatos = 1;
    } else {
        $confirmTransferenciaDatos = 2;
    }

    if (isset($cambiosAviso)) {
        $confirmCambiosAviso = 1;
    } else {
        $confirmCambiosAviso = 2;
    }

    if (isset($avisoLeidoAceptado)) {
        $confirmAvisoLeidoAceptado = 1;
    } else {
        $confirmAvisoLeidoAceptado = 2;
    }

    $consultaAvisoPrivacidad = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM avisos_privacidad WHERE id_empresa = '$id'"));

    if ($consultaAvisoPrivacidad == 0) {
        $sql = "INSERT INTO avisos_privacidad VALUES ('$id', '$confirmFinesSecundarios', '$confirmTransferenciaDatos','$confirmCambiosAviso', '$confirmAvisoLeidoAceptado', '$confirmAvisoLeidoAceptado', '$nombre', '$apellidoPaterno', '$apellidoMaterno', '$correo', '$telefono', '$domicilio')";
        $resSQL = mysqli_query($conexion, $sql);
    } else {
        $sql = "UPDATE avisos_privacidad SET fines_secundarios = '" .$confirmFinesSecundarios. "', transferencia_datos = '" .$confirmTransferenciaDatos. "', cambios_aviso = '" .$confirmCambiosAviso. "', aviso_leido = '" .$confirmAvisoLeidoAceptado. "', aviso_aceptado = '" .$confirmAvisoLeidoAceptado. "', nombre_representante = '" .$nombre. "', primer_apellido = '" .$apellidoPaterno. "', segundo_apellido = '" .$apellidoMaterno. "', correo = '" .$correo. "', telefono = '" .$telefono. "', domicilio = '" .$domicilio. "' WHERE id_empresa = '".$id."'";
        $resSQL = mysqli_query($conexion, $sql);

    }

    if ($resSQL) {
        header ("Location: ../adminAvisoPrivacidad.php");
    } else {
        header ("Location: ../adminAvisoPrivacidad.php");
    }
    
    mysqli_close($conexion);
?>
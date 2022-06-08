<?php
    require("../conexion.php");
    
    error_reporting(0);
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $calle = $_POST["calle"];
    $noExt = $_POST["noExt"];
    $noInt = $_POST["noInt"];
    $codigoPostal = $_POST["codigoPostal"];
    $claveColonia = $_POST["claveColonia"];
    $clavePais = $_POST["clavePais"];
    $claveEstado = $_POST["claveEstado"];
    $claveMunicipio = $_POST["claveMunicipio"];
    $correo = $_POST["correo"];
    $telefono = $_POST["telefono"];
    
    // if (empty($noInt)) {
    //     $insert = "INSERT INTO empresas_oficinas VALUES (null, '$id', '$nombre', '$calle', '$noExt', null, '$codigoPostal', '$claveColonia', '$clavePais', '$claveEstado', '$claveMunicipio', '$correo', '$telefono', 1)";
    // } else {
        $insert = "INSERT INTO empresas_oficinas VALUES (null, '$id', '$nombre', '$calle', '$noExt', '$noInt', '$codigoPostal', '$claveColonia', '$clavePais', '$claveEstado', '$claveMunicipio', '$correo', '$telefono', 1)";        
    // }
    
    $resInsert = mysqli_query($conexion, $insert);

    if ($resInsert) {
        header ("Location: ../adminOficinas.php");
    } else {
        header ("Location: ../adminOficinas.php");
    }
    
    mysqli_close($conexion);
?>
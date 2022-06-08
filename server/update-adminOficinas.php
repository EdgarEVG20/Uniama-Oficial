<?php
    require("../conexion.php");

    error_reporting(0);
    $id = $_POST["id"];
    $nombreOficina = $_POST["nombreOficina2"];
    $calle = $_POST["calle2"];
    $noExt = $_POST["noExt2"];
    $noInt = $_POST["noInt2"];
    $codigoPostal = $_POST["codigoPostal2"];
    $claveColonia = $_POST["claveColonia2"];
    $claveMunicipio = $_POST["claveMunicipio2"];
    $claveEstado = $_POST["claveEstado2"];
    $clavePais = $_POST["clavePais2"];
    $correo = $_POST["correo2"];
    $telefono = $_POST["telefono2"];

    $update = "UPDATE empresas_oficinas SET nombre_oficina = '" .$nombreOficina. "', calle = '" .$calle. "', noExt = '" .$noExt. "', noInt = '" .$noInt. "', codigo_postal = '" .$codigoPostal. "', clave_colonia = '" .$claveColonia. "', clave_pais = '" .$clavePais. "', clave_estado = '" .$claveEstado. "', clave_municipio = '" .$claveMunicipio. "', correo = '" .$correo. "', telefono = '" .$telefono. "' WHERE id_oficina = '" .$id. "'";
    $resUpdate = mysqli_query($conexion, $update);

    if ($resUpdate) {
        header ("Location: ../adminOficinas.php");
    } else {
        header ("Location: ../adminOficinas.php");
    }
    
    mysqli_close($conexion);
?>
<?php
    require("../conexion.php");

    //error_reporting(0);
    $rfc = $_POST["rfc"];
    $nombreSocial = $_POST["nombreSocial"];
    $nombreComercial = $_POST["nombreComercial"];
    $calle = $_POST["calle"];
    $noExt = $_POST["noExt"];
    $noInt = $_POST["noInt"];
    $claveColonia = $_POST["claveColonia"];
    $codigoPostal = $_POST["codigoPostal"];
    $claveMunicipio = $_POST["claveMunicipio"];
    $claveEstado = $_POST["claveEstado"];
    $clavePais = $_POST["clavePais"];
    $claveRegimen = $_POST["claveRegimen"];
    $suscripcion = $_POST["suscripcion"];
    $fecha = $_POST["fecha"];
    $precio = $_POST["precio"];

    $consultaRFC = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM empresas WHERE rfc = '$rfc'"));

    if ($consultaRFC == 0) {
        $insert = "INSERT INTO empresas VALUES (null, '$rfc', '$nombreSocial', '$nombreComercial', '$calle', '$noExt', '$noInt', '$claveColonia', '$codigoPostal', '$claveMunicipio', '$claveEstado', '$clavePais', null, null, null, '$claveRegimen', '$suscripcion', '$precio', '$fecha', 2, 1)";
        
        $resInsert = mysqli_query($conexion, $insert);

        if ($resInsert) {
            header ("Location: ../nuevoCliente.php");
        } else {
            echo "<script> window.history.go(-1); </script>";
        }
    } else {
        echo '<script> alert("Ya existe una empresa registrada con el mismo RFC."); window.history.go(-1); </script>';
    }
    
    mysqli_close($conexion);
?>
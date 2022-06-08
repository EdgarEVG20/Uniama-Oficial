<?php
    require("../conexion.php");

    error_reporting(0);
    $claveM = $_POST["claveMunicipio"];
    $claveE = $_POST["claveEstado"];
    $nombre = $_POST["nombre"];

    $insert = "INSERT INTO _cat_municipios VALUES (null, '$claveM', '$claveE','$nombre', 1)";
    $resInsert = mysqli_query($conexion, $insert);

    if ($resInsert) {
        header ("Location: ../municipios.php");
    } else {
        header ("Location: ../municipios.php");
    }
    
    mysqli_close($conexion);
?>
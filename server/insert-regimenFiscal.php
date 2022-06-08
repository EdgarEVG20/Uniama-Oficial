<?php
    require("../conexion.php");

    error_reporting(0);
    $clave = $_POST["clave"];
    $desc = $_POST["descripcion"];
    $persona = $_POST["persona"];

    $insert = "INSERT INTO _cat_regimen_fiscal VALUES (null, '$clave', '$desc','$persona', 1)";
    $resInsert = mysqli_query($conexion, $insert);

    if ($resInsert) {
        header ("Location: ../regimenFiscal.php");
    } else {
        header ("Location: ../regimenFiscal.php");
    }
    
    mysqli_close($conexion);
?>
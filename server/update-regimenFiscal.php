<?php
    require("../conexion.php");

    error_reporting(0);
    $id = $_POST["id"];
    $clave = $_POST["clave"];
    $descripcion = $_POST["descripcion"];
    $persona = $_POST["persona"];

    $update = "UPDATE _cat_regimen_fiscal SET clave_regimen = '" .$clave. "', descripcion = '" .$descripcion. "', persona = '" .$persona. "' WHERE id_regimen = '" .$id. "'";
    $resUpdate = mysqli_query($conexion, $update);

    if ($resUpdate) {
        header ("Location: ../regimenFiscal.php");
    } else {
        header ("Location: ../regimenFiscal.php");
    }
    
    mysqli_close($conexion);
?>
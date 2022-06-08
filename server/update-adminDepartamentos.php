<?php
    require("../conexion.php");

    error_reporting(0);
    $id = $_POST["id"];
    $nombre = $_POST["nombre2"];
    $dependeDe = $_POST["dependeDe2"];
    $jerarquia = $_POST["jerarquia2"];
    
    if (empty($dependeDe)) {
        $update = "UPDATE catalogo_departamentos SET nombre = '" .$nombre. "', jerarquia = '" .$jerarquia. "' WHERE id_departamento = '" .$id. "'";
        $resUpdate = mysqli_query($conexion, $update);
    } else {
        $update = "UPDATE catalogo_departamentos SET nombre = '" .$nombre. "', depende_de = '" .$dependeDe. "', jerarquia = '" .$jerarquia. "' WHERE id_departamento = '" .$id. "'";
        $resUpdate = mysqli_query($conexion, $update);
    }
    

    if ($resUpdate) {
        header ("Location: ../adminDepartamentos.php");
    } else {
        header ("Location: ../adminDepartamentos.php");
    }
    
    mysqli_close($conexion);
?>
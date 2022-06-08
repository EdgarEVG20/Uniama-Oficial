<?php
    require("../conexion.php");

    error_reporting(0);
    $id = $_POST["id2"];
    $idEmpleado = $_POST["idEmpleado2"];
    $tipoUsuario = $_POST["tipoUsuario2"];

    $update = "UPDATE usuarios SET nivel = '" .$tipoUsuario. "' WHERE id_usuario = '" .$idEmpleado. "' AND id_empresa = '" .$id. "'";
    $resUpdate = mysqli_query($conexion, $update);

    if ($resUpdate) {
        header ("Location: ../adminEmpleados.php");
    } else {
        header ("Location: ../adminEmpleados.php");
    }
    
    mysqli_close($conexion);
?>
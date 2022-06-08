<?php
    require("../conexion.php");

    error_reporting(0);
    $id = $_POST["id"];
    $suscripcion = $_POST["suscripcion"];
    $precio = $_POST["precio"];
    $fecha = $_POST["fecha"];


    if (!empty($_POST["id"]) && !empty($_POST["suscripcion"]) && !empty($_POST["fecha"]) && !empty($_POST["precio"])) {
        $update = "UPDATE empresas SET suscripcion = '" .$suscripcion. "', precio = '" .$precio. "', fecha = '" .$fecha. "' WHERE id_empresa = '" .$id. "'";
        $resUpdate = mysqli_query($conexion, $update);

        if ($resUpdate) {
            header ("Location: ../mostrarClientes.php");
        } else {
            header ("Location: ../mostrarClientes.php");
        }
    } else {
        echo '<script> alert("Por favor, llena todos los campos."); window.history.go(-1); </script>';
    }  
    
    mysqli_close($conexion);
?>
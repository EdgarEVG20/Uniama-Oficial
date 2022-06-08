<?php
    require("../conexion.php");

    $id = $_POST["id"];

    $delete = "DELETE FROM usuarios WHERE id_usuario = '$id'";

    $resDelete = mysqli_query($conexion, $delete);

    if ($resDelete) {
        header ("Location: ../usuarios.php");
    } else {
        header ("Location: ../usuarios.php");
    }
    
    mysqli_close($conexion);
?>
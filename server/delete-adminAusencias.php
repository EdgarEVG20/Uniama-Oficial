<?php
    require("../conexion.php");

    $id = $_POST["id"];

    $delete = "DELETE FROM catalogo_ausencias WHERE id_ausencia = '$id'";

    $resDelete = mysqli_query($conexion, $delete);

    if ($resDelete) {
        header ("Location: ../adminAusencias.php");
    } else {
        header ("Location: ../adminAusencias.php");
    }
    
    mysqli_close($conexion);
?>
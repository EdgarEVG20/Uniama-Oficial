<?php
    require("../conexion.php");

    error_reporting(0);
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $color = $_POST["color"];
    $descuentaTiempo = $_POST["descuentaTiempo"];
    $aprobacion = $_POST["aprobacion"];
    $laborable = $_POST["laborable"];
    $justificante = $_POST["justificante"];

    $insert = "INSERT INTO catalogo_ausencias VALUES (null, '$id', '$nombre', '$color', '$descuentaTiempo', '$aprobacion', '$laborable', '$justificante', 1)";
    $resInsert = mysqli_query($conexion, $insert);

    if ($resInsert) {
        header ("Location: ../adminAusencias.php");
    } else {
        header ("Location: ../adminAusencias.php");
    }
    
    mysqli_close($conexion);
?>
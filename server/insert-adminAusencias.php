<?php
    require("../conexion.php");

    error_reporting(0);
    
    if (!empty($_POST["nombre1"]) && empty($_POST["nombre2"])) {
        if (!empty($_POST["id"]) && !empty($_POST["nombre1"]) && !empty($_POST["color"]) && !empty($_POST["descuentaTiempo"]) && !empty($_POST["aprobacion"]) && !empty($_POST["laborable"]) && !empty($_POST["justificante"])) {
            $id = $_POST["id"];
            $nombre = $_POST["nombre1"];
            $color = $_POST["color"];
            $descuentaTiempo = $_POST["descuentaTiempo"];
            $aprobacion = $_POST["aprobacion"];
            $laborable = $_POST["laborable"];
            $justificante = $_POST["justificante"];

            $consultaNombre = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM catalogo_ausencias WHERE nombre = '$nombre' AND id_empresa = '$id'"));

            if ($consultaNombre == 0) {
                $insert = "INSERT INTO catalogo_ausencias VALUES (null, '$id', '$nombre', '$color', '$descuentaTiempo', '$aprobacion', '$laborable', '$justificante', 1)";
                $resInsert = mysqli_query($conexion, $insert);

                if ($resInsert) {
                    header ("Location: ../adminAusencias.php");
                } else {
                    header ("Location: ../adminAusencias.php");
                }
            } else {
                echo '<script> alert("Ya existe una ausencia con el mismo nombre."); window.history.go(-1); </script>';
            }
        } else {
        echo '<script> alert("Por favor, selecciona todos los datos obligatorios."); window.history.go(-1); </script>';
        }
    } elseif (!empty($_POST["nombre2"]) && empty($_POST["nombre1"])) {
        if (!empty($_POST["id"]) && !empty($_POST["nombre2"]) && !empty($_POST["color"]) && !empty($_POST["descuentaTiempo"]) && !empty($_POST["aprobacion"]) && !empty($_POST["laborable"]) && !empty($_POST["justificante"])) {
            $id =  $_POST["id"];
            $nombre =  $_POST["nombre2"];
            $color =  $_POST["color"];
            $descuentaTiempo =  $_POST["descuentaTiempo"];
            $aprobacion =  $_POST["aprobacion"];
            $laborable =  $_POST["laborable"];
            $justificante =  $_POST["justificante"];

            $consultaNombre = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM catalogo_ausencias WHERE nombre = '$nombre' AND id_empresa = '$id'"));

            if ($consultaNombre == 0) {
                $insert = "INSERT INTO catalogo_ausencias VALUES (null, '$id', '$nombre', '$color', '$descuentaTiempo', '$aprobacion', '$laborable', '$justificante', 1)";
                $resInsert = mysqli_query($conexion, $insert);

                if ($resInsert) {
                    header ("Location: ../adminAusencias.php");
                } else {
                    header ("Location: ../adminAusencias.php");
                }
            } else {
                echo '<script> alert("Ya existe una ausencia con el mismo nombre."); window.history.go(-1); </script>';
            }
        } else {
        echo '<script> alert("Por favor, selecciona todos los datos obligatorios."); window.history.go(-1); </script>';
        }
    } elseif (!empty($_POST["nombre1"]) && !empty($_POST["nombre2"])) {
        echo '<script> alert("Por favor, solo selecciona una asuencia o escribe el nombre de una, inténtalo de nuevo."); window.history.go(-1); </script>';
    } else {
        echo '<script> alert("Ha ocurrido un error, inténtalo de nuevo."); window.history.go(-1); </script>';
    }
    
    mysqli_close($conexion);
?>
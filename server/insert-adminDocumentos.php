<?php
    require("../conexion.php");

    error_reporting(0);

    if (!empty($_POST["nombre1"]) && empty($_POST["nombre2"])) {
        if (!empty($_POST["id"]) && !empty($_POST["nombre1"]) && !empty($_POST["vigencia"]) && !empty($_POST["obligatorio"]) && !empty($_POST["visible"])) {
            $id = $_POST["id"];
            $nombre = $_POST["nombre1"];
            $vigencia = $_POST["vigencia"];
            $obligatorio = $_POST["obligatorio"];
            $visible = $_POST["visible"];
            $mesesVigencia = $_POST["mesesVigencia"];
            
            $consultaNombre = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM catalogo_documentos WHERE nombre = '$nombre' AND id_empresa = '$id'"));

            if ($consultaNombre == 0) {
                $insert = "INSERT INTO catalogo_documentos VALUES (null, '$id', '$nombre', '$vigencia', '$mesesVigencia', '$obligatorio', '$visible', 1)";
                $resInsert = mysqli_query($conexion, $insert);

                if ($resInsert) {
                    header ("Location: ../adminDocumentos.php");
                } else {
                    header ("Location: ../adminDocumentos.php");
                }
            } else {
                echo '<script> alert("Ya existe un documento con el mismo nombre."); window.history.go(-1); </script>';
            }
        } else {
            echo '<script> alert("Por favor, selecciona todos los datos obligatorios."); window.history.go(-1); </script>';
        }
    } elseif (!empty($_POST["nombre2"]) && empty($_POST["nombre1"])) {
        if (!empty($_POST["id"]) && !empty($_POST["nombre2"]) && !empty($_POST["vigencia"]) && !empty($_POST["obligatorio"]) && !empty($_POST["visible"])) {
            $id =  $_POST["id"];
            $nombre =  $_POST["nombre2"];
            $vigencia =  $_POST["vigencia"];
            $obligatorio =  $_POST["obligatorio"];
            $visible =  $_POST["visible"];
            $mesesVigencia =  $_POST["mesesVigencia"];

            $consultaNombre = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM catalogo_documentos WHERE nombre = '$nombre' AND id_empresa = '$id'"));

            if ($consultaNombre == 0) {
                $insert = "INSERT INTO catalogo_documentos VALUES (null, '$id', '$nombre', '$vigencia', '$mesesVigencia', '$obligatorio', '$visible', 1)";
                $resInsert = mysqli_query($conexion, $insert);

                if ($resInsert) {
                    header ("Location: ../adminDocumentos.php");
                } else {
                    header ("Location: ../adminDocumentos.php");
                }
            } else {
                echo '<script> alert("Ya existe un documento con el mismo nombre."); window.history.go(-1); </script>';
            }
        } else {
            echo '<script> alert("Por favor, selecciona todos los datos obligatorios."); window.history.go(-1); </script>';
        }
    } elseif (!empty($_POST["nombre1"]) && !empty($_POST["nombre2"])) {
        echo '<script> alert("Por favor, solo selecciona un documento o escribe el nombre de uno, inténtalo de nuevo."); window.history.go(-1); </script>';
    } else {
        echo '<script> alert("Ha ocurrido un error, inténtalo de nuevo."); window.history.go(-1); </script>';
    }
    
    mysqli_close($conexion);
?>
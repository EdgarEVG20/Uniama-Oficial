<?php
    require("../conexion.php");

    error_reporting(0);
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $tipoHorario = $_POST["tipoHorario"];
    $lunesEntrada = $_POST["lunesEntrada"];
    $lunesSalida = $_POST["lunesSalida"];
    $martesEntrada = $_POST["martesEntrada"];
    $martesSalida = $_POST["martesSalida"];
    $miercolesEntrada = $_POST["miercolesEntrada"];
    $miercolesSalida = $_POST["miercolesSalida"];
    $juevesEntrada = $_POST["juevesEntrada"];
    $juevesSalida = $_POST["juevesSalida"];
    $viernesEntrada = $_POST["viernesEntrada"];
    $viernesSalida = $_POST["viernesSalida"];
    $sabadoEntrada = $_POST["sabadoEntrada"];
    $sabadoSalida = $_POST["sabadoSalida"];
    $domingoEntrada = $_POST["domingoEntrada"];
    $domingoSalida = $_POST["domingoSalida"];

    $consultaNoHorarioMax = "SELECT COALESCE(MAX(no_horario) + 1,1) FROM horarios_laborales WHERE id_empresa = $id";
    $resultadoMax = mysqli_query($conexion, $consultaNoHorarioMax);
    $resMax = mysqli_fetch_assoc($resultadoMax);
    $noHorario = $resMax['COALESCE(MAX(no_horario) + 1,1)'];

    $consultaNombre = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM horarios_laborales WHERE nombre_horario = '$nombre' AND id_empresa = '$id'"));

    if ($consultaNombre == 0) {
        if (empty($lunesEntrada) && empty($lunesSalida) || empty($martesEntrada) && empty($martesSalida) || empty($miercolesEntrada) && empty($miercolesSalida) | empty($juevesEntrada) && empty($juevesSalida) || empty($viernesEntrada) && empty($viernesSalida) || empty($sabadoEntrada) && empty($sabadoSalida)|| empty($domingoEntrada) && empty($domingoSalida)) {
            if (!empty($lunesEntrada) && !empty($lunesSalida) && !empty($martesEntrada) && !empty($martesSalida) && !empty($miercolesEntrada) && !empty($miercolesSalida) | !empty($juevesEntrada) && !empty($juevesSalida) && !empty($viernesEntrada) && !empty($viernesSalida) && !empty($sabadoEntrada) && !empty($sabadoSalida)&& !empty($domingoEntrada) && !empty($domingoSalida)) {
                $insert = "INSERT INTO horarios_laborales VALUES ('$noHorario', '$id', '$nombre', '$tipoHorario','$lunesEntrada', '$lunesSalida', '$martesEntrada', '$martesSalida', '$miercolesEntrada', '$miercolesSalida', '$juevesEntrada', '$juevesSalida', '$viernesEntrada', '$viernesSalida', '$sabadoEntrada', '$sabadoSalida', '$domingoEntrada', '$domingoSalida', 1)";
                $resInsert = mysqli_query($conexion, $insert);

                if ($resInsert) {
                    header ("Location: ../adminHorariosLaborales.php");
                } else {
                    header ("Location: ../adminHorariosLaborales.php");
                }
            } else {
                echo '<script> alert("Por favor ingresa las horas laborales, dejando un día de descanso."); window.history.go(-1); </script>';
            }
        } else {
            echo '<script> alert("Por indicaciones de la Ley Federal del Trabajo (LFT) debe de haber un día de descanso laboral."); window.history.go(-1); </script>';
        }
    } else {
        echo '<script> alert("Ya existe un horario laboral con el mismo nombre."); window.history.go(-1); </script>';
    }
    
    mysqli_close($conexion);
?>
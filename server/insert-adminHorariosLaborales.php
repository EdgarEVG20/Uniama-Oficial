<?php
    require("../conexion.php");

    error_reporting(0);
    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $tipoHorario = $_POST["tipoHorario"];

    $consultaNoHorarioMax = "SELECT COALESCE(MAX(no_horario) + 1,1) FROM horarios_laborales WHERE id_empresa = $id";
    $resultadoMax = mysqli_query($conexion, $consultaNoHorarioMax);
    $resMax = mysqli_fetch_assoc($resultadoMax);
    $noHorario = $resMax['COALESCE(MAX(no_horario) + 1,1)'];

    $consultaNombre = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM horarios_laborales WHERE nombre_horario = '$nombre' AND id_empresa = '$id'"));

    if ($consultaNombre == 0) {
        $insert = "INSERT INTO horarios_laborales VALUES ('$noHorario', '$id', '$nombre', '$tipoHorario', 1)";
        $resInsert = mysqli_query($conexion, $insert);

        if ($resInsert) {
            header ("Location: ../adminHorariosLaborales.php");
        } else {
            header ("Location: ../adminHorariosLaborales.php");
        }
    } else {
        echo '<script> alert("Ya existe un horario laboral con el mismo nombre."); window.history.go(-1); </script>';
    }
    
    mysqli_close($conexion);
?>
<?php
    require("../conexion.php");

    error_reporting(0);
    $id = $_POST["id"];
    $noHorario = $_POST["idHorario"];

    // INSERT
    // Detalles (Corrido y Flexible)
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

    // Recesos (Flexible)
    $lunesSalidaReceso = $_POST["lunesSalidaReceso"];
    $lunesEntradaReceso = $_POST["lunesEntradaReceso"];
    $martesSalidaReceso = $_POST["martesSalidaReceso"];
    $martesEntradaReceso = $_POST["martesEntradaReceso"];
    $miercolesSalidaReceso = $_POST["miercolesSalidaReceso"];
    $miercolesEntradaReceso = $_POST["miercolesEntradaReceso"];
    $juevesSalidaReceso = $_POST["juevesSalidaReceso"];
    $juevesEntradaReceso = $_POST["juevesEntradaReceso"];
    $viernesSalidaReceso = $_POST["viernesSalidaReceso"];
    $viernesEntradaReceso = $_POST["viernesEntradaReceso"];
    $sabadoSalidaReceso = $_POST["sabadoSalidaReceso"];
    $sabadoEntradaReceso = $_POST["sabadoEntradaReceso"];
    $domingoSalidaReceso = $_POST["domingoSalidaReceso"];
    $domingoEntradaReceso = $_POST["domingoEntradaReceso"];

    // UPDATE
    // Detalles (Corrido)
    $uLunesEntrada = $_POST["e2"];
    $uLunesSalida = $_POST["s2"];
    $uMartesEntrada = $_POST["e3"];
    $uMartesSalida = $_POST["s3"];
    $uMiercolesEntrada = $_POST["e4"];
    $uMiercolesSalida = $_POST["s4"];
    $uJuevesEntrada = $_POST["e5"];
    $uJuevesSalida = $_POST["s5"];
    $uViernesEntrada = $_POST["e6"];
    $uViernesSalida = $_POST["s6"];
    $uSabadoEntrada = $_POST["e7"];
    $uSabadoSalida = $_POST["s7"];
    $uDomingoEntrada = $_POST["e1"];
    $uDomingoSalida = $_POST["s1"];

    // Detalles (Flexible)
    $rLunesEntrada = $_POST["e_d2"];
    $rLunesSalida = $_POST["s_d2"];
    $rMartesEntrada = $_POST["e_d3"];
    $rMartesSalida = $_POST["s_d3"];
    $rMiercolesEntrada = $_POST["e_d4"];
    $rMiercolesSalida = $_POST["s_d4"];
    $rJuevesEntrada = $_POST["e_d5"];
    $rJuevesSalida = $_POST["s_d5"];
    $rViernesEntrada = $_POST["e_d6"];
    $rViernesSalida = $_POST["s_d6"];
    $rSabadoEntrada = $_POST["e_d7"];
    $rSabadoSalida = $_POST["s_d7"];
    $rDomingoEntrada = $_POST["e_d1"];
    $rDomingoSalida = $_POST["s_d1"];

    // Receso (Flexible)
    $rLunesSalidaReceso = $_POST["s_r2"];
    $rLunesEntradaReceso = $_POST["e_r2"];
    $rMartesSalidaReceso = $_POST["s_r3"];
    $rMartesEntradaReceso = $_POST["e_r3"];
    $rMiercolesSalidaReceso = $_POST["s_r4"];
    $rMiercolesEntradaReceso = $_POST["e_r4"];
    $rJuevesSalidaReceso = $_POST["s_r5"];
    $rJuevesEntradaReceso = $_POST["e_r5"];
    $rViernesSalidaReceso = $_POST["s_r6"];
    $rViernesEntradaReceso = $_POST["e_r6"];
    $rSabadoSalidaReceso = $_POST["s_r7"];
    $rSabadoEntradaReceso = $_POST["e_r7"];
    $rDomingoSalidaReceso = $_POST["s_r1"];
    $rDomingoEntradaReceso = $_POST["e_r1"];

    $consultaRegistrosDetalles = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM horarios_laborales_detalles WHERE no_horario = '$noHorario' AND id_empresa = '$id'"));
    $consultaRegistrosRecesos = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM horarios_laborales_recesos WHERE no_horario = '$noHorario' AND id_empresa = '$id'"));
    
    // Si Entrada y Salida de un dia están vacios, pasa a la siguiente validación (INSERT)
    if (empty($lunesEntrada) && empty($lunesSalida) || empty($martesEntrada) && empty($martesSalida) || empty($miercolesEntrada) && empty($miercolesSalida) || empty($juevesEntrada) && empty($juevesSalida) || empty($viernesEntrada) && empty($viernesSalida) || empty($sabadoEntrada) && empty($sabadoSalida) || empty($domingoEntrada) && empty($domingoSalida)) {
        
        // Si están vacios todos los horarios de Receso, significa que es de Horario Corrido
        if (empty($lunesSalidaReceso) && empty($lunesEntradaReceso) && empty($martesSalidaReceso) && empty($martesEntradaReceso) && empty($miercolesSalidaReceso) && empty($miercolesEntradaReceso) && empty($juevesSalidaReceso) && empty($juevesEntradaReceso) && empty($viernesSalidaReceso) && empty($viernesEntradaReceso) && empty($sabadoSalidaReceso) && empty($sabadoEntradaReceso) && empty($domingoSalidaReceso) && empty($domingoEntradaReceso) && empty($rLunesSalidaReceso) && empty($rLunesEntradaReceso) && empty($rMartesSalidaReceso) && empty($rMartesEntradaReceso) && empty($rMiercolesSalidaReceso) && empty($rMiercolesEntradaReceso) && empty($rJuevesSalidaReceso) && empty($rJuevesEntradaReceso) && empty($rViernesSalidaReceso) && empty($rViernesEntradaReceso) && empty($rSabadoSalidaReceso) && empty($rSabadoEntradaReceso) && empty($rDomingoSalidaReceso) && empty($rDomingoEntradaReceso)) {

            // Si no hay ningun registro, inserta datos
            if ($consultaRegistrosDetalles == 0) {
                $insertDomingo = mysqli_query($conexion, "INSERT INTO horarios_laborales_detalles VALUES ('$noHorario', '$id', 1,'$domingoEntrada', '$domingoSalida')");
                $insertLunes = mysqli_query($conexion, "INSERT INTO horarios_laborales_detalles VALUES ('$noHorario', '$id', 2,'$lunesEntrada', '$lunesSalida')");
                $insertMartes = mysqli_query($conexion, "INSERT INTO horarios_laborales_detalles VALUES ('$noHorario', '$id', 3,'$martesEntrada', '$martesSalida')");
                $insertMiercoles = mysqli_query($conexion, "INSERT INTO horarios_laborales_detalles VALUES ('$noHorario', '$id', 4,'$miercolesEntrada', '$miercolesSalida')");
                $insertJueves = mysqli_query($conexion, "INSERT INTO horarios_laborales_detalles VALUES ('$noHorario', '$id', 5,'$juevesEntrada', '$juevesSalida')");
                $insertViernes = mysqli_query($conexion, "INSERT INTO horarios_laborales_detalles VALUES ('$noHorario', '$id', 6,'$viernesEntrada', '$viernesSalida')");
                $insertSabado = mysqli_query($conexion, "INSERT INTO horarios_laborales_detalles VALUES ('$noHorario', '$id', 7,'$sabadoEntrada', '$sabadoSalida')");

                if ($insertDomingo && $insertLunes && $insertMartes && $insertMiercoles && $insertJueves && $insertViernes && $insertSabado) {
                    header ("Location: ../adminHorariosLaborales.php");
                } else {
                    header ("Location: ../adminHorariosLaborales.php");
                }
            // Caso contrario, si ya hay datos, los actualiza
            } else {
                // Si Entrada y Salida de un dia están vacios, pasa a la siguiente validación (UPDATE)
                if (empty($uLunesEntrada) && empty($uLunesSalida) || empty($uMartesEntrada) && empty($uMartesSalida) || empty($uMiercolesEntrada) && empty($uMiercolesSalida) || empty($uJuevesEntrada) && empty($uJuevesSalida) || empty($uViernesEntrada) && empty($uViernesSalida) || empty($uSabadoEntrada) && empty($uSabadoSalida) || empty($uDomingoEntrada) && empty($uDomingoSalida)) {
                    $updateDomingo = mysqli_query($conexion, "UPDATE horarios_laborales_detalles SET hora_entrada = '" .$uDomingoEntrada. "', hora_salida = '" .$uDomingoSalida. "' WHERE no_horario = '" .$noHorario. "' AND id_empresa = '" .$id. "' AND no_dia = 1");
                    $updateLunes = mysqli_query($conexion, "UPDATE horarios_laborales_detalles SET hora_entrada = '" .$uLunesEntrada. "', hora_salida = '" .$uLunesSalida. "' WHERE no_horario = '" .$noHorario. "' AND id_empresa = '" .$id. "' AND no_dia = 2");
                    $updateMartes = mysqli_query($conexion, "UPDATE horarios_laborales_detalles SET hora_entrada = '" .$uMartesEntrada. "', hora_salida = '" .$uMartesSalida. "' WHERE no_horario = '" .$noHorario. "' AND id_empresa = '" .$id. "' AND no_dia = 3");
                    $updateMiercoles = mysqli_query($conexion, "UPDATE horarios_laborales_detalles SET hora_entrada = '" .$uMiercolesEntrada. "', hora_salida = '" .$uMiercolesSalida. "' WHERE no_horario = '" .$noHorario. "' AND id_empresa = '" .$id. "' AND no_dia = 4");
                    $updateJueves = mysqli_query($conexion, "UPDATE horarios_laborales_detalles SET hora_entrada = '" .$uJuevesEntrada. "', hora_salida = '" .$uJuevesSalida. "' WHERE no_horario = '" .$noHorario. "' AND id_empresa = '" .$id. "' AND no_dia = 5");
                    $updateViernes = mysqli_query($conexion, "UPDATE horarios_laborales_detalles SET hora_entrada = '" .$uViernesEntrada. "', hora_salida = '" .$uViernesSalida. "' WHERE no_horario = '" .$noHorario. "' AND id_empresa = '" .$id. "' AND no_dia = 6");
                    $updateSabado = mysqli_query($conexion, "UPDATE horarios_laborales_detalles SET hora_entrada = '" .$uSabadoEntrada. "', hora_salida = '" .$uSabadoSalida. "' WHERE no_horario = '" .$noHorario. "' AND id_empresa = '" .$id. "' AND no_dia = 7");

                    if ($updateDomingo && $updateLunes && $updateMartes && $updateMiercoles && $updateJueves && $updateViernes && $updateSabado) {
                        header ("Location: ../adminHorariosLaborales.php");
                    } else {
                        header ("Location: ../adminHorariosLaborales.php");
                    }
                // Caso contrario, manda una alerta
                } else {
                    echo '<script> alert("Por indicaciones de la Ley Federal del Trabajo (LFT) debe de haber un día de descanso laboral."); window.history.go(-1); </script>';
                }
            }
        // Caso contrario, si detecta algun valor en los horarios de Receso, significa que es de Horario Flexible
        } else {
            // Si no hay ningun registro, inserta datos
            if ($consultaRegistrosDetalles == 0 && $consultaRegistrosRecesos == 0) {
                $insertDomingoD = mysqli_query($conexion, "INSERT INTO horarios_laborales_detalles VALUES ('$noHorario', '$id', 1,'$domingoEntrada', '$domingoSalida')");
                $insertLunesD = mysqli_query($conexion, "INSERT INTO horarios_laborales_detalles VALUES ('$noHorario', '$id', 2,'$lunesEntrada', '$lunesSalida')");
                $insertMartesD = mysqli_query($conexion, "INSERT INTO horarios_laborales_detalles VALUES ('$noHorario', '$id', 3,'$martesEntrada', '$martesSalida')");
                $insertMiercolesD = mysqli_query($conexion, "INSERT INTO horarios_laborales_detalles VALUES ('$noHorario', '$id', 4,'$miercolesEntrada', '$miercolesSalida')");
                $insertJuevesD = mysqli_query($conexion, "INSERT INTO horarios_laborales_detalles VALUES ('$noHorario', '$id', 5,'$juevesEntrada', '$juevesSalida')");
                $insertViernesD = mysqli_query($conexion, "INSERT INTO horarios_laborales_detalles VALUES ('$noHorario', '$id', 6,'$viernesEntrada', '$viernesSalida')");
                $insertSabadoD = mysqli_query($conexion, "INSERT INTO horarios_laborales_detalles VALUES ('$noHorario', '$id', 7,'$sabadoEntrada', '$sabadoSalida')");

                $insertDomingoR = mysqli_query($conexion, "INSERT INTO horarios_laborales_recesos VALUES ('$noHorario', '$id', 1,'$domingoSalidaReceso', '$domingoEntradaReceso')");
                $insertLunesR = mysqli_query($conexion, "INSERT INTO horarios_laborales_recesos VALUES ('$noHorario', '$id', 2,'$lunesSalidaReceso', '$lunesEntradaReceso')");
                $insertMartesR = mysqli_query($conexion, "INSERT INTO horarios_laborales_recesos VALUES ('$noHorario', '$id', 3,'$martesSalidaReceso', '$martesEntradaReceso')");
                $insertMiercolesR = mysqli_query($conexion, "INSERT INTO horarios_laborales_recesos VALUES ('$noHorario', '$id', 4,'$miercolesSalidaReceso', '$miercolesEntradaReceso')");
                $insertJuevesR = mysqli_query($conexion, "INSERT INTO horarios_laborales_recesos VALUES ('$noHorario', '$id', 5,'$juevesSalidaReceso', '$juevesEntradaReceso')");
                $insertViernesR = mysqli_query($conexion, "INSERT INTO horarios_laborales_recesos VALUES ('$noHorario', '$id', 6,'$viernesSalidaReceso', '$viernesEntradaReceso')");
                $insertSabadoR = mysqli_query($conexion, "INSERT INTO horarios_laborales_recesos VALUES ('$noHorario', '$id', 7,'$sabadoSalidaReceso', '$sabadoEntradaReceso')");

                if ($insertDomingoD && $insertLunesD && $insertMartesD && $insertMiercolesD && $insertJuevesD && $insertViernesD && $insertSabadoD && $insertDomingoR && $insertLunesR && $insertMartesR && $insertMiercolesR && $insertJuevesR && $insertViernesR && $insertSabadoR) {
                    header ("Location: ../adminHorariosLaborales.php");
                } else {
                    header ("Location: ../adminHorariosLaborales.php");
                }
            // Caso contrario, si ya hay datos, los actualiza
            } else {
                // Si Entrada y Salida de un dia están vacios, pasa a la siguiente validación (UPDATE)
                if (empty($rLunesEntrada) && empty($rLunesSalida) && empty($rLunesSalidaReceso) && empty($rLunesEntradaReceso) || empty($rMartesEntrada) && empty($rMartesSalida) && empty($rMartesSalidaReceso) && empty($rMartesEntradaReceso) || empty($rMiercolesEntrada) && empty($rMiercolesSalida) && empty($rMiercolesSalidaReceso) && empty($rMiercolesEntradaReceso) || empty($rJuevesEntrada) && empty($rJuevesSalida) && empty($rJuevesSalidaReceso) && empty($rJuevesEntradaReceso) || empty($rViernesEntrada) && empty($rViernesSalida) && empty($rViernesSalidaReceso) && empty($rViernesEntradaReceso) || empty($rSabadoEntrada) && empty($rSabadoSalida) && empty($rSabadoSalidaReceso) && empty($rSabadoEntradaReceso) || empty($rDomingoEntrada) && empty($rDomingoSalida) && empty($rDomingoSalidaReceso) && empty($rDomingoEntradaReceso)) {
                    $updateDomingoD = mysqli_query($conexion, "UPDATE horarios_laborales_detalles SET hora_entrada = '" .$rDomingoEntrada. "', hora_salida = '" .$rDomingoSalida. "' WHERE no_horario = '" .$noHorario. "' AND id_empresa = '" .$id. "' AND no_dia = 1");
                    $updateLunesD = mysqli_query($conexion, "UPDATE horarios_laborales_detalles SET hora_entrada = '" .$rLunesEntrada. "', hora_salida = '" .$rLunesSalida. "' WHERE no_horario = '" .$noHorario. "' AND id_empresa = '" .$id. "' AND no_dia = 2");
                    $updateMartesD = mysqli_query($conexion, "UPDATE horarios_laborales_detalles SET hora_entrada = '" .$rMartesEntrada. "', hora_salida = '" .$rMartesSalida. "' WHERE no_horario = '" .$noHorario. "' AND id_empresa = '" .$id. "' AND no_dia = 3");
                    $updateMiercolesD = mysqli_query($conexion, "UPDATE horarios_laborales_detalles SET hora_entrada = '" .$rMiercolesEntrada. "', hora_salida = '" .$rMiercolesSalida. "' WHERE no_horario = '" .$noHorario. "' AND id_empresa = '" .$id. "' AND no_dia = 4");
                    $updateJuevesD = mysqli_query($conexion, "UPDATE horarios_laborales_detalles SET hora_entrada = '" .$rJuevesEntrada. "', hora_salida = '" .$rJuevesSalida. "' WHERE no_horario = '" .$noHorario. "' AND id_empresa = '" .$id. "' AND no_dia = 5");
                    $updateViernesD = mysqli_query($conexion, "UPDATE horarios_laborales_detalles SET hora_entrada = '" .$rViernesEntrada. "', hora_salida = '" .$rViernesSalida. "' WHERE no_horario = '" .$noHorario. "' AND id_empresa = '" .$id. "' AND no_dia = 6");
                    $updateSabadoD = mysqli_query($conexion, "UPDATE horarios_laborales_detalles SET hora_entrada = '" .$rSabadoEntrada. "', hora_salida = '" .$rSabadoSalida. "' WHERE no_horario = '" .$noHorario. "' AND id_empresa = '" .$id. "' AND no_dia = 7");

                    $updateDomingoR = mysqli_query($conexion, "UPDATE horarios_laborales_recesos SET salida_descanso = '" .$rDomingoSalidaReceso. "', entrada_descanso = '" .$rDomingoEntradaReceso. "' WHERE no_horario = '" .$noHorario. "' AND id_empresa = '" .$id. "' AND no_dia = 1");
                    $updateLunesR = mysqli_query($conexion, "UPDATE horarios_laborales_recesos SET salida_descanso = '" .$rLunesSalidaReceso. "', entrada_descanso = '" .$rLunesEntradaReceso. "' WHERE no_horario = '" .$noHorario. "' AND id_empresa = '" .$id. "' AND no_dia = 2");
                    $updateMartesR = mysqli_query($conexion, "UPDATE horarios_laborales_recesos SET salida_descanso = '" .$rMartesSalidaReceso. "', entrada_descanso = '" .$rMartesEntradaReceso. "' WHERE no_horario = '" .$noHorario. "' AND id_empresa = '" .$id. "' AND no_dia = 3");
                    $updateMiercolesR = mysqli_query($conexion, "UPDATE horarios_laborales_recesos SET salida_descanso = '" .$rMiercolesSalidaReceso. "', entrada_descanso = '" .$rMiercolesEntradaReceso. "' WHERE no_horario = '" .$noHorario. "' AND id_empresa = '" .$id. "' AND no_dia = 4");
                    $updateJuevesR = mysqli_query($conexion, "UPDATE horarios_laborales_recesos SET salida_descanso = '" .$rJuevesSalidaReceso. "', entrada_descanso = '" .$rJuevesEntradaReceso. "' WHERE no_horario = '" .$noHorario. "' AND id_empresa = '" .$id. "' AND no_dia = 5");
                    $updateViernesR = mysqli_query($conexion, "UPDATE horarios_laborales_recesos SET salida_descanso = '" .$rViernesSalidaReceso. "', entrada_descanso = '" .$rViernesEntradaReceso. "' WHERE no_horario = '" .$noHorario. "' AND id_empresa = '" .$id. "' AND no_dia = 6");
                    $updateSabadoR = mysqli_query($conexion, "UPDATE horarios_laborales_recesos SET salida_descanso = '" .$rSabadoSalidaReceso. "', entrada_descanso = '" .$rSabadoEntradaReceso. "' WHERE no_horario = '" .$noHorario. "' AND id_empresa = '" .$id. "' AND no_dia = 7");

                    if ($updateDomingoD && $updateLunesD && $updateMartesD && $updateMiercolesD && $updateJuevesD && $updateViernesD && $updateSabadoD && $updateDomingoR && $updateLunesR && $updateMartesR && $updateMiercolesR && $updateJuevesR && $updateViernesR && $updateSabadoR) {
                        header ("Location: ../adminHorariosLaborales.php");
                    } else {
                        header ("Location: ../adminHorariosLaborales.php");
                    }
                // Caso contrario, manda una alerta
                } else {
                    echo '<script> alert("Por indicaciones de la Ley Federal del Trabajo (LFT) debe de haber un día de descanso laboral."); window.history.go(-1); </script>';
                }
            }
        }
    // Caso contrario, manda una alerta
    } else {
        echo '<script> alert("Por indicaciones de la Ley Federal del Trabajo (LFT) debe de haber un día de descanso laboral."); window.history.go(-1); </script>';
    }

    mysqli_close($conexion);
?>
<?php
    require("../conexion.php");

    error_reporting(0);
    
    //if (!empty($_POST["id"]) && !empty($_POST["idU"]) && !empty($_POST["rfc"]) && !empty($_POST["curp"]) && !empty($_POST["noIMSS"])) {
    if (empty($_POST['fechaFinalizacion'])) {
        $id = $_POST["id"];
        $idU = $_POST["idU"];

        $equipoAreaDepartamento = $_POST["equipoAreaDepartamento"];
        $cargoPuesto = $_POST["cargoPuesto"];
        $fechaIngreso = $_POST["fechaIngreso"];
        $fechaAltaIMSS = $_POST["fechaAltaIMSS"];
        $nombreBanco = $_POST["nombreBanco"];
        $numeroCuenta = $_POST["numeroCuenta"];
        $clabeInterbancaria = $_POST["clabeInterbancaria"];
        
        $fechaInicio = $_POST["fechaInicio"];
        $frecuenciaPago = $_POST["frecuenciaPago"];
        $salarioDiario = $_POST["salarioDiario"];
        $tipoContrato = $_POST["tipoContrato"];
        $lugarTrabajoOficina = $_POST["lugarTrabajoOficina"];
        $horarioLaboral = $_POST["horarioLaboral"];
        // $HLLunesViernes1 = $_POST["HLLunesViernes1"];
        // $HLLunesViernes2 = $_POST["HLLunesViernes2"];
        // $HLSabado1 = $_POST["HLSabado1"];
        // $HLSabado2 = $_POST["HLSabado2"];
        // $HLDomingo1 = $_POST["HLDomingo1"];
        // $HLDomingo2 = $_POST["HLDomingo2"];

        $supervisorAusencias =  $_POST["supervisorAusencias"];
        $puestoSupervisor =  $_POST["puestoSupervisor"];
        $correoElectronicoSupervisor =  $_POST["correoElectronicoSupervisor"];

        // $update = "UPDATE usuarios_perfiles SET il_departamento = '" .$equipoAreaDepartamento. "', il_puesto = '" .$cargoPuesto. "', il_fecha_ingreso = '" .$fechaIngreso. "', il_fecha_alta_imss = '" .$fechaAltaIMSS. "', il_nombre_banco = '" .$nombreBanco. "', il_no_cuenta = '" .$numeroCuenta. "', il_clabe_interbancaria = '" .$clabeInterbancaria. "', cl_fecha_inicio = '" .$fechaInicio. "', cl_frecuencia_pago = '" .$frecuenciaPago. "', cl_salario_diario = '" .$salarioDiario. "', cl_tipo_contrato = '" .$tipoContrato. "', cl_oficina = '" .$lugarTrabajoOficina. "', cl_LaV_entrada = '" .$HLLunesViernes1. "', cl_LaV_salida = '" .$HLLunesViernes2. "', cl_S_entrada = '" .$HLSabado1. "', cl_S_salida = '" .$HLSabado2. "', cl_D_entrada = '" .$HLDomingo1. "', cl_D_salida = '" .$HLDomingo2. "', a_supervisor_ausencias = '" .$supervisorAusencias. "', a_puesto_supervisor = '" .$puestoSupervisor. "', a_correo_supervisor = '" .$correoElectronicoSupervisor. "' WHERE id_empresa = '" .$id. "' AND id_usuario = '" .$idU. "'";
        $update = "UPDATE usuarios_perfiles SET il_departamento = '" .$equipoAreaDepartamento. "', il_puesto = '" .$cargoPuesto. "', il_fecha_ingreso = '" .$fechaIngreso. "', il_fecha_alta_imss = '" .$fechaAltaIMSS. "', il_nombre_banco = '" .$nombreBanco. "', il_no_cuenta = '" .$numeroCuenta. "', il_clabe_interbancaria = '" .$clabeInterbancaria. "', cl_fecha_inicio = '" .$fechaInicio. "', cl_frecuencia_pago = '" .$frecuenciaPago. "', cl_salario_diario = '" .$salarioDiario. "', cl_tipo_contrato = '" .$tipoContrato. "', cl_oficina = '" .$lugarTrabajoOficina. "', cl_horario_laboral = '" .$horarioLaboral. "', a_supervisor_ausencias = '" .$supervisorAusencias. "', a_puesto_supervisor = '" .$puestoSupervisor. "', a_correo_supervisor = '" .$correoElectronicoSupervisor. "' WHERE id_empresa = '" .$id. "' AND id_usuario = '" .$idU. "'";

        $resUpdate = mysqli_query($conexion, $update);
        
        if ($resUpdate) {
            header ("Location: ../adminVerMiPerfilT.php?idU=".$idU);
        } else {
            header ("Location: ../adminVerMiPerfilT.php?idU=".$idU);
        }
    } else {
        $id = $_POST["id"];
        $idU = $_POST["idU"];

        $equipoAreaDepartamento = $_POST["equipoAreaDepartamento"];
        $cargoPuesto = $_POST["cargoPuesto"];
        $fechaIngreso = $_POST["fechaIngreso"];
        $fechaAltaIMSS = $_POST["fechaAltaIMSS"];
        $nombreBanco = $_POST["nombreBanco"];
        $numeroCuenta = $_POST["numeroCuenta"];
        $clabeInterbancaria = $_POST["clabeInterbancaria"];

        $fechaInicio = $_POST["fechaInicio"];
        $fechaFinalizacion = $_POST["fechaFinalizacion"];
        $frecuenciaPago = $_POST["frecuenciaPago"];
        $salarioDiario = $_POST["salarioDiario"];
        $tipoContrato = $_POST["tipoContrato"];
        $lugarTrabajoOficina = $_POST["lugarTrabajoOficina"];
        $HLLunesViernes1 = $_POST["HLLunesViernes1"];
        $HLLunesViernes2 = $_POST["HLLunesViernes2"];
        $HLSabado1 = $_POST["HLSabado1"];
        $HLSabado2 = $_POST["HLSabado2"];
        $HLDomingo1 = $_POST["HLDomingo1"];
        $HLDomingo2 = $_POST["HLDomingo2"];

        $supervisorAusencias =  $_POST["supervisorAusencias"];
        $puestoSupervisor =  $_POST["puestoSupervisor"];
        $correoElectronicoSupervisor =  $_POST["correoElectronicoSupervisor"];

        $update = "UPDATE usuarios_perfiles SET il_departamento = '" .$equipoAreaDepartamento. "', il_puesto = '" .$cargoPuesto. "', il_fecha_ingreso = '" .$fechaIngreso. "', il_fecha_alta_imss = '" .$fechaAltaIMSS. "', il_nombre_banco = '" .$nombreBanco. "', il_no_cuenta = '" .$numeroCuenta. "', il_clabe_interbancaria = '" .$clabeInterbancaria. "', cl_fecha_inicio = '" .$fechaInicio. "', cl_fecha_finalizacion = '" .$fechaFinalizacion. "', cl_frecuencia_pago = '" .$frecuenciaPago. "', cl_salario_diario = '" .$salarioDiario. "', cl_tipo_contrato = '" .$tipoContrato. "', cl_oficina = '" .$lugarTrabajoOficina. "', cl_LaV_entrada = '" .$HLLunesViernes1. "', cl_LaV_salida = '" .$HLLunesViernes2. "', cl_S_entrada = '" .$HLSabado1. "', cl_S_salida = '" .$HLSabado2. "', cl_D_entrada = '" .$HLDomingo1. "', cl_D_salida = '" .$HLDomingo2. "', a_supervisor_ausencias = '" .$supervisorAusencias. "', a_puesto_supervisor = '" .$puestoSupervisor. "', a_correo_supervisor = '" .$correoElectronicoSupervisor. "' WHERE id_empresa = '" .$id. "' AND id_usuario = '" .$idU. "'";

        $resUpdate = mysqli_query($conexion, $update);
        
        if ($resUpdate) {
            header ("Location: ../adminVerMiPerfilT.php?idU=".$idU);
        } else {
            header ("Location: ../adminVerMiPerfilT.php?idU=".$idU);
        }
    }
    //} else {
        //echo '<script> alert("Por favor, llena todos los campos."); window.history.go(-1); </script>';
    //}
    
    mysqli_close($conexion);
?>
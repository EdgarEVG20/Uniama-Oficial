<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require('../src/Exception.php');
    require('../src/PHPMailer.php');
    require('../src/SMTP.php');

    require("../conexion.php");

    $mail = new PHPMailer(true);

    // error_reporting(0);
    //Si se quiere subir una imagen
    if (isset($_POST['guardarAusencia'])) {
        //Recogemos el archivo enviado por el formulario
        $id = $_POST['id'];
        $idU = $_POST['idU'];
        $idAusencia = $_POST["nombreAusencia"];
        $motivoAusencia = $_POST["motivo"];
        $tipoAusencia = $_POST["tipo"];
        $fechaInicio = $_POST["fechaInicio"];
        $fechaFin = $_POST["fechaFin"];
        $archivo = $_FILES['archivo']['name'];
        
        //Busca que la ausencia, fecha de inicio y fecha final no sean iguales
        $query = mysqli_query($conexion, "SELECT id_cat_ausencia, fecha_inicio, fecha_fin FROM ausencias WHERE id_empresa = '".$id."' AND id_usuario = '".$idU."' AND id_cat_ausencia = '".$idAusencia."' AND fecha_inicio = '".$fechaInicio."' AND fecha_fin = '".$fechaFin."'");
        $resAusencia = mysqli_fetch_assoc($query);
        $idAusenciaBD = $resAusencia['id_cat_ausencia'];
        $fechaInicioBD = $resAusencia['fecha_inicio'];
        $fechaFinBD = $resAusencia['fecha_fin'];

        //Seleccionar el nombre del usuario que solicita la ausencia
        $conNombre = mysqli_query($conexion, "SELECT nombre FROM usuarios WHERE id_usuario = '".$idU."'");
        $resNombre = mysqli_fetch_assoc($conNombre);
        $nombreU = $resNombre['nombre'];

        //Seleccionar si la ausencia solicitada necesita aprobación o no y el nombre de la ausencia
        $query = mysqli_query($conexion, "SELECT nombre, aprobacion FROM catalogo_ausencias WHERE id_ausencia = '".$idAusencia."'");
        $resQuery = mysqli_fetch_assoc($query);
        $nombreAusencia = $resQuery['nombre'];
        $aprobacion = $resQuery['aprobacion'];

        //Asignar el tipo de Ausencia según el dato mandado en el formulario
        if ($tipoAusencia == 1) {
            $tipoAusenciaLetra = "Mismo Día";
        } elseif ($tipoAusencia == 2) {
            $tipoAusenciaLetra = "Días";
        }
        
        mysqli_next_result($conexion);
        $CorreoAdministradores = mysqli_query($conexion, "CALL obtieneCorreosAdmin($id);");
        // $dataCorreosAdmins = mysqli_fetch_assoc($CorreoAdministradores);
        // $correosAdmin = $dataCorreosAdmins['correo'];
        
        mysqli_next_result($conexion);
        $CorreoSupervisor = mysqli_query($conexion, "CALL obtieneCorreoSupervisor($idU);");
        $dataCorreoSuper = mysqli_fetch_assoc($CorreoSupervisor);
        $correoSuper = $dataCorreoSuper['correo'];

        $FI = strtotime($fechaInicio);
        $diaFI = date("d", $FI);
        $mesFI = date("m", $FI);
        $añoFI = date("Y", $FI);

        $FF = strtotime($fechaFin);
        $diaFF = date("d", $FF);
        $mesFF = date("m", $FF);
        $añoFF = date("Y", $FF);

        mysqli_next_result($conexion);
        //Si el archivo contiene algo y es diferente de vacio
        if (isset($archivo) && $archivo != "") {
            $tipo = $_FILES['archivo']['type'];
            $tamano = $_FILES['archivo']['size'];
            $temp = $_FILES['archivo']['tmp_name'];

            if (!strpos($tipo, 'pdf')) {
                echo '<script> alert("Error. La extensión del archivo no es correcta. Por favor, sube tu documento en PDF."); window.history.go(-1); </script>';
            } else {

                $folder = "../Clientes/".$id."/empleados/".$idU."/ausencias"; //"_".$rfc.
                if (!is_dir($folder)) {
                    mkdir($folder);
                }

                if (move_uploaded_file($temp, "../Clientes/".$id."/empleados/".$idU."/ausencias/".$idAusencia."_".$fechaInicio."_".$fechaFin.".pdf")) { //"_".$rfc.
                    chmod($folder, 0777);

                    if ($idAusencia !== $idAusenciaBD && $fechaInicio !== $fechaInicioBD && $fechaFin !== $fechaFinBD) {
                        $insert = mysqli_query($conexion, "INSERT INTO ausencias VALUES (null, '$id', '$idU', '$idAusencia', '$motivoAusencia', '$tipoAusencia', '$fechaInicio', '$fechaFin', 1, '$aprobacion')");
                        // if ($aprobacion == 1) {
                        //     $insert = mysqli_query($conexion, "INSERT INTO ausencias VALUES (null, '$id', '$idU', '$idAusencia', '$motivoAusencia', '$tipoAusencia', '$fechaInicio', '$fechaFin', 1, 1)");
                        // } elseif ($aprobacion == 2) {
                        //     $insert = mysqli_query($conexion, "INSERT INTO ausencias VALUES (null, '$id', '$idU', '$idAusencia', '$motivoAusencia', '$tipoAusencia', '$fechaInicio', '$fechaFin', 1, 2)");
                        // }

                        try {
                            $mail->isSMTP();
                            $mail->Host       = 'mail.velor.mx';
                            $mail->SMTPAuth   = true;
                            
                            $mail->Username   = 'notificaciones.uniama@velor.mx';
                            $mail->Password   = 'velor300Correo';
                            $mail->SMTPSecure = 'ssl';
                            $mail->Port       = 465;

                            $mail->setFrom('notificaciones.uniama@velor.mx', 'UNIAMA Notificador'); 
                            $mail->addAddress($correoSuper);
                            while ($dataCorreosAdmins = mysqli_fetch_assoc($CorreoAdministradores)) {
                                $mail->addCC($dataCorreosAdmins['correo']);
                            }
                            $mail->isHTML(true);
                            $mail->Subject = 'SOLICITUD DE AUSENCIA';
                            $mensaje = '
                                    El colaborador <b>'.$nombreU.'</b> ha creado una solicitud de ausencia desde UNIAMA con la siguiente información.<br><br>
                                    <b>Ausencia:<b> '.$nombreAusencia.'<br>
                                    <b>Tipo:<b> '.$tipoAusenciaLetra.'<br>
                                    <b>Fecha inicio:<b> '.$diaFI.'-'.$mesFI.'-'.$añoFI.'<br>
                                    <b>Fecha fin:<b> '.$diaFF.'-'.$mesFF.'-'.$añoFF.'<br>
                                    <b>Motivo:<b> '.$motivoAusencia.'<br><br><br><br><br>
                                    
                                    <center><a type="button" style="
                                                                    text-decoration:none;
                                                                    font-weight: 600;
                                                                    font-size: 20px;
                                                                    color:#ffffff;
                                                                    padding-top:15px;
                                                                    padding-bottom:15px;
                                                                    padding-left:40px;
                                                                    padding-right:40px;
                                                                    background-color:#0800ff;
                                                                    border-color: #0800ff;
                                                                    border-width: 3px;
                                                                    border-style: solid;
                                                                        border-radius:35px;" href="https://uniama.velor.mx/">ENTRAR</a></center>
                                    <br><br>
                                ';
                            $mail->Body = $mensaje;

                            $mail->send();
                            echo '<script> alert("Tu ausencia ha sido enviada para su respectiva aprobación."); </script>';
                            header ("Location: ../tAusencias.php");
                        } catch (Exception $e) {
                            echo "El mensaje no pudo ser enviado. Error: {$mail->ErrorInfo}";
                        }


                        if ($insert) {
                            echo '<script> alert("¡Tu ausencia ha sido creada con éxito!."); </script>';
                            header ("Location: ../tAusencias.php");
                        } else {
                            echo '<script> alert("Ha ocurrido un error al intentar crear tu ausencia, inténtalo de nuevo."); window.history.go(-1); </script>';
                        }
                    } else {
                        echo '<script> alert("Error. No puedes agregar una ausencia con el mismo nombre y el mismo rango de fecha."); window.history.go(-1); </script>';
                    }
                } else {
                    echo '<script> alert("Ha ocurrido un error al intentar subir el arhcivo, inténtalo de nuevo."); window.history.go(-1); </script>';
                }
            }
        } else {
            if ($idAusencia !== $idAusenciaBD && $fechaInicio !== $fechaInicioBD && $fechaFin !== $fechaFinBD) {
                $insert = mysqli_query($conexion, "INSERT INTO ausencias VALUES (null, '$id', '$idU', '$idAusencia', '$motivoAusencia', '$tipoAusencia', '$fechaInicio', '$fechaFin', 2, '$aprobacion')");
                // if ($aprobacion == 1) {
                //     $insert = mysqli_query($conexion, "INSERT INTO ausencias VALUES (null, '$id', '$idU', '$idAusencia', '$motivoAusencia', '$tipoAusencia', '$fechaInicio', '$fechaFin', 2, 1)");
                // } elseif ($aprobacion == 2) {
                //     $insert = mysqli_query($conexion, "INSERT INTO ausencias VALUES (null, '$id', '$idU', '$idAusencia', '$motivoAusencia', '$tipoAusencia', '$fechaInicio', '$fechaFin', 2, 2)");
                // }

                try {
                    $mail->isSMTP();
                    $mail->Host       = 'mail.velor.mx';
                    $mail->SMTPAuth   = true;
                    
                    $mail->Username   = 'notificaciones.uniama@velor.mx';
                    $mail->Password   = 'velor300Correo';
                    $mail->SMTPSecure = 'ssl';
                    $mail->Port       = 465;

                    $mail->setFrom('notificaciones.uniama@velor.mx', 'UNIAMA Notificador'); 
                    $mail->addAddress($correoSuper);
                    while ($dataCorreosAdmins = mysqli_fetch_assoc($CorreoAdministradores)) {
                        $mail->addCC($dataCorreosAdmins['correo']);
                    }
                    $mail->isHTML(true);
                    $mail->Subject = 'SOLICITUD DE AUSENCIA';
                    $mensaje = '
                            El colaborador <b>'.$nombreU.'</b> ha creado una solicitud de ausencia desde UNIAMA con la siguiente información.<br><br>
                            <b>Ausencia:<b> '.$nombreAusencia.'<br>
                            <b>Tipo:<b> '.$tipoAusenciaLetra.'<br>
                            <b>Fecha inicio:<b> '.$diaFI.'-'.$mesFI.'-'.$añoFI.'<br>
                            <b>Fecha fin:<b> '.$diaFF.'-'.$mesFF.'-'.$añoFF.'<br>
                            <b>Motivo:<b> '.$motivoAusencia.'<br><br><br><br><br>
                            
                            <center><a type="button" style="
                                                            text-decoration:none;
                                                            font-weight: 600;
                                                            font-size: 20px;
                                                            color:#ffffff;
                                                            padding-top:15px;
                                                            padding-bottom:15px;
                                                            padding-left:40px;
                                                            padding-right:40px;
                                                            background-color:#0800ff;
                                                            border-color: #0800ff;
                                                            border-width: 3px;
                                                            border-style: solid;
                                                                border-radius:35px;" href="https://uniama.velor.mx/">ENTRAR</a></center>
                            <br><br>
                        ';
                    $mail->Body = $mensaje;

                    $mail->send();
                    echo '<script> alert("Tu ausencia ha sido enviada para su respectiva aprobación."); </script>';
                    header ("Location: ../tAusencias.php");
                } catch (Exception $e) {
                    // echo '<script> alert("Ha ocurrido un error inesperado, inténtalo de nuevo."); </script>';
                    echo "El mensaje no pudo ser enviado. Error: {$mail->ErrorInfo}";
                }

                if ($insert) {
                    echo '<script> alert("¡Tu ausencia ha sido creada con éxito!.");</script>';
                    header ("Location: ../tAusencias.php");
                } else {
                    echo '<script> alert("Ha ocurrido un error al intentar crear tu ausencia, inténtalo de nuevo."); window.history.go(-1); </script>';
                }
            } else {
                echo '<script> alert("Error. No puedes agregar una ausencia con el mismo nombre y el mismo rango de fecha."); window.history.go(-1); </script>';
            }
        }
    } else {
        echo '<script> alert("Para registrar tu ausencia da clic en "Agregar""); window.history.go(-1); </script>';
    }

?>
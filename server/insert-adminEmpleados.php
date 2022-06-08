    <?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require('../src/Exception.php');
    require('../src/PHPMailer.php');
    require('../src/SMTP.php');

    require("../conexion.php");

    $mail = new PHPMailer(true);

    error_reporting(0);

    $id = $_POST["id"];
    $nombre = $_POST["nombre"];
    $correo = $_POST["correo"];
    $tipoUsuario = $_POST["tipoUsuario"];

   //Carácteres para la contraseña
    $str = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";
    $password = "";
    for($i = 0; $i < 10; $i++) {
      $password .= substr($str,rand(0,61),1);
   }

    $folder = "../Clientes/".$id."/empleados";
    if (!is_dir($folder)) {
        mkdir($folder);
    }

    $consultaSuscripcion = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM empresas WHERE id_empresa = '$id'"));
    $resSuscripcion = $consultaSuscripcion['suscripcion'];

    $consultaNumUsuarios = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id_empresa = '$id'");
    $resNumUsuarios = mysqli_num_rows($consultaNumUsuarios);

    if($resSuscripcion == '1 - 40' && $resNumUsuarios >= 40 || $resSuscripcion == '41 - 80' && $resNumUsuarios >= 80) {
        echo '<script> alert("El número de usuarios máximos permitidos llegó a su límite, por favor comunícate con soporte para contratar otro paquete."); window.history.go(-1); </script>';
    } else {
        $consultaCorreo = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM usuarios WHERE correo = '$correo'"));

        if ($consultaCorreo == 0) {
            $consultaNombreEmpresa = mysqli_query($conexion, "SELECT nombre_comercial FROM empresas WHERE id_empresa = '$id'");
            $resSelectNombre = mysqli_fetch_assoc($consultaNombreEmpresa);
            $nombreEmpresa = $resSelectNombre['nombre_comercial'];

            $insert = "INSERT INTO usuarios VALUES (null, '$id', '$nombre', '$correo', '$password', '$tipoUsuario', 1, 2)";
            $resInsert = mysqli_query($conexion, $insert);

            $selectIdUsuario = mysqli_query($conexion, "SELECT MAX(id_usuario) FROM usuarios");
            $consultaId = mysqli_fetch_array($selectIdUsuario);
            $idU = $consultaId[0];

            $insertPerfil = "INSERT INTO usuarios_perfiles (id_perfil, id_usuario, id_empresa) VALUES (null, '$idU', '$id')";
            $resInsertPerfil = mysqli_query($conexion, $insertPerfil);

            $folderUser = "../Clientes/".$id."/empleados/".$idU."";
            if (!is_dir($folderUser)) {
                mkdir($folderUser);
            }

            if ($tipoUsuario == 2) {
                $privilegio = "Administrador";
            } elseif ($tipoUsuario == 3) {
                $privilegio = "Supervisor";
            } elseif ($tipoUsuario == 4) {
                $privilegio = "Colaborador";
            }

            try {
                $mail->isSMTP();
                $mail->Host       = 'mail.velor.mx';
                $mail->SMTPAuth   = true;
                
                $mail->Username   = 'notificaciones.uniama@velor.mx';
                $mail->Password   = 'velor300Correo';
                $mail->SMTPSecure = 'ssl';
                $mail->Port       = 465;

                $mail->setFrom('notificaciones.uniama@velor.mx', 'UNIAMA Notificador'); 
                $mail->addAddress($correo);

                $mail->isHTML(true);
                $mail->Subject = 'BIENVENIDO COLABORADOR';
                $mensaje = '
                    Bienvenido <b>'.$nombre.'</b> ahora eres parte de nuestra empresa <b>'.$nombreEmpresa.'</b>, deseamos que te integres de manera efectiva a nuestros procesos, donde compartimos momentos de alegría y alcanzamos nuestras metas con la colaboración de todos.
                    Por favor activa tu cuenta con los siguientes datos para ingresar a nuestro Software de Capital Humano: <a href="https://uniama.velor.mx/">UNIAMA</a><br><br>
                    <b>Correo:</b> '.$correo.'<br>
                    <b>Contraseña:</b> '.$password.'<br>
                    <b>Tipo de Usuario:</b> '.$privilegio.'.<br><br><br><br><br>

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
                                                        border-radius:35px;" href="https://uniama.velor.mx/pruebas/">ACTIVAR</a></center>
                    <br><br>
                    ';
                $mail->Body = $mensaje;

                $mail->send();
                //echo 'El mensaje ha sido enviado';
                echo '<script> alert("El mensaje se ha enviado, usuario creado con éxito."); window.history.go(-1); </script>';
            } catch (Exception $e) {
                echo "El mensaje no pudo ser enviado. Error: {$mail->ErrorInfo}";
            }

            if ($resInsert && $resInsertPerfil) {
                header ("Location: ../adminEmpleados.php");
            } else {
                header ("Location: ../adminEmpleados.php");
            }
        } else {
            echo '<script> alert("Ya existe un usuario registrado con el mismo correo. Ingrese uno diferente."); window.history.go(-1); </script>';
        }

    }    
    
    mysqli_close($conexion);
?>
    <?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require('../src/Exception.php');
    require('../src/PHPMailer.php');
    require('../src/SMTP.php');

    require("../conexion.php");

    $mail = new PHPMailer(true);

    error_reporting(0);

    $idU = $_GET["idU"];

    $consultaPassword = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM usuarios WHERE id_usuario = $idU"));
    $nombre = $consultaPassword['nombre'];
    $correo = $consultaPassword['correo'];
    $password = $consultaPassword['password'];
    $tipoUsuario = $consultaPassword['nivel'];
    $estatus = $consultaPassword['estatus'];

    if ($tipoUsuario == 2) {
        $privilegio = "Administrador";
    } elseif ($tipoUsuario == 3) {
        $privilegio = "Supervisor";
    } elseif ($tipoUsuario == 4) {
        $privilegio = "Colaborador";
    }
    if ($estatus == 1) {
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
            $mail->Subject = 'RECORDATORIO DE PASSWORD';
            $mensaje = '
                    Buen dia <b>'.$nombre.'</b> por medio de este correo te hacemos llegar un recordatorio de tus datos para que ingreses a nuestro Software de Capital Humano: <a href="https://uniama.velor.mx/">UNIAMA</a><br><br>
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
                                                        border-radius:35px;" href="https://uniama.velor.mx/pruebas/">ENTRAR</a></center>
                    <br><br>
                ';
            $mail->Body = $mensaje;

            $mail->send();
            echo '<script> alert("El mensaje se ha enviado."); window.history.go(-1); </script>';
        } catch (Exception $e) {
            echo "El mensaje no pudo ser enviado. Error: {$mail->ErrorInfo}";
        }
    } else {
        echo '<script> alert("Para enviar un recordatorio de contraseña el usuario debe de estar activo, de lo contrario, no podrás hacerlo."); window.history.go(-1); </script>';
    }
    
    mysqli_close($conexion);
?>
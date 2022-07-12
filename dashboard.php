<?php
    session_start();
    require("conexion.php");

    $usuario = $_SESSION['nombre_user'];
    $idEmpresa = $_SESSION['id_emisor_user'];
    $idUsuario = $_SESSION['id_user'];
    $nivelUsuario = $_SESSION['nivel_user'];

    if (!isset($usuario)){
        header("location: index.html");
    } else 
    if (isset($usuario)) {
    
?>
    <?php
        $consultaAvisoPrivacidad = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM avisos_privacidad WHERE id_empresa = '$idEmpresa'"));
        
        if ($nivelUsuario == 2 || $nivelUsuario == 3 || $nivelUsuario == 4) {
            if ($consultaAvisoPrivacidad == 0) {
    ?>
        <div class="d-sm-flex align-items-center justify-content-between mb-4 bg-warning rounded">
            <h1 class="h4 mt-2 mb-2 text-gray-800 text-center">UNIAMA TE INVITA A QUE CONOZCAS SU AVISO DE PRIVACIDAD EN EL MANEJO Y TRATAMIENTO DE LA INFORMACI&Oacute;N DE TU EMPRESA.</h1>
        </div>
    <?php
            }
        }
    ?>
    <div class="row">
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="./tDocumentos.php">
                <label class="input-group-btn pointer">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body dashboardCards">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 infoCards">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">DOCUMENTOS OBLIGATORIOS</div>
                                    <?php
                                        $documentosObligatorios = mysqli_query($conexion, "CALL obtieneNoObligatorios($idEmpresa, $idUsuario);");
                                        $dataObligatorios = mysqli_fetch_assoc($documentosObligatorios);
                                    ?>
                                    <div class="h5 mb-0 mt-3 font-weight-bold text-gray-800"><?php echo $dataObligatorios['cargados'] .' de '. $dataObligatorios['obligatorios'] ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-file-pdf fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>    
                </label>
            </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <a href="./tDocumentos.php">
                <label class="input-group-btn pointer">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body dashboardCards">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 infoCards">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">DOCUMENTOS TOTALES</div>
                                    <?php
                                        mysqli_next_result($conexion);
                                        $documentosTotales = mysqli_query($conexion, "CALL obtieneDocTotales($idEmpresa, $idUsuario);");
                                        $dataTotales = mysqli_fetch_assoc($documentosTotales);
                                    ?>
                                    <div class="h5 mb-0 mt-3 font-weight-bold text-gray-800"><?php echo $dataTotales['cargados'] .' de '. $dataTotales['documentosTotal'] ?></div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-file-pdf fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>    
                </label>
            </a>
        </div>
        
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="./tMiPerfil.php">
                <label class="input-group-btn pointer">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body dashboardCards">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2 infoCards">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">DATOS COMPLETADOS DE MI PERFIL</div>
                                    <?php
                                        mysqli_next_result($conexion);
                                        $datosTotalesPerfil = mysqli_query($conexion, "CALL obtieneNoCampos($idEmpresa, $idUsuario);");
                                        $dataTotalesPerfil = mysqli_fetch_assoc($datosTotalesPerfil);
                                        $resCamposLlenos = $dataTotalesPerfil['totalCampos'] - $dataTotalesPerfil['totalVacios'];
                                        $data = ($resCamposLlenos * 100) / $dataTotalesPerfil['totalCampos'];
                                    ?>
                                    <div class="row no-gutters align-items-center  mt-3">
                                        <div class="col-auto">
                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo bcdiv($data, '1', 1); ?>%</div>
                                        </div>
                                        <div class="col">
                                            <div class="progress progress-sm mr-2">
                                                <div class="progress-bar bg-success" role="progressbar"
                                                    style="width: <?php echo $data ?>%" aria-valuenow="50" aria-valuemin="0"
                                                    aria-valuemax="100"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-info-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </label>
            </a>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <a href="#">
                <label class="input-group-btn">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body dashboardCards">
                            <div class="row no-gutters align-items-center">
                                <div class="col infoCards">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">PRÓXIMO DÍA FESTIVO</div>
                                    <?php
                                        mysqli_next_result($conexion);
                                        setlocale(LC_ALL, 'es_ES');
                                        $diasFestivos = mysqli_query($conexion, "CALL obtieneDiaFestivo('MEX');");
                                        $dataDiaFestivo = mysqli_fetch_assoc($diasFestivos);
                                        $fecha = strtotime($dataDiaFestivo['fecha']);

                                        $mes = DateTime::createFromFormat('!m', date("m", $fecha));
                                        $nombreMes = strftime("%B", $mes->getTimestamp());

                                        $dia = date("d", $fecha);
                                        $año = date("Y");
                                    ?>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800"><small><strong><?php echo $dia.' DE '.strtoupper($nombreMes).' DE '.$año ?></strong></small></div>
                                    <div class="h6 mb-0 font-weight-bold text-gray-800"><small><strong><?php echo $dataDiaFestivo['nombre'] ?></strong></small></div>
                                </div>
                                
                            </div>
                        </div>
                    </div>    
                </label>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-8 col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">CUMPLEAÑOS</h6>
                </div>
                <div class="card-body">
                    <?php
                        mysqli_next_result($conexion);
                        setlocale(LC_ALL, 'es_ES');
                        $festejos = mysqli_query($conexion, "CALL obtieneFestejados($idEmpresa);");
                    ?>
                    <div class="table-responsive">
                        <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Foto</th>
                                    <th>Nombre</th>
                                    <th>Fecha Cumpleaños</th>
                                    <th>Departamento</th>
                                </tr>
                            </thead>
                            
                            <?php
                                while($dataFestejos = mysqli_fetch_assoc($festejos)){
                                    $idUsuarioEmpresa = $dataFestejos['id_usuario'];
                                    $fechaNacimiento = strtotime($dataFestejos['ipb_fecha_nacimiento']);
                                    $mesFN = DateTime::createFromFormat('!m', date("m", $fechaNacimiento));
                                    $nombreMesFN = strftime("%B", $mesFN->getTimestamp());
                                    $diaFN = date("d", $fechaNacimiento);
                                    $año = date("Y");
                            ?>

                            <tbody>
                                <tr>
                                    <td>
                                        <?php
                                            $foto = "Clientes/".$idEmpresa."/empleados/".$idUsuarioEmpresa."/imgPerfil/fotoPerfil.png";
                                            if (file_exists($foto)) {
                                        ?>
                                                <img class="fotoPerfilMiniaturaTabla rounded-circle" src="Clientes/<?php echo $idEmpresa ?>/empleados/<?php echo $idUsuarioEmpresa ?>/imgPerfil/fotoPerfil.png" alt="">
                                        <?php
                                            } else {
                                        ?>
                                                <img class="fotoPerfilMiniaturaTabla rounded-circle" src="Clientes/fotoTemp.png">
                                        <?php
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $dataFestejos['nombre'] ?></td>
                                    <td><?php echo $diaFN.' DE '.strtoupper($nombreMesFN).' DE '.$año ?></td>
                                    <td><?php echo $dataFestejos['nombreD'] ?></td>
                                </tr>
                            </tbody>

                            <?php
                                }
                            ?>
                                
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4 col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-center">
                    <h6 class="m-0 font-weight-bold text-primary">BIENVENIDO</h6>
                </div>
                <div class="card-body">
                    <?php
                        mysqli_next_result($conexion);
                        $foto = "Clientes/".$idEmpresa."/empleados/".$idUsuario."/imgPerfil/fotoPerfil.png";
                            if (file_exists($foto)) {
                    ?>
                                <center><img class="img-thumbnail rounded-circle" style="width: 250px;" src="Clientes/<?php echo $idEmpresa ?>/empleados/<?php echo $idUsuario ?>/imgPerfil/fotoPerfil.png"></center>
                    <?php
                            } else {
                    ?>
                                <center><img class="img-thumbnail rounded-circle" style="width: 250px;" src="Clientes/fotoProfile.png"></center>
                    <?php
                            }
                    ?>
                    <br><br>
                    <?php
                        echo '<center><h1 class="h5 mb-0 text-gray-800">'.$usuario.'</h1></center>';
                    ?>

                </div>
            </div>
        </div>
    </div>
<?php
    }
    mysqli_close($conexion);
?>
<?php
    session_start();
    require("conexion.php");

    $usuario = $_SESSION['nombre_user'];
    $idEmpresa = $_SESSION['id_emisor_user'];
    $idUsuario = $_SESSION['id_user'];
    $nivelUsuario = $_SESSION['nivel_user'];
    $idVerUsuario = $_GET["idU"];

    if (!isset($usuario)){
        header("location: index.html");
    } elseif (isset($usuario) && $nivelUsuario == 2 || $nivelUsuario == 3) {
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        $breadcrumb = "Tablero / Información De Colaboradores / Ver Checadas";
        include("estructura/metas.php");
        include("estructura/title.php");
        include("estructura/hrefs.php");
    ?>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <?php
            include("estructura/menu.php");
        ?>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <?php
                    include("estructura/encabezado.php");
                ?>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <h1 class="h3 mb-2 text-gray-800">Ver Checadas</h1>
                    <br>

                    <?php
                        $nombreUsuario = mysqli_query($conexion, "SELECT nombre FROM usuarios WHERE id_usuario = $idVerUsuario");
                        $nombreU = mysqli_fetch_assoc($nombreUsuario);

                    ?>
                    <h1 class="h5 mb-2 text-gray-800">Trabajador: <?php echo $nombreU['nombre'] ?></h1>
                    <br>
                    <!-- DataTales -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Checadas Registradas</h6>
                        </div>

                        <?php
                        $res = mysqli_query($conexion, "SELECT usuarios.id_usuario, usuarios.id_empresa, usuarios.nombre, usuarios.estatus, reloj_checador.fecha_checada FROM usuarios LEFT JOIN reloj_checador ON usuarios.id_empresa = reloj_checador.id_empresa AND usuarios.id_usuario = reloj_checador.id_usuario WHERE usuarios.id_empresa = $idEmpresa AND usuarios.id_usuario = $idVerUsuario AND usuarios.estatus = 1 ORDER BY usuarios.nombre ASC");
                        ?>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th style="text-align: center;">Fecha Registrada</th>
                                            <th colspan="2" style="text-align: center;">Horarios</th>
                                        </tr>
                                    </thead>
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th style="text-align: center;">Entrada</th>
                                            <th style="text-align: center;">Salida</th>
                                        </tr>
                                    </thead>
                                    
                                    <?php
                                        while($data = mysqli_fetch_array($res)){
                                    ?>

                                    <tbody>
                                        <tr>
                                            <!-- <td><?php //echo $data['nombre'] ?></td> -->
                                            <td>
                                                <?php
                                                    if ($data['fecha_checada'] == '0000-00-00' || $data['fecha_checada'] == NULL) {
                                                        echo "S/F";
                                                    } else {
                                                        $fecha = strtotime($data['fecha_checada']);

                                                        $mes = DateTime::createFromFormat('!m', date("m", $fecha));
                                                        $nombreMes = strftime("%B", $mes->getTimestamp());
                                                        
                                                        $dia = date("d", $fecha);
                                                        // $mes = date("m", $fecha);
                                                        $año = date("Y", $fecha);
                                                        // echo $dia.'-'.$mes.'-'.$año;
                                                        echo $dia.' DE '.strtoupper($nombreMes).' DE '.$año;
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if ($data['fecha_checada'] == '0000-00-00' || $data['fecha_checada'] == NULL) {
                                                        echo "S/F";
                                                    } else {
                                                        $fecha = strtotime($data['fecha_checada']);
                                                        $hora = date("h:i:s A", $fecha);
                                                        echo $hora;
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if ($data['fecha_checada'] == '0000-00-00' || $data['fecha_checada'] == NULL) {
                                                        echo "S/F";
                                                    } else {
                                                        $fecha = strtotime($data['fecha_checada']);
                                                        $hora = date("h:i:s A", $fecha);
                                                        echo $hora;
                                                    }
                                                ?>
                                            </td>
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
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <?php
                include("estructura/pie.php");
            ?>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

<?php
    } elseif (isset($usuario) && $nivelUsuario == 1 || $nivelUsuario == 4) {
        header("location: panel2.php");
    }
    mysqli_close($conexion);
?>

</body>
</html>
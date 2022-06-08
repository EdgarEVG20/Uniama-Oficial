<?php
    session_start();
    error_reporting(0);
    require("conexion.php");
    $correo = $_POST['correo'];
    $password = $_POST['password'];
    $consultaSQL = "SELECT * FROM usuarios WHERE correo = '".$correo."' AND password = '".$password."'";
    $resultado = mysqli_query($conexion, $consultaSQL);
    $usuario = mysqli_fetch_array($resultado);
        
    $idU = $usuario['id_usuario'];
    $id = $usuario['id_empresa'];
    if ($idU == "") {
        session_destroy();
        header('Location: index.html');
    }
    
    $consultaU = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM usuarios WHERE id_usuario = $idU"));

    if ($consultaU['estatus'] == 2 && $consultaU['nuevo'] == 2) {
        session_destroy();
        header('Location: index.html');
    } elseif ($consultaU['estatus'] == 2 || $consultaU['estatus'] == 1 && $consultaU['nuevo'] == 1 || $consultaU['nuevo'] == 2) {
        $update = mysqli_query($conexion, "UPDATE usuarios SET estatus = 1, nuevo = 2 WHERE id_usuario = $idU");


        // $consultaIdCorporativo = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT id_corporativo FROM corporativo_empresas WHERE id_empresa = $id"));
        // $idCorporativo = $consultaIdCorporativo['id_corporativo']; // 1

        // $consultaIdsEmpresas = mysqli_query($conexion, "SELECT * FROM corporativo_empresas WHERE id_corporativo = $idCorporativo");// 4 y 5


        $_SESSION['id_user'] = $usuario["id_usuario"];
        $_SESSION['id_emisor_user'] = $usuario["id_empresa"];
        $_SESSION['nombre_user'] = $usuario["nombre"];
        $_SESSION['nivel_user'] = $usuario["nivel"];
        
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php
        $breadcrumb = "Tablero /";
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
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Tablero</h1>
                    </div>

                    <!-- <select class="form-control" id="empresa" name="empresa" required>
                        <option value="#" disabled selected>Empresas</option>
                        <?php
                            // while ($dataEmpresas = mysqli_fetch_assoc($consultaIdsEmpresas)){ // 4 y 5
                                // $idEmpresa = $dataEmpresas['id_empresa'];
                                // $nombreEmpresa = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT nombre_comercial FROM empresas WHERE id_empresa = $idEmpresa"));

                        ?>
                                <option value="<?php //echo $nombreEmpresa["id_empresa"]; ?>"><?php //echo $nombreEmpresa["nombre_comercial"]; ?></option>
                        <?php
                            // }
                        ?>
                    </select> -->

                    <?php
                        include("./dashboard.php");
                    ?>

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

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>
<?php
    }
?>
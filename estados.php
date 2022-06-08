<?php
    session_start();
    require("conexion.php");

    $usuario = $_SESSION['nombre_user'];
    $nivelUsuario = $_SESSION['nivel_user'];

    if (!isset($usuario)){
        header("location: index.html");
    } elseif (isset($usuario) && $nivelUsuario == 1) {
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        $breadcrumb = "Tablero / Cat&aacute;logos / Estados";
        include("estructura/metas.php");
        include("estructura/title.php");
        include("estructura/hrefs.php");
    ?>
    <script src="js/peticiones.js"></script>
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
                    <h1 class="h3 mb-2 text-gray-800">Estados</h1>

                    <!-- Formulario -->
                    <form class="form mt-3 mb-5" action="server/insert-estados.php" method="POST">
                        <div class="row pt-3 pb-4">
                            <div class="col-2">
                                <input type="text" class="form-control"name="clave" placeholder="Clave Pa&iacute;s" required onkeyup="mayusculas(this)" maxlength="3">
                            </div>
                            <div class="col-2">
                                <input type="text" class="form-control" name="catalogo" placeholder="Clave Estado" required onkeyup="mayusculas(this)" maxlength="3">
                            </div>
                            <div class="col-8">
                                <input type="text" class="form-control" name="nombre" placeholder="Nombre" required onkeyup="mayusculas(this)" maxlength="50">
                            </div>
                        </div>

                        <center><button type="submit" class="btn btn-primary">Agregar</button></center>
                    </form>

                    <!-- DataTales -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row justify-content-between">
                                <div class="col-6">
                                    <h6 class="m-0 font-weight-bold text-primary">Registro de datos</h6>
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="busqueda" name="busqueda" placeholder="Buscar..." onkeyup="cargarBusquedaEstados(); mayusculas(this)">
                                </div>
                            </div>
                        </div>

                        <?php
                            $res = mysqli_query($conexion, "SELECT * FROM _cat_estados ORDER BY estado ASC LIMIT 50")
                        ?>

                        <div class="card-body">
                            <div class="table-responsive" id="mostrarTabla">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Clave Pais</th>
                                            <th>Clave Estado</th>
                                            <th>Nombre</th>
                                            <th>Estatus</th>
                                        </tr>
                                    </thead>
                                    
                                    <?php
                                        while($data = mysqli_fetch_array($res)){
                                    ?>

                                    <tbody>
                                        <tr>
                                            <td><?php echo $data['clave_pais'] ?></td>
                                            <td><?php echo $data['catalogo'] ?></td>
                                            <td><?php echo $data['estado'] ?></td>
                                            <td class="btn-switch">
                                                <label class="switch">
                                                    <input type="checkbox" id="<?php echo $data['id_estado']?>" name="btnSwitch" onclick="updateEstatus(<?php echo $data['id_estado']?>,<?php echo $data['id_estado']?>);" value="<?php echo $data['estatus']?>" <?php echo $data['estatus'] == '1' ? 'checked' : '2' ;?>>
                                                    <span class="slider round"></span>
                                                </label>
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

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>
    <script src="js/demo/chart-bar-demo.js"></script>

<?php
    } elseif (isset($usuario) && $nivelUsuario == 2 || $nivelUsuario == 3 || $nivelUsuario == 4) {
        header("location: panel2.php");
    }
    mysqli_close($conexion);
?>

<script language="JavaScript">
    function updateEstatus(idEstado, nombreSwitch)
    {
        if(document.getElementById(nombreSwitch).checked==false)
        {
            cambioEstado = 2;
        }
        else
        {
            cambioEstado = 1;
        }
        $.ajax({
            cache: false,
            dataType: 'json',
            url: 'server/updateEstatus.php',
            type: 'POST',
            data: {"id": idEstado, "estado": cambioEstado, "idBD": 'id_estado', "tablaBD": '_cat_estados'},
            success:function(data){
            },
        });
    }
</script>

</body>
</html>
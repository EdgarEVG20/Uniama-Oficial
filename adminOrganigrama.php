<?php
    session_start();
    require("conexion.php");

    $usuario = $_SESSION['nombre_user'];
    $idEmpresa = $_SESSION['id_emisor_user'];
    $nivelUsuario = $_SESSION['nivel_user'];

    if (!isset($usuario)){
        header("location: index.html");
    } elseif (isset($usuario) && $nivelUsuario == 2) {
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        $breadcrumb = "Tablero / Empresa / Organigrama";
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
                    <h1 class="h3 mb-2 text-gray-800">Organigrama</h1><br><br>

                    <?php
                        $consultaCount = "SELECT COUNT(*) FROM catalogo_departamentos WHERE id_empresa = $idEmpresa AND estatus = 1 ORDER BY jerarquia ASC";
                        $resultadoCount = mysqli_query($conexion, $consultaCount);
                        $datosCount = mysqli_fetch_array($resultadoCount);
                        $x = 1;
                        $consulta = "SELECT * FROM catalogo_departamentos WHERE id_empresa = $idEmpresa AND estatus = 1 ORDER BY jerarquia ASC";
                        $resultado = mysqli_query($conexion, $consulta);
                        while($datos = mysqli_fetch_array($resultado))
                        {
                            if ($datos["jerarquia"] == 1)
                            {
                                $organigrama.="[0, '".$datos['nombre']."', -1, 1, 'black'],";
                            }
                            else
                            {
                                if ($datos["jerarquia"] == 2)
                                {
                                    if($x == $datosCount[0])
                                    {
                                        $organigrama.="[".$datos['id_departamento'].", '".$datos['nombre']."', 0, 1, 'black']";
                                    }
                                    else
                                    {
                                        $organigrama.="[".$datos['id_departamento'].", '".$datos['nombre']."', 0, 1, 'black'],";
                                    }
                                }
                                else
                                {
                                    if($x == $datosCount[0])
                                    {
                                        $organigrama.="[".$datos['id_departamento'].", '".$datos['nombre']."', ".$datos['depende_de'].", 1, 'black']";
                                    }
                                    else
                                    {
                                        $organigrama.="[".$datos['id_departamento'].", '".$datos['nombre']."', ".$datos['depende_de'].", 1, 'black'],";
                                    }
                                }
                            }
                            $x++;
                        }
                        // $variable = "[0, 'Consejo Accionistas', -1, 1, 'black'],
                        //     [12, 'TI', 0,1, 'black'],
                        //     [13, 'Administraci贸n', 0, 1, 'black'],
                        //     [14, 'Comercializaci贸n', 0, 1, 'black'],
                        //     [15, 'Recursos Humanos', 0, 1, 'black'],
                        //     [16, 'Ejecutivo de Desarrollo', 12, 1, 'black'],
                        //     [17, 'Soporte T茅cnico', 12, 1, 'black']";
                    ?>

                    <div id="wordtree_explicit" style="width: 100%; height: 450px;"></div>

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

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<?php
    } elseif (isset($usuario) && $nivelUsuario == 1 || $nivelUsuario == 3 || $nivelUsuario == 4) {
        header("location: panel2.php");
    }
    mysqli_close($conexion);
?>

<script type="text/javascript">
    google.charts.load('current', {packages:['wordtree']});
    google.charts.setOnLoadCallback(drawSimpleNodeChart);
    function drawSimpleNodeChart() {
        var nodeListData = new google.visualization.arrayToDataTable([
            ['id', 'childLabel', 'parent', 'size', { role: 'style' }],
            <?php
                echo $organigrama;
            ?>
        ]);

        var options = {
            colors: ['black', 'black', 'black'],
            wordtree: {
                format: 'explicit',
                type: 'suffix'
            }
        };

        var wordtree = new google.visualization.WordTree(document.getElementById('wordtree_explicit'));
        wordtree.draw(nodeListData, options);
    }
</script>

</body>
</html>
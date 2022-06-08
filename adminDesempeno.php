<?php
    session_start();
    require("conexion.php");

    $usuario = $_SESSION['nombre_user'];
    $idEmpresa = $_SESSION['id_emisor_user'];

    if (!isset($usuario)){
        header("location: index.html");
    } else
    if (isset($usuario)) {
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        $breadcrumb = "Tablero / Mi Perfil / Desempeño";
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
                    <h1 class="h3 mb-2 text-gray-800">Desempeño</h1>


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
    }
    mysqli_close($conexion);
?>

<script language="JavaScript">
    function updateEstatus(idAdDepartamentos, nombreSwitch)
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
            data: {"id":idAdDepartamentos, "estado":cambioEstado, "idBD":'id_departamento', "tablaBD":'catalogo_departamentos'},
            success:function(data){
            },
        });
    }
</script>

</body>
</html>
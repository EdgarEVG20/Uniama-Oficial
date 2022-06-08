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
        $breadcrumb = "Tablero / Mi Perfil / Informes";
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
                    <h1 class="h3 mb-2 text-gray-800">Informes</h1>

                    <!-- Formulario -->
                    <form class="form mt-3 mb-5" action="server/insert-adminInformes.php" method="POST">
                        <h1 class="h5 mb-2 text-gray-800">Agregar departamentos.</h1>
                        <input type="hidden" name="id" value="<?php echo $idEmpresa ?>">
                        <div class="row pt-3  pb-4">
                            <div class="col-12">
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre de Departamento" required>
                            </div>
                        </div>

                        <center><button type="submit" class="btn btn-primary">Agregar</button></center>
                    </form>

                    <!-- DataTales -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Registro de datos</h6>
                        </div>

                        <?php
                            $res = mysqli_query($conexion, "SELECT * FROM catalogo_departamentos WHERE id_empresa = $idEmpresa ORDER BY nombre ASC")
                        ?>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Estatus</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Estatus</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </tfoot>

                                        <?php
                                            while($data = mysqli_fetch_array($res)){
                                        ?>

                                    <tbody>
                                        <tr>
                                            <td><?php echo $data['nombre'] ?></td>
                                            <td class="btn-switch">
                                                <label class="switch">
                                                    <input type="checkbox" id="<?php echo $data['id_departamento']?>" name="btnSwitch" onclick="updateEstatus(<?php echo $data['id_departamento']?>,<?php echo $data['id_departamento']?>);" value="<?php echo $data['estatus']?>" <?php echo $data['estatus'] == '1' ? 'checked' : '2' ;?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td class="btn-eliminar">
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-departamento<?php echo $data['id_departamento']; ?>"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>

                                    <!-- Modal Para Eliminar Departamento -->
                                    <div class="modal fade" id="modal-delete-departamento<?php echo $data['id_departamento']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Departamento</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="server/delete-adminDepartamentos.php" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $data['id_departamento']?>">
                                                    <div class="modal-body">
                                                        <h5>¿Estás seguro de eliminar el departamento con el nombre: <?php echo $data['nombre']; ?>?</h5>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                                                        <button type="submit" class="btn btn-danger">Si</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

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
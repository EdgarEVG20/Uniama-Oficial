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
        $breadcrumb = "Tablero / Administrador / Catálogos / Documentos";
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
                    <h1 class="h3 mb-2 text-gray-800">Documentos</h1>

                    <!-- Formulario -->
                    <form class="form mt-3 mb-5" action="server/insert-documentos.php" method="POST">
                        <div class="row pt-3 pb-4">
                            <div class="col-12">
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required onkeyup="mayusculas(this)" maxlength="50">
                            </div>
                            <!--<div class="col">
                                <select class="form-control form-select-sm" id="vigencia" name="vigencia" required>
                                    <option value="#" disabled selected>Vigencia</option>
                                    <option value="1">Si</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                            <div class="col">
                                <select class="form-control form-select-sm" id="obligatorio" name="obligatorio" required>
                                    <option value="#" disabled selected>Obligatorio</option>
                                    <option value="1">Si</option>
                                    <option value="2">No</option>
                                </select>
                            </div>-->
                        </div>

                        <center><button type="submit" class="btn btn-primary">Agregar</button></center>
                    </form>

                    <!-- DataTales -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row justify-content-between">
                                <div class="col-6">
                                    <h6 class="m-0 font-weight-bold text-primary">Documentos Registrados</h6>
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="busqueda" name="busqueda" placeholder="Buscar..." onkeyup="cargarBusquedaDocumentos(); mayusculas(this)">
                                </div>
                            </div>
                        </div>

                        <?php
                            $res = mysqli_query($conexion, "SELECT * FROM _cat_documentos ORDER BY nombre ASC")
                        ?>

                        <div class="card-body">
                            <div class="table-responsive" id="mostrarTabla">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Estatus</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    
                                    <?php
                                        while($data = mysqli_fetch_array($res)){
                                    ?>

                                    <tbody>
                                        <tr>
                                            <td><?php echo $data['nombre'] ?></td>
                                            <td class="btn-switch">
                                                <label class="switch">
                                                    <input type="checkbox" id="<?php echo $data['id_documento']?>" name="btnSwitch" onclick="updateEstatus(<?php echo $data['id_documento']?>,<?php echo $data['id_documento']?>);" value="<?php echo $data['estatus']?>" <?php echo $data['estatus'] == '1' ? 'checked' : '2' ;?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td class="btn-modificar">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-edit-company<?php echo $data['id_documento']; ?>"><i class="fas fa-user-edit"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>

                                    <!-- Modal Para Modificar Documento -->
                                    <div class="modal fade" id="modal-edit-company<?php echo $data['id_documento']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modificar Documento</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="server/update-documentos.php" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $data['id_documento']?>">
                                                    <div class="modal-body">
                                                        <div class="col">
                                                            <div class="col mt-4">
                                                                <input type="text" class="form-control" name="nombre" placeholder="Nombre" value="<?php echo $data['nombre'] ?>"  onkeyup="mayusculas(this)">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-primary">Guardar cambios</button>
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
    } elseif (isset($usuario) && $nivelUsuario == 2 || $nivelUsuario == 3 || $nivelUsuario == 4) {
        header("location: panel2.php");
    }
    mysqli_close($conexion);
?>

<script language="JavaScript">
    function updateEstatus(idDocumento, nombreSwitch)
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
            data: {"id":idDocumento, "estado":cambioEstado, "idBD":'id_documento', "tablaBD":'_cat_documentos'},
            success:function(data){
            },
        });
    }
</script>

</body>
</html>
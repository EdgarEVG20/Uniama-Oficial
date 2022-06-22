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
        $breadcrumb = "Tablero / Configuración De Empresa / Empresa / Documentos";
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
                    <form class="form mt-3 mb-5" action="server/insert-adminDocumentos.php" method="POST">
                        <h1 class="h5 mb-2 text-gray-800">Agregar documentos.</h1>
                        <input type="hidden" name="id" value="<?php echo $idEmpresa ?>">
                        <div class="row pt-3">
                            <div class="col-11" id="option1" style="display: block;">
                                <select class="form-control" name="nombre1" required>
                                    <option value="#" disabled selected>Cat&aacute;logo General De Documentos</option>
                                    <?php
                                        $query = mysqli_query($conexion, "SELECT * FROM _cat_documentos WHERE estatus = 1 ORDER BY nombre ASC");
                                        while ($data = mysqli_fetch_assoc($query)){
                                    ?>
                                            <option value="<?php echo $data["nombre"]; ?>"><?php echo $data["nombre"]; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="col-11" id="option2" style="display: none;">
                                <input type="text" class="form-control" name="nombre2" placeholder="Nombre" onkeyup="mayusculas(this)" maxlength="50">
                            </div>

                            <div class="col-1">
                                <button type="button" class="btn btn-success" onclick="mostrarOcultar()"><i class="fas fa-plus"></i></button>
                            </div>
                        </div>
                        <div class="row pt-3 pb-4">
                            <div class="col-3">
                                <select class="form-control" id="vigencia" name="vigencia" required>
                                    <option value="#" disabled selected>Vigencia</option>
                                    <option value="1">Si</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" name="mesesVigencia" placeholder="No. Meses de Vigencia" min="0" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" maxlength="10">
                            </div>
                            <div class="col-3">
                                <select class="form-control" id="obligatorio" name="obligatorio" required>
                                    <option value="#" disabled selected>Obligatorio</option>
                                    <option value="1">Si</option>
                                    <option value="2">No</option>
                                    <option value="3">Administrador Decide</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <select class="form-control" id="visible" name="visible" required>
                                    <option value="#" disabled selected>Visible</option>
                                    <option value="1">Si</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                        </div>

                        <center><button type="submit" class="btn btn-primary">Agregar</button></center>
                    </form>

                    <!-- DataTales -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Documentos Registrados</h6>
                        </div>

                        <?php
                            $res = mysqli_query($conexion, "SELECT * FROM catalogo_documentos WHERE id_empresa = $idEmpresa ORDER BY nombre ASC")
                        ?>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Vigencia</th>
                                            <th>Tiempo de Vigencia</th>
                                            <th>Obligatorio</th>
                                            <th>Visible</th>
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
                                            <td>
                                                <?php
                                                    if ($data['vigencia'] == 1) {
                                                        echo "SI";
                                                    } elseif ($data['vigencia'] == 2) {
                                                        echo "NO";
                                                    } else {
                                                        echo "NO ESPECIFICADO";
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if ($data['meses_vigencia'] !== null && !empty($data['meses_vigencia'])) {
                                                        if ($data['meses_vigencia'] == 1) {
                                                            echo $data['meses_vigencia']." Mes";
                                                        } else {
                                                            echo $data['meses_vigencia']." Meses";
                                                        }
                                                    } else {
                                                        echo "N/A";
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if ($data['obligatorio'] == 1) {
                                                        echo "SI";
                                                    } elseif ($data['obligatorio'] == 2) {
                                                        echo "NO";
                                                    } elseif ($data['obligatorio'] == 3) {
                                                        echo "ADMINISTRADOR DECIDE";
                                                    } else {
                                                        echo "NO ESPECIFICADO";
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if ($data['visible'] == 1) {
                                                        echo "SI";
                                                    } elseif ($data['visible'] == 2) {
                                                        echo "NO";
                                                    } else {
                                                        echo "NO ESPECIFICADO";
                                                    }
                                                ?>
                                            </td>
                                            <td class="btn-switch">
                                                <label class="switch">
                                                    <input type="checkbox" id="<?php echo $data['id_documento']?>" name="btnSwitch" onclick="updateEstatus(<?php echo $data['id_documento']?>,<?php echo $data['id_documento']?>);" value="<?php echo $data['estatus']?>" <?php echo $data['estatus'] == '1' ? 'checked' : '2' ;?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td class="btn-eliminar">
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-documento<?php echo $data['id_documento']; ?>"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>

                                    <!-- Modal Para Eliminar Documento -->
                                    <div class="modal fade" id="modal-delete-documento<?php echo $data['id_documento']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Documento</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="server/delete-adminDocumentos.php" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $idEmpresa ?>">
                                                    <input type="hidden" name="idDocumento" value="<?php echo $data['id_documento']?>">
                                                    <div class="modal-body">
                                                        <h5>¿Estás seguro de eliminar el documento con el nombre: <?php echo $data['nombre']; ?>?</h5>
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
    } elseif (isset($usuario) && $nivelUsuario == 1 || $nivelUsuario == 3 || $nivelUsuario == 4) {
        header("location: panel2.php");
    }
    mysqli_close($conexion);
?>

<script language="JavaScript">
    function updateEstatus(idAdDocumentos, nombreSwitch)
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
            data: {"id":idAdDocumentos, "estado":cambioEstado, "idBD":'id_documento', "tablaBD":'catalogo_documentos'},
            success:function(data){
            },
        });
    };

    function mostrarOcultar(){
        var select = document.getElementById('option1');
        var input = document.getElementById('option2');

        if (select.style.display == 'block') {
            select.style.display = 'none';
            input.style.display = 'block';
        } else {
            select.style.display = 'block';
            input.style.display = 'none';
        }
    }
</script>

</body>
</html>
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
        $breadcrumb = "Tablero / Administrador / Catálogos / Régimen Fiscal";
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
                    <h1 class="h3 mb-2 text-gray-800">R&eacute;gimen Fiscal</h1>

                    <!-- Formulario -->
                    <form class="form mt-3 mb-5" action="server/insert-regimenFiscal.php" method="POST">
                        <div class="row pt-3 pb-4">
                            <div class="col-2">
                                <input type="text" class="form-control" name="clave" placeholder="Clave R&eacute;gimen" min="0" required onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" maxlength="3">
                            </div>
                            <div class="col">
                                <input type="text" class="form-control" name="descripcion" placeholder="Descripci&oacute;n" required onkeyup="mayusculas(this)" maxlength="250">
                            </div>
                            <div class="col-2">
                                <select class="form-control" name="persona" required maxlength="6">
                                    <option value="" disabled selected>Persona</option>
                                    <option value="FISICA">FISICA</option>
                                    <option value="MORAL">MORAL</option>
                                </select>
                            </div>
                        </div>

                        <center><button type="submit" class="btn btn-primary">Agregar</button></center>
                    </form>

                    <!-- DataTales -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row justify-content-between">
                                <div class="col-6">
                                    <h6 class="m-0 font-weight-bold text-primary">Reg&iacute;menes Fiscales Registrados</h6>
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="busqueda" name="busqueda" placeholder="Buscar..." onkeyup="cargarBusquedaRegimenFiscal(); mayusculas(this)">
                                </div>
                            </div>
                        </div>

                        <?php
                            $res = mysqli_query($conexion, "SELECT * FROM _cat_regimen_fiscal ORDER BY descripcion ASC")
                        ?>

                        <div class="card-body">
                            <div class="table-responsive" id="mostrarTabla">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Clave R&eacute;gimen Fiscal</th>
                                            <th>Descripci&oacute;n</th>
                                            <th>Persona</th>
                                            <th>Estatus</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    
                                    <?php
                                        while($data = mysqli_fetch_array($res)){
                                    ?>

                                    <tbody>
                                        <tr>
                                            <td><?php echo $data['clave_regimen'] ?></td>
                                            <td><?php echo $data['descripcion'] ?></td>
                                            <td><?php echo $data['persona'] ?></td>
                                            <td class="btn-switch">
                                                <label class="switch">
                                                    <input type="checkbox" id="<?php echo $data['id_regimen']?>" name="btnSwitch" onclick="updateEstatus(<?php echo $data['id_regimen']?>,<?php echo $data['id_regimen']?>);" value="<?php echo $data['estatus']?>" <?php echo $data['estatus'] == '1' ? 'checked' : '2' ;?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td class="btn-modificar">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-edit-company<?php echo $data['id_regimen']; ?>"><i class="fas fa-user-edit"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    
                                    <!-- Modal Para Modificar Regimen Fiscal -->
                                    <div class="modal fade" id="modal-edit-company<?php echo $data['id_regimen']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modificar R&eacute;gimen Fiscal</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="server/update-regimenFiscal.php" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $data['id_regimen']?>">
                                                    <div class="modal-body">
                                                        <div class="col">
                                                            <div class="col mt-4">
                                                                <input type="number" class="form-control" name="clave" placeholder="Clave" value="<?php echo $data['clave_regimen'] ?>" min="0">
                                                            </div>
                                                            <div class="col mt-4">
                                                                <input type="text" class="form-control" name="descripcion" placeholder="Descripci&oacute;n" value="<?php echo $data['descripcion'] ?>" onkeyup="mayusculas(this)">
                                                            </div>
                                                            <div class="col mt-4">
                                                                <select class="form-control" name="persona" required>
                                                                    <?php
                                                                        if ($data['persona'] == 'FISICA') {
                                                                    ?>
                                                                            <option value="" disabled>Persona</option>
                                                                            <option value="FISICA" selected>FISICA</option>
                                                                            <option value="MORAL">MORAL</option>
                                                                    <?php
                                                                        } elseif ($data['persona'] == 'MORAL') {
                                                                    ?>
                                                                            <option value="" disabled>Persona</option>
                                                                            <option value="FISICA">FISICA</option>
                                                                            <option value="MORAL" selected>MORAL</option>
                                                                    <?php
                                                                        } else {
                                                                    ?>
                                                                            <option value="" disabled selected>Persona</option>
                                                                            <option value="FISICA">FISICA</option>
                                                                            <option value="MORAL">MORAL</option>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                </select>
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
    function updateEstatus(idRegimenF, nombreSwitch)
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
            data: {"id": idRegimenF, "estado": cambioEstado, "idBD": 'id_regimen', "tablaBD": '_cat_regimen_fiscal'},
            success:function(data){
            },
        });
    }
</script>

</body>
</html>
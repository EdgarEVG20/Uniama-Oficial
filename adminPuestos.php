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
        $breadcrumb = "Tablero / Configuración De Empresa / Empresa / Puestos";
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
                    <h1 class="h3 mb-2 text-gray-800">Puestos</h1>

                    <!-- Formulario -->
                    <form class="form mt-3 mb-5" action="server/insert-adminPuestos.php" method="POST">
                        <h1 class="h5 mb-2 text-gray-800">Agregar puestos.</h1>
                        <input type="hidden" name="id" value="<?php echo $idEmpresa ?>">
                        <div class="row pt-3 pb-4">
                            <div class="col-6">
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required onkeyup="mayusculas(this)" maxlength="75">
                            </div>
                            <div class="col-6">
                                <select class="form-control form-select-sm" id="departamento" name="departamento" required>
                                    <option value="" disabled selected>Cat&aacute;logo De Departamentos</option>
                                    <?php
                                        $query = mysqli_query($conexion, "SELECT * FROM catalogo_departamentos WHERE id_empresa = '$idEmpresa' AND estatus = 1");
                                        while ($data = mysqli_fetch_assoc($query)){
                                    ?>
                                            <option value="<?php echo $data["id_departamento"]; ?>"><?php echo $data["nombre"]; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <center><button type="submit" class="btn btn-primary">Agregar</button></center>
                    </form>

                    <!-- DataTales -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Puestos Registrados</h6>
                        </div>

                        <?php
                            $res = mysqli_query($conexion, "SELECT catalogo_puestos.id_puesto, catalogo_departamentos.nombre, catalogo_puestos.nombre_puesto, catalogo_puestos.estatus FROM catalogo_puestos INNER JOIN catalogo_departamentos ON catalogo_puestos.id_departamento=catalogo_departamentos.id_departamento WHERE catalogo_puestos.id_empresa = $idEmpresa ORDER BY nombre_puesto ASC");
                        ?>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nombre Del Puesto</th>
                                            <th>Departamentos</th>
                                            <th>Estatus</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    
                                    <?php
                                        while($data = mysqli_fetch_array($res)){
                                    ?>

                                    <tbody>
                                        <tr>
                                            <td><?php echo $data['nombre_puesto'] ?></td>
                                            <td><?php echo $data['nombre'] ?></td>
                                            <td class="btn-switch">
                                                <label class="switch">
                                                    <input type="checkbox" id="<?php echo $data['id_puesto']?>" name="btnSwitch" onclick="updateEstatus(<?php echo $data['id_puesto']?>,<?php echo $data['id_puesto']?>);" value="<?php echo $data['estatus']?>" <?php echo $data['estatus'] == '1' ? 'checked' : '2' ;?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td class="btn-eliminar">
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-usuarios<?php echo $data['id_puesto']; ?>"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>

                                    <!-- Modal Para Eliminar Empleado -->
                                    <div class="modal fade" id="modal-delete-usuarios<?php echo $data['id_puesto']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Puesto</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="server/delete-adminPuestos.php" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $idEmpresa ?>">
                                                    <input type="hidden" name="idPuesto" value="<?php echo $data['id_puesto']?>">
                                                    <div class="modal-body">
                                                        <h5>¿Estás seguro de eliminar el puesto con el nombre: <?php echo $data['nombre_puesto']; ?>?</h5>
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
    function updateEstatus(idAdPuestos, nombreSwitch)
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
            data: {"id":idAdPuestos, "estado":cambioEstado, "idBD":'id_puesto', "tablaBD":'catalogo_puestos'},
            success:function(data){
            },
        });
    }
</script>

</body>
</html>
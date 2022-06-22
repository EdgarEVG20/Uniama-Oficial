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
        $breadcrumb = "Tablero / Administrador / Clientes / Mostrar Clientes";
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
                    <h1 class="h3 mb-2 text-gray-800">Mostrar Clientes</h1>

                    <!-- DataTales -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row justify-content-between">
                                <div class="col-6">
                                    <h6 class="m-0 font-weight-bold text-primary">Clientes Registrados</h6>
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="busqueda" name="busqueda" placeholder="Buscar..." onkeyup="cargarBusquedaClientes(); mayusculas(this)">
                                </div>
                            </div>
                        </div>

                        <?php
                            $res = mysqli_query($conexion, "SELECT * FROM empresas ORDER BY nombre_social ASC")
                        ?>
                        
                        <div class="card-body">
                            <div class="table-responsive" id="mostrarTabla">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>ID</th>
                                            <th>RFC</th>
                                            <th>Nombre Social</th>
                                            <th>Suscripci&oacute;n</th>
                                            <th>Precio</th>
                                            <th>Estatus</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>

                                    <?php
                                        while($data = mysqli_fetch_array($res)){
                                    ?>

                                    <tbody>
                                        <tr>
                                            <td><?php echo $data['id_empresa'] ?></td>
                                            <?php 
                                                $id = $data['id_empresa'];
                                                $folder = "Clientes/".$id."";
                                                if(!is_dir($folder)){
                                                    mkdir($folder);
                                                }
                                            ?>
                                            <td><?php echo $data['rfc'] ?></td>
                                            <td><?php echo $data['nombre_social'] ?></td>
                                            <td><?php echo $data['suscripcion']." Trabajadores" ?></td>
                                            <td><?php echo $data['precio'] ?></td>
                                            <td class="btn-switch">
                                                <label class="switch">
                                                    <input type="checkbox" id="<?php echo $data['id_empresa']?>" name="btnSwitch" onclick="updateEstatus(<?php echo $data['id_empresa']?>,<?php echo $data['id_empresa']?>);" value="<?php echo $data['estatus']?>" <?php echo $data['estatus'] == '1' ? 'checked' : '2' ;?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td class="btn-modificar">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-edit-company<?php echo $data['id_empresa']; ?>"><i class="fas fa-user-edit"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                    
                                    <!-- Modal Para Modificar Clientes/Empresa -->
                                    <div class="modal fade" id="modal-edit-company<?php echo $data['id_empresa']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modificar Cliente/Empresa</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="server/update-clientes.php" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $data['id_empresa']?>">
                                                    <div class="modal-body">
                                                        <div class="col">
                                                            <div class="col mt-4">
                                                                <select class="form-control" id="suscripcion<?php echo $data['id_empresa']; ?>" name="suscripcion" onchange="cargarPrecioSuscripcionModal(<?php echo $data['id_empresa']; ?>);" required>
                                                                    <?php
                                                                        if ($data['suscripcion'] == '1 - 40') {
                                                                    ?>
                                                                            <option value="" disabled>Suscripci&oacute;n</option>
                                                                            <option value="1 - 40" selected>1 - 40 Empleados</option>
                                                                            <option value="41 - 80">41 - 80 Empleados</option>
                                                                            <option value="+80">M&aacute;s 80 Empleados</option>
                                                                    <?php
                                                                        } elseif ($data['suscripcion'] == '41 - 80') {
                                                                    ?>
                                                                            <option value="" disabled>Suscripci&oacute;n</option>
                                                                            <option value="1 - 40">1 - 40 Empleados</option>
                                                                            <option value="41 - 80" selected>41 - 80 Empleados</option>
                                                                            <option value="+80">M&aacute;s 80 Empleados</option>
                                                                    <?php
                                                                        } elseif ($data['suscripcion'] == '+80') {
                                                                    ?>
                                                                            <option value="" disabled>Suscripci&oacute;n</option>
                                                                            <option value="1 - 40">1 - 40 Empleados</option>
                                                                            <option value="41 - 80">41 - 80 Empleados</option>
                                                                            <option value="+80" selected>M&aacute;s 80 Empleados</option>
                                                                    <?php
                                                                        } else {
                                                                    ?>
                                                                            <option value="" disabled selected>Suscripci&oacute;n</option>
                                                                            <option value="1 - 40">1 - 40 Empleados</option>
                                                                            <option value="41 - 80">41 - 80 Empleados</option>
                                                                            <option value="+80">M&aacute;s 80 Empleados</option>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            <div class="col mt-4">
                                                                <input type="number" class="form-control" id="precio<?php echo $data['id_empresa']; ?>" name="precio" placeholder="Precio Del Paquete" value="<?php echo $data['precio']; ?>" min="0">
                                                            </div>
                                                            <div class="col mt-4">
                                                                <input type="date" class="form-control" name="fecha" placeholder="Fecha" value="<?php echo $data['fecha'] ?>">
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
    function updateEstatus(idEmpresa, nombreSwitch)
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
            data: {"id": idEmpresa, "estado": cambioEstado, "idBD": 'id_empresa', "tablaBD": 'empresas'},
            success:function(data){
            },
        });
    }
</script>

</body>
</html>
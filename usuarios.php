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
        $breadcrumb = "Tablero / Usuarios / Mostrar Usuarios";
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
                    <h1 class="h3 mb-2 text-gray-800">Mostrar Usuarios</h1>

                    <!-- Formulario -->
                    <form class="form mt-3 mb-5" action="server/insert-usuarios.php" method="POST">
                        <h1 class="h5 mb-2 text-gray-800">Agregar Usuario.</h1>
                        <div class="row pt-3 pb-4">
                            <div class="col-6">
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre Completo" required onkeyup="mayusculas(this)" maxlength="75">
                            </div>
                            <div class="col-6">
                                <input type="text" class="form-control" id="correo" name="correo" placeholder="Correo" required onkeyup="minusculas(this)" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" maxlength="75">
                            </div>
                            <div class="col-12 pt-3">
                                <select class="form-control form-select-sm" id="empresa" name="empresa" required>
                                    <option value="#" disabled selected>Cat&aacute;logo De Empresas</option>
                                    <?php
                                        $query = mysqli_query($conexion, "SELECT * FROM empresas WHERE estatus = 1");
                                        while ($data = mysqli_fetch_assoc($query)){
                                    ?>
                                            <option value="<?php echo $data["id_empresa"]; ?>"><?php echo $data["nombre_comercial"]; ?></option>
                                            
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
                            <h6 class="m-0 font-weight-bold text-primary">Registro de datos</h6>
                        </div>

                        <?php
                            $res = mysqli_query($conexion, "SELECT usuarios.id_usuario, empresas.nombre_comercial, usuarios.nombre, usuarios.correo, usuarios.nivel, usuarios.nuevo, usuarios.estatus FROM usuarios INNER JOIN empresas ON usuarios.id_empresa=empresas.id_empresa WHERE nivel = 2 ORDER BY nombre ASC");
                        ?>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Empresa</th>
                                            <th>Nombre</th>
                                            <th>Correo</th>
                                            <th>Contraseña</th>
                                            <th>Estatus</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    
                                    <?php
                                        while($data = mysqli_fetch_array($res)){
                                    ?>

                                    <tbody>
                                        <tr>
                                            <td><?php echo $data['nombre_comercial'] ?></td>
                                            <td><?php echo $data['nombre'] ?></td>
                                            <td><?php echo $data['correo'] ?></td>
                                            <td class="btn-envioPassword">
                                                <a type="button" class="btn btn-success" href="server/envioPasswordUsuarios.php?idU=<?php echo $data['id_usuario']; ?>"><i class="fas fa-paper-plane"></i></a>
                                            </td>
                                            <td class="btn-switch">
                                                <label class="switch">
                                                    <input type="checkbox" id="<?php echo $data['id_usuario']?>" name="btnSwitch" onclick="updateEstatus(<?php echo $data['id_usuario']?>,<?php echo $data['id_usuario']?>);" value="<?php echo $data['estatus']?>" <?php echo $data['estatus'] == '1' ? 'checked' : '2' ;?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td class="btn-eliminar">
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-usuarios<?php echo $data['id_usuario']; ?>"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>

                                    <!-- Modal Para Eliminar Empleado -->
                                    <div class="modal fade" id="modal-delete-usuarios<?php echo $data['id_usuario']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Empleado</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="server/delete-usuarios.php" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $data['id_usuario']?>">
                                                    <div class="modal-body">
                                                        <h5>¿Estás seguro de eliminar el empleado con el nombre: <?php echo $data['nombre']; ?>?</h5>
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
    } elseif (isset($usuario) && $nivelUsuario == 2 || $nivelUsuario == 3 || $nivelUsuario == 4) {
        header("location: panel2.php");
    }
    mysqli_close($conexion);
?>

<script language="JavaScript">
    function updateEstatus(idUsuario, nombreSwitch)
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
            data: {"id":idUsuario, "estado":cambioEstado, "idBD":'id_usuario', "tablaBD":'usuarios'},
            success:function(data){
            },
        });
    }
</script>

</body>
</html>
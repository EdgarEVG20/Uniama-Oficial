<?php
    session_start();
    require("conexion.php");

    $usuario = $_SESSION['nombre_user'];
    $idEmpresa = $_SESSION['id_emisor_user'];
    $idUsuario = $_SESSION['id_user'];
    $nivelUsuario = $_SESSION['nivel_user'];

    if (!isset($usuario)){
        header("location: index.html");
    } elseif (isset($usuario) && $nivelUsuario == 2) {
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        $breadcrumb = "Tablero / Información De Colaboradores / Colaboradores";
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
                    <h1 class="h3 mb-2 text-gray-800">Colaboradores</h1>

                    <!-- Formulario -->
                    <form class="form mt-3 mb-5" action="server/insert-adminEmpleados.php" method="POST">
                        <h1 class="h5 mb-2 text-gray-800">Agregar Colaboradores.</h1>
                        <input type="hidden" name="id" value="<?php echo $idEmpresa ?>">
                        <div class="row pt-3 pb-4">
                            <div class="col-6">
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre Completo" required onkeyup="mayusculas(this)" maxlength="75">
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control" id="correo" name="correo" placeholder="Correo" required onkeyup="minuscula(this)" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" maxlength="75">
                            </div>
                            <div class="col-3">
                                <select class="form-control" name="tipoUsuario" required>
                                    <option value="" disabled selected>Tipo Usuario</option>
                                    <option value="2">Administrador</option>
                                    <option value="3">Supervisor</option>
                                    <option value="4">Colaborador</option>
                                </select>
                            </div>
                            <!--<div class="col-3 pt-3">
                                <input type="password" class="form-control" id="password" name="password" placeholder="Contrase単a" required>
                            </div>-->
                        </div>

                        <center><button type="submit" class="btn btn-primary">Agregar</button></center>
                    </form>

                    <!-- DataTales -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Colaboradores Registrados</h6>
                        </div>

                        <?php
                            $res = mysqli_query($conexion, "SELECT usuarios.id_usuario, usuarios.id_empresa, usuarios.nombre, usuarios.nivel, catalogo_departamentos.nombre AS nombreD, catalogo_puestos.nombre_puesto, usuarios.correo, usuarios.estatus FROM usuarios LEFT JOIN usuarios_perfiles ON usuarios.id_usuario = usuarios_perfiles.id_usuario AND usuarios.id_empresa = usuarios_perfiles.id_empresa LEFT JOIN catalogo_puestos ON usuarios_perfiles.il_puesto = catalogo_puestos.id_puesto AND usuarios_perfiles.id_empresa = catalogo_puestos.id_empresa LEFT JOIN catalogo_departamentos ON catalogo_puestos.id_departamento = catalogo_departamentos.id_departamento WHERE usuarios.id_empresa = $idEmpresa ORDER BY usuarios.nombre ASC");
                        ?>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Foto</th>
                                            <th>Nombre</th>
                                            <th>Nivel</th>
                                            <th style="width: 200px;">
                                                <input type="hidden" id="id" name="id" value="<?php echo $idEmpresa ?>">
                                                <select class="form-control" id="idDepartamento" name="idDepartamento" onchange="cargarDatosDepartamento()">
                                                    <option value="#" disabled selected>&Aacute;rea/Departamento</option>
                                                    <?php
                                                        $query = mysqli_query($conexion, "SELECT * FROM catalogo_departamentos WHERE id_empresa = $idEmpresa ORDER BY nombre ASC");
                                                        while ($data = mysqli_fetch_assoc($query)){
                                                                echo '<option value="'.$data['id_departamento'].'">'.$data["nombre"].'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </th>
                                            <th style="width: 170px;">
                                                <input type="hidden" id="id" name="id" value="<?php echo $idEmpresa ?>">
                                                <select class="form-control" id="idPuesto" name="idPuesto" onchange="cargarDatosPuesto()">
                                                    <option value="#" disabled selected>Cargo/Puesto</option>
                                                    <?php
                                                        $query = mysqli_query($conexion, "SELECT * FROM catalogo_puestos WHERE id_empresa = $idEmpresa ORDER BY nombre_puesto ASC");
                                                        while ($data = mysqli_fetch_assoc($query)){
                                                                echo '<option value="'.$data['id_puesto'].'" >'.$data["nombre_puesto"].'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </th>
                                            <!--<th>Correo</th>-->
                                            <th style="width: 150px;">
                                                <input type="hidden" id="id" name="id" value="<?php echo $idEmpresa ?>">
                                                <select class="form-control" id="estatus" name="estatus" onchange="cargarDatosEstatus()">
                                                    <option value="#" disabled selected>Estatus</option>
                                                    <option value="1">ACTIVO</option>
                                                    <option value="2">INACTIVO</option>
                                                </select>
                                            </th>
                                            <th colspan="2">Acciones</th>
                                        </tr>
                                    </thead>
                                    
                                    <tbody id="mostrarTabla">
                                    <?php
                                        while($data = mysqli_fetch_assoc($res)) {
                                            $condicion = $data['estatus'] == '1' ? 'checked' : '2';
                                            //$rfc = $data['ips_rfc'];
                                            $idUsuarioEmpresa = $data['id_usuario'];
                                            $foto = "Clientes/".$idEmpresa."/empleados/".$idUsuarioEmpresa."/imgPerfil/fotoPerfil.png";
                                            if (file_exists($foto)) {
                                                $img='<img class="fotoPerfilMiniaturaTabla rounded-circle" src="Clientes/'.$idEmpresa.'/empleados/'.$idUsuarioEmpresa.'/imgPerfil/fotoPerfil.png" alt="">';
                                            } else {
                                                $img='<img class="fotoPerfilMiniaturaTabla rounded-circle" src="Clientes/fotoTemp.png">';
                                            }
                                            if ($data['nivel'] == 2) {
                                                $nivel = "Administrador";
                                            } elseif ($data['nivel'] == 3) {
                                                $nivel = "Supervisor";
                                            } elseif ($data['nivel'] == 4) {
                                                $nivel = "Colaborador";
                                            } else {
                                                $nivel = "No especificado";
                                            }
                                            
                                            echo '
                                                <tr>
                                                    <td>'.$img.'</td>
                                                    <td>'.$data['nombre'].'</td>
                                                    <td>'.$nivel.'</td>
                                                    <td>'.$data['nombreD'].'</td>
                                                    <td>'.$data['nombre_puesto'].'</td>
                                                    <td class="btn-switch">
                                                        <label class="switch">
                                                            <input type="checkbox" id="'.$data['id_usuario'].'" name="btnSwitch" onclick="updateEstatus('.$data['id_usuario'].','.$data['id_usuario'].');" value="'.$data['estatus'].'" '.$condicion.'>
                                                            <span class="slider round"></span>
                                                        </label>
                                                    </td>
                                                    <td class="btn-modificar">
                                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-edit-empleado'.$data['id_usuario'].'"><i class="fas fa-user-edit"></i></button>
                                                    </td>
                                                    <td class="btn-ver">
                                                        <a type="button" class="btn btn-success" href="adminVerMiPerfilT.php?idU='.$data['id_usuario'].'"><i class="fas fa-eye"></i></a>
                                                    </td>
                                                </tr>
                                            ';
                                    ?>

                                    <!-- Modal Para Modificar Empleado-->
                                    <div class="modal fade" id="modal-edit-empleado<?php echo $data['id_usuario']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modificar Tipo De Usuario</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="server/update-adminEmpleados.php" method="POST">
                                                    <input type="hidden" name="id2" value="<?php echo $idEmpresa ?>">
                                                    <input type="hidden" name="idEmpleado2" value="<?php echo $data['id_usuario'] ?>">
                                                    <div class="modal-body">
                                                        <div class="col">
                                                            <div class="row pt-3 pb-4">
                                                                <div class="col-12 mt-3">
                                                                    <small>Tipo Usuario</small>
                                                                    <select class="form-control" name="tipoUsuario2" required>
                                                                        <?php
                                                                            if ($data['nivel'] == 2) {
                                                                        ?>
                                                                                <option value="" disabled>Tipo Usuario</option>
                                                                                <option value="2" selected>Administrador</option>
                                                                                <option value="3">Supervisor</option>
                                                                                <option value="4">Colaborador</option>
                                                                        <?php
                                                                            } elseif ($data['nivel'] == 3) {
                                                                        ?>
                                                                                <option value="" disabled>Tipo Usuario</option>
                                                                                <option value="2">Administrador</option>
                                                                                <option value="3" selected>Supervisor</option>
                                                                                <option value="4">Colaborador</option>
                                                                        <?php
                                                                            } elseif ($data['nivel'] == 4) {
                                                                        ?>
                                                                                <option value="" disabled>Tipo Usuario</option>
                                                                                <option value="2">Administrador</option>
                                                                                <option value="3">Supervisor</option>
                                                                                <option value="4" selected>Colaborador</option>
                                                                        <?php
                                                                            } else {
                                                                        ?>
                                                                                <option value="" disabled selected>Tipo Usuario</option>
                                                                                <option value="2">Administrador</option>
                                                                                <option value="3">Supervisor</option>
                                                                                <option value="4">Colaborador</option>
                                                                        <?php
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
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

                                    </tbody>
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
    function updateEstatus(idAdEmpleados, nombreSwitch)
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
            data: {"id":idAdEmpleados, "estado":cambioEstado, "idBD":'id_usuario', "tablaBD":'usuarios'},
            success:function(data){
            },
        });
    }
</script>

</body>
</html>
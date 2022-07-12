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
        $breadcrumb = "Tablero / Información De Colaboradores / Archivos";
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
                    <h1 class="h3 mb-2 text-gray-800">Archivos</h1>

                    <!-- DataTales -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <div class="row justify-content-between">
                                <div class="col-6">
                                    <h6 class="m-0 font-weight-bold text-primary">Archivos Registrados</h6>
                                </div>
                                <div class="col-4">
                                    <input type="text" class="form-control" id="busqueda" name="busqueda" placeholder="Buscar Por Nombre..." onkeyup="cargarBusquedaArchivosUsuarios(<?php echo $idEmpresa ?>); mayusculas(this)">
                                </div>
                            </div>
                        </div>

                        <?php
                            $res = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id_empresa = '$idEmpresa' AND estatus = 1 ORDER BY nombre ASC")
                        ?>

                        <div class="card-body">
                            <div class="table-responsive" id="mostrarTabla">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Foto</th>
                                            <th>Nombre</th>
                                            <th>Nivel</th>
                                            <th>Documentos</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>

                                    <?php
                                        while($data = mysqli_fetch_array($res)){
                                            $idUsuarioEmpresa = $data['id_usuario'];
                                    ?>

                                    <tbody>
                                        <tr>
                                            <td>
                                                <?php
                                                $foto = "Clientes/".$idEmpresa."/empleados/".$idUsuarioEmpresa."/imgPerfil/fotoPerfil.png";
                                                    if (file_exists($foto)) {
                                                ?>
                                                        <img class="fotoPerfilMiniaturaTabla rounded-circle" src="Clientes/<?php echo $idEmpresa ?>/empleados/<?php echo $idUsuarioEmpresa ?>/imgPerfil/fotoPerfil.png" alt=""><!--_--><?php //echo $rfc ?>
                                                <?php
                                                    } else {
                                                ?>
                                                        <img class="fotoPerfilMiniaturaTabla rounded-circle" src="Clientes/fotoTemp.png">
                                                <?php
                                                    }
                                                ?>
                                            </td>
                                            <td><?php echo $data['nombre'] ?></td>
                                            <td>
                                                <?php
                                                    if ($data['nivel'] == 2) {
                                                        echo "Administrador";
                                                    } elseif ($data['nivel'] == 3) {
                                                        echo "Supervisor";
                                                    } elseif ($data['nivel'] == 4) {
                                                        echo "Colaborador";
                                                    } else {
                                                        echo "No especificado";
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    $contadorDocs = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM archivos_documentos WHERE id_empresa = '$idEmpresa' AND id_usuario = '$idUsuarioEmpresa' AND estatus = 1"));
                                                    $contadorCatalagoDocs = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM catalogo_documentos WHERE id_empresa = '$idEmpresa' AND estatus = 1"));
                                                    echo $contadorDocs."/".$contadorCatalagoDocs;
                                                ?>
                                            </td>
                                            <td class="btn-ver">
                                                <a type="button" class="btn btn-success" href="adminVerArchivos.php?idU=<?php echo $data['id_usuario']; ?>"><i class="fas fa-eye"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>

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

<!-- <script language="JavaScript">
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
</script> -->

</body>
</html>
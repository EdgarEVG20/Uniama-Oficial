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
        $breadcrumb = "Tablero / Corporativo / Relacionar Empresas";
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
                    <h1 class="h3 mb-2 text-gray-800">Relacionar Empresas</h1>

                    <!-- Formulario -->
                    <form class="form mt-3 mb-5" action="server/insert-nuevoCorporativoEmpresa.php" method="POST">
                        <div class="row pt-3 pb-4">
                            <div class="col-6 pt-3">
                                <select class="form-control form-select-sm" id="corporativo" name="corporativo" required>
                                    <option value="#" disabled selected>Cat&aacute;logo De Corporativos</option>
                                    <?php
                                        $query = mysqli_query($conexion, "SELECT * FROM corporativo WHERE estatus = 1");
                                        while ($data = mysqli_fetch_assoc($query)){
                                    ?>
                                            <option value="<?php echo $data["id_corporativo"]; ?>"><?php echo $data["nombre"]; ?></option>
                                            
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-6 pt-3">
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
                            $res = mysqli_query($conexion, "SELECT corporativo_empresas.id_detalle, corporativo.nombre, empresas.nombre_comercial, corporativo_empresas.estatus FROM corporativo_empresas INNER JOIN corporativo ON corporativo_empresas.id_corporativo = corporativo.id_corporativo INNER JOIN empresas ON corporativo_empresas.id_empresa = empresas.id_empresa ORDER BY corporativo.nombre ASC");
                        ?>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Corporativo</th>
                                            <th>Empresa</th>
                                            <th>Estatus</th>
                                        </tr>
                                    </thead>
                                    
                                    <?php
                                        while($data = mysqli_fetch_array($res)){
                                    ?>

                                    <tbody>
                                        <tr>
                                            <td><?php echo $data['nombre'] ?></td>
                                            <td><?php echo $data['nombre_comercial'] ?></td>
                                            <td class="btn-switch">
                                                <label class="switch">
                                                    <input type="checkbox" id="<?php echo $data['id_detalle']?>" name="btnSwitch" onclick="updateEstatus(<?php echo $data['id_detalle']?>,<?php echo $data['id_detalle']?>);" value="<?php echo $data['estatus']?>" <?php echo $data['estatus'] == '1' ? 'checked' : '2' ;?>>
                                                    <span class="slider round"></span>
                                                </label>
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
    } elseif (isset($usuario) && $nivelUsuario == 2 || $nivelUsuario == 3 || $nivelUsuario == 4) {
        header("location: panel2.php");
    }
    mysqli_close($conexion);
?>

<script language="JavaScript">
    function updateEstatus(idCorporativoEmpresa, nombreSwitch)
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
            data: {"id":idCorporativoEmpresa, "estado":cambioEstado, "idBD":'id_detalle', "tablaBD":'corporativo_empresas'},
            success:function(data){
            },
        });
    }
</script>

</body>
</html>
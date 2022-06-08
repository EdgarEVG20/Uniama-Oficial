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
        $breadcrumb = "Tablero / Clientes / Nuevo Cliente";
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
                    <h1 class="h3 mb-2 text-gray-800">Nuevo Cliente</h1>

                    <!-- Formulario -->
                    <form class="form mt-3 mb-5" id="formNuevoCliente" action="server/insert-nuevoCliente.php" method="POST">
                        <div class="row pt-3">
                            <div class="col-3">
                                <input type="text" class="form-control" id="rfc" name="rfc" placeholder="RFC" required onkeyup="mayusculas(this)" maxlength="13">
                            </div>
                        </div>

                        <div class="row pt-3">
                            <div class="col-12">
                                <input type="text" class="form-control" id="nombreSocial" name="nombreSocial" placeholder="Nombre Social" required onkeyup="mayusculas(this)" maxlength="100">
                            </div>
                        </div>

                        <div class="row pt-3">
                            <div class="col-12">
                                <input type="text" class="form-control" id="nombreComercial" name="nombreComercial" placeholder="Nombre Comercial" required onkeyup="mayusculas(this)" maxlength="100">
                            </div>
                        </div>

                        <div class="row pt-4">
                            <div class="col-3 pt-3">
                                <input type="text" class="form-control" id="calle" name="calle" placeholder="Calle" required onkeyup="mayusculas(this)" maxlength="100">
                            </div>
                            <div class="col-3 pt-3">
                                <input type="text" class="form-control" id="noExt" name="noExt" placeholder="N&uacute;mero Exterior" required onkeyup="mayusculas(this)" maxlength="15">
                            </div>
                            <div class="col-3 pt-3">
                                <input type="text" class="form-control" id="noInt" name="noInt" placeholder="N&uacute;mero Interior" onkeyup="mayusculas(this)" maxlength="15">
                            </div>
                            <div class="col-3 pt-3">
                                <input type="text" class="form-control" id="codigoPostal" name="codigoPostal" placeholder="C&oacute;digo Postal" min="0" onkeyup="cargarColonias();" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required maxlength="5">
                            </div>
                            <div class="col-3 pt-3">
                                <select class="form-control" id="colonias" name="claveColonia" required disabled>
                                    <option selected>Colonias</option>
                                </select>
                            </div>
                            <div class="col-3 pt-3">
                                <select class="form-control" id="clavePais" name="clavePais" required disabled> <!-- onclick="cargarEstados();"-->
                                    <option value="" disabled selected>Paises</option>
                                    <!-- <?php
                                        // $query = mysqli_query($conexion, "SELECT * FROM _cat_pais WHERE estatus = 1");
                                        // while ($data = mysqli_fetch_assoc($query)){
                                    ?>
                                            <option value="<?php // echo $data["clave_pais"]; ?>"><?php // echo $data["nombre_pais"]; ?></option>
                                    <?php
                                        // }
                                    ?> -->
                                </select>
                            </div>
                            <div class="col-3 pt-3">
                                <select class="form-control" id="claveEstado" name="claveEstado" required disabled> <!-- onclick="cargarMunicipios();"-->
                                    <option selected>Estados</option>
                                </select>
                            </div>
                            <div class="col-3 pt-3">
                                <select class="form-control" id="municipios" name="claveMunicipio" required disabled>
                                    <option selected>Municipios</option>
                                </select>
                            </div>
                            <div class="col-12 pt-3">
                                <select class="form-control" id="claveRegimen" name="claveRegimen" required>
                                    <option value="" disabled selected>Reg&iacute;menes Fiscales</option>
                                    <?php
                                        $query = mysqli_query($conexion, "SELECT * FROM _cat_regimen_fiscal ORDER BY descripcion ASC");
                                        while ($data = mysqli_fetch_assoc($query)){
                                    ?>
                                            <option value="<?php echo $data["clave_regimen"]; ?>"><?php echo $data["descripcion"]; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <!--<div class="row pt-4">
                            <div class="col-12 pt-3">
                                <input type="text" class="form-control" id="sitioWeb" name="sitioWeb" placeholder="Sitio Web" required>
                            </div>
                            <div class="col-6 pt-3">
                                <input type="text" class="form-control" id="correo" name="correo" placeholder="Correo" required>
                            </div>
                            <div class="col-6 pt-3">
                                <input type="number" class="form-control" id="telefono" name="telefono" placeholder="Tel&eacute;fono" required>
                            </div>
                        </div>-->

                        <div class="row pt-4 pb-4">
                            <div class="col-6 pt-3">
                                <select class="form-control" id="suscripcion" name="suscripcion" onchange="cargarPrecioSuscripcion();" required>
                                    <option value="" disabled selected>Suscripci&oacute;n</option>
                                    <option value="1 - 40">1 - 40 Empleados</option>
                                    <option value="41 - 80">41 - 80 Empleados</option>
                                    <option value="+80">M&aacute;s 80 Empleados</option>
                                </select>
                            </div>
                            <!--<div class="col-6 pt-3">
                                <input type="text" class="form-control" id="suscripcion" name="suscripcion" placeholder="Suscripci&oacute;n" required>
                            </div>-->
                            <div class="col-6 pt-3">
                                <input type="number" class="form-control" id="precio" name="precio" placeholder="Precio" required min="0">
                            </div>
                            <div class="col-6 pt-3">
                                <input type="date" class="form-control" id="fecha" name="fecha" placeholder="Fecha" required>
                            </div>
                            <!--<div class="col-5 pt-3">
                                <input type="text" class="form-control" id="logo" name="logo" placeholder="Logo" required>
                            </div>
                            <div class="col-4 pt-3">
                                <input type="text" class="form-control" id="estatus" name="estatus" placeholder="Estatus" required>
                            </div>-->
                        </div>

                        <center><input type="submit" class="btn btn-primary" value="Agregar"></center>
                    </form>

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

</body>
</html>
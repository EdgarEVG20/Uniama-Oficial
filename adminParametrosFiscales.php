<?php
    session_start();
    require("conexion.php");

    header("Cache-Control: no-store, no-cache, must-revalidate");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");
    
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
        $breadcrumb = "Tablero / Configuración De Empresa / Empresa / Parámetros Fiscales";
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
                    <h1 class="h3 mb-2 text-gray-800">Par&aacute;metros Fiscales</h1>

                    <!-- Formulario -->
                    <form class="form mt-3 mb-5" action="server/update-adminParametrosFiscales.php" method="POST">
                        <h1 class="h5 mb-2 text-gray-800">Configurar R&eacute;gimen Fiscal.</h1>
                        <input type="hidden" name="id" value="<?php echo $idEmpresa ?>">

                        <?php
                            $dataEmpresa = mysqli_query($conexion, "SELECT * FROM empresas WHERE id_empresa = $idEmpresa");
                            $dataE = mysqli_fetch_assoc($dataEmpresa);
                        ?>

                        <div class="row pt-3">
                            <div class="col-3">
                                <input type="text" class="form-control" name="rfc" placeholder="RFC" value="<?php echo $dataE['rfc'] ?>" onkeyup="mayusculas(this)" maxlength="13">
                            </div>
                        </div>

                        <div class="row pt-3">
                            <div class="col-12">
                                <input type="text" class="form-control" name="nombreSocial" placeholder="Nombre Social" value="<?php echo $dataE['nombre_social'] ?>" onkeyup="mayusculas(this)" maxlength="100">
                            </div>
                        </div>

                        <div class="row pt-3">
                            <div class="col-12">
                                <input type="text" class="form-control" name="nombreComercial" placeholder="Nombre Comercial" value="<?php echo $dataE['nombre_comercial'] ?>" onkeyup="mayusculas(this)" maxlength="100">
                            </div>
                        </div>

                        <div class="row pt-4">
                            <div class="col-3 mt-4">
                                <input type="text" class="form-control" name="calle" placeholder="Calle" value="<?php echo $dataE['calle'] ?>" onkeyup="mayusculas(this)" maxlength="100">
                            </div>
                            <div class="col-3 mt-4">
                                <input type="text" class="form-control" name="noExt" placeholder="N&uacute;mero Exterior" value="<?php echo $dataE['noExt'] ?>" onkeyup="mayusculas(this)" maxlength="4">
                            </div>
                            <div class="col-3 mt-4">
                                <input type="text" class="form-control" name="noInt" placeholder="N&uacute;mero Interior" value="<?php echo $dataE['noInt'] ?>" onkeyup="mayusculas(this)" maxlength="4">
                            </div>
                            <div class="col-3 mt-4">
                                <input type="text" class="form-control" id="codigoPostal" name="codigoPostal" placeholder="C&oacute;digo Postal" min="0" onkeyup="cargarColonias();" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="<?php echo $dataE['codigo_postal'] ?>" maxlength="5">
                            </div>
                            <!--<div class="col-3 mt-4">
                                <select class="form-control" id="colonias" name="claveColonia" required disabled>
                                    <option selected>Colonias</option>
                                </select>
                            </div>-->
                            <div class="col-3 pt-3">
                                <select class="form-control" id="colonias" name="claveColonia">
                                    <option value="" disabled selected>Colonias</option>
                                    <?php
                                        $colonia = $dataE['clave_colonia'];
                                        $cp = $dataE['codigo_postal'];

                                        $query = mysqli_query($conexion, "SELECT * FROM _cat_colonias WHERE codigo_postal = '".$cp."' AND estatus = 1 ORDER BY nombre_colonia ASC");
                                        while ($data = mysqli_fetch_assoc($query)){
                                            $selected = '';
                                            if ($colonia == $data['clave_colonia']) {
                                                echo '<option value="'.$data['clave_colonia'].'" selected>'.$data["nombre_colonia"].'</option>';
                                            }
                                            else {
                                                echo '<option value="'.$data['clave_colonia'].'">'.$data["nombre_colonia"].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-3 pt-3">
                                <select class="form-control" id="clavePais" name="clavePais" onclick="cargarEstados();">
                                    <option value="" disabled selected>Pa&iacute;ses</option>
                                    <?php
                                        $pais = $dataE['clave_pais'];

                                        $query = mysqli_query($conexion, "SELECT * FROM _cat_pais WHERE estatus = 1 ORDER BY nombre_pais ASC");
                                        while ($data = mysqli_fetch_assoc($query)){
                                            $selected = '';
                                            if ($pais == $data['clave_pais']) {
                                                echo '<option value="'.$data['clave_pais'].'" selected>'.$data["nombre_pais"].'</option>';
                                            }
                                            else {
                                                echo '<option value="'.$data['clave_pais'].'">'.$data["nombre_pais"].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-3 pt-3">
                                <select class="form-control" id="claveEstado" name="claveEstado" onclick="cargarMunicipios();">
                                    <option value="" disabled selected>Estados</option>
                                    <?php
                                        $estado = $dataE['clave_estado'];

                                        $query = mysqli_query($conexion, "SELECT * FROM _cat_estados WHERE clave_pais = '".$pais."' AND estatus = 1 ORDER BY estado ASC");
                                        while ($data = mysqli_fetch_assoc($query)){
                                            $selected = '';
                                            if ($estado == $data['catalogo']) {
                                                echo '<option value="'.$data['catalogo'].'" selected>'.$data["estado"].'</option>';
                                            }
                                            else {
                                                echo '<option value="'.$data['catalogo'].'">'.$data["estado"].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-3 pt-3">
                                <select class="form-control" id="municipios" name="claveMunicipio">
                                    <option value="" disabled selected>Municipios</option>
                                    <?php
                                        $municipio = $dataE['clave_municipio'];
                                        $estado = $dataE['clave_estado'];

                                        $query = mysqli_query($conexion, "SELECT * FROM _cat_municipios WHERE clave_estado =  '".$estado."' AND estatus = 1 ORDER BY nombre_municipio ASC");
                                        while ($data = mysqli_fetch_assoc($query)){
                                            $selected = '';
                                            if ($municipio == $data['clave_municipio']) {
                                                echo '<option value="'.$data['clave_municipio'].'" selected>'.$data["nombre_municipio"].'</option>';
                                            }
                                            else {
                                                echo '<option value="'.$data['clave_municipio'].'">'.$data["nombre_municipio"].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="col-12 pt-3">
                                <select class="form-control" id="claveRegimen" name="claveRegimen">
                                    <option value="" disabled selected>Reg&iacute;menes Fiscales</option>
                                    <?php
                                        $regimen = $dataE['clave_regimen'];

                                        $query = mysqli_query($conexion, "SELECT * FROM _cat_regimen_fiscal ORDER BY descripcion ASC");
                                        while ($data = mysqli_fetch_assoc($query)){
                                            $selected = '';
                                            if ($regimen == $data['clave_regimen']) {
                                                echo '<option value="'.$data['clave_regimen'].'" selected>'.$data["descripcion"].'</option>';
                                            }
                                            else {
                                                echo '<option value="'.$data['clave_regimen'].'">'.$data["descripcion"].'</option>';
                                            }
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="row pt-4 pb-4">
                            <div class="col-12 mt-4">
                                <input type="text" class="form-control" name="sitioWeb" placeholder="Sitio Web" value="<?php echo $dataE['sitio_web'] ?>" onkeyup="minusculas(this)" maxlength="75">
                            </div>
                            <div class="col-6 pt-3">
                                <input type="text" class="form-control" name="correo" placeholder="Correo" value="<?php echo $dataE['correo'] ?>" onkeyup="minusculas(this)" maxlength="75">
                            </div>
                            <div class="col-6 pt-3">
                                <input type="text" class="form-control" name="telefono" placeholder="Tel&eacute;fono" value="<?php echo $dataE['telefono'] ?>" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" maxlength="10">
                            </div>
                        </div>

                        <center><button type="submit" class="btn btn-primary">Actualizar</button></center>

                    </form>


                    <!-- Formulario Para Subir Logo -->
                    <form class="form mt-3 mb-5" action="server/update-adminParametrosFiscalesLogo.php" method="POST" enctype="multipart/form-data">
                        <h1 class="h5 mb-2 text-gray-800">Cambiar Logo.</h1>
                        <input type="hidden" name="id" value="<?php echo $idEmpresa ?>">

                        <div class="row pt-3 pb-4">
                            <div class="col-12">
                                <center>
                                <label class="input-group-btn">
                                    <span class="btn btn-primary btn-file">
                                        Seleccionar Logo Nuevo
                                        <input type="file" class="form-control" id="logo" name="archivo" hidden>
                                        
                                        <br clear="all"><br clear="all">
                                            <output id="miniaturas">
                                                <img src="Clientes/<?php echo $idEmpresa ?>/imgEmpresa/logo.png"  width="40%" height="15%">
                                            </output>
                                        <br clear="all"><br clear="all">
                                    </span>
                                </label>
                                </center>
                            </div>
                        </div>
                        
                        <center>
                            <button type="submit" class="btn btn-primary" name="subir">Actualizar</button><br><br>
                            <h6>Especificaciones:</h6>
                            <small>Formatos V&aacute;lidos: PNG, JPG y JPEG.</small><br>
                            <small>Peso del Logo: 500kb.</small>
                        </center>
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
    } elseif (isset($usuario) && $nivelUsuario == 1 || $nivelUsuario == 3 || $nivelUsuario == 4) {
        header("location: panel2.php");
    }
    mysqli_close($conexion);
?>

<script type="text/javascript">
// Código para visualizar la miniatura de la imagen
    function handleFileSelect(evt) {
        var files = evt.target.files;
        for (var i = 0, f; f = files[i]; i++) {
            if (!f.type.match('image.*')) {
                continue;
            }
        
            var reader = new FileReader();
            reader.onload = (function(theFile) {
                return function(e) {
                var span = document.createElement('span');
                span.innerHTML = ['<img class="img_galeria" src="', e.target.result, '" title="', escape(theFile.name), '"/>'].join('');
                document.getElementById('miniaturas').insertBefore(span, null);
                };
            })(f);
        reader.readAsDataURL(f);
        }
    }
    document.getElementById('logo').addEventListener('change', handleFileSelect, false);
</script>

</body>
</html>
<?php
    session_start();
    require("conexion.php");

    $usuario = $_SESSION['nombre_user'];
    $idEmpresa = $_SESSION['id_emisor_user'];
    $idUsuario = $_SESSION['id_user'];
    $nivelUsuario = $_SESSION['nivel_user'];

    if (!isset($usuario)){
        header("location: index.html");
    } elseif (isset($usuario) && $nivelUsuario == 2 || $nivelUsuario == 3 || $nivelUsuario == 4) {
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        $breadcrumb = "Tablero / Mis Datos / Información";
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
                    <h1 class="h3 mb-2 text-gray-800">Mi Perfil</h1><br>
                    <div class="row">
                        <div class="col">
                            <ul class="nav nav-tabs">
                                <li class="nav-item">
                                    <a href="#FP" class="nav-link active" role="tab" data-toggle="tab">Foto De Perfil</a>
                                </li>

                                <li class="nav-item">
                                    <a href="#IPB" class="nav-link" role="tab" data-toggle="tab">Información Personal Básica</a>
                                </li>
                                
                                <li class="nav-item">
                                    <a href="#IPS" class="nav-link" role="tab" data-toggle="tab">Información Personal Secundaria</a>
                                </li>

                                <li class="nav-item">
                                    <a href="#IDE" class="nav-link" role="tab" data-toggle="tab">Información De Emergencia</a>
                                </li>

                                <li class="nav-item">
                                    <a href="#IL" class="nav-link" role="tab" data-toggle="tab">Informacion Laboral</a>
                                </li>
                            </ul>


                            <div class="tab-content">
                                <div role="tabpanel" class="tab-pane show active" id="FP">
                                    <div class="divLogo">
                                        <!-- Formulario FP = Foto Perfil -->
                                        <form class="form mt-3 mb-5" action="server/update-tPerfilLogo.php" method="POST" enctype="multipart/form-data">
                                            <h1 class="h5 mb-2 text-gray-800">Cambiar Foto de Perfil.</h1>
                                            <input type="hidden" name="id" value="<?php echo $idEmpresa ?>">
                                            <input type="hidden" name="idU" value="<?php echo $idUsuario ?>">

                                            <?php
                                                $dataUsuario = mysqli_query($conexion, "SELECT * FROM usuarios_perfiles WHERE id_empresa = $idEmpresa AND id_usuario = $idUsuario");
                                                $dataU = mysqli_fetch_assoc($dataUsuario);
                                                //$rfc = $dataU['ips_rfc'];
                                            ?>

                                            <div class="row pt-3 pb-4">
                                                <div class="col-12">
                                                    <center>
                                                    <label class="input-group-btn">
                                                        <span class="btn btn-primary btn-file">
                                                            Seleccionar Foto Nueva
                                                            <input type="file" class="form-control" id="logo" name="archivo" hidden>
                                                            
                                                            <br clear="all"><br clear="all">
                                                                <output id="miniaturas">
                                                                    <?php
                                                                        $foto = "Clientes/".$idEmpresa."/empleados/".$idUsuario."/imgPerfil/fotoPerfil.png";
                                                                        if (file_exists($foto)) {
                                                                    ?>
                                                                            <img class="fotoPerfilMiniatura" src="Clientes/<?php echo $idEmpresa ?>/empleados/<?php echo $idUsuario ?>/imgPerfil/fotoPerfil.png" alt=""><!--_--><?php //echo $rfc ?>
                                                                    <?php
                                                                        } else {
                                                                    ?>
                                                                            <img class="fotoPerfilMiniatura" src="Clientes/fotoTemp.png">
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                </output>
                                                            <br clear="all"><br clear="all">
                                                        </span>
                                                    </label>
                                                    </center>
                                                </div>
                                            </div>

                                            <center>
                                                <button type="submit" class="btn btn-primary" name="subir">Guardar</button><br><br>
                                                <h6>Especificaciones:</h6>
                                                <small>Formatos Válidos: PNG, JPG y JPEG.</small><br>
                                                <small>Peso de la Foto de Perfil: 500kb.</small>
                                            </center>
                                        </form>
                                    </div>
                                </div>

<!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->

                                <div role="tabpanel" class="tab-pane fade" id="IPB">
                                    <!-- Formulario IPB = Información Personal Básica -->
                                    <form class="form mt-3 mb-5" action="server/insert-tMiPerfilIPB.php" method="POST">
                                        <h1 class="h5 mb-2 text-gray-800">Informaci&oacute;n Personal B&aacute;sica.</h1>
                                        <input type="hidden" name="id" value="<?php echo $idEmpresa ?>">
                                        <input type="hidden" name="idU" value="<?php echo $idUsuario ?>">

                                        <?php
                                            $dataPerfil = mysqli_query($conexion, "SELECT * FROM usuarios_perfiles WHERE id_empresa = $idEmpresa AND id_usuario = $idUsuario");
                                            $dataU = mysqli_fetch_assoc($dataPerfil);

                                            $dataUsuario = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id_empresa = $idEmpresa AND id_usuario = $idUsuario");
                                            $dataUsuario = mysqli_fetch_assoc($dataUsuario);
                                        ?>

                                        <div class="row pt-3 pb-4">
                                            <div class="col-6">
                                                <small>Nombre Completo *</small>
                                                <input type="text" class="form-control" name="nombreCompleto" placeholder="Nombre Completo" value="<?php echo $dataUsuario['nombre'] ?>" onkeyup="mayusculas(this)" required maxlength="75">
                                            </div>
                                            <div class="col-3">
                                                <small>Correo Electr&oacute;nico *</small>
                                                <input type="text" class="form-control" name="correoElectronico" placeholder="Correo Electr&oacute;nico" value="<?php echo $dataUsuario['correo'] ?>" required maxlength="75">
                                            </div>
                                            <div class="col-3">
                                                <small>Contraseña *</small>
                                                <input type="password" class="form-control" name="password" placeholder="Contraseña" value="<?php echo $dataUsuario['password'] ?>" onkeyup="minusculas(this)" required maxlength="20">
                                            </div>
                                            <div class="col-3 pt-2">
                                                <small>Fecha De Nacimiento</small>
                                                <input type="date" class="form-control" name="fechaNacimiento" placeholder="Fecha De Nacimiento" value="<?php echo $dataU['ipb_fecha_nacimiento'] ?>">
                                            </div>
                                            <div class="col-3 pt-2">
                                                <small>G&eacute;nero</small>
                                                <select class="form-control" name="genero">
                                                    <?php 
                                                        $consulta = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM usuarios_perfiles WHERE id_usuario = '$idU'"));
                                                    
                                                        if ($dataU['ipb_genero'] == 'M') {
                                                    ?>
                                                            <option value="#" disabled>G&eacute;nero</option>
                                                            <option value="M" selected>Masculino</option>
                                                            <option value="F">Femenino</option>
                                                    <?php
                                                        } elseif ($dataU['ipb_genero'] == 'F') {
                                                    ?>
                                                            <option value="#" disabled>G&eacute;nero</option>
                                                            <option value="M">Masculino</option>
                                                            <option value="F" selected>Femenino</option>
                                                    <?php
                                                        } else {
                                                    ?>
                                                            <option value="#" disabled selected>G&eacute;nero</option>
                                                            <option value="M">Masculino</option>
                                                            <option value="F">Femenino</option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-3 pt-2">
                                                <small>Tel&eacute;fono</small>
                                                <input type="text" class="form-control" name="telefono" placeholder="Tel&eacute;fono" value="<?php echo $dataU['ipb_telefono'] ?>" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" maxlength="10">
                                            </div>
                                            <div class="col-3 pt-2">
                                                <small>Nacionalidad</small>
                                                <input type="text" class="form-control" name="nacionalidad" placeholder="Nacionalidad" value="<?php echo $dataU['ipb_nacionalidad'] ?>" onkeyup="mayusculas(this)" maxlength="20">
                                            </div>
                                            <div class="col-6 pt-2">
                                                <small>Escolaridad</small>
                                                <select class="form-control" name="escolaridad">
                                                    <?php 
                                                        $consulta = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM usuarios_perfiles WHERE id_usuario = '$idU'"));
                                                    
                                                        if ($dataU['ipb_escolaridad'] == 'PRIMARIA') {
                                                    ?>
                                                            <option value="" disabled>ESCOLARIDAD</option>
                                                            <option value="PRIMARIA" selected>PRIMARIA</option>
                                                            <option value="SECUNDARIA">SECUNDARIA</option>
                                                            <option value="BACHILLERATO">BACHILLERATO</option>
                                                            <option value="LICENCIATURA">LICENCIATURA</option>
                                                            <option value="MAESTRIA">MAESTR&Iacute;A</option>
                                                            <option value="DOCTORADO">DOCTORADO</option>
                                                    <?php
                                                        } elseif ($dataU['ipb_escolaridad'] == 'SECUNDARIA') {
                                                    ?>
                                                            <option value="" disabled selected>ESCOLARIDAD</option>
                                                            <option value="PRIMARIA">PRIMARIA</option>
                                                            <option value="SECUNDARIA" selected>SECUNDARIA</option>
                                                            <option value="BACHILLERATO">BACHILLERATO</option>
                                                            <option value="LICENCIATURA">LICENCIATURA</option>
                                                            <option value="MAESTRIA">MAESTR&Iacute;A</option>
                                                            <option value="DOCTORADO">DOCTORADO</option>
                                                    <?php
                                                        } elseif ($dataU['ipb_escolaridad'] == 'BACHILLERATO') {
                                                    ?>
                                                            <option value="" disabled selected>ESCOLARIDAD</option>
                                                            <option value="PRIMARIA">PRIMARIA</option>
                                                            <option value="SECUNDARIA">SECUNDARIA</option>
                                                            <option value="BACHILLERATO" selected>BACHILLERATO</option>
                                                            <option value="LICENCIATURA">LICENCIATURA</option>
                                                            <option value="MAESTRIA">MAESTR&Iacute;A</option>
                                                            <option value="DOCTORADO">DOCTORADO</option>
                                                    <?php
                                                        } elseif ($dataU['ipb_escolaridad'] == 'LICENCIATURA') {
                                                    ?>
                                                            <option value="" disabled selected>ESCOLARIDAD</option>
                                                            <option value="PRIMARIA">PRIMARIA</option>
                                                            <option value="SECUNDARIA">SECUNDARIA</option>
                                                            <option value="BACHILLERATO">BACHILLERATO</option>
                                                            <option value="LICENCIATURA" selected>LICENCIATURA</option>
                                                            <option value="MAESTRIA">MAESTR&Iacute;A</option>
                                                            <option value="DOCTORADO">DOCTORADO</option>
                                                    <?php
                                                        } elseif ($dataU['ipb_escolaridad'] == 'MAESTRIA') {
                                                    ?>
                                                            <option value="" disabled selected>ESCOLARIDAD</option>
                                                            <option value="PRIMARIA">PRIMARIA</option>
                                                            <option value="SECUNDARIA">SECUNDARIA</option>
                                                            <option value="BACHILLERATO">BACHILLERATO</option>
                                                            <option value="LICENCIATURA">LICENCIATURA</option>
                                                            <option value="MAESTRIA" selected>MAESTR&Iacute;A</option>
                                                            <option value="DOCTORADO">DOCTORADO</option>
                                                    <?php
                                                        } elseif ($dataU['ipb_escolaridad'] == 'DOCTORADO') {
                                                    ?>
                                                            <option value="" disabled selected>ESCOLARIDAD</option>
                                                            <option value="PRIMARIA">PRIMARIA</option>
                                                            <option value="SECUNDARIA">SECUNDARIA</option>
                                                            <option value="BACHILLERATO">BACHILLERATO</option>
                                                            <option value="LICENCIATURA">LICENCIATURA</option>
                                                            <option value="MAESTRIA">MAESTR&Iacute;A</option>
                                                            <option value="DOCTORADO" selected>DOCTORADO</option>
                                                    <?php
                                                        } else {
                                                    ?>
                                                            <option value="" disabled selected>ESCOLARIDAD</option>
                                                            <option value="PRIMARIA">PRIMARIA</option>
                                                            <option value="SECUNDARIA">SECUNDARIA</option>
                                                            <option value="BACHILLERATO">BACHILLERATO</option>
                                                            <option value="LICENCIATURA">LICENCIATURA</option>
                                                            <option value="MAESTRIA">MAESTR&Iacute;A</option>
                                                            <option value="DOCTORADO">DOCTORADO</option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-6 pt-2">
                                                <small>&Aacute;rea O Carrera</small>
                                                <input type="text" class="form-control" name="areaCarrera" placeholder="&Aacute;rea O Carrera" value="<?php echo $dataU['ipb_area_carrera'] ?>" onkeyup="mayusculas(this)" maxlength="100">
                                            </div>
                                            <div class="col-3 pt-2">
                                                <small>Calle</small>
                                                <input type="text" class="form-control" name="calle" placeholder="Calle" value="<?php echo $dataU['ipb_calle'] ?>" onkeyup="mayusculas(this)" maxlength="35">
                                            </div>
                                            <div class="col-3 pt-2">
                                                <small>N&uacute;mero Exterior</small>
                                                <input type="text" class="form-control" name="numeroExt" placeholder="N&uacute;mero Exterior" value="<?php echo $dataU['ipb_no_exterior'] ?>" onkeyup="mayusculas(this)" maxlength="15">
                                            </div>
                                            <div class="col-3 pt-2">
                                                <small>N&uacute;mero Interior</small>
                                                <input type="text" class="form-control" name="numeroInt" placeholder="N&uacute;mero Interior" value="<?php echo $dataU['ipb_no_interior'] ?>" onkeyup="mayusculas(this)" maxlength="15">
                                            </div>
                                            <div class="col-3 pt-2">
                                                <small>C&oacute;digo Postal</small>
                                                <input type="text" class="form-control" id="codigoPostal" name="codigoPostal" placeholder="C&oacute;digo Postal" min="0" onkeyup="cargarColonias();" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="<?php echo $dataU['ipb_codigo_postal'] ?>" maxlength="5">
                                            </div>
                                            <div class="col-3 pt-2">
                                                <small>Colonia</small>
                                                <select class="form-control" id="colonias" name="claveColonia" disabled>
                                                    <option value="" disabled selected>Colonias</option>
                                                    <?php
                                                        $colonia = $dataU['ipb_colonia'];
                                                        $cp = $dataU['ipb_codigo_postal'];

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
                                            <div class="col-3 pt-2">
                                                <small>Pa&iacute;s</small>
                                                <select class="form-control" id="clavePais" name="clavePais" onclick="cargarEstados();" disabled>
                                                    <option value="" disabled selected>Pa&iacute;ses</option>
                                                    <?php
                                                        $pais = $dataU['ipb_pais'];

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
                                            <div class="col-3 pt-2">
                                                <small>Estado</small>
                                                <select class="form-control" id="claveEstado" name="claveEstado" onclick="cargarMunicipios();" disabled>
                                                    <option value="" disabled selected>Estados</option>
                                                    <?php
                                                        $estado = $dataU['ipb_estado'];

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
                                            <div class="col-3 pt-2">
                                                <small>Municipio</small>
                                                <select class="form-control" id="municipios" name="claveMunicipio" disabled>
                                                    <option value="" disabled selected>Municipios</option>
                                                    <?php
                                                        $municipio = $dataU['ipb_municipio'];

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
                                        </div>

                                        <center><button type="submit" class="btn btn-primary">Guardar</button></center>

                                    </form>
                                </div>

<!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->

                                <div role="tabpanel" class="tab-pane fade" id="IPS">
                                    <!-- Formulario IPS = Información Personal Secundaria -->
                                    <form class="form mt-3 mb-5" action="server/insert-tMiPerfilIPS.php" method="POST">
                                        <h1 class="h5 mb-2 text-gray-800">Informaci&oacute;n Personal Secundaria.</h1>
                                        <input type="hidden" name="id" value="<?php echo $idEmpresa ?>">
                                        <input type="hidden" name="idU" value="<?php echo $idUsuario ?>">

                                        <?php
                                            $dataUsuario = mysqli_query($conexion, "SELECT * FROM usuarios_perfiles WHERE id_empresa = $idEmpresa AND id_usuario = $idUsuario");
                                            $dataU = mysqli_fetch_assoc($dataUsuario);
                                        ?>

                                        <div class="row pt-3 pb-4">
                                            <div class="col-3">
                                                <small>N&uacute;mero de Identificaci&oacute;n</small>
                                                <input type="text" class="form-control" name="numeroIdentificacion" placeholder="N&uacute;mero de Identificaci&oacute;n" value="<?php echo $dataU['ips_no_identificacion'] ?>" onkeyup="mayusculas(this)" maxlength="35">
                                            </div>
                                            <div class="col-3">
                                                <small>RFC</small>
                                                <input type="text" class="form-control" name="rfc" placeholder="RFC" value="<?php echo $dataU['ips_rfc'] ?>" onkeyup="mayusculas(this)" maxlength="13">
                                            </div>
                                            <div class="col-3">
                                                <small>CURP</small>
                                                <input type="text" class="form-control" name="curp" placeholder="CURP" value="<?php echo $dataU['ips_curp'] ?>" onkeyup="mayusculas(this)" maxlength="18">
                                            </div>
                                            <div class="col-3">
                                                <small>N&uacute;mero de IMSS</small>
                                                <input type="text" class="form-control" name="numeroIMSS" placeholder="N&uacute;mero de IMSS" value="<?php echo $dataU['ips_no_imss'] ?>" onkeyup="mayusculas(this)" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" maxlength="11">
                                            </div>
                                        </div>

                                        <center><button type="submit" class="btn btn-primary">Guardar</button></center>

                                    </form>
                                </div>

<!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->

                                <div role="tabpanel" class="tab-pane fade" id="IDE">
                                    <!-- Formulario IDE = Información De Emergencia -->
                                    <form class="form mt-3 mb-5" action="server/insert-tMiPerfilIDE.php" method="POST">
                                        <h1 class="h5 mb-2 text-gray-800">Informaci&oacute;n De Emergencia.</h1>
                                        <input type="hidden" name="id" value="<?php echo $idEmpresa ?>">
                                        <input type="hidden" name="idU" value="<?php echo $idUsuario ?>">

                                        <?php
                                            $dataUsuario = mysqli_query($conexion, "SELECT * FROM usuarios_perfiles WHERE id_empresa = $idEmpresa AND id_usuario = $idUsuario");
                                            $dataU = mysqli_fetch_assoc($dataUsuario);
                                        ?>

                                        <div class="row pt-3 pb-4">
                                            <div class="col-6">
                                                <small>Contacto De Emergencia</small>
                                                <input type="text" class="form-control" name="contactoEmergencia" placeholder="Contacto De Emergencia" value="<?php echo $dataU['ide_contacto_emergencia'] ?>" onkeyup="mayusculas(this)" maxlength="75">
                                            </div>
                                            <div class="col-3">
                                                <small>Tel&eacute;fono De Emergencia</small>
                                                <input type="text" class="form-control" name="telefonoEmergencia" placeholder="Tel&eacute;fono De Emergencia" value="<?php echo $dataU['ide_telefono_emergencia'] ?>" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" maxlength="10">
                                            </div>
                                            <div class="col-3">
                                                <small>Tipo De Sangre</small>
                                                <input type="text" class="form-control" name="tipoSangre" placeholder="Tipo De Sangre" value="<?php echo $dataU['ide_tipo_sangre'] ?>" onkeyup="mayusculas(this)" maxlength="3">
                                            </div>
                                        </div>

                                        <center><button type="submit" class="btn btn-primary">Guardar</button></center>

                                    </form>
                                </div>

<!-- --------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- -->

                                <div role="tabpanel" class="tab-pane fade" id="IL">
                                    <!-- Formulario IL = Información Laboral -->
                                    <!-- <form class="form mt-3 mb-5" action="server/insert-tMiPerfilIL.php" method="POST"> -->
                                        <h1 class="h5 mb-2 text-gray-800">Informaci&oacute;n Laboral.</h1>
                                        <input type="hidden" name="id" value="<?php echo $idEmpresa ?>">
                                        <input type="hidden" name="idU" value="<?php echo $idUsuario ?>">

                                        <?php
                                            $dataUsuario = mysqli_query($conexion, "SELECT * FROM usuarios_perfiles WHERE id_empresa = $idEmpresa AND id_usuario = $idUsuario");
                                            $dataU = mysqli_fetch_assoc($dataUsuario);
                                        ?>

                                        <div class="row pt-3">
                                            <div class="col-6">
                                                <small>Equipo / &Aacute;rea / Departamento</small>
                                                <select class="form-control" id="idDepartamento" name="equipoAreaDepartamento" onclick="cargarPuestos();" disabled>
                                                    <option value="" disabled selected>Equipo / &Aacute;rea / Departamento</option>
                                                    <?php
                                                        $departamento = $dataU['il_departamento'];

                                                        $query = mysqli_query($conexion, "SELECT * FROM catalogo_departamentos WHERE id_empresa = '".$idEmpresa."' AND estatus = 1 ORDER BY nombre ASC");
                                                        while ($data = mysqli_fetch_assoc($query)){
                                                            $selected = '';
                                                            if ($departamento == $data['id_departamento']) {
                                                                echo '<option value="'.$data['id_departamento'].'" selected>'.$data["nombre"].'</option>';
                                                            }
                                                            else {
                                                                echo '<option value="'.$data['id_departamento'].'">'.$data["nombre"].'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-6">
                                                <small>Cargo / Puesto</small>
                                                <select class="form-control" id="puestos" name="cargoPuesto" disabled>
                                                    <option value="" disabled selected>Cargos / Puestos</option>
                                                    <?php
                                                        $cargo = $dataU['il_puesto'];

                                                        $query = mysqli_query($conexion, "SELECT * FROM catalogo_puestos WHERE id_departamento = '".$departamento."' AND id_empresa = '".$idEmpresa."' AND estatus = 1 ORDER BY nombre_puesto ASC");
                                                        while ($data = mysqli_fetch_assoc($query)){
                                                            $selected = '';
                                                            if ($cargo == $data['id_puesto']) {
                                                                echo '<option value="'.$data['id_puesto'].'" selected>'.$data["nombre_puesto"].'</option>';
                                                            }
                                                            else {
                                                                echo '<option value="'.$data['id_puesto'].'">'.$data["nombre_puesto"].'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-3 pt-2">
                                                <small>Fecha De Ingreso *</small>
                                                <input type="date" class="form-control" name="fechaIngreso" placeholder="Fecha De Ingreso" value="<?php echo $dataU['il_fecha_ingreso'] ?>" required disabled>
                                            </div>
                                            <div class="col-3 pt-2">
                                                <small>Fecha De Alta De IMSS *</small>
                                                <input type="date" class="form-control" name="fechaAltaIMSS" placeholder="Fecha De Alta De IMSS" value="<?php echo $dataU['il_fecha_alta_imss'] ?>" required disabled>
                                            </div>
                                        </div>
                                        <div class="row pb-4">
                                            <div class="col-6 pt-2">
                                                <small>Nombre De Banco</small>
                                                <input type="text" class="form-control" name="nombreBanco" placeholder="Nombre De Banco" value="<?php echo $dataU['il_nombre_banco'] ?>" onkeyup="mayusculas(this)" disabled maxlength="50">
                                            </div>
                                            <div class="col-3 pt-2">
                                                <small>N&uacute;mero De Cuenta</small>
                                                <input type="text" class="form-control" name="numeroCuenta" placeholder="N&uacute;mero De Cuenta" value="<?php echo $dataU['il_no_cuenta'] ?>" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" disabled maxlength="20">
                                            </div>
                                            <div class="col-3 pt-2">
                                                <small>Clabe Interbancaria</small>
                                                <input type="text" class="form-control" name="clabeInterbancaria" placeholder="Clabe Interbancaria" value="<?php echo $dataU['il_clabe_interbancaria'] ?>" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" disabled maxlength="20">
                                            </div>
                                        </div>

<!-- ------------------------------------------------------------------------- -->

                                        <h1 class="h5 mb-2 text-gray-800">Contrato Laboral.</h1>
                                        <div class="row pb-4">
                                            <div class="col-3">
                                                <small>Fecha De Inicio *</small>
                                                <input type="date" class="form-control" name="fechaInicio" placeholder="Fecha De Ingreso" value="<?php echo $dataU['cl_fecha_inicio'] ?>" required disabled>
                                            </div>
                                            <div class="col-3">
                                                <small>Fecha De Finalizaci&oacute;n</small>
                                                <input type="date" class="form-control" name="fechaFinalizacion" placeholder="Fecha De Finalizaci&oacute;n" value="<?php echo $dataU['cl_fecha_finalizacion'] ?>" disabled>
                                            </div>
                                            <div class="col-3">
                                                <small>FRECUENCIA DE PAGO</small>
                                                <select class="form-control" name="frecuenciaPago" disabled>
                                                    <?php 
                                                        $consulta = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM usuarios_perfiles WHERE id_usuario = '$idU'"));
                                                    
                                                        if ($dataU['cl_frecuencia_pago'] == 'SEMANAL') {
                                                    ?>
                                                            <option value="" disabled>FRECUENCIA DE PAGO</option>
                                                            <option value="SEMANAL" selected>N&Oacute;MINA SEMANAL</option>
                                                            <option value="CATORCENAL">N&Oacute;MINA CATORCENAL</option>
                                                            <option value="QUINCENAL">N&Oacute;MINA QUINCENAL</option>
                                                            <option value="MENSUAL">N&Oacute;MINA MENSUAL</option>
                                                    <?php
                                                        } elseif ($dataU['cl_frecuencia_pago'] == 'CATORCENAL') {
                                                    ?>
                                                            <option value="" disabled>FRECUENCIA DE PAGO</option>
                                                            <option value="SEMANAL">N&Oacute;MINA SEMANAL</option>
                                                            <option value="CATORCENAL" selected>N&Oacute;MINA CATORCENAL</option>
                                                            <option value="QUINCENAL">N&Oacute;MINA QUINCENAL</option>
                                                            <option value="MENSUAL">N&Oacute;MINA MENSUAL</option>
                                                    <?php
                                                        } elseif ($dataU['cl_frecuencia_pago'] == 'QUINCENAL') {
                                                    ?>
                                                            <option value="" disabled>FRECUENCIA DE PAGO</option>
                                                            <option value="SEMANAL">N&Oacute;MINA SEMANAL</option>
                                                            <option value="CATORCENAL">N&Oacute;MINA CATORCENAL</option>
                                                            <option value="QUINCENAL" selected>N&Oacute;MINA QUINCENAL</option>
                                                            <option value="MENSUAL">N&Oacute;MINA MENSUAL</option>
                                                    <?php
                                                        } elseif ($dataU['cl_frecuencia_pago'] == 'MENSUAL') {
                                                    ?>
                                                            <option value="" disabled>FRECUENCIA DE PAGO</option>
                                                            <option value="SEMANAL">N&Oacute;MINA SEMANAL</option>
                                                            <option value="CATORCENAL">N&Oacute;MINA CATORCENAL</option>
                                                            <option value="QUINCENAL">N&Oacute;MINA QUINCENAL</option>
                                                            <option value="MENSUAL" selected>N&Oacute;MINA MENSUAL</option>
                                                    <?php
                                                        } else {
                                                    ?>
                                                            <option value="" disabled selected>FRECUENCIA DE PAGO</option>
                                                            <option value="SEMANAL">N&Oacute;MINA SEMANAL</option>
                                                            <option value="CATORCENAL">N&Oacute;MINA CATORCENAL</option>
                                                            <option value="QUINCENAL">N&Oacute;MINA QUINCENAL</option>
                                                            <option value="MENSUAL">N&Oacute;MINA MENSUAL</option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-3">
                                                <small>Salario Diario</small>
                                                <input type="text" class="form-control" name="salarioDiario" placeholder="Salario Diario" value="<?php echo $dataU['cl_salario_diario'] ?>" disabled maxlength="10">
                                            </div>
                                            <div class="col-6 pt-2">
                                                <small>TIPO DE CONTRATO</small>
                                                <select class="form-control" name="tipoContrato" disabled>
                                                    <?php 
                                                        $consulta = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM usuarios_perfiles WHERE id_usuario = '$idU'"));
                                                        
                                                        if ($dataU['cl_tipo_contrato'] == 'cObraOTiempoDet') {
                                                    ?>
                                                            <option value="" disabled>TIPO DE CONTRATO</option>
                                                            <option value="cObraOTiempoDet" selected>CONTRATO PARA OBRA O TIEMPO DETERMINADO.</option>
                                                            <option value="cPorTemporada">CONTRATO POR TEMPORADA.</option>
                                                            <option value="cTiempoIndeterminado">CONTRATO POR TIEMPO INDETERMINADO.</option>
                                                            <option value="cSujPruebaOCapIni">CONTRATO SUJETO A PRUEBA O CAPACITACI&Oacute;N INICIAL.</option>
                                                            <option value="cInversionCapitalDet">CONTRATO POR INVERSI&Oacute;N DE CAPITAL DETERMINADO.</option>
                                                            <option value="cLey">CONTRATO LEY.</option>
                                                    <?php
                                                        } elseif ($dataU['cl_tipo_contrato'] == 'cPorTemporada') {
                                                    ?>
                                                            <option value="" disabled>TIPO DE CONTRATO</option>
                                                            <option value="cObraOTiempoDet">CONTRATO PARA OBRA O TIEMPO DETERMINADO.</option>
                                                            <option value="cPorTemporada" selected>CONTRATO POR TEMPORADA.</option>
                                                            <option value="cTiempoIndeterminado">CONTRATO POR TIEMPO INDETERMINADO.</option>
                                                            <option value="cSujPruebaOCapIni">CONTRATO SUJETO A PRUEBA O CAPACITACI&Oacute;N INICIAL.</option>
                                                            <option value="cInversionCapitalDet">CONTRATO POR INVERSI&Oacute;N DE CAPITAL DETERMINADO.</option>
                                                            <option value="cLey">CONTRATO LEY.</option>
                                                    <?php
                                                        } elseif ($dataU['cl_tipo_contrato'] == 'cTiempoIndeterminado') {
                                                    ?>
                                                            <option value="" disabled>TIPO DE CONTRATO</option>
                                                            <option value="cObraOTiempoDet">CONTRATO PARA OBRA O TIEMPO DETERMINADO.</option>
                                                            <option value="cPorTemporada">CONTRATO POR TEMPORADA.</option>
                                                            <option value="cTiempoIndeterminado" selected>CONTRATO POR TIEMPO INDETERMINADO.</option>
                                                            <option value="cSujPruebaOCapIni">CONTRATO SUJETO A PRUEBA O CAPACITACI&Oacute;N INICIAL.</option>
                                                            <option value="cInversionCapitalDet">CONTRATO POR INVERSI&Oacute;N DE CAPITAL DETERMINADO.</option>
                                                            <option value="cLey">CONTRATO LEY.</option>
                                                    <?php
                                                        } elseif ($dataU['cl_tipo_contrato'] == 'cSujPruebaOCapIni') {
                                                    ?>
                                                            <option value="" disabled>TIPO DE CONTRATO</option>
                                                            <option value="cObraOTiempoDet">CONTRATO PARA OBRA O TIEMPO DETERMINADO.</option>
                                                            <option value="cPorTemporada">CONTRATO POR TEMPORADA.</option>
                                                            <option value="cTiempoIndeterminado">CONTRATO POR TIEMPO INDETERMINADO.</option>
                                                            <option value="cSujPruebaOCapIni" selected>CONTRATO SUJETO A PRUEBA O CAPACITACI&Oacute;N INICIAL.</option>
                                                            <option value="cInversionCapitalDet">CONTRATO POR INVERSI&Oacute;N DE CAPITAL DETERMINADO.</option>
                                                            <option value="cLey">CONTRATO LEY.</option>
                                                    <?php
                                                        } elseif ($dataU['cl_tipo_contrato'] == 'cInversionCapitalDet') {
                                                    ?>
                                                            <option value="" disabled>TIPO DE CONTRATO</option>
                                                            <option value="cObraOTiempoDet">CONTRATO PARA OBRA O TIEMPO DETERMINADO.</option>
                                                            <option value="cPorTemporada">CONTRATO POR TEMPORADA.</option>
                                                            <option value="cTiempoIndeterminado">CONTRATO POR TIEMPO INDETERMINADO.</option>
                                                            <option value="cSujPruebaOCapIni">CONTRATO SUJETO A PRUEBA O CAPACITACI&Oacute;N INICIAL.</option>
                                                            <option value="cInversionCapitalDet" selected>CONTRATO POR INVERSI&Oacute;N DE CAPITAL DETERMINADO.</option>
                                                            <option value="cLey">CONTRATO LEY.</option>
                                                    <?php
                                                        } elseif ($dataU['cl_tipo_contrato'] == 'cLey') {
                                                    ?>
                                                            <option value="" disabled>TIPO DE CONTRATO</option>
                                                            <option value="cObraOTiempoDet">CONTRATO PARA OBRA O TIEMPO DETERMINADO.</option>
                                                            <option value="cPorTemporada">CONTRATO POR TEMPORADA.</option>
                                                            <option value="cTiempoIndeterminado">CONTRATO POR TIEMPO INDETERMINADO.</option>
                                                            <option value="cSujPruebaOCapIni">CONTRATO SUJETO A PRUEBA O CAPACITACI&Oacute;N INICIAL.</option>
                                                            <option value="cInversionCapitalDet">CONTRATO POR INVERSI&Oacute;N DE CAPITAL DETERMINADO.</option>
                                                            <option value="cLey" selected>CONTRATO LEY.</option>
                                                    <?php
                                                        } else {
                                                    ?>
                                                            <option value="" disabled selected>TIPO DE CONTRATO</option>
                                                            <option value="cObraOTiempoDet">CONTRATO PARA OBRA O TIEMPO DETERMINADO.</option>
                                                            <option value="cPorTemporada">CONTRATO POR TEMPORADA.</option>
                                                            <option value="cTiempoIndeterminado">CONTRATO POR TIEMPO INDETERMINADO.</option>
                                                            <option value="cSujPruebaOCapIni">CONTRATO SUJETO A PRUEBA O CAPACITACI&Oacute;N INICIAL.</option>
                                                            <option value="cInversionCapitalDet">CONTRATO POR INVERSI&Oacute;N DE CAPITAL DETERMINADO.</option>
                                                            <option value="cLey">CONTRATO LEY.</option>
                                                    <?php
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-6 pt-2">
                                                <small>Lugar De Trabajo / Oficina</small>
                                                <select class="form-control" name="lugarTrabajoOficina" disabled>
                                                    <option value="" disabled selected>Lugar De Trabajo / Oficina</option>
                                                    <?php
                                                        $oficina = $dataU['cl_oficina'];

                                                        $query = mysqli_query($conexion, "SELECT * FROM empresas_oficinas WHERE id_empresa = '".$idEmpresa."' AND estatus = 1 ORDER BY nombre_oficina ASC");
                                                        while ($data = mysqli_fetch_assoc($query)){
                                                            $selected = '';
                                                            if ($oficina == $data['id_oficina']) {
                                                                echo '<option value="'.$data['id_oficina'].'" selected>'.$data["nombre_oficina"].'</option>';
                                                            }
                                                            else {
                                                                echo '<option value="'.$data['id_oficina'].'">'.$data["nombre_oficina"].'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-6 pt-2">
                                                <small>Horario Laboral: *</small>
                                                <select class="form-control" name="horarioLaboral" disabled>
                                                    <option value="" disabled selected>Horario Laboral</option>
                                                    <?php
                                                        $horarioLaboral = $dataU['cl_horario_laboral'];

                                                        $query = mysqli_query($conexion, "SELECT * FROM horarios_laborales WHERE id_empresa = '".$idEmpresa."' AND estatus = 1 ORDER BY nombre_horario ASC");
                                                        while ($data = mysqli_fetch_assoc($query)){
                                                            $selected = '';
                                                            if ($horarioLaboral == $data['no_horario']) {
                                                                echo '<option value="'.$data['no_horario'].'" selected>'.$data["nombre_horario"].'</option>';
                                                            }
                                                            else {
                                                                echo '<option value="'.$data['no_horario'].'">'.$data["nombre_horario"].'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <!-- <div class="col-12 pt-2">
                                                <div class="row">
                                                    <div class="col-3">
                                                    <small>Horario Laboral: *</small>
                                                    </div>
                                                    <div class="col-3">
                                                        <small>Lunes a Viernes *</small>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <input type="time" class="form-control" title="Hora De Entrada" name="HLLunesViernes1" placeholder="Entrada" value="<?php // echo $dataU['cl_LaV_entrada'] ?>" required disabled>
                                                            </div>
                                                            <div class="col-6">
                                                                <input type="time" class="form-control" title="Hora De Salida" name="HLLunesViernes2" placeholder="Salida" value="<?php // echo $dataU['cl_LaV_salida'] ?>" required disabled>    
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <small>S&aacute;bado *</small>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <input type="time" class="form-control" title="Hora De Entrada" name="HLSabado1" placeholder="S&aacute;bado" value="<?php // echo $dataU['cl_S_entrada'] ?>" required disabled>
                                                            </div>
                                                            <div class="col-6">
                                                                <input type="time" class="form-control" title="Hora De Salida" name="HLSabado2" placeholder="S&aacute;bado" value="<?php // echo $dataU['cl_S_salida'] ?>" required disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-3">
                                                        <small>Domingo *</small>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <input type="time" class="form-control" title="Hora De Entrada" name="HLDomingo1" placeholder="Domingo" value="<?php // echo $dataU['cl_D_entrada'] ?>" required disabled>
                                                            </div>
                                                            <div class="col-6">
                                                                <input type="time" class="form-control" title="Hora De Salida" name="HLDomingo2" placeholder="Domingo" value="<?php // echo $dataU['cl_D_salida'] ?>" required disabled>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>

<!-- ------------------------------------------------------------------------- -->

                                        <h1 class="h5 mb-2 text-gray-800">Ausencias.</h1>
                                        <div class="row pb-4">
                                             <div class="col-6">
                                                <small>Supervisor De Ausencias</small>
                                                <select class="form-control" id="idSupervisorAusencias" name="supervisorAusencias" onclick="cargarPuestoYCorreoSupervisor();" disabled>
                                                    <option value="" disabled selected>Supervisor De Ausencias</option>
                                                    <?php
                                                        $supervisorAusencias = $dataU['a_supervisor_ausencias'];

                                                        $query = mysqli_query($conexion, "SELECT * FROM usuarios WHERE id_empresa = '".$idEmpresa."' AND estatus = 1 AND nivel = 3 ORDER BY nombre ASC");
                                                        while ($data = mysqli_fetch_assoc($query)){
                                                            $selected = '';
                                                            if ($supervisorAusencias == $data['id_usuario']) {
                                                                echo '<option value="'.$data['id_usuario'].'" selected>'.$data["nombre"].'</option>';
                                                            }
                                                            else {
                                                                echo '<option value="'.$data['id_usuario'].'">'.$data["nombre"].'</option>';
                                                            }
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                            <div class="col-6" id="puestoCorreoSupervisor">
                                                <div class="row">
                                                    <div class="col-6">
                                                        <small>Puesto</small>
                                                        <select class="form-control" name="puestoSupervisor" disabled>
                                                            <option value="" disabled selected>Puestos</option>
                                                            <?php
                                                                $puestoSupervisor = $dataU['a_puesto_supervisor'];

                                                                $query = mysqli_query($conexion, "SELECT * FROM catalogo_puestos WHERE id_empresa = '".$idEmpresa."' AND id_puesto = $puestoSupervisor");
                                                                while ($data = mysqli_fetch_assoc($query)){
                                                                    $selected = '';
                                                                    if ($puestoSupervisor == $data['id_puesto']) {
                                                                        echo '<option value="'.$data['id_puesto'].'" selected>'.$data["nombre_puesto"].'</option>';
                                                                    }
                                                                    else {
                                                                        echo '<option value="'.$data['id_puesto'].'">'.$data["nombre_puesto"].'</option>';
                                                                    }
                                                                }
                                                            ?>
                                                        </select>
                                                        <!--<input type="text" class="form-control" name="puestoSupervisor" placeholder="Puesto" value="<?php //echo $dataU['a_puesto_supervisor'] ?>" disabled>-->
                                                    </div>
                                                    <div class="col-6">
                                                        <small>Correo Electr&oacute;nico</small>
                                                        <input type="text" class="form-control" name="correoElectronicoSupervisor" placeholder="Correo Electr&oacute;nico" value="<?php echo $dataU['a_correo_supervisor'] ?>" disabled maxlength="75">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!--<center><button type="submit" class="btn btn-primary">Guardar</button></center>-->

                                    <!-- </form> -->
                                </div>

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
    } elseif (isset($usuario) && $nivelUsuario == 1) {
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
                span.innerHTML = ['<img class="img_fotoPerfil" src="', e.target.result, '" title="', escape(theFile.name), '"/>'].join('');
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
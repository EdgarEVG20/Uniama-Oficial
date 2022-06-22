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
        $breadcrumb = "Tablero / Mis Datos / Ausencias";
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
                    <h1 class="h3 mb-2 text-gray-800">Mis Ausencias</h1>
                    
                    <!-- Formulario -->
                    <form class="form mt-3 mb-5" action="server/insert-tAusencias.php" method="POST" enctype="multipart/form-data">
                        <h1 class="h5 mb-2 text-gray-800">Agregar ausencias.</h1>
                        <input type="hidden" name="id" value="<?php echo $idEmpresa ?>">
                        <input type="hidden" name="idU" value="<?php echo $idUsuario ?>">
                        <div class="row pt-3">
                            <div class="col-6">
                                <select class="form-control" name="nombreAusencia" required>
                                    <option value="#" disabled selected>Cat&aacute;logo General De Ausencias</option>
                                    <?php
                                        $query = mysqli_query($conexion, "SELECT * FROM catalogo_ausencias WHERE id_empresa = $idEmpresa AND estatus = 1 ORDER BY nombre ASC");
                                        while ($data = mysqli_fetch_assoc($query)){
                                    ?>
                                            <option value="<?php echo $data["id_ausencia"]; ?>"><?php echo $data["nombre"]; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>

                        </div>
                        <div class="row pt-3">
                            <div class="col-12">
                                <textarea class="form-control" name="motivo" placeholder="Motivo" maxlength="400" required rows="4" onkeyup="mayusculas(this)" maxlength="400"></textarea>
                            </div>
                        </div>
                        <div class="row pt-3 pb-4">
                            <div class="col-3">
                                <select class="form-control" name="tipo" required>
                                    <option value="" disabled selected>Tipo</option>
                                    <option value="1">Mismo Día</option>
                                    <option value="2">Días</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <input type="date" class="form-control" name="fechaInicio" required title="Fecha de Inicio">
                            </div>
                            <div class="col-3">
                                <input type="date" class="form-control" name="fechaFin" required title="Fecha Final">
                            </div>
                            <div class="col-3">
                                <label class="input-group-btn pointer">
                                    <span class="btn btn-primary btn-file" style="width: 298px; height: 38px;">
                                        Adjuntar Documento...
                                        <input type="file" class="form-control" name="archivo" hidden/>
                                    </span>
                                </label>
                            </div>
                        </div>

                        <center><button type="submit" class="btn btn-primary" name="guardarAusencia">Agregar</button></center>
                    </form>

                    <!-- DataTales -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Ausencias Registradas</h6>
                        </div>

                        <?php
                            $res = mysqli_query($conexion, "SELECT ausencias.id_ausencia, ausencias.id_empresa, ausencias.id_usuario, ausencias.id_cat_ausencia, catalogo_ausencias.nombre, ausencias.motivo, ausencias.tipo, ausencias.fecha_inicio, ausencias.fecha_fin, ausencias.archivo_adjunto, ausencias.estatus FROM ausencias INNER JOIN catalogo_ausencias ON ausencias.id_cat_ausencia = catalogo_ausencias.id_ausencia WHERE ausencias.id_empresa = $idEmpresa AND ausencias.id_usuario = $idUsuario ORDER BY catalogo_ausencias.nombre ASC");
                        ?>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nombre Ausencia</th>
                                            <th style="width: 350px;">Motivo</th>
                                            <th>Tipo</th>
                                            <th>Fecha Inicial</th>
                                            <th>Fecha Final</th>
                                            <th style="width: 80px;">Archivo Adjunto</th>
                                            <th style="width: 100px;">Proceso Aprobaci&oacute;n</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    
                                    <?php
                                        while($data = mysqli_fetch_array($res)){
                                            $fechaInicio = strtotime($data['fecha_inicio']);
                                            // $mesFI = DateTime::createFromFormat('!m', date("m", $fechaInicio));
                                            // $nombreMesFI = strftime("%B", $mesFI->getTimestamp());
                                            $diaFI = date("d", $fechaInicio);
                                            $mesFI = date("m", $fechaInicio);
                                            $añoFI = date("Y", $fechaInicio);

                                            $fechaFin = strtotime($data['fecha_fin']);
                                            // $mesFF = DateTime::createFromFormat('!m', date("m", $fechaFin));
                                            // $nombremesFF = strftime("%B", $mesFF->getTimestamp());
                                            $diaFF = date("d", $fechaFin);
                                            $mesFF = date("m", $fechaFin);
                                            $añoFF = date("Y", $fechaFin);
                                    ?>

                                    <tbody>
                                        <tr>
                                            <td><?php echo $data['nombre'] ?></td>
                                            <td><?php echo $data['motivo'] ?></td>
                                            <td>
                                                <?php
                                                    if ($data['tipo'] == 1) {
                                                        echo "Mismo Día";
                                                    } elseif ($data['tipo'] == 2) {
                                                        echo "Días";
                                                    } else {
                                                        echo "No especificado";
                                                    }
                                                ?>
                                            </td>
                                            <td><?php echo $diaFI.'-'.$mesFI.'-'.$añoFI ?></td>
                                            <td><?php echo $diaFF.'-'.$mesFF.'-'.$añoFF ?></td>
                                            <td>
                                                <?php
                                                    if ($data['archivo_adjunto'] == 1) {
                                                        echo "SI";
                                                    } elseif ($data['archivo_adjunto'] == 2) {
                                                        echo "NO";
                                                    } else {
                                                        echo "No especificado";
                                                    }
                                                ?>
                                            </td>
                                            <!--<td class="btn-switch">
                                                <label class="switch">
                                                    <input type="checkbox" id="<?php /*echo $data['id_ausencia']?>" name="btnSwitch" onclick="updateEstatus(<?php echo $data['id_ausencia']?>,<?php echo $data['id_ausencia']?>);" value="<?php echo $data['estatus']?>" <?php echo $data['estatus'] == '1' ? 'checked' : '2'*/ ;?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>-->
                                            <td>
                                                <center>
                                                    <?php
                                                        if ($data['estatus'] == 1) {
                                                    ?>
                                                            <i class="fas fa-clock fa-2x" style="color: orange;" title="En Proceso De Aprobación"t></i>
                                                    <?php
                                                        } elseif ($data['estatus'] == 2) {
                                                    ?>
                                                            <i class="fas fa-check fa-2x" style="color: green;" title="Aprobado"></i>
                                                    <?php
                                                        } elseif ($data['estatus'] == 3) {
                                                    ?>
                                                            <i class="fas fa-times fa-2x" style="color: red;" title="Rechazado"></i>
                                                    <?php
                                                        } else {
                                                            echo "No especificado";
                                                        }
                                                    ?>
                                                </center>
                                            </td>
                                            <td class="btn-modificar">
                                                <?php
                                                if ($data['estatus'] == 1) {
                                                ?>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-edit-ausencia<?php echo $data['id_ausencia']; ?>"><i class="fas fa-edit"></i></button>
                                                <?php
                                                } elseif ($data['estatus'] == 2 || $data['estatus'] == 3) {
                                                ?>
                                                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-edit-ausencia<?php echo $data['id_ausencia']; ?>" disabled><i class="fas fa-edit"></i></button>
                                                <?php
                                                }
                                                ?>
                                            </td>
                                            <!--<td class="btn-eliminar">
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-ausencia<?php //echo $data['id_ausencia']; ?>"><i class="fas fa-trash-alt"></i></button>
                                            </td>-->
                                        </tr>
                                    </tbody>

                                    <!-- Modal Para Modificar Oficina-->
                                    <div class="modal fade" id="modal-edit-ausencia<?php echo $data['id_ausencia']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modificar Ausencia</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="server/update-tAusencias.php" method="POST"  enctype="multipart/form-data">
                                                    <input type="hidden" name="id2" value="<?php echo $idEmpresa ?>">
                                                    <input type="hidden" name="idU2" value="<?php echo $idUsuario ?>">
                                                    <input type="hidden" name="idAusencia2" value="<?php echo $data['id_ausencia'] ?>">
                                                    <div class="modal-body">
                                                        <div class="col">
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <small>Cat&aacute;logo Ausencias</small>
                                                                    <select class="form-control" name="nombreAusencia2" required>
                                                                        <option value="" disabled selected>Cat&aacute;logo De Ausencias</option>
                                                                        <?php
                                                                        $idCatAusencia = $data['id_cat_ausencia'];

                                                                        $query = mysqli_query($conexion, "SELECT * FROM catalogo_ausencias WHERE id_empresa = $idEmpresa AND estatus = 1 ORDER BY nombre ASC");
                                                                            while ($dataAusencia = mysqli_fetch_assoc($query)){
                                                                                $selected = '';
                                                                                if ($idCatAusencia == $dataAusencia['id_ausencia']) {
                                                                                    echo '<option value="'.$dataAusencia['id_ausencia'].'" selected>'.$dataAusencia["nombre"].'</option>';
                                                                                }
                                                                                else {
                                                                                    echo '<option value="'.$dataAusencia['id_ausencia'].'">'.$dataAusencia["nombre"].'</option>';
                                                                                }
                                                                            }

                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12 mt-3">
                                                                    <small>Motivo</small>
                                                                    <textarea class="form-control" name="motivo2" placeholder="Motivo" maxlength="400" required rows="3" onkeyup="mayusculas(this)"><?php echo $data['motivo'] ?></textarea>
                                                                </div>
                                                                <div class="col-6 mt-3">
                                                                    <small>Tipo</small>
                                                                    <select class="form-control form-select-sm" name="tipo2" required>
                                                                    <?php
                                                                        if ($data['tipo'] == 1) {
                                                                    ?>
                                                                            <option value="" disabled>Tipo</option>
                                                                            <option value="1" selected>Mismo Día</option>
                                                                            <option value="2">Días</option>
                                                                    <?php
                                                                        } elseif ($data['tipo'] == 2) {
                                                                    ?>
                                                                            <option value="" disabled>Tipo</option>
                                                                            <option value="1">Mismo Día</option>
                                                                            <option value="2" selected>Días</option>
                                                                    <?php
                                                                        } else {
                                                                    ?>
                                                                            <option value="" disabled selected>Tipo</option>
                                                                            <option value="1">Mismo Día</option>
                                                                            <option value="2">Días</option>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                </select>
                                                                </div>
                                                                <div class="col-6 mt-3">
                                                                    <small>Fecha Inicio</small>
                                                                    <input type="date" class="form-control" name="fechaInicio2" placeholder="Fecha Inicio" value="<?php echo $data['fecha_inicio'] ?>">
                                                                </div>
                                                                <div class="col-6 mt-3">
                                                                    <small>Fecha Fin</small>
                                                                    <input type="date" class="form-control" name="fechaFin2" placeholder="Fecha Final" value="<?php echo $data['fecha_fin'] ?>">
                                                                </div>
                                                            </div>
                                                            <div class="row pb-4">
                                                                <div class="col-6 mt-3">
                                                                    <small>Comprobante</small>
                                                                    <label class="input-group-btn pointer">
                                                                        <span class="btn btn-primary btn-file" style="position: static; width: 441px; height: 38px;">
                                                                            Adjuntar Documento...
                                                                            <input type="file" class="form-control" name="archivo2" hidden/>
                                                                        </span>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-primary" name="guardarAusencia2">Guardar cambios</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- Modal Para Eliminar Ausencias de Trabajadores -->
                                    <!--<div class="modal fade" id="modal-delete-ausencia<?php /*echo $data['id_ausencia']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Ausencia</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="server/delete-tAusencias.php" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $idEmpresa ?>">
                                                    <input type="hidden" name="idU" value="<?php echo $idUsuario ?>">
                                                    <input type="hidden" name="idAusencia" value="<?php echo $data['id_ausencia']?>">
                                                    <input type="hidden" name="idCatAusencia" value="<?php echo $data['id_cat_ausencia']?>">
                                                    <input type="hidden" name="fechaInicio" value="<?php echo $data['fecha_inicio']?>">
                                                    <input type="hidden" name="fechaFin" value="<?php echo $data['fecha_fin']?>">
                                                    <div class="modal-body">
                                                        <h5>¿Estás seguro de eliminar tu ausencia con el nombre: <?php echo $data['nombre'];*/ ?>?</h5>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                                                        <button type="submit" class="btn btn-danger">Si</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>-->

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
    } elseif (isset($usuario) && $nivelUsuario == 1) {
        header("location: panel2.php");
    }
    mysqli_close($conexion);
?>

<!--<script language="JavaScript">
    function updateEstatus(idTrAusencias, nombreSwitch)
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
            data: {"id":idTrAusencias, "estado":cambioEstado, "idBD":'id_ausencia', "tablaBD":'ausencias'},
            success:function(data){
            },
        });
    }
</script>-->

</body>
</html>
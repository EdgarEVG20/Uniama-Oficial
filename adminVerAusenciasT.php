<?php
    session_start();
    require("conexion.php");

    $usuario = $_SESSION['nombre_user'];
    $idEmpresa = $_SESSION['id_emisor_user'];
    $idUsuario = $_SESSION['id_user'];
    $nivelUsuario = $_SESSION['nivel_user'];
    $idVerUsuario = $_GET["idU"];

    if (!isset($usuario)){
        header("location: index.html");
    } elseif (isset($usuario) && $nivelUsuario == 2 || $nivelUsuario == 3) {
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        $breadcrumb = "Tablero / Información De Colaboradores / Ver Ausencias";
        include("estructura/metas.php");
        include("estructura/title.php");
        include("estructura/hrefs.php");
    ?>
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
                    <h1 class="h3 mb-2 text-gray-800">Ver Ausencias</h1>
                    <br>

                    <?php
                        $nombreUsuario = mysqli_query($conexion, "SELECT nombre FROM usuarios WHERE id_usuario = $idVerUsuario");
                        $nombreU = mysqli_fetch_assoc($nombreUsuario);

                    ?>
                    <h1 class="h5 mb-2 text-gray-800">Trabajador: <?php echo $nombreU['nombre'] ?></h1>
                    <br>
                    <!-- DataTales -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Ausencias Registradas</h6>
                        </div>

                        <?php
                            $res = mysqli_query($conexion, "SELECT ausencias.id_ausencia, ausencias.id_empresa, ausencias.id_usuario, ausencias.id_cat_ausencia, catalogo_ausencias.nombre, ausencias.motivo, ausencias.tipo, ausencias.fecha_inicio, ausencias.fecha_fin, ausencias.archivo_adjunto, ausencias.estatus FROM ausencias INNER JOIN catalogo_ausencias ON ausencias.id_cat_ausencia = catalogo_ausencias.id_ausencia WHERE ausencias.id_empresa = $idEmpresa AND ausencias.id_usuario = $idVerUsuario ORDER BY ausencias.id_ausencia DESC");
                        ?>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nombre Ausencia</th>
                                            <th>Motivo</th>
                                            <th>Tipo</th>
                                            <th>Fecha Inicial</th>
                                            <th>Fecha Final</th>
                                            <th>Archivo Adjunto</th>
                                            <th>Proceso Aprobaci&oacute;n</th>
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
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-edit-tAusencia<?php echo $data['id_ausencia'] ?>"><i class="fas fa-edit"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>

                                    <!-- Modal Para Modificar Aprobación De Ausencia-->
                                    <div class="modal fade" id="modal-edit-tAusencia<?php echo $data['id_ausencia'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modificar Aprobaci&oacute;n De Ausencia</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="server/update-adminTAusencia.php" method="POST">
                                                    <input type="hidden" name="id2" value="<?php echo $idEmpresa ?>">
                                                    <input type="hidden" name="idVerUsuario2" value="<?php echo $data['id_usuario'] ?>">
                                                    <input type="hidden" name="idAusencia2" value="<?php echo $data['id_ausencia'] ?>">
                                                    <div class="modal-body">
                                                        <div class="col">
                                                            <?php
                                                                if ($data['archivo_adjunto'] == 1) {
                                                            ?>
                                                            <div class="row pt-3 pb-4">
                                                                <div class="col-10 mt-3">
                                                                    <small>Aprobaci&oacute;n</small>
                                                                    <select class="form-control" name="aprobacion2" required>
                                                                        <?php
                                                                            if ($data['estatus'] == 1) {
                                                                        ?>
                                                                                <option value="" disabled>Aprobaci&oacute;n</option>
                                                                                <option value="1" selected>En proceso de aprobación</option>
                                                                                <option value="2">Aprobada</option>
                                                                                <option value="3">Rechazada</option>
                                                                        <?php
                                                                            } elseif ($data['estatus'] == 2) {
                                                                        ?>
                                                                                <option value="" disabled>Aprobaci&oacute;n</option>
                                                                                <option value="1">En proceso de aprobación</option>
                                                                                <option value="2" selected>Aprobada</option>
                                                                                <option value="3">Rechazada</option>
                                                                        <?php
                                                                            } elseif ($data['estatus'] == 3) {
                                                                        ?>
                                                                                <option value="">Aprobaci&oacute;n</option>
                                                                                <option value="1">En proceso de aprobación</option>
                                                                                <option value="2">Aprobada</option>
                                                                                <option value="3" selected>Rechazada</option>
                                                                        <?php
                                                                            } else {
                                                                        ?>
                                                                                <option value="" disabled selected>Aprobaci&oacute;n</option>
                                                                                <option value="1">En proceso de aprobación</option>
                                                                                <option value="2">Aprobada</option>
                                                                                <option value="3">Rechazada</option>
                                                                        <?php
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                                <div class="col-2 mt-3">
                                                                    <br>
                                                                    <?php
                                                                        $idAusencia = $data['id_cat_ausencia'];
                                                                        $fechaInicio = $data['fecha_inicio'];
                                                                        $fechaFin = $data['fecha_fin'];
                                                                    ?>

                                                                    <button type="button" class="btn btn-success" name="verArchivo"  data-toggle="modal" data-target="#modal-ver-documento<?php echo $data['id_ausencia']; ?>"><i class="fas fa-eye"></i></button>

                                                                    <!-- <a type="button" class="btn btn-success" name="verArchivo" target="_blank" href="<?php //echo 'http://'.$_SERVER['HTTP_HOST'].'/11CuatrimestresEstadias/Proyecto/UniamaOficial/Clientes/'.$idEmpresa.'/empleados/'.$idVerUsuario.'/ausencias/'.$idAusencia.'_'.$fechaInicio.'_'.$fechaFin.'.pdf' ?>"><i class="fas fa-file-pdf"></i></a> -->
                                                                    
                                                                    <!-- LINEA DE CODIGO PARA MODO PRUEBA -->
                                                                    <!-- <a type="button" class="btn btn-success" name="verArchivo" target="_blank" href="<?php //echo 'http://'.$_SERVER['HTTP_HOST'].'/pruebas/Clientes/'.$idEmpresa.'/empleados/'.$idVerUsuario.'/ausencias/'.$idAusencia.'_'.$fechaInicio.'_'.$fechaFin.'.pdf' ?>"><i class="fas fa-file-pdf"></i></a> -->
                                                                    
                                                                    <!-- LINEA DE CODIGO PARA MODO PRODUCCIÓN -->
                                                                    <!-- <a type="button" class="btn btn-success" name="verArchivo" target="_blank" href="<?php //echo 'http://'.$_SERVER['HTTP_HOST'].'/Clientes/'.$idEmpresa.'/empleados/'.$idVerUsuario.'/ausencias/'.$idAusencia.'_'.$fechaInicio.'_'.$fechaFin.'.pdf' ?>"><i class="fas fa-file-pdf"></i></a> -->
                                                                </div>
                                                            </div>
                                                            <?php
                                                                } elseif ($data['archivo_adjunto'] == 2) {
                                                            ?>
                                                            <div class="row pt-3 pb-4">
                                                                <div class="col-12 mt-3">
                                                                    <small>Aprobaci&oacute;n</small>
                                                                    <select class="form-control" name="aprobacion2" required>
                                                                        <?php
                                                                            if ($data['estatus'] == 1) {
                                                                        ?>
                                                                                <option value="" disabled>Aprobaci&oacute;n</option>
                                                                                <option value="1" selected>En proceso de aprobación</option>
                                                                                <option value="2">Aprobada</option>
                                                                                <option value="3">Rechazada</option>
                                                                        <?php
                                                                            } elseif ($data['estatus'] == 2) {
                                                                        ?>
                                                                                <option value="" disabled>Aprobaci&oacute;n</option>
                                                                                <option value="1">En proceso de aprobación</option>
                                                                                <option value="2" selected>Aprobada</option>
                                                                                <option value="3">Rechazada</option>
                                                                        <?php
                                                                            } elseif ($data['estatus'] == 3) {
                                                                        ?>
                                                                                <option value="">Aprobaci&oacute;n</option>
                                                                                <option value="1">En proceso de aprobación</option>
                                                                                <option value="2">Aprobada</option>
                                                                                <option value="3" selected>Rechazada</option>
                                                                        <?php
                                                                            } else {
                                                                        ?>
                                                                                <option value="" disabled selected>Aprobaci&oacute;n</option>
                                                                                <option value="1">En proceso de aprobación</option>
                                                                                <option value="2">Aprobada</option>
                                                                                <option value="3">Rechazada</option>
                                                                        <?php
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <?php
                                                                }
                                                            ?>
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

                                    <!-- Modal Para Ver Documento Dentro Del Modal -->
                                    <div class="modal fade" id="modal-ver-documento<?php echo $data['id_ausencia']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel"><?php echo $data['nombre'] ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <object class="PDFdoc" width="100%" height="550px" type="application/pdf" data="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/11CuatrimestresEstadias/Proyecto/UniamaOficial/Clientes/'.$idEmpresa.'/empleados/'.$idVerUsuario.'/ausencias/'.$idAusencia.'_'.$fechaInicio.'_'.$fechaFin.'.pdf' ?>"></object>
                                                    
                                                    <!-- <object class="PDFdoc" width="100%" height="550px" type="application/pdf" data="<?php //echo 'Clientes/'.$idEmpresa.'/empleados/'.$idVerUsuario.'/ausencias/'.$idAusencia.'_'.$fechaInicio.'_'.$fechaFin.'.pdf' ?>"></object> -->
                                                    
                                                    <!-- <object class="PDFdoc" width="100%" height="550px" type="application/pdf" data="<?php //echo 'Clientes/'.$idEmpresa.'/empleados/'.$idVerUsuario.'/ausencias/'.$idAusencia.'_'.$fechaInicio.'_'.$fechaFin.'.pdf' ?>"></object> -->
                                                </div>
                                                <!-- <div class="modal-footer">
                                                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                                    <button type="submit" class="btn btn-danger">Si</button>
                                                </div> -->
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
    } elseif (isset($usuario) && $nivelUsuario == 1 || $nivelUsuario == 4) {
        header("location: panel2.php");
    }
    mysqli_close($conexion);
?>

</body>
</html>
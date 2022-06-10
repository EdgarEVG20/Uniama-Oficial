<?php
    session_start();
    require("conexion.php");

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
        $breadcrumb = "Tablero / Empresa / Horarios Laborales";
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
                    <h1 class="h3 mb-2 text-gray-800">Horarios Laborales</h1>

                    <!-- Formulario -->
                    <form class="form mt-3 mb-5" action="server/insert-adminHorariosLaborales.php" method="POST">
                        <h1 class="h5 mb-2 text-gray-800">Agregar horarios laborales.</h1>
                        <input type="hidden" name="id" value="<?php echo $idEmpresa ?>">
                        <div class="row pt-3 pb-4">
                            <div class="col-6">
                                <small>Nombre *</small>
                                <input type="text" class="form-control" name="nombre" placeholder="Nombre del Horario Laboral" required onkeyup="mayusculas(this)">
                            </div>
                            <div class="col-6">
                                <small>Tipo Horario *</small>
                                <select class="form-control" name="tipoHorario" required>
                                    <option value="" selected disabled>Tipo de Horario</option>
                                    <option value="1">Tipo 1</option>
                                    <option value="2">Tipo 2</option>
                                </select>
                            </div>

                            <div class="col-4 pt-3">
                                <small>Lunes</small>
                                <div class="row">
                                    <div class="col-6">
                                        <small>Entrada</small>
                                        <input type="time" class="form-control" title="Hora De Entrada" name="lunesEntrada">
                                    </div>
                                    <div class="col-6">
                                        <small>Salida</small>
                                        <input type="time" class="form-control" title="Hora De Salida" name="lunesSalida">    
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 pt-3">
                                <small>Martes</small>
                                <div class="row">
                                    <div class="col-6">
                                        <small>Entrada</small>
                                        <input type="time" class="form-control" title="Hora De Entrada" name="martesEntrada">
                                    </div>
                                    <div class="col-6">
                                        <small>Salida</small>
                                        <input type="time" class="form-control" title="Hora De Salida" name="martesSalida">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 pt-3">
                                <small>Miercoles</small>
                                <div class="row">
                                    <div class="col-6">
                                        <small>Entrada</small>
                                        <input type="time" class="form-control" title="Hora De Entrada" name="miercolesEntrada">
                                    </div>
                                    <div class="col-6">
                                        <small>Salida</small>
                                        <input type="time" class="form-control" title="Hora De Salida" name="miercolesSalida">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 pt-3">
                                <small>Jueves</small>
                                <div class="row">
                                    <div class="col-6">
                                        <small>Entrada</small>
                                        <input type="time" class="form-control" title="Hora De Entrada" name="juevesEntrada">
                                    </div>
                                    <div class="col-6">
                                        <small>Salida</small>
                                        <input type="time" class="form-control" title="Hora De Salida" name="juevesSalida">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 pt-3">
                                <small>Viernes</small>
                                <div class="row">
                                    <div class="col-6">
                                        <small>Entrada</small>
                                        <input type="time" class="form-control" title="Hora De Entrada" name="viernesEntrada">
                                    </div>
                                    <div class="col-6">
                                        <small>Salida</small>
                                        <input type="time" class="form-control" title="Hora De Salida" name="viernesSalida">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 pt-3">
                                <small>S&aacute;bado</small>
                                <div class="row">
                                    <div class="col-6">
                                        <small>Entrada</small>
                                        <input type="time" class="form-control" title="Hora De Entrada" name="sabadoEntrada">
                                    </div>
                                    <div class="col-6">
                                        <small>Salida</small>
                                        <input type="time" class="form-control" title="Hora De Salida" name="sabadoSalida">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 pt-3">
                                <small>Domingo</small>
                                <div class="row">
                                    <div class="col-6">
                                        <small>Entrada</small>
                                        <input type="time" class="form-control" title="Hora De Entrada" name="domingoEntrada">
                                    </div>
                                    <div class="col-6">
                                        <small>Salida</small>
                                        <input type="time" class="form-control" title="Hora De Salida" name="domingoSalida">
                                    </div>
                                </div>
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
                            $res = mysqli_query($conexion, "SELECT * FROM horarios_laborales WHERE id_empresa = $idEmpresa ORDER BY nombre_horario ASC");
                        ?>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th></th>
                                            <th></th>
                                            <th colspan="2" style="text-align: center;">Lunes</th>
                                            <th colspan="2" style="text-align: center;">Martes</th>
                                            <th colspan="2" style="text-align: center;">Miercoles</th>
                                            <th colspan="2" style="text-align: center;">Jueves</th>
                                            <th colspan="2" style="text-align: center;">Viernes</th>
                                            <th colspan="2" style="text-align: center;">S&aacute;bado</th>
                                            <th colspan="2" style="text-align: center;">Domingo</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Tipo</th>
                                            <th>Entrada</th>
                                            <th>Salida</th>
                                            <th>Entrada</th>
                                            <th>Salida</th>
                                            <th>Entrada</th>
                                            <th>Salida</th>
                                            <th>Entrada</th>
                                            <th>Salida</th>
                                            <th>Entrada</th>
                                            <th>Salida</th>
                                            <th>Entrada</th>
                                            <th>Salida</th>
                                            <th>Entrada</th>
                                            <th>Salida</th>
                                            <th>Estatus</th>
                                        </tr>
                                    </thead>
                                    
                                    <?php
                                        while($data = mysqli_fetch_array($res)){
                                    ?>

                                    <tbody>
                                        <tr>
                                            <td><?php echo $data['nombre_horario'] ?></td>
                                            <td><?php echo $data['tipo_horario'] ?></td>
                                            <td><?php echo $data['lunes_entrada'] ?></td>
                                            <td><?php echo $data['lunes_salida'] ?></td>
                                            <td><?php echo $data['martes_entrada'] ?></td>
                                            <td><?php echo $data['martes_salida'] ?></td>
                                            <td><?php echo $data['miercoles_entrada'] ?></td>
                                            <td><?php echo $data['miercoles_salida'] ?></td>
                                            <td><?php echo $data['jueves_entrada'] ?></td>
                                            <td><?php echo $data['jueves_salida'] ?></td>
                                            <td><?php echo $data['viernes_entrada'] ?></td>
                                            <td><?php echo $data['viernes_salida'] ?></td>
                                            <td><?php echo $data['sabado_entrada'] ?></td>
                                            <td><?php echo $data['sabado_salida'] ?></td>
                                            <td><?php echo $data['domingo_entrada'] ?></td>
                                            <td><?php echo $data['domingo_salida'] ?></td>
                                            <td class="btn-switch">
                                                <label class="switch">
                                                    <input type="checkbox" id="<?php echo $data['no_horario']?>" name="btnSwitch" onclick="updateEstatus(<?php echo $data['no_horario']?>,<?php echo $data['no_horario']?>, <?php echo $data['id_empresa']?>);" value="<?php echo $data['estatus']?>" <?php echo $data['estatus'] == '1' ? 'checked' : '2' ;?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <!-- <td class="btn-eliminar">
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-horario-laboral<?php //echo $data['no_horario']; ?>"><i class="fas fa-trash-alt"></i></button>
                                            </td> -->
                                        </tr>
                                    </tbody>

                                    <!-- Modal Para Eliminar Empleado -->
                                    <!-- <div class="modal fade" id="modal-delete-horario-laboral<?php //echo $data['no_horario']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Puesto</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="server/delete-adminHorarioLaboral.php" method="POST">
                                                    <input type="hidden" name="id" value="<?php //echo $idEmpresa ?>">
                                                    <input type="hidden" name="idPuesto" value="<?php //echo $data['no_horario']?>">
                                                    <div class="modal-body">
                                                        <h5>¿Estás seguro de eliminar el horario laboral con el nombre: <?php //echo $data['nombre_horario']; ?>?</h5>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                                                        <button type="submit" class="btn btn-danger">Si</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div> -->

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

<script language="JavaScript">
    function updateEstatus(idAdHL, nombreSwitch, idEmpresa)
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
            url: 'server/updateEstatusHorarioLaboral.php',
            type: 'POST',
            data: {"idHL":idAdHL, "estado":cambioEstado, "idEmpresa":idEmpresa, "idBD":'no_horario', "tablaBD":'horarios_laborales'},
            success:function(data){
            },
        });
    }
</script>

</body>
</html>
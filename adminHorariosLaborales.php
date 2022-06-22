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
        $breadcrumb = "Tablero / Configuración De Empresa / Empresa / Horarios Laborales";
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
                                <!-- <small>Nombre</small> -->
                                <input type="text" class="form-control" name="nombre" placeholder="Nombre" required onkeyup="mayusculas(this)">
                            </div>
                            <div class="col-6">
                                <!-- <small>Tipo Horario</small> -->
                                <select class="form-control" name="tipoHorario" required>
                                    <option value="" selected disabled>Tipo de Horario</option>
                                    <option value="FLEXIBLE">FLEXIBLE</option>
                                    <option value="CORRIDO">CORRIDO</option>
                                </select>
                            </div>
                        </div>

                        <center><button type="submit" class="btn btn-primary">Agregar</button></center>
                    </form>

                    <!-- DataTales -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Horarios Laborales Registrados</h6>
                        </div>

                        <?php
                            $res = mysqli_query($conexion, "SELECT * FROM horarios_laborales WHERE id_empresa = $idEmpresa ORDER BY nombre_horario ASC");
                        ?>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Tipo</th>
                                            <th>Estatus</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    
                                    <?php
                                        while($data = mysqli_fetch_array($res)){
                                    ?>

                                    <tbody>
                                        <tr>
                                            <td><?php echo $data['nombre_horario'] ?></td>
                                            <td><?php echo $data['tipo_horario'] ?></td>
                                            <td class="btn-switch">
                                                <label class="switch">
                                                    <input type="checkbox" id="<?php echo $data['no_horario']?>" name="btnSwitch" onclick="updateEstatus(<?php echo $data['no_horario']?>,<?php echo $data['no_horario']?>, <?php echo $data['id_empresa']?>);" value="<?php echo $data['estatus']?>" <?php echo $data['estatus'] == '1' ? 'checked' : '2' ;?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td class="btn-modificar">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-edit-horario-laboral<?php echo $data['no_horario']; ?><?php echo $data['id_empresa']; ?>"><i class="fas fa-edit"></i></button>
                                            </td>
                                            <!-- <td class="btn-eliminar">
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-horario-laboral<?php //echo $data['no_horario']; ?><?php //echo $data['id_empresa']; ?>"><i class="fas fa-trash-alt"></i></button>
                                            </td> -->
                                        </tr>
                                    </tbody>

                                    <!-- Modal Para Modificar Horarios Laborales -->
                                    <div class="modal fade" id="modal-edit-horario-laboral<?php echo $data['no_horario']; ?><?php echo $data['id_empresa']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-xl" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel"><?php echo $data['nombre_horario']; ?></h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="server/update-adminHorariosLaborales.php" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $data['id_empresa']?>">
                                                    <input type="hidden" name="idHorario" value="<?php echo $data['no_horario']?>">
                                                    <div class="modal-body">
                                                        <?php
                                                                $noHorario = $data['no_horario'];
                                                                $conHLDetalles = mysqli_query($conexion, "SELECT * FROM horarios_laborales_detalles WHERE no_horario = $noHorario AND id_empresa = $idEmpresa ORDER BY no_dia ASC");

                                                                $consultaRegistros = mysqli_num_rows($conHLDetalles);
                                                            if ($data['tipo_horario'] == 'CORRIDO') {
                                                                if ($consultaRegistros == 0) {
                                                        ?>
                                                        <div class="col">
                                                            <div class="row pt-3 pb-4">

                                                                <div class="col-4 pt-3">
                                                                    <div class="card border-left-primary shadow h-100 py-2">
                                                                        <div class="card-body">
                                                                            <div class="row no-gutters align-items-center">
                                                                                <div class="col mr-2">
                                                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">DOMINGO</div>
                                                                                    <div class="h5 mb-0 mt-3 font-weight-bold text-gray-800">
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
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4 pt-3">
                                                                    <div class="card border-left-primary shadow h-100 py-2">
                                                                        <div class="card-body">
                                                                            <div class="row no-gutters align-items-center">
                                                                                <div class="col mr-2">
                                                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">LUNES</div>
                                                                                    <div class="h5 mb-0 mt-3 font-weight-bold text-gray-800">
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
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4 pt-3">
                                                                    <div class="card border-left-primary shadow h-100 py-2">
                                                                        <div class="card-body">
                                                                            <div class="row no-gutters align-items-center">
                                                                                <div class="col mr-2">
                                                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">MARTES</div>
                                                                                    <div class="h5 mb-0 mt-3 font-weight-bold text-gray-800">
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
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4 pt-3">
                                                                    <div class="card border-left-primary shadow h-100 py-2">
                                                                        <div class="card-body">
                                                                            <div class="row no-gutters align-items-center">
                                                                                <div class="col mr-2">
                                                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">MIERCOLES</div>
                                                                                    <div class="h5 mb-0 mt-3 font-weight-bold text-gray-800">
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
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4 pt-3">
                                                                    <div class="card border-left-primary shadow h-100 py-2">
                                                                        <div class="card-body">
                                                                            <div class="row no-gutters align-items-center">
                                                                                <div class="col mr-2">
                                                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">JUEVES</div>
                                                                                    <div class="h5 mb-0 mt-3 font-weight-bold text-gray-800">
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
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4 pt-3">
                                                                    <div class="card border-left-primary shadow h-100 py-2">
                                                                        <div class="card-body">
                                                                            <div class="row no-gutters align-items-center">
                                                                                <div class="col mr-2">
                                                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">VIERNES</div>
                                                                                    <div class="h5 mb-0 mt-3 font-weight-bold text-gray-800">
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
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-4 pt-3">
                                                                    <div class="card border-left-primary shadow h-100 py-2">
                                                                        <div class="card-body">
                                                                            <div class="row no-gutters align-items-center">
                                                                                <div class="col mr-2">
                                                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">S&Aacute;BADO</div>
                                                                                    <div class="h5 mb-0 mt-3 font-weight-bold text-gray-800">
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
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <?php
                                                                } else {
                                                        ?>

                                                        <div class="col">
                                                            <div class="row pt-3 pb-4">
                                                                <?php
                                                                    while ($resDetalles = mysqli_fetch_array($conHLDetalles)) {
                                                                ?>
                                                                <div class="col-4 pt-3">
                                                                    <div class="card border-left-primary shadow h-100 py-2">
                                                                        <div class="card-body">
                                                                            <div class="row no-gutters align-items-center">
                                                                                <div class="col mr-2">
                                                                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                                                        <?php
                                                                                            if ($resDetalles['no_dia'] == 1) {
                                                                                                echo "DOMINGO";
                                                                                            } elseif ($resDetalles['no_dia'] == 2) {
                                                                                                echo "LUNES";
                                                                                            } elseif ($resDetalles['no_dia'] == 3) {
                                                                                                echo "MARTES";
                                                                                            } elseif ($resDetalles['no_dia'] == 4) {
                                                                                                echo "MIERCOLES";
                                                                                            } elseif ($resDetalles['no_dia'] == 5) {
                                                                                                echo "JUEVES";
                                                                                            } elseif ($resDetalles['no_dia'] == 6) {
                                                                                                echo "VIERNES";
                                                                                            } elseif ($resDetalles['no_dia'] == 7) {
                                                                                                echo "SÁBADO";
                                                                                            }
                                                                                        ?>
                                                                                    </div>
                                                                                    <div class="h5 mb-0 mt-3 font-weight-bold text-gray-800">
                                                                                        <div class="row">
                                                                                            <?php
                                                                                                if ($resDetalles['hora_entrada'] == '00:00:00' && $resDetalles['hora_salida'] == '00:00:00') {
                                                                                            ?>
                                                                                            <div class="col-6">
                                                                                                <small>Entrada</small>
                                                                                                <input type="time" class="form-control" style="color: <?php if (empty($resDetalles['hora_entrada']) || $resDetalles['hora_entrada'] == '00:00:00') { echo 'red'; } ?>" title="Hora De Entrada" name="e<?php echo $resDetalles['no_dia']; ?>">
                                                                                            </div>
                                                                                            <div class="col-6">
                                                                                                <small>Salida</small>
                                                                                                <input type="time" class="form-control" style="color: <?php if (empty($resDetalles['hora_salida']) || $resDetalles['hora_salida'] == '00:00:00') { echo 'red'; } ?>" title="Hora De Salida" name="s<?php echo $resDetalles['no_dia']; ?>">
                                                                                            </div>
                                                                                            <?php
                                                                                                } else {
                                                                                            ?>
                                                                                            <div class="col-6">
                                                                                                <small>Entrada</small>
                                                                                                <input type="time" class="form-control" style="color: <?php if (empty($resDetalles['hora_entrada']) || $resDetalles['hora_entrada'] == '00:00:00') { echo 'red'; } ?>" title="Hora De Entrada" name="e<?php echo $resDetalles['no_dia']; ?>" value="<?php echo $resDetalles['hora_entrada']; ?>">
                                                                                            </div>
                                                                                            <div class="col-6">
                                                                                                <small>Salida</small>
                                                                                                <input type="time" class="form-control" style="color: <?php if (empty($resDetalles['hora_salida']) || $resDetalles['hora_salida'] == '00:00:00') { echo 'red'; } ?>" title="Hora De Salida" name="s<?php echo $resDetalles['no_dia']; ?>" value="<?php echo $resDetalles['hora_salida']; ?>">
                                                                                            </div>
                                                                                            <?php
                                                                                                }
                                                                                            ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </div>
                                                        </div>

                                                        <?php
                                                                }
                                                        ?>
                                                        <?php
                                                            } elseif ($data['tipo_horario'] == 'FLEXIBLE') {
                                                                if ($consultaRegistros == 0) {
                                                        ?>
                                                        <div class="col">
                                                            <div class="row pt-3 pb-4">

                                                                <div class="col-12 pt-3">
                                                                    <div class="card border-left-primary shadow h-100 py-2">
                                                                        <div class="card-body">
                                                                            <div class="row no-gutters align-items-center">
                                                                                <div class="col mr-2">
                                                                                    <div class="row">
                                                                                        <div class="col-6">
                                                                                            <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">DOMINGO</div>
                                                                                        </div>
                                                                                        <div class="col-6">
                                                                                            <div class="text-sm font-weight-bold text-primary text-capitalize mb-1">Receso</div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="h5 mb-0 mt-3 font-weight-bold text-gray-800">
                                                                                        <div class="row">
                                                                                            <div class="col-3">
                                                                                                <small>Entrada</small>
                                                                                                <input type="time" class="form-control" title="Hora De Entrada" name="domingoEntrada">
                                                                                            </div>
                                                                                            <div class="col-3">
                                                                                                <small>Salida</small>
                                                                                                <input type="time" class="form-control" title="Hora De Salida" name="domingoSalida">    
                                                                                            </div>
                                                                                            <div class="col-3">
                                                                                                <small>Salida</small>
                                                                                                <input type="time" class="form-control" title="Hora De Salida de Receso" name="domingoSalidaReceso">    
                                                                                            </div>
                                                                                            <div class="col-3">
                                                                                                <small>Entrada</small>
                                                                                                <input type="time" class="form-control" title="Hora De Entrada de Receso" name="domingoEntradaReceso">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 pt-3">
                                                                    <div class="card border-left-primary shadow h-100 py-2">
                                                                        <div class="card-body">
                                                                            <div class="row no-gutters align-items-center">
                                                                                <div class="col mr-2">
                                                                                    <div class="row">
                                                                                        <div class="col-6">
                                                                                            <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">LUNES</div>
                                                                                        </div>
                                                                                        <div class="col-6">
                                                                                            <div class="text-sm font-weight-bold text-primary text-capitalize mb-1">Receso</div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="h5 mb-0 mt-3 font-weight-bold text-gray-800">
                                                                                        <div class="row">
                                                                                            <div class="col-3">
                                                                                                <small>Entrada</small>
                                                                                                <input type="time" class="form-control" title="Hora De Entrada" name="lunesEntrada">
                                                                                            </div>
                                                                                            <div class="col-3">
                                                                                                <small>Salida</small>
                                                                                                <input type="time" class="form-control" title="Hora De Salida" name="lunesSalida">    
                                                                                            </div>
                                                                                            <div class="col-3">
                                                                                                <small>Salida</small>
                                                                                                <input type="time" class="form-control" title="Hora De Salida de Receso" name="lunesSalidaReceso">    
                                                                                            </div>
                                                                                            <div class="col-3">
                                                                                                <small>Entrada</small>
                                                                                                <input type="time" class="form-control" title="Hora De Entrada de Receso" name="lunesEntradaReceso">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 pt-3">
                                                                    <div class="card border-left-primary shadow h-100 py-2">
                                                                        <div class="card-body">
                                                                            <div class="row no-gutters align-items-center">
                                                                                <div class="col mr-2">
                                                                                    <div class="row">
                                                                                        <div class="col-6">
                                                                                            <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">MARTES</div>
                                                                                        </div>
                                                                                        <div class="col-6">
                                                                                            <div class="text-sm font-weight-bold text-primary text-capitalize mb-1">Receso</div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="h5 mb-0 mt-3 font-weight-bold text-gray-800">
                                                                                        <div class="row">
                                                                                            <div class="col-3">
                                                                                                <small>Entrada</small>
                                                                                                <input type="time" class="form-control" title="Hora De Entrada" name="martesEntrada">
                                                                                            </div>
                                                                                            <div class="col-3">
                                                                                                <small>Salida</small>
                                                                                                <input type="time" class="form-control" title="Hora De Salida" name="martesSalida">    
                                                                                            </div>
                                                                                            <div class="col-3">
                                                                                                <small>Salida</small>
                                                                                                <input type="time" class="form-control" title="Hora De Salida de Receso" name="martesSalidaReceso">    
                                                                                            </div>
                                                                                            <div class="col-3">
                                                                                                <small>Entrada</small>
                                                                                                <input type="time" class="form-control" title="Hora De Entrada de Receso" name="martesEntradaReceso">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 pt-3">
                                                                    <div class="card border-left-primary shadow h-100 py-2">
                                                                        <div class="card-body">
                                                                            <div class="row no-gutters align-items-center">
                                                                                <div class="col mr-2">
                                                                                    <div class="row">
                                                                                        <div class="col-6">
                                                                                            <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">MIERCOLES</div>
                                                                                        </div>
                                                                                        <div class="col-6">
                                                                                            <div class="text-sm font-weight-bold text-primary text-capitalize mb-1">Receso</div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="h5 mb-0 mt-3 font-weight-bold text-gray-800">
                                                                                        <div class="row">
                                                                                            <div class="col-3">
                                                                                                <small>Entrada</small>
                                                                                                <input type="time" class="form-control" title="Hora De Entrada" name="miercolesEntrada">
                                                                                            </div>
                                                                                            <div class="col-3">
                                                                                                <small>Salida</small>
                                                                                                <input type="time" class="form-control" title="Hora De Salida" name="miercolesSalida">    
                                                                                            </div>
                                                                                            <div class="col-3">
                                                                                                <small>Salida</small>
                                                                                                <input type="time" class="form-control" title="Hora De Salida de Receso" name="miercolesSalidaReceso">    
                                                                                            </div>
                                                                                            <div class="col-3">
                                                                                                <small>Entrada</small>
                                                                                                <input type="time" class="form-control" title="Hora De Entrada de Receso" name="miercolesEntradaReceso">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 pt-3">
                                                                    <div class="card border-left-primary shadow h-100 py-2">
                                                                        <div class="card-body">
                                                                            <div class="row no-gutters align-items-center">
                                                                                <div class="col mr-2">
                                                                                    <div class="row">
                                                                                        <div class="col-6">
                                                                                            <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">JUEVES</div>
                                                                                        </div>
                                                                                        <div class="col-6">
                                                                                            <div class="text-sm font-weight-bold text-primary text-capitalize mb-1">Receso</div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="h5 mb-0 mt-3 font-weight-bold text-gray-800">
                                                                                        <div class="row">
                                                                                            <div class="col-3">
                                                                                                <small>Entrada</small>
                                                                                                <input type="time" class="form-control" title="Hora De Entrada" name="juevesEntrada">
                                                                                            </div>
                                                                                            <div class="col-3">
                                                                                                <small>Salida</small>
                                                                                                <input type="time" class="form-control" title="Hora De Salida" name="juevesSalida">    
                                                                                            </div>
                                                                                            <div class="col-3">
                                                                                                <small>Salida</small>
                                                                                                <input type="time" class="form-control" title="Hora De Salida de Receso" name="juevesSalidaReceso">    
                                                                                            </div>
                                                                                            <div class="col-3">
                                                                                                <small>Entrada</small>
                                                                                                <input type="time" class="form-control" title="Hora De Entrada de Receso" name="juevesEntradaReceso">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 pt-3">
                                                                    <div class="card border-left-primary shadow h-100 py-2">
                                                                        <div class="card-body">
                                                                            <div class="row no-gutters align-items-center">
                                                                                <div class="col mr-2">
                                                                                    <div class="row">
                                                                                        <div class="col-6">
                                                                                            <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">VIERNES</div>
                                                                                        </div>
                                                                                        <div class="col-6">
                                                                                            <div class="text-sm font-weight-bold text-primary text-capitalize mb-1">Receso</div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="h5 mb-0 mt-3 font-weight-bold text-gray-800">
                                                                                        <div class="row">
                                                                                            <div class="col-3">
                                                                                                <small>Entrada</small>
                                                                                                <input type="time" class="form-control" title="Hora De Entrada" name="viernesEntrada">
                                                                                            </div>
                                                                                            <div class="col-3">
                                                                                                <small>Salida</small>
                                                                                                <input type="time" class="form-control" title="Hora De Salida" name="viernesSalida">    
                                                                                            </div>
                                                                                            <div class="col-3">
                                                                                                <small>Salida</small>
                                                                                                <input type="time" class="form-control" title="Hora De Salida de Receso" name="viernesSalidaReceso">    
                                                                                            </div>
                                                                                            <div class="col-3">
                                                                                                <small>Entrada</small>
                                                                                                <input type="time" class="form-control" title="Hora De Entrada de Receso" name="viernesEntradaReceso">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 pt-3">
                                                                    <div class="card border-left-primary shadow h-100 py-2">
                                                                        <div class="card-body">
                                                                            <div class="row no-gutters align-items-center">
                                                                                <div class="col mr-2">
                                                                                    <div class="row">
                                                                                        <div class="col-6">
                                                                                            <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">S&Aacute;BADO</div>
                                                                                        </div>
                                                                                        <div class="col-6">
                                                                                            <div class="text-sm font-weight-bold text-primary text-capitalize mb-1">Receso</div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="h5 mb-0 mt-3 font-weight-bold text-gray-800">
                                                                                        <div class="row">
                                                                                            <div class="col-3">
                                                                                                <small>Entrada</small>
                                                                                                <input type="time" class="form-control" title="Hora De Entrada" name="sabadoEntrada">
                                                                                            </div>
                                                                                            <div class="col-3">
                                                                                                <small>Salida</small>
                                                                                                <input type="time" class="form-control" title="Hora De Salida" name="sabadoSalida">    
                                                                                            </div>
                                                                                            <div class="col-3">
                                                                                                <small>Salida</small>
                                                                                                <input type="time" class="form-control" title="Hora De Salida de Receso" name="sabadoSalidaReceso">    
                                                                                            </div>
                                                                                            <div class="col-3">
                                                                                                <small>Entrada</small>
                                                                                                <input type="time" class="form-control" title="Hora De Entrada de Receso" name="sabadoEntradaReceso">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <?php
                                                                } else {
                                                        ?>
                                                        <div class="col">
                                                            <div class="row pt-3 pb-4">
                                                                <?php
                                                                    while ($resDetalles = mysqli_fetch_array($conHLDetalles)) {
                                                                        $dia = $resDetalles['no_dia'];
                                                                        $conHLRecesos = mysqli_query($conexion, "SELECT * FROM horarios_laborales_recesos WHERE no_horario = $noHorario AND id_empresa = $idEmpresa AND no_dia = $dia");

                                                                        $resRecesos = mysqli_fetch_assoc($conHLRecesos);
                                                                ?>
                                                                <div class="col-12 pt-3">
                                                                    <div class="card border-left-primary shadow h-100 py-2">
                                                                        <div class="card-body">
                                                                            <div class="row no-gutters align-items-center">
                                                                                <div class="col mr-2">
                                                                                    <div class="row">
                                                                                        <div class="col-6">
                                                                                            <!-- <div class="text-sm font-weight-bold text-primary text-uppercase mb-1"> -->
                                                                                            <div class="text-sm font-weight-bold text-primary text-uppercase mb-1">
                                                                                                <?php
                                                                                                    if ($resDetalles['no_dia'] == 1) {
                                                                                                        echo "DOMINGO";
                                                                                                    } elseif ($resDetalles['no_dia'] == 2) {
                                                                                                        echo "LUNES";
                                                                                                    } elseif ($resDetalles['no_dia'] == 3) {
                                                                                                        echo "MARTES";
                                                                                                    } elseif ($resDetalles['no_dia'] == 4) {
                                                                                                        echo "MIERCOLES";
                                                                                                    } elseif ($resDetalles['no_dia'] == 5) {
                                                                                                        echo "JUEVES";
                                                                                                    } elseif ($resDetalles['no_dia'] == 6) {
                                                                                                        echo "VIERNES";
                                                                                                    } elseif ($resDetalles['no_dia'] == 7) {
                                                                                                        echo "SÁBADO";
                                                                                                    }
                                                                                                ?>
                                                                                            </div>
                                                                                            <!-- </div> -->
                                                                                        </div>
                                                                                        <div class="col-6">
                                                                                            <div class="text-sm font-weight-bold text-primary text-capitalize mb-1">Receso</div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="h5 mb-0 mt-3 font-weight-bold text-gray-800">
                                                                                        <div class="row">
                                                                                            <?php
                                                                                                if ($resDetalles['hora_entrada'] == '00:00:00' && $resDetalles['hora_salida'] == '00:00:00' && $resRecesos['salida_descanso'] == '00:00:00' && $resRecesos['entrada_descanso'] == '00:00:00') {
                                                                                            ?>
                                                                                            <div class="col-3">
                                                                                                <small>Entrada</small>
                                                                                                <input type="time" class="form-control" style="color: <?php if (empty($resDetalles['hora_entrada']) || $resDetalles['hora_entrada'] == '00:00:00') { echo 'red'; } ?>" title="Hora De Entrada" name="e_d<?php echo $resDetalles['no_dia']; ?>">
                                                                                            </div>
                                                                                            <div class="col-3">
                                                                                                <small>Salida</small>
                                                                                                <input type="time" class="form-control" style="color: <?php if (empty($resDetalles['hora_salida']) || $resDetalles['hora_salida'] == '00:00:00') { echo 'red'; } ?>" title="Hora De Salida" name="s_d<?php echo $resDetalles['no_dia']; ?>">
                                                                                            </div>
                                                                                            <div class="col-3">
                                                                                                <small>Salida</small>
                                                                                                <input type="time" class="form-control" style="color: <?php if (empty($resRecesos['salida_descanso']) || $resRecesos['salida_descanso'] == '00:00:00') { echo 'red'; } ?>" title="Hora De Salida de Receso" name="s_r<?php echo $resDetalles['no_dia']; ?>">
                                                                                            </div>
                                                                                            <div class="col-3">
                                                                                                <small>Entrada</small>
                                                                                                <input type="time" class="form-control" style="color: <?php if (empty($resRecesos['entrada_descanso']) || $resRecesos['entrada_descanso'] == '00:00:00') { echo 'red'; } ?>" title="Hora De Entrada de Receso"  name="e_r<?php echo $resDetalles['no_dia']; ?>">
                                                                                            </div>
                                                                                            <?php
                                                                                                } else {
                                                                                            ?>
                                                                                            <div class="col-3">
                                                                                                <small>Entrada</small>
                                                                                                <input type="time" class="form-control" style="color: <?php if (empty($resDetalles['hora_entrada']) || $resDetalles['hora_entrada'] == '00:00:00') { echo 'red'; } ?>" title="Hora De Entrada" name="e_d<?php echo $resDetalles['no_dia']; ?>" value="<?php echo $resDetalles['hora_entrada']; ?>">
                                                                                            </div>
                                                                                            <div class="col-3">
                                                                                                <small>Salida</small>
                                                                                                <input type="time" class="form-control" style="color: <?php if (empty($resDetalles['hora_salida']) || $resDetalles['hora_salida'] == '00:00:00') { echo 'red'; } ?>" title="Hora De Salida" name="s_d<?php echo $resDetalles['no_dia']; ?>" value="<?php echo $resDetalles['hora_salida']; ?>">
                                                                                            </div>
                                                                                            <div class="col-3">
                                                                                                <small>Salida</small>
                                                                                                <input type="time" class="form-control" style="color: <?php if (empty($resRecesos['salida_descanso']) || $resRecesos['salida_descanso'] == '00:00:00') { echo 'red'; } ?>" title="Hora De Salida de Receso" name="s_r<?php echo $resDetalles['no_dia']; ?>" value="<?php echo $resRecesos['salida_descanso']; ?>">
                                                                                            </div>
                                                                                            <div class="col-3">
                                                                                                <small>Entrada</small>
                                                                                                <input type="time" class="form-control" style="color: <?php if (empty($resRecesos['entrada_descanso']) || $resRecesos['entrada_descanso'] == '00:00:00') { echo 'red'; } ?>" title="Hora De Entrada de Receso"  name="e_r<?php echo $resDetalles['no_dia']; ?>" value="<?php echo $resRecesos['entrada_descanso']; ?>">
                                                                                            </div>
                                                                                            <?php
                                                                                                }
                                                                                            ?>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                                    }
                                                                ?>
                                                            </div>
                                                        </div>
                                                        <?php
                                                                }
                                                            }
                                                        ?>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-primary" name="agregarHorarioCorrido">Guardar cambios</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Para Eliminar Horarios Laborales -->
                                    <!-- <div class="modal fade" id="modal-delete-horario-laboral<?php //echo $data['no_horario']; ?><?php //echo $data['id_empresa']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Horario Laboral</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="server/delete-adminHorarioLaboral.php" method="POST">
                                                    <input type="hidden" name="id" value="<?php //echo $idEmpresa ?>">
                                                    <input type="hidden" name="idHorario" value="<?php //echo $data['no_horario']?>">
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
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
        $breadcrumb = "Tablero / Empresa / Ausencias";
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
                    <h1 class="h3 mb-2 text-gray-800">Ausencias</h1>

                    <!-- Formulario -->
                    <form class="form mt-3 mb-5" action="server/insert-adminAusencias.php" method="POST">
                        <h1 class="h5 mb-2 text-gray-800">Agregar ausencias.</h1>
                        <input type="hidden" name="id" value="<?php echo $idEmpresa ?>">
                        <div class="row pt-3">
                            <div class="col-8" id="option1" style="display: block;">
                                <select class="form-control" name="nombre1" required>
                                    <option value="#" disabled selected>Cat&aacute;logo General De Ausencias</option>
                                    <?php
                                        $query = mysqli_query($conexion, "SELECT * FROM _cat_ausencias WHERE estatus = 1 ORDER BY nombre ASC");
                                        while ($data = mysqli_fetch_assoc($query)){
                                    ?>
                                            <option value="<?php echo $data["nombre"]; ?>"><?php echo $data["nombre"]; ?></option>
                                    <?php
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="col-8" id="option2" style="display: none;">
                                <input type="text" class="form-control" name="nombre2" placeholder="Nombre" onkeyup="mayusculas(this)" maxlength="30">
                            </div>

                            <div class="col-2">
                                <button type="button" class="btn btn-success" onclick="mostrarOcultar()"><i class="fas fa-plus"></i></button>
                            </div>

                            <div id="color" class="col-2">
                                <input type="color" class="form-control" name="color" placeholder="Color" required maxlength="15">
                            </div>
                        </div>
                        <div class="row pt-3 pb-4">
                            <div class="col-3">
                                <select class="form-control form-select-sm" id="descuentaTiempo" name="descuentaTiempo" required>
                                    <option value="#" disabled selected>Descuenta Tiempo</option>
                                    <option value="1">Si</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <select class="form-control form-select-sm" id="aprobacion" name="aprobacion" required>
                                    <option value="#" disabled selected>Aprobaci&oacute;n</option>
                                    <option value="1">Si</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <select class="form-control form-select-sm" id="laborable" name="laborable" required>
                                    <option value="#" disabled selected>Laborable</option>
                                    <option value="1">Si</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                            <div class="col-3">
                                <select class="form-control form-select-sm" id="justificante" name="justificante" required>
                                    <option value="#" disabled selected>Justificante Obligatorio</option>
                                    <option value="1">Si</option>
                                    <option value="2">No</option>
                                </select>
                            </div>
                        </div>

                        <center><button type="submit" class="btn btn-primary">Agregar</button></center>
                    </form>

                    <!-- DataTables -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Registro de datos</h6>
                        </div>

                        <?php
                            $res = mysqli_query($conexion, "SELECT * FROM catalogo_ausencias WHERE id_empresa = $idEmpresa ORDER BY nombre ASC")
                        ?>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Color</th>
                                            <th>Descuenta Tiempo</th>
                                            <th>Aprobaci&oacute;n</th>
                                            <th>Laborable</th>
                                            <th>Justificante Obligatorio</th>
                                            <th>Estatus</th>
                                            <th>Acciones</th>  
                                        </tr>
                                    </thead>
                                    
                                    <?php
                                        while($data = mysqli_fetch_array($res)){
                                    ?>

                                    <tbody>
                                        <tr>
                                            <td><?php echo $data['nombre'] ?></td>
                                            <td bgcolor="<?php echo $data['color'] ?>"></td>
                                            <td>
                                                <?php
                                                    if ($data['descuenta_tiempo'] == 1) {
                                                        echo "SI";
                                                    } elseif ($data['descuenta_tiempo'] == 2) {
                                                        echo "NO";
                                                    }else{
                                                        echo "No especificado";
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if ($data['aprobacion'] == 1) {
                                                        echo "SI";
                                                    } elseif ($data['aprobacion'] == 2) {
                                                        echo "NO";
                                                    } else {
                                                        echo "No especificado";
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if ($data['laborable'] == 1) {
                                                        echo "SI";
                                                    } elseif ($data['laborable'] == 2) {
                                                        echo "NO";
                                                    } else {
                                                        echo "No especificado";
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if ($data['justificante'] == 1) {
                                                        echo "SI";
                                                    } elseif ($data['justificante'] == 2) {
                                                        echo "NO";
                                                    } else {
                                                        echo "No especificado";
                                                    }
                                                ?>
                                            </td>
                                            <td class="btn-switch">
                                                <label class="switch">
                                                    <input type="checkbox" id="<?php echo $data['id_ausencia']?>" name="btnSwitch" onclick="updateEstatus(<?php echo $data['id_ausencia']?>,<?php echo $data['id_ausencia']?>);" value="<?php echo $data['estatus']?>" <?php echo $data['estatus'] == '1' ? 'checked' : '2' ;?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td class="btn-eliminar">
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-ausencia<?php echo $data['id_ausencia']; ?>"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>

                                    <!-- Modal Para Agregar Ausencia -->
                                    <div class="modal fade" id="modal-add-ausencia" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Agregar Ausencia</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="server/insert-adminAusenciasModal.php" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $idEmpresa ?>">
                                                    <div class="modal-body">
                                                        <div class="col">
                                                            <div class="row pt-3 pb-4">
                                                                <div class="col-12">
                                                                    <input type="text" class="form-control" name="nombre" placeholder="Nombre">
                                                                </div>
                                                                <div class="col-6 mt-3">
                                                                    <input type="color" class="form-control" id="color" name="color" placeholder="Color" required>
                                                                </div>
                                                            
                                                                <div class="col-6 mt-3">
                                                                    <select class="form-control form-select-sm" id="descuentaTiempo" name="descuentaTiempo" required>
                                                                        <option value="#" disabled selected>Descuenta Tiempo</option>
                                                                        <option value="1">Si</option>
                                                                        <option value="2">No</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-6 mt-3">
                                                                    <select class="form-control form-select-sm" id="aprobacion" name="aprobacion" required>
                                                                        <option value="#" disabled selected>Aprobaci&oacute;n</option>
                                                                        <option value="1">Si</option>
                                                                        <option value="2">No</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-6 mt-3">
                                                                    <select class="form-control form-select-sm" id="laborable" name="laborable" required>
                                                                        <option value="#" disabled selected>Laborable</option>
                                                                        <option value="1">Si</option>
                                                                        <option value="2">No</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-6 mt-3">
                                                                    <select class="form-control form-select-sm" id="justificante" name="justificante" required>
                                                                        <option value="#" disabled selected>Justificante Obligatorio</option>
                                                                        <option value="1">Si</option>
                                                                        <option value="2">No</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                                        <button type="submit" class="btn btn-primary">Agregar</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Modal Para Eliminar Ausencia -->
                                    <div class="modal fade" id="modal-delete-ausencia<?php echo $data['id_ausencia']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Ausencia</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="server/delete-adminAusencias.php" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $data['id_ausencia']?>">
                                                    <div class="modal-body">
                                                        <h5>¿Estás seguro de eliminar la ausencia con el nombre: <?php echo $data['nombre']; ?>?</h5>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                                                        <button type="submit" class="btn btn-danger">Si</button>
                                                    </div>
                                                </form>
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
    } elseif (isset($usuario) && $nivelUsuario == 1 || $nivelUsuario == 3 || $nivelUsuario == 4) {
        header("location: panel2.php");
    }
    mysqli_close($conexion);
?>

<script language="JavaScript">
    function updateEstatus(idAdAusencias, nombreSwitch)
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
            data: {"id":idAdAusencias, "estado":cambioEstado, "idBD":'id_ausencia', "tablaBD":'catalogo_ausencias'},
            success:function(data){
            },
        });
    };

    function mostrarOcultar(){
        var select = document.getElementById('option1');
        var input = document.getElementById('option2');

        if (select.style.display == 'block') {
            select.style.display = 'none';
            input.style.display = 'block';
        } else {
            select.style.display = 'block';
            input.style.display = 'none';
        }
    }

</script>

</body>
</html>
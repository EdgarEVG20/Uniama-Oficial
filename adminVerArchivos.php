<?php
    session_start();
    require("conexion.php");

    $usuario = $_SESSION['nombre_user'];
    $idEmpresa = $_SESSION['id_emisor_user'];
    $nivelUsuario = $_SESSION['nivel_user'];
    $idVerUsuario = $_GET["idU"];

    if (!isset($usuario)){
        header("location: index.html");
    } elseif (isset($usuario) && $nivelUsuario == 2) {
    
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <?php
        $breadcrumb = "Tablero / Información De Colaboradores / Ver Archivos";
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
                    <h1 class="h3 mb-2 text-gray-800">Ver Archivos</h1>
                    <br>

                    <?php
                        $nombreUsuario = mysqli_query($conexion, "SELECT nombre FROM usuarios WHERE id_usuario = $idVerUsuario");
                        $nombreU = mysqli_fetch_assoc($nombreUsuario);
                    ?>

                    <h1 class="h5 mb-2 text-gray-800">Trabajador: <?php echo $nombreU['nombre'] ?></h1>

                    <div class="row">

                        <?php 
                            //$query = mysqli_query($conexion, "SELECT * FROM catalogo_documentos WHERE id_empresa = $idEmpresa AND estatus = 1 ORDER BY nombre ASC");
                            $query = mysqli_query($conexion, "SELECT catalogo_documentos.id_documento, catalogo_documentos.id_empresa, catalogo_documentos.nombre, catalogo_documentos.vigencia, catalogo_documentos.obligatorio, catalogo_documentos.estatus FROM catalogo_documentos INNER JOIN usuarios_perfiles ON catalogo_documentos.id_empresa = usuarios_perfiles.id_empresa AND usuarios_perfiles.id_usuario = $idVerUsuario AND catalogo_documentos.estatus = 1 ORDER BY catalogo_documentos.nombre ASC");

                            while ($data = mysqli_fetch_assoc($query)){
                                //$rfc = $data['ips_rfc'];
                                $nombre = $data['nombre'];
                                $nombreSinAcentos = str_replace(' ', '_', $nombre);
                        ?>

                        <div class="col-xl-3 col-md-6 mb-4 mt-3 w-100">
                            <form action="server/update-tDocumentos.php" method="POST" enctype="multipart/form-data">
                                <label class="input-group-btn pointer">
                                    <div class="card border-left-primary shadow h-100 py-2">
                                        <div class="card-body documentCards">
                                            <div class="row no-gutters align-items-center">
                                                <div class="col mr-2 infoCards">
                                                    <div class="text-s font-weight-bold text-primary text-uppercase mb-1 documentName"><?php echo $data['nombre'] ?></div>
                                                    <div class="documentInfo">
                                                        <div class="h6 mb-0 font-weight-normal text-gray-800">Obligatorio:
                                                            <?php
                                                                if ($data['obligatorio'] == 1) {
                                                                    echo "Si";
                                                                } elseif ($data['obligatorio'] == 2) {
                                                                    echo "No";
                                                                } elseif ($data['obligatorio'] == 3) {
                                                                    echo "Administrador decide";
                                                                } else {
                                                                    echo "No especificado";
                                                                }
                                                            ?>
                                                        </div>
                                                        <div class="h6 mb-0 font-weight-normal text-gray-800">Vigencia:
                                                            <?php
                                                                if ($data['vigencia'] == 1) {
                                                                    echo "Si";
                                                                } elseif ($data['vigencia'] == 2) {
                                                                    echo "No";
                                                                } else {
                                                                    echo "No especificado";
                                                                }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="btns">
                                                        <input type="hidden" name="id" value="<?php echo $idEmpresa ?>">
                                                        <input type="hidden" name="idU" value="<?php echo $idVerUsuario ?>">
                                                        <input type="hidden" name="nombre" value="<?php echo $data['nombre'] ?>">
                                                        <input type="hidden" name="idDocumento" value="<?php echo $data['id_documento'] ?>">
                                                        <input type="hidden" name="vigencia" value="<?php echo $data['vigencia'] ?>">
                                                        <input type="file" name="archivo" hidden/>

                                                        <div class="row">
                                                        <?php
                                                            $idDocumentoCatalogo = $data['id_documento'];
                                                            $consultaIdDocumento = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM archivos_documentos WHERE id_documento = $idDocumentoCatalogo AND id_empresa = $idEmpresa AND id_usuario = $idVerUsuario"));

                                                            $conAplica = mysqli_query($conexion, "SELECT * FROM archivos_documentos WHERE id_documento = $idDocumentoCatalogo AND id_empresa = $idEmpresa AND id_usuario = $idVerUsuario");
                                                            $resAplica = mysqli_fetch_assoc($conAplica);
                                                        ?>
                                                            
                                                        <?php
                                                            if ($resAplica['aplica'] == 2) {
                                                        ?>
                                                                <div class="col-ml-3 ml-1">
                                                                    <button type="submit" class="btn btn-primary" name="subirArchivo" disabled><i class="fas fa-file-upload"></i></button>
                                                                </div>
                                                        <?php
                                                            } else {
                                                        ?>
                                                                <div class="col-ml-3 ml-1">
                                                                    <button type="submit" class="btn btn-primary" name="subirArchivo"><i class="fas fa-file-upload"></i></button>
                                                                </div>
                                                        <?php
                                                            }
                                                        ?>
                                                            
                                                        <?php
                                                            if ($consultaIdDocumento == 0 || $resAplica['aplica'] == 2 || $resAplica['estatus'] == 2) {
                                                        ?>
                                                                <div class="col-ml-3 ml-1">
                                                                    <button type="button" class="btn btn-success" name="verArchivo" disabled><i class="fas fa-eye"></i></button>
                                                                </div>
                                                        <?php
                                                            } else {
                                                        ?>
                                                                <div class="col-ml-3 ml-1">
                                                                    <button type="button" class="btn btn-success" name="verArchivo" data-toggle="modal" data-target="#modal-ver-documento<?php echo $data['id_documento']; ?>"><i class="fas fa-eye"></i></button>
                                                                </div>
                                                                
                                                                <!-- <a type="button" class="btn btn-success" name="verArchivo" target="_blank" href="<?php //echo 'http://'.$_SERVER['HTTP_HOST'].'/11CuatrimestresEstadias/Proyecto/UniamaOficial/Clientes/'.$idEmpresa.'/empleados/'.$idVerUsuario.'/'.$nombreSinAcentos.'.pdf' ?>"><i class="fas fa-eye"></i></a> -->
                                                                
                                                                <!-- LINEA DE CODIGO PARA MODO PRUEBA -->
                                                                <!--<a type="button" class="btn btn-success" name="verArchivo" target="_blank" href="<?php //echo 'http://'.$_SERVER['HTTP_HOST'].'/pruebas/Clientes/'.$idEmpresa.'/empleados/'.$idVerUsuario.'/'.$nombreSinAcentos.'.pdf' ?>"><i class="fas fa-eye"></i></a>-->
                                                                
                                                                <!-- LINEA DE CODIGO PARA MODO PRODUCCIÓN -->
                                                                <!--<a type="button" class="btn btn-success" name="verArchivo" target="_blank" href="<?php //echo 'http://'.$_SERVER['HTTP_HOST'].'/Clientes/'.$idEmpresa.'/empleados/'.$idVerUsuario.'/'.$nombreSinAcentos.'.pdf' ?>"><i class="fas fa-eye"></i></a>-->
                                                        
                                                        <?php
                                                            }
                                                        ?>
                                                        <?php
                                                            if ($consultaIdDocumento == 0 || $resAplica['aplica'] == 2 || $resAplica['estatus'] == 2) {
                                                        ?>
                                                                <div class="col-ml-3 ml-1">
                                                                    <button type="button" class="btn btn-danger" name="eliminarArchivo" disabled><i class="fas fa-trash-alt"></i></button>
                                                                </div>
                                                        <?php
                                                            } else {
                                                        ?>
                                                                <div class="col-ml-3 ml-1">
                                                                    <button type="button" class="btn btn-danger" name="eliminarArchivo" data-toggle="modal" data-target="#modal-delete-documento<?php echo $data['id_documento']; ?>"><i class="fas fa-trash-alt"></i></button>
                                                                </div>
                                                        <?php
                                                            }
                                                        ?>
                                                        <?php
                                                            if ($data['obligatorio'] == 3) {
                                                        ?>
                                                                <div class="col-ml-3 ml-1">
                                                                    <label class="switch">
                                                                        <input type="checkbox" id="<?php echo $data['id_documento'] ?>" name="btnSwitch" onclick="updateEstatus(<?php echo $data['id_documento'] ?>, <?php echo $data['id_documento'] ?>, <?php echo $idEmpresa ?>, <?php echo $idVerUsuario ?>, <?php echo $data['vigencia'] ?>);" value="<?php echo $resAplica['aplica']?>"<?php echo $resAplica['aplica'] == '1' ? 'checked' : '2' ;?>>
                                                                        <span class="slider round"></span>
                                                                    </label>
                                                                </div>
                                            <!-- <button type="button" class="btn btn-warning" name="decisionObligatorio" data-toggle="modal" data-target="#modal-decide-obligatorio<?php //echo $data['id_documento']; ?>"><i class="fas fa-question"></i></button> -->
                                                        <?php
                                                            }
                                                        ?>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-auto">
                                                    <?php
                                                        if ($consultaIdDocumento == 0) {
                                                    ?>
                                                            <i class="fas fa-times fa-3x documentIcon" style="color: red;"></i>
                                                    <?php
                                                        } else {
                                                            if ($resAplica['estatus'] == 2) {
                                                    ?>
                                                            <i class="fas fa-ban fa-3x documentIcon" style="color: red;"></i>
                                                    <?php
                                                            } else {
                                                    ?>
                                                            <i class="fas fa-check fa-3x documentIcon" style="color: green;"></i>
                                                    <?php
                                                            }
                                                        }
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </label>
                            </form>
                        </div>

                        <!-- Modal Para Eliminar Documento -->
                        <div class="modal fade" id="modal-delete-documento<?php echo $data['id_documento']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Eliminar Documento</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="server/delete-adminDocumentosUsuarios.php" method="POST">
                                        <input type="hidden" name="id" value="<?php echo $idEmpresa ?>">
                                        <input type="hidden" name="idU" value="<?php echo $idVerUsuario ?>">
                                        <!--<input type="hidden" name="rfc" value="<?php //echo $rfc ?>">-->
                                        <input type="hidden" name="idDocumento" value="<?php echo $data['id_documento']?>">
                                        <input type="hidden" name="nombreDocumento" value="<?php echo $nombreSinAcentos?>">
                                        <div class="modal-body">
                                            <h5>¿Estás seguro de eliminar el documento con el nombre: <?php echo $data['nombre']; ?>?</h5>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
                                            <button type="submit" class="btn btn-danger">Si</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Para Ver Documento -->
                        <div class="modal fade" id="modal-ver-documento<?php echo $data['id_documento']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-xl" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel"><?php echo $data['nombre'] ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <object class="PDFdoc" width="100%" height="550px" type="application/pdf" data="<?php echo 'http://'.$_SERVER['HTTP_HOST'].'/11CuatrimestresEstadias/Proyecto/UniamaOficial/Clientes/'.$idEmpresa.'/empleados/'.$idVerUsuario.'/'.$nombreSinAcentos.'.pdf' ?>"></object>
                                        
                                        <!-- <object class="PDFdoc" width="100%" height="550px" type="application/pdf" data="<?php //echo 'Clientes/'.$idEmpresa.'/empleados/'.$idVerUsuario.'/'.$nombreSinAcentos.'.pdf' ?>"></object> -->
                                        
                                        <!-- <object class="PDFdoc" width="100%" height="550px" type="application/pdf" data="<?php //echo 'Clientes/'.$idEmpresa.'/empleados/'.$idVerUsuario.'/'.$nombreSinAcentos.'.pdf' ?>"></object> -->
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal Para Decidir obligacion Del Documento -->
                        <!-- <div class="modal fade" id="modal-decide-obligatorio<?php //echo $data['id_documento']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Obligatorio</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="server/update-adminDocumentosUsuarios.php" method="POST">
                                        <input type="hidden" name="id" value="<?php //echo $idEmpresa ?>">
                                        <input type="hidden" name="idU" value="<?php //echo $idVerUsuario ?>">
                                        <input type="hidden" name="idDocumento" value="<?php //echo $data['id_documento']?>">
                                        <input type="hidden" name="vigencia" value="<?php //echo $data['vigencia'] ?>">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <small>Obligatorio</small>
                                                    <select class="form-control" name="decision">
                                                        <option value="#">Obligatorio</option>
                                                        <option value="1">Si</option>
                                                        <option value="2">No</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-danger">Guardar Cambios</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div> -->

                        <?php
                            }
                        ?>

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
    function updateEstatus(idAdDocumentosObligacion, nombreSwitch, idE, idU, vigencia)
    {
        if(document.getElementById(nombreSwitch).checked==false)
        {
            cambioEstado = 2;
        }
        else
        {
            cambioEstado = 1;
        }

        console.log(idAdDocumentosObligacion);
        console.log(nombreSwitch);
        console.log(idE);
        console.log(idU);
        console.log(vigencia);
        console.log(cambioEstado);

        $.ajax({
            cache: false,
            dataType: 'json',
            url: 'server/updateEstatusObligacion.php',
            type: 'POST',
            data: {"id":idAdDocumentosObligacion, "estado":cambioEstado, "idE":idE, "idU":idU, "vigencia":vigencia},
            success:function(data){
            },
        });
    }
</script>

</body>
</html>
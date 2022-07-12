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
        $breadcrumb = "Tablero / Configuración De Empresa / Empresa / Departamentos";
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
                    <h1 class="h3 mb-2 text-gray-800">Departamentos</h1>

                    <!-- Formulario -->
                    <form class="form mt-3 mb-5" action="server/insert-adminDepartamentos.php" method="POST">
                        <h1 class="h5 mb-2 text-gray-800">Agregar departamentos.</h1>
                        <input type="hidden" name="id" value="<?php echo $idEmpresa ?>">
                        <div class="row pt-3  pb-4">
                            <div class="col-4">
                                <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" required onkeyup="mayusculas(this)" maxlength="30">
                            </div>
                            <div class="col-4">
                                <select class="form-control" id="jerarquia" name="jerarquia" required onchange="cargarDependenciaDepartamentos()">
                                    <option value="" disabled selected>Jerarqu&iacute;a</option>
                                    <option value="1">NIVEL 1</option>
                                    <option value="2">NIVEL 2</option>
                                    <option value="3">NIVEL 3</option>
                                    <option value="4">NIVEL 4</option>
                                    <option value="5">NIVEL 5</option>
                                    <option value="6">NIVEL 6</option>
                                    <option value="7">NIVEL 7</option>
                                    <option value="8">NIVEL 8</option>
                                    <option value="9">NIVEL 9</option>
                                    <option value="10">NIVEL 10</option>
                                    <option value="11">NIVEL 11</option>
                                    <option value="12">NIVEL 12</option>
                                    <option value="13">NIVEL 13</option>
                                    <option value="14">NIVEL 14</option>
                                    <option value="15">NIVEL 15</option>
                                    <option value="16">NIVEL 16</option>
                                    <option value="17">NIVEL 17</option>
                                    <option value="18">NIVEL 18</option>
                                    <option value="19">NIVEL 19</option>
                                    <option value="20">NIVEL 20</option>
                                </select>
                            </div>
                            <div class="col-4">
                                <select class="form-control" id="dependeDe" name="dependeDe" required>
                                    <option value="" disabled selected>Depende De</option>
                                    <?php
                                        $query = mysqli_query($conexion, "SELECT * FROM catalogo_departamentos WHERE id_empresa = '$idEmpresa' AND estatus = 1");
                                        while ($data = mysqli_fetch_assoc($query)){
                                    ?>
                                            <option value="<?php echo $data["id_departamento"]; ?>"><?php echo $data["nombre"]; ?></option>
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
                            <h6 class="m-0 font-weight-bold text-primary">Departamentos Registrados</h6>
                        </div>

                        <?php
                            $res = mysqli_query($conexion, "SELECT * FROM catalogo_departamentos WHERE id_empresa = $idEmpresa ORDER BY jerarquia ASC")
                        ?>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Nombre</th>
                                            <th>Depende De</th>
                                            <th>Jerarqu&iacute;a</th>
                                            <th>Estatus</th>
                                            <th colspan="2">Acciones</th>
                                        </tr>
                                    </thead>
                                    
                                    <?php
                                        while($data = mysqli_fetch_array($res)){
                                    ?>

                                    <tbody>
                                        <tr>
                                            <td><?php echo $data['nombre'] ?></td>
                                            <td>
                                                <?php
                                                    if ($data['depende_de'] == 0) {
                                                        echo "N/A";
                                                    } else {
                                                        $depaDependeDe = $data['depende_de'];
                                                        $departamento = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT nombre FROM catalogo_departamentos WHERE id_departamento = $depaDependeDe"));
                                                        echo $departamento['nombre'];
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php
                                                    if ($data['jerarquia'] == 1) {
                                                        echo "NIVEL 1";
                                                    } elseif ($data['jerarquia'] == 2) {
                                                        echo "NIVEL 2";
                                                    } elseif ($data['jerarquia'] == 3) {
                                                        echo "NIVEL 3";
                                                    } elseif ($data['jerarquia'] == 4) {
                                                        echo "NIVEL 4";
                                                    } elseif ($data['jerarquia'] == 5) {
                                                        echo "NIVEL 5";
                                                    } elseif ($data['jerarquia'] == 6) {
                                                        echo "NIVEL 6";
                                                    } elseif ($data['jerarquia'] == 7) {
                                                        echo "NIVEL 7";
                                                    } elseif ($data['jerarquia'] == 8) {
                                                        echo "NIVEL 8";
                                                    } elseif ($data['jerarquia'] == 9) {
                                                        echo "NIVEL 9";
                                                    } elseif ($data['jerarquia'] == 10) {
                                                        echo "NIVEL 10";
                                                    } elseif ($data['jerarquia'] == 11) {
                                                        echo "NIVEL 11";
                                                    } elseif ($data['jerarquia'] == 12) {
                                                        echo "NIVEL 12";
                                                    } elseif ($data['jerarquia'] == 13) {
                                                        echo "NIVEL 13";
                                                    } elseif ($data['jerarquia'] == 14) {
                                                        echo "NIVEL 14";
                                                    } elseif ($data['jerarquia'] == 15) {
                                                        echo "NIVEL 15";
                                                    } elseif ($data['jerarquia'] == 16) {
                                                        echo "NIVEL 16";
                                                    } elseif ($data['jerarquia'] == 17) {
                                                        echo "NIVEL 17";
                                                    } elseif ($data['jerarquia'] == 18) {
                                                        echo "NIVEL 18";
                                                    } elseif ($data['jerarquia'] == 19) {
                                                        echo "NIVEL 19";
                                                    } elseif ($data['jerarquia'] == 20) {
                                                        echo "NIVEL 20";
                                                    } elseif (empty($data['jerarquia']) || $data['jerarquia'] == 0) {
                                                        echo "N/A";
                                                    }
                                                ?>
                                            </td>
                                            <td class="btn-switch">
                                                <label class="switch">
                                                    <input type="checkbox" id="<?php echo $data['id_departamento']?>" name="btnSwitch" onclick="updateEstatus(<?php echo $data['id_departamento']?>,<?php echo $data['id_departamento']?>);" value="<?php echo $data['estatus']?>" <?php echo $data['estatus'] == '1' ? 'checked' : '2' ;?>>
                                                    <span class="slider round"></span>
                                                </label>
                                            </td>
                                            <td class="btn-modificar">
                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-edit-departamento<?php echo $data['id_departamento']; ?>"><i class="fas fa-user-edit"></i></button>
                                            </td>
                                            <td class="btn-eliminar">
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-departamento<?php echo $data['id_departamento']; ?>"><i class="fas fa-trash-alt"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>

                                    <!-- Modal Para Modificar Departamentos -->
                                    <div class="modal fade" id="modal-edit-departamento<?php echo $data['id_departamento']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Modificar Departamento</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="server/update-adminDepartamentos.php" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $data['id_departamento']?>">
                                                    <div class="modal-body">
                                                        <div class="col">
                                                            <div class="row pt-3">
                                                                <div class="col-12">
                                                                    <small>Nombre De Departamento</small>
                                                                    <input type="text" class="form-control" name="nombre2" placeholder="Nombre De Departamento" value="<?php echo $data['nombre'] ?>" onkeyup="mayusculas(this)"maxlength="30">
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <!-- Jerarquía-->
                                                                <div class="col-12 mt-3">
                                                                    <small>Jerarqu&iacute;a</small>
                                                                    <select class="form-control" id="jerarquia<?php echo $data['id_departamento']; ?>" name="jerarquia2" onchange="cargarDependenciaDepartamentosModal(<?php echo $data['id_departamento']; ?>)">
                                                                        <?php
                                                                            if ($data['jerarquia'] == 1) {
                                                                        ?>
                                                                                <option value="" disabled>JERARQU&Iacute;A</option>
                                                                                <option value="1" selected>NIVEL 1</option>
                                                                                <option value="2">NIVEL 2</option>
                                                                                <option value="3">NIVEL 3</option>
                                                                                <option value="4">NIVEL 4</option>
                                                                                <option value="5">NIVEL 5</option>
                                                                                <option value="6">NIVEL 6</option>
                                                                                <option value="7">NIVEL 7</option>
                                                                                <option value="8">NIVEL 8</option>
                                                                                <option value="9">NIVEL 9</option>
                                                                                <option value="10">NIVEL 10</option>
                                                                                <option value="11">NIVEL 11</option>
                                                                                <option value="12">NIVEL 12</option>
                                                                                <option value="13">NIVEL 13</option>
                                                                                <option value="14">NIVEL 14</option>
                                                                                <option value="15">NIVEL 15</option>
                                                                                <option value="16">NIVEL 16</option>
                                                                                <option value="17">NIVEL 17</option>
                                                                                <option value="18">NIVEL 18</option>
                                                                                <option value="19">NIVEL 19</option>
                                                                                <option value="20">NIVEL 20</option>
                                                                        <?php
                                                                            } elseif ($data['jerarquia'] == 2) {
                                                                        ?>
                                                                                <option value="" disabled>JERARQU&Iacute;A</option>
                                                                                <option value="1">NIVEL 1</option>
                                                                                <option value="2" selected>NIVEL 2</option>
                                                                                <option value="3">NIVEL 3</option>
                                                                                <option value="4">NIVEL 4</option>
                                                                                <option value="5">NIVEL 5</option>
                                                                                <option value="6">NIVEL 6</option>
                                                                                <option value="7">NIVEL 7</option>
                                                                                <option value="8">NIVEL 8</option>
                                                                                <option value="9">NIVEL 9</option>
                                                                                <option value="10">NIVEL 10</option>
                                                                                <option value="11">NIVEL 11</option>
                                                                                <option value="12">NIVEL 12</option>
                                                                                <option value="13">NIVEL 13</option>
                                                                                <option value="14">NIVEL 14</option>
                                                                                <option value="15">NIVEL 15</option>
                                                                                <option value="16">NIVEL 16</option>
                                                                                <option value="17">NIVEL 17</option>
                                                                                <option value="18">NIVEL 18</option>
                                                                                <option value="19">NIVEL 19</option>
                                                                                <option value="20">NIVEL 20</option>
                                                                        <?php
                                                                            } elseif ($data['jerarquia'] == 3) {
                                                                        ?>
                                                                                <option value="" disabled>JERARQU&Iacute;A</option>
                                                                                <option value="1">NIVEL 1</option>
                                                                                <option value="2">NIVEL 2</option>
                                                                                <option value="3" selected>NIVEL 3</option>
                                                                                <option value="4">NIVEL 4</option>
                                                                                <option value="5">NIVEL 5</option>
                                                                                <option value="6">NIVEL 6</option>
                                                                                <option value="7">NIVEL 7</option>
                                                                                <option value="8">NIVEL 8</option>
                                                                                <option value="9">NIVEL 9</option>
                                                                                <option value="10">NIVEL 10</option>
                                                                                <option value="11">NIVEL 11</option>
                                                                                <option value="12">NIVEL 12</option>
                                                                                <option value="13">NIVEL 13</option>
                                                                                <option value="14">NIVEL 14</option>
                                                                                <option value="15">NIVEL 15</option>
                                                                                <option value="16">NIVEL 16</option>
                                                                                <option value="17">NIVEL 17</option>
                                                                                <option value="18">NIVEL 18</option>
                                                                                <option value="19">NIVEL 19</option>
                                                                                <option value="20">NIVEL 20</option>
                                                                        <?php
                                                                            } elseif ($data['jerarquia'] == 4) {
                                                                        ?>
                                                                                <option value="" disabled>JERARQU&Iacute;A</option>
                                                                                <option value="1">NIVEL 1</option>
                                                                                <option value="2">NIVEL 2</option>
                                                                                <option value="3">NIVEL 3</option>
                                                                                <option value="4" selected>NIVEL 4</option>
                                                                                <option value="5">NIVEL 5</option>
                                                                                <option value="6">NIVEL 6</option>
                                                                                <option value="7">NIVEL 7</option>
                                                                                <option value="8">NIVEL 8</option>
                                                                                <option value="9">NIVEL 9</option>
                                                                                <option value="10">NIVEL 10</option>
                                                                                <option value="11">NIVEL 11</option>
                                                                                <option value="12">NIVEL 12</option>
                                                                                <option value="13">NIVEL 13</option>
                                                                                <option value="14">NIVEL 14</option>
                                                                                <option value="15">NIVEL 15</option>
                                                                                <option value="16">NIVEL 16</option>
                                                                                <option value="17">NIVEL 17</option>
                                                                                <option value="18">NIVEL 18</option>
                                                                                <option value="19">NIVEL 19</option>
                                                                                <option value="20">NIVEL 20</option>
                                                                        <?php
                                                                            } elseif ($data['jerarquia'] == 5) {
                                                                        ?>
                                                                                <option value="" disabled>JERARQU&Iacute;A</option>
                                                                                <option value="1">NIVEL 1</option>
                                                                                <option value="2">NIVEL 2</option>
                                                                                <option value="3">NIVEL 3</option>
                                                                                <option value="4">NIVEL 4</option>
                                                                                <option value="5" selected>NIVEL 5</option>
                                                                                <option value="6">NIVEL 6</option>
                                                                                <option value="7">NIVEL 7</option>
                                                                                <option value="8">NIVEL 8</option>
                                                                                <option value="9">NIVEL 9</option>
                                                                                <option value="10">NIVEL 10</option>
                                                                                <option value="11">NIVEL 11</option>
                                                                                <option value="12">NIVEL 12</option>
                                                                                <option value="13">NIVEL 13</option>
                                                                                <option value="14">NIVEL 14</option>
                                                                                <option value="15">NIVEL 15</option>
                                                                                <option value="16">NIVEL 16</option>
                                                                                <option value="17">NIVEL 17</option>
                                                                                <option value="18">NIVEL 18</option>
                                                                                <option value="19">NIVEL 19</option>
                                                                                <option value="20">NIVEL 20</option>
                                                                        <?php
                                                                            } elseif ($data['jerarquia'] == 6) {
                                                                        ?>
                                                                                <option value="" disabled>JERARQU&Iacute;A</option>
                                                                                <option value="1">NIVEL 1</option>
                                                                                <option value="2">NIVEL 2</option>
                                                                                <option value="3">NIVEL 3</option>
                                                                                <option value="4">NIVEL 4</option>
                                                                                <option value="5">NIVEL 5</option>
                                                                                <option value="6" selected>NIVEL 6</option>
                                                                                <option value="7">NIVEL 7</option>
                                                                                <option value="8">NIVEL 8</option>
                                                                                <option value="9">NIVEL 9</option>
                                                                                <option value="10">NIVEL 10</option>
                                                                                <option value="11">NIVEL 11</option>
                                                                                <option value="12">NIVEL 12</option>
                                                                                <option value="13">NIVEL 13</option>
                                                                                <option value="14">NIVEL 14</option>
                                                                                <option value="15">NIVEL 15</option>
                                                                                <option value="16">NIVEL 16</option>
                                                                                <option value="17">NIVEL 17</option>
                                                                                <option value="18">NIVEL 18</option>
                                                                                <option value="19">NIVEL 19</option>
                                                                                <option value="20">NIVEL 20</option>
                                                                        <?php
                                                                            } elseif ($data['jerarquia'] == 7) {
                                                                        ?>
                                                                                <option value="" disabled>JERARQU&Iacute;A</option>
                                                                                <option value="1">NIVEL 1</option>
                                                                                <option value="2">NIVEL 2</option>
                                                                                <option value="3">NIVEL 3</option>
                                                                                <option value="4">NIVEL 4</option>
                                                                                <option value="5">NIVEL 5</option>
                                                                                <option value="6">NIVEL 6</option>
                                                                                <option value="7" selected>NIVEL 7</option>
                                                                                <option value="8">NIVEL 8</option>
                                                                                <option value="9">NIVEL 9</option>
                                                                                <option value="10">NIVEL 10</option>
                                                                                <option value="11">NIVEL 11</option>
                                                                                <option value="12">NIVEL 12</option>
                                                                                <option value="13">NIVEL 13</option>
                                                                                <option value="14">NIVEL 14</option>
                                                                                <option value="15">NIVEL 15</option>
                                                                                <option value="16">NIVEL 16</option>
                                                                                <option value="17">NIVEL 17</option>
                                                                                <option value="18">NIVEL 18</option>
                                                                                <option value="19">NIVEL 19</option>
                                                                                <option value="20">NIVEL 20</option>
                                                                        <?php
                                                                            } elseif ($data['jerarquia'] == 8) {
                                                                        ?>
                                                                                <option value="" disabled>JERARQU&Iacute;A</option>
                                                                                <option value="1">NIVEL 1</option>
                                                                                <option value="2">NIVEL 2</option>
                                                                                <option value="3">NIVEL 3</option>
                                                                                <option value="4">NIVEL 4</option>
                                                                                <option value="5">NIVEL 5</option>
                                                                                <option value="6">NIVEL 6</option>
                                                                                <option value="7">NIVEL 7</option>
                                                                                <option value="8" selected>NIVEL 8</option>
                                                                                <option value="9">NIVEL 9</option>
                                                                                <option value="10">NIVEL 10</option>
                                                                                <option value="11">NIVEL 11</option>
                                                                                <option value="12">NIVEL 12</option>
                                                                                <option value="13">NIVEL 13</option>
                                                                                <option value="14">NIVEL 14</option>
                                                                                <option value="15">NIVEL 15</option>
                                                                                <option value="16">NIVEL 16</option>
                                                                                <option value="17">NIVEL 17</option>
                                                                                <option value="18">NIVEL 18</option>
                                                                                <option value="19">NIVEL 19</option>
                                                                                <option value="20">NIVEL 20</option>
                                                                        <?php
                                                                            } elseif ($data['jerarquia'] == 9) {
                                                                        ?>
                                                                                <option value="" disabled>JERARQU&Iacute;A</option>
                                                                                <option value="1">NIVEL 1</option>
                                                                                <option value="2">NIVEL 2</option>
                                                                                <option value="3">NIVEL 3</option>
                                                                                <option value="4">NIVEL 4</option>
                                                                                <option value="5">NIVEL 5</option>
                                                                                <option value="6">NIVEL 6</option>
                                                                                <option value="7">NIVEL 7</option>
                                                                                <option value="8">NIVEL 8</option>
                                                                                <option value="9" selected>NIVEL 9</option>
                                                                                <option value="10">NIVEL 10</option>
                                                                                <option value="11">NIVEL 11</option>
                                                                                <option value="12">NIVEL 12</option>
                                                                                <option value="13">NIVEL 13</option>
                                                                                <option value="14">NIVEL 14</option>
                                                                                <option value="15">NIVEL 15</option>
                                                                                <option value="16">NIVEL 16</option>
                                                                                <option value="17">NIVEL 17</option>
                                                                                <option value="18">NIVEL 18</option>
                                                                                <option value="19">NIVEL 19</option>
                                                                                <option value="20">NIVEL 20</option>
                                                                        <?php
                                                                            } elseif ($data['jerarquia'] == 10) {
                                                                        ?>
                                                                                <option value="" disabled>JERARQU&Iacute;A</option>
                                                                                <option value="1">NIVEL 1</option>
                                                                                <option value="2">NIVEL 2</option>
                                                                                <option value="3">NIVEL 3</option>
                                                                                <option value="4">NIVEL 4</option>
                                                                                <option value="5">NIVEL 5</option>
                                                                                <option value="6">NIVEL 6</option>
                                                                                <option value="7">NIVEL 7</option>
                                                                                <option value="8">NIVEL 8</option>
                                                                                <option value="9">NIVEL 9</option>
                                                                                <option value="10" selected>NIVEL 10</option>
                                                                                <option value="11">NIVEL 11</option>
                                                                                <option value="12">NIVEL 12</option>
                                                                                <option value="13">NIVEL 13</option>
                                                                                <option value="14">NIVEL 14</option>
                                                                                <option value="15">NIVEL 15</option>
                                                                                <option value="16">NIVEL 16</option>
                                                                                <option value="17">NIVEL 17</option>
                                                                                <option value="18">NIVEL 18</option>
                                                                                <option value="19">NIVEL 19</option>
                                                                                <option value="20">NIVEL 20</option>
                                                                        <?php
                                                                            } elseif ($data['jerarquia'] == 11) {
                                                                        ?>
                                                                                <option value="" disabled>JERARQU&Iacute;A</option>
                                                                                <option value="1">NIVEL 1</option>
                                                                                <option value="2">NIVEL 2</option>
                                                                                <option value="3">NIVEL 3</option>
                                                                                <option value="4">NIVEL 4</option>
                                                                                <option value="5">NIVEL 5</option>
                                                                                <option value="6">NIVEL 6</option>
                                                                                <option value="7">NIVEL 7</option>
                                                                                <option value="8">NIVEL 8</option>
                                                                                <option value="9">NIVEL 9</option>
                                                                                <option value="10">NIVEL 10</option>
                                                                                <option value="11" selected>NIVEL 11</option>
                                                                                <option value="12">NIVEL 12</option>
                                                                                <option value="13">NIVEL 13</option>
                                                                                <option value="14">NIVEL 14</option>
                                                                                <option value="15">NIVEL 15</option>
                                                                                <option value="16">NIVEL 16</option>
                                                                                <option value="17">NIVEL 17</option>
                                                                                <option value="18">NIVEL 18</option>
                                                                                <option value="19">NIVEL 19</option>
                                                                                <option value="20">NIVEL 20</option>
                                                                        <?php
                                                                            } elseif ($data['jerarquia'] == 12) {
                                                                        ?>
                                                                                <option value="" disabled>JERARQU&Iacute;A</option>
                                                                                <option value="1">NIVEL 1</option>
                                                                                <option value="2">NIVEL 2</option>
                                                                                <option value="3">NIVEL 3</option>
                                                                                <option value="4">NIVEL 4</option>
                                                                                <option value="5">NIVEL 5</option>
                                                                                <option value="6">NIVEL 6</option>
                                                                                <option value="7">NIVEL 7</option>
                                                                                <option value="8">NIVEL 8</option>
                                                                                <option value="9">NIVEL 9</option>
                                                                                <option value="10">NIVEL 10</option>
                                                                                <option value="11">NIVEL 11</option>
                                                                                <option value="12" selected>NIVEL 12</option>
                                                                                <option value="13">NIVEL 13</option>
                                                                                <option value="14">NIVEL 14</option>
                                                                                <option value="15">NIVEL 15</option>
                                                                                <option value="16">NIVEL 16</option>
                                                                                <option value="17">NIVEL 17</option>
                                                                                <option value="18">NIVEL 18</option>
                                                                                <option value="19">NIVEL 19</option>
                                                                                <option value="20">NIVEL 20</option>
                                                                        <?php
                                                                            } elseif ($data['jerarquia'] == 13) {
                                                                        ?>
                                                                                <option value="" disabled>JERARQU&Iacute;A</option>
                                                                                <option value="1">NIVEL 1</option>
                                                                                <option value="2">NIVEL 2</option>
                                                                                <option value="3">NIVEL 3</option>
                                                                                <option value="4">NIVEL 4</option>
                                                                                <option value="5">NIVEL 5</option>
                                                                                <option value="6">NIVEL 6</option>
                                                                                <option value="7">NIVEL 7</option>
                                                                                <option value="8">NIVEL 8</option>
                                                                                <option value="9">NIVEL 9</option>
                                                                                <option value="10">NIVEL 10</option>
                                                                                <option value="11">NIVEL 11</option>
                                                                                <option value="12">NIVEL 12</option>
                                                                                <option value="13" selected>NIVEL 13</option>
                                                                                <option value="14">NIVEL 14</option>
                                                                                <option value="15">NIVEL 15</option>
                                                                                <option value="16">NIVEL 16</option>
                                                                                <option value="17">NIVEL 17</option>
                                                                                <option value="18">NIVEL 18</option>
                                                                                <option value="19">NIVEL 19</option>
                                                                                <option value="20">NIVEL 20</option>
                                                                        <?php
                                                                            } elseif ($data['jerarquia'] == 14) {
                                                                        ?>
                                                                                <option value="" disabled>JERARQU&Iacute;A</option>
                                                                                <option value="1">NIVEL 1</option>
                                                                                <option value="2">NIVEL 2</option>
                                                                                <option value="3">NIVEL 3</option>
                                                                                <option value="4">NIVEL 4</option>
                                                                                <option value="5">NIVEL 5</option>
                                                                                <option value="6">NIVEL 6</option>
                                                                                <option value="7">NIVEL 7</option>
                                                                                <option value="8">NIVEL 8</option>
                                                                                <option value="9">NIVEL 9</option>
                                                                                <option value="10">NIVEL 10</option>
                                                                                <option value="11">NIVEL 11</option>
                                                                                <option value="12">NIVEL 12</option>
                                                                                <option value="13">NIVEL 13</option>
                                                                                <option value="14" selected>NIVEL 14</option>
                                                                                <option value="15">NIVEL 15</option>
                                                                                <option value="16">NIVEL 16</option>
                                                                                <option value="17">NIVEL 17</option>
                                                                                <option value="18">NIVEL 18</option>
                                                                                <option value="19">NIVEL 19</option>
                                                                                <option value="20">NIVEL 20</option>
                                                                        <?php
                                                                            } elseif ($data['jerarquia'] == 15) {
                                                                        ?>
                                                                                <option value="" disabled>JERARQU&Iacute;A</option>
                                                                                <option value="1">NIVEL 1</option>
                                                                                <option value="2">NIVEL 2</option>
                                                                                <option value="3">NIVEL 3</option>
                                                                                <option value="4">NIVEL 4</option>
                                                                                <option value="5">NIVEL 5</option>
                                                                                <option value="6">NIVEL 6</option>
                                                                                <option value="7">NIVEL 7</option>
                                                                                <option value="8">NIVEL 8</option>
                                                                                <option value="9">NIVEL 9</option>
                                                                                <option value="10">NIVEL 10</option>
                                                                                <option value="11">NIVEL 11</option>
                                                                                <option value="12">NIVEL 12</option>
                                                                                <option value="13">NIVEL 13</option>
                                                                                <option value="14">NIVEL 14</option>
                                                                                <option value="15" selected>NIVEL 15</option>
                                                                                <option value="16">NIVEL 16</option>
                                                                                <option value="17">NIVEL 17</option>
                                                                                <option value="18">NIVEL 18</option>
                                                                                <option value="19">NIVEL 19</option>
                                                                                <option value="20">NIVEL 20</option>
                                                                        <?php
                                                                            } elseif ($data['jerarquia'] == 16) {
                                                                        ?>
                                                                                <option value="" disabled>JERARQU&Iacute;A</option>
                                                                                <option value="1">NIVEL 1</option>
                                                                                <option value="2">NIVEL 2</option>
                                                                                <option value="3">NIVEL 3</option>
                                                                                <option value="4">NIVEL 4</option>
                                                                                <option value="5">NIVEL 5</option>
                                                                                <option value="6">NIVEL 6</option>
                                                                                <option value="7">NIVEL 7</option>
                                                                                <option value="8">NIVEL 8</option>
                                                                                <option value="9">NIVEL 9</option>
                                                                                <option value="10">NIVEL 10</option>
                                                                                <option value="11">NIVEL 11</option>
                                                                                <option value="12">NIVEL 12</option>
                                                                                <option value="13">NIVEL 13</option>
                                                                                <option value="14">NIVEL 14</option>
                                                                                <option value="15">NIVEL 15</option>
                                                                                <option value="16" selected>NIVEL 16</option>
                                                                                <option value="17">NIVEL 17</option>
                                                                                <option value="18">NIVEL 18</option>
                                                                                <option value="19">NIVEL 19</option>
                                                                                <option value="20">NIVEL 20</option>
                                                                        <?php
                                                                            } elseif ($data['jerarquia'] == 17) {
                                                                        ?>
                                                                                <option value="" disabled>JERARQU&Iacute;A</option>
                                                                                <option value="1">NIVEL 1</option>
                                                                                <option value="2">NIVEL 2</option>
                                                                                <option value="3">NIVEL 3</option>
                                                                                <option value="4">NIVEL 4</option>
                                                                                <option value="5">NIVEL 5</option>
                                                                                <option value="6">NIVEL 6</option>
                                                                                <option value="7">NIVEL 7</option>
                                                                                <option value="8">NIVEL 8</option>
                                                                                <option value="9">NIVEL 9</option>
                                                                                <option value="10">NIVEL 10</option>
                                                                                <option value="11">NIVEL 11</option>
                                                                                <option value="12">NIVEL 12</option>
                                                                                <option value="13">NIVEL 13</option>
                                                                                <option value="14">NIVEL 14</option>
                                                                                <option value="15">NIVEL 15</option>
                                                                                <option value="16">NIVEL 16</option>
                                                                                <option value="17" selected>NIVEL 17</option>
                                                                                <option value="18">NIVEL 18</option>
                                                                                <option value="19">NIVEL 19</option>
                                                                                <option value="20">NIVEL 20</option>
                                                                        <?php
                                                                            } elseif ($data['jerarquia'] == 18) {
                                                                        ?>
                                                                                <option value="" disabled>JERARQU&Iacute;A</option>
                                                                                <option value="1">NIVEL 1</option>
                                                                                <option value="2">NIVEL 2</option>
                                                                                <option value="3">NIVEL 3</option>
                                                                                <option value="4">NIVEL 4</option>
                                                                                <option value="5">NIVEL 5</option>
                                                                                <option value="6">NIVEL 6</option>
                                                                                <option value="7">NIVEL 7</option>
                                                                                <option value="8">NIVEL 8</option>
                                                                                <option value="9">NIVEL 9</option>
                                                                                <option value="10">NIVEL 10</option>
                                                                                <option value="11">NIVEL 11</option>
                                                                                <option value="12">NIVEL 12</option>
                                                                                <option value="13">NIVEL 13</option>
                                                                                <option value="14">NIVEL 14</option>
                                                                                <option value="15">NIVEL 15</option>
                                                                                <option value="16">NIVEL 16</option>
                                                                                <option value="17">NIVEL 17</option>
                                                                                <option value="18" selected>NIVEL 18</option>
                                                                                <option value="19">NIVEL 19</option>
                                                                                <option value="20">NIVEL 20</option>
                                                                        <?php
                                                                            } elseif ($data['jerarquia'] == 19) {
                                                                        ?>
                                                                                <option value="" disabled>JERARQU&Iacute;A</option>
                                                                                <option value="1">NIVEL 1</option>
                                                                                <option value="2">NIVEL 2</option>
                                                                                <option value="3">NIVEL 3</option>
                                                                                <option value="4">NIVEL 4</option>
                                                                                <option value="5">NIVEL 5</option>
                                                                                <option value="6">NIVEL 6</option>
                                                                                <option value="7">NIVEL 7</option>
                                                                                <option value="8">NIVEL 8</option>
                                                                                <option value="9">NIVEL 9</option>
                                                                                <option value="10">NIVEL 10</option>
                                                                                <option value="11">NIVEL 11</option>
                                                                                <option value="12">NIVEL 12</option>
                                                                                <option value="13">NIVEL 13</option>
                                                                                <option value="14">NIVEL 14</option>
                                                                                <option value="15">NIVEL 15</option>
                                                                                <option value="16">NIVEL 16</option>
                                                                                <option value="17">NIVEL 17</option>
                                                                                <option value="18">NIVEL 18</option>
                                                                                <option value="19" selected>NIVEL 19</option>
                                                                                <option value="20">NIVEL 20</option>
                                                                        <?php
                                                                            } elseif ($data['jerarquia'] == 20) {
                                                                        ?>
                                                                                <option value="" disabled>JERARQU&Iacute;A</option>
                                                                                <option value="1">NIVEL 1</option>
                                                                                <option value="2">NIVEL 2</option>
                                                                                <option value="3">NIVEL 3</option>
                                                                                <option value="4">NIVEL 4</option>
                                                                                <option value="5">NIVEL 5</option>
                                                                                <option value="6">NIVEL 6</option>
                                                                                <option value="7">NIVEL 7</option>
                                                                                <option value="8">NIVEL 8</option>
                                                                                <option value="9">NIVEL 9</option>
                                                                                <option value="10">NIVEL 10</option>
                                                                                <option value="11">NIVEL 11</option>
                                                                                <option value="12">NIVEL 12</option>
                                                                                <option value="13">NIVEL 13</option>
                                                                                <option value="14">NIVEL 14</option>
                                                                                <option value="15">NIVEL 15</option>
                                                                                <option value="16">NIVEL 16</option>
                                                                                <option value="17">NIVEL 17</option>
                                                                                <option value="18">NIVEL 18</option>
                                                                                <option value="19">NIVEL 19</option>
                                                                                <option value="20" selected>NIVEL 20</option>
                                                                        <?php
                                                                            } else {
                                                                        ?>
                                                                                <option value="" disabled selected>JERARQU&Iacute;A</option>
                                                                                <option value="1">NIVEL 1</option>
                                                                                <option value="2">NIVEL 2</option>
                                                                                <option value="3">NIVEL 3</option>
                                                                                <option value="4">NIVEL 4</option>
                                                                                <option value="5">NIVEL 5</option>
                                                                                <option value="6">NIVEL 6</option>
                                                                                <option value="7">NIVEL 7</option>
                                                                                <option value="8">NIVEL 8</option>
                                                                                <option value="9">NIVEL 9</option>
                                                                                <option value="10">NIVEL 10</option>
                                                                                <option value="11">NIVEL 11</option>
                                                                                <option value="12">NIVEL 12</option>
                                                                                <option value="13">NIVEL 13</option>
                                                                                <option value="14">NIVEL 14</option>
                                                                                <option value="15">NIVEL 15</option>
                                                                                <option value="16">NIVEL 16</option>
                                                                                <option value="17">NIVEL 17</option>
                                                                                <option value="18">NIVEL 18</option>
                                                                                <option value="19">NIVEL 19</option>
                                                                                <option value="20">NIVEL 20</option>
                                                                        <?php
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row pb-4">
                                                                <!-- Depende De -->
                                                                <div class="col-12 mt-3">
                                                                    <small>Depende De</small>
                                                                    <?php
                                                                        if ($data['jerarquia'] == 1) {
                                                                    ?>
                                                                    <select class="form-control" id="dependeDe<?php echo $data['id_departamento']; ?>" name="dependeDe2" disabled>
                                                                        <option value="" disabled selected>DEPENDE DE</option>
                                                                        <?php
                                                                            $dependeDe = $data['depende_de'];
                                                                            $sqlDependeDe = mysqli_query($conexion, "SELECT * FROM catalogo_departamentos WHERE id_empresa = '".$idEmpresa."' AND depende_de = '".$dependeDe."'");
                                                                            $resDependeDe = mysqli_fetch_assoc($sqlDependeDe);
                                                                            $idDependeDe = $resDependeDe['depende_de'];

                                                                            $query = mysqli_query($conexion, "SELECT * FROM catalogo_departamentos WHERE id_empresa = '".$idEmpresa."' AND estatus = 1 ORDER BY nombre ASC");
                                                                            while ($dataDependeDe = mysqli_fetch_assoc($query)){
                                                                                $selected = '';
                                                                                if ($idDependeDe == $dataDependeDe['id_departamento']) {
                                                                                    echo '<option value="'.$dataDependeDe['id_departamento'].'" selected>'.$dataDependeDe["nombre"].'</option>';
                                                                                }
                                                                                else {
                                                                                    echo '<option value="'.$dataDependeDe['id_departamento'].'">'.$dataDependeDe["nombre"].'</option>';
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                    <?php
                                                                        } else {
                                                                    ?>
                                                                    <select class="form-control" id="dependeDe<?php echo $data['id_departamento']; ?>" name="dependeDe2">
                                                                        <option value="" disabled selected>DEPENDE DE</option>
                                                                        <?php
                                                                            $dependeDe = $data['depende_de'];
                                                                            $sqlDependeDe = mysqli_query($conexion, "SELECT * FROM catalogo_departamentos WHERE id_empresa = '".$idEmpresa."' AND depende_de = '".$dependeDe."'");
                                                                            $resDependeDe = mysqli_fetch_assoc($sqlDependeDe);
                                                                            $idDependeDe = $resDependeDe['depende_de'];

                                                                            $query = mysqli_query($conexion, "SELECT * FROM catalogo_departamentos WHERE id_empresa = '".$idEmpresa."' AND estatus = 1 ORDER BY nombre ASC");
                                                                            while ($dataDependeDe = mysqli_fetch_assoc($query)){
                                                                                $selected = '';
                                                                                if ($idDependeDe == $dataDependeDe['id_departamento']) {
                                                                                    echo '<option value="'.$dataDependeDe['id_departamento'].'" selected>'.$dataDependeDe["nombre"].'</option>';
                                                                                }
                                                                                else {
                                                                                    echo '<option value="'.$dataDependeDe['id_departamento'].'">'.$dataDependeDe["nombre"].'</option>';
                                                                                }
                                                                            }
                                                                        ?>
                                                                    </select>
                                                                    <?php
                                                                        }
                                                                    ?>
                                                                </div>
                                                            </div>
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

                                    <!-- Modal Para Eliminar Departamento -->
                                    <div class="modal fade" id="modal-delete-departamento<?php echo $data['id_departamento']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLabel">Eliminar Departamento</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="server/delete-adminDepartamentos.php" method="POST">
                                                    <input type="hidden" name="id" value="<?php echo $idEmpresa ?>">
                                                    <input type="hidden" name="idDepartamento" value="<?php echo $data['id_departamento']?>">
                                                    <div class="modal-body">
                                                        <h5>¿Estás seguro de eliminar el departamento con el nombre: <?php echo $data['nombre']; ?>?</h5>
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
    function updateEstatus(idAdDepartamentos, nombreSwitch)
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
            data: {"id":idAdDepartamentos, "estado":cambioEstado, "idBD":'id_departamento', "tablaBD":'catalogo_departamentos'},
            success:function(data){
            },
        });
    }
</script>

</body>
</html>
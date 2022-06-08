<?php
    require("../conexion.php");

    $id = $_POST["id"];
    $idDepartamento = $_POST["idDepartamento"];

    $consultaDepartamentoCatalogo = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM catalogo_puestos WHERE id_departamento = '$idDepartamento' AND id_empresa = '$id'"));
    $consultaDepartamentoUsuarioPerfiles = mysqli_num_rows(mysqli_query($conexion, "SELECT * FROM usuarios_perfiles WHERE il_departamento = '$idDepartamento' AND id_empresa = '$id'"));

    if ($consultaDepartamentoCatalogo == 0 && $consultaDepartamentoUsuarioPerfiles == 0) {
        $delete = "DELETE FROM catalogo_departamentos WHERE id_departamento = '$idDepartamento' AND id_empresa = '$id'";

        $resDelete = mysqli_query($conexion, $delete);

        if ($resDelete) {
            header ("Location: ../adminDepartamentos.php");
        } else {
            header ("Location: ../adminDepartamentos.php");
        }
    } else {
        echo '<script> alert("Este departamento está actualmente en uso, no se puede eliminar."); window.history.go(-1); </script>';
    }

    mysqli_close($conexion);
?>
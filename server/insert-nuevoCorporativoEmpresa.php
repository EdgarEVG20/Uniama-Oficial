<?php
    require("../conexion.php");

    error_reporting(0);
    $corporativo = $_POST["corporativo"];
    $empresa = $_POST["empresa"];

    $concorporativoEmpresa = mysqli_query($conexion, "SELECT * FROM corporativo_empresas WHERE id_corporativo = '$corporativo' AND id_empresa = '$empresa'");
    $res = mysqli_fetch_assoc($concorporativoEmpresa);
    $idCorporativo = $res['id_corporativo'];
    $idEmpresa = $res['id_empresa'];

    if ($corporativo !== $idCorporativo && $empresa !== $idEmpresa) {
        $insert = "INSERT INTO corporativo_empresas VALUES (null, '$corporativo', '$empresa', 1)";
        $resInsert = mysqli_query($conexion, $insert);

        if ($resInsert) {
            header ("Location: ../nuevoCorporativoEmpresa.php");
        } else {
            header ("Location: ../nuevoCorporativoEmpresa.php");
        }
    } else {
        echo '<script> alert("La empresa seleccionada ya está relacionada al corporativo seleccionado."); window.history.go(-1); </script>';
    }
    
    mysqli_close($conexion);
?>
<?php
    function conexion() {
        return new PDO('mysql:host=localhost; dbname=uniama', 'root', 'sci300megabyte', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }

    error_reporting(0);
    $pdo = conexion();

    $sql = "UPDATE ".$_POST['tablaBD']." SET estatus = ".$_POST['estado']." WHERE ".$_POST['idBD']." = ".$_POST['idHL']." AND id_empresa = ".$_POST['idEmpresa'];
    $query = $pdo->prepare($sql);
    $query->execute();
?>
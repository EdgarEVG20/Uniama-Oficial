<?php
    // Utilizaremos conexion PDO PHP
    function conexion() {
        return new PDO('mysql:host=localhost; dbname=uniama', 'root', 'sci300megabyte', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
    }

    // error_reporting(0);
    $pdo = conexion();

    $idDoc = $_POST['id'];
    $estatus = $_POST['estado'];
    $idEmpresa = $_POST['idE'];
    $idU = $_POST['idU'];
    $vigencia = $_POST['vigencia'];
    $fechaActual = date('Y-m-d');

    $conExistenciaDocumento = "SELECT * FROM archivos_documentos WHERE id_documento = ".$idDoc." AND id_empresa = ".$idEmpresa." AND id_usuario = ".$idU."";
    $result = $pdo->prepare($conExistenciaDocumento);
    $result->execute(); 
    $rows = $result->fetchColumn();

    // $query = $conexión->query($conExistenciaDocumento);

    if ($rows < 1) {
        $sql = "INSERT INTO archivos_documentos VALUES (null, '$idDoc', '$idEmpresa', '$idU', '$vigencia', '$fechaActual', 1, 2)";
        $query = $pdo->prepare($sql);
        $query->execute();

    } elseif ($rows > 0) {
        $sql = "UPDATE archivos_documentos SET aplica = ".$estatus." WHERE id_documento = ".$idDoc." AND id_usuario = ".$idU;
        $query = $pdo->prepare($sql);
        $query->execute();
        
    }

?>
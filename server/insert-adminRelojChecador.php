<?php
    require("../conexion.php");
    
    error_reporting(0);
    
    if (isset($_POST["subirArchivoXLSX"])) {

        $id = $_POST['id'];
        $opcionFormato = $_POST['opcionFormato'];

        $archivoTemp = '../SubidasExcel/'.$_FILES['archivo']['name'];
        move_uploaded_file($_FILES['archivo']['tmp_name'], $archivoTemp);

        if ($opcionFormato == 1) {
            $sql = "LOAD DATA LOCAL INFILE '".$archivoTemp."' INTO TABLE reloj_checador_temporal FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\\r\\n' IGNORE 1 LINES";
        } elseif ($opcionFormato == 2) {
            $sql = "LOAD DATA LOCAL INFILE '".$archivoTemp."' INTO TABLE reloj_checador_temporal FIELDS TERMINATED BY ',' OPTIONALLY ENCLOSED BY '\"' LINES TERMINATED BY '\\r\\n' IGNORE 1 LINES";
        }
         // SET id_empresa = '".$id."'

        $res = mysqli_query($conexion, $sql);

        if ($res) {
            header ("Location: ../adminRelojChecador.php"); //Llamar procedimiento
        } else {
            echo mysqli_error($conexion);
        }
    }
    unlink($archivoTemp);

    mysqli_close($conexion);
?>
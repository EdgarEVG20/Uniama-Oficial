<?php
    require("../conexion.php");

    error_reporting(0);
    $id = $_POST["id"];
    $rfc = $_POST["rfc"];
    $nombreSocial = $_POST["nombreSocial"];
    $nombreComercial = $_POST["nombreComercial"];
    $calle = $_POST["calle"];
    $noExt = $_POST["noExt"];
    $noInt = $_POST["noInt"];
    $codigoPostal = $_POST["codigoPostal"];
    $claveColonia = $_POST["claveColonia"];
    $clavePais = $_POST["clavePais"];
    $claveEstado = $_POST["claveEstado"];
    $claveMunicipio = $_POST["claveMunicipio"];
    $claveRegimen = $_POST["claveRegimen"];
    $sitioWeb = $_POST["sitioWeb"];
    $correo = $_POST["correo"];
    $telefono = $_POST["telefono"];


    $updateRegimen = "UPDATE empresas SET rfc = '" .$rfc. "', nombre_social = '" .$nombreSocial. "', nombre_comercial = '" .$nombreComercial. "', calle = '" .$calle. "', noExt = '" .$noExt. "', noInt = '" .$noInt. "', clave_colonia = '" .$claveColonia. "', codigo_postal = '" .$codigoPostal. "', clave_municipio = '" .$claveMunicipio. "', clave_estado = '" .$claveEstado. "', clave_pais = '" .$clavePais. "', sitio_web = '" .$sitioWeb. "', correo = '" .$correo. "', telefono = '" .$telefono. "', clave_regimen = '" .$claveRegimen. "' WHERE id_empresa = '" .$id. "'";

    $resUpdate = mysqli_query($conexion, $updateRegimen);

    if ($resUpdate) {
        header ("Location: ../adminParametrosFiscales.php");
    } else {
        header ("Location: ../adminParametrosFiscales.php");
    }
    
    mysqli_close($conexion);
?>

<?php
    /*
    require("../conexion.php");

    $id =  $_POST["id"];
    $claveRegimen =  $_POST["claveRegimen"];
    $logo = $_FILES['logo'];

    $tmp_name = $logo['tmp_name'];
    $directorioDestino = "Clientes/".$id."/imgEmpresa";

        $img_file = $logo['name'];
        $img_type = $logo['type'];

        if (((strpos($img_type, "jpge") || strpos($img_type, "jpg")) || strpos($img_type, "png"))){
            $destino = $directorioDestino. "/" .$img_file;
            $update = "UPDATE empresas SET clave_regimen = '" .$claveRegimen. "', logo = 1 WHERE id_empresa = '" .$id. "'";
            $resUpdate = mysqli_query($conexion, $update);


            if($resUpdate){
                echo "<script> window.history.go(-1); </script>";
            }else{
                echo "<script> window.history.go(-1); </script>";
                }

            if (move_uploaded_file($tmp_name, $destino)) {
                return true;
            }

        }

        return false;

    mysqli_close($conexion);
    */
?>

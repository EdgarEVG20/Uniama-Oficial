<?php
    require("../conexion.php");

    error_reporting(0);
    
    //if (!empty($_POST["id"]) && !empty($_POST["idU"]) && !empty($_POST["nombreCompleto"]) && !empty($_POST["correoElectronico"]) && !empty($_POST["password"]) && !empty($_POST["genero"]) && !empty($_POST["telefono"]) && !empty($_POST["nacionalidad"])) {
    if (empty($_POST['fechaNacimiento'])) {
        $id = $_POST["id"];
        $idU = $_POST["idU"];
        $nombreCompleto = $_POST["nombreCompleto"];
        $correoElectronico = $_POST["correoElectronico"];
        $password = $_POST["password"];
        $genero = $_POST["genero"];
        $telefono =  $_POST["telefono"];
        $nacionalidad = $_POST["nacionalidad"];
        $escolaridad = $_POST["escolaridad"];
        $areaCarrera = $_POST["areaCarrera"];
        $calle = $_POST["calle"];
        $numeroExt = $_POST["numeroExt"];
        $numeroInt = $_POST["numeroInt"];
        $codigoPostal = $_POST["codigoPostal"];
        $claveColonia = $_POST["claveColonia"];
        $clavePais = $_POST["clavePais"];
        $claveEstado = $_POST["claveEstado"];
        $claveMunicipio = $_POST["claveMunicipio"];

        $updatePerfil = "UPDATE usuarios_perfiles SET ipb_genero = '" .$genero. "', ipb_telefono = '" .$telefono. "', ipb_nacionalidad = '" .$nacionalidad. "', ipb_escolaridad = '" .$escolaridad. "', ipb_area_carrera = '" .$areaCarrera. "', ipb_calle = '" .$calle. "', ipb_no_exterior = '" .$numeroExt. "', ipb_no_interior = '" .$numeroInt. "', ipb_codigo_postal = '" .$codigoPostal. "', ipb_colonia = '" .$claveColonia. "',  ipb_pais = '" .$clavePais. "', ipb_estado = '" .$claveEstado. "', ipb_municipio = '" .$claveMunicipio. "' WHERE id_empresa = '" .$id. "' AND id_usuario = '" .$idU. "'";

        $updateUsuario = "UPDATE usuarios SET nombre = '" .$nombreCompleto. "', correo = '" .$correoElectronico. "', password = '" .$password. "' WHERE id_empresa = '" .$id. "' AND id_usuario = '" .$idU. "'";

        $resUpdatePerfil = mysqli_query($conexion, $updatePerfil);
        $resUpdateUsuario = mysqli_query($conexion, $updateUsuario);

        if ($resUpdatePerfil && $resUpdateUsuario) {
            header ("Location: ../tMiPerfil.php");
        } else {
            header ("Location: ../tMiPerfil.php");
        }
    } else {
        $id = $_POST["id"];
        $idU = $_POST["idU"];
        $nombreCompleto = $_POST["nombreCompleto"];
        $correoElectronico = $_POST["correoElectronico"];
        $password = $_POST["password"];
        $fechaNacimiento = $_POST["fechaNacimiento"];
        $genero = $_POST["genero"];
        $telefono =  $_POST["telefono"];
        $nacionalidad = $_POST["nacionalidad"];
        $escolaridad = $_POST["escolaridad"];
        $areaCarrera = $_POST["areaCarrera"];
        $calle = $_POST["calle"];
        $numeroExt = $_POST["numeroExt"];
        $numeroInt = $_POST["numeroInt"];
        $codigoPostal = $_POST["codigoPostal"];
        $claveColonia = $_POST["claveColonia"];
        $clavePais = $_POST["clavePais"];
        $claveEstado = $_POST["claveEstado"];
        $claveMunicipio = $_POST["claveMunicipio"];

        $updatePerfil = "UPDATE usuarios_perfiles SET ipb_fecha_nacimiento = '" .$fechaNacimiento. "', ipb_genero = '" .$genero. "', ipb_telefono = '" .$telefono. "', ipb_nacionalidad = '" .$nacionalidad. "', ipb_escolaridad = '" .$escolaridad. "', ipb_area_carrera = '" .$areaCarrera. "', ipb_calle = '" .$calle. "', ipb_no_exterior = '" .$numeroExt. "', ipb_no_interior = '" .$numeroInt. "', ipb_codigo_postal = '" .$codigoPostal. "', ipb_colonia = '" .$claveColonia. "',  ipb_pais = '" .$clavePais. "', ipb_estado = '" .$claveEstado. "', ipb_municipio = '" .$claveMunicipio. "' WHERE id_empresa = '" .$id. "' AND id_usuario = '" .$idU. "'";

        $updateUsuario = "UPDATE usuarios SET nombre = '" .$nombreCompleto. "', correo = '" .$correoElectronico. "', password = '" .$password. "' WHERE id_empresa = '" .$id. "' AND id_usuario = '" .$idU. "'";

        $resUpdatePerfil = mysqli_query($conexion, $updatePerfil);
        $resUpdateUsuario = mysqli_query($conexion, $updateUsuario);

        if ($resUpdatePerfil && $resUpdateUsuario) {
            header ("Location: ../tMiPerfil.php");
        } else {
            header ("Location: ../tMiPerfil.php");
        }
    }
    //} else {
        //echo '<script> alert("Por favor, llena todos los campos."); window.history.go(-1); </script>';
    //}
    
    mysqli_close($conexion);
?>
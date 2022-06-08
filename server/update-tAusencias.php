<?php
    require("../conexion.php");

    error_reporting(0);
    //Si se quiere subir una imagen
    if (isset($_POST['guardarAusencia2'])) {
        //Recogemos el archivo enviado por el formulario
        $id = $_POST['id2'];
        $idU = $_POST['idU2'];
        $idAusencia = $_POST["idAusencia2"]; //Tabla ausencia (id principal)
        $idCatAusencia = $_POST["nombreAusencia2"]; //tabla catalogo_ausencia (select)
        $motivoAusencia = $_POST["motivo2"];
        $tipoAusencia = $_POST["tipo2"];
        $fechaInicio = $_POST["fechaInicio2"];
        $fechaFin = $_POST["fechaFin2"];
        $archivo = $_FILES['archivo2']['name'];
       
        $query = mysqli_query($conexion, "SELECT id_cat_ausencia, fecha_inicio, fecha_fin FROM ausencias WHERE id_empresa = '".$id."' AND id_usuario = '".$idU."' AND id_cat_ausencia != '".$idCatAusencia."' AND fecha_inicio != '".$fechaInicio."' AND fecha_fin != '".$fechaFin."'");
        $resAusencia = mysqli_fetch_assoc($query);
        $idAusenciaBD = $resAusencia['id_cat_ausencia'];
        $fechaInicioBD = $resAusencia['fecha_inicio'];
        $fechaFinBD = $resAusencia['fecha_fin'];

        //$query = mysqli_query($conexion, "SELECT ips_rfc FROM usuarios_perfiles WHERE id_usuario = '".$idU."'");
        //$resRFC = mysqli_fetch_assoc($query);
        //$rfc = $resRFC['ips_rfc'];

        //Si el archivo contiene algo y es diferente de vacio
        if (isset($archivo) && $archivo != "") {
            //if (isset($rfc)) {
                $tipo = $_FILES['archivo2']['type'];
                $tamano = $_FILES['archivo2']['size'];
                $temp = $_FILES['archivo2']['tmp_name'];

                if (!strpos($tipo, 'pdf')) {
                    echo '<script> alert("Error. La extensión del archivo no es correcta. Por favor, sube tu documento en PDF."); window.history.go(-1); </script>';
                } else {

                    if (move_uploaded_file($temp, "../Clientes/".$id."/empleados/".$idU."/ausencias/".$idCatAusencia."_".$fechaInicio."_".$fechaFin.".pdf")) { //"_".$rfc.

                        if ($idAusencia !== $idAusenciaBD && $fechaInicio !== $fechaInicioBD && $fechaFin !== $fechaFinBD) {
                            
                            $update = mysqli_query($conexion, "UPDATE ausencias SET id_cat_ausencia = '" .$idCatAusencia. "', motivo = '" .$motivoAusencia. "', tipo = '" .$tipoAusencia. "', fecha_inicio = '" .$fechaInicio. "', fecha_fin = '" .$fechaFin. "', archivo_adjunto = 1 WHERE id_empresa = '" .$id. "' AND id_usuario = '" .$idU. "' AND id_ausencia = '" .$idAusencia. "'");

                            if ($update) {
                                echo '<script> alert("¡Tu ausencia ha sido actualizada con éxito!."); window.history.go(-1); </script>';
                                //echo '<script> alert("¡Tu ausencia ha sido creada con éxito!.");</script>';
                                //header ("Location: ../tAusencias.php");
                            } else {
                                echo '<script> alert("Ha ocurrido un error al intentar actualizar tu ausencia, inténtalo de nuevo."); window.history.go(-1); </script>';
                                //echo '<script> alert("Ha ocurrido un error al intentar crear tu ausencia, inténtalo de nuevo.");</script>';
                                //header ("Location: ../tAusencias.php");
                            }
                        } else {
                            echo '<script> alert("Error. No puedes actualizar una ausencia con el mismo nombre y el mismo rango de fecha a otra."); window.history.go(-1); </script>';
                        }
                        
                    } else {
                        echo '<script> alert("Ha ocurrido un error al intentar subir el arhcivo, inténtalo de nuevo."); window.history.go(-1); </script>';
                    }
                }
            //} else {
                //echo '<script> alert("Para subir tu comprobante primero rellena tu información laboral"); window.history.go(-1); </script>';
            //}
        } else {
            if ($idAusencia !== $idAusenciaBD && $fechaInicio !== $fechaInicioBD && $fechaFin !== $fechaFinBD) {
                
                $update = mysqli_query($conexion, "UPDATE ausencias SET id_cat_ausencia = '" .$idCatAusencia. "', motivo = '" .$motivoAusencia. "', tipo = '" .$tipoAusencia. "', fecha_inicio = '" .$fechaInicio. "', fecha_fin = '" .$fechaFin. "', archivo_adjunto = 2 WHERE id_empresa = '" .$id. "' AND id_usuario = '" .$idU. "' AND id_ausencia = '" .$idAusencia. "'");

                if ($update) {
                    echo '<script> alert("¡Tu ausencia ha sido actualizada con éxito!."); window.history.go(-1); </script>';
                    //echo '<script> alert("¡Tu ausencia ha sido creada con éxito!.");</script>';
                    //header ("Location: ../tAusencias.php");
                } else {
                    echo '<script> alert("Ha ocurrido un error al intentar actualizar tu ausencia, inténtalo de nuevo."); window.history.go(-1); </script>';
                    //echo '<script> alert("Ha ocurrido un error al intentar crear tu ausencia, inténtalo de nuevo.");</script>';
                    //header ("Location: ../tAusencias.php");
                }

            } else {
                echo '<script> alert("Error. No puedes actualizar una ausencia con el mismo nombre y el mismo rango de fecha a otra."); window.history.go(-1); </script>';
            }
        }
    } else {
        echo '<script> alert("Para actualizar tu ausencia da clic en "Guardar Cambios""); window.history.go(-1); </script>';
    }

?>
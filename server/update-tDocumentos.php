<?php
    require("../conexion.php");

    error_reporting(0);
    //Si se quiere subir una imagen
    if (isset($_POST['subirArchivo'])) {
        //Recogemos el archivo enviado por el formulario
        $id = $_POST['id'];
        $idU = $_POST['idU'];
        $nombre = $_POST['nombre'];
        $idDocumento = $_POST['idDocumento'];
        $vigencia = $_POST['vigencia'];
        $archivo = $_FILES['archivo']['name'];
        $fechaActual = date('Y-m-d');
       
        //$query = mysqli_query($conexion, "SELECT ips_rfc FROM usuarios_perfiles WHERE id_usuario = '".$idU."'");
        //$res = mysqli_fetch_assoc($query);
        //$rfc = $res['ips_rfc'];

            //Si el archivo contiene algo y es diferente de vacio
        if (isset($archivo) && $archivo != "") {
            //if (!empty($res['ips_rfc'])) {
                //Obtenemos algunos datos necesarios sobre el archivo
                $tipo = $_FILES['archivo']['type'];
                $tamano = $_FILES['archivo']['size'];
                $temp = $_FILES['archivo']['tmp_name'];


                /*$tofind = "ÀÁÂÃÄÅàáâãäåÒÓÔÕÖØòóôõöøÈÉÊËèéêëÇçÌÍÎÏìíîïÙÚÛÜùúûüÿÑñ· ";
                $replace = "AAAAAAaaaaaaOOOOOOooooooEEEEeeeeCcIIIIiiiiUUUUuuuuyNn-_";
                $nombreSinAcentos = strtr($nombre, $tofind, $replace);*/

                $nombreSinAcentos = str_replace(' ', '_', $nombre);

                //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
                if (!((strpos($tipo, 'pdf')))) {
                    echo '<script> alert("Error. La extensión del archivo no es correcta. Por favor, sube tu documento en PDF."); window.history.go(-1); </script>';
                    //'<div><b>Error. La extensión o el tamaño de los archivos no es correcta.<br/>
                    //- Se permiten archivos .jpg, .png. y de 200 kb como máximo.</b></div>';
                } else {

                    $folder = "../Clientes/".$id."/empleados/".$idU; //"_".$rfc
                    if (!is_dir($folder)) {
                        mkdir($folder);
                    }

                    //Si la imagen es correcta en tamaño y tipo, se intenta subir al servidor
                    if (move_uploaded_file($temp, "../Clientes/".$id."/empleados/".$idU."/".$nombreSinAcentos.".pdf")) { //"_".$rfc.
                        //Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
                        chmod($folder, 0777);
                        //Se crea la secuencia sql para almacenar ciertos datos en la base de datos
                        $insert = mysqli_query($conexion, "INSERT INTO archivos_documentos VALUES (null, '$idDocumento', '$id', '$idU', '$vigencia', '$fechaActual', 1)");
                        //Mostramos el mensaje de que se ha subido co éxito
                        //echo '<script> alert("Se ha subido correctamente la imagen."); </script>';
                        echo '<script> alert("¡Tu documento se ha subido con éxito!.");  window.history.go(-1); </script>';
                        //header ("Location: ../tDocumentos.php");
                        //'<div><b>Se ha subido correctamente la imagen.</b></div>';
                    } else {
                        //Si no se ha podido subir la imagen, mostramos un mensaje de error
                        echo '<script> alert("Ha ocurrido un error al intentar subir el arhcivo, inténtalo de nuevo."); window.history.go(-1); </script>';
                        //'<div><b>Ocurrió algún error al subir el fichero. No pudo guardarse.</b></div>';
                    }
                }
            //} else {
                //echo '<script> alert("Para subir tus archivos primero rellena tu información laboral"); window.history.go(-1); </script>';
            //}
        } else {
            echo '<script> alert("Por favor selecciona el archivo que desees subir."); window.history.go(-1); </script>';
        }
    } elseif (isset($_POST['verArchivo']) || isset($_POST['eliminarArchivo'])) {
        echo '<script> alert("Para subir el documento, da clic en "Subir""); window.history.go(-1); </script>';
    }

?>
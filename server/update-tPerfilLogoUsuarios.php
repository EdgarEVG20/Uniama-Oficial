<?php
    require("../conexion.php");
    // CODIGO ENCONTRADO EN INTERNET: https://www.jose-aguilar.com/blog/upload-de-imagenes-con-php/
    error_reporting(0);
    //Si se quiere subir una imagen
    if (isset($_POST['subir'])) {
       //Recogemos el archivo enviado por el formulario
       $id = $_POST['id'];
       $idU = $_POST['idU'];
       $archivo = $_FILES['archivo']['name'];
       
       //Si el archivo contiene algo y es diferente de vacio
       if (isset($archivo) && $archivo != "") {
            //Obtenemos algunos datos necesarios sobre el archivo
            $tipo = $_FILES['archivo']['type'];
            $tamano = $_FILES['archivo']['size'];
            $temp = $_FILES['archivo']['tmp_name'];

            //$query = mysqli_query($conexion, "SELECT ips_rfc FROM usuarios_perfiles WHERE id_usuario = '".$idU."'");
            //$res = mysqli_fetch_assoc($query);
            //$rfc = $res['ips_rfc'];

            //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
            if (!((strpos($tipo, 'jpeg') || strpos($tipo, 'jpg') || strpos($tipo, 'png')) && ($tamano < 2000000))) {
                echo '<script> alert("Error. La extensión o el tamaño de la foto no es el correcto. Se permiten archivos .jpg, .png y .jpeg, y de 200 kb como máximo."); window.history.go(-1); </script>';
                //'<div><b>Error. La extensión o el tamaño de los archivos no es correcta.<br/>
                //- Se permiten archivos .jpg, .png. y de 200 kb como máximo.</b></div>';
            } else {

                $folder = "../Clientes/".$id."/empleados/".$idU."/imgPerfil"; //"_".$rfc.
                if (!is_dir($folder)) {
                    mkdir($folder);
                }

                //Si la imagen es correcta en tamaño y tipo, se intenta subir al servidor
                if (move_uploaded_file($temp, "../Clientes/".$id."/empleados/".$idU."/imgPerfil/fotoPerfil.png")) { //"_".$rfc.
                    //Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
                    chmod($folder, 0777);
                    //Mostramos el mensaje de que se ha subido co éxito
                    //echo '<script> alert("Se ha subido correctamente la imagen."); </script>';
                    header ("Location: ../adminVerMiPerfilT.php?idU=".$idU);
                    //'<div><b>Se ha subido correctamente la imagen.</b></div>';
                } else {
                    //Si no se ha podido subir la imagen, mostramos un mensaje de error
                    echo '<script> alert("Ocurrió algún error al subir el fichero. No pudo guardarse."); window.history.go(-1); </script>';
                    //'<div><b>Ocurrió algún error al subir el fichero. No pudo guardarse.</b></div>';
                }
            }
        } else {
            echo '<script> alert("Por favor selecciona el logo que desees actualizar."); window.history.go(-1); </script>';
        }
    }

?>
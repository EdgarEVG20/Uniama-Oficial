    <?php
    /*require("../conexion.php");

    if (isset($_FILES['logo'])) {
        $id =  $_POST["id"];
        $logo = $_FILES['logo'];
        $filename = $_FILES['name'];
        $mimetype = $_FILES['type'];

        $allowed_types = array("image/jpg", "image/jpeg", "image/png");

        if (!in_array($mimetype, $allowed_types)) {
            echo "<script> alert('NO coincide con el formato del logo.'); window.history.go(-1); </script>";
        }

        //Crear directorio imgEmpresa
        $folder = "../Clientes/".$id."/imgEmpresa";
        if (!is_dir($folder)) {
            mkdir($folder);
        }

        //Mover logo a Clientes/$id/imgEmpresa
        move_uploaded_file($$_FILES['tmp_name'], $folder.$filename);
    } else {
        echo "<script> alert('Ha ocurrido un error al actualizar el logo'); window.history.go(-1); </script>";
    }
    
    mysqli_close($conexion);*/
?>


<?php
    require("../conexion.php");
    // CODIGO ENCONTRADO EN INTERNET: https://www.jose-aguilar.com/blog/upload-de-imagenes-con-php/
    error_reporting(0);
    //Si se quiere subir una imagen
    if (isset($_POST['subir'])) {
       //Recogemos el archivo enviado por el formulario
       $id = $_POST['id'];
       $archivo = $_FILES['archivo']['name'];
       
       //Si el archivo contiene algo y es diferente de vacio
       if (isset($archivo) && $archivo != "") {
            //Obtenemos algunos datos necesarios sobre el archivo
            $tipo = $_FILES['archivo']['type'];
            $tamano = $_FILES['archivo']['size'];
            $temp = $_FILES['archivo']['tmp_name'];
            //Se comprueba si el archivo a cargar es correcto observando su extensión y tamaño
            if (!((strpos($tipo, 'jpeg') || strpos($tipo, 'jpg') || strpos($tipo, 'png')) && ($tamano < 2000000))) {
                echo '<script> alert("Error. La extensión o el tamaño del logo no es el correcto. Se permiten archivos .jpg, .png y .jpeg, y de 200 kb como máximo."); window.history.go(-1); </script>';
                //'<div><b>Error. La extensión o el tamaño de los archivos no es correcta.<br/>
                //- Se permiten archivos .jpg, .png. y de 200 kb como máximo.</b></div>';
            } else {
                $folder = "../Clientes/".$id."/imgEmpresa";
                if (!is_dir($folder)) {
                    mkdir($folder);
                }

                //Si la imagen es correcta en tamaño y tipo, se intenta subir al servidor
                if (move_uploaded_file($temp, "../Clientes/".$id."/imgEmpresa/logo.png")) {
                    //Cambiamos los permisos del archivo a 777 para poder modificarlo posteriormente
                    chmod($folder, 0777);

                    $update = mysqli_query($conexion, "UPDATE empresas SET logo = 1 WHERE id_empresa = '".$id."'");
                    //Mostramos el mensaje de que se ha subido con éxito
                    echo '<script> alert("Se ha subido correctamente la imagen. Si no se visualiza tu logo nuevo, por favor actualiza la vista (Crtl + F5)."); document.location="../adminParametrosFiscales.php";</script>';
                    // header ("Refresh: 0; URL=../adminParametrosFiscales.php");
                    // header ("Location: ../adminParametrosFiscales.php");
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
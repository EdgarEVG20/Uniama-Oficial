<?php
	require("conexion.php");
	
	//error_reporting(0);

	$cp = $_POST['codigoPostal'];
	$consultaCP = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM _cat_codigos_postales WHERE c_cp = $cp"));
	$resClaveEstado = $consultaCP['c_estado'];
	
	$consulta = "SELECT * FROM _cat_estados WHERE catalogo = '".$resClaveEstado."' AND estatus = 1 ORDER BY estado ASC";
	$buscar = mysqli_query($conexion, $consulta);

	if (mysqli_num_rows($buscar) > 0) {
		// $claveEstado.='<option value="" disabled selected>Estados</option>';
		while($fila = mysqli_fetch_assoc($buscar)){
			$claveEstado.='<option value="'.$fila['catalogo'].'">'.$fila['estado'].'</option>';
		}
		echo $claveEstado;
	}

	
?>
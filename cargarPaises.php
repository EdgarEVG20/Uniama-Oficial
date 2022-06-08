<?php
	require("conexion.php");
	
	error_reporting(0);

	$cp = $_POST['codigoPostal'];
	$consultaClaveEstado = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM _cat_codigos_postales WHERE c_cp = $cp"));
	$resClaveEstado = $consultaClaveEstado['c_estado'];

	$consultaClavePais = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM _cat_estados WHERE catalogo = '".$resClaveEstado."'"));
	$resClavePais = $consultaClavePais['clave_pais'];

	$consulta = "SELECT * FROM _cat_pais WHERE clave_pais = '".$resClavePais."' AND estatus = 1 ORDER BY nombre_pais ASC";
	$buscar = mysqli_query($conexion, $consulta);

	if (mysqli_num_rows($buscar) > 0) {
		// $clavePais.='<option value="" disabled selected>Países</option>';
		while($fila = mysqli_fetch_assoc($buscar)){
			$clavePais.='<option value="'.$fila['clave_pais'].'">'.$fila['nombre_pais'].'</option>';
		}		
	}

	echo $clavePais;
?>
<?php
	require("conexion.php");
	
	error_reporting(0);

	$cp = $_POST['codigoPostal'];
	$consultaCPMunicipio = mysqli_fetch_assoc(mysqli_query($conexion, "SELECT * FROM _cat_codigos_postales WHERE c_cp = $cp"));
	$resClaveEstado = $consultaCPMunicipio['c_estado'];
	$resClaveMunicipio = $consultaCPMunicipio['c_municipio'];

	$consulta = "SELECT * FROM _cat_municipios WHERE clave_municipio = $resClaveMunicipio AND clave_estado = '".$resClaveEstado."' AND estatus = 1 ORDER BY nombre_municipio ASC";
	$buscar = mysqli_query($conexion, $consulta);

	if (mysqli_num_rows($buscar) > 0) {
		// $municipios.='<option value="" disabled selected>Municipios</option>';
		while($fila = mysqli_fetch_assoc($buscar)){
			$municipios.='<option value="'.$fila['clave_municipio'].'">'.$fila['nombre_municipio'].'</option>';
		}		
	}

	echo $municipios;
?>
<?php
	require("conexion.php");
	
	$cp = $_POST['codigoPostal'];

	$consulta = "SELECT * FROM _cat_colonias WHERE codigo_postal = $cp AND estatus = 1 ORDER BY nombre_colonia ASC";
	$buscar = mysqli_query($conexion, $consulta);

	if (mysqli_num_rows($buscar) > 0) {
		// $colonias.='<option value="" disabled selected>Colonias</option>';
		while($fila = mysqli_fetch_assoc($buscar)) {
			$colonias.='<option value="'.$fila['clave_colonia'].'">'.$fila['nombre_colonia'].'</option>';
		}		
	}

	echo $colonias;
?>
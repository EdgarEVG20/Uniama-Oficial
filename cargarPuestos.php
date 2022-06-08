<?php
	require("conexion.php");
	
	error_reporting(0);
	$consulta = "SELECT * FROM catalogo_puestos WHERE id_departamento = '".$_POST['departamento']."' AND estatus = 1 ORDER BY nombre_puesto ASC";
	$buscar = mysqli_query($conexion, $consulta);

	if (mysqli_num_rows($buscar) > 0) {
		$puestos.='<option value="" disabled selected>Cargos / Puestos</option>';
		while($fila = mysqli_fetch_assoc($buscar)){
			$puestos.='<option value="'.$fila['id_puesto'].'">'.$fila['nombre_puesto'].'</option>';
		}		
	}

	echo $puestos;
?>
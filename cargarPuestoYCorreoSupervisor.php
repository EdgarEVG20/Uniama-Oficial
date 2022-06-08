<?php
	require("conexion.php");
	
	error_reporting(0);
	$consulta = "SELECT usuarios.correo, catalogo_puestos.nombre_puesto, catalogo_puestos.id_puesto FROM usuarios INNER JOIN usuarios_perfiles ON usuarios.id_usuario = usuarios_perfiles.id_usuario INNER JOIN catalogo_puestos ON usuarios_perfiles.il_puesto = catalogo_puestos.id_puesto WHERE usuarios.id_usuario = '".$_POST['idSupervisorAusencias']."'";

	$buscar = mysqli_query($conexion, $consulta);
	$res = mysqli_fetch_assoc($buscar);

	$puestoCorreoSupervisor.='
								<div class="row">
	                                <div class="col-6">
	                                    <small>Puesto</small>
	                                    <input type="text" class="form-control" placeholder="Puesto" value="'.$res['nombre_puesto'].'">
	                                    <input type="hidden" name="puestoSupervisor" value="'.$res['id_puesto'].'">
	                                </div>
	                                <div class="col-6">
	                                    <small>Correo Electr&oacute;nico</small>
	                                    <input type="text" class="form-control" name="correoElectronicoSupervisor" placeholder="Correo Electr&oacute;nico" value="'.$res['correo'].'">
	                                </div>
	                            </div>
                            ';
	
	echo $puestoCorreoSupervisor;
	//echo $correoSupervisor;
?>

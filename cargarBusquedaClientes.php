<?php
	require("conexion.php");

	error_reporting(0);
	if(isset($_POST['clientes'])) {
		$q=$conexion->real_escape_string($_POST['clientes']);
		$consulta="SELECT * FROM empresas WHERE nombre_social LIKE '%".$q."%' ORDER BY nombre_social ASC LIMIT 20";
	}

	$buscar=$conexion->query($consulta);

	$tabla='
		<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
	        <thead>
	            <tr>
	                <th>ID</th>
	                <th>RFC</th>
	                <th>Nombre Social</th>
	                <th>Suscripci&oacute;n</th>
	                <th>Precio</th>
	                <th>Estatus</th>
	                <th>Acciones</th>
	            </tr>
	        </thead>
	';

	if ($buscar->num_rows > 0) {
		while($fila= $buscar->fetch_assoc()) {
			$condicion = $fila['estatus'] == '1' ? 'checked' : '2';
			$idDeEmpresa = $fila['id_empresa'];

			$tabla.='
			<tbody>
				<tr>
					<td>'.$fila['id_empresa'].'</td>
					<td>'.$fila['rfc'].'</td>
					<td>'.$fila['nombre_social'].'</td>
					<td>'.$fila['suscripcion'].' Trabajadores</td>
					<td>'.$fila['precio'].'</td>
					<td class="btn-switch">
                    	<label class="switch">
                        	<input type="checkbox" id="'.$fila['id_empresa'].'" name="btnSwitch" onclick="updateEstatus('.$fila['id_empresa'].','.$fila['id_empresa'].');" value="'.$fila['estatus'].'" '.$condicion.'>
                        	<span class="slider round"></span>
                    	</label>
                	</td>
					<td class="btn-modificar">
                    	<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-edit-cliente'.$idDeEmpresa.'"><i class="fas fa-user-edit"></i></button>
                	</td>
				</tr>
			</tbody>

			<div class="modal fade" id="modal-edit-cliente'.$idDeEmpresa.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
			    	<div class="modal-content">
			        	<div class="modal-header">
			            	<h5 class="modal-title" id="exampleModalLabel">Modificar Cliente/Empresa</h5>
			            	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			                	<span aria-hidden="true">&times;</span>
			            	</button>
			        	</div>
			        	<form action="server/update-clientes.php" method="POST">
			            	<input type="hidden" name="id" value="'.$fila['id_empresa'].'">
			            	<div class="modal-body">
			                	<div class="col">
			                    	<div class="col mt-4">
			                        	<select class="form-control form-select-sm" id="suscripcion'.$idDeEmpresa.'" name="suscripcion" onchange="cargarPrecioSuscripcionModal('.$idDeEmpresa.');" required>
			';
			                        		if ($fila['suscripcion'] == "1 - 40") {
												$tabla.='<option value="" disabled>Suscripci&oacute;n</option>';
												$tabla.='<option value="1 - 40" selected>1 - 40 Trabajadores</option>';
												$tabla.='<option value="41 - 80">41 - 80 Trabajadores</option>';
												$tabla.='<option value="+80">Más 80 Trabajadores</option>';
											}
											elseif($fila['suscripcion'] == "41 - 80"){
												$tabla.='<option value="" disabled>Suscripci&oacute;n</option>';
												$tabla.='<option value="1 - 40">1 - 40 Trabajadores</option>';
												$tabla.='<option value="41 - 80" selected>41 - 80 Trabajadores</option>';
												$tabla.='<option value="+80">Más 80 Trabajadores</option>';
											}
											elseif($fila['suscripcion'] == "+80"){
												$tabla.='<option value="" disabled>Suscripci&oacute;n</option>';
												$tabla.='<option value="1 - 40">1 - 40 Trabajadores</option>';
												$tabla.='<option value="41 - 80">41 - 80 Trabajadores</option>';
												$tabla.='<option value="+80" selected>Más 80 Trabajadores</option>';

											}else{
												$tabla.='<option value="" disabled selected>Suscripci&oacute;n</option>';
												$tabla.='<option value="1 - 40">1 - 40 Trabajadores</option>';
												$tabla.='<option value="41 - 80">41 - 80 Trabajadores</option>';
												$tabla.='<option value="+80">Más 80 Trabajadores</option>';
											}
			$tabla.='
			                        	</select>
			                    	</div>
			                    	<div class="col mt-4">
			                        	<input type="number" class="form-control" id="precio'.$idDeEmpresa.'" name="precio" placeholder="Precio Del Paquete" value="'.$fila['precio'].'" min="0">
			                    	</div>
			                    	<div class="col mt-4">
			                        	<input type="date" class="form-control" id="fecha" name="fecha" placeholder="Fecha" value="'.$fila['fecha'].'">
			                    	</div>
			                	</div>
			            	</div>
			            	<div class="modal-footer">
			                	<button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
			                	<button type="submit" class="btn btn-primary" onclick="guardarCambios('.$fila['id_empresa'].');">Guardar cambios</button>
			            	</div>
			        	</form>
			    	</div>
				</div>
			</div>
			';
		}
	} else {
		$tabla.='
			<tbody>
				<tr>
					<td colspan="7" style="text-align: center">Lo sentimos, no se han encontrado resultados para tu búsqueda.</td>
				</tr>
			</tbody>
		';
	}

	$tabla.="</table>";
	echo $tabla;
?>

<script language="JavaScript">
    function updateEstatus(idEmpresa, nombreSwitch)
    {
        if(document.getElementById(nombreSwitch).checked==false)
        {
            cambioEstado = 2;
        }
        else
        {
            cambioEstado = 1;
        }
        $.ajax({
            cache: false,
            dataType: 'json',
            url: 'server/updateEstatus.php',
            type: 'POST',
            data: {"id": idEmpresa, "estado": cambioEstado, "idBD": 'id_empresa', "tablaBD": 'empresas'},
            success:function(data){
            },
        });
    }
</script>
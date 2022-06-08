<?php
	require("conexion.php");

	error_reporting(0);
	if(isset($_POST['regimenFiscales'])) {
		$q=$conexion->real_escape_string($_POST['regimenFiscales']);
		$consulta="SELECT * FROM _cat_regimen_fiscal WHERE descripcion LIKE '%".$q."%' ORDER BY descripcion ASC LIMIT 20";
	}

	$buscar=$conexion->query($consulta);

	$tabla='
		<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
	        <thead>
	            <tr>
	                <th>Clave R&eacute;gimen Fiscal</th>
                    <th>Descripci&oacute;n</th>
                    <th>Persona</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
	            </tr>
	        </thead>
	        
	';

	if ($buscar->num_rows > 0) {
		while($fila= $buscar->fetch_assoc()) {
			$condicion = $fila['estatus'] == '1' ? 'checked' : '2';
			$idDeRegimenFiscal = $fila['id_regimen'];

			if ($fila['persona'] == "FISICA") {
				$persona = '<option value="" disabled>Persona</option>
				<option value="FISICA" selected>FISICA</option>
				<option value="MORAL">MORAL</option>';
			}
			elseif($fila['persona'] == "MORAL"){
				$persona = '<option value="" disabled>Persona</option>
				<option value="FISICA">FISICA</option>
				<option value="MORAL" selected>MORAL</option>';
			}else{
				$persona = '<option value="" disabled selected>Persona</option>
				<option value="FISICA">FISICA</option>
				<option value="MORAL">MORAL</option>';
			}

			$tabla.=
			'
			<tbody>
				<tr>
					<td>'.$fila['clave_regimen'].'</td>
					<td>'.$fila['descripcion'].'</td>
					<td>'.$fila['persona'].'</td>
					<td class="btn-switch">
                        <label class="switch">
                            <input type="checkbox" id="'.$fila['id_regimen'].'" name="btnSwitch" onclick="updateEstatus('.$fila['id_regimen'].','.$fila['id_regimen'].');" value="'.$fila['estatus'].'" '.$condicion.'>
                            <span class="slider round"></span>
                        </label>
                    </td>
					<td class="btn-modificar">
	                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-edit-regimen'.$idDeRegimenFiscal.'"><i class="fas fa-user-edit"></i></button>
	                </td>
				</tr>
			</tbody>

			<div class="modal fade" id="modal-edit-regimen'.$idDeRegimenFiscal.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
				    <div class="modal-content">
				        <div class="modal-header">
				            <h5 class="modal-title" id="exampleModalLabel">Modificar R&eacute;gimen Fiscal</h5>
				            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				                <span aria-hidden="true">&times;</span>
				            </button>
				        </div>
				        <form action="server/update-clientes.php" method="POST">
				            <input type="hidden" name="id" value="'.$fila['id_regimen'].'">
				            <div class="modal-body">
				                <div class="col">
				                    <div class="col mt-4">
				                        <input type="number" class="form-control" id="clave" name="clave" placeholder="Fecha" value="'.$fila['clave_regimen'].'" min="0">
				                    </div>
				                    <div class="col mt-4">
				                        <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Descripcion" value="'.$fila['descripcion'].'" onkeyup="mayusculas(this)">
				                    </div>
				                    <div class="col mt-4">
				                        <select class="form-control form-select-sm" id="persona" name="persona" required>
				                        '.$persona.'
				                        </select>
				                    </div>
				                </div>
				            </div>
				            <div class="modal-footer">
				                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
				                <button type="submit" class="btn btn-primary" onclick="guardarCambiosRegimenFiscal('.$fila['id_regimen'].');">Guardar cambios</button>
				            </div>
				        </form>
				    </div>
				</div>
			</div>
			';
		}		
	}
	$tabla.="</table>";
	echo $tabla;
?>

<script language="JavaScript">
    function updateEstatus(idRegimenFiscal, nombreSwitch)
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
            data: {"id": idRegimenFiscal, "estado": cambioEstado, "idBD": 'id_regimen', "tablaBD": '_cat_regimen_fiscal'},
            success:function(data){
            },
        });
    }
</script>
<?php
	require("conexion.php");

	error_reporting(0);
	if(isset($_POST['ausencias'])) {
		$q=$conexion->real_escape_string($_POST['ausencias']);
		$consulta="SELECT * FROM _cat_ausencias WHERE nombre LIKE '%".$q."%' ORDER BY nombre ASC LIMIT 20";
	}

	$buscar=$conexion->query($consulta);

	$tabla='
		<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
	        <thead>
	            <tr>
	                <th>Nombre</th>
                    <th>Estatus</th>
                    <th>Acciones</th>
	            </tr>
	        </thead>
	        
	';

	if ($buscar->num_rows > 0) {
		while($fila= $buscar->fetch_assoc()) {
			$condicion = $fila['estatus'] == '1' ? 'checked' : '2';
			$idDeAusencia = $fila['id_ausencia'];

			$tabla.=
			'
			<tbody>
				<tr>
					<td>'.$fila['nombre'].'</td>
					<td class="btn-switch">
                        <label class="switch">
                            <input type="checkbox" id="'.$fila['id_ausencia'].'" name="btnSwitch" onclick="updateEstatus('.$fila['id_ausencia'].','.$fila['id_ausencia'].');" value="'.$fila['estatus'].'" '.$condicion.'>
                            <span class="slider round"></span>
                        </label>
                    </td>
					<td class="btn-modificar">
	                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-edit-ausencia'.$idDeAusencia.'"><i class="fas fa-user-edit"></i></button>
	                </td>
				</tr>
			 </tbody>

			<div class="modal fade" id="modal-edit-ausencia'.$idDeAusencia.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
				    <div class="modal-content">
				        <div class="modal-header">
				            <h5 class="modal-title" id="exampleModalLabel">Modificar Ausencia</h5>
				            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				                <span aria-hidden="true">&times;</span>
				            </button>
				        </div>
				        <form action="server/update-documentos.php" method="POST">
				            <input type="hidden" name="id" value="'.$fila['id_ausencia'].'">
				            <div class="modal-body">
				                <div class="col">
				                	<div class="col mt-4">
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="'.$fila['nombre'].'" onkeyup="mayusculas(this)">
                                    </div>
				                </div>
				            </div>
				            <div class="modal-footer">
				                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
				                <button type="submit" class="btn btn-primary" onclick="guardarCambiosAusencias('.$fila['id_ausencia'].');">Guardar cambios</button>
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
    function updateEstatus(idAusencia, nombreSwitch)
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
            data: {"id": idAusencia, "estado": cambioEstado, "idBD": 'id_ausencia', "tablaBD": '_cat_ausencias'},
            success:function(data){
            },
        });
    }
</script>
<?php
	require("conexion.php");

	error_reporting(0);
	if(isset($_POST['documentos'])) {
		$q=$conexion->real_escape_string($_POST['documentos']);
		$consulta="SELECT * FROM _cat_documentos WHERE nombre LIKE '%".$q."%' ORDER BY nombre ASC LIMIT 20";
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
			$idDeDocumento = $fila['id_documento'];

			$tabla.='
			<tbody>
				<tr>
					<td>'.$fila['nombre'].'</td>
					<td class="btn-switch">
                        <label class="switch">
                            <input type="checkbox" id="'.$fila['id_documento'].'" name="btnSwitch" onclick="updateEstatus('.$fila['id_documento'].','.$fila['id_documento'].');" value="'.$fila['estatus'].'" '.$condicion.'>
                            <span class="slider round"></span>
                        </label>
                    </td>
					<td class="btn-modificar">
	                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-edit-documento'.$idDeDocumento.'"><i class="fas fa-user-edit"></i></button>
	                </td>
				</tr>
			</tbody>

			<div class="modal fade" id="modal-edit-documento'.$idDeDocumento.'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
				<div class="modal-dialog" role="document">
				    <div class="modal-content">
				        <div class="modal-header">
				            <h5 class="modal-title" id="exampleModalLabel">Modificar Documento</h5>
				            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
				                <span aria-hidden="true">&times;</span>
				            </button>
				        </div>
				        <form action="server/update-documentos.php" method="POST">
				            <input type="hidden" name="id" value="'.$fila['id_documento'].'">
				            <div class="modal-body">
				                <div class="col">
				                	<div class="col mt-4">
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="'.$fila['nombre'].'" onkeyup="mayusculas(this)">
                                    </div>
				                </div>
				            </div>
				            <div class="modal-footer">
				                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
				                <button type="submit" class="btn btn-primary" onclick="guardarCambiosDocumentos('.$fila['id_documento'].');">Guardar cambios</button>
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
					<td colspan="3" style="text-align: center">Lo sentimos, no se han encontrado resultados para tu búsqueda.</td>
				</tr>
			</tbody>
		';
	}

	$tabla.="</table>";
	echo $tabla;
?>

<script language="JavaScript">
    function updateEstatus(idDocumento, nombreSwitch)
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
            data: {"id": idDocumento, "estado": cambioEstado, "idBD": 'id_documento', "tablaBD": '_cat_documentos'},
            success:function(data){
            },
        });
    }
</script>
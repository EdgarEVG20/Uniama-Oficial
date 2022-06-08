<?php
	require("conexion.php");

	error_reporting(0);
	if(isset($_POST['estados'])) {
		$q=$conexion->real_escape_string($_POST['estados']);
		$consulta="SELECT * FROM _cat_estados WHERE estado LIKE '%".$q."%' || catalogo LIKE '%".$q."%' || clave_pais LIKE '%".$q."%' ORDER BY estado ASC LIMIT 20";
	}

	$buscar=$conexion->query($consulta);

	$tabla='
		<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
	        <thead>
	            <tr>
	                <th>Clave Pais</th>
                    <th>Clave Estado</th>
                    <th>Nombre</th>
                    <th>Estatus</th>
	            </tr>
	        </thead>
	        
	';

	if ($buscar->num_rows > 0) {
		while($fila= $buscar->fetch_assoc()) {
			$condicion = $fila['estatus'] == '1' ? 'checked' : '2';

			$tabla.=
			'
			<tbody>
				<tr>
					<td>'.$fila['clave_pais'].'</td>
					<td>'.$fila['catalogo'].'</td>
					<td>'.$fila['estado'].'</td>
					<td class="btn-switch">
                        <label class="switch">
                            <input type="checkbox" id="'.$fila['id_estado'].'" name="btnSwitch" onclick="updateEstatus('.$fila['id_estado'].','.$fila['id_estado'].');" value="'.$fila['estatus'].'" '.$condicion.'>
                            <span class="slider round"></span>
                        </label>
                    </td>
				</tr>
			 </tbody>

			';
		}		
	}
	$tabla.="</table>";
	echo $tabla;
?>

<script language="JavaScript">
    function updateEstatus(idEstado, nombreSwitch)
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
            data: {"id": idEstado, "estado": cambioEstado, "idBD": 'id_estado', "tablaBD": '_cat_estados'},
            success:function(data){
            },
        });
    }
</script>
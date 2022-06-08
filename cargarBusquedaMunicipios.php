<?php
	require("conexion.php");

	error_reporting(0);
	if(isset($_POST['municipios'])) {
		$q=$conexion->real_escape_string($_POST['municipios']);
		$consulta="SELECT * FROM _cat_municipios WHERE clave_municipio LIKE '%".$q."%' || clave_estado LIKE '%".$q."%' || nombre_municipio LIKE '%".$q."%' ORDER BY nombre_municipio ASC LIMIT 20";
	}

	$buscar=$conexion->query($consulta);

	$tabla='
		<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
	        <thead>
	            <tr>
                    <th>Clave Estado</th>
	                <th>Clave Municipio</th>
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
					<td>'.$fila['clave_estado'].'</td>
					<td>'.$fila['clave_municipio'].'</td>
					<td>'.$fila['nombre_municipio'].'</td>
					<td class="btn-switch">
                        <label class="switch">
                            <input type="checkbox" id="'.$fila['id_municipio'].'" name="btnSwitch" onclick="updateEstatus('.$fila['id_municipio'].','.$fila['id_municipio'].');" value="'.$fila['estatus'].'" '.$condicion.'>
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
    function updateEstatus(idMunicipio, nombreSwitch)
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
            data: {"id": idMunicipio, "estado": cambioEstado, "idBD": 'id_municipio', "tablaBD": '_cat_municipios'},
            success:function(data){
            },
        });
    }
</script>
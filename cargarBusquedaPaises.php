<?php
	require("conexion.php");

	error_reporting(0);
	if(isset($_POST['paises'])) {
		$q=$conexion->real_escape_string($_POST['paises']);
		$consulta="SELECT * FROM _cat_pais WHERE clave_pais LIKE '%".$q."%' || nombre_pais LIKE '%".$q."%' ORDER BY nombre_pais ASC LIMIT 20";
	}

	$buscar=$conexion->query($consulta);

	$tabla='
		<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
	        <thead>
	            <tr>
	                <th>Clave Pais</th>
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
					<td>'.$fila['nombre_pais'].'</td>
					<td class="btn-switch">
                        <label class="switch">
                            <input type="checkbox" id="'.$fila['id_pais'].'" name="btnSwitch" onclick="updateEstatus('.$fila['id_pais'].','.$fila['id_pais'].');" value="'.$fila['estatus'].'" '.$condicion.'>
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
    function updateEstatus(idPais, nombreSwitch)
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
            data: {"id": idPais, "estado": cambioEstado, "idBD": 'id_pais', "tablaBD": '_cat_pais'},
            success:function(data){
            },
        });
    }
</script>
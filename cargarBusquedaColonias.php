<?php
	require("conexion.php");

	error_reporting(0);
	if(isset($_POST['colonias'])) {
		$q=$conexion->real_escape_string($_POST['colonias']);
		$consulta="SELECT * FROM _cat_colonias WHERE nombre_colonia LIKE '%".$q."%' ORDER BY nombre_colonia ASC LIMIT 20";
	}

	$buscar=$conexion->query($consulta);

	$tabla='
		<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
	        <thead>
	            <tr>
                    <th>C&oacute;digo Postal</th>
	                <th>Clave Colonia</th>
                    <th>Nombre</th>
                    <th>Estatus</th>
	            </tr>
	        </thead>
	';

	if ($buscar->num_rows > 0) {
		while($fila= $buscar->fetch_assoc()) {
			$condicion = $fila['estatus'] == '1' ? 'checked' : '2';

			$tabla.='
			<tbody>
				<tr>
					<td>'.$fila['codigo_postal'].'</td>
					<td>'.$fila['clave_colonia'].'</td>
					<td>'.$fila['nombre_colonia'].'</td>
					<td class="btn-switch">
                        <label class="switch">
                            <input type="checkbox" id="'.$fila['id_colonia'].'" name="btnSwitch" onclick="updateEstatus('.$fila['id_colonia'].','.$fila['id_colonia'].');" value="'.$fila['estatus'].'" '.$condicion.'>
                            <span class="slider round"></span>
                        </label>
                    </td>
				</tr>
			 </tbody>
			';
		}
	} else {
		$tabla.='
			<tbody>
				<tr>
					<td colspan="4" style="text-align: center">Lo sentimos, no se han encontrado resultados para tu búsqueda.</td>
				</tr>
			</tbody>
		';
	}

	$tabla.="</table>";
	echo $tabla;
?>

<script language="JavaScript">
    function updateEstatus(idColonia, nombreSwitch)
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
            data: {"id": idColonia, "estado": cambioEstado, "idBD": 'id_colonia', "tablaBD": '_cat_colonias'},
            success:function(data){
            },
        });
    }
</script>
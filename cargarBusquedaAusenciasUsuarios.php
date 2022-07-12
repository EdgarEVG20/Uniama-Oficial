<?php
	require("conexion.php");

	error_reporting(0);
	if(isset($_POST['nombreAusenciasUsuarios']) && isset($_POST['id'])) {
		$id = $conexion->real_escape_string($_POST['id']);
		$q = $conexion->real_escape_string($_POST['nombreAusenciasUsuarios']);
		$consulta="SELECT * FROM usuarios WHERE id_empresa = $id AND estatus = 1 AND nombre LIKE '%".$q."%' ORDER BY nombre ASC LIMIT 20";
	}

	$buscar=$conexion->query($consulta);

	$tabla='
		<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
	        <thead>
	            <tr>
                    <th>Foto</th>
                    <th>Nombre</th>
                    <th>Nivel</th>
                    <th>Acciones</th>
                </tr>
	        </thead>
	';

	if ($buscar->num_rows > 0) {
		while($fila= $buscar->fetch_assoc()) {
			$id = $fila['id_empresa'];
			$idUsuarioEmpresa = $fila['id_usuario'];

			$foto = "Clientes/".$id."/empleados/".$idUsuarioEmpresa."/imgPerfil/fotoPerfil.png";

            if (file_exists($foto)) {
                $img = "<img class='fotoPerfilMiniaturaTabla rounded-circle' src='Clientes/".$id."/empleados/".$idUsuarioEmpresa."/imgPerfil/fotoPerfil.png'>";
            } else {
                $img = "<img class='fotoPerfilMiniaturaTabla rounded-circle' src='Clientes/fotoTemp.png'>";
            }

            if ($fila['nivel'] == 2) {
                $nivel = "Administrador";
            } elseif ($fila['nivel'] == 3) {
                $nivel = "Supervisor";
            } elseif ($fila['nivel'] == 4) {
                $nivel = "Colaborador";
            } else {
                $nivel = "No especificado";
            }
			
			$tabla.='
			<tbody>
				<tr>
					<td>'.$img.'</td>
					<td>'.$fila['nombre'].'</td>
                    <td>'.$nivel.'</td>
					<td class="btn-ver">
                        <a type="button" class="btn btn-success" href="adminVerAusenciasT.php?idU='.$idUsuarioEmpresa.'"><i class="fas fa-eye"></i></a>
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
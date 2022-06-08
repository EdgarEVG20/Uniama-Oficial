<?php
	require("conexion.php");

	error_reporting(0);
	if(isset($_POST['id']) && isset($_POST['idPuesto'])) {
		$id = $conexion->real_escape_string($_POST['id']);
		$idPuesto = $conexion->real_escape_string($_POST['idPuesto']);

		$consulta = "SELECT usuarios.id_usuario, usuarios.id_empresa, usuarios.nombre, usuarios.nivel, catalogo_departamentos.nombre AS nombreD, catalogo_puestos.nombre_puesto, usuarios.correo, usuarios.estatus FROM usuarios LEFT JOIN usuarios_perfiles ON usuarios.id_usuario = usuarios_perfiles.id_usuario AND usuarios.id_empresa = usuarios_perfiles.id_empresa LEFT JOIN catalogo_puestos ON usuarios_perfiles.il_puesto = catalogo_puestos.id_puesto AND usuarios_perfiles.id_empresa = catalogo_puestos.id_empresa LEFT JOIN catalogo_departamentos ON catalogo_puestos.id_departamento = catalogo_departamentos.id_departamento WHERE usuarios.id_empresa = $id AND catalogo_puestos.id_puesto = $idPuesto ORDER BY usuarios.nombre ASC";
	}

	$buscar = $conexion->query($consulta);

	if ($buscar->num_rows > 0) {
		while($fila = $buscar->fetch_assoc()) {
			$condicion = $fila['estatus'] == '1' ? 'checked' : '2';
			$id = $fila['id_empresa'];
			$idUsuarioEmpresa = $fila['id_usuario'];
			//$rfc = $fila['ips_rfc'];
			
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
            
			$tabla.=
			'
				<tr>
					<td>'.$img.'</td>
					<td>'.$fila['nombre'].'</td>
					<td>'.$nivel.'</td>
					<td>'.$fila['nombreD'].'</td>
					<td>'.$fila['nombre_puesto'].'</td>
					<td class="btn-switch">
                        <label class="switch">
                            <input type="checkbox" id="'.$fila['id_usuario'].'" name="btnSwitch" onclick="updateEstatus('.$fila['id_usuario'].','.$fila['id_usuario'].');" value="'.$fila['estatus'].'" '.$condicion.'>
                            <span class="slider round"></span>
                        </label>
                    </td>
                    <td class="btn-modificar">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-edit-empleado'.$fila['id_usuario'].'"><i class="fas fa-user-edit"></i></button>
                    </td>
                    <td class="btn-ver">
                        <a type="button" class="btn btn-success" href="adminVerMiPerfilT.php?idU='.$fila['id_usuario'].'"><i class="fas fa-eye"></i></a>
                    </td>
                </tr>
			';
		}		
	}
	echo $tabla;
?>

<script language="JavaScript">
    function updateEstatus(idUsuario, nombreSwitch)
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
            data: {"id": idUsuario, "estado": cambioEstado, "idBD": 'id_usuario', "tablaBD": 'usuarios'},
            success:function(data){
            },
        });
    }
</script>
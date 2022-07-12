<?php
    require("conexion.php");

    error_reporting(0);
    if(isset($_POST['id']) && isset($_POST['idDepartamento'])) {
        $id = $conexion->real_escape_string($_POST['id']);
        $idDepartamento = $conexion->real_escape_string($_POST['idDepartamento']);
        
        $consulta = "SELECT usuarios.id_usuario, usuarios.id_empresa, usuarios.nombre, usuarios.nivel, catalogo_departamentos.nombre AS nombreD, catalogo_puestos.nombre_puesto, usuarios.estatus FROM usuarios LEFT JOIN usuarios_perfiles ON usuarios.id_usuario = usuarios_perfiles.id_usuario AND usuarios.id_empresa = usuarios_perfiles.id_empresa LEFT JOIN catalogo_puestos ON usuarios_perfiles.il_puesto = catalogo_puestos.id_puesto AND usuarios_perfiles.id_empresa = catalogo_puestos.id_empresa LEFT JOIN catalogo_departamentos ON catalogo_puestos.id_departamento = catalogo_departamentos.id_departamento WHERE usuarios.id_empresa = $id AND catalogo_departamentos.id_departamento = $idDepartamento ORDER BY usuarios.nombre ASC";
    }

    $buscar = $conexion->query($consulta);
    $tabla="";
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

            $tabla.='
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

                <div class="modal fade" id="modal-edit-empleado'.$fila['id_usuario'].'" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modificar Tipo De Usuario</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <form action="server/update-adminEmpleados.php" method="POST">
                                <input type="hidden" name="id2" value="'.$idEmpresa.'">
                                <input type="hidden" name="idEmpleado2" value="'.$data['id_usuario'].'">
                                <div class="modal-body">
                                    <div class="col">
                                        <div class="row pt-3 pb-4">
                                            <div class="col-12 mt-3">
                                                <small>Tipo Usuario</small>
                                                <select class="form-control" name="tipoUsuario2" required>
            ';
                                                if ($fila['nivel'] == 2) {
                                                    $tabla.='<option value="" disabled>Tipo Usuario</option>';
                                                    $tabla.='<option value="2" selected>Administrador</option>';
                                                    $tabla.='<option value="3">Supervisor</option>';
                                                    $tabla.='<option value="4">Colaborador</option>';
                                                } elseif ($fila['nivel'] == 3) {
                                                    $tabla.='<option value="" disabled>Tipo Usuario</option>';
                                                    $tabla.='<option value="2">Administrador</option>';
                                                    $tabla.='<option value="3" selected>Supervisor</option>';
                                                    $tabla.='<option value="4">Colaborador</option>';
                                                } elseif ($fila['nivel'] == 4) {
                                                    $tabla.='<option value="">Tipo Usuario</option>';
                                                    $tabla.='<option value="2">Administrador</option>';
                                                    $tabla.='<option value="3">Supervisor</option>';
                                                    $tabla.='<option value="4" selected>Colaborador</option>';
                                                } else {
                                                    $tabla.='<option value="" disabled selected>Tipo Usuario</option>';
                                                    $tabla.='<option value="2">Administrador</option>';
                                                    $tabla.='<option value="3">Supervisor</option>';
                                                    $tabla.='<option value="4">Colaborador</option>';
                                                }
            $tabla.='
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                                    <button type="submit" class="btn btn-primary">Guardar cambios</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            ';
        }
    } else {
        $tabla.='
                <p style="margin: 0px; padding: 0px; text-align: center"></P>
                <tr>
                    <td colspan="7" style="text-align: center">Lo sentimos, no se han encontrado resultados para tu búsqueda.</td>
                </tr>
        ';
    }

    echo $tabla;
?>
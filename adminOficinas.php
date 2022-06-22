<?php
	session_start();
	require("conexion.php");

    $usuario = $_SESSION['nombre_user'];
    $idEmpresa = $_SESSION['id_emisor_user'];
    $nivelUsuario = $_SESSION['nivel_user'];

    if (!isset($usuario)){
        header("location: index.html");
    } elseif (isset($usuario) && $nivelUsuario == 2) {
	
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<?php
		$breadcrumb = "Tablero / Empresa / Oficinas";
		include("estructura/metas.php");
		include("estructura/title.php");
		include("estructura/hrefs.php");
	?>
	<script src="js/peticiones.js"></script>
</head>

<body id="page-top">
	
	<!-- Page Wrapper -->
	<div id="wrapper">

		<!-- Sidebar -->
		<?php
			include("estructura/menu.php");
		?>
		<!-- End of Sidebar -->

		<!-- Content Wrapper -->
		<div id="content-wrapper" class="d-flex flex-column">

			<!-- Main Content -->
			<div id="content">

				<!-- Topbar -->
				<?php
					include("estructura/encabezado.php");
				?>
				<!-- End of Topbar -->

				<!-- Begin Page Content -->
				<div class="container-fluid">

					<!-- Page Heading -->
					<h1 class="h3 mb-2 text-gray-800">Oficinas</h1>

					<!-- Formulario -->
					<form class="form mt-3 mb-5" action="server/insert-adminOficinas.php" method="POST">
						<h1 class="h5 mb-2 text-gray-800">Agregar oficinas.</h1>
						<input type="hidden" name="id" value="<?php echo $idEmpresa ?>">
						<div class="row pt-3">
							<div class="col-12">
								<input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre De oficina" required onkeyup="mayusculas(this)" maxlength="100">
							</div>
						</div>
						<div class="row pt-3 pb-4">
							<div class="col-3 mt-4">
								<input type="text" class="form-control" id="calle" name="calle" placeholder="Calle" required onkeyup="mayusculas(this)" maxlength="30">
							</div>
							<div class="col-3 mt-4">
								<input type="text" class="form-control" id="noExt" name="noExt" placeholder="N&uacute;mero Exterior" required onkeyup="mayusculas(this)" maxlength="15">
							</div>
							<div class="col-3 mt-4">
								<input type="text" class="form-control" id="noInt" name="noInt" placeholder="N&uacute;mero Interior" onkeyup="mayusculas(this)" maxlength="15">
							</div>

							<div class="col-3 mt-4">
								<input type="text" class="form-control" id="codigoPostal" name="codigoPostal" placeholder="C&oacute;digo Postal" min="0" onkeyup="cargarColonias();" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required maxlength="5">
							</div>
							<div class="col-3 pt-3">
								<select class="form-control form-select-sm" id="colonias" name="claveColonia" required disabled>
									<option selected>Colonias</option>
								</select>
							</div>
							<div class="col-3 pt-3">
								<select class="form-control form-select-sm" id="clavePais" name="clavePais" onclick="cargarEstados();" required disabled>
									<option value="#" disabled selected>Pa&iacute;ses</option>
									<!-- <?php
										// $query = mysqli_query($conexion, "SELECT * FROM _cat_pais WHERE estatus = 1");
										// while ($data = mysqli_fetch_assoc($query)){
									?>
											<option value="<?php // echo $data["clave_pais"]; ?>"><?php // echo $data["nombre_pais"]; ?></option>
									<?php
										// }
									?> -->
								</select>
							</div>
							<div class="col-3 pt-3">
								<select class="form-control form-select-sm" id="claveEstado" name="claveEstado" onclick="cargarMunicipios();" required disabled>
									<option selected>Estados</option>
								</select>
							</div>
							<div class="col-3 pt-3">
								<select class="form-control form-select-sm" id="municipios" name="claveMunicipio" required disabled>
									<option selected>Municipios</option>
								</select>
							</div>
							<div class="col-6 pt-3">
								<input type="text" class="form-control" id="correo" name="correo" placeholder="Correo" required onkeyup="minusculas(this)" maxlength="75">
							</div>
							<div class="col-6 pt-3">
								<input type="text" class="form-control" id="telefono" name="telefono" placeholder="Tel&eacute;fono" required onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" maxlength="10">
							</div>
						</div>

						<center><button type="submit" class="btn btn-primary">Agregar</button></center>
					</form>

					<!-- DataTables -->
					<div class="card shadow mb-4">
						<div class="card-header py-3">
							<h6 class="m-0 font-weight-bold text-primary">Registro de datos</h6>
						</div>
						<?php
							$res = mysqli_query($conexion, "SELECT empresas_oficinas.id_oficina, empresas_oficinas.nombre_oficina, empresas_oficinas.calle, empresas_oficinas.noExt, empresas_oficinas.noInt, _cat_colonias.nombre_colonia, _cat_colonias.codigo_postal, _cat_municipios.nombre_municipio, _cat_estados.estado, _cat_pais.nombre_pais, empresas_oficinas.correo, empresas_oficinas.telefono, empresas_oficinas.estatus FROM empresas_oficinas INNER JOIN _cat_colonias ON empresas_oficinas.clave_colonia=_cat_colonias.clave_colonia AND empresas_oficinas.codigo_postal=_cat_colonias.codigo_postal INNER JOIN _cat_municipios ON empresas_oficinas.clave_municipio=_cat_municipios.clave_municipio AND empresas_oficinas.clave_estado=_cat_municipios.clave_estado INNER JOIN _cat_estados ON empresas_oficinas.clave_estado=_cat_estados.catalogo INNER JOIN _cat_pais ON empresas_oficinas.clave_pais=_cat_pais.clave_pais WHERE id_empresa = $idEmpresa ORDER BY empresas_oficinas.nombre_oficina ASC");
						?>

						<div class="card-body">
							<div class="table-responsive">
								<table class="table table-hover" id="dataTable" width="100%" cellspacing="0">
									<thead>
										<tr>
											<th>Nombre</th>
											<th>Calle</th>
											<th>No Exterior</th>
											<th>No Interior</th>
											<th>C&oacute;digo Postal</th>
											<th>Colonia</th>
											<th>Municipio</th>
											<th>Estado</th>
											<th>Pais</th>
											<th>Correo</th>
											<th>Tel&eacute;fono</th>
											<th>Estatus</th>
											<th colspan="2">Acciones</th>                                            
										</tr>
									</thead>
									
									<?php
										while($data = mysqli_fetch_array($res)){
									?>

									<tbody>
										<tr>
											<td><?php echo $data['nombre_oficina'] ?></td>
											<td><?php echo $data['calle'] ?></td>
											<td><?php echo $data['noExt'] ?></td>
											<td>
												<?php
													if ($data['noInt'] == null || $data['noInt'] == "") {
														echo "N/A";
													} else {
													echo $data['noInt'];
													}
												?>	
											</td>
											<td><?php echo $data['codigo_postal'] ?></td>
											<td><?php echo $data['nombre_colonia'] ?></td>
											<td><?php echo $data['nombre_municipio'] ?></td>
											<td><?php echo $data['estado'] ?></td>
											<td><?php echo $data['nombre_pais'] ?></td>
											<td><?php echo $data['correo'] ?></td>
											<td><?php echo $data['telefono'] ?></td>
											<td class="btn-switch">
												<label class="switch">
													<input type="checkbox" id="<?php echo $data['id_oficina']?>" name="btnSwitch" onclick="updateEstatus(<?php echo $data['id_oficina']?>,<?php echo $data['id_oficina']?>);" value="<?php echo $data['estatus']?>" <?php echo $data['estatus'] == '1' ? 'checked' : '2' ;?>>
													<span class="slider round"></span>
												</label>
											</td>
											<td class="btn-modificar">
												<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-edit-oficina<?php echo $data['id_oficina']; ?>"><i class="fas fa-edit"></i></button>
											</td>
											<td class="btn-eliminar">
												<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-oficina<?php echo $data['id_oficina']; ?>"><i class="fas fa-trash-alt"></i></button>
											</td>
										</tr>
									</tbody>

									<!-- Modal Para Modificar Oficina-->
									<div class="modal fade" id="modal-edit-oficina<?php echo $data['id_oficina']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Modificar Oficina</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<form action="server/update-adminOficinas.php" method="POST">
													<input type="hidden" name="id" value="<?php echo $data['id_oficina']?>">
													<div class="modal-body">
														<div class="col">
															<div class="row pt-3">
																<div class="col-12">
																	<small>Nombre</small>
																	<input type="text" class="form-control" name="nombreOficina2" placeholder="Nombre de oficina" value="<?php echo $data['nombre_oficina'] ?>" onkeyup="mayusculas(this)"maxlength="100">
																</div>
															</div>
															<div class="row pb-4">
																<div class="col-6 mt-3">
																	<small>Calle</small>
																	<input type="text" class="form-control" name="calle2" placeholder="Calle" value="<?php echo $data['calle'] ?>" onkeyup="mayusculas(this)" maxlength="30">
																</div>
																<div class="col-6 mt-3">
																	<small>N&uacute;mero Exterior</small>
																	<input type="text" class="form-control"  name="noExt2" placeholder="N&uacute;mero Exterior" value="<?php echo $data['noExt'] ?>" onkeyup="mayusculas(this)" maxlength="15">
																</div>
																<div class="col-6 mt-3">
																	<small>N&uacute;mero Interior</small>
																	<input type="text" class="form-control" name="noInt2" placeholder="N&uacute;mero Interior" value="<?php echo $data['noInt'] ?>" onkeyup="mayusculas(this)" maxlength="15">
																</div>
																<div class="col-6 mt-3">
																	<small>C&oacute;digo Postal</small>
																	<input type="text" class="form-control" id="codigoPostal2" name="codigoPostal2" placeholder="C&oacute;digo Postal" min="0" onkeyup="cargarColoniasModal();" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" value="<?php echo $data['codigo_postal'] ?>" maxlength="5">
																</div>

																<!-- Colonia-->
																<div class="col-6 mt-3">
																	<small>Colonia</small>
																	<select class="form-control" id="colonias2" name="claveColonia2">
																		<option value="#" disabled selected>Colonia</option>
																		<?php
																			$idOficina = $data['id_oficina'];
																			$sqlOficina = mysqli_query($conexion, "SELECT * FROM empresas_oficinas WHERE id_empresa = '".$idEmpresa."' AND id_oficina = '".$idOficina."'");
																			$resOficina = mysqli_fetch_assoc($sqlOficina);
																			$claveColonia = $resOficina['clave_colonia'];

																			$query = mysqli_query($conexion, "SELECT * FROM _cat_colonias WHERE codigo_postal = '".$resOficina['codigo_postal']."' AND estatus = 1 ORDER BY nombre_colonia ASC");
																			while ($dataColonia = mysqli_fetch_assoc($query)){
																				$selected = '';
																				if ($claveColonia == $dataColonia['clave_colonia']) {
																					echo '<option value="'.$dataColonia['clave_colonia'].'" selected>'.$dataColonia["nombre_colonia"].'</option>';
																				}
																				else {
																					echo '<option value="'.$dataColonia['clave_colonia'].'">'.$dataColonia["nombre_colonia"].'</option>';
																				}
																			}
																		?>
																	</select>
																</div>

																<!-- Pais-->
																<div class="col-6 mt-3">
																	<small>Pa&iacute;s</small>
																	<select class="form-control" id="clavePais2" name="clavePais2" onclick="cargarEstadosModal();">
																		<option value="#" disabled selected>Pais</option>
																		<?php
																			$clavePais = $resOficina['clave_pais'];

																			$query = mysqli_query($conexion, "SELECT * FROM _cat_pais WHERE estatus = 1 ORDER BY nombre_pais ASC");
																			while ($dataPais = mysqli_fetch_assoc($query)){
																				$selected = '';
																				if ($clavePais == $dataPais['clave_pais']) {
																					echo '<option value="'.$dataPais['clave_pais'].'" selected>'.$dataPais["nombre_pais"].'</option>';
																				}
																				else {
																					echo '<option value="'.$dataPais['clave_pais'].'">'.$dataPais["nombre_pais"].'</option>';
																				}
																			}
																		?>
																	</select>
																</div>

																<!-- Estado-->
																<div class="col-6 mt-3">
																	<small>Estado</small>
																	<select class="form-control" id="claveEstado2" name="claveEstado2" onclick="cargarMunicipiosModal();">
																		<option value="#" disabled selected>Estado</option>
																		<?php
																			$claveEstado = $resOficina['clave_estado'];

																			$query = mysqli_query($conexion, "SELECT * FROM _cat_estados WHERE clave_pais = '".$clavePais."' AND estatus = 1 ORDER BY estado ASC");
																			while ($dataEstado = mysqli_fetch_assoc($query)){
																				$selected = '';
																				if ($claveEstado == $dataEstado['catalogo']) {
																					echo '<option value="'.$dataEstado['catalogo'].'" selected>'.$dataEstado["estado"].'</option>';
																				}
																				else {
																					echo '<option value="'.$dataEstado['catalogo'].'">'.$dataEstado["estado"].'</option>';
																				}
																			}
																		?>
																	</select>
																</div>

																<!-- Municipio-->
																<div class="col-6 mt-3">
																	<small>Municipio</small>
																	<select class="form-control" id="municipios2" name="claveMunicipio2">
																		<option value="#" disabled selected>Municipio</option>
																		<?php
																			$claveMunicipio = $resOficina['clave_municipio'];

																			$query = mysqli_query($conexion, "SELECT * FROM _cat_municipios WHERE clave_estado = '".$claveEstado."' AND estatus = 1 ORDER BY nombre_municipio ASC");
																			while ($dataMunicipio = mysqli_fetch_assoc($query)){
																				$selected = '';
																				if ($claveMunicipio == $dataMunicipio['clave_municipio']) {
																					echo '<option value="'.$dataMunicipio['clave_municipio'].'" selected>'.$dataMunicipio["nombre_municipio"].'</option>';
																				}
																				else {
																					echo '<option value="'.$dataMunicipio['clave_municipio'].'">'.$dataMunicipio["nombre_municipio"].'</option>';
																				}
																			}
																		?>
																	</select>
																</div>
																
																<div class="col-6 mt-3">
																	<small>Correo</small>
																	<input type="text" class="form-control" name="correo2" placeholder="Correo" value="<?php echo $data['correo'] ?>" onkeyup="minusculas(this)" maxlength="75">
																</div>
																<div class="col-6 mt-3">
																	<small>Tel&eacute;fono</small>
																	<input type="text" class="form-control" name="telefono2" placeholder="Tel&eacute;fono" value="<?php echo $data['telefono'] ?>" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" maxlength="10">
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


									<!-- Modal Para Eliminar Oficina-->
									<div class="modal fade" id="modal-delete-oficina<?php echo $data['id_oficina']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog" role="document">
											<div class="modal-content">
												<div class="modal-header">
													<h5 class="modal-title" id="exampleModalLabel">Eliminar Oficina</h5>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
														<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<form action="server/delete-adminOficinas.php" method="POST">
													<input type="hidden" name="id" value="<?php echo $idEmpresa ?>">
													<input type="hidden" name="idOficina" value="<?php echo $data['id_oficina']?>">
													<div class="modal-body">
														<h5>¿Estás seguro de eliminar la oficina con el nombre: <?php echo $data['nombre_oficina']; ?>?</h5>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
														<button type="submit" class="btn btn-danger">Si</button>
													</div>
												</form>
											</div>
										</div>
									</div>

									<?php
										}
									?>
										
								</table>
							</div>
						</div>
					</div>

				</div>
				<!-- /.container-fluid -->

			</div>
			<!-- End of Main Content -->

			<!-- Footer -->
			<?php
				include("estructura/pie.php");
			?>
			<!-- End of Footer -->

		</div>
		<!-- End of Content Wrapper -->

	</div>
	<!-- End of Page Wrapper -->

	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>

	<!-- Bootstrap core JavaScript-->
	<script src="vendor/jquery/jquery.min.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

	<!-- Core plugin JavaScript-->
	<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

	<!-- Custom scripts for all pages-->
	<script src="js/sb-admin-2.min.js"></script>

<?php
    } elseif (isset($usuario) && $nivelUsuario == 1 || $nivelUsuario == 3 || $nivelUsuario == 4) {
        header("location: panel2.php");
    }
    mysqli_close($conexion);
?>

<script language="JavaScript">
	function updateEstatus(idAdOficinas, nombreSwitch)
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
			data: {"id":idAdOficinas, "estado":cambioEstado, "idBD":'id_oficina', "tablaBD":'empresas_oficinas'},
			success:function(data){
			},
		});
	}
</script>

</body>
</html>
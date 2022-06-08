function mayusculas(letra) {
    letra.value = letra.value.toUpperCase();
}

function minusculas(letra) {
    letra.value = letra.value.toLowerCase();
}

function cargarColonias() {
	caracteres = $("#codigoPostal").val();

	if(caracteres.length == 5) {
		$.ajax({
			cache: false,
			url : 'cargarColonias.php',
			type : 'POST',
			dataType : 'html',
			data : { codigoPostal: caracteres },
		})
		.done(function(resultado){
			if (resultado == 0) {
                $("#colonias").html('<option disabled selected value="">Registro No Encontrado.</option>');
            } else {
                $("#colonias").html(resultado);
            }
		})
		$("#colonias").removeAttr('disabled');
	} else {
		$("#colonias").html('<option>Colonias</option>');
        $("#colonias").prop('disabled','disabled');
	}

	if(caracteres.length == 5) {
		$.ajax({
			cache: false,
			url : 'cargarPaises.php',
			type : 'POST',
			dataType : 'html',
			data : { codigoPostal: caracteres },
		})
		.done(function(resultado){
			if (resultado == 0) {
                $("#clavePais").html('<option disabled selected value="">Registro No Encontrado.</option>');
            } else {
                $("#clavePais").html(resultado);
            }
		})
		$("#clavePais").removeAttr('disabled');
	} else {
		$("#clavePais").html('<option>Países</option>');
        $("#clavePais").prop('disabled','disabled');
	}

    if(caracteres.length == 5) {
        $.ajax({
        	cache: false,
        	url : 'cargarEstados.php',
        	type : 'POST',
        	dataType : 'html',
        	data : { codigoPostal: caracteres },
        })
        .done(function(resultado){
            if (resultado == 0) {
                $("#claveEstado").html('<option disabled selected value="">Registro No Encontrado.</option>');
            }else{
                $("#claveEstado").html(resultado);
            }
        })
        $("#claveEstado").removeAttr('disabled');
    } else {
        $("#claveEstado").html('<option>Estados</option>');
        $("#claveEstado").prop('disabled','disabled');
    }

    if(caracteres.length == 5) {
        $.ajax({
        	cache: false,
        	url : 'cargarMunicipios.php',
        	type : 'POST',
        	dataType : 'html',
        	data : { codigoPostal: caracteres },
        })
        .done(function(resultado){
            if (resultado == 0) {
                $("#municipios").html('<option disabled selected value="">Registro No Encontrado.</option>');
            }else{
                $("#municipios").html(resultado);
            }
        })
        $("#municipios").removeAttr('disabled');
    } else {
        $("#municipios").html('<option>Municipios</option>');
        $("#municipios").prop('disabled','disabled');
    }
}

function cargarColoniasModal() {
	caracteres = $("#codigoPostal2").val();

	if(caracteres.length == 5) {
		$.ajax({
			cache: false,
			url : 'cargarColonias.php',
			type : 'POST',
			dataType : 'html',
			data : { codigoPostal: caracteres },
		})
		.done(function(resultado){
			if (resultado == 0) {
                $("#colonias2").html('<option disabled selected value="">Registro No Encontrado.</option>');
            } else {
                $("#colonias2").html(resultado);
            }
		})
		$("#colonias2").removeAttr('disabled');
	} else {
		$("#colonias2").html('<option>colonias</option>');
        $("#colonias2").prop('disabled','disabled');
	}

	if(caracteres.length == 5) {
		$.ajax({
			cache: false,
			url : 'cargarPaises.php',
			type : 'POST',
			dataType : 'html',
			data : { codigoPostal: caracteres },
		})
		.done(function(resultado){
			if (resultado == 0) {
                $("#clavePais2").html('<option disabled selected value="">Registro No Encontrado.</option>');
            } else {
                $("#clavePais2").html(resultado);
            }
		})
		$("#clavePais2").removeAttr('disabled');
	} else {
		$("#clavePais2").html('<option>Países</option>');
        $("#clavePais2").prop('disabled','disabled');
	}

    if(caracteres.length == 5) {
        $.ajax({
        	cache: false,
        	url : 'cargarEstados.php',
        	type : 'POST',
        	dataType : 'html',
        	data : { codigoPostal: caracteres },
        })
        .done(function(resultado){
            if (resultado == 0) {
                $("#claveEstado2").html('<option disabled selected value="">Registro No Encontrado.</option>');
            }else{
                $("#claveEstado2").html(resultado);
            }
        })
        $("#claveEstado2").removeAttr('disabled');
    } else {
        $("#claveEstado2").html('<option>Estados</option>');
        $("#claveEstado2").prop('disabled','disabled');
    }

    if(caracteres.length == 5) {
        $.ajax({
        	cache: false,
        	url : 'cargarMunicipios.php',
        	type : 'POST',
        	dataType : 'html',
        	data : { codigoPostal: caracteres },
        })
        .done(function(resultado){
            if (resultado == 0) {
                $("#municipios2").html('<option disabled selected value="">Registro No Encontrado.</option>');
            }else{
                $("#municipios2").html(resultado);
            }
        })
        $("#municipios2").removeAttr('disabled');
    } else {
        $("#municipios2").html('<option>Municipios</option>');
        $("#municipios2").prop('disabled','disabled');
    }
}


// function cargarColonias() {
// 	caracteres = $("#codigoPostal").val();
// 	if(caracteres.length == 5){
// 		$.ajax({
// 			cache: false,
// 			url : 'cargarColonias.php',
// 			type : 'POST',
// 			dataType : 'html',
// 			data : { codigoPostal: caracteres },
// 		})
// 		.done(function(resultado){
// 			$("#colonias").html(resultado);
// 		})
// 		$("#colonias").removeAttr('disabled');
// 	}else{
// 		$("#colonias").html('<option>Colonias</option>');
// 		$("#colonias").prop('disabled','disabled');
// 	}
// }

// function cargarColoniasModal() {
// 	caracteres = $("#codigoPostal2").val();
// 	if(caracteres.length == 5){
// 		$.ajax({
// 			cache: false,
// 			url : 'cargarColonias.php',
// 			type : 'POST',
// 			dataType : 'html',
// 			data : { codigoPostal: caracteres },
// 		})
// 		.done(function(resultado){
// 			$("#colonias2").html(resultado);
// 		})
// 		$("#colonias2").removeAttr('disabled');
// 	}else{
// 		$("#colonias2").html('<option>Colonias</option>');
// 		$("#colonias2").prop('disabled','disabled');
// 	}
// }

// function cargarEstados(){
// 	cPais = $("#clavePais").val();
// 	if(cPais.length > 0){
// 		$.ajax({
// 			cache: false,
// 			url : 'cargarEstados.php',
// 			type : 'POST',
// 			dataType : 'html',
// 			data : { pais: cPais },
// 		})
// 		.done(function(resultado){
// 			$("#claveEstado").html(resultado);
// 		})
// 		$("#claveEstado").removeAttr('disabled');
// 	}else{
// 		$("#claveEstado").html('<option>Estados</option>');
// 		$("#claveEstado").prop('disabled','disabled');
// 	}
// }

// function cargarEstadosModal() {
// 	cPais = $("#clavePais2").val();
// 	if(cPais.length > 0){
// 		$.ajax({
// 			cache: false,
// 			url : 'cargarEstados.php',
// 			type : 'POST',
// 			dataType : 'html',
// 			data : { pais: cPais },
// 		})
// 		.done(function(resultado){
// 			$("#claveEstado2").html(resultado);
// 		})
// 		$("#claveEstado2").removeAttr('disabled');
// 	}else{
// 		$("#claveEstado2").html('<option>Estados</option>');
// 		$("#claveEstado2").prop('disabled','disabled');
// 	}
// }

// function cargarMunicipios() {
// 	cEstado = $("#claveEstado").val();
// 	if(cEstado.length > 0){
// 		$.ajax({
// 			cache: false,
// 			url : 'cargarMunicipios.php',
// 			type : 'POST',
// 			dataType : 'html',
// 			data : {estado: cEstado },
// 		})
// 		.done(function(resultado){
// 			$("#municipios").html(resultado);
// 		})
// 		$("#municipios").removeAttr('disabled');
// 	}else{
// 		$("#municipios").html('<option>Municipios</option>');
// 		$("#municipios").prop('disabled','disabled');
// 	}
// }

// function cargarMunicipiosModal() {
// 	cEstado = $("#claveEstado2").val();
// 	if(cEstado.length > 0){
// 		$.ajax({
// 			cache: false,
// 			url : 'cargarMunicipios.php',
// 			type : 'POST',
// 			dataType : 'html',
// 			data : {estado: cEstado },
// 		})
// 		.done(function(resultado){
// 			$("#municipios2").html(resultado);
// 		})
// 		$("#municipios2").removeAttr('disabled');
// 	}else{
// 		$("#municipios2").html('<option>Municipios</option>');
// 		$("#municipios2").prop('disabled','disabled');
// 	}
// }

function cargarPuestos() {
	cDepartamento = $("#idDepartamento").val();
	if(cDepartamento.length > 0){
		$.ajax({
			cache: false,
			url : 'cargarPuestos.php',
			type : 'POST',
			dataType : 'html',
			data : {departamento: cDepartamento },
		})
		.done(function(resultado){
			$("#puestos").html(resultado);
		})
		$("#puestos").removeAttr('disabled');
	}else{
		$("#puestos").html('<option>Cargos / Puestos</option>');
		$("#puestos").prop('disabled','disabled');
	}
}

function cargarPuestoYCorreoSupervisor() {
	idSupervisorAusencias = $("#idSupervisorAusencias").val();
	$.ajax({
		cache: false,
		url : 'cargarPuestoYCorreoSupervisor.php',
		type : 'POST',
		dataType : 'html',
		data : { idSupervisorAusencias: idSupervisorAusencias },
	})
	.done(function(resultado){
		$("#puestoCorreoSupervisor").html(resultado);
	})
}

function cargarPrecioSuscripcion() {
	tipoSuscripcion = $("#suscripcion").val();
	
	if(tipoSuscripcion == "1 - 40") {
	    $("#precio").val("986.00");
	}
	if(tipoSuscripcion == "41 - 80") {
	    $("#precio").val("1875.00");
	}
	if(tipoSuscripcion == "+80") {
	    $("#precio").val("3450.00");
	}
	/*
	$.ajax({
		cache: false,
		url : 'cargarPrecioSuscripcion.php',
		type : 'POST',
		dataType : 'html',
		data : { tipoSuscripcion: tipoSuscripcion },
	})
	.done(function(resultado){
		$("#precio").html(resultado);
	})
	*/
}

function cargarPrecioSuscripcionModal(empresa) {
	tipoSuscripcion = $("#suscripcion"+empresa).val();
	
	if(tipoSuscripcion == "1 - 40") {
	    $("#precio"+empresa).val("986.00");
	}
	if(tipoSuscripcion == "41 - 80") {
	    $("#precio"+empresa).val("1875.00");
	}
	if(tipoSuscripcion == "+80") {
	    $("#precio"+empresa).val("3450.00");
	}
	/*
	$.ajax({
		cache: false,
		url : 'cargarPrecioSuscripcionModal.php',
		type : 'POST',
		dataType : 'html',
		data : { tipoSuscripcionModal: tipoSuscripcionModal },
	})
	.done(function(resultado){
		$("#precioModal").html(resultado);
	})
	*/
}





//Filtrar datos en tabla de la vista "adminEmpleados.php"
function cargarDatosDepartamento() {
	id = $("#id").val();
	idDepartamento = $("#idDepartamento").val();
	console.log(idDepartamento);
	$.ajax({
		cache: false,
		url : 'cargarDatosDepartamento.php',
		type : 'POST',
		dataType : 'html',
		data : { id: id, idDepartamento: idDepartamento },
		})
	.done(function(resultado){
		$("#mostrarTabla").html(resultado);
	})
}

function cargarDatosPuesto() {
	id = $("#id").val();
	idPuesto = $("#idPuesto").val();

	$.ajax({
		cache: false,
		url : 'cargarDatosPuesto.php',
		type : 'POST',
		dataType : 'html',
		data : { id: id, idPuesto: idPuesto },
		})
	.done(function(resultado){
		$("#mostrarTabla").html(resultado);
	})
}

function cargarDatosEstatus() {
	id = $("#id").val();
	estatus = $("#estatus").val();

	$.ajax({
		cache: false,
		url : 'cargarDatosEstatus.php',
		type : 'POST',
		dataType : 'html',
		data : { id: id, estatus: estatus },
		})
	.done(function(resultado){
		$("#mostrarTabla").html(resultado);
	})
}





//Funciones para buscar registros de tablas.
function cargarBusquedaClientes() {
	clientes = document.getElementById('busqueda').value;

	$.ajax({
		cache: false,
		url : 'cargarBusquedaClientes.php',
		type : 'POST',
		dataType : 'html',
		data : { clientes: clientes },
		})

	.done(function(resultado){
		$("#mostrarTabla").html(resultado);
	})
}

function cargarBusquedaDocumentos() {
	documentos = document.getElementById('busqueda').value;

	$.ajax({
		cache: false,
		url : 'cargarBusquedaDocumentos.php',
		type : 'POST',
		dataType : 'html',
		data : { documentos: documentos },
		})

	.done(function(resultado){
		$("#mostrarTabla").html(resultado);
	})
}

function cargarBusquedaAusencias() {
	ausencias = document.getElementById('busqueda').value;

	$.ajax({
		cache: false,
		url : 'cargarBusquedaAusencias.php',
		type : 'POST',
		dataType : 'html',
		data : { ausencias: ausencias },
		})

	.done(function(resultado){
		$("#mostrarTabla").html(resultado);
	})
}

function cargarBusquedaPaises() {
	paises = document.getElementById('busqueda').value;

	$.ajax({
		cache: false,
		url : 'cargarBusquedaPaises.php',
		type : 'POST',
		dataType : 'html',
		data : { paises: paises },
		})

	.done(function(resultado) {
		$("#mostrarTabla").html(resultado);
	})
}

function cargarBusquedaEstados() {
	estados = document.getElementById('busqueda').value;

	$.ajax({
		cache: false,
		url : 'cargarBusquedaEstados.php',
		type : 'POST',
		dataType : 'html',
		data : { estados: estados },
		})

	.done(function(resultado) {
		$("#mostrarTabla").html(resultado);
	})
}

function cargarBusquedaMunicipios() {
	municipios = document.getElementById('busqueda').value;

	$.ajax({
		cache: false,
		url : 'cargarBusquedaMunicipios.php',
		type : 'POST',
		dataType : 'html',
		data : { municipios: municipios },
		})

	.done(function(resultado){
		$("#mostrarTabla").html(resultado);
	})
}

function cargarBusquedaColonias() {
	colonias = document.getElementById('busqueda').value;

	$.ajax({
		cache: false,
		url : 'cargarBusquedaColonias.php',
		type : 'POST',
		dataType : 'html',
		data : { colonias: colonias },
		})

	.done(function(resultado){
		$("#mostrarTabla").html(resultado);
	})
}

function cargarBusquedaRegimenFiscal() {
	regimenFiscales = document.getElementById('busqueda').value;

	$.ajax({
		cache: false,
		url : 'cargarBusquedaRegimenFiscal.php',
		type : 'POST',
		dataType : 'html',
		data : { regimenFiscales: regimenFiscales },
		})

	.done(function(resultado){
		$("#mostrarTabla").html(resultado);
	})
}

function cargarBusquedaArchivosUsuarios(idEmpresa) {
	nombreArchivosUsuarios = document.getElementById('busqueda').value;

	$.ajax({
		cache: false,
		url : 'cargarBusquedaArchivosUsuarios.php',
		type : 'POST',
		dataType : 'html',
		data : { id: idEmpresa, nombreArchivosUsuarios: nombreArchivosUsuarios },
		})

	.done(function(resultado) {
		$("#mostrarTabla").html(resultado);
	})
}

function cargarBusquedaAusenciasUsuarios(idEmpresa) {
	nombreAusenciasUsuarios = document.getElementById('busqueda').value;

	$.ajax({
		cache: false,
		url : 'cargarBusquedaAusenciasUsuarios.php',
		type : 'POST',
		dataType : 'html',
		data : { id: idEmpresa, nombreAusenciasUsuarios: nombreAusenciasUsuarios },
		})

	.done(function(resultado) {
		$("#mostrarTabla").html(resultado);
	})
}





//Guardar cambios de Modales, cuando se hace una búsqueda.
function guardarCambios(idEmpresa) {
	var suscripcion = $("#suscripcion"+idEmpresa).val();
	var precio = $("#precio"+idEmpresa).val();
	var fecha = $("#fecha").val();
	$.ajax({
		cache: false,
		url : 'server/update-clientes.php',
		type : 'POST',
		dataType : 'html',
		data : { id : idEmpresa, suscripcion : suscripcion, precio : precio, fecha : fecha },
		})
	.done(function(resultado){
		location.reload();
	})
}

function guardarCambiosDocumentos(idDocumento) {
	var nombre = $("#nombre").val();
	$.ajax({
		cache: false,
		url : 'server/update-documentos.php',
		type : 'POST',
		dataType : 'html',
		data : { id : idDocumento, nombre : nombre },
		})
	.done(function(resultado){
		location.reload();
	})
}

function guardarCambiosAusencias(idAusencia) {
	var nombre = $("#nombre").val();
	$.ajax({
		cache: false,
		url : 'server/update-ausencias.php',
		type : 'POST',
		dataType : 'html',
		data : { id : idAusencia, nombre : nombre },
		})
	.done(function(resultado){
		location.reload();
	})
}

function guardarCambiosRegimenFiscal(idRegimenFiscal) {
	var clave = $("#clave").val();
	var descripcion = $("#descripcion").val();
	var persona = $("#persona").val();
	$.ajax({
		cache: false,
		url : 'server/update-regimenFiscal.php',
		type : 'POST',
		dataType : 'html',
		data : { id : idRegimenFiscal, clave : clave, descripcion : descripcion , persona : persona },
		})
	.done(function(resultado){
		location.reload();
	})
}

function cargarDependenciaDepartamentos() {
    var jerarquia = $("#jerarquia").val();
    if (jerarquia == 1) {
        $("#dependeDe").attr('disabled', true);
    } else{
    	$("#dependeDe").removeAttr('disabled');
    }
}

function cargarDependenciaDepartamentosModal(departamento) {
    var jerarquia = $("#jerarquia"+departamento).val();
    if (jerarquia == 1) {
        $("#dependeDe"+departamento).attr('disabled', true);
    } else{
    	$("#dependeDe"+departamento).removeAttr('disabled');
    }
}

var Nuevo = {

	quitarInvitado: function(usuarioid){

		for(var i=0; i<LIST_INVITADOS.length; i++){

			if(usuarioid == LIST_INVITADOS[i].usuarioid)

				LIST_INVITADOS.splice(i,1);

		}

		Nuevo.listarUsuariosInvitados();

	},

	agregarUsuario: function(usuarioid,nombre,email){

		//LIST_INVITADOS.push({'usuarioid':usuarioid,'nombre':nombre});

		//alert(email);

		var $correos = $('#emails');

		var htmlCorreos = $correos.val().replace(/\s/g,'');

		if(htmlCorreos == '')

			$correos.val(email.replace(/\s/g,''));

		else

			$correos.val(htmlCorreos + ';' + email.replace(/\s/g,''));

		$('#modalListaUsuarios').modal('hide');

		//Nuevo.listarUsuariosInvitados();

	},

	listarUsuariosInvitados: function(){

		var htmlLista = '';

		for(var i=0; i<LIST_INVITADOS.length; i++){

			var item = LIST_INVITADOS[i];

			htmlLista += '<a class="labelInvitado" onclick="Nuevo.quitarInvitado('+item.usuarioid+')">'+item.nombre+'</a> | ';

		}

		$('#listaInvitados').html(htmlLista);

	},

	mostrarListaUsuarios: function(){

		if(CRONOMETRO < TIEMPO_CONSULTA){

			CRONOMETRO = TIEMPO_CONSULTA;

			return;

		}

		this.iniciarCronometro();

	},

	iniciarCronometro: function(){

		CRONOMETRO -= 200;

		setTimeout(function(){

			if(CRONOMETRO <= 0){

				CRONOMETRO = TIEMPO_CONSULTA;

				var parametros = {

					'textoBusqueda' : $('#textoBusqueda').val(),

					'tipoTicket'	: $('#tipoTicket').val()

				};

				General.consultaArray(parametros, 12,function(datos){

					htmlTabla = '';

					for(var i=0; i<datos.resultados.length; i++){

						var item = datos.resultados[i];

						htmlTabla += '<tr><td><a href="#" onclick="Nuevo.agregarUsuario('+

							item.usuarioid+',\''+item.nombre+' '+item.paterno+'\',\''+item.email+'\')">'+item.nombre+' '+

							item.paterno+' '+item.materno+'</a></td><td>'+item.departamento+'</td><td>'+item.email+'</td></tr>';

					}

					$('#tablaBusquedaUsuarios').html(htmlTabla);

				});

			}

			else

				Nuevo.iniciarCronometro();

			//alert(CRONOMETRO);

		},200);

	},

	mostrarUsuarios: function(){

		$('#textoBusqueda').val('');

		$('#tablaBusquedaUsuarios').html('');

		$('#modalListaUsuarios').modal('show');

		setTimeout(function(){$('#textoBusqueda').focus()},800);

	},

	mostrarResponsable: function(){

		var parametros = {

			'aplicativoid' : $('#tipoAplicativo').val()

		}

		General.consultaArray(parametros, 11,function(datos){

			var textoUsuarios = '';

			//alert(datos.resultados.length);

			for(var i=0; i<datos.resultados.length; i++){

				var item = datos.resultados[i];

				if(i != 0)

					textoUsuarios += ', ';

				textoUsuarios += item.nombre + item.paterno;

			}

			$('#spanResponsable').html(textoUsuarios);

		});

	},

	/*confirmarRegistro: function(){

		if(!Nuevo.comprobarCampos()) return false;

		if(confirm('¿Está seguro de registrar el ticket?')){

			var html = '';

			for(var i=0; i<LIST_INVITADOS.length; i++){

				var item = LIST_INVITADOS[i];

				html += item.usuarioid+',';
			}

			$('#inputInvitados').val(html);

			return true;

		}
		else
		 	return false;

	},*/

	confirmarRegistro: function(){

		if(!Nuevo.comprobarCampos()) return false;

		swal({
		  title: '¿Está seguro de registrar el ticket?',
		  type: 'question',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Aceptar',
		  cancelButtonText: 'Cancelar'
		}).then(function (result) {
			if(result.value){
				document.getElementById("nuevoticket").submit();
				var html = '';

	    		for(var i=0; i<LIST_INVITADOS.length; i++){
	    			var item = LIST_INVITADOS[i];
	    			html += item.usuarioid+',';
	    		}
	    		('#inputInvitados').val(html);

				return true;
			}else{
				return false;
			}
		});

	},

	mostrarTipoSoporte: function(){

		var parametros = {};

		General.consultaArray(parametros, 35,Nuevo.mostrarDepartamentos);

	},

	mostrarDepartamentos: function(datos){

		var arrayConsulta = datos.resultados;

		var html = '';

		html += '<option value="0">Seleccione</option>';

			for(var i=0; i<arrayConsulta.length; i++){

				html += '<option value="'+arrayConsulta[i].tipoSoporteId+'">'+arrayConsulta[i].descripcion+'</option>';

			}

			$('#tipoSoporte').html(html);

	},

	consultarAplicativos: function(){

		$('#modalCarga').modal('show');

		var tipoSoporteid = $('#tipoSoporte').val();

		var parametros = {

			'tipoSoporteid' : tipoSoporteid

		};

		General.consultaArray(parametros, 2,Nuevo.mostrarTiposAplicativo);

	},

	mostrarTiposAplicativo: function(datos){

		if(datos.resultados.length > 0){

			var arrayConsulta = datos.resultados;

			

			var html = '';

			for(var i=0; i<arrayConsulta.length; i++){

				html += '<option value="'+arrayConsulta[i].aplicativoid+'">'+arrayConsulta[i].descripcion+'</option>';

			}

			$('#tipoAplicativo').html(html);

			$('#divAplicativo').show();

		}

		else{

			$('#tipoAplicativo').html('');

			$('#divAplicativo').hide();

		}

		Nuevo.mostrarResponsable();

		$('#modalCarga').modal('hide');

	},

	comprobarCampos: function(){

		var emails = $('#emails');

		var textoEmails = emails.val().replace(' ','');

		if(textoEmails == '')return true;



		var arrayEmails = textoEmails.split(';');

		for(var i=0; i<arrayEmails.length; i++){

			//console.log('correo'+i+':'+arrayEmails[i].length);

			if(arrayEmails[i].length > 0){

				if(arrayEmails[i].indexOf('@') < 0 || arrayEmails[i].indexOf('.') < 0){

					swal("Correo incorrecto" , "Ejemplo( prueba@teksi.com )", "warning");

					emails.focus();

					return false;

				}

			}

		}

		emails.val(textoEmails);

		// var descripcion = $('#descripcion');

		// var asunto = $('#asunto');

		// if(asunto.val() != ''){

		// 	if(descripcion.val() != '')

		// 		return true;

		// 	else

		// 		descripcion.focus();

		// }

		// else

		// 	asunto.focus();

		return true;

	},

	guardarTicket: function(){

		//if(Nuevo.comprobarCampos() == false) return;

		$('#modalCarga').modal('show');

		var tipoSoporte = $('#tipoSoporte').val();

		var tipoAplicativo = $('#tipoAplicativo').val();

		var tipoTicket = $('#tipoTicket').val();

		var detieneOperacion = $('#detieneOperacion').val();

		var descripcion = $('#descripcion').val();

		var parametros = {

			'tipoSoporte'		: tipoSoporte,

			'tipoAplicativo'	: tipoAplicativo,

			'tipoTicket'		: tipoTicket,

			'detieneOperacion'	: detieneOperacion,

			'descripcion'		: descripcion

		};

		General.consultaArray(parametros, 3,Nuevo.comprobarSiGuardo);

	},

	comprobarSiGuardo: function(datos){

		if(datos.resultados.length > 0){

			if(parseInt(datos.resultados[0].numeroAfectados) == 1)

				window.location = "inicio";

			else
                swal("Error al guardar", "intente nuevamente, en caso de continuar con el problema favor de reportar con sistemas.", "error");

		}

		$('#modalCarga').modal('hide');

	}

};

$(document).ready(function() {  

	Nuevo.consultarAplicativos();

});



var TIEMPO_CONSULTA = 1000;

var CRONOMETRO = TIEMPO_CONSULTA;

var LIST_INVITADOS = new Array();
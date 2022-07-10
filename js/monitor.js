

$(document).ready(function(){

	Monitor.consultarTickets();

});

var TICKET_MAXIMO = 0;

var TIEMPO = 50000;

var COUNT_ERROR = 0;

var Monitor = {

	consultarTickets: function(){

		var parametros = {};

		General.consultaArray(parametros, 5,Monitor.mostrarTickets);

	},

	mostrarTickets: function(datos){

		var arrayConsulta = datos.resultados;

		var html = '';

		var estiloActivo = 'active';

		for(var i=0; i<arrayConsulta.length; i++){

			var $iconoEstatus = '';

			if(TICKET_MAXIMO < parseInt(arrayConsulta[i].soporteid))

				TICKET_MAXIMO = parseInt(arrayConsulta[i].soporteid);

			if(arrayConsulta[i].estatusid == 1)

				iconoEstatus = '<img src="img/por-atender.png" title="'+arrayConsulta[i].estatus+'" alt="'+arrayConsulta[i].estatus+'" />';

			else if(arrayConsulta[i].estatusid == 2)

				iconoEstatus = '<img src="img/en-atencion.png" title="'+arrayConsulta[i].estatus+'" alt="'+arrayConsulta[i].estatus+'" />';

			else if(arrayConsulta[i].estatusid == 3)

				iconoEstatus = '<img src="img/finalizado.png" title="'+arrayConsulta[i].estatus+'" alt="'+arrayConsulta[i].estatus+'" />';

			else if(arrayConsulta[i].estatusid == 4)

				iconoEstatus = '<img src="img/cancelado.png" title="'+arrayConsulta[i].estatus+'" alt="'+arrayConsulta[i].estatus+'" />';

			else if(arrayConsulta[i].estatusid == 5)

				iconoEstatus = '<img src="img/suspendido.png" title="'+arrayConsulta[i].estatus+'" alt="'+arrayConsulta[i].estatus+'" />';

			var htmlFile = '';

			if(arrayConsulta[i].archivo != '')

				htmlFile = '<a href="archivos-usuarios/'+arrayConsulta[i].archivo+'" target="_blank"><img src="img/file.png" width="30"></a>';

			

			htmlOnClick = 'onclick="Monitor.consultarComentarios('+arrayConsulta[i].soporteid+','+arrayConsulta[i].estatusid+')"';

			html += '<tr class="'+estiloActivo+'">\

						<td>'+arrayConsulta[i].folio+'</td>\

						<td style="text-align:center">'+iconoEstatus+'</td>\

						<td>'+arrayConsulta[i].fecha+'</td>\

						<td>'+arrayConsulta[i].tipoSoporte+'</td>\

						<td>'+arrayConsulta[i].aplicativo+'</td>\

						<td>'+arrayConsulta[i].descripcion+'</td>\

						<td>'+arrayConsulta[i].nombre+' '+arrayConsulta[i].paterno+' '+arrayConsulta[i].materno+'</td>\

						<td style="text-align:center"><a href="#" style="width:100%" class="btn btn-default" '+htmlOnClick+'><b>'+arrayConsulta[i].numComentarios+'</b></a></td>\

						<td style="text-align:center">'+htmlFile+'</td>\

						<td style="text-align:center"><b>'+arrayConsulta[i].calificacion+'</b></td>\

					  </tr>';

			if(estiloActivo != '') estiloActivo = '';

			else estiloActivo = 'active';

		}

		if(html == '')

			html = 'Sin Tickets';

		$('#tbodyTickets').html(html);

		setTimeout(Monitor.consultarNuevosTickets, TIEMPO);

	},

	consultarNuevosTickets: function(){

		var parametros = {

			'ticketid'	: TICKET_MAXIMO

		};

		General.consultaArray2(parametros, 8, Monitor.accionConsultarNuevosTickets, Monitor.errorConsultarNuevosTickets);

	},

	errorConsultarNuevosTickets: function(){

		if(COUNT_ERROR < 5){

			COUNT_ERROR++;

			Monitor.consultarNuevosTickets();

		}

		else{
			swal("Error", "falló la conexión con el servidor, actualice la página", "error");
		}

	},

	accionConsultarNuevosTickets: function(datos){

		COUNT_ERROR = 0;

		if(datos.resultados.length > 0){

			if(parseInt(datos.resultados[0].countNuevos) > 0){

				swal("Agregaron un nuevo ticket");

				Monitor.consultarTickets();

			}

			else

				setTimeout(Monitor.consultarNuevosTickets, TIEMPO);

		}

		else

			swal("Error", "Falla en proceso de consulta, actulice la página", "error");

	},

	consultarComentarios: function(ticketid,estatusid){

		$('#modalCarga').modal('show');

		var parametros = {

			'ticketid' : ticketid

		};

		TICKET = ticketid;

		General.consultaArray(parametros, 1,Monitor.mostrarComentarios);

		$('#estatus').val(estatusid);

	},

	mostrarComentarios: function(datos){

		var arrayConsulta = datos.resultados;

		var html = '';

		for(var i=0; i<arrayConsulta.length; i++){

			var htmlBotonArchivo = '';

			if(arrayConsulta[i].nombreArchivo != '' && arrayConsulta[i].nombreArchivo != 'null')

				htmlBotonArchivo = '<br /><i class="fa fa-file"></i> <button onclick="window.open(\'archivos-usuarios/'+arrayConsulta[i].nombreArchivo+'\', \'_blank\');">'+arrayConsulta[i].nombreArchivo+'</button>';

			

			html += '<a href="#" class="list-group-item">\

						<span class="badge">'+arrayConsulta[i].nombre+' '+arrayConsulta[i].paterno+' '+arrayConsulta[i].materno+'</span>\

						<i class="fa fa-calendar"></i><b>'+arrayConsulta[i].fecha+'</b> '+arrayConsulta[i].comentario+ htmlBotonArchivo +'\

					 </a>';

		}

		if(html == '')

			html = 'Sin Comentarios';

		$('#divComentariosDetalle').html(html);

		$('#divTickets').hide();

		$('#divComentarios').show();

		$('#modalCarga').modal('hide');

	},

	cambiarEstatus: function(){

		if($('#comentario2').val() == ''){

            swal("Mensaje","Escriba un comentario","info");

			$('#comentario2').focus();

			return;

		}

		swal({
		  title: '¿Está seguro de cambiar el estatus?',
		  type: 'question',
		  showCancelButton: true,
		  confirmButtonColor: '#3085d6',
		  cancelButtonColor: '#d33',
		  confirmButtonText: 'Aceptar',
		  cancelButtonText: 'Cancelar'
		}).then((result) => {
		  if (result.value) {
		  	//$('#modalCarga').modal('show');

			var parametros = {

				'ticketid'	: TICKET,

				'estatusid': $('#estatus').val()

			};

			General.consultaArray(parametros, 7,Monitor.accionCambiarEstatus);
		  }
		});

		/*if(confirm('¿Está seguro de cambiar el estatus?')){

			//$('#modalCarga').modal('show');

			var parametros = {

				'ticketid'	: TICKET,

				'estatusid': $('#estatus').val()

			};

			General.consultaArray(parametros, 7,Monitor.accionCambiarEstatus);

		}*/

	},

	accionCambiarEstatus: function(datos){

		//$('#modalCarga').modal('hide');

		if(datos.resultados.length > 0){

			if(parseInt(datos.resultados[0].numeroAfectados) == 1){

				Inicio.guardarComentario(2);

				Monitor.consultarTickets();

				//alert('¡¡Actualización exitosa!!');

			}

			else

                swal("Error al guardar", "intente nuevamente, en caso de continuar con el problema favor de reportar con sistemas.", "error");

		}

	},

	ponerOpcionSelect: function(opcion){

		

	}

};
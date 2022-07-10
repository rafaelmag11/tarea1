
var Monitor = {
	TICKET_ABIERTO: 0,
	comenzar: function(){
		this.ajustarDivs();
		this.consultarTickets();
	},
	ajustarDivs: function(){
		var altoDiv = $(window).height()
		$('#divLista').height((altoDiv-170));
		$('#divDetalle').height((altoDiv-240));
	},
	consultarTickets: function(){
		var estatusid = $('#selectFiltro').val();
		
		General.consultaArray({'estatusid':estatusid}, 5,function(datos){
			var htmlLink = '';
			
			for(var i=0; i<datos.resultados.length; i++){
				var item = datos.resultados[i];

				var imagenEstatus = '';
				if(item.estatusid == 1)
					imagenEstatus = 'por-atender.png';
				else if(item.estatusid == 2)
					imagenEstatus = 'en-atencion.png';
				else if(item.estatusid == 3)
					imagenEstatus = 'finalizado.png';
				else if(item.estatusid == 4)
					imagenEstatus = 'cancelado.png';
				else
					imagenEstatus = 'suspendido.png';

				var descripcion = item.descripcion;
				if(descripcion.length > 45)
					descripcion = descripcion.slice(0,45);
				var htmlNumComentarios = '';
				if(item.numComentarios > 0)
					htmlNumComentarios = '\
						<span style="position:relative">\
							<b style="position:absolute;display:block;z-index:10;padding:5px 0 0 8px" id="panelNoComentarios">\
								'+item.numComentarios+'</b>\
							<img src="img/comentarios.png" width="35">\
						</span>';

				htmlComoInvitado = '';
				// if(item.invitado != '')
				// 	htmlComoInvitado = '<i style="color:blue">(Invitado)</i>';
				htmlLink += '\
					<a href="#" class="list-group-item" onclick="Monitor.consultarTicket('+item.soporteid+'); return false"\
	            	id="a'+item.soporteid+'">\
	            	<div class="col-lg-9" style="padding-left:0">\
	            		<span id="spanInvitado'+item.soporteid+'" style="display:none">'+item.invitado+'\
	            		</span>\
						<span>\
							<b>'+item.folio+'</b> - '+item.nombre+' '+item.paterno+'\
						</span><br>\
						<span><b>'+item.asunto+'</b>'+htmlComoInvitado+'</span><br>\
						<span style="font-size:12px">'+descripcion+'</span><br>\
					</div>\
					<div class="col-lg-3" style="padding:0">\
						<span>'+item.fecha+'</span><br>\
						'+htmlNumComentarios+'\
						<span>\
							<img src="img/'+imagenEstatus+'" width="30">\
						</span>\
					</div>\
					<div style="clear:both"></div>\
	            </a>';
			}
			$('#divLista').html(htmlLink);
		});
	},
	consultarTicket: function(soporteid){
		$('#aAgregarComentario').removeClass('disabled');
		$('#aAtencion').removeClass('disabled');
		$('#aFinalizar').removeClass('disabled');
		$('#aCancelarTicket').removeClass('disabled');

		General.consultaArray({'soporteid':soporteid}, 13,function(datos){
			if(datos.detalle.length > 0){

				$('.list-group-item').css('background-color','#ffffff');
				$('#a'+soporteid).css('background-color','#ECE9E1');
				var item = datos.detalle[0];
				var htmlCalificacion = '';
				var intInvitado = parseInt($('#spanInvitado'+soporteid).html(), 10);

				$('#label_cc').html(item.cc);

				if(item.estatusid == 1){//POR ATENDER
					
				}
				else if(item.estatusid == 2){//EN ATENCION
					$('#aAtencion').addClass('disabled');
				}
				else if(item.estatusid == 3){//RESUELTO
					$('#aAtencion').addClass('disabled');
					$('#aFinalizar').addClass('disabled');
					$('#aCancelarTicket').addClass('disabled');
				}
				else if(item.estatusid == 4){//CANCELADO
					$('#aAgregarComentario').addClass('disabled');
					$('#aAtencion').addClass('disabled');
					$('#aFinalizar').addClass('disabled');
					$('#aCancelarTicket').addClass('disabled');
				}

				$('#resultEstatus').html(item.estatus);
				$('#inputModalNoTicket').val(soporteid);
				$('#inputModalComentarioNoTicket').val(soporteid);
				$('#resultCalificacion').html(htmlCalificacion);
				$('#resultNoTicket').html(item.folio);
				
				var htmlEtiquetaInvitado = '';
				if(intInvitado == 1)
					htmlEtiquetaInvitado = ' (Invitado)';
				$('#resultAsunto').html(item.asunto + htmlEtiquetaInvitado);
				$('#resultRegistro').html(item.nombre+' '+item.paterno+' '+item.materno);
				$('#resultResponsable').html(item.responsable);

				var htmlNombresResponsables = '';
				for(var i=0; i<datos.responsables.length; i++){
					if(i > 0)
						htmlNombresResponsables += ', ';
					htmlNombresResponsables += datos.responsables[i].nombre+' '+datos.responsables[i].paterno;
				}
				$('#resultNombresResponsables').html(htmlNombresResponsables);

				var htmlInvitados = '';
				if(datos.invitados.length > 0){
					for (var i = 0; i <datos.invitados.length; i++) {
						if(i > 0)
							htmlInvitados += ', '
						htmlInvitados += datos.invitados[i].nombre+' '+datos.invitados[i].paterno;
					};
				}
				else
					htmlInvitados = '<i>Ninguno</i>';
				//$('#resultInvitados').html(htmlInvitados);

				if(item.nombreArchivo != '')
					$('#resultAbjunto').html('<a href="archivos-usuarios/'+item.nombreArchivo+'" target="_blank">'+item.nombreArchivo+'</a>');
				else
					$('#resultAbjunto').html(' <i>Ninguno</i>');
				$('#resultDescripcion').html(item.descripcion);

				var htmlComentarios = '';
				for(var i=0; i<datos.comentarios.length; i++){
					var item = datos.comentarios[i];
					var htmlBotonArchivo = '';
					if(item.nombreArchivo != '')
						htmlBotonArchivo = '<br /><i class="fa fa-file"></i> <button onclick="window.open(\'archivos-usuarios/'+item.nombreArchivo
							+'\', \'_blank\');">'+item.nombreArchivo+'</button>';
					htmlComentarios += '<a href="#" class="list-group-item">\
						<span class="badge">'+item.nombre+' '+item.paterno+' '+item.materno+'</span>\
						<i class="fa fa-calendar"></i><b>'+item.fecha+'</b> '+item.comentario+ htmlBotonArchivo+'\
					 </a>';
				}
				if(htmlComentarios == '')
					htmlComentarios = 'Sin Comentarios';
				$('#divComentariosDetalle').html(htmlComentarios);
			}
		});
	},
	mostrarModalFinalizar: function(){
		$('#noTicket_ModalFinalizar').html($('#resultNoTicket').html());
		$('#comentario_ModalFinalizar').html('');
		$('#modalFinalizar').modal('show');
	},
	guardarFinalizacion: function(){
		var parametros = {
			'soporteid' : parseInt($('#inputModalNoTicket').val(),10),
			'comentario': $('#comentario_ModalFinalizar').val()
		};
		General.consultaArray(parametros, 16,function(datos){
			if(datos.resultados[0].numeroAfectados == 1){
				swal({
				  type: 'success',
				  title: 'Se ha Finalizado el ticket correctamente',
				  showConfirmButton: false,
				  timer: 5000
				});
				setTimeout("location.reload(true);", 3000);
			}
		});
	},
	mostrarModalAtencion: function(){
		$('#noTicket_ModalAtencion').html($('#resultNoTicket').html());
		$('#comentario_ModalAtencion').html('');
		$('#modalAtencion').modal('show');
	},
	guardarAtencion: function(){
		var parametros = {
			'soporteid' : parseInt($('#inputModalNoTicket').val(),10),
			'comentario': $('#comentario_ModalAtencion').val()
		};
		General.consultaArray(parametros, 17,function(datos){
			if(datos.resultados[0].numeroAfectados == 1){
				swal({
				  type: 'success',
				  title: 'Se ha actualizado el ticket correctamente',
				  showConfirmButton: false,
				  timer: 5000
				});
				setTimeout("location.reload(true);", 3000);
			}
		});
	}
};
var Inicio = {
	cargaPagina : true,
	comenzar: function(){
		this.ajustarDivs();
		this.consultarTickets();
	},
	ajustarDivs: function(){
		//alert($(window).height());
		var altoDiv = $(window).height()
		$('#divLista').height((altoDiv-200));
		$('#divDetalle').height((altoDiv-240));
	},
	consultarPorCalificar: function(){
		if( parseInt($('#label_porCalificar').html(),10) == 0 ){
			swal({
				  type: 'info',
				  title: 'No hay ticket para calificar',
				  showConfirmButton: true
				});
			return;
		}
		$('#selectFiltro').val(5);
		Inicio.consultarTickets();
	},
	consultarTickets: function(){
		var estatusid = $('#selectFiltro').val();
		//alert(opcionFiltro);
		General.consultaArray({'estatusid':estatusid}, 15,function(datos){
			var htmlLink = '';
			var numPorCalificar = 0;
			for(var i=0; i<datos.resultados.length; i++){
				var item = datos.resultados[i];
				var imagenEstatus = '';
				if(item.estatusid == 1)
					imagenEstatus = 'Amarillo.svg';
				else if(item.estatusid == 2)
					imagenEstatus = 'Morado.svg';
				else if(item.estatusid == 3){
					imagenEstatus = 'Verde.svg';
					if(Inicio.cargaPagina){
						if(item.calificacion == '')
							numPorCalificar++;
						//alert(item.calificacion)
						
					}
				}
				else if(item.estatusid == 4)
					imagenEstatus = 'Rojo.svg';
				else
					imagenEstatus = 'Naranja.svg';

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
				if(item.invitado != '')
					htmlComoInvitado = '<i style="color:blue">(Invitado)</i>';
				htmlLink += '\
					<a href="#" class="list-group-item item-ticket" onclick="Inicio.consultarTicket('+item.soporteid+'); return false"\
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
							<img class="img-ticket" src="img/'+imagenEstatus+'" width="20">\
						</span>\
					</div>\
					<div style="clear:both"></div>\
	            </a>';
			}
			if(Inicio.cargaPagina)
				$('#label_porCalificar').html(numPorCalificar);
			Inicio.cargaPagina = false;
			$('#divLista').html(htmlLink);
		});
	},
	consultarTicket: function(soporteid){
		$('#aAgregarComentario').removeClass('disabled');
		$('#aCalificar').removeClass('disabled');
		$('#aCancelarTicket').removeClass('disabled');

		General.consultaArray({'soporteid':soporteid}, 13,function(datos){
			if(datos.detalle.length > 0){

				$('.list-group-item').css('background-color','#ffffff');
				$('#a'+soporteid).css('background-color','#ECE9E1');
				var item = datos.detalle[0];
				var htmlCalificacion = '';
				var intInvitado = parseInt($('#spanInvitado'+soporteid).html(), 10);

				$('#label_cc').html(item.cc);

				if(item.estatusid == 1 || item.estatusid == 2){
					$('#aCalificar').addClass('disabled');
					if(intInvitado == 1)
						$('#aCancelarTicket').addClass('disabled');
				}
				else if(item.estatusid == 3){
					$('#aCancelarTicket').addClass('disabled');
					if(item.calificacion != '' || intInvitado == 1){
						$('#aCalificar').addClass('disabled');
						htmlCalificacion = 'calificacion: <span style="color:green;font-size:18px"><b>'+item.calificacion+'</b></span>';
					}
				}
				else if(item.estatusid == 4){
					$('#aAgregarComentario').addClass('disabled');
					$('#aCalificar').addClass('disabled');
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
	recarga:function(){
		location.reload(true);
	},
	mostrarModelComentario: function(){
		$('#comentario').val('');
		$fileupload = $('#archivo');  
		$fileupload.replaceWith($fileupload.clone(true));
		$('#modalComentario').modal('show');
	},
	guardarComentarioArchivo: function(){
		//información del formulario
        var formData = new FormData($(".formulario")[0]);
        var message = "";
        var ticketid = parseInt($('#inputModalComentarioNoTicket').val(),10);
        $.ajax({
            url: 'controller/subirComentarioImagen.php?ticketid='+ ticketid,
            type: 'POST',
            data: formData,
            //necesario para subir archivos via ajax
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){
                //message = $("<span class='before'>Subiendo la imagen, por favor espere...</span>");
                //showMessage(message)
            },
            success: function(data){
				if(parseInt(data,10) == 1){
					Inicio.consultarTicket(ticketid);
					var $noComentarios = $('#panelNoComentarios');
					$noComentarios.html(parseInt($noComentarios.html(),10)+1);
					$('#modalComentario').modal('hide');
					document.getElementById("comentario").submit();
				}
				else
					swal("Error" , "intente nuevamente ok, en caso de continuar con el problema favor de reportar a sistemas" , "error");
            },
            //si ha ocurrido un error
            error: function(){
                swal("Atención","Ocurrio un error","error");
            }
        });
	},
	motrarModalCancelar: function(){
		$('#noTicket_ModalCancelar').html($('#resultNoTicket').html());
		$('#comentario_ModalCancelar').html('');
		$('#modalCancelar').modal('show');
	},
	guardarCancelacion: function(){
		var parametros = {
			'soporteid' : parseInt($('#inputModalNoTicket').val(),10),
			'comentario': $('#comentario_ModalCancelar').val()
		};
		General.consultaArray(parametros, 14,function(datos){
			if(datos.resultados[0].numeroAfectados == 1){
				swal({
				  type: 'success',
				  title: 'Se ha cancelado el ticket correctamente',
				  showConfirmButton: false,
				  timer: 5000
				});
				setTimeout("location.reload(true);", 3000);
			}
		});
	},
	mostrarModalCalificar: function(){
		$('#noTicket_modalCalificar').html($('#resultNoTicket').html());
		$('#modalCalificar').modal('show');
	},
	guardarCalificacion:function(){
		var noTicket = parseInt($('#inputModalNoTicket').val(),10);
		var calificacion = $('#calificacion_modalCalificar').val();
		var parametros = {
			'ticketid'	: noTicket,
			'calificacion': calificacion
		};
		General.consultaArray(parametros, 10,function(datos){
			if(parseInt(datos.resultados[0].numeroAfectados,10) == 1){
				// $('#modalCalificar').modal('hide');
				// Inicio.consultarTicket(noTicket);
				swal({
				  type: 'success',
				  title: 'Se guardó la calificación correctamente',
				  showConfirmButton: false,
				  timer: 5000
				});
				setTimeout("location.reload(true);", 3000);
			}
			else
				swal("Error","no se guardó, intente nuevamente","error");
		});
	},
	mostrarReabrirTicket: function(){
		$('#modalCalificar').modal('hide');
		$('#modalReabrirTicket').modal('show');
	},
	guardarReabrirTicket: function(){
		var textMotivo = $('#textMotivoApertura');
		if(textMotivo.val() == ''){
			textMotivo.focus();
			return;
		}

		var noTicket = parseInt($('#inputModalNoTicket').val(),10);
		var parametros = {
			'ticketid'	: noTicket,
			'estatusid': 2
		};
		General.consultaArray(parametros, 7,function(datos){
			if(datos.resultados.length > 0){
				if(parseInt(datos.resultados[0].numeroAfectados) == 1)
					Inicio.guardarSoloComentario(noTicket,textMotivo.val());
				else
					swal("Error","no se guardó el estatus, intente nuevamente, en caso de continuar con el problema favor de reportar con sistemas.","error");
			}
		});
	},
	guardarSoloComentario: function(noTicket, comentario){
		//alert(noTicket+' - '+comentario);
		var parametros = {
			'ticketid' : noTicket,
			'comentario' : comentario
		}
		General.consultaArray(parametros, 4,function(datos){
			if(datos.resultados.length > 0){
				if(parseInt(datos.resultados[0].numeroAfectados) == 1){
					swal({
					  type: 'success',
					  title: 'Actualización exitosa.',
					  showConfirmButton: false,
					  timer: 5000
					});
					setTimeout("location.reload(true);", 3000);
				}
				else
					swal("Error","no se guardó el comentario, intente nuevamente, en caso de continuar con el problema favor de reportar con sistemas.","error");
			}
		});
	}
};

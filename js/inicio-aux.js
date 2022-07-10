alert('aca');

var TICKET;



var Inicio = {

	consultarComentarios: function(ticketid){

		$('#modalCarga').modal('show');

		var parametros = {

			'ticketid' : ticketid

		};

		TICKET = ticketid;

		General.consultaArray(parametros, 1,Inicio.mostrarComentarios);

	},

	mostrarComentarios: function(datos){

		$('#divTickets').hide();

		var arrayConsulta = datos.resultados;

		var html = '';

		for(var i=0; i<arrayConsulta.length; i++){

			var htmlBotonArchivo = '';

			if(arrayConsulta[i].nombreArchivo != '')

				htmlBotonArchivo = '<br /><i class="fa fa-file"></i> <button onclick="window.open(\'archivos-usuarios/'+

					arrayConsulta[i].nombreArchivo+'\', \'_blank\');">'+arrayConsulta[i].nombreArchivo+'</button>';



			html += '<a href="#" class="list-group-item">\

						<span class="badge">'+arrayConsulta[i].nombre+' '+arrayConsulta[i].paterno+' '+arrayConsulta[i].materno+'</span>\

						<i class="fa fa-calendar"></i><b>'+arrayConsulta[i].fecha+'</b> '+arrayConsulta[i].comentario+ htmlBotonArchivo+'\

					 </a>';

		}



		if(html == '')

			html = 'Sin Comentarios';



		$('#divComentariosDetalle').html(html);

		$('#divComentarios').show();

		$('#modalCarga').modal('hide');

	},



	mostrarTickets: function(){

		$('#divComentarios').hide();

		$('#divTickets').show();

	},



	guardarComentario: function(tab){

		var comentario;

		if(tab == 1)

			comentario = $('#comentario');

		else if(tab == 2)

			comentario = $('#comentario2');

		if(comentario.val() == ''){

			comentario.focus();

			return;

		}



		$('#modalCarga').modal('show');



		var parametros = {

			'ticketid'	: TICKET,

			'comentario': comentario.val()

		};



		General.consultaArray(parametros, 4,Inicio.accionGuardarComentario);



	},



	accionGuardarComentario: function(datos){



		if(datos.resultados.length > 0){



			if(parseInt(datos.resultados[0].numeroAfectados) == 1){



				Inicio.consultarComentarios(TICKET);



				$('#comentario').val('');



				$('#comentario2').val('');



			}



			else
				swal("Error al guardar", "intente nuevamente, en caso de continuar con el problema favor de reportar con sistemas.", "error");



		}



		$('#modalCarga').modal('hide');



	},



	modalCalificar: function(noTicket){



		$('#spanTicketCalificar').html(noTicket);



		$('#modalCalificar').modal('show');



	},



	guardarCalificacion: function(){



		var noTicket = parseInt($('#spanTicketCalificar').html(),10);



		var calificacion = $('#selectCalificacion').val();



		//alert(noTicket+' - '+calificacion);



		var parametros = {



			'ticketid'	: noTicket,



			'calificacion': calificacion



		};



		General.consultaArray(parametros, 10,function(datos){



			//alert(datos.resultados[0].numeroAfectados);



			if(parseInt(datos.resultados[0].numeroAfectados,10) == 1){



				location.reload();



			}



			else
				swal("Error", "no se guardó, intente nuevamente", "error");



		});



	},



	guardarComentarioArchivo: function(){



		//información del formulario



        var formData = new FormData($(".formulario")[0]);



        var message = ""; 



        $.ajax({



            url: 'controller/subirComentarioImagen.php?ticketid='+TICKET,  



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



					Inicio.consultarComentarios(TICKET);



					$('#comentario').val('');



					$fileupload = $('#archivo');  



					$fileupload.replaceWith($fileupload.clone(true));  



				}



				else
					swal("Error", "intente nuevamente, en caso de continuar con el problema favor de reportar a sistemas.", "error");



            },



            //si ha ocurrido un error



            error: function(){

                swal("Atención", "Ocurrio un error", "error");

            }



        });



	}



};
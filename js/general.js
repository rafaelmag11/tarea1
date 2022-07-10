var General = {

    consultaArray: function(parametros, opcionConsulta, funcion){

		$.ajax({

			data:  parametros,

	        url:   'controller/consultas.php?opcion=' + opcionConsulta,

			dataType: 'json',

			cache: false,

	        type:  'post',

			beforeSend: function () {

	            

	        },

	        success:  function(datos){

				funcion(datos);

			},

			error: function(xhr, status, error){

				$('#modalCarga').modal('hide');
				swal("Error", "Falló la conexión con el servidor, opcion:" + opcionConsulta, "error");

			}

	    });

    },

	consultaArray2: function(parametros, opcionConsulta, funcion, funcionError){

		$.ajax({

			data:  parametros,

	        url:   'controller/consultas.php?opcion=' + opcionConsulta,

			dataType: 'json',

			cache: false,

	        type:  'post',

			beforeSend: function () {

	            

	        },

	        success:  function(datos){

				funcion(datos);

			},

			error: function(){

				funcionError();

			}

	    });

    }

};
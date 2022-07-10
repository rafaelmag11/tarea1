var Global = {

	consultarDatosUsuario: function(){

		$('#modalDatosUsuario').modal('show'); 

	},

	guardarDatosUsuario: function(){

		var inputPass1 = $('#inputPass1');

		var inputPass2 = $('#inputPass2');

		if(inputPass1.val() != ''){

			if(inputPass1.val() == inputPass2.val()){
				swal({
				  title: '¿Está seguro de cambiar la contraseña?',
				  type: 'question',
				  showCancelButton: true,
				  confirmButtonColor: '#3085d6',
				  cancelButtonColor: '#d33',
				  confirmButtonText: 'Aceptar',
				  cancelButtonText: 'Cancelar'
				}).then((result) => {
				  if (result.value) {
				    var parametros = {
                			'pass' : inputPass1.val()
                		};

                		General.consultaArray2(parametros, 9,
                			function(datos){
                				if(parseInt(datos.resultados[0].numeroAfectados, 10) == 1)
                					window.location = 'controller/salir.php';
                				else
                					swal("Error", "Error al actualizar la contraseña", "error");
                			},

                			function(){

                			}
                			);
				  }
				});

			}else

				swal("Error", "Las contraseñas no son iguales.", "warning");

		}

	}

};
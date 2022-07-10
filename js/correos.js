var Inicio = {
	cargaPagina : true,
	mostrarModalModificar:function(usuarioid){
		var idUser = document.getElementById("idUser");
        var nombre = document.getElementById("noId_modalModificar");

		var parametros = {
			'usuarioid'	: usuarioid
		};
		General.consultaArray(parametros, 29,function(datos){
			if(datos.resultados.length > 0){
				$('#modalModificar').modal('show');
				var item = datos.resultados[0].numeroAfectados;
				nombre.value = item;
				idUser.value = usuarioid;			
			}
			else{
				swal("Error","no es posible hacer la acción","error");
			}
		});
	},
	guardarModificacion:function(){
		var usuarioid = $('#idUser').val();
		var email = $('#noId_modalModificar').val();

		if(email == ''){
			swal("Ingresa el correo", "", "info");
			return;
		}
        
        if(!Inicio.comprobarCampos()) return false;

		var parametros = {
			'usuarioid': usuarioid,
			'email': email
		};
		General.consultaArray(parametros, 30,function(datos){
			if(parseInt(datos.resultados[0].numeroAfectados,10) == 1 || parseInt(datos.resultados[0].numeroAfectados,10) == 0){
				swal({
				  type: 'success',
				  title: 'Se modificó correctamente',
				  showConfirmButton: false,
				  timer: 5000
				});
				setTimeout("location.reload(true);", 3000);
			}
			else
				swal("Error","no se guardó, intente nuevamente","error");
		});
	},
	comprobarCampos: function(){

		var emails = $('#noId_modalModificar');

		var textoEmails = emails.val().replace(' ','');

		if(textoEmails == '')return true;



		var arrayEmails = textoEmails.split(';');

		for(var i=0; i<arrayEmails.length; i++){

			if(arrayEmails[i].length > 0){

				if(arrayEmails[i].indexOf('@') < 0 || arrayEmails[i].indexOf('.') < 0){

					swal("Correo incorrecto" , "Ejemplo( prueba@teksi.com )", "warning");

					emails.focus();

					return false;

				}

			}

		}

		emails.val(textoEmails);

		return true;

	}
};
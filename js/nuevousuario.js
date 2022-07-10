var Inicio = {
	cargaPagina : true,
	guardarUsuario:function(){
        var admin = document.getElementById("administrador").value;

		var nombre = $('#nombre').val();
		var apaterno = $('#apaterno').val();
		var amaterno = $('#amaterno').val();
		var departamentoid = $('#departamentoid').val();
		var puesto = $('#puesto').val();
		var email = $('#emails').val();
		var estatusid = $('#estatusid').val();
		var clave = $('#clave').val();
		var pass = $('#pass').val();
		var administrador = $('#administrador').val();
		var tipoAplicativo = $('#tipoAplicativo').val();

		if(nombre == '' || puesto == '' || email == '' || clave == '' || pass == ''){
			swal("Faltan datos por capturar","","info");
			return;
		}

		if(!Inicio.comprobarCampos()) return false;

		var parametros = {
			'nombre'	: nombre,
			'apaterno': apaterno,
			'amaterno'	: amaterno,
			'departamentoid': departamentoid,
			'puesto'	: puesto,
			'email': email,
			'estatusid'	: estatusid,
			'clave': clave,
			'pass'	: pass,
			'administrador': administrador
		};

		var parametros2 = {
			'nombre'	: nombre,
			'apaterno': apaterno,
			'amaterno'	: amaterno,
			'departamentoid': departamentoid,
			'puesto'	: puesto,
			'email': email,
			'estatusid'	: estatusid,
			'clave': clave,
			'pass'	: pass,
			'administrador': administrador,
			'tipoAplicativo': tipoAplicativo
		};

        if(admin == 1){
        	General.consultaArray(parametros2, 28,function(datos){
			if(parseInt(datos.resultados[0].numeroAfectados,10) == 1){
				swal({
				  type: 'success',
				  title: 'Se guardó el usuario correctamente',
				  showConfirmButton: false,
				  timer: 5000
				});
				setTimeout(function(){window.location="cat-usuarios"}, 3000);
			}
			else{
				swal("Error","no se guardó, verifique que el usuario no exista e intente nuevamente","error");
			}
		});
        }else{
        	General.consultaArray(parametros, 18,function(datos){
			if(parseInt(datos.resultados[0].numeroAfectados,10) == 1){
				swal({
				  type: 'success',
				  title: 'Se guardó el usuario correctamente',
				  showConfirmButton: false,
				  timer: 5000
				});
				setTimeout(function(){window.location="cat-usuarios"}, 3000);
			}
			else{
				swal("Error","no se guardó, verifique que el usuario no exista e intente nuevamente","error");
			}
		});
        }
	},
	validar:function(){
		var x = document.getElementById("administrador").value;
		if(x == 1){
			document.getElementById("tipoAplicativo1").style.display = "block";
		}else{
			document.getElementById("tipoAplicativo1").style.display = "none";
		}
	},
	mostrarModalModificar:function(usuarioid){
		var idUser = document.getElementById("idUser");
        var nombre = document.getElementById("nombre");
        var apaterno = document.getElementById("apaterno");
        var amaterno = document.getElementById("amaterno");
        var departamentoid = document.getElementById("departamentoid");
        var puesto = document.getElementById("puesto");
        var emails = document.getElementById("emails");
        var estatusid = document.getElementById("estatusid");
        var clave = document.getElementById("clave");
        var pass = document.getElementById("pass");
        var administrador = document.getElementById("administrador");
        var aplicativoid = document.getElementById("tipoAplicativo");

		var parametros = {
			'usuarioid'	: usuarioid
		};
		General.consultaArray(parametros, 27,function(datos){
			if(datos.resultados.length > 0){
				var item_nom = datos.resultados[0].numeroAfectados[0].nombre;
				var item_ap = datos.resultados[0].numeroAfectados[0].apaterno;
				var item_am = datos.resultados[0].numeroAfectados[0].amaterno;
				var item_dep = datos.resultados[0].numeroAfectados[0].departamentoid;
				var item_pue = datos.resultados[0].numeroAfectados[0].puesto;
				var item_email = datos.resultados[0].numeroAfectados[0].emails;
				var item_est = datos.resultados[0].numeroAfectados[0].estatusid;
				var item_clave = datos.resultados[0].numeroAfectados[0].clave;
				var item_pass = datos.resultados[0].numeroAfectados[0].pass;
				var item_adm = datos.resultados[0].numeroAfectados[0].administrador;

                if(item_adm == 1){
                	General.consultaArray(parametros, 33, function(datos){
                		if(datos.resultados.length > 0){
                			var proyectoid = datos.resultados[0].numeroAfectados;
                			$('#modalModificar').modal('show');
                			document.getElementById("tipoAplicativo1").style.display = "block";
                			nombre.value = item_nom;
							apaterno.value = item_ap;
							amaterno.value = item_am;
							departamentoid.value = item_dep;
							puesto.value = item_pue;
							emails.value = item_email;
							estatusid.value = item_est;
							clave.value = item_clave;
							pass.value = item_pass;
							administrador.value = item_adm;
							idUser.value = usuarioid;
							aplicativoid.value = proyectoid;
                		}
                	});
                }else{
                	$('#modalModificar').modal('show');
					nombre.value = item_nom;
					apaterno.value = item_ap;
					amaterno.value = item_am;
					departamentoid.value = item_dep;
					puesto.value = item_pue;
					emails.value = item_email;
					estatusid.value = item_est;
					clave.value = item_clave;
					pass.value = item_pass;
					administrador.value = item_adm;
					idUser.value = usuarioid;
                }			
			}
			else{
				swal("Error","no es posible hacer la acción","error");
			}
		});
	},
	guardarModificacion:function(){
		var usuarioid = $('#idUser').val();

        var admin = document.getElementById("administrador").value;

		var nombre = $('#nombre').val();
		var apaterno = $('#apaterno').val();
		var amaterno = $('#amaterno').val();
		var departamentoid = $('#departamentoid').val();
		var puesto = $('#puesto').val();
		var email = $('#emails').val();
		var estatusid = $('#estatusid').val();
		var clave = $('#clave').val();
		var tipoAplicativo = $('#tipoAplicativo').val();

		if(nombre == '' || puesto == '' || email == '' || clave == ''){
			swal("Faltan datos por capturar","","info");
			return;
		}

		if(!Inicio.comprobarCampos()) return false;

		var parametros = {
			'usuarioid'	: usuarioid,
			'nombre'	: nombre,
			'apaterno': apaterno,
			'amaterno'	: amaterno,
			'departamentoid': departamentoid,
			'puesto'	: puesto,
			'email': email,
			'estatusid'	: estatusid,
			'clave': clave			
		};

        var parametros2 = {
        	'usuarioid'	: usuarioid,
			'nombre'	: nombre,
			'apaterno': apaterno,
			'amaterno'	: amaterno,
			'departamentoid': departamentoid,
			'puesto'	: puesto,
			'email': email,
			'estatusid'	: estatusid,
			'clave': clave,
			'aplicativoid': tipoAplicativo
		};

		if(admin == 1){
			General.consultaArray(parametros2, 34,function(datos){
			if(parseInt(datos.resultados[0].numeroAfectados,10) == 1 || parseInt(datos.resultados[0].numeroAfectados,10) == 0){
				swal({
				  type: 'success',
				  title: 'Se modificó correctamente',
				  showConfirmButton: false,
				  timer: 4000
				});
				setTimeout("location.reload(true);", 3000);
			}
			else
				swal("Error","no se guardó, intente nuevamente","error");
		});
		}else{
			General.consultaArray(parametros, 32,function(datos){
			if(parseInt(datos.resultados[0].numeroAfectados,10) == 1){
				swal({
				  type: 'success',
				  title: 'Se modificó correctamente',
				  showConfirmButton: false,
				  timer: 4000
				});
				setTimeout("location.reload(true);", 3000);
			}
			else
				swal("Error","no se guardó, intente nuevamente","error");
		});
		}
	},
	comprobarCampos: function(){

		var emails = $('#emails');

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
var Inicio = {
	cargaPagina : true,
	guardarArea:function(){

		var descripcion = $('#descripcion').val();
		if(descripcion == ''){
			swal("Ingresa el área","","info");
			return;
		}
		
		var parametros = {
			'descripcion'	: descripcion
		};
		General.consultaArray(parametros, 19,function(datos){
			if(parseInt(datos.resultados[0].numeroAfectados,10) == 1){
				swal({
				  type: 'success',
				  title: 'Se guardó el área correctamente',
				  showConfirmButton: false,
				  timer: 5000
				});
				setTimeout(function(){window.location="cat-areas"}, 3000);
			}
			else{
				swal("Error","no se guardó, intente nuevamente","error");
			}
		});
	},
	mostrarModalModificar:function(departamentoid){
		var idDep = document.getElementById("idDep");
        var nombre = document.getElementById("noId_modalModificar");

		var parametros = {
			'departamentoid'	: departamentoid
		};
		General.consultaArray(parametros, 21,function(datos){
			if(datos.resultados.length > 0){
				$('#modalModificar').modal('show');
				var item = datos.resultados[0].numeroAfectados;
				nombre.value = item;
				idDep.value = departamentoid;			
			}
			else{
				swal("Error","no es posible hacer la acción","error");
			}
		});
	},
	guardarModificacion:function(){
		var departamentoid = $('#idDep').val();
		var descripcion = $('#noId_modalModificar').val();

        if(descripcion == ''){
			swal("Ingresa el área","","info");
			return;
		}

		var parametros = {
			'departamentoid': departamentoid,
			'descripcion': descripcion
		};
		General.consultaArray(parametros, 22,function(datos){
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
	mostrarModalEliminar:function(departamentoid){
		var idDep = document.getElementById("idDep");
        var nombre = document.getElementById("noId_modalEliminar");

		var parametros = {
			'departamentoid'	: departamentoid
		};
		General.consultaArray(parametros, 21,function(datos){
			if(datos.resultados.length > 0){
				$('#modalEliminar').modal('show');
				var item = datos.resultados[0].numeroAfectados;
				nombre.value = item;
				idDep.value = departamentoid;			
			}
			else{
				swal("Error","no es posible hacer la acción","error");
			}
		});
	},
	guardarEliminar:function(){
		var departamentoid = $('#idDep').val();
		var parametros = {
			'departamentoid': departamentoid
		};
		General.consultaArray(parametros, 25,function(datos){
			if(parseInt(datos.resultados[0].numeroAfectados,10) == 1){
				swal({
				  type: 'success',
				  title: 'Se eliminó correctamente',
				  showConfirmButton: false,
				  timer: 4000
				});
				setTimeout("location.reload(true);", 3000);
			}
			else
				swal("Error","no se guardó, intente nuevamente","error");
		});
	}
};
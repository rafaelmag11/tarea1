var Inicio = {
	cargaPagina : true,
	guardarAplicacion:function(){

		var tiposoporteid = $('#tiposoporteid').val();
		var descripcion = $('#descripcion').val();

		if(descripcion == ''){
			swal("Ingresa el nombre del proyecto","","info");
			return;
		}
		
		var parametros = {
			'tiposoporteid'	: tiposoporteid,
			'descripcion'	: descripcion
		};
		General.consultaArray(parametros, 20,function(datos){
			if(parseInt(datos.resultados[0].numeroAfectados,10) == 1){
				swal({
				  type: 'success',
				  title: 'Se guardó la aplicación correctamente',
				  showConfirmButton: false,
				  timer: 4000
				});
				setTimeout(function(){window.location="cat-aplicaciones"}, 3000);
			}
			else{
				swal("Error","no se guardó, intente nuevamente","error");
			}
		});
	},
	mostrarModalModificar:function(aplicativosid){
		var idApp = document.getElementById("idApp");
        var nombre = document.getElementById("nombre");
        var tiposoporteid = document.getElementById("tiposoporteid");

		var parametros = {
			'aplicativosid'	: aplicativosid
		};
		General.consultaArray(parametros, 23,function(datos){
			if(datos.resultados.length > 0){
				var item_desc = datos.resultados[0].numeroAfectados[0].descripcion;
				var item_tipo_sop = datos.resultados[0].numeroAfectados[0].tiposoporteid;
				$('#modalModificar').modal('show');
				nombre.value = item_desc;
				tiposoporteid.value = item_tipo_sop;
				idApp.value = aplicativosid;			
			}
			else{
				swal("Error","no es posible hacer la acción","error");
			}
		});
	},
	guardarModificacion:function(){
		var aplicativosid = $('#idApp').val();
		var descripcion = $('#nombre').val();
		var tiposoporteid = $('#tiposoporteid').val();

        if(descripcion == ''){
        	swal("Ingresa el nombre del proyecto", "", "info");
        	return;
        }

		var parametros = {
			'aplicativosid': aplicativosid,
			'descripcion': descripcion,
			'tiposoporteid': tiposoporteid
		};
		General.consultaArray(parametros, 24,function(datos){
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
	},
	mostrarModalEliminar:function(aplicativosid){
		var idApp = document.getElementById("idApp2");
        var nombre = document.getElementById("nombre2");
        var tiposoporteid = document.getElementById("tiposoporteid2");

		var parametros = {
			'aplicativosid'	: aplicativosid
		};
		General.consultaArray(parametros, 23,function(datos){
			if(datos.resultados.length > 0){
				var item_desc = datos.resultados[0].numeroAfectados[0].descripcion;
				var item_tipo_sop = datos.resultados[0].numeroAfectados[0].tiposoporteid;
				$('#modalEliminar').modal('show');
				nombre.value = item_desc;
				tiposoporteid.value = item_tipo_sop;
				idApp.value = aplicativosid;			
			}
			else{
				swal("Error","no es posible hacer la acción","error");
			}
		});
	},
	guardarEliminar:function(){
		var aplicativosid = $('#idApp2').val();
		var parametros = {
			'aplicativosid': aplicativosid
		};
		General.consultaArray(parametros, 26,function(datos){
			if(parseInt(datos.resultados[0].numeroAfectados,10) == 1){
				swal({
				  type: 'success',
				  title: 'Se eliminó correctamente',
				  showConfirmButton: false,
				  timer: 3000
				});
				setTimeout("location.reload(true);", 3000);
			}
			else
				swal("Error","no se guardó, intente nuevamente","error");
		});
	}
};
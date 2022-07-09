var Inicio = {
	cargaPagina : true,
	guardarArea:function(){
		var descripcion = $('#descripcion').val();
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
				setTimeout("location.reload(true);", 3000);
			}
			else{
				swal("Error","no se guardó, intente nuevamente","error");
			}
		});
	}
};
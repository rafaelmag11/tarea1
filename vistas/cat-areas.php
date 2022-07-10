<?php

if(!defined('tmAu347djsa')) exit;

require 'modelos/seguridad.php';

$Seguridad = new Seguridad;

$resultados = $Seguridad->consultarDepartamentos();

?>

<script src="js/nuevarea.js"></script>

<div class="row">

<h3>Catálogo de Áreas</h3>

	<div class="col-lg-12">
		<div style="text-align: right">

			<button type="button" class="btn btn-success" onclick="window.location.href='?page=nueva-area'">Nueva Área</button>

		</div>
	</div>
	<div class="col-lg-12 scroll-tablas">
		<table width="100%" id="tablaAreas">
			<tr>
				<th>Nombre</th>
				<th style="text-align: center;">Acciones</th>
			</tr>
			<?php

				foreach($resultados as $registro){
					echo '<tr><td>'.$registro['descripcion'].'</td><td style="text-align: center;"><button type="button" class="btn btn-info btn-xs" onclick="Inicio.mostrarModalModificar('.$registro['departamentoid'].')">Detalles</button><!--&nbsp;<button type="button" class="btn btn-danger btn-xs" onclick="Inicio.mostrarModalEliminar('.$registro['departamentoid'].')">Eliminar</button>--></td></tr>';
				}?>
		</table>
	</div>

</div>

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true"
	id="modalModificar">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span></button>
				<h4 class="modal-title">Modificar Área.</h4>
			</div>
			<div class="modal-body">
				<input type="text" id="inputModalNoId" style="display:none">
				<input type="hidden" name="idDep" id="idDep">

				<h5>Nombre de área:</h5><br>
				<input type="text" required="true" class="form-control"  id="noId_modalModificar" value="">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="submit" class="btn btn-primary" onclick="Inicio.guardarModificacion();return false">Aceptar</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true"
	id="modalEliminar">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span></button>
				<h4 class="modal-title">Eliminar Área.</h4>
			</div>
			<div class="modal-body">
				<input type="text" id="inputModalNoId" style="display:none">
				<input type="hidden" name="idDep" id="idDep">

				<h5>Nombre de área:</h5><br>
				<input type="text" class="form-control"  id="noId_modalEliminar" disabled value="">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="submit" class="btn btn-primary" onclick="Inicio.guardarEliminar();return false">Aceptar</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
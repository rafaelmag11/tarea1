<?php

if(!defined('tmAu347djsa')) exit;

require 'modelos/seguridad.php';

$Seguridad = new Seguridad;

$resultados = $Seguridad->consultarAplicativos();

$resultados2 = $Seguridad->consultarTipoSoporte();

?>

<script src="js/nuevaplicacion.js"></script>

<div class="row">

<h3>Catálogo de Proyectos</h3>

<div class="col-lg-12">
	<div style="text-align: right">

		<button type="button" class="btn btn-primary btn-general" onclick="window.location.href='?page=nueva-aplicacion'">Nuevo Proyecto</button>

	</div>
</div>
<div class="col-lg-12 scroll-tablas">
	<table width="100%" id="tablaAplicacion">
		<tr>
			<th>Proyecto</th>
			<th>Tipo Soporte</th>
			<th style="text-align: center;">Acciones</th>
		</tr>
		<?php

			foreach($resultados as $registro){
				echo '<tr><td>'.$registro['aplicativo'].'</td><td>'.$registro['tiposoporte'].'</td><td style="text-align: center;"><button type="button" class="btn btn-primary btn-general btn-xs" onclick="Inicio.mostrarModalModificar('.$registro['aplicativosid'].')">Detalles</button><!--&nbsp;<button type="button" class="btn btn-danger btn-xs" onclick="Inicio.mostrarModalEliminar('.$registro['aplicativosid'].')">Eliminar</button>--></td></tr>';
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
				<h4 class="modal-title">Modificar Proyecto.</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" name="idApp" id="idApp">

				<h5>Nombre del proyecto:</h5><br>
				<input type="text" required="true" class="form-control"  id="nombre" value="">

				<div class="form-group">

					<h5>Tipo soporte:</h5><br>

					<select class="form-control" id="tiposoporteid" name="tiposoporteid">
						<?php

						foreach($resultados2 as $registro){

							echo '<option value="'.$registro['tiposoporteid'].'">'.$registro['descripcion'].'</option>';

						}?>
					</select>

				</div>
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
				<h4 class="modal-title">Eliminar Proyecto.</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" name="idApp2" id="idApp2">

				<h5>Nombre del proyecto:</h5><br>
				<input type="text" required="true" class="form-control" disabled  id="nombre2" value="">

				<div class="form-group">

					<h5>Tipo soporte:</h5><br>

					<select class="form-control" id="tiposoporteid2" name="tiposoporteid2" disabled>
						<?php

						foreach($resultados2 as $registro){

							echo '<option value="'.$registro['tiposoporteid'].'">'.$registro['descripcion'].'</option>';

						}?>
					</select>

				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="submit" class="btn btn-primary" onclick="Inicio.guardarEliminar();return false">Aceptar</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
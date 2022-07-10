<?php

if(!defined('tmAu347djsa')) exit;

require 'modelos/seguridad.php';

$Seguridad = new Seguridad;

$resultados = $Seguridad->consultarUsuariosAplicativo2();

?>

<script src="js/correos.js"></script>

<div class="row">

<h3>Catálogo de Correos</h3>

<div class="col-lg-12">
	<table width="100%" id="tablaCorreos">
		<tr>
			<th>Proyecto</th>
			<th>Email</th>
			<th style="text-align: center;">Acciones</th>
		</tr>
		<?php

			foreach($resultados as $registro){
				echo '<tr><td>'.$registro['proyecto'].'</td><td>'.$registro['email'].'</td><td style="text-align: center;"><button type="button" class="btn btn-info btn-xs" onclick="Inicio.mostrarModalModificar('.$registro['usuarioid'].')">Detalles</button></td></tr>';
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
				<h4 class="modal-title">Modificar Correo.</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" name="idUser" id="idUser">

				<h5>Correo:</h5><br>
				<input type="text" required="true" class="form-control"  id="noId_modalModificar" value="">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="submit" class="btn btn-primary" onclick="Inicio.guardarModificacion();return false">Aceptar</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
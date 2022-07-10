<?php

if(!defined('tmAu347djsa')) exit;

require 'modelos/seguridad.php';

$Seguridad = new Seguridad;

$resultados = $Seguridad->consultarTipoSoporte();

?>

<script src="js/nuevaplicacion.js"></script>

<div class="row">

<h3>Registrar Proyecto</h3>

	<div class="col-lg-6">

		<div class="form-group">

			<label>Nombre del proyecto</label>

			<div class="form-group">
			<input type="text" required class="form-control" name="descripcion" id="descripcion">
		    </div>

		</div>

	</div>

	<div class="col-lg-6">

		<div class="form-group">

			<label>Tipo soporte</label>

			<select class="form-control" id="tiposoporteid" name="tiposoporteid">
				<?php

				foreach($resultados as $registro){

					echo '<option value="'.$registro['tiposoporteid'].'">'.$registro['descripcion'].'</option>';

				}?>
			</select>

		</div>

	</div>

	<div class="col-lg-12">

		<div style="text-align: right">
			<button type="button" class="btn btn-danger" onclick="window.location.href='cat-aplicaciones'"> Cancelar</button>
			<button type="button" class="btn btn-success" onclick="Inicio.guardarAplicacion();return false">Agregar</button>
		</div>

	</div>

</div>
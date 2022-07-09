<?php

if(!defined('tmAu347djsa')) exit;

require 'modelos/seguridad.php';

?>

<script src="js/nuevarea.js"></script>

<div class="row">

<h3>Registrar nueva área</h3>
<div class="col-lg-12">
	<div class="col-lg-6">

		<div class="form-group">

			<label>Nombre área</label>

			<div class="form-group">
			<input type="text" required class="form-control" name="descripcion" id="descripcion">
		    </div>

		</div>

	</div>
	<div class="col-lg-6">
	</div>
</div>

<div class="col-lg-12">

<div class="col-lg-12">
	<div style="text-align: right">
		<button type="button" class="btn btn-danger" onclick="window.location.href='cat-areas'"> Cancelar</button>
		<button type="button" class="btn btn-success" onclick="Inicio.guardarArea();return false">Agregar</button>
	</div>

</div>
</div>

</div>
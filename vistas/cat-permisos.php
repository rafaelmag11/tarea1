<?php

if(!defined('tmAu347djsa')) exit;

require 'modelos/seguridad.php';

$Seguridad = new Seguridad;

?>

<div class="row">

<h3>Catálogo de Permisos</h3>

<form method="POST" action="controller/registrarTicket.php" enctype="multipart/form-data" id="nuevoticket" name="nuevoticket">

	<div class="col-lg-6">

		<div class="form-group">

			<label>Text...</label>
			<input type="text" required class="form-control" name="textNombre" id="nombre">

		</div>

	</div>

	<div class="col-lg-6">

		<div class="form-group">

			<label>Text...</label>
			<input type="text" required class="form-control" name="textNombre" id="nombre">

		</div>

	</div>

	<div class="col-lg-12">

		<div style="text-align: right">

			<button type="button" class="btn btn-primary" onclick=""><span><img src="img/icon-aceptar.png"/></span> Aceptar</button>

		</div>

	</div>

</form>

</div>
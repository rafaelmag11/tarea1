<?php

if(!defined('tmAu347djsa')) exit;

require 'modelos/seguridad.php';

$Seguridad = new Seguridad;

?>

<div class="row">

<h3>Catálogo de Empresas</h3>

<form method="POST" action="controller/registrarTicket.php" enctype="multipart/form-data" id="nuevoticket" name="nuevoticket">
	<div class="col-lg-12">
		<div style="text-align: right">

			<button type="button" class="btn btn-success" onclick=""><span><img src="img/add-area.png"/></span> Agregar Empresa</button>

		</div>
	</div>
	<div class="col-lg-12">
		<table width="100%" id="tablaEmpresas">
			<tr>
				<th>Nombre</th>
				<th style="text-align: center;">Acciones</th>
			</tr>
			<?php 
			echo '<tr><td>Empresa 1</td><td style="text-align: center;"><button type="button" class="btn btn-info btn-xs" onclick="">Detalles</button></td></tr>';
			?>
		</table>
	</div>
</form>

</div>
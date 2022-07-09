<?php

if(!defined('tmAu347djsa')) exit;

require 'modelos/seguridad.php';

$Seguridad = new Seguridad;

$resultados = $Seguridad->consultarDepartamentos();

$resultados2 = $Seguridad->consultarApps();

?>

<script src="js/nuevousuario.js"></script>

<div class="row">

<h3>Registrar nuevo usuario</h3>

<div class="col-lg-4">

	<div class="form-group">

		<label>Nombre</label>

		<div class="form-group">
		<input type="text" required class="form-control" name="nombre" id="nombre">
	    </div>

	</div>

	<div class="form-group">

		<label>Departamento</label>

		<select class="form-control" id="departamentoid" name="departamentoid">
			<?php

			foreach($resultados as $registro){

				echo '<option value="'.$registro['departamentoid'].'">'.$registro['descripcion'].'</option>';

			}?>
		</select>
	</div>

	<div class="form-group">

		<label>Estatus</label>

		<select class="form-control" id="estatusid" name="estatusid">

			<option value="1">Activo</option>

			<option value="2">Inactivo</option>

		</select>

	</div>

	<div class="form-group" >

		<label>Administrador</label>

		<select class="form-control" id="administrador" name="administrador" onchange="Inicio.validar()">

			<option value="0">NO</option>

			<option value="1">SI</option>

		</select>

	</div>

</div>

<div class="col-lg-4">
	<div class="form-group">

		<label>Apellido Paterno</label>

		<div class="form-group">
		<input type="text" required class="form-control" name="apaterno" id="apaterno">
	    </div>

	</div>

	<div class="form-group">

		<label>Puesto</label>

		<div class="form-group">
		<input type="text" required class="form-control" name="puesto" id="puesto">
	    </div>

	</div>

	<div class="form-group">

		<label>Usuario</label>

		<div class="form-group">
		<input type="text" required class="form-control" name="clave" id="clave">
	    </div>

	</div>
	<div class="form-group" id="tipoAplicativo1" name="tipoAplicativo1" style="display: none;">

			<label>Proyecto</label>

			<select class="form-control" onchange="" id="tipoAplicativo" name="tipoAplicativo">

				<?php

				foreach($resultados2 as $registro){

					echo '<option value="'.$registro['aplicativoid'].'">'.$registro['descripcion'].'</option>';

				}?>

			</select>

		</div>
</div>

<div class="col-lg-4">
	<div class="form-group">

		<label>Apellido Materno</label>

		<div class="form-group">
		<input type="text" required class="form-control" name="amaterno" id="amaterno">
	    </div>

	</div>

	<div class="form-group">

		<label>Email</label>

		<div class="form-group">
		<input type="text" required class="form-control" name="emails" id="emails">
	    </div>

	</div>

	<div class="form-group">

		<label>Contraseña</label>

		<div class="form-group">
		<input type="text" required class="form-control" name="pass" id="pass">
	    </div>

	</div>
</div>
<div class="col-lg-12">
	

<div style="text-align: right">
		<button type="button" class="btn btn-primary btn-general-cancel" onclick="window.location.href='cat-usuarios'"> Cancelar</button>
		<button type="button" class="btn btn-primary btn-general" onclick="Inicio.guardarUsuario();return false">Agregar</button>
		</div>

</div>

</div>

</div>
<?php

if(!defined('tmAu347djsa')) exit;

require 'modelos/seguridad.php';

$Seguridad = new Seguridad;

$resultados = $Seguridad->consultarUsuarios();

$resultados2 = $Seguridad->consultarApps();

$resultados3 = $Seguridad->consultarDepartamentos();

?>

<script src="js/nuevousuario.js"></script>

<div class="row">

<h3>Catálogo de Usuarios</h3>

<div class="col-lg-12">
	<div style="text-align: right">

		<button 
			type="button" 
			class="btn btn-success btn-general" 
			onclick="window.location.href='?page=nuevo-usuario'"
		>
			Nuevo Usuario
		</button>
		<!-- <button 
		type="button" 
		class="btn btn-success" 
		onclick="window.location.href='?page=nuevo-usuario'"
	>
		<span><img src="img/add-user.png"/></span> Nuevo Usuario
		</button> -->

	</div>
</div>

<div class="col-lg-12 scroll-tablas">
	<table width="100%" id="tablaUsuarios">
		<tr>
			<th>Nombre</th>
			<th>Apellido Paterno</th>
			<th>Usuario</th>
			<th>Departamento</th>
			<th style="text-align: center;">Acciones</th>
		</tr>
		<?php

			foreach($resultados as $registro){
				echo '<tbody id="tableUser"><tr><td>'.$registro['nombre'].'</td><td>'.$registro['paterno'].'</td><td>'.$registro['usuario'].'</td><td>'.$registro['departamento'].'</td><td style="text-align: center;"><button type="button" class="btn btn-primary btn-general btn-xs" onclick="Inicio.mostrarModalModificar('.$registro['usuarioid'].')">Detalles</button></td></tr></tbody>';
			}?>
	</table>
</div>

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true"
	id="modalModificar">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span></button>
				<h4 class="modal-title">Modificar Usuario.</h4>
			</div>
			<div class="modal-body">
				<input type="hidden" name="idUser" id="idUser">

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

							foreach($resultados3 as $registro){

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

						<select class="form-control" id="administrador" disabled name="administrador" onchange="Inicio.validar()">

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

					<div class="form-group" style="display: none;">

						<label>Contraseña</label>

						<div class="form-group">
						<input type="text" required class="form-control" name="pass" id="pass">
					    </div>

					</div>
					<div class="form-group">

						<label></label>

						<div class="form-group">
						<input type="hidden" name="" id="">
					    </div>

					</div>
				</div>
				
			</div>
			<div class="modal-footer">
				<div class="col-lg-12">
					<button type="button" class="btn btn-primary btn-general-cancel" data-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-primary btn-general" onclick="Inicio.guardarModificacion(); return false">Aceptar</button>
				</div>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
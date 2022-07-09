<?php

if(!defined('tmAu347djsa')) exit;

require 'modelos/seguridad.php';

$Seguridad = new Seguridad;

$resultados = $Seguridad->consultarTiposSoportes();

$resultados2 = $Seguridad->consultaTiposTickets();

?>
<script src="js/nuevoticket.js"></script>

<div class="row">

<h3>Registrar nuevo ticket</h3>

<form method="POST" action="controller/registrarTicket.php" enctype="multipart/form-data" id="nuevoticket" name="nuevoticket">

	<div class="col-lg-6">

		<div class="form-group">

			<label>Para</label>

			<select class="form-control" onchange="Nuevo.consultarAplicativos()" id="tipoSoporte" name="selectDepartamento">
                  <?php

				foreach($resultados as $registro){

					echo '<option value="'.$registro['tipoSoporteId'].'">'.$registro['descripcion'].'</option>';

				}
				
				?>
				</select>
				
				
			<p class="help-block">Seleccione el Departamento al que deseé enviar el ticket.</p>

		</div>

		<div class="form-group" id="divAplicativo" >

			<label>Tipo de Ticket</label>

			<select class="form-control" id="tipoAplicativo" name="selectTipoSoporte" onchange="Nuevo.mostrarResponsable()"></select>

			<p class="help-block">Responsable: <span id="spanResponsable" style="color:#0c80c5;font-weight: bold;"></span></p>

		</div>

		

		<div class="form-group" style="display: none">

			<label>Prioridad</label>

			<select class="form-control" id="tipoTicket" name="selectPrioridad">

				<?php

				foreach($resultados2 as $registro){

					echo '<option value="'.$registro['tipoTicketId'].'">'.$registro['descripcion'].'</option>';

				} ?>

			</select>

		</div>

		<div class="form-group" style="display:none">

			<label>¿Detiene su operación?</label>

			<select class="form-control" id="detieneOperacion" name="selectDetieneOperacion">

				<option value="1">No</option>

				<option value="2">Si</option>

			</select>

		</div>

		

	</div>

	<div class="col-lg-6">

		<div class="form-group">

			<label>Archivo Adjunto</label>

			<input type="file" class="form-control" name="fileAbjunto">

            <!--<label for="subirFactura" value="Seleccionar" class="btn btn-success" style="background-image: url(img/archivo.png); background-position: center; background-repeat: no-repeat; background-size: 17px; padding-left: 30px; height: 25px; width: 10px;" title="Seleccionar"></label> <input type="file" value="Seleccionar" id="subirFactura" name="fileAbjunto" style="width: 0px; height: 0px;">-->

			<p class="help-block">Formatos: jpg,png,txt,pdf,xls,doc.</p>

		</div>

		<div class="form-group">

			<label>Asunto</label>
			<input type="text" required class="form-control" name="textAsunto" id="asunto">

		</div>

	</div>

	<div class="col-lg-12">

		<div class="form-group">

			<div class="input-group">

				<span class="input-group-addon texto-prev-input"><b>C.C.</b></span>

				<input type="text" class="form-control select-general" id="emails" name="emails">

				<div class="input-group-addon" style="padding:0;border:0; margin-left: 10px !important;">

					<button type="button" class="btn btn-primary btn-general" onclick="Nuevo.mostrarUsuarios()">Buscar</button></div>

			</div>

		</div>	

	</div>

	

	<div class="col-lg-12" style="display:none">

		<div class="panel panel-default">

        	<div class="panel-body">

        		<label>Invitados: <input type="button" onclick="Nuevo.mostrarUsuarios()" value="Buscar Usuario"></label><br />

        		<label id="listaInvitados">

					<!-- <a class="labelInvitado" onclick="Nuevo.quitarInvitado(22)">Juan Alvarez</a>-->

				</label>

				<input type="text" name="inputInvitados" id="inputInvitados" style="display:none">

			</div>

        </div>

	</div>



	

	<div class="col-lg-12">

		<div class="form-group" >

			<label>Descripción</label>

			<textarea class="form-control" required rows="10" id="descripcion" name="textDescripcion"></textarea>

			<p class="help-block">Se recomienda que incluya objetivo general, objetivo específico, indicador de desempeño, criterio de aceptación/rechazo.</p>

		</div>

		

		<div style="text-align: right">

			<button type="button" class="btn btn-primary btn-general" onclick="return Nuevo.confirmarRegistro()">Enviar</button>

		</div>

	</div>

</form>

</div>



<div class="modal fade" id="modalListaUsuarios">

	<div class="modal-dialog modal-lg">

		<div class="modal-content">

			<div class="modal-header">

				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>

				<h4 class="modal-title">Seleccione un Usuario</h4>

			</div>

			<div class="modal-body">

				<form class="form-horizontal" role="form">

					<div class="form-group">

						<input type="text" class="form-control" onkeyup="Nuevo.mostrarListaUsuarios()"

							onkeypress="Nuevo.mostrarListaUsuarios()" id="textoBusqueda" autocomplete="off"/>

						<div class="col-sm-12" style="padding-top:20px">

							<table width="100%" id="tablaBusquedaUsuarios">

							</table>

						</div>

					</div>

				</form>

			</div>

		</div><!-- /.modal-content -->

	</div><!-- /.modal-dialog -->

</div><!-- /.modal -->
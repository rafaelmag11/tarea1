<?php
if(!defined('tmAu347djsa')) exit;
//require 'modelos/seguridad.php';
//$Seguridad = new Seguridad;
//$resultados = $Seguridad->consultarTicketUsuario($_SESSION['usuarioid']);
?>
<script src="js/Monitor2.js"></script>
<script src="js/Inicio.js"></script>
<script src="js/Monitor_controller.js"></script>


<div class="row">
	<div class="col-lg-5">
		<h3></h3>
		<form role="form">
			<div class="form-group input-group">
				<span class="input-group-addon texto-prev-input">Mostrar</span>
				<select class="form-control select-general" id="selectFiltro" onchange="Monitor.consultarTickets()">
					<option value="0" selected>Todos</option>
					<option value="1">Por Atender</option>
					<option value="2">En Atención</option>
					<option value="3">Resueltos</option>
					<option value="4">Cancelados</option>
				</select>
			</div>
		</form>
		<div class="borde">
			<div class="list-group" id="divLista">
				

			</div>
		</div>
	</div>

	<div class="col-lg-7" style="margin-top:10px">
		<p>
			<div class="btn-group btn-group-justified">
				<a href="#" id="aAgregarComentario" class="btn btn-primary  btn-group-left" onclick="Inicio.mostrarModelComentario();return false">Agregar Comentario</a>
				<!-- <a href="#" id="aCalificar" class="btn btn-primary disabled" onclick="Inicio.mostrarModalCalificar();return false">Calificar</a> -->
				<a href="#" id="aAtencion" class="btn btn-primary  btn-group-medium" onclick="Monitor.mostrarModalAtencion();return false">Marcar en Atención</a>
				<a href="#" id="aFinalizar" class="btn btn-primary  btn-group-medium" onclick="Monitor.mostrarModalFinalizar();return false">Finalizar Ticket</a>
				<a href="#" id="aCancelarTicket" class="btn btn-primary  btn-group-right" onclick="Inicio.motrarModalCancelar();return false">Cancelar Ticket</a>
			</div>
		</p>
		<h3 id="resultAsunto">----------</h3>
		<div style="overflow-y:auto" id="divDetalle">
			<div class="well well-sm">
				<span>No de Ticket: </span><b id="resultNoTicket"></b><br />
				<span>Registró: <b id="resultRegistro">-------------</b></span><br />
				<span>Responsable:</span> <span><b id="resultResponsable">-----</b> (<i id="resultNombresResponsables">-------</i>)</span>
					<br />
				<!-- <span>Invitados:</span> <b id="resultInvitados">-------</b><br /> -->
				<span>CC:</span> <b id="label_cc">-</b><br />
				<span>Adjunto:</span> <span id="resultAbjunto"></span><br />
				<span>Estatus:</span> <b id="resultEstatus">-------</b><br />
				<span id="resultCalificacion"></span>
				<div style="clear:both"></div>
			</div>
			<div class="panel">
				<div class="panel-body" id="resultDescripcion"></div>
            </div>

            <div class="panel panel-primary">
	              	<div class="panel-heading">
	                	<h3 class="panel-title">Seguimiento</h3>
	                	
	                	<!-- <a href="#" style="float:right;margin-top:-20px" onclick="Inicio.mostrarModelComentario();return false">
	                		<span class="label label-warning" style="font-size:13px">Agregar Comentario</span></a> -->
	              	</div>
	              	<div class="panel-body">
	                	<div class="list-group" id="divComentariosDetalle">
							<!--<a href="#" class="list-group-item">
								<span class="badge">just now</span>
								<i class="fa fa-calendar"></i> Calendar updated
							</a>-->
	                	</div>
	              	</div>
			</div>
		</div>
	</div>
</div>


<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modalComentario">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form enctype="multipart/form-data" class="formulario" method="POST" id="comentario" name="comentario">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title">Agregar Comentario</h4>
				</div>
				<div class="modal-body">
					<input type="text" id="inputModalComentarioNoTicket" style="display:none">
					<div class="form-group">
						<label>Comentario</label>
						<textarea name="comentario" rows="12" class="form-control" id="comentario"></textarea>
					</div>
					<div class="form-group">
						<label>Archivo adjunto</label>
						<input type="file" class="form-control" name="archivo" id="archivo">
						<p class="help-block">Formatos: jpg,png,txt,pdf,xls,doc.</p>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary btn-general-cancel" data-dismiss="modal">Cancelar</button>
					<button type="button" class="btn btn-primary btn-general" onclick="Inicio.guardarComentarioArchivo();return false">Aceptar</button>
				</div>
			</form>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true"
	id="modalCancelar">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span></button>
				<h4 class="modal-title">Cancelación del ticket.</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>No. de Ticket: <span id="noTicket_ModalCancelar"></span></label>
				</div>
				<div class="form-group">
					<label>Motivo</label>
					<textarea name="comentario" rows="12" class="form-control" id="comentario_ModalCancelar"></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary btn-general-cancel" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary btn-general" onclick="Inicio.guardarCancelacion();return false">Aceptar</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true"
	id="modalCalificar">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span></button>
				<h4 class="modal-title">Calificar Ticket.</h4>
			</div>
			<div class="modal-body">
				<input type="text" id="inputModalNoTicket" style="display:none">
				<h5>No de Ticket: <span id="noTicket_modalCalificar"></span></h5>
				Calificación
				<select id="calificacion_modalCalificar" class="form-control" style="max-width: 200px;display: initial;">
					<option>1</option>
					<option>2</option>
					<option>3</option>
					<option>4</option>
					<option>5</option>
					<option>6</option>
					<option>7</option>
					<option>8</option>
					<option>9</option>
					<option>10</option>
				</select>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary btn-general" onclick="Inicio.mostrarReabrirTicket()" style="float:left">Reabrir Ticket</button>

				<button type="button" class="btn btn-primary btn-general-cancel" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary btn-general" onclick="Inicio.guardarCalificacion();return false">Aceptar</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true"
	id="modalReabrirTicket">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span></button>
				<h4 class="modal-title">Reabrir ticket</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>Motivo</label>
					<textarea name="comentario" rows="12" class="form-control" id="textMotivoApertura"></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary btn-general-cancel" data-dismiss="modal">Cancelar</button>
				<button type="submit" class="btn btn-primary btn-general" onclick="Inicio.guardarReabrirTicket();return false">Aceptar</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true"
	id="modalFinalizar">
	<div class="modal-dialog modal-lg">
		<div class="modal-content panel-success">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span></button>
				<h4 class="modal-title">Finalizar ticket.</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>No. de Ticket: <span id="noTicket_ModalFinalizar"></span></label>
				</div>
				<div class="form-group">
					<label>Comentario</label>
					<textarea name="comentario" rows="12" class="form-control" id="comentario_ModalFinalizar"></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary btn-general-cancel" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary btn-general" onclick="Monitor.guardarFinalizacion();return false">Aceptar</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>

<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true"
	id="modalAtencion">
	<div class="modal-dialog modal-lg">
		<div class="modal-content panel-warning">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span>
					<span class="sr-only">Close</span></button>
				<h4 class="modal-title">Finalizar ticket.</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label>No. de Ticket: <span id="noTicket_ModalAtencion"></span></label>
				</div>
				<div class="form-group">
					<label>Comentario</label>
					<textarea name="comentario" rows="12" class="form-control" id="comentario_ModalAtencion"></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary btn-general-cancel" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary btn-general" onclick="Monitor.guardarAtencion();return false">Aceptar</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
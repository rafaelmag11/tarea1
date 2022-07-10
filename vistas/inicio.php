<?php
if(!defined('tmAu347djsa')) exit;
//require 'modelos/seguridad.php';
//$Seguridad = new Seguridad;
//$resultados = $Seguridad->consultarTicketUsuario($_SESSION['usuarioid']);
?>
<script src="js/Inicio_controller.js"></script>
<script src="js/Inicio.js"></script>

<div class="row">
	<ul class="nav nav-pills">
		<li><a class="texto-pequenio contenedor-counter" href="#" onclick="Inicio.consultarPorCalificar()">Por Calificar <span class="badge counter" id="label_porCalificar">0</span></a></li>
	</ul>
</div>
<div class="row">
	<div class="col-lg-5">
		<h3></h3>
		<!-- Select -->
		<form role="form">
			<div class="form-group input-group">
				<span class="input-group-addon texto-prev-input">Mostrar</span>
				<select class="form-control select-general" id="selectFiltro" onchange="Inicio.consultarTickets()">
					<option value="0" selected>Todos</option>
					<option value="1">Por Atender</option>
					<option value="2">En Atención</option>
					<option value="3">Resueltos</option>
					<option value="5">Por Calificar</option>
					<option value="4">Cancelados</option>
				</select>
			</div>
		</form>
		<!-- Contenedor de tickets -->
		<div class="borde">
			<div class="list-group" id="divLista">
				<!-- Eliminar desde aqui -->
				<a href="#" class="list-group-item item-ticket" onclick="Inicio.consultarTicket(1994); return false" id="a1994">	          
					<div class="col-lg-9" style="padding-left:0"> 
						<span id="spanInvitado1994" style="display:none">0</span>						
						<span><b>1650001</b> - Patrick Hernandez</span>
						<br>						
						<span><b>prueba</b></span>
						<br>						
						<span style="font-size:12px">prueba</span>
						<br>					
					</div>					
					<div class="col-lg-3 contenedor-icono" style="padding:0">						
						<span>23/05/2022</span>
						<br>												
						<span><img class="img-ticket" src="img/Amarillo.svg" width="30"></span>				
					</div>					
					<div style="clear:both"></div>	            
				</a>					
				<a href="#" class="list-group-item item-ticket" onclick="Inicio.consultarTicket(1995); return false" id="a1995">	            	
					<div class="col-lg-9" style="padding-left:0">	            		
						<span id="spanInvitado1995" style="display:none">0</span>
						<span><b>1650002</b> - Patrick Hernandez</span>
						<br>						
						<span><b>sin asunto</b></span>
						<br>				
						<span style="font-size:12px">sin desc</span>
						<br>					
					</div>					
					<div class="col-lg-3 contenedor-icono" style="padding:0">						
						<span>23/05/2022</span>
						<br>												
						<span><img class="img-ticket" src="img/Morado.svg" width="30"></span>					
					</div>					
					<div style="clear:both"></div>	            
				</a>
				<a href="#" class="list-group-item item-ticket" onclick="Inicio.consultarTicket(1994); return false" id="a1994">	          
					<div class="col-lg-9" style="padding-left:0"> 
						<span id="spanInvitado1994" style="display:none">0</span>						
						<span><b>1650001</b> - Patrick Hernandez</span>
						<br>						
						<span><b>prueba</b></span>
						<br>						
						<span style="font-size:12px">prueba</span>
						<br>					
					</div>					
					<div class="col-lg-3 contenedor-icono" style="padding:0">						
						<span>23/05/2022</span>
						<br>												
						<span><img class="img-ticket" src="img/Verde.svg" width="30"></span>				
					</div>					
					<div style="clear:both"></div>	            
				</a>					
				<a href="#" class="list-group-item item-ticket" onclick="Inicio.consultarTicket(1995); return false" id="a1995">	            	
					<div class="col-lg-9" style="padding-left:0">	            		
						<span id="spanInvitado1995" style="display:none">0</span>
						<span><b>1650002</b> - Patrick Hernandez</span>
						<br>						
						<span><b>sin asunto</b></span>
						<br>				
						<span style="font-size:12px">sin desc</span>
						<br>					
					</div>					
					<div class="col-lg-3 contenedor-icono" style="padding:0">						
						<span>23/05/2022</span>
						<br>												
						<span><img class="img-ticket" src="img/Rojo.svg" width="30"></span>					
					</div>					
					<div style="clear:both"></div>	            
				</a>
				<a href="#" class="list-group-item item-ticket" onclick="Inicio.consultarTicket(1995); return false" id="a1995">	            	
					<div class="col-lg-9" style="padding-left:0">	            		
						<span id="spanInvitado1995" style="display:none">0</span>
						<span><b>1650002</b> - Patrick Hernandez</span>
						<br>						
						<span><b>sin asunto</b></span>
						<br>				
						<span style="font-size:12px">sin desc</span>
						<br>					
					</div>					
					<div class="col-lg-3 contenedor-icono" style="padding:0">						
						<span>23/05/2022</span>
						<br>												
						<span><img class="img-ticket" src="img/Naranja.svg" width="30"></span>					
					</div>					
					<div style="clear:both"></div>	            
				</a>
				<!-- Eliminar desde aqui -->
			</div>
		</div>
	</div>
	<!-- Columna derecha -->
	<div class="col-lg-7" style="margin-top:10px">
		<!-- Botones de acciones para tickets -->
		<p>
			<div class="btn-group btn-group-justified">
				<a 
					href="#" 
					id="aAgregarComentario" 
					class="btn btn-primary disabled btn-group-left" 
					onclick="Inicio.mostrarModelComentario();
					return false"
				>
					Agregar Comentario
				</a>
				<a 
					href="#" 
					id="aCalificar" 
					class="btn btn-primary disabled btn-group-medium" 
					onclick="Inicio.mostrarModalCalificar();
					return false"
				>
					Calificar
				</a>
				<a 
					href="#" 
					id="aCancelarTicket" 
					class="btn btn-primary disabled btn-group-right" 
					onclick="Inicio.motrarModalCancelar();
					return false"
				>
					Cancelar Ticket
				</a>
			</div>
		</p>
		<!-- Texto principal -->
		<h3 id="resultAsunto">----------</h3>
		<!-- Contenedor informacion de tickets -->
		<div id="divDetalle">
			<div class="well well-sm contenedor-info-ticket" >
				<span>No de Ticket: </span><b id="resultNoTicket"></b><br />
				<span>Registró: <b id="resultRegistro">-------------</b></span><br />
				<span>Responsable:</span> <span><b id="resultResponsable">-----</b> (<i id="resultNombresResponsables">-------</i>)</span>
				<br />
				<span>CC:</span> <b id="label_cc">-</b><br />
				<span>Adjunto:</span> <span id="resultAbjunto"></span><br />
				<span>Estatus:</span> <b id="resultEstatus">-------</b><br />
				<span id="resultCalificacion"></span>
				<div style="clear:both"></div>
			</div>
			<div class="panel">
				<div class="panel-body" id="resultDescripcion"></div>
            </div>
			<!-- Seguimiento -->
            <div class="panel panel-primary">
				<div class="panel-heading">
					<h3 class="panel-title">Seguimiento</h3>
				</div>
				<div class="panel-body">
					<div class="list-group" id="divComentariosDetalle">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>



<div class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modalComentario">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form enctype="multipart/form-data" class="formulario" method="POST">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
					<h4 class="modal-title">Agregar Comentario</h4>
				</div>
				<div class="modal-body">
					<input type="text" id="inputModalComentarioNoTicket" style="display:none">
					<div class="form-group">
						<label>Comentario</label>
						<textarea name="comentario" class="form-control" rows="12" id="comentario"></textarea>
					</div>
					<div class="form-group">
						<label>Archivo adjunto</label>
						<input type="file" class="form-control" name="archivo" id="archivo">
						<p class="help-block">Formatos: jpg,png,txt,pdf,xls,doc.</p>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary btn-general-cancel" data-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary btn-general" onclick="Inicio.guardarComentarioArchivo();return false">Aceptar</button>
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
					<textarea as="textarea" name="comentario" class="form-control" rows="12" id="comentario_ModalCancelar"></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary btn-general-cancel" data-dismiss="modal">Cancelar</button>
				<button type="submit" class="btn btn-primary btn-general" onclick="Inicio.guardarCancelacion();return false">Aceptar</button>
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
				<label>Calificación</label>
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
				<button type="submit" class="btn btn-primary btn-general" onclick="Inicio.guardarCalificacion();return false">Aceptar</button>
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
					<textarea name="comentario" class="form-control" rows="12" id="textMotivoApertura"></textarea>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-primary btn-general-cancel" data-dismiss="modal">Cancelar</button>
				<button type="submit" class="btn btn-primary btn-general" onclick="Inicio.guardarReabrirTicket();return false">Aceptar</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
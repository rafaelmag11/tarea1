<?php
if(!defined('tmAu347djsa')) exit;
require 'modelos/seguridad.php';
$Seguridad = new Seguridad;
$resultados = $Seguridad->consultarTicketUsuario($_SESSION['usuarioid']);
?>
<script src="js/inicio.js"></script>
<div class="row" id="divTickets">
	<h3>Ticket's Registrados</h3>
	<div class="table-responsive">
		<table class="table table-bordered table-hover ">
		<thead>
			<tr>
				<th style="min-width:70px">Folio <i class="fa fa-sort"></i></th>
				<th>Estatus</th>
				<th style="min-width:100px">Fecha <i class="fa fa-sort"></i></th>
				<th>Departamento que atiende<i class="fa fa-sort"></i></th>
				<th style="min-width:85px">Tipo de Soporte<i class="fa fa-sort"></i></th>
				<th>Descripción<i class="fa fa-sort"></i></th>
				<th>Comentarios</th>
				<th>Adjunto</th>
				<th>Calificación</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$estiloActivo = 'active';
			foreach($resultados as $registro){
				$htmlCalificacion = '';
				
				$iconoEstatus = '';
				if($registro['estatusid'] == 1){
					//$estilo = 'class="danger"';
					$iconoEstatus = '<img src="img/por-atender.png" title="'.$registro['estatus'].'" alt="'.$registro['estatus'].'" />';
				}
				elseif($registro['estatusid'] == 2){
					$iconoEstatus = '<img src="img/en-atencion.png" title="'.$registro['estatus'].'" alt="'.$registro['estatus'].'" />';
				}
				elseif($registro['estatusid'] == 3){
					$iconoEstatus = '<img src="img/finalizado.png" title="'.$registro['estatus'].'" alt="'.$registro['estatus'].'" />';
					if($registro['calificacion'] == null){
						$htmlCalificacion = '<a href="#" class="btn btn-default" onclick="Inicio.modalCalificar('.$registro['soporteid'].')">Calificar ticket</a>';
					}else{
						$htmlCalificacion = $registro['calificacion'];
					}
				}
				elseif($registro['estatusid'] == 4){
					$iconoEstatus = '<img src="img/cancelado.png" title="'.$registro['estatus'].'" alt="'.$registro['estatus'].'" />';
				}
				elseif($registro['estatusid'] == 5){
					$iconoEstatus = '<img src="img/suspendido.png" title="'.$registro['estatus'].'" alt="'.$registro['estatus'].'" />';
				}
				
				$htmlFile = '';
				if($registro['archivo'] != '')
					$htmlFile = '<a href="archivos-usuarios/'.$registro['archivo'].'" target="_blank"><img src="img/file.png" width="30"></a>';
				
				echo '<tr class="'.$estiloActivo.'">
						<td style="text-align:center">'.$registro['folio'].'</td>
						<td style="text-align:center">'.$iconoEstatus.'</td>
						<td>'.$registro['fecha'].'</td>
						<td>'.$registro['tipoSoporte'].'</td>
						<td>'.$registro['aplicativo'].'</td>
						<td>'.$registro['descripcion'].'</td>
						<td style="text-align:center"><a href="#" style="width:100%" onclick="Inicio.consultarComentarios('.$registro['soporteid'].')" class="btn btn-default"><b>'.$registro['numComentarios'].'</b></a></td>
						<td style="text-align:center">'.$htmlFile.'</td>
						<td style="text-align:center"><b>'.$htmlCalificacion.'</b></td>
					  </tr>';
				if($estiloActivo != '')$estiloActivo = '';
				else	$estiloActivo = 'active';
			}
			?>
		</tbody>
		</table>
	</div>
</div><!-- /.row -->

<div class="row" id="divTicketsInvitado">
	<h3>Ticket's como Invitado</h3>
	<div class="table-responsive">
		<table class="table table-bordered table-hover ">
		<thead>
			<tr>
				<th>Estatus</th>
				<th style="min-width:70px">Folio <i class="fa fa-sort"></i></th>
				<th>Registró</th>
				<th style="min-width:100px">Fecha <i class="fa fa-sort"></i></th>
				<th>Responsable de Atención<i class="fa fa-sort"></i></th>
				<th style="min-width:85px">Asunto<i class="fa fa-sort"></i></th>
				<th>Descripción<i class="fa fa-sort"></i></th>
				<th>Comentarios</th>
				<th>Adjunto</th>
				<th>Calificación</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
		</table>
	</div>
</div>

<div id="divComentarios" style="display: none">
	<ol class="breadcrumb">
      <li><a href="#" onclick="Inicio.mostrarTickets();return false"><i class="fa fa-dashboard"></i> Tikets</a></li>
      <li class="active"><i class="fa fa-desktop"></i> Seguimiento</li>
    </ol>

	<div class="row" >
		<div class="col-lg-10">
			<form enctype="multipart/form-data" class="formulario" method="POST">
			<div class="form-group">
				<label>Comentario</label>
				<textarea name="comentario" class="form-control" id="comentario"></textarea>
			</div>
			<div class="form-group">
				<label>Archivo adjunto</label>
				<input type="file" class="form-control" name="archivo" id="archivo">
				<p class="help-block">Formatos: jpg,png,txt,pdf,xls,doc.</p>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-primary" onclick="Inicio.guardarComentarioArchivo();return false">Aceptar</button>
			</div>
			</form>
		
			<div class="panel panel-primary">
              	<div class="panel-heading">
                	<h3 class="panel-title"><i class="fa fa-calendar-o"></i> Seguimiento</h3>
              	</div>

            	<p>
					<div class="btn-group btn-group-justified">
						<a href="#" class="btn btn-default">Left</a>
						<a href="#" class="btn btn-default">Right</a>
						<a href="#" class="btn btn-default">Middle</a>
					</div>
				</p>
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
	</div><!-- /.row -->
</div>

<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modalCalificar">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">Asigne una calificación a este ticket</h4>
			</div>
			<div class="modal-body">
				<h5>No de Ticket: <span id="spanTicketCalificar"></span></h5>
				Calificación
				<select id="selectCalificacion" class="form-control" style="max-width: 200px;display: initial;">
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
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
				<button type="button" class="btn btn-primary" onclick="Inicio.guardarCalificacion()">Aceptar</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>
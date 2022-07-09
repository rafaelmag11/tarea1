<?php
if(!defined('tmAu347djsa')) exit;
require 'modelos/seguridad.php';
$Seguridad = new Seguridad;
$resultados = $Seguridad->consultarEstatus();
?>

<script src="js/inicio-aux.js"></script>
<script src="js/monitor.js"></script>

<div class="row" id="divTickets">
	<div >
		<h2>Tickets por Atender</h2>
		<div class="table-responsive">
			<table class="table table-bordered table-hover tablesorter">
			<thead>
				<tr>
					<th style="min-width:70px">Folio <i class="fa fa-sort"></i></th>
					<th>Estatus</th>
					<th style="min-width:100px">Fecha <i class="fa fa-sort"></i></th>
					<th>Departamento que atiende<i class="fa fa-sort"></i></th>
					<th style="min-width:85px">Tipo de Soporte<i class="fa fa-sort"></i></th>
					<th>Descripción<i class="fa fa-sort"></i></th>
					<th>Reporta</th>
					<th>Comentarios</th>
					<th>Adjunto</th>
					<th>Calificación</th>
				</tr>
			</thead>
			<tbody id="tbodyTickets">
			</tbody>
			</table>
		</div>
	</div>
</div><!-- /.row -->

<div id="divComentarios" style="display: none">
	<ol class="breadcrumb">
      <li><a href="#" onclick="window.location.reload()"><i class="fa fa-dashboard"></i> Monitor</a></li>
      <li class="active"><i class="fa fa-desktop"></i> Seguimiento</li>
    </ol>

    <div class="row" >
    	<div class="bs-example">
			<ul class="nav nav-tabs" style="">
				<li class="active"><a href="#home" data-toggle="tab">Agregar Comentario</a></li>
				<li><a href="#profile" data-toggle="tab">Actualizar Estatus</a></li>
			</ul>
			<div id="myTabContent" class="tab-content">
				<div class="tab-pane fade active in" id="home">
					<div class="col-lg-12" style="padding-top:15px;margin-bottom:15px;border-left: 1px solid #ccc;;border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;">
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
							<button type="submit" class="btn btn-primary" onclick="Inicio.guardarComentarioArchivo();return false">Agregar</button>
						</div>
						</form>
					</div>
				</div>
				<div class="tab-pane fade" id="profile">
					<div class="col-lg-12" style="padding-top:15px;margin-bottom:15px;border-left: 1px solid #ccc;;border-bottom: 1px solid #ccc;border-right: 1px solid #ccc;">
						<div class="col-lg-6" style="text-align: right">
							<div class="form-group">
								<select class="form-control" id="estatus">
									<?php
									foreach($resultados as $registro){
										echo '<option value="'.$registro['estatusid'].'">'.$registro['descripcion'].'</option>';
									}
									?>
								</select>
							</div>
						</div>
						<div class="col-lg-12" style="text-align: right">
							<div class="form-group">
								<textarea class="form-control" id="comentario2"></textarea>
								<button type="button" class="btn btn-primary" onclick="Monitor.cambiarEstatus()">Actualizar</button>
							</div>
						</div>
					</div>
				</div>	
			</div>
		</div>
    </div>
    
	<div class="row" >
		<div class="col-lg-12">
			<div class="panel panel-primary">
	              <div class="panel-heading">
	                <h3 class="panel-title"><i class="fa fa-calendar-o"></i> Seguimiento</h3>
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
	</div><!-- /.row -->
</div>
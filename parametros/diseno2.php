<?php
if(!defined('tmAu347djsa')) exit;
function encabezado2($menu,$menuOpcion,$cd){?>
	<!DOCTYPE html>
	<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<link rel="stylesheet" href="<?php echo $cd;?>css/propio.css">

		<!-- Inclusion de Bootstrap 5 cdn -->
		<!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script> -->

		<script src="https://kit.fontawesome.com/ed1ee4745a.js" crossorigin="anonymous"></script>


		<title>Mesa de ayuda</title>
		<!-- Bootstrap core CSS -->
		<link href="<?php echo $cd;?>css/bootstrap/bootstrap.css" rel="stylesheet">
		<!-- Add custom CSS here -->
		<link href="<?php echo $cd;?>css/bootstrap/sb-admin.css" rel="stylesheet">
		<link rel="stylesheet" href="<?php echo $cd;?>css/font-awesome/css/font-awesome.min.css">
		<!-- Page Specific CSS -->
		<!-- <link rel="stylesheet" href="<?php echo $cd;?>css/bootstrap/morris-0.4.3.min.css"> -->
		<!-- JavaScript -->
	    <script src="<?php echo $cd;?>js/js-lib/jquery-1.10.2.js"></script>
	    <script src="<?php echo $cd;?>js/js-lib/bootstrap.js"></script>

	    <!-- Page Specific Plugins -->
	    <script src="<?php echo $cd;?>js/js-lib/raphael-min.js"></script>
	    <script src="<?php echo $cd;?>js/js-lib/morris-0.4.3.min.js"></script>
	    <script src="<?php echo $cd;?>js/morris/chart-data-morris.js"></script>
	    <script src="<?php echo $cd;?>js/tablesorter/jquery.tablesorter.js"></script>
	    <script src="<?php echo $cd;?>js/tablesorter/tables.js"></script>
	    
		<!-- 	JS PROPIOS -->
	    <script src="<?php echo $cd;?>js/general.js"></script>
	    <script src="<?php echo $cd;?>js/global.js"></script>

	</head>
	<body>
		<!-- <div id="wrapper"> -->
		<div class="wrapper">
		
    		<nav class="navbar navbar-fixed-top" role="navigation">
        
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
						<span class="sr-only">TEKSI</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<!-- <a class="navbar-brand" href="inicio"><img src="img/logo-teksi.png"></a> -->
				</div>

        		<div class="collapse navbar-collapse navbar-ex1-collapse">
					<?php
						if($menu){?>
							<ul class="nav navbar-nav side-nav">
								<?php
								require 'parametros/menu.php';
								foreach($menu as $submenu){
									if($submenu[5]==0 || ($submenu[5]==1 && $_SESSION['administrador']==1)){							
										$resaltar = '';
										if($menuOpcion == $submenu[0])
											$resaltar = 'class="active"';
										if(count($submenu[4]) == 0)
											echo '<li '.$resaltar.'><a href="'.$submenu[3].'"><i class="fa '.$submenu[2].'"></i> '.$submenu[1].'</a></li>';
										else{
											echo '<li class="dropdown">
												<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa '.$submenu[2].'"></i> '.$submenu[1].' <b class="caret"></b></a>
												<ul class="dropdown-menu">';
											foreach($submenu[4] as $link){
												echo '<li><a href="'.$link[1].'">'.$link[2].'</a></li>';
											}
											echo '</ul></li></ul>';
										}
									}
								}
								?>
							</ul>
							
							<ul class="nav navbar-nav navbar-right navbar-user">
								<li class="dropdown user-dropdown">
								<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $_SESSION['nombre'];?> <b class="caret"></b></a>
								<ul class="dropdown-menu">
									<li><a href="#" onclick="Global.consultarDatosUsuario()"><i class="fa fa-user"></i> Contraseña</a></li>
		<!-- 			                <li><a href="#"><i class="fa fa-envelope"></i> Inbox <span class="badge">7</span></a></li> -->
		<!-- 			                <li><a href="#"><i class="fa fa-gear"></i> Settings</a></li> -->
									<li class="divider"></li>
									<li><a href="controller/salir.php"><i class="fa fa-power-off"></i> Cerrar Sesión</a></li>
								</ul>
								</li>
							</ul>
					<?php }?>
        		</div>
      		</nav>
	  	<div id="page-wrapper">
<?php
}

function pie2(){?>
		</div>
		</div><!-- /#wrapper -->
		
		<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" id="modalCarga">
			<div class="modal-dialog modal-sm">
				<div class="modal-content" style="padding: 40px">
					  <img src="img/cargando.gif"/>
					  Espere por favor..
				</div>
			</div>
		</div>
		
		<div class="modal fade" id="modalDatosUsuario">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
						<h4 class="modal-title">Cambiar Contraseña</h4>
					</div>
					<div class="modal-body">
						<form class="form-horizontal" role="form">
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Contraseña</label>
								<div class="col-sm-6">
									<input type="password" maxlength="20" class="form-control" id="inputPass1">
								</div>
							</div>
							<div class="form-group">
								<label for="inputEmail3" class="col-sm-4 control-label">Repetir contraseña</label>
								<div class="col-sm-6">
									<input type="password" maxlength="20" class="form-control" id="inputPass2">
								</div>
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
						<button type="button" class="btn btn-primary" onclick="Global.guardarDatosUsuario()">Guardar cambios</button>
					</div>
				</div><!-- /.modal-content -->
			</div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		
	  </body>
	</html>
<?php
}
?>
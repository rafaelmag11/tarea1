<?php
if(!defined('tmAu347djsa')) exit;
?>

<div id="loginModal" class="modal show contenedor-logueo" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" style="margin:130px auto 30px auto">
		<div class="modal-content" id="modal-login">
			<div class="modal-body">

				<div class="contenedor-imagen">
					<img src="img/logoTeksiResponsivePurple.svg" alt="" class="contenedor-imagen__img">
				</div>
				<div class="contenedor-imagen-responsive">
					<img src="img/logoTeksiResponsive.svg" alt="" class="contenedor-imagen__img-responsive">
				</div>
				<br>
				<br>

				<form class="form col-md-12 modal-login__form" action="controller/logueo.php" name="f_acceso" method="POST">
					<input 
						type="text" 
						name="usuario" 
						id="usuario" 
						class="form-control form-control-sm modal-login__input" 
						type="text" 
						placeholder="Usuario"
					>
					<input 
						type="password" 
						name="pass" 
						id="pass" 
						class="form-control form-control-sm modal-login__input" 
						type="text" 
						placeholder="Contraseña"
					>
				<!-- <div class="form-group">
					<input type="text" name="usuario" id="usuario" class="form-control input-lg" placeholder="Usuario">
				</div> -->
				<!-- <div class="form-group">
					<input type="password" name="pass" id="pass" class="form-control input-lg" placeholder="Contraseña">
				</div> -->
					<br>
					<button
						class="btn btn-success modal-login__btn"
						onclick="return comprobar()"
					>
						Aceptar
					</button>
					<!-- <div class="form-group">
						<button class="btn btn-primary btn-lg btn-block" onclick="return comprobar()">Aceptar</button>
					</div> -->
				</form>
				<div style="clear: both"></div>

			</div>
			<div class="modal-footer">
				<div class="col-md-12">
					<span style="color: red">
						<?php
							if(isset($_SESSION['mensaje']))
								echo $_SESSION['mensaje'];
						?>
					</span>
				<!--<button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>-->
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript" >

	function comprobar(){

		var usuario = $('#usuario');
		var pass = $('#pass');

		console.log(usuario, pass);
		
		if(usuario.val() != ''){
			if(pass.val() != '')
				return true;
			else
				pass.focus();
		}
		else
			usuario.focus();
		return false;
	}

</script>
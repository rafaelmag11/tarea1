<?php
	if(!isset($_GET['user'])||!isset($_GET['token']))
		exit;

	$usuario = $_GET['user'];
	$elToken = $_GET['token'];
?>
<div class="row">
  <div class="col-lg-6">
    <h2>Tablero de control - <span style="font-size: 18px;"><?php echo $usuario;?></span></h2>
    <div class="table-responsive">	
    <?php	
    	require 'modelos/seguridad.php';
		$Seguridad = new Seguridad;
		$existe = $Seguridad->validaToken($usuario,$elToken);
		if($existe == 1){
			$volumen = $Seguridad->obtieneVentas($usuario);
			echo '<table class="table table-bordered table-hover table-striped tablesorter">
				  	<thead>
				  		<tr>
						  	<th>
						  		Indicador <i class="fa fa-sort"></i>
						  	</th>
							<th>
								Cantidad <i class="fa fa-sort"></i>
							</th>
							<th>
								Objetivo <i class="fa fa-sort"></i>
							</th>
							<th>
								Diferencia <i class="fa fa-sort"></i>
							</th>
						 </tr>
					</thead>
					<tbody>';
			foreach($volumen as $vol){
				echo '</tr>
					  	<td>
					  		'.$vol['indicador'].'
					  	</td>
						<td>
							'.$vol['cantidad'].'
						</td>
						<td>
							'.$vol['objetivo'].'
						</td>
						<td>
							'.$vol['diferencia'].'
						</td>
					  </tr>';
			}
			echo 	'</tbody>
				</table>';
			$Seguridad->cerrarConexion();
		}
		else{
			echo "No tiene acceso a este reporte...";
			exit();
		}
		?>
	</div>
  </div>
</div>  
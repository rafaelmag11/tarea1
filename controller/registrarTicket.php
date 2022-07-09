<?php

define('tmAu347djsa', true);//VARIABLE PARA QUE DEJAR VER CONTENIDO POR REQUIRE

require '../modelos/seguridad.php';

require '../parametros/conexion.php';

require '../clases-externas/upload.php';

require '../modelos/usuarios.php';

require 'funcion-correo.php';

require '../clases-externas/Generica.php';



session_start();

$Modelo = new Seguridad();



$asunto = $_POST['textAsunto'];

$departamento = $_POST['selectDepartamento'];

$tipoSoporte = $_POST['selectTipoSoporte'];

$prioridad = $_POST['selectPrioridad'];

$descripcion = $_POST['textDescripcion'];

$detieneOperacion = $_POST['selectDetieneOperacion'];

$nombreArchivo = '';

$usuarioid = $_SESSION['usuarioid'];

$stringInvitados = $_POST['inputInvitados'];

$emails = $_POST['emails'];

error_log('invitados:'.$stringInvitados);

$listInvitados = explode(',',$stringInvitados);



$nombreArchivo = '';

if(isset($_FILES['fileAbjunto'])){

	if($_FILES['fileAbjunto']['name'] != ''){

		// error_log($_FILES['fileAbjunto']['name']);

		$Upload = new Upload();

		$Upload->setNombreCampoFile('fileAbjunto');

		if(!$Upload->subirArchivo()){

			regresar($Upload->getMensaje());

			exit();

		}

		$nombreArchivo = $Upload->getNombreArchivo();

	}

}



$soporteId = $Modelo->guardarTicket($prioridad,$departamento,$tipoSoporte,$detieneOperacion,$descripcion,$usuarioid,$nombreArchivo,$asunto,$listInvitados,$emails);

error_log('$soporte:'.$soporteId);

if($soporteId > 0){

	regresar("Se guardó correctamente");

	enviarMail(1,$soporteId);
	header('Location:../');
}

else
{
	regresar('Error al guardar ticket');
}



function regresar($mensajeError){

	header('Location:../');

}

?>
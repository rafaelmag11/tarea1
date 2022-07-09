<?php

define('tmAu347djsa', true);//VARIABLE PARA QUE DEJAR VER CONTENIDO POR REQUIRE

require '../modelos/seguridad.php';

require '../parametros/conexion.php';

session_start();

$Seguridad = new Seguridad;

$usuario = $_POST['usuario'];

$pass = $_POST['pass'];

$resultados = $Seguridad->logueo($usuario,$pass);

$Seguridad->cerrarConexion();

if(count($resultados) > 0){

		$_SESSION['usuarioid'] = $resultados[0]['usuarioid'];

		$_SESSION['nombre'] = $resultados[0]['nombre'].' '.$resultados[0]['paterno'];

		$_SESSION['administrador'] = $resultados[0]['administrador'];

		$_SESSION['mensaje'] = '';

} else{
	$_SESSION['mensaje'] = 'Datos Incorrectos.';
}
header('Location: localhost/tickets/');
?>
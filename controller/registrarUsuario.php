<?php

define('tmAu347djsa', true);//VARIABLE PARA QUE DEJAR VER CONTENIDO POR REQUIRE

require '../modelos/seguridad.php';

require '../parametros/conexion.php';

require '../clases-externas/upload.php';

require '../modelos/usuarios.php';

require 'funcion-correo.php';

require '../clases-externas/Generica.php';



session_start();

$nombre = $_POST['nombre'];

$apaterno = $_POST['apaterno'];

$amaterno = $_SESSION['amaterno'];

$departamentoid = $_POST['selectDepartamento'];

$puesto = $_POST['puesto'];

$emails = $_POST['emails'];

$sstatusid = $_POST['selectEstatus'];

$clave = $_POST['clave'];

$pass = $_POST['pass'];

$administrador = $_POST['selectAdministrador'];

$usuarioid = $_SESSION['usuarioid'];

$Modelo = new Seguridad();

$resultado = $Modelo->guardarUsuario($nombre,$apaterno,$amaterno,$departamentoid,$puesto,$email,$estatusid,$clave,$pass,$administrador);

error_log('$resultado:'.$resultado);

if($resultado > 0){

	regresar("Se guardo correctamente");

	header("Location:../");

}

else

	regresar('Error al guardar ticket');



function regresar($mensajeError){

	echo '<script>alert("'.utf8_decode($mensajeError).'");window.history.back();</script>';

}

?>
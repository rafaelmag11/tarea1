<?php

define('tmAu347djsa', true);//VARIABLE PARA QUE DEJAR VER CONTENIDO POR REQUIRE

require '../modelos/seguridad.php';

require '../parametros/conexion.php';

require '../clases-externas/upload.php';

require '../modelos/usuarios.php';

require '../clases-externas/Generica.php';



session_start();

$Modelo = new Seguridad();


function regresar($mensajeError){

	echo '<script>alert("'.utf8_decode($mensajeError).'");window.history.back();</script>';

}

?>
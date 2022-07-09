<?php
define('tmAu347djsa', true);//VARIABLE PARA QUE DEJAR VER CONTENIDO POR REQUIRE
require '../modelos/seguridad.php';
require '../parametros/conexion.php';
require '../clases-externas/upload.php';
require '../modelos/usuarios.php';
require 'funcion-correo.php';
require '../clases-externas/Generica.php';

session_start();
$ticketid = $_GET['ticketid'];
$comentario = $_POST['comentario'];
$usuarioid = $_SESSION['usuarioid'];

$nombreArchivo = '';
if(isset($_FILES['archivo'])){
	if($_FILES['archivo']['name'] != ''){
		error_log($_FILES['archivo']['name']);
		$Upload = new Upload();
		$Upload->setNombreCampoFile('archivo');
		if(!$Upload->subirArchivo()){
			regresar($Upload->getMensaje());
			exit();
		}
		$nombreArchivo = $Upload->getNombreArchivo();
	}
}
$Modelo = new Seguridad();
$resultado = $Modelo->guardarComentario($ticketid,$comentario,$usuarioid,$nombreArchivo);
if($resultado > 0){
	enviarMail(2,$ticketid);
	echo '1';
}
else
	echo '0';


// //comprobamos que sea una petición ajax
// if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') 
// {
    // //obtenemos el archivo a subir
    // $file = $_FILES['archivo']['name'];
 
     
    // //comprobamos si el archivo ha subido
    // if ($file && move_uploaded_file($_FILES['archivo']['tmp_name'],"../archivos-usuarios/".$file))
    // {
       // echo $file;//devolvemos el nombre del archivo para pintar la imagen
    // }
// }else{
    // throw new Exception("Error Processing Request", 1);   
// }
?>
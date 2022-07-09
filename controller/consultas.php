<?php

define('tmAu347djsa', true);//VARIABLE PARA QUE DEJAR VER CONTENIDO POR REQUIRE

require '../modelos/seguridad.php';

require '../modelos/usuarios.php';

require '../parametros/conexion.php';

require '../parametros/seguridad.php';

require 'funcion-correo.php';

require '../clases-externas/Generica.php';



if(!isset($_GET['opcion'])){

	echo 'ACCESO RESTRINGUIDO';

	exit();

}

session_start();

if(comprobarLogueo() == FALSE){

	echo 'ACCESO RESTRINGUIDO X';

	exit();

}

$opcion = $_GET['opcion'];

$Seguridad = new Seguridad;

$resultados = array();

$carpetaActual = 'soporte-';



if($opcion == 1){//######################  CONSULTAR COMENTARIOS  ##########################

	$ticketid = $_POST['ticketid'];

	$resultados = $Seguridad->consultarComentariosTicket($ticketid);

}

elseif($opcion == 2){//######################  TIPOS APLICATIVOS  ##########################

	$tipoSoporteid = $_POST['tipoSoporteid'];

	$resultados = $Seguridad->consultarTipoAplicativo($tipoSoporteid);

}

elseif($opcion == 3){//######################  GUARDAR TICKET  ##########################

	$tipoTicket = $_POST['tipoTicket'];

	$tipoSoporte = $_POST['tipoSoporte'];

	$tipoAplicativo = $_POST['tipoAplicativo'];

	$detieneOperacion = $_POST['detieneOperacion'];

	$descripcion = $_POST['descripcion'];

	$usuarioid = $_SESSION['usuarioid'];

	$resultado = $Seguridad->guardarTicket($tipoTicket,$tipoSoporte,$tipoAplicativo,$detieneOperacion,$descripcion,$usuarioid);

	

	if($resultado > 0){

		$ticketid = $resultado;
		$pass = '';

		pclose(popen('cd /var/www/soporte/controller; php correo.php ' . $pass . '  1 '.$ticketid, 'r'));

		$resultado = 1;

	}

	

	array_push($resultados,array('numeroAfectados' => $resultado));

}

elseif($opcion == 4){//######################  GUARDAR Comentario  ##########################

	$ticketid = $_POST['ticketid'];

	$comentario = $_POST['comentario'];

	$usuarioid = $_SESSION['usuarioid'];

	$resultado = $Seguridad->guardarComentario($ticketid,$comentario,$usuarioid,'');

	

	if($resultado == 1){

		enviarMail(2,$ticketid);

		//pclose(popen('cd /var/www/soporte/controller; php correo.php u47r21HD378Jd63j51 2 '.$ticketid, 'r'));

		//pclose(popen('php C:\\xampp\htdocs\soporte\controller\correo.php u47r21HD378Jd63j51 2 '.$ticketid, 'r'));

	}

	

	array_push($resultados,array('numeroAfectados' => $resultado));

}

elseif($opcion == 5){//######################  CONSULTAR TICKETS  ##########################

	$usuarioid = $_SESSION['usuarioid'];

	$estatusid = $_POST['estatusid'];

	$resultados = $Seguridad->consultarTickets($usuarioid, $estatusid);

}

elseif($opcion == 6){//######################  Consultar estatus  ##########################

	$resultados = $Seguridad->consultarEstatus();

}

elseif($opcion == 7){//######################  CAMBIAR ESTATUS TICKET  ##########################

	$ticketid = $_POST['ticketid'];

	$estatusid = $_POST['estatusid'];

	$usuarioid = $_SESSION['usuarioid'];

	$resultado = $Seguridad->cambiarEstatusTicket($ticketid,$estatusid,$usuarioid);

	array_push($resultados,array('numeroAfectados' => $resultado));

}

elseif($opcion == 8){//######################  CONSULTAR NUEVOS TICKETS  ##########################

	$ticketid = $_POST['ticketid'];

	$usuarioid = $_SESSION['usuarioid'];

	$resultado = $Seguridad->consultarNuevosTickets($ticketid,$usuarioid);

	array_push($resultados,array('countNuevos' => $resultado));

}

elseif($opcion == 9){//######################  CAMBIAR CONTRASEÑA  ##########################

	$pass = $_POST['pass'];

	$usuarioid = $_SESSION['usuarioid'];

	$Usuarios = new Usuarios();

	$resultado = $Usuarios->cambiarPass($usuarioid, $pass);

	array_push($resultados,array('numeroAfectados' => $resultado));

}

elseif($opcion == 10){//######################  GUARDAR CALIFICACION  ##########################

	$ticketid = $_POST['ticketid'];

	$calificacion = $_POST['calificacion'];

	$resultado = $Seguridad->guardarCalificacion($ticketid, $calificacion);

	array_push($resultados,array('numeroAfectados' => $resultado));

}

elseif($opcion == 11){//######################  USUARIOS RESPONSABLES DE APLICATIVOS  ##########################

	$aplicativoid = $_POST['aplicativoid'];

	$resultados = $Seguridad->consultarUsuariosAplicativo($aplicativoid);

}

elseif($opcion == 12){//######################  LISTA USUARIOS  ##########################

	$textoBusqueda = $_POST['textoBusqueda'];

	$tipoTicket = $_POST['tipoTicket'];

	$usuarioBusca = $_SESSION['usuarioid'];

	$UsuariosModelo = new Usuarios();

	$resultados = $UsuariosModelo->buscarCoincidencias($textoBusqueda,$tipoTicket,$usuarioBusca);

}

elseif($opcion == 13){//######################  CONSULTAR DETALLE COMPLETO DEL TICKET  ##########################

	$soporteid = $_POST['soporteid'];

	$datosTicket = array();

	$datosTicket = $Seguridad->consultarTicketPorNumero($soporteid);

	$comentarios = array();

	$comentarios = $Seguridad->consultarComentariosTicket($soporteid);

	$responsables = array();

	$responsables = $Seguridad->consultarUsuariosAplicativo($datosTicket[0]['aplicativoid']);

	$invitadosTicket = array();

	$invitadosTicket = $Seguridad->invitadosTicket($soporteid);

	print '{"detalle":'.json_encode($datosTicket).',"comentarios":'.json_encode($comentarios)

		.',"responsables":'.json_encode($responsables).',"invitados":'.json_encode($invitadosTicket).'}';

	exit();

}

elseif($opcion == 14){//######################  CANCELAR TICKET  ##########################

	$soporteid = $_POST['soporteid'];

	$comentario = $_POST['comentario'];

	$usuarioid = $_SESSION['usuarioid'];

	$resultado = $Seguridad->guardarComentario($soporteid,$comentario,$usuarioid,'');

	if($resultado == 1){

		$resultado = $Seguridad->cambiarEstatusTicket($soporteid,4,$usuarioid);

		if($resultado == 1){

			enviarMail(2,$soporteid);

		}

	}

	array_push($resultados,array('numeroAfectados' => $resultado));

}

elseif($opcion == 15){

	$estatusid = $_POST['estatusid'];

	$usuarioid = $_SESSION['usuarioid'];
	
	$resultados = $Seguridad->consultarTicketUsuario($usuarioid,$estatusid);

}

elseif($opcion == 16){//######################  FINALIZAR TICKET  ##########################

	$soporteid = $_POST['soporteid'];

	$comentario = $_POST['comentario'];

	$usuarioid = $_SESSION['usuarioid'];

	$resultado = $Seguridad->guardarComentario($soporteid,$comentario,$usuarioid,'');

	if($resultado == 1){

		$resultado = $Seguridad->cambiarEstatusTicket($soporteid,3,$usuarioid);

		if($resultado == 1){

			enviarMail(2,$soporteid);

		}

	}

	array_push($resultados,array('numeroAfectados' => $resultado));

}

elseif($opcion == 17){//######################  TICKET EN ATENCION  ##########################

	$soporteid = $_POST['soporteid'];

	$comentario = $_POST['comentario'];

	$usuarioid = $_SESSION['usuarioid'];

	$resultado = $Seguridad->guardarComentario($soporteid,$comentario,$usuarioid,'');

	if($resultado == 1){

		$resultado = $Seguridad->cambiarEstatusTicket($soporteid,2,$usuarioid);

		if($resultado == 1){

			enviarMail(2,$soporteid);

		}

	}

	array_push($resultados,array('numeroAfectados' => $resultado));

}

elseif ($opcion == 18) {//######################  AGREGAR USUARIO  ##########################

	$nombre = $_POST['nombre'];

	$apaterno = $_POST['apaterno'];

	$amaterno = $_POST['amaterno'];

	$departamentoid = $_POST['departamentoid'];

	$puesto = $_POST['puesto'];

	$emails = $_POST['email'];

	$estatusid = $_POST['estatusid'];

	$clave = $_POST['clave'];

	$pass = $_POST['pass'];

	$administrador = $_POST['administrador'];

	$resultado = $Seguridad->guardarUsuario($nombre,$apaterno,$amaterno,$departamentoid,$puesto,$emails,$estatusid,$clave,$pass,$administrador);

	array_push($resultados,array('numeroAfectados' => $resultado));
}

elseif ($opcion == 19){//######################  AGREGAR AREA  ##########################

	$descripcion = $_POST['descripcion'];

	$resultado = $Seguridad->guardarArea($descripcion);

	array_push($resultados,array('numeroAfectados' => $resultado));
}

elseif ($opcion == 20){//######################  GUARDAR PROYECTO  ##########################

	$descripcion = $_POST['descripcion'];

	$tiposoporteid = $_POST['tiposoporteid'];

	$resultado = $Seguridad->guardarAplicacion($descripcion,$tiposoporteid);

	array_push($resultados,array('numeroAfectados' => $resultado));
}

elseif ($opcion == 21){//######################  CONSULTAR POR ID AREA  ##########################

	$departamentoid =$_POST['departamentoid'];

	$resultado = $Seguridad->consultarIdDepartamento($departamentoid);

	array_push($resultados,array('numeroAfectados' => $resultado));
}

elseif ($opcion == 22){//######################  MODIFICAR AREA  ##########################

	$departamentoid = $_POST['departamentoid'];

	$descripcion = $_POST['descripcion'];

	$resultado = $Seguridad->guardarModificacionDep($departamentoid, $descripcion);

	array_push($resultados,array('numeroAfectados' => $resultado));
}

elseif ($opcion == 23){//######################  CONSULTAR POR ID PROYECTO  ##########################

	$aplicativosid = $_POST['aplicativosid'];

	$resultado = $Seguridad->consultarIdAplicativos($aplicativosid);

	array_push($resultados,array('numeroAfectados' => $resultado));
}

elseif ($opcion == 24){//######################  MODIFICAR PROYECTO  ##########################

	$aplicativosid = $_POST['aplicativosid'];

	$descripcion = $_POST['descripcion'];

	$tiposoporteid = $_POST['tiposoporteid'];

	$resultado = $Seguridad->guardarModificacionApp($aplicativosid, $descripcion, $tiposoporteid);

	array_push($resultados,array('numeroAfectados' => $resultado));
}

elseif ($opcion == 25){//######################  ELIMINAR AREA  ##########################

	$departamentoid = $_POST['departamentoid'];

	$resultado = $Seguridad->eliminarDep($departamentoid);

	array_push($resultados,array('numeroAfectados' => $resultado));
}

elseif ($opcion == 26){//######################  ELIMINAR PROYECTO  ##########################

	$aplicativosid = $_POST['aplicativosid'];

	$resultado = $Seguridad->eliminarApp($aplicativosid);

	array_push($resultados,array('numeroAfectados' => $resultado));
}

elseif ($opcion == 27){//######################  CONSULTA POR ID USUARIO  ##########################

	$usuarioid = $_POST['usuarioid'];

	$resultado = $Seguridad->consultarIdUsuario($usuarioid);

	array_push($resultados,array('numeroAfectados' => $resultado));
}

elseif ($opcion == 28) {//######################  AGREGAR APLICATIVOS USUARIOS  ##########################

	$nombre = $_POST['nombre'];

	$apaterno = $_POST['apaterno'];

	$amaterno = $_POST['amaterno'];

	$departamentoid = $_POST['departamentoid'];

	$puesto = $_POST['puesto'];

	$emails = $_POST['email'];

	$estatusid = $_POST['estatusid'];

	$clave = $_POST['clave'];

	$pass = $_POST['pass'];

	$administrador = $_POST['administrador'];

	$tipoAplicativo = $_POST['tipoAplicativo'];

	$resultado = $Seguridad->guardarAplicativosUsuario($nombre,$apaterno,$amaterno,$departamentoid,$puesto,$emails,$estatusid,$clave,$pass,$administrador,$tipoAplicativo);

	array_push($resultados,array('numeroAfectados' => $resultado));
}

elseif ($opcion == 29){//######################  CONSULTAR CORREO DE USUARIO  ##########################

	$usuarioid = $_POST['usuarioid'];

	$resultado = $Seguridad->consultarCorreo($usuarioid);

	array_push($resultados,array('numeroAfectados' => $resultado));
}

elseif ($opcion == 30){//######################  CONSULTAR CORREO DE USUARIO  ##########################

	$usuarioid = $_POST['usuarioid'];

	$email = $_POST['email'];

	$resultado = $Seguridad->guardarModificacionCorreo($usuarioid, $email);

	array_push($resultados,array('numeroAfectados' => $resultado));
}

elseif ($opcion == 31){//######################  MODIFICAR USUARIOS Y APLICATIVOS  ##########################

	$usuarioid = $_POST['usuarioid'];

	$nombre = $_POST['nombre'];

	$apaterno = $_POST['apaterno'];

	$amaterno = $_POST['amaterno'];

	$departamentoid = $_POST['departamentoid'];

	$puesto = $_POST['puesto'];

	$emails = $_POST['email'];

	$estatusid = $_POST['estatusid'];

	$clave = $_POST['clave'];

	$tipoAplicativo = $_POST['tipoAplicativo'];

	$resultado = $Seguridad->guardarModificacionAplicativosUser($usuarioid, $nombre,$apaterno,$amaterno,$departamentoid,$puesto,$emails,$estatusid,$clave,$tipoAplicativo);

	array_push($resultados,array('numeroAfectados' => $resultado));
}

elseif ($opcion == 32){//######################  MODIFICAR USUARIOS  ##########################

	$usuarioid = $_POST['usuarioid'];

	$nombre = $_POST['nombre'];

	$apaterno = $_POST['apaterno'];

	$amaterno = $_POST['amaterno'];

	$departamentoid = $_POST['departamentoid'];

	$puesto = $_POST['puesto'];

	$emails = $_POST['email'];

	$estatusid = $_POST['estatusid'];

	$clave = $_POST['clave'];

	$resultado = $Seguridad->guardarModificacionUser($usuarioid, $nombre,$apaterno,$amaterno,$departamentoid,$puesto,$emails,$estatusid,$clave);

	array_push($resultados,array('numeroAfectados' => $resultado));
}

elseif ($opcion == 33){//######################  CONSULTA APLICATIVOS POR ID USUARIO  ##########################

	$usuarioid = $_POST['usuarioid'];

	$resultado = $Seguridad->consultarAplicativosIdUsuario($usuarioid);

	array_push($resultados,array('numeroAfectados' => $resultado));
}

elseif ($opcion == 34){//######################  MODIFICAR APLICATIVOS USUARIOS  ##########################

	$usuarioid = $_POST['usuarioid'];

	$nombre = $_POST['nombre'];

	$apaterno = $_POST['apaterno'];

	$amaterno = $_POST['amaterno'];

	$departamentoid = $_POST['departamentoid'];

	$puesto = $_POST['puesto'];

	$emails = $_POST['email'];

	$estatusid = $_POST['estatusid'];

	$clave = $_POST['clave'];

	$aplicativoid = $_POST['aplicativoid'];

	$resultado = $Seguridad->guardarModificacionAplicativosUser($usuarioid, $nombre,$apaterno,$amaterno,$departamentoid,$puesto,$emails,$estatusid,$clave,$aplicativoid);

	array_push($resultados,array('numeroAfectados' => $resultado));
}

elseif($opcion == 35){//######################  CONSULTAR POR TIPO SOPORTE AL INICIAR SESIÓN  ##########################

	$usuarioid = $_SESSION['usuarioid'];

	$resultados = $Seguridad->consultarAplicativosIdUsuario2($usuarioid);
}

print '{"resultados":'.json_encode($resultados).'}';

?>
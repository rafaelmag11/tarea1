<?php

error_log('entro en correo.php');

$pass = $argv[1];

$tipoCorreo = $argv[2];

$noTicket = $argv[3];

if($pass != '')exit();

$tituloHtml = '';

$contenidoHtml = '';

$correoDestinatario = '';



require '../parametros/conexion.php';

require '../modelos/seguridad.php';

require '../modelos/usuarios.php';

$Ticket = new Seguridad();



if($tipoCorreo == 1){

	$tituloHtml = 'Ticket registrado con No. '.$noTicket;

	$datosTicket = $Ticket->consultarTicketPorNumero($noTicket);

	$Usuarios = new Usuarios();

	$correosDestino = $Usuarios->usuariosDestinoAplicativos($datosTicket[0]['aplicativoid']);

	

	$correoDestinatario = $datosTicket[0]['email'];

	$contenidoHtml .= '<p><b>Tipo de soporte:</b> '.utf8_decode($datosTicket[0]['aplicativo']).'</p>';

	$contenidoHtml .= '<p><b>Usuario:</b> '.utf8_decode($datosTicket[0]['nombre'].' '.$datosTicket[0]['paterno'].' '.$datosTicket[0]['materno']).'</p>';

	$contenidoHtml .= '<p><b>Problema Reportado:</b> '.utf8_decode($datosTicket[0]['descripcion']).'</p>';

	$contenidoHtml .= '<p><b>Estatus:</b> '.utf8_decode($datosTicket[0]['estatus']).'</p><hr>';

}

elseif($tipoCorreo == 2){

	$tituloHtml = 'Seguimiento a su ticket No. '.$noTicket;

	$datosTicket = $Ticket->consultarTicketPorNumero($noTicket);

	$comentarios = $Ticket->consultarComentariosTicket($noTicket);

	$Usuarios = new Usuarios();

	$correosDestino = $Usuarios->usuariosDestinoAplicativos($datosTicket[0]['aplicativoid']);

	

	$correoDestinatario = $datosTicket[0]['email'];

	$contenidoHtml .= '<p><b>Tipo de soporte:</b> '.utf8_decode($datosTicket[0]['aplicativo']).'</p>';

	$contenidoHtml .= '<p><b>Usuario:</b> '.utf8_decode($datosTicket[0]['nombre'].' '.$datosTicket[0]['paterno'].' '.$datosTicket[0]['materno']).'</p>';

	$contenidoHtml .= '<p><b>Problema Reportado:</b> '.utf8_decode($datosTicket[0]['descripcion']).'</p>';

	$contenidoHtml .= '<p><b>Estatus:</b> '.utf8_decode($datosTicket[0]['estatus']).'</p><hr>';

	

	$contenidoHtml .= '<p><b>Comentarios Agregados</b></p><table align="center"><tr><th>Fecha</th><th>Comentario</th><th>Coment&oacute;</th></tr>';

	$primero = TRUE;

	for($i=0; $i<count($comentarios); $i++){

		if($primero){

			$contenidoHtml .= '<tr><td><i>'.$comentarios[$i]['fecha'].'</i> </td><td> <b>'.utf8_decode($comentarios[$i]['comentario']).'</b> </td>

							   <td> <i>'.$comentarios[$i]['nombre'].' '.$comentarios[$i]['paterno'].'</i></td></tr>';

			$primero = FALSE;

		}else{

			$contenidoHtml .= '<tr><td><i>'.$comentarios[$i]['fecha'].'</i> </td><td> '.utf8_decode($comentarios[$i]['comentario']).' </td>

							   <td> <i>'.$comentarios[$i]['nombre'].' '.$comentarios[$i]['paterno'].'</i></td></tr>';

		}

	}

	$contenidoHtml .= '</table>';

}



$contenidoHtml .= utf8_decode('<p><b>POR FAVOR</b> no respondas a este correo, todos los comentarios y nuevas evidencias agregalas al ticket desde el sistema de Gestión de Ayuda en la opción de comentarios del ticket.</p>');

//error_log('titulo: '.$tituloHtml);

//error_log('contenido: '.$contenidoHtml);



include("../clases-externas/phpmailer/class.phpmailer.php");

$mail = new phpmailer();

$mail->PluginDir = "../clases-externas/phpmailer/";

$mail->Mailer = "smtp";
//$mail->IsSMTP();
//Le indicamos que el servidor smtp requiere autenticación

$mail->SMTPAuth = true;
$mail->SMTPSecure = "ssl";
$mail->IsHTML(true);


$mail->Host = "outlook.office365.com";

// $mail->Port = 465;
$mail->Port = 587;

$mail->Username =  "teksi.pruebas@outlook.com";

$mail->Password = "test123TEST123";



//Indicamos cual es nuestra dirección de correo y el nombre que

//queremos que vea el usuario que lee nuestro correo

$mail->From = "patrickjhonatanh@gmail.com";

$mail->FromName = "MESA DE AYUDA DE TEKSI";



//el valor por defecto 10 de Timeout es un poco escaso dado que voy a usar

//una cuenta gratuita, por tanto lo pongo a 30

$mail->Timeout=20;

//Indicamos cual es la dirección de destino del correo

$email_to_sent = $correoDestinatario;

$mail->AddAddress("$email_to_sent");
$mail->AddCC('patrick.hernandez@teksi.mx');



for($i=0; $i<count($correosDestino); $i++){

// 	error_log($correosDestino[$i]['email']);

	$mail->AddAddress($correosDestino[$i]['email']);

}



// $mail->AddAddress('sistemas4@tecnocor.com', 'Gil Villa');

// $mail->AddAddress('sistemas@tecnocor.com', 'Florencio');

// $mail->AddAddress('sistemas6@tecnocor.com', 'Israel Hdz');

// $mail->AddAddress('sistemas5@tecnocor.com', 'Jorge Gonzalez');



//$mail->AddReplyTo('soporte@tecnocor.com', 'Lista Soporte');

//Asignamos asunto y cuerpo del mensaje

//El cuerpo del mensaje lo ponemos en formato html, haciendo

//que se vea en negrita

$mail->Subject = $tituloHtml;

$mail->Body = $contenidoHtml;

//Definimos AltBody por si el destinatario del correo no admite email con formato html

$mail->AltBody = "Ticket recibido";



//se envia el mensaje, si no ha habido problemas

//la variable $exito tendra el valor true

$exito = $mail->Send();



// error_log($contenidoHtml);



$intentos=1;

while ((!$exito) && ($intentos < 2)){

	$exito = $mail->Send();

	$intentos=$intentos+1;

}



if(!$exito){
	return FALSE;
}
else{
	return TRUE;
}
?>
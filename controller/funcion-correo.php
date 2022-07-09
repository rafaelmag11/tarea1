<?php

function enviarMail($tipoCorreo, $noTicket){

	$Generica = new Generica();

	//return TRUE;

	

	$tituloHtml = '';

	$contenidoHtml = '';

	$correoDestinatario = '';



	$Ticket = new Seguridad();

	$datosTicket = $Ticket->consultarTicketPorNumero($noTicket);

	if($tipoCorreo == 1){



		$tituloHtml = 'No. de Folio: '.$Generica->formatoFolio($datosTicket[0]['usuarioid'],$datosTicket[0]['consecutivo']);

		//$tituloHtml = 'Ticket registrado con No. '.$noTicket;

		$Usuarios = new Usuarios();

		$correosDestino = $Usuarios->usuariosDestinoAplicativos($datosTicket[0]['aplicativoid']);

		

		$correoDestinatario = $datosTicket[0]['email'];

		$contenidoHtml .= '<p><b>Tipo de ticket:</b> '.utf8_decode($datosTicket[0]['aplicativo']).'</p>';

		$contenidoHtml .= '<p><b>Usuario que solicita:</b> '.utf8_decode($datosTicket[0]['nombre'].' '.$datosTicket[0]['paterno'].' '.$datosTicket[0]['materno']).'</p>';

		$contenidoHtml .= '<p><b>Detalle del Ticket:</b> '.utf8_decode($datosTicket[0]['descripcion']).'</p>';

		if($datosTicket[0]['nombreArchivo'] != '') 

			$contenidoHtml .= '<p><b>Archivo Adjunto:</b> <a href="http://teksi.mx/tickets/archivos-usuarios/'.$datosTicket[0]['nombreArchivo'].'" target="_blanck">'.$datosTicket[0]['nombreArchivo'].'</a></p><hr>';

		$contenidoHtml .= '<p><b>Estatus:</b> '.utf8_decode($datosTicket[0]['estatus']).'</p><hr>';

	}

	elseif($tipoCorreo == 2){

		

		//$tituloHtml = 'Seguimiento a su ticket No. '.$noTicket;

		$tituloHtml = 'No. de Folio: '.$Generica->formatoFolio($datosTicket[0]['usuarioid'],$datosTicket[0]['consecutivo']);

		$comentarios = $Ticket->consultarComentariosTicket($noTicket);

		$Usuarios = new Usuarios();

		$correosDestino = $Usuarios->usuariosDestinoAplicativos($datosTicket[0]['aplicativoid']);

		

		$correoDestinatario = $datosTicket[0]['email'];

		$contenidoHtml .= '<p><b>Tipo de ticket:</b> '.utf8_decode($datosTicket[0]['aplicativo']).'</p>';

		$contenidoHtml .= '<p><b>Usuario que solicita:</b> '.utf8_decode($datosTicket[0]['nombre'].' '.$datosTicket[0]['paterno'].' '.$datosTicket[0]['materno']).'</p>';

		$contenidoHtml .= '<p><b>Detalle del Ticket:</b> '.utf8_decode($datosTicket[0]['descripcion']).'</p>';

		if($datosTicket[0]['nombreArchivo'] != '')

			$contenidoHtml .= '<p><b>Archivo Adjunto:</b> <a href="http://teksi.mx/tickets/archivos-usuarios/'.$datosTicket[0]['nombreArchivo'].'" target="_blanck">'.$datosTicket[0]['nombreArchivo'].'</a></p><hr>';

		$contenidoHtml .= '<p><b>Estatus:</b> '.utf8_decode($datosTicket[0]['estatus']).'</p><hr>';



		if($datosTicket[0]['estatusid'] == 3 && $datosTicket[0]['calificacion'] == '')

			$contenidoHtml .= '<font color="#1CAD42"><h3 align="center">��Ingrese al sistema Mesa de Ayuda y califique este ticket!!!</h3></font>';

		

		$contenidoHtml .= '<p><b>Comentarios Agregados</b></p><table align="center"><tr><th>Fecha</th><th>Comentario</th><th>Coment&oacute;</th></tr>';

		$primero = TRUE;

		for($i=0; $i<count($comentarios); $i++){

			$htmlLinkArchivo = '';

			if($comentarios[$i]['nombreArchivo'] != '')

				$htmlLinkArchivo = '<a href="http://teksi.mx/tickets/archivos-usuarios/'.$comentarios[$i]['nombreArchivo'].'" target="_blanck">'.$comentarios[$i]['nombreArchivo'].'</a>';

			if($primero){

				$contenidoHtml .= '<tr><td><i>'.$comentarios[$i]['fecha'].'</i> </td><td> <b>'.utf8_decode($comentarios[$i]['comentario']).'</b><br />'.$htmlLinkArchivo.'</td>

								   <td> <i>'.$comentarios[$i]['nombre'].' '.$comentarios[$i]['paterno'].'</i></td></tr>';

				$primero = FALSE;

			}else{

				$contenidoHtml .= '<tr><td><i>'.$comentarios[$i]['fecha'].'</i> </td><td> '.utf8_decode($comentarios[$i]['comentario']).'<br />'.$htmlLinkArchivo.'</td>

								   <td> <i>'.$comentarios[$i]['nombre'].' '.$comentarios[$i]['paterno'].'</i></td></tr>';

			}

		}

		$contenidoHtml .= '</table>';

	}

	$contenidoHtml .= utf8_decode('<p><b>POR FAVOR</b> no respondas a este correo, todos los comentarios y nuevas evidencias agregalas al ticket desde el sistema de Gesti�n de Ayuda en la opci�n de comentarios del ticket.</p>');



	include("../clases-externas/phpmailer/class.phpmailer.php");

	$mail = new phpmailer();

	$mail->PluginDir = "../clases-externas/phpmailer/";

	$mail->Mailer = "smtp";
    
    $mail->SMTPAuth = true;
	$mail->SMTPSecure = "ssl";
	$mail->IsHTML(true);
	//$mail->Host = "ssl://smtp.gmail.com";
	$mail->Host = "outlook.office365.com";
    
	$mail->Port = 587;

	//Nombre del usuario SMTP
	$mail->Username =  "teksi.pruebas@outlook.com"; 

	//Contrase�a del usuario SMTP
	$mail->Password = "test123TEST123";

	//Indicamos cual es nuestra direcci�n de correo y el nombre que 

	//queremos que vea el usuario que lee nuestro correo

	$mail->From = "teksi.pruebas@outlook.com";

	$mail->FromName = "MESA DE AYUDA";



	//el valor por defecto 10 de Timeout es un poco escaso dado que voy a usar

	//una cuenta gratuita, por tanto lo pongo a 30

	$mail->Timeout=20;

	//Indicamos cual es la direcci�n de destino del correo

	$email_to_sent = $correoDestinatario;

	$mail->AddAddress("patrickjhonatanh@gmail.com");
	$mail->AddCC('patrick.hernandez@teksi.mx');
	// $mail->AddCC('guadalupe.rosas@bocar.com');



	for($i=0; $i<count($correosDestino); $i++) {
		$mail->AddAddress($correosDestino[$i]['email']);
	}

	if($datosTicket[0]['cc'] != "") {
		$arrayCorreos = explode(';',$datosTicket[0]['cc']);
		for($i=0; $i<count($arrayCorreos); $i++) {
			if($arrayCorreos[$i] != "") {
				error_log("cc:".$arrayCorreos[$i]);
				$mail->AddCC($arrayCorreos[$i]);
			}
		}
	}



	//$mail->AddReplyTo('soporte@teksi.com', 'Lista Soporte');

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

}

?>
<?php

$pass = $argv[1];

$correoDestinatario = $argv[2];

$titulo = $argv[3];

$cuerpo = $argv[4].utf8_decode('<p>POR FAVOR NO RESPONDAS ESTE CORREO, todos los comentarios y nuevas evidencias agregalas al ticket desde el sistema de Gestión de Ayuda en la opción de comentarios del ticket.</p>');





if($pass != '')exit();

/*error_log('email: '.$correoDestinatario);

error_log('titulo: '.$titulo);

error_log('cuerpo: '.$cuerpo);*/



	

include("../clases-externas/phpmailer/class.phpmailer.php");

$mail = new phpmailer();

$mail->PluginDir = "../clases-externas/phpmailer/";

$mail->Mailer = "smtp";

//Le indicamos que el servidor smtp requiere autenticación

$mail->SMTPAuth = true;
$mail->SMTPSecure = "ssl";
$mail->IsHTML(true); 

$mail->Host = "outlook.office365.com";

$mail->Port = 587;

//Nombre del usuario SMTP
$mail->Username =  "teksi.pruebas@outlook.com"; 

//Contraseña del usuario SMTP
$mail->Password = "test123TEST123";

//Indicamos cual es nuestra dirección de correo y el nombre que 

//queremos que vea el usuario que lee nuestro correo

$mail->From = "teksi.pruebas@outlook.com";

$mail->FromName = "MESA DE AYUDA";



//el valor por defecto 10 de Timeout es un poco escaso dado que voy a usar 

//una cuenta gratuita, por tanto lo pongo a 30  

$mail->Timeout=10;

//Indicamos cual es la dirección de destino del correo

$email_to_sent = "patrickjhonatanh@gmail.com";
// $email_to_sent = $correoDestinatario;

$mail->AddAddress("$email_to_sent"); 
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


//$mail->AddAddress('sistemas4@tecnocor.com', 'Gil Villa');

//$mail->AddAddress('sistemas@tecnocor.com', 'Florencio');

//$mail->AddAddress('sistemas6@tecnocor.com', 'Israel Hdz');

//$mail->AddAddress('sistemas5@tecnocor.com', 'Jorge Gonzalez');

//Asignamos asunto y cuerpo del mensaje

//El cuerpo del mensaje lo ponemos en formato html, haciendo 

//que se vea en negrita

$mail->Subject = $titulo;

$mail->Body = $cuerpo;

//Definimos AltBody por si el destinatario del correo no admite email con formato html 

$mail->AltBody = "Ticket recibido";

 

//se envia el mensaje, si no ha habido problemas 

//la variable $exito tendra el valor true

$exito = $mail->Send();



$intentos=1; 

while ((!$exito) && ($intentos < 2)){

	//sleep(2);

	//echo $mail->ErrorInfo;

	$exito = $mail->Send();

	$intentos=$intentos+1;

}

error_log('finalizo');

 

if(!$exito){
	return FALSE;

}

else{

	return TRUE;

}

?>
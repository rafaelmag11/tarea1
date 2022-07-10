<?php

if(!defined('tmAu347djsa')) exit;

date_default_timezone_set("America/Mexico_City");

$conexion = mysql_connect("localhost", "reauve2013", "IShe683-A");

mysql_select_db("reauve2013-2", $conexion);

mysql_query("SET NAMES 'utf8'");

$password = '.D,-sDFI,A.FKBNS2sf-.7a,d1a8DF,-Vndm1G8S.-3';



function enviarMail($lectura_roboid,$opcion){

	$pass = '';

	pclose(popen('C:\xampp\htdocs\reauve\webservices\psexec -d C:\xampp\php\php.exe C:\xampp\htdocs\reauve\parametros\mail.php '.

		$lectura_roboid. $pass .$opcion.' > result.txt 2> error.log' , 'r'));

}

?>
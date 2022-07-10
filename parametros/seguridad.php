<?php

if(!defined('tmAu347djsa')) exit;

function comprobarLogueo(){

	if(isset($_SESSION['usuarioid'])){

		if($_SESSION['usuarioid'] != '')

			return TRUE;

	}

	return FALSE;

}

function comprobarPermiso($permiso){

	$consulta = 'SELECT permisoid FROM usuarios_permisos WHERE usuario="'.$_SESSION['usuario'].'" and permisoid='.$permiso;

	$resultado = mysql_query($consulta);

	if(mysql_num_rows($resultado) == 1)

		return TRUE;

	require 'vistas/opcion_no_permitida.php';

}

?>
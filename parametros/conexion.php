<?php
function conexionBD(){
    // $servidor   = '192.168.1.10';
    // $nombreBD   = 'aabascul_soporte';
    // $usuario    = 'admin';
    // $contrasena = '123456';

    //$servidor   = 'teksi.mx';
    $servidor   = 'localhost';
    $nombreBD   = 'teksimx_mesaayuda';
    //$nombreBD   = 'teksimx_mesa_ayuda';
    //$usuario    = 'teksimx_mesAyuda';
    $usuario    = 'root';
    //$usuario    = 'teksimx_control';
    //$contrasena = 'control_2018';
    $contrasena = '';
    //$contrasena = 'control2014';
    $conexion = new mysqli($servidor,$usuario,$contrasena,$nombreBD);
    if($conexion->connect_error){
        die('Error en la conexion : '.$conexion->connect_errno.'-'.$conexion->connect_error);
    }
    if (!$conexion->set_charset("utf8")) {
        printf("Error cargando el conjunto de caracteres utf8: %s\n", $conexion->error);
    }
    return $conexion;
}
?>
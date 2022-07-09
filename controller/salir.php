<?php
session_start();
$_SESSION['usuario'] = '';
$_SESSION['nombre'] = '';
session_unset();
session_destroy();
header('location: ../');
?>
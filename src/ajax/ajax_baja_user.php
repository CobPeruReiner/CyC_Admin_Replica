<?php
date_default_timezone_set('America/Lima');
$responce	= new stdClass();
$responce->codigo = 0;
$responce->mensaje = 'Baja';


if (isset($_REQUEST)) {
	require_once("../php/clsUsuario.php");
	session_start();
	if (!isset($_SESSION['id_ls']) || !isset($_SESSION['user_ls']) || !isset($_SESSION['nombre_ls'])) {
		$responce->codigo = 2;
		$responce->mensaje = 'Se ha agotado el tiempo de conexión. Inicie Sesión';
	} else {
		$verificar = clsUsuario::verificar_sesion($_SESSION['id_ls'], $_SESSION['user_ls']);
		if (sizeof($verificar) == 0) {
			$responce->codigo = 3;
			$responce->mensaje = 'Usuario no válido, Inicie Sesión';
		} else {
			$responce->codigo = 1;
			clsUsuario::baja_user($_REQUEST['id'], $_SESSION['id_ls']);
		}
	}
}

echo json_encode($responce);

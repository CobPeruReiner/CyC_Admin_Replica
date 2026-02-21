<?php
date_default_timezone_set('America/Lima');
$responce	= new stdClass();
$responce->codigo = 0;
$responce->mensaje = 'Registrado';


if (isset($_REQUEST)) {
	require_once("../php/clsUsuario.php");
	require_once("../php/clsProject.php");
	session_start();
	if (!isset($_SESSION['id_ls']) || !isset($_SESSION['user_ls']) || !isset($_SESSION['nombre_ls'])) {
		$responce->codigo = 2;
		$responce->mensaje = 'Se ha agotado el tiempo de conexión. Inicie Sesión';
	}else{
		$verificar=clsUsuario::verificar_sesion($_SESSION['id_ls'],$_SESSION['user_ls']);
		if (sizeof($verificar)==0){
			$responce->codigo = 3;
			$responce->mensaje = 'Usuario no válido, Inicie Sesión';
		}else{
			$responce->codigo = 1;
			$rpta =clsProject::registrar(utf8_decode($_REQUEST['consulting']),$_REQUEST['cliente'],$_REQUEST['fecha_inicio'],$_REQUEST['fecha_fin'],utf8_decode($_REQUEST['normas']),$_REQUEST['plazo'],$_REQUEST['auditor']);
			if ($rpta>0) {
				if (isset($_REQUEST['plazo'])){
					for ($i = 1; $i <= 69; $i++) {
						clsProject::registrar_elemento($i,$rpta);
					}
				}
			}
		}
	}
}

echo json_encode($responce);
?>



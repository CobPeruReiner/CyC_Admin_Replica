<?php
$responce = new stdClass();
$responce->codigo = 0;
if (isset($_REQUEST)) {
	require_once("../php/clsUsuario.php");
	require_once("../php/clsDashboard.php");
	session_start();
	$arr_datos = clsDashboard::dashboard($_SESSION['id_ls']);
	$arr_datos1 = clsDashboard::contadores();
	$arr_datos2 = clsDashboard::logeos_hh();
	//$arr_datos0 = clsDashboard::ultimos_ficheros();

	$responce->arr_datos = $arr_datos;
	$responce->arr_datos1 = $arr_datos1;
	$responce->arr_datos2 = $arr_datos2;
	//$responce->arr_datos0 = $arr_datos0;
	
	$responce->codigo = 1;
}

echo json_encode($responce);
?>
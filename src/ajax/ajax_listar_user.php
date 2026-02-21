<?php
// $responce	= new stdClass();
// $responce->codigo = 0;
// if (isset($_REQUEST)) {
// 	require_once("../php/clsUsuario.php");
// 	session_start();
// 	$arr_datos = clsUsuario::listar_user();
// 	if (sizeof($arr_datos)>0) {
// 		$responce->codigo = 1;
// 		$responce->arr_datos = $arr_datos;
// 	}else{
// 		$responce->mensaje='No se encontraron registros de usuario(s)';
// 	}
// }
// echo json_encode($responce);
session_start();
require_once("../php/clsUsuario.php");

$responce = new stdClass();
$responce->codigo = 0;

$arr_datos = clsUsuario::listar_user();
if (!empty($arr_datos)) {
	$responce->codigo   = 1;
	$responce->arr_datos = $arr_datos;
} else {
	$responce->mensaje = 'No se encontraron registros de usuario(s)';
}

// Envía JSON limpio (sin \uXXXX ni \/)
header('Content-Type: application/json; charset=utf-8');
echo json_encode($responce, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
exit;

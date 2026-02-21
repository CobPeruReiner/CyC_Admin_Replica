<?php
$responce	= new stdClass();
$responce->codigo = 0;
if (isset($_REQUEST)) {
	require_once("../php/clsSector.php");
	session_start();
	$arr_datos = clsSector::listar_sector();
	if (sizeof($arr_datos)>0) {
		$responce->codigo = 1;
		$responce->arr_datos = $arr_datos;
	}else{
		$responce->mensaje='No se encontraron registros de sectore(s)';
	}
}
echo json_encode($responce);
?>
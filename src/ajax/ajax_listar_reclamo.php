<?php
$responce	= new stdClass();
$responce->codigo = 0;
if (isset($_REQUEST)) {
	require_once("../php/clsContacto.php");
	session_start();
	$arr_datos = clsContacto::listar_reclamos();
	if (sizeof($arr_datos)>0) {
		$responce->codigo = 1;
		$responce->arr_datos = $arr_datos;
	}else{
		$responce->mensaje='No se encontraron registros de reclamo(s)';
	}
}
echo json_encode($responce);
?>
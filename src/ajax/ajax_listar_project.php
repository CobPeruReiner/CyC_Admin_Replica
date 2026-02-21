<?php
$responce	= new stdClass();
$responce->codigo = 0;
if (isset($_REQUEST)) {
	require_once("../php/clsProject.php");
	session_start();
	$arr_datos = clsProject::listar_project();
	if (sizeof($arr_datos)>0) {
		$responce->codigo = 1;
		$responce->arr_datos = $arr_datos;
	}else{
		$responce->mensaje='No se encontraron registros de proyecto(s)';
	}
}
echo json_encode($responce);
?>
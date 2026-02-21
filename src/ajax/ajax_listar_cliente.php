<?php
$responce	= new stdClass();
$responce->codigo = 0;
if (isset($_REQUEST)) {
	require_once("../php/clsCliente.php");
	session_start();
	$arr_datos = clsCliente::listar_clientes();
	if (sizeof($arr_datos)>0) {
		$responce->codigo = 1;
		$responce->arr_datos = $arr_datos;
	}else{
		$responce->mensaje='No se encontraron registros de cliente(s)';
	}
}
echo json_encode($responce);
?>
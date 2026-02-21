<?php
$responce = new stdClass();
$responce->codigo = 0;
if (isset($_REQUEST)) {
	require_once("../php/clsUsuario.php");
	session_start();
	$arr_datos = clsUsuario::listar_user_online();
	$arr_datos2 = clsUsuario::verificar_sesion($_SESSION['id_ls']);
	//$arr_datos3 = clsUsuario::dashboard($_SESSION['id_ls']);
	
	if (sizeof($arr_datos2)>0){
		if (sizeof($arr_datos)>0) {
			$responce->codigo = 1;
			$responce->arr_datos = $arr_datos;
			//$responce->arr_datos3 = $arr_datos3;
		}else{
			$responce->mensaje='No se encontraron usuario(s) online';
		}
	}else{
		$responce->codigo = 2;
		$responce->mensaje='Inicie sesión para navegar';
		unset($_SESSION["nombre_ls"]); 
		unset($_SESSION["tipo_ls"]);
		unset($_SESSION["user_ls"]);
		unset($_SESSION["id_ls"]);
		session_unset();  
	}
}
echo json_encode($responce);
?>
<?php
$responce	= new stdClass();
$responce->codigo = 0;
if (isset($_REQUEST)) {
	
	require_once("../php/clsUsuario.php");
	//echo json_encode($_REQUEST);
	$arr_datos = clsUsuario::acceso($_REQUEST['username'],$_REQUEST['password']);
	//var_dump($arr_datos);
	
	if (sizeof($arr_datos)==1) {
		$responce->codigo = 1;
		session_start();
		$_SESSION['nombre_ls']=$arr_datos[0]['empleado'];
		$_SESSION['tipo_ls']=$arr_datos[0]['tipo'];
		$_SESSION['user_ls']=$arr_datos[0]['usuario'];
		$_SESSION['id_ls']=$arr_datos[0]['idpersonal'];
		$responce->valida_user = $_SESSION['tipo_ls'];
		
		$verificar=clsUsuario::verificar_logeo($_SESSION['id_ls'],'IN');
		if (sizeof($verificar)==0){
			clsUsuario::registrar_user_in($_SESSION['id_ls']);
		}
	}
}
echo json_encode($responce);
?>
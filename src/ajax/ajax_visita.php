<?php
date_default_timezone_set('America/Lima');
$responce	= new stdClass();
$responce->codigo = 0;
$responce->mensaje = 'Registrado';

if (isset($_REQUEST)) {
	require_once("../php/clsUsuario.php");
	require_once("../php/clsVisita.php");
	session_start();
	if (!isset($_SESSION['id_ls']) || !isset($_SESSION['user_ls']) || !isset($_SESSION['nombre_ls'])) {
		$responce->codigo = 2;
		$responce->mensaje = 'Se ha agotado el tiempo de conexión. Inicie Sesión';
	}else{

		$verificar=clsUsuario::verificar_sesion($_SESSION['id_ls']);
		if (sizeof($verificar)==0){
			$responce->codigo = 3;
			$responce->mensaje = 'Usuario no válido, Inicie Sesión';
		}else {
			if ($_REQUEST['valida']==1){
				$responce->codigo = 1;
				$responce->mensaje = 'Registrar Visita';
				clsVisita::registrar_visita($_SESSION['id_ls'],$_REQUEST['edificio']);
			}else if($_REQUEST['valida']==2 ){
			    $responce->codigo = 1;
			    $fecha=date("Y-m-d H:i:s");
		        $responce->mensaje = 'Registrar Bitacora';
				clsVisita::update_contacto(utf8_decode($_REQUEST['observacion']),$_SESSION['id_ls'],$_REQUEST['id'],$fecha);
				clsVisita::registrar_bitacora($_REQUEST['id'],utf8_decode($_REQUEST['observacion']),$_SESSION['id_ls'],$fecha);
			}else if($_REQUEST['valida']==3 ){
		    	$arr_datos = clsVisita::listar_bitacora($_REQUEST['id']);
            	if (sizeof($arr_datos)>0) {
            		$responce->codigo = 1;
            		$responce->arr_datos = $arr_datos;
            	}else{
            		$responce->mensaje='No se encontraron registros de bitacora';
            	}
			}else if($_REQUEST['valida']==4 ){
			   $arr_datos = clsVisita::listar();
            	if (sizeof($arr_datos)>0) {
            		$responce->codigo = 1;
            		$responce->arr_datos = $arr_datos;
            	}else{
            		$responce->mensaje='No se encontraron registros de visita(s)';
            	}

			}else{
				$responce->codigo = 1;
				$responce->mensaje = 'Eliminado';
				clsVisita::baja($_REQUEST['id']);
			}

		}
	}
}
echo json_encode($responce);
?>



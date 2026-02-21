<?php
date_default_timezone_set('America/Lima');
$responce	= new stdClass();
$responce->codigo = 0;
$responce->mensaje = 'Error';

if (isset($_REQUEST)) {
	require_once("../php/clsUsuario.php");
	require_once("../php/clsMapa.php");
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
			if ($_REQUEST['control']==1){
				$responce->codigo = 1;
				$responce->mensaje = 'Mapa Registrado';
				
				clsMapa::registrar(utf8_decode($_REQUEST['cartera']),utf8_decode($_REQUEST['identificador']),utf8_decode($_REQUEST['dato1']),utf8_decode($_REQUEST['dato2']),utf8_decode($_REQUEST['dato3']),utf8_decode($_REQUEST['dato4']),utf8_decode($_REQUEST['dato5']),utf8_decode($_REQUEST['dato6']),utf8_decode($_REQUEST['dato7']),utf8_decode($_REQUEST['dato8']),utf8_decode($_REQUEST['dato9']),utf8_decode($_REQUEST['dato10']));
			  
			}else if($_REQUEST['control']==2 ){
		    	$arr_datos = clsMapa::listar();
            	if (sizeof($arr_datos)>0) {
            		$responce->codigo = 1;
            		$responce->arr_datos = $arr_datos;
            		$responce->mensaje='Listado Mapa';
            	}else{
            		$responce->mensaje='No se encontraron registros';
            	}
			}else if($_REQUEST['control']==3 ){
			    
			    if (isset($_REQUEST['id'])){
			        $responce->codigo = 1;
				
		    	    clsMapa::update($_REQUEST['id'],utf8_decode($_REQUEST['cartera']),utf8_decode($_REQUEST['identificador']),utf8_decode($_REQUEST['dato1']),utf8_decode($_REQUEST['dato2']),utf8_decode($_REQUEST['dato3']),utf8_decode($_REQUEST['dato4']),utf8_decode($_REQUEST['dato5']),utf8_decode($_REQUEST['dato6']),utf8_decode($_REQUEST['dato7']),utf8_decode($_REQUEST['dato8']),utf8_decode($_REQUEST['dato9']),utf8_decode($_REQUEST['dato10']),$_REQUEST['estado']);
		    	    $responce->mensaje='Actualizar Mapa';
			    }
			}else{
				$responce->codigo = 1;
				$responce->mensaje = 'Eliminado';
				clsMapa::baja($_REQUEST['id']);
			}

		}
	}
}
echo json_encode($responce);
?>



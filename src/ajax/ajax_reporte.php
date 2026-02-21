<?php
date_default_timezone_set('America/Lima');
$responce	= new stdClass();
$responce->codigo = 0;
$responce->mensaje = 'Error';

if (isset($_REQUEST)) {
	require_once("../php/clsUsuario.php");
	require_once("../php/clsReporte.php");
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
			if($_REQUEST['control']==1){
			     
			   	$arr_datos = clsReporte::listar_reporte($_REQUEST['fecha_i'],$_REQUEST['fecha_f'],$_REQUEST['cuenta'],$_REQUEST['cliente']);
			   	
            	if (sizeof($arr_datos)>0) {
            		$responce->codigo = 1;
            		$responce->arr_datos = $arr_datos;
            		$responce->mensaje='Listado Tabla';
            	}else{
            		$responce->mensaje='No se encontraron registros';
            	}
            	
			    
			}else if($_REQUEST['control']==2){
			     
			   	$arr_datos = clsReporte::listar_promesa($_REQUEST['fecha_i'],$_REQUEST['fecha_f'],$_REQUEST['cuenta'],$_REQUEST['cliente']);
			   	
            	if (sizeof($arr_datos)>0) {
            		$responce->codigo = 1;
            		$responce->arr_datos = $arr_datos;
            		$responce->mensaje='Listado Promesa';
            	}else{
            		$responce->mensaje='No se encontraron registros';
            	}
            	
			    
			}else if($_REQUEST['control']==3){
			     
			   	$arr_datos = clsReporte::listar_efectos_user($_REQUEST['fecha_i'],$_REQUEST['fecha_f'],$_REQUEST['cuenta'],$_REQUEST['cliente']);
			   	
            	if (sizeof($arr_datos)>0) {
            		$responce->codigo = 1;
            		$responce->arr_datos = $arr_datos;
            		$responce->mensaje='Listado EUSER';
            	}else{
            		$responce->mensaje='No se encontraron registros';
            	}
            	
			    
			}	else if($_REQUEST['control']==4){
			     
			   	$arr_datos = clsReporte::listar_login_user($_REQUEST['fecha_i'],$_REQUEST['fecha_f']);
			   	
            	if (sizeof($arr_datos)>0) {
            		$responce->codigo = 1;
            		$responce->arr_datos = $arr_datos;
            		$responce->mensaje='Listado LOGINASESOR';
            	}else{
            		$responce->mensaje='No se encontraron registros';
            	}
            	
			    
			}else{
				$responce->codigo = 1;
				$responce->mensaje = 'Eliminado';
				clsTable::baja($_REQUEST['id']);
			}

		}
	}
}
echo json_encode($responce);
?>



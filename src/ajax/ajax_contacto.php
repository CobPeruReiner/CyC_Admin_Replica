<?php
date_default_timezone_set('America/Lima');
$responce	= new stdClass();
$responce->codigo = 0;
$responce->mensaje = 'Error';

if (isset($_REQUEST)) {
	require_once("../php/clsUsuario.php");
	require_once("../php/clsContacto.php");
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
				$responce->mensaje = 'Contacto Registrado';
				
				clsContacto::registrar(utf8_decode($_REQUEST['nombre']),$_REQUEST['efecto'],utf8_decode($_REQUEST['homologo']),utf8_decode($_REQUEST['descripcion']));
				
			}else if($_REQUEST['control']==2 ){
		    	$arr_datos = clsContacto::listar();
            	if (sizeof($arr_datos)>0) {
            		$responce->codigo = 1;
            		$responce->arr_datos = $arr_datos;
            		$responce->mensaje='Listado Contacto';
            	}else{
            		$responce->mensaje='No se encontraron registros';
            	}
			}else if($_REQUEST['control']==3 ){
			    if (isset($_REQUEST['id'])){
			        $responce->codigo = 1;			
					
		    	    clsContacto::update_contacto($_REQUEST['id'],utf8_decode($_REQUEST['nombre']),$_REQUEST['efecto'],utf8_decode($_REQUEST['homologo']),utf8_decode($_REQUEST['descripcion']),$_REQUEST['estado']);
		    	    $responce->mensaje='Actualizar Contacto';
			    }
			}else{
				$responce->codigo = 1;
				$responce->mensaje = 'Eliminado Contacto';
				clsContacto::baja($_REQUEST['id']);
			}

		}
	}
}
echo json_encode($responce);
?>



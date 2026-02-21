<?php
date_default_timezone_set('America/Lima');
$responce	= new stdClass();
$responce->codigo = 0;
$responce->mensaje = 'Error';

if (isset($_REQUEST)) {
	require_once("../php/clsUsuario.php");
	require_once("../php/clsCategoria.php");
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
				$responce->mensaje = 'Categoria Registrado';
				clsCategoria::registrar(utf8_decode($_REQUEST['nombre']),utf8_decode($_REQUEST['descripcion']));
				
			}else if($_REQUEST['control']==2 ){
		    	$arr_datos = clsCategoria::listar();
            	if (sizeof($arr_datos)>0) {
            		$responce->codigo = 1;
            		$responce->arr_datos = $arr_datos;
            		$responce->mensaje='Listado Categoria';
            	}else{
            		$responce->mensaje='No se encontraron registros';
            	}
			}else if($_REQUEST['control']==3 ){
			    if (isset($_REQUEST['id'])){
			        $responce->codigo = 1;							
		    	    clsCategoria::update_categoria($_REQUEST['id'],utf8_decode($_REQUEST['nombre']),utf8_decode($_REQUEST['descripcion']),$_REQUEST['estado']);
		    	    $responce->mensaje='Actualizar Categoria';
			    }
			}else{
				$responce->codigo = 1;
				$responce->mensaje = 'Eliminado Categoria';
				clsCategoria::baja($_REQUEST['id']);
			}

		}
	}
}
echo json_encode($responce);
?>



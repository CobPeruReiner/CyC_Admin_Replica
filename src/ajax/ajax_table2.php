<?php
date_default_timezone_set('America/Lima');
set_time_limit(3000);

$responce	= new stdClass();
$responce->codigo = 0;
$responce->mensaje = 'Error';


if (isset($_REQUEST)) {
    
	require_once("../php/clsTable.php");
	session_start();
	if (!isset($_SESSION['id_ls']) || !isset($_SESSION['user_ls']) || !isset($_SESSION['nombre_ls'])) {
		$responce->codigo = 2;
		$responce->mensaje = 'Se ha agotado el tiempo de conexión. Inicie Sesión';
	}else{

		    $responce->codigo = 1;
		    $responce->mensaje = 'Campos Registrado';
				
			if (isset($_REQUEST['arr_select2'])){
					for ($i=0;$i<sizeof($_REQUEST['arr_select2']);$i++){
						clsTable::agregar_campo(utf8_decode($_REQUEST['nombre']),utf8_decode($_REQUEST['arr_select2'][$i][2]),utf8_decode($_REQUEST['arr_select2'][$i][1]));
					}						
			}
		
		
	}
}

echo json_encode($responce);
?>



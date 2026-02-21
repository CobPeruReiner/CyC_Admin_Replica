<?php 

require_once("../php/clsSucursal.php");
$arr_datos = clsSucursal::distritos($_REQUEST['id'],$_REQUEST['id2']);

//var_dump($arr_datos);

	if (sizeof($arr_datos)>0) {
		echo '<option value="">Seleccione Distrito</option>';
	}
	
	foreach($arr_datos as $datos){
			echo '<option value="'.$datos["id"].'">'.$datos["nombre"].'</option>';
		
	}
?>
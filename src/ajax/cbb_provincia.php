<?php 

require_once("../php/clsSucursal.php");
$arr_datos = clsSucursal::provincias($_REQUEST['id']);

//var_dump($arr_datos);

	if (sizeof($arr_datos)>0) {
		echo '<option value="">Seleccione Provincia </option>';
	}
		
	foreach($arr_datos as $datos){
			echo '<option value="'.$datos["id"].'">'.$datos["nombre"].'</option>';
		
	}


?>
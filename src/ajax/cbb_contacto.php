<?php 

require_once("../php/clsGestion.php");
$arr_datos = clsGestion::contactos($_REQUEST['id']);

//var_dump($arr_datos);

	if (sizeof($arr_datos)>0) {
		echo '<option value="">Seleccione Contacto</option>';
	}
		
	foreach($arr_datos as $datos){
			echo '<option value="'.$datos["id"].'">'.$datos["nombre"].'</option>';
		
	}


?>
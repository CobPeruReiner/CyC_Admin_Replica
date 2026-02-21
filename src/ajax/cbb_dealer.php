<?php 

require_once("../php/clsFormulario.php");
$arr_datos = clsFormulario::dealers($_REQUEST['id']);

//var_dump($arr_datos);

	if (sizeof($arr_datos)>0) {
		echo '<option value="">Seleccione Dealer</option>';
	}
		
	foreach($arr_datos as $datos){
			echo '<option value="'.$datos["id"].'">'.$datos["nombre"].'</option>';
		
	}


?>
<?php
date_default_timezone_set('America/Lima');




$responce	= new stdClass();
$responce->codigo = 0;
$responce->mensaje = 'Error';

if (isset($_REQUEST)) {
	require_once("../php/clsUsuario.php");
	require_once("../php/clsGestion.php");
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
				
			 
			    $verificar_ctd=clsGestion::verificar_ctd($_REQUEST['id'],$_SESSION['id_ls']);
			    	
			    if (sizeof($verificar_ctd)>=1){
			        
			        $responce->codigo = 2;
		        	$responce->mensaje = 'Tiene registro pendiente de gestionar';
		           
			    }else{
			        
			        $responce->codigo = 1;
			        $responce->mensaje = 'Asignado exito';
			    
			        $tabla=clsGestion::verificar_tabla($_REQUEST['id']);
    			    $registro=clsGestion::verificar_registro($tabla[0]['nombre'],$tabla[0]['id']);
    			    
    			    $rpta=clsGestion::asignar($registro[0]['identificador'],$tabla[0]['id'],$_SESSION['id_ls']);
			    
			    }
		
			  
			
			
			}else if($_REQUEST['control']==2 ){
		    	$arr_datos = clsGestion::listar_asignaciones_($_SESSION['id_ls']);
            	if (sizeof($arr_datos)>0) {
            		$responce->codigo = 1;
            		$responce->arr_datos = $arr_datos;
            		$responce->mensaje='Listado Tabla';
            	}else{
            		$responce->mensaje='No se encontraron registros';
            	}
			}else if($_REQUEST['control']==3 ){
		    	$arr_datos = clsGestion::buscar($_REQUEST['table'],$_REQUEST['id_table'],$_REQUEST['campo1'],$_REQUEST['campo2'],$_REQUEST['campo3'],$_REQUEST['campo4']);
		    	if (sizeof($arr_datos)>0) {
            		$responce->codigo = 1;
            		$responce->arr_datos = $arr_datos;
            		$responce->mensaje='Buscar Tabla';
            	}else{
            		$responce->mensaje='No se encontraron registros';
            	}
			}else if($_REQUEST['control']==4){
			    
			    
			     $verificar_ctd=clsGestion::verificar_ctd($_REQUEST['id'],$_SESSION['id_ls']);
			    	
			    if (sizeof($verificar_ctd)>=3){
			        
			        $responce->codigo = 2;
		        	$responce->mensaje = 'Tiene registro pendiente de gestionar';
		           
			    }else{
			        
			        $responce->codigo = 1;
			        $responce->mensaje = 'Asignado exito';
			    
			        $tabla=clsGestion::verificar_tabla($_REQUEST['id_table']);
    			    $registro=clsGestion::verificar_registro_2($tabla[0]['nombre'],$_REQUEST['id']);
    			    
    			    $rpta=clsGestion::asignar($registro[0]['identificador'],$tabla[0]['id'],$_SESSION['id_ls']);
			    
			    }
			    
			}else if($_REQUEST['control']==5){
			     $responce->codigo = 1;
			        $responce->mensaje = 'registro exito';
			    
			  
			    clsGestion::insertar($_REQUEST['identificador'],$_REQUEST['id_cuenta'],$_REQUEST['efecto'],$_REQUEST['motivo'],$_REQUEST['contacto'],$_REQUEST['observacion'],$_REQUEST['telefono'],$_REQUEST['direccion'],$_SESSION['id_ls'],$_REQUEST['nom_contacto'],$_REQUEST['pisos'],$_REQUEST['puerta'],$_REQUEST['fachada'],$_REQUEST['id'],$_REQUEST['fecha_promesa'],$_REQUEST['monto_promesa']);
			    
			    
			}else if($_REQUEST['control']==6 ){
	            $arr_datos = clsGestion::listar_identificador($_REQUEST['identificador'],$_REQUEST['cuenta']);
            	if (sizeof($arr_datos)>0) {
            		$responce->codigo = 1;
            		$responce->arr_datos = $arr_datos;
            		$responce->mensaje='Listado Tabla';
            	}else{
            		$responce->mensaje='No se encontraron registros';
            	}
			}else if($_REQUEST['control']==7 ){
	            $arr_datos = clsGestion::listar_campana($_REQUEST['identificador']);
            	if (sizeof($arr_datos)>0) {
            		$responce->codigo = 1;
            		$responce->arr_datos = $arr_datos;
            		$responce->mensaje='Listado Campana';
            	}else{
            		$responce->mensaje='No se encontraron registros';
            	}
			}else if($_REQUEST['control']==8 ){
	            $arr_datos = clsGestion::listar_pago($_REQUEST['identificador']);
            	if (sizeof($arr_datos)>0) {
            		$responce->codigo = 1;
            		$responce->arr_datos = $arr_datos;
            		$responce->mensaje='Listado Pago';
            	}else{
            		$responce->mensaje='No se encontraron registros';
            	}
			}else if($_REQUEST['control']==9){
			     $responce->codigo = 1;
			        $responce->mensaje = 'registro exito';
			    
	
			  
			    clsGestion::insertar_telefono($_REQUEST['doc_gestion'],$_REQUEST['cuenta_'],$_REQUEST['telefono_'],$_SESSION['id_ls']);
			    
			    
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



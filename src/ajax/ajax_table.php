<?php
date_default_timezone_set('America/Lima');
$responce	= new stdClass();
$responce->codigo = 0;
$responce->mensaje = 'Error';

$campo_archivo	= isset($_REQUEST['campo_archivo'])?$_REQUEST['campo_archivo']:null;
$descripcion	= isset($_REQUEST['descripcion'])?$_REQUEST['descripcion']:null;

if (isset($_REQUEST)) {
	require_once("../php/clsUsuario.php");
	require_once("../php/clsTable.php");
	require_once('../Archivo.class.php');
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
				$responce->mensaje = 'Tabla Registrado';
				
				clsTable::registrar_log(utf8_decode($_REQUEST['nombre']),utf8_decode($_REQUEST['cartera']),$_SESSION['id_ls']);
				clsTable::crear_tabla(utf8_decode($_REQUEST['nombre']));
				
				
				if (isset($_REQUEST['arr_select'])){
						for ($i=0;$i<sizeof($_REQUEST['arr_select']);$i++){
							clsTable::agregar_campo(utf8_decode(strtoupper($_REQUEST['nombre'])),utf8_decode($_REQUEST['arr_select'][$i][2]),utf8_decode($_REQUEST['arr_select'][$i][1]));
						}						
				}
				
				clsTable::agregar_key(utf8_decode($_REQUEST['nombre']),'identificador');
					clsTable::agregar_key(utf8_decode($_REQUEST['nombre']),'documento');
			  
			}else if($_REQUEST['control']==2 ){
		    	$arr_datos = clsTable::listar();
            	if (sizeof($arr_datos)>0) {
            		$responce->codigo = 1;
            		$responce->arr_datos = $arr_datos;
            		$responce->mensaje='Listado Tabla';
            	}else{
            		$responce->mensaje='No se encontraron registros';
            	}
			}else if($_REQUEST['control']==3 ){
			    
			    				
				$responce->codigo = 1;	
				if (isset($_FILES[$campo_archivo])) {
					if (empty($_FILES[$campo_archivo]['name'])) {
						$responce->codigo	= 4;
						$responce->mensaje	= (empty($descripcion)?'':$descripcion." : ")."No se ha adjunto archivo";
						$responce->archivo_nuevo = "";
					}else{
						$ano=date("Y/m/");
									 
						$a		= $_FILES[$campo_archivo]['name'];
						$d		= "../assets/archivos/";	
						$e		= array('csv');
						$t		= $_FILES[$campo_archivo]['size'];
						$tmp	= $_FILES[$campo_archivo]['tmp_name'];
						$error	= $_FILES[$campo_archivo]['error'];
							if ($error == UPLOAD_ERR_OK) {
									$obj = new Archivo($a,$d,$e,$t,$tmp,$error);
									$ruta= $ano.$_REQUEST['id'].".".$obj->getExtension();
														
									clsTable::update_ruta($_REQUEST['id'], $ruta);
									
									$obj->archivo_nuevo = $ruta;
									$responce	= $obj->subir();
							}else{
								$responce-> mensaje="No se puede subir fichero". $error;
							}
					}
				}else{
						$responce->codigo	= 0;
						$responce->mensaje	= "Error de par&aacute;metros para realizar la transaci&oacute;n.";
				}
				
			}else if($_REQUEST['control']==4 ){
			    $responce->codigo = 1;
			    $responce->mensaje = 'GUI exito';
				clsTable::eliminar_gui($_REQUEST['id']);
				clsTable::update_asigna($_REQUEST['id'],$_REQUEST['asigna']);
				
		          if (isset($_REQUEST['arr_items'])){
						for ($i=0;$i<sizeof($_REQUEST['arr_items']);$i++){
						clsTable::agregar_gui($_REQUEST['id'],$_REQUEST['arr_items'][$i][0],$_REQUEST['arr_items'][$i][1]);
						}						
					}
					
					
			}else if ($_REQUEST['control']==5){
				$responce->codigo = 1;
				$responce->mensaje = 'Campo Registrado';
				
			
				clsTable::agregar_campo(utf8_decode(strtoupper($_REQUEST['nombre'])),$_REQUEST['campo'],$_REQUEST['tipo']);
						
				
				//clsTable::agregar_key(utf8_decode($_REQUEST['nombre']));
			  
			}else if ($_REQUEST['control']==6){
			    $responce->codigo = 1;
			    $responce->mensaje = 'GUI2 exito';
			
		          if (isset($_REQUEST['arr_items2'])){
						for ($i=0;$i<sizeof($_REQUEST['arr_items2']);$i++){
						clsTable::agregar_gui($_REQUEST['id'],$_REQUEST['arr_items2'][$i][0],$_REQUEST['arr_items2'][$i][1]);
						}						
					}
			  
			}else if ($_REQUEST['control']==7){
			    $responce->codigo = 1;
			    $responce->mensaje = 'GUI3 exito';
			       clsTable::eliminar_asignacion($_REQUEST['id']);
		          if (isset($_REQUEST['arr_items3'])){
						for ($i=0;$i<sizeof($_REQUEST['arr_items3']);$i++){
						    
						  if ($_REQUEST['arr_items3'][$i]>0){   
						    clsTable::registrar_asignacion($_REQUEST['id'],$_REQUEST['arr_items3'][$i]);
						  }
						
						
						}						
					}
					
			  
			}else if ($_REQUEST['control']==8){
			    $responce->codigo = 1;
			    $responce->mensaje = 'Duplicado exito';
			 
			    $rpta=clsTable::registrar_log_duplicado($_SESSION['id_ls'],$_REQUEST['id']);
			    $tabla_origen=clsTable::verificar_tabla($_REQUEST['id']);
			    $tabla_destino=clsTable::verificar_tabla($rpta);
			    
			   /* var_dump ( $tabla_origen[0]['nombre']);
			    var_dump ( $tabla_destino['nombre']);*/
			    clsTable::create_duplicado($tabla_destino[0]['nombre'],$tabla_origen[0]['nombre']);
			    
			  
			}else if ($_REQUEST['control']==9){
			    $responce->codigo = 1;
			    
			    $cadena=("'".str_replace(",", "','",$_REQUEST['texto'])."'");
			    
			    
			    $responce->mensaje = 'Se eliminaron correctamente: '.$cadena;
			 
			    $tabla_origen=clsTable::verificar_tabla($_REQUEST['id']);
		        
			    clsTable::eliminar_registro($tabla_origen[0]['nombre'],$cadena);
			    
			  
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



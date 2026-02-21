<?php
date_default_timezone_set('America/Lima');
$responce	= new stdClass();
$responce->codigo = 0;
$responce->mensaje = 'Registrado';

$campo_archivo	= isset($_REQUEST['campo_archivo'])?$_REQUEST['campo_archivo']:null;
$descripcion	= isset($_REQUEST['descripcion'])?$_REQUEST['descripcion']:null;


if (isset($_REQUEST)) {
	require_once("../php/clsUsuario.php");
	require_once("../php/clsFile.php");
	require_once('../Archivo.class.php');
	session_start();
	if (!isset($_SESSION['id_ls']) || !isset($_SESSION['user_ls']) || !isset($_SESSION['nombre_ls'])) {
		$responce->codigo = 2;
		$responce->mensaje = 'Se ha agotado el tiempo de conexión. Inicie Sesión';
	}else{
		$verificar=clsUsuario::verificar_sesion($_SESSION['id_ls'],$_SESSION['user_ls']);
		if (sizeof($verificar)==0){
			$responce->codigo = 3;
			$responce->mensaje = 'Usuario no válido, Inicie Sesión';
		}else{

			if (isset($_FILES[$campo_archivo])) {
				if (empty($_FILES[$campo_archivo]['name'])) {
					$responce->codigo	= 4;
					$responce->mensaje	= (empty($descripcion)?'':$descripcion." : ")."No se ha adjunto archivo";
					$responce->archivo_nuevo = "";
				}else{
					$ano=date("Y/m/");
					$rpta = clsFile::registrar($_REQUEST['id_norma'],$_REQUEST['id_version'],$_REQUEST['id_language'],$_REQUEST['fecha_caducidad'],$_REQUEST['estado'],$_REQUEST['peso']);
					$a		= $_FILES[$campo_archivo]['name'];
					$d		= "../assets/archivos/";	
					$e		= array('docx','xlsx','pptx','pdf','doc','xls','ppt','zip','jpg','png','gif');
					$t		= $_FILES[$campo_archivo]['size'];
					$tmp	= $_FILES[$campo_archivo]['tmp_name'];
					$error	= $_FILES[$campo_archivo]['error'];
						if ($error == UPLOAD_ERR_OK) {
								$obj = new Archivo($a,$d,$e,$t,$tmp,$error);
								$ruta= $ano.$rpta.".".$obj->getExtension();
								clsFile::actualizar_ruta_id($rpta, $ruta,$obj->getExtension());
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

		}
	}
}

echo json_encode($responce);



?>



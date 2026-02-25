<?php
// date_default_timezone_set('America/Lima');
// $responce	= new stdClass();
// $responce->codigo = 0;
// $responce->mensaje = 'Modificado';


// if (isset($_REQUEST)) {
// 	require_once("../php/clsUsuario.php");
// 	session_start();
// 	if (!isset($_SESSION['id_ls']) || !isset($_SESSION['user_ls']) || !isset($_SESSION['nombre_ls'])) {
// 		$responce->codigo = 2;
// 		$responce->mensaje = 'Se ha agotado el tiempo de conexión. Inicie Sesión';
// 	} else {
// 		$verificar = clsUsuario::verificar_sesion($_SESSION['id_ls'], $_SESSION['user_ls']);
// 		$verificar_dni_update = clsUsuario::verificar_dni_update($_REQUEST['dni'], $_REQUEST['id']);
// 		$verificar_dni = clsUsuario::verificar_dni($_REQUEST['dni']);
// 		$verificar_password = clsUsuario::verificar_password($_REQUEST['password'], $_REQUEST['id']);
// 		if (sizeof($verificar) == 0) {
// 			$responce->codigo = 3;
// 			$responce->mensaje = 'Usuario no válido, Inicie Sesión';
// 		} else if (sizeof($verificar_dni_update) == 1) {
// 			$responce->codigo = 1;
// 			if (sizeof($verificar_password) == 1) {
// 				$_REQUEST['password'] = "SI";
// 			} else {
// 				$_REQUEST['password'] = $_REQUEST['password'];
// 			}

// 			if (isset($_REQUEST['arr_items'])) {

// 				clsUsuario::eliminar_item($_REQUEST['id']);

// 				for ($i = 0; $i < sizeof($_REQUEST['arr_items']); $i++) {
// 					clsUsuario::registrar_item($_REQUEST['arr_items'][$i], $_REQUEST['id']);
// 				}

// 				clsUsuario::update_empleado($_REQUEST['id'], $_REQUEST['estado'], utf8_decode($_REQUEST['apellidos']), utf8_decode($_REQUEST['nombre']), utf8_decode($_REQUEST['fechanac']), $_REQUEST['sexo'], $_REQUEST['dni'], $_REQUEST['ec'], $_REQUEST['fam'], $_REQUEST['hijos'], utf8_decode($_REQUEST['direccion']), utf8_decode($_REQUEST['distrito']), utf8_decode($_REQUEST['departamento']), utf8_decode($_REQUEST['referencia']), $_REQUEST['telefono'], $_REQUEST['movil'], utf8_decode($_REQUEST['email']), $_REQUEST['gi'], utf8_decode($_REQUEST['cargo']), $_REQUEST['suc'], $_REQUEST['user'], $_REQUEST['password'], $_REQUEST['cartera'], utf8_decode($_REQUEST['fechaing']), utf8_decode($_REQUEST['fechabaja']), (int)$_SESSION['id_ls']);
// 			}
// 		} else {
// 			if (sizeof($verificar_dni) == 1) {
// 				$responce->codigo = 4;
// 				$responce->mensaje = 'Ya se encuentra registrado usuario con DNI: ' . $_REQUEST['dni'];
// 			} else {
// 				$responce->codigo = 1;
// 				if (sizeof($verificar_password) == 1) {
// 					$_REQUEST['password'] = "SI";
// 				} else {
// 					$_REQUEST['password'] = $_REQUEST['password'];
// 				}


// 				if (isset($_REQUEST['arr_items'])) {

// 					clsUsuario::eliminar_item($_REQUEST['id']);

// 					for ($i = 0; $i < sizeof($_REQUEST['arr_items']); $i++) {
// 						clsUsuario::registrar_item($_REQUEST['arr_items'][$i], $_REQUEST['id']);
// 					}

// 					clsUsuario::update_empleado($_REQUEST['id'], $_REQUEST['estado'], utf8_decode($_REQUEST['apellidos']), utf8_decode($_REQUEST['nombre']), utf8_decode($_REQUEST['fechanac']), $_REQUEST['sexo'], $_REQUEST['dni'], $_REQUEST['ec'], $_REQUEST['fam'], $_REQUEST['hijos'], utf8_decode($_REQUEST['direccion']), utf8_decode($_REQUEST['distrito']), utf8_decode($_REQUEST['departamento']), utf8_decode($_REQUEST['referencia']), $_REQUEST['telefono'], $_REQUEST['movil'], utf8_decode($_REQUEST['email']), $_REQUEST['gi'], utf8_decode($_REQUEST['cargo']), $_REQUEST['suc'], $_REQUEST['user'], $_REQUEST['password'], $_REQUEST['cartera'], utf8_decode($_REQUEST['fechaing']), utf8_decode($_REQUEST['fechabaja']), (int)$_SESSION['id_ls']);
// 				}
// 			}
// 		}
// 	}
// }

// echo json_encode($responce);

date_default_timezone_set('America/Lima');
header('Content-Type: application/json; charset=UTF-8');

function validar_password_segura($password)
{
	return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/', $password);
}

function dbg($msg, $ctx = array())
{
	if (isset($ctx['password'])) $ctx['password'] = '***';
	if (is_array($ctx)) {
		foreach ($ctx as $k => $v) {
			if (is_object($v)) $ctx[$k] = '[object]';
		}
	}
	error_log('[ajax_modificar_user] ' . $msg . ' | ctx=' . json_encode($ctx));
}

require_once("../php/clsUsuario.php");
session_start();

header('X-Debug-Script: ajax_modificar_user.php');
header('X-Debug-Host: ' . gethostname());
header('X-Debug-SID: ' . session_id());
header('X-Debug-UserId: ' . (isset($_SESSION['id_ls']) ? (int)$_SESSION['id_ls'] : -1));

$responce = new stdClass();
$responce->codigo  = 0;
$responce->mensaje = 'Modificado';

dbg('request_in', array(
	'sid'     => session_id(),
	'method'  => isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : '',
	'uri'     => isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '',
	'id_ls'   => isset($_SESSION['id_ls']) ? (int)$_SESSION['id_ls'] : null,
	'user_ls' => isset($_SESSION['user_ls']) ? $_SESSION['user_ls'] : null,
));

if (
	empty($_SESSION['id_ls']) || (int)$_SESSION['id_ls'] <= 0
	|| empty($_SESSION['user_ls']) || empty($_SESSION['nombre_ls'])
) {

	dbg('no_session_or_zero', array('sess' => $_SESSION));
	http_response_code(401);
	$responce->codigo  = 2;
	$responce->mensaje = 'Se ha agotado el tiempo de conexión. Inicie Sesión';
	echo json_encode($responce);
	exit;
}
$idUsuario = (int)$_SESSION['id_ls'];

$in = $_REQUEST;
if (isset($in['password'])) $in['password'] = '***';
dbg('payload_received', $in);

$verificar            = clsUsuario::verificar_sesion($_SESSION['id_ls'], $_SESSION['user_ls']);
$verificar_dni_update = clsUsuario::verificar_dni_update($_REQUEST['dni'], $_REQUEST['id']);
$verificar_dni        = clsUsuario::verificar_dni($_REQUEST['dni']);
$verificar_password   = clsUsuario::verificar_password($_REQUEST['password'], $_REQUEST['id']);

if (sizeof($verificar) == 0) {
	$responce->codigo  = 3;
	$responce->mensaje = 'Usuario no válido, Inicie Sesión';
	dbg('user_invalid', array('id_ls' => $idUsuario));
	echo json_encode($responce);
	exit;
}

if (sizeof($verificar_password) == 1) {
	$_REQUEST['password'] = 'SI';
} else {
	if (!validar_password_segura($_REQUEST['password'])) {

		$responce->codigo = 6;
		$responce->mensaje = 'La contraseña debe tener mínimo 8 caracteres, incluyendo mayúscula, minúscula, número y símbolo especial';

		echo json_encode($responce);
		exit;
	}
}

if (sizeof($verificar_dni_update) == 1) {
	$responce->codigo = 1;
} else {
	if (sizeof($verificar_dni) == 1) {
		$responce->codigo  = 4;
		$responce->mensaje = 'Ya se encuentra registrado usuario con DNI: ' . $_REQUEST['dni'];
		dbg('dni_duplicado', array('dni' => $_REQUEST['dni']));
		echo json_encode($responce);
		exit;
	} else {
		$responce->codigo = 1;
	}
}

if (isset($_REQUEST['arr_items'])) {
	clsUsuario::eliminar_item($_REQUEST['id']);
	for ($i = 0; $i < sizeof($_REQUEST['arr_items']); $i++) {
		clsUsuario::registrar_item($_REQUEST['arr_items'][$i], $_REQUEST['id']);
	}
}

dbg('about_to_update', array(
	'id'        => isset($_REQUEST['id']) ? $_REQUEST['id'] : null,
	'dni'       => isset($_REQUEST['dni']) ? $_REQUEST['dni'] : null,
	'idUsuario' => $idUsuario
));

clsUsuario::update_empleado(
	$_REQUEST['id'],
	$_REQUEST['estado'],
	utf8_decode($_REQUEST['apellidos']),
	utf8_decode($_REQUEST['nombre']),
	utf8_decode($_REQUEST['fechanac']),
	$_REQUEST['sexo'],
	$_REQUEST['dni'],
	$_REQUEST['ec'],
	$_REQUEST['fam'],
	$_REQUEST['hijos'],
	utf8_decode($_REQUEST['direccion']),
	utf8_decode($_REQUEST['distrito']),
	utf8_decode($_REQUEST['departamento']),
	utf8_decode($_REQUEST['referencia']),
	$_REQUEST['telefono'],
	$_REQUEST['movil'],
	utf8_decode($_REQUEST['email']),
	$_REQUEST['gi'],
	utf8_decode($_REQUEST['cargo']),
	$_REQUEST['suc'],
	$_REQUEST['user'],
	$_REQUEST['password'],
	$_REQUEST['cartera'],
	utf8_decode($_REQUEST['fechaing']),
	utf8_decode($_REQUEST['fechabaja']),
	$idUsuario
);

dbg('update_done', array('idUsuario' => $idUsuario));

echo json_encode($responce);

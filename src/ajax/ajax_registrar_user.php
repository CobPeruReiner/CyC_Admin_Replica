<?php
date_default_timezone_set('America/Lima');

function validar_password_segura($password)
{
	return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/', $password);
}

$responce	= new stdClass();
$responce->codigo = 0;
$responce->mensaje = 'Error';

if (isset($_REQUEST)) {
	require_once("../php/clsUsuario.php");
	session_start();
	if (!isset($_SESSION['id_ls']) || !isset($_SESSION['user_ls']) || !isset($_SESSION['nombre_ls'])) {
		$responce->codigo = 2;
		$responce->mensaje = 'Se ha agotado el tiempo de conexión. Inicie Sesión';
	} else {
		$verificar = clsUsuario::verificar_sesion($_SESSION['id_ls'], $_SESSION['user_ls']);
		$verificar_dni = clsUsuario::verificar_dni($_REQUEST['dni']);
		$verificar_user = clsUsuario::verificar_nombre_user($_REQUEST['user']);
		if (sizeof($verificar) == 0) {
			$responce->codigo = 3;
			$responce->mensaje = 'Usuario no válido, Inicie Sesión';
		} else if (sizeof($verificar_dni) >= 1) {
			$responce->codigo = 4;
			$responce->mensaje = 'Ya se encuentra registrado usuario con DNI: ' . $_REQUEST['dni'];
		} else if (sizeof($verificar_user) >= 1) {
			$responce->codigo = 5;
			$responce->mensaje = 'Nickname: ' . $_REQUEST['user'] . ' no disponible';
		} else if (!isset($_REQUEST['password']) || !validar_password_segura($_REQUEST['password'])) {
			$responce->codigo = 6;
			$responce->mensaje = 'La contraseña debe tener mínimo 8 caracteres, incluyendo mayúscula, minúscula, número y símbolo especial';
		} else {
			$responce->codigo = 1;
			$responce->mensaje = 'Registrado';

			$rpta = clsUsuario::registrar_empleado(utf8_decode($_REQUEST['apellidos']), utf8_decode($_REQUEST['nombre']), utf8_decode($_REQUEST['fechanac']), $_REQUEST['sexo'], $_REQUEST['dni'], $_REQUEST['ec'], $_REQUEST['fam'], $_REQUEST['hijos'], utf8_decode($_REQUEST['direccion']), utf8_decode($_REQUEST['distrito']), utf8_decode($_REQUEST['departamento']), utf8_decode($_REQUEST['referencia']), $_REQUEST['telefono'], $_REQUEST['movil'], utf8_decode($_REQUEST['email']), $_REQUEST['gi'], utf8_decode($_REQUEST['cargo']), $_REQUEST['suc'], $_REQUEST['user'], $_REQUEST['password'], $_REQUEST['cartera'], utf8_decode($_REQUEST['fechaing']));


			if ($rpta > 0) {
				if (isset($_REQUEST['arr_items'])) {

					for ($i = 0; $i < sizeof($_REQUEST['arr_items']); $i++) {
						clsUsuario::registrar_item($_REQUEST['arr_items'][$i], $rpta);
					}
				}
			}
		}
	}
}

echo json_encode($responce);

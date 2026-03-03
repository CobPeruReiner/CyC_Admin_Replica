<?php
date_default_timezone_set('America/Lima');
session_start();

function validar_password_segura($password)
{
	return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/', $password);
}

$responce = new stdClass();
$responce->codigo = 0;
$responce->mensaje = 'Error';

/* ===============================
   SOLO PERMITIR POST
=================================*/
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	$responce->mensaje = 'Método no permitido';
	echo json_encode($responce);
	exit;
}

require_once("../php/clsUsuario.php");

/* ===============================
   VALIDAR SESIÓN
=================================*/
if (!isset($_SESSION['id_ls']) || !isset($_SESSION['user_ls']) || !isset($_SESSION['nombre_ls'])) {
	$responce->codigo = 2;
	$responce->mensaje = 'Se ha agotado el tiempo de conexión. Inicie Sesión';
	echo json_encode($responce);
	exit;
}

/* ===============================
   VALIDAR CAMPOS OBLIGATORIOS
=================================*/
$campos_requeridos = [
	'dni',
	'user',
	'password',
	'apellidos',
	'nombre',
	'fechanac',
	'sexo'
];

foreach ($campos_requeridos as $campo) {
	if (!isset($_POST[$campo]) || trim($_POST[$campo]) === '') {
		$responce->codigo = 8;
		$responce->mensaje = 'Faltan campos obligatorios';
		echo json_encode($responce);
		exit;
	}
}

/* ===============================
   SANITIZAR DATOS
=================================*/
$dni        = trim($_POST['dni']);
$user       = trim($_POST['user']);
$password   = $_POST['password'];

$apellidos  = trim($_POST['apellidos']);
$nombre     = trim($_POST['nombre']);
$fechanac   = trim($_POST['fechanac']);
$sexo       = trim($_POST['sexo']);

$email      = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
$telefono   = isset($_POST['telefono']) ? trim($_POST['telefono']) : '';
$movil      = isset($_POST['movil']) ? trim($_POST['movil']) : '';
$hijos      = isset($_POST['hijos']) ? filter_var($_POST['hijos'], FILTER_VALIDATE_INT) : 0;
$cartera    = isset($_POST['cartera']) ? filter_var($_POST['cartera'], FILTER_VALIDATE_INT) : 0;

/* Validaciones adicionales */
if (!filter_var($email, FILTER_VALIDATE_EMAIL) && $email != '') {
	$responce->codigo = 9;
	$responce->mensaje = 'Email inválido';
	echo json_encode($responce);
	exit;
}

if (!validar_password_segura($password)) {
	$responce->codigo = 6;
	$responce->mensaje = 'La contraseña debe tener mínimo 8 caracteres, incluyendo mayúscula, minúscula, número y símbolo especial';
	echo json_encode($responce);
	exit;
}

/* ===============================
   VALIDACIONES DE NEGOCIO
=================================*/
$verificar = clsUsuario::verificar_sesion($_SESSION['id_ls'], $_SESSION['user_ls']);
$verificar_dni = clsUsuario::verificar_dni($dni);
$verificar_user = clsUsuario::verificar_nombre_user($user);

if (sizeof($verificar) == 0) {
	$responce->codigo = 3;
	$responce->mensaje = 'Usuario no válido, Inicie Sesión';
} else if (sizeof($verificar_dni) >= 1) {
	$responce->codigo = 4;
	$responce->mensaje = 'Ya se encuentra registrado usuario con DNI: ' . $dni;
} else if (sizeof($verificar_user) >= 1) {
	$responce->codigo = 5;
	$responce->mensaje = 'Nickname: ' . $user . ' no disponible';
} else {

	$rpta = clsUsuario::registrar_empleado(
		utf8_decode($apellidos),
		utf8_decode($nombre),
		$fechanac,
		$sexo,
		$dni,
		$_POST['ec'],
		$_POST['fam'],
		$hijos,
		utf8_decode($_POST['direccion']),
		utf8_decode($_POST['distrito']),
		utf8_decode($_POST['departamento']),
		utf8_decode($_POST['referencia']),
		$telefono,
		$movil,
		utf8_decode($email),
		$_POST['gi'],
		utf8_decode($_POST['cargo']),
		$_POST['suc'],
		$user,
		$password,
		$cartera,
		utf8_decode($_POST['fechaing'])
	);

	if ($rpta > 0) {

		if (isset($_POST['arr_items']) && is_array($_POST['arr_items'])) {
			foreach ($_POST['arr_items'] as $item) {
				clsUsuario::registrar_item($item, $rpta);
			}
		}

		$responce->codigo = 1;
		$responce->mensaje = 'Registrado';
	}
}

echo json_encode($responce);

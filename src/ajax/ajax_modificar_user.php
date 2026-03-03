<?php
date_default_timezone_set('America/Lima');
header('Content-Type: application/json; charset=UTF-8');
session_start();
require_once("../php/clsUsuario.php");

function validar_password_segura($password)
{
	return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/', $password);
}

$responce = new stdClass();
$responce->codigo  = 0;
$responce->mensaje = 'Modificado';

/* ==========================
   SOLO POST
========================== */
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	http_response_code(405);
	exit;
}

/* ==========================
   VALIDAR SESIÓN
========================== */
if (
	empty($_SESSION['id_ls']) ||
	empty($_SESSION['user_ls']) ||
	empty($_SESSION['nombre_ls'])
) {
	$responce->codigo  = 2;
	$responce->mensaje = 'Sesión inválida';
	echo json_encode($responce);
	exit;
}

$idUsuario = (int)$_SESSION['id_ls'];

/* ==========================
   CAMPOS OBLIGATORIOS
========================== */
$campos = ['id', 'dni', 'user', 'apellidos', 'nombre', 'fechanac', 'sexo'];

foreach ($campos as $campo) {
	if (!isset($_POST[$campo]) || trim($_POST[$campo]) === '') {
		$responce->codigo = 8;
		$responce->mensaje = 'Faltan campos obligatorios';
		echo json_encode($responce);
		exit;
	}
}

/* ==========================
   SANITIZAR
========================== */
$id       = (int)$_POST['id'];
$dni      = trim($_POST['dni']);
$user     = trim($_POST['user']);
$password = isset($_POST['password']) ? trim($_POST['password']) : '';

$apellidos = trim($_POST['apellidos']);
$nombre    = trim($_POST['nombre']);
$fechanac  = trim($_POST['fechanac']);
$sexo      = trim($_POST['sexo']);

$hijos   = isset($_POST['hijos']) ? (int)$_POST['hijos'] : 0;
$cartera = isset($_POST['cartera']) ? (int)$_POST['cartera'] : 0;

/* ==========================
   VALIDACIONES DE NEGOCIO
========================== */

$verificar = clsUsuario::verificar_sesion($idUsuario, $_SESSION['user_ls']);
if (sizeof($verificar) == 0) {
	$responce->codigo  = 3;
	$responce->mensaje = 'Usuario no válido';
	echo json_encode($responce);
	exit;
}

/* Validar DNI */
$verificar_dni_update = clsUsuario::verificar_dni_update($dni, $id);
$verificar_dni        = clsUsuario::verificar_dni($dni);

if (sizeof($verificar_dni_update) != 1 && sizeof($verificar_dni) == 1) {
	$responce->codigo  = 4;
	$responce->mensaje = 'Ya se encuentra registrado usuario con DNI: ' . $dni;
	echo json_encode($responce);
	exit;
}

/* ==========================
   VALIDAR PASSWORD
========================== */

if ($password !== '') {

	if (!validar_password_segura($password)) {
		$responce->codigo  = 6;
		$responce->mensaje = 'La contraseña debe tener mínimo 8 caracteres, incluyendo mayúscula, minúscula, número y símbolo especial';
		echo json_encode($responce);
		exit;
	}

	$yaUsada = clsUsuario::verificar_password($password, $id);

	if ($yaUsada === true) {
		$responce->codigo  = 10;
		$responce->mensaje = 'No puede reutilizar ninguna de sus últimas 24 contraseñas';
		echo json_encode($responce);
		exit;
	}
} else {
	$password = null;
}

/* ==========================
   ITEMS
========================== */
if (isset($_POST['arr_items']) && is_array($_POST['arr_items'])) {

	clsUsuario::eliminar_item($id);

	foreach ($_POST['arr_items'] as $item) {
		clsUsuario::registrar_item($item, $id);
	}
}

/* ==========================
   UPDATE
========================== */

clsUsuario::update_empleado(
	$id,
	$_POST['estado'],
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
	$_POST['telefono'],
	$_POST['movil'],
	utf8_decode($_POST['email']),
	$_POST['gi'],
	utf8_decode($_POST['cargo']),
	$_POST['suc'],
	$user,
	$password, // null si no cambia
	$cartera,
	utf8_decode($_POST['fechaing']),
	utf8_decode($_POST['fechabaja']),
	$idUsuario
);

$responce->codigo  = 1;
$responce->mensaje = 'Modificado';

echo json_encode($responce);

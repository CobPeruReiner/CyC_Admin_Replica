<?php
date_default_timezone_set('America/Lima');
ini_set('display_errors', '0');
ini_set('log_errors', '1');
header('Content-Type: application/json; charset=utf-8');
session_start();

require_once("../php/clsUsuario.php");

function responder_registro($codigo, $mensaje)
{
	$respuesta = new stdClass();
	$respuesta->codigo = (int)$codigo;
	$respuesta->mensaje = $mensaje;
	echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
	exit;
}

function texto_post_registro($campo)
{
	return isset($_POST[$campo]) ? trim((string)$_POST[$campo]) : '';
}

function entero_post_registro($campo)
{
	return isset($_POST[$campo]) ? (int)$_POST[$campo] : 0;
}

function es_utf8_valido_registro($valor)
{
	return preg_match('//u', $valor) === 1;
}

function fecha_valida_registro($fecha)
{
	$objFecha = DateTime::createFromFormat('Y-m-d', $fecha);
	return $objFecha && $objFecha->format('Y-m-d') === $fecha;
}

function password_segura_registro($password)
{
	if (strlen($password) > 72) {
		return false;
	}
	return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/', $password) === 1;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	responder_registro(2, 'Método no permitido');
}

if (!isset($_SESSION['id_ls']) || !isset($_SESSION['user_ls']) || !isset($_SESSION['nombre_ls'])) {
	responder_registro(3, 'Se ha agotado el tiempo de conexión. Inicie sesión');
}

$camposRequeridos = array(
	'dni',
	'user',
	'password',
	'apellidos',
	'nombre',
	'fechanac',
	'sexo',
	'ec',
	'cargo',
	'direccion',
	'departamento',
	'distrito',
	'referencia',
	'fam',
	'telefono',
	'movil',
	'email',
	'gi',
	'suc',
	'cartera',
	'fechaing',
	'refrigerio'
);

foreach ($camposRequeridos as $campo) {
	if (!isset($_POST[$campo]) || trim((string)$_POST[$campo]) === '') {
		responder_registro(8, 'Falta el campo obligatorio: ' . $campo);
	}
}

if (!isset($_POST['arr_items']) || !is_array($_POST['arr_items']) || count($_POST['arr_items']) === 0) {
	responder_registro(8, 'Debe seleccionar por lo menos un horario');
}

$apellidos = texto_post_registro('apellidos');
$nombres = texto_post_registro('nombre');
$dni = texto_post_registro('dni');
$usuario = texto_post_registro('user');
$password = isset($_POST['password']) ? (string)$_POST['password'] : '';
$fechaNacimiento = texto_post_registro('fechanac');
$fechaIngreso = texto_post_registro('fechaing');
$direccion = texto_post_registro('direccion');
$distrito = texto_post_registro('distrito');
$departamento = texto_post_registro('departamento');
$referencia = texto_post_registro('referencia');
$email = texto_post_registro('email');
$telefono = texto_post_registro('telefono');
$movil = texto_post_registro('movil');

$sexo = entero_post_registro('sexo');
$estadoCivil = entero_post_registro('ec');
$cargaFamiliar = entero_post_registro('fam');
$hijos = entero_post_registro('hijos');
$gradoInstruccion = entero_post_registro('gi');
$cargo = entero_post_registro('cargo');
$sucursal = entero_post_registro('suc');
$cartera = entero_post_registro('cartera');
$refrigerio = entero_post_registro('refrigerio');
$idUsuarioRegistro = (int)$_SESSION['id_ls'];

$textosUtf8 = array(
	'apellidos' => $apellidos,
	'nombres' => $nombres,
	'dirección' => $direccion,
	'distrito' => $distrito,
	'departamento' => $departamento,
	'referencia' => $referencia,
	'email' => $email,
	'usuario' => $usuario
);

foreach ($textosUtf8 as $nombreCampo => $valorCampo) {
	if (!es_utf8_valido_registro($valorCampo)) {
		responder_registro(9, 'El campo ' . $nombreCampo . ' contiene una codificación inválida');
	}
}

if (!fecha_valida_registro($fechaNacimiento) || !fecha_valida_registro($fechaIngreso)) {
	responder_registro(9, 'Las fechas deben usar el formato YYYY-MM-DD');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	responder_registro(9, 'Email inválido');
}

if ($hijos < 0) {
	responder_registro(9, 'La cantidad de hijos no puede ser negativa');
}

if (strlen($dni) < 8 || strlen($dni) > 10) {
	responder_registro(9, 'El documento debe tener entre 8 y 10 caracteres');
}

if (!password_segura_registro($password)) {
	responder_registro(6, 'La contraseña debe tener entre 8 y 72 caracteres e incluir mayúscula, minúscula, número y símbolo especial');
}

if ($sexo <= 0 || $estadoCivil <= 0 || $cargo <= 0 || $gradoInstruccion <= 0 || $sucursal <= 0 || $cartera <= 0 || $refrigerio <= 0) {
	responder_registro(8, 'Uno o más campos de selección son inválidos');
}

if (!clsUsuario::validar_refrigerio($refrigerio)) {
	responder_registro(10, 'La hora de almuerzo seleccionada no está disponible');
}

$verificarSesion = clsUsuario::verificar_sesion($idUsuarioRegistro);
$verificarDni = clsUsuario::verificar_dni($dni);
$verificarUsuario = clsUsuario::verificar_nombre_user($usuario);

if (count($verificarSesion) === 0) {
	responder_registro(3, 'Usuario no válido. Inicie sesión nuevamente');
}
if (count($verificarDni) > 0) {
	responder_registro(4, 'Ya existe un usuario registrado con el documento: ' . $dni);
}
if (count($verificarUsuario) > 0) {
	responder_registro(5, 'El usuario ' . $usuario . ' no está disponible');
}

$horarios = array();
foreach ($_POST['arr_items'] as $idHorario) {
	$idHorario = (int)$idHorario;
	if ($idHorario > 0) {
		$horarios[$idHorario] = $idHorario;
	}
}
$horarios = array_values($horarios);

if (count($horarios) === 0) {
	responder_registro(8, 'Debe seleccionar por lo menos un horario válido');
}

$idPersonal = clsUsuario::registrar_empleado(
	$apellidos,
	$nombres,
	$fechaNacimiento,
	$sexo,
	$dni,
	$estadoCivil,
	$cargaFamiliar,
	$hijos,
	$direccion,
	$distrito,
	$departamento,
	$referencia,
	$telefono,
	$movil,
	$email,
	$gradoInstruccion,
	$cargo,
	$sucursal,
	$usuario,
	$password,
	$cartera,
	$fechaIngreso,
	$refrigerio,
	$idUsuarioRegistro,
	$horarios
);

if (!$idPersonal) {
	responder_registro(11, 'No se pudo registrar el personal. No se guardaron cambios incompletos');
}

responder_registro(1, 'Registrado correctamente');

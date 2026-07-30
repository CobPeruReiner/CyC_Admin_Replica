<?php
date_default_timezone_set('America/Lima');
ini_set('display_errors', '0');
ini_set('log_errors', '1');
header('Content-Type: application/json; charset=utf-8');
session_start();

require_once("../php/clsUsuario.php");

function responder_modificacion($codigo, $mensaje)
{
	$respuesta = new stdClass();
	$respuesta->codigo = (int)$codigo;
	$respuesta->mensaje = $mensaje;
	echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
	exit;
}

function texto_post_modificacion($campo)
{
	return isset($_POST[$campo]) ? trim((string)$_POST[$campo]) : '';
}

function entero_post_modificacion($campo)
{
	return isset($_POST[$campo]) ? (int)$_POST[$campo] : 0;
}

function es_utf8_valido_modificacion($valor)
{
	return preg_match('//u', $valor) === 1;
}

function fecha_valida_modificacion($fecha)
{
	$objFecha = DateTime::createFromFormat('Y-m-d', $fecha);
	return $objFecha && $objFecha->format('Y-m-d') === $fecha;
}

function password_segura_modificacion($password)
{
	if (strlen($password) > 72) {
		return false;
	}
	return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/', $password) === 1;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
	responder_modificacion(2, 'Método no permitido');
}

if (!isset($_SESSION['id_ls']) || !isset($_SESSION['user_ls']) || !isset($_SESSION['nombre_ls'])) {
	responder_modificacion(3, 'Se ha agotado el tiempo de conexión. Inicie sesión');
}

$camposRequeridos = array(
	'id',
	'dni',
	'user',
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
		responder_modificacion(8, 'Falta el campo obligatorio: ' . $campo);
	}
}

if (!isset($_POST['arr_items']) || !is_array($_POST['arr_items']) || count($_POST['arr_items']) === 0) {
	responder_modificacion(8, 'Debe seleccionar por lo menos un horario');
}

$idPersonal = entero_post_modificacion('id');
$estado = entero_post_modificacion('estado') === 1 ? 1 : 0;
$apellidos = texto_post_modificacion('apellidos');
$nombres = texto_post_modificacion('nombre');
$dni = texto_post_modificacion('dni');
$usuario = texto_post_modificacion('user');
$password = isset($_POST['password']) ? (string)$_POST['password'] : '';
$fechaNacimiento = texto_post_modificacion('fechanac');
$fechaIngreso = texto_post_modificacion('fechaing');
$fechaBaja = texto_post_modificacion('fechabaja');
$direccion = texto_post_modificacion('direccion');
$distrito = texto_post_modificacion('distrito');
$departamento = texto_post_modificacion('departamento');
$referencia = texto_post_modificacion('referencia');
$email = texto_post_modificacion('email');
$telefono = texto_post_modificacion('telefono');
$movil = texto_post_modificacion('movil');

$sexo = entero_post_modificacion('sexo');
$estadoCivil = entero_post_modificacion('ec');
$cargaFamiliar = entero_post_modificacion('fam');
$hijos = entero_post_modificacion('hijos');
$gradoInstruccion = entero_post_modificacion('gi');
$cargo = entero_post_modificacion('cargo');
$sucursal = entero_post_modificacion('suc');
$cartera = entero_post_modificacion('cartera');
$refrigerio = entero_post_modificacion('refrigerio');
$idUsuarioModifica = (int)$_SESSION['id_ls'];

if ($idPersonal <= 0) {
	responder_modificacion(8, 'Identificador de personal inválido');
}

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
	if (!es_utf8_valido_modificacion($valorCampo)) {
		responder_modificacion(9, 'El campo ' . $nombreCampo . ' contiene una codificación inválida');
	}
}

if (!fecha_valida_modificacion($fechaNacimiento) || !fecha_valida_modificacion($fechaIngreso)) {
	responder_modificacion(9, 'Las fechas deben usar el formato YYYY-MM-DD');
}

if ($fechaBaja === '') {
	$fechaBaja = '0000-00-00';
} elseif ($fechaBaja !== '0000-00-00' && !fecha_valida_modificacion($fechaBaja)) {
	responder_modificacion(9, 'La fecha de cese debe usar el formato YYYY-MM-DD');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
	responder_modificacion(9, 'Email inválido');
}

if ($hijos < 0) {
	responder_modificacion(9, 'La cantidad de hijos no puede ser negativa');
}

if (strlen($dni) < 8 || strlen($dni) > 10) {
	responder_modificacion(9, 'El documento debe tener entre 8 y 10 caracteres');
}

if ($password !== '' && !password_segura_modificacion($password)) {
	responder_modificacion(6, 'La nueva contraseña debe tener entre 8 y 72 caracteres e incluir mayúscula, minúscula, número y símbolo especial');
}

if ($password !== '' && clsUsuario::verificar_password($password, $idPersonal)) {
	responder_modificacion(7, 'La nueva contraseña no puede coincidir con una de las últimas contraseñas utilizadas');
}

if ($sexo <= 0 || $estadoCivil <= 0 || $cargo <= 0 || $gradoInstruccion <= 0 || $sucursal <= 0 || $cartera <= 0 || $refrigerio <= 0) {
	responder_modificacion(8, 'Uno o más campos de selección son inválidos');
}

if (!clsUsuario::validar_refrigerio($refrigerio)) {
	responder_modificacion(10, 'La hora de almuerzo seleccionada no está disponible');
}

$verificarSesion = clsUsuario::verificar_sesion($idUsuarioModifica);
$verificarDni = clsUsuario::verificar_dni_update($dni, $idPersonal);
$verificarUsuario = clsUsuario::verificar_nombre_user_update($usuario, $idPersonal);

if (count($verificarSesion) === 0) {
	responder_modificacion(3, 'Usuario no válido. Inicie sesión nuevamente');
}
if (count($verificarDni) > 0) {
	responder_modificacion(4, 'Ya existe otro usuario registrado con el documento: ' . $dni);
}
if (count($verificarUsuario) > 0) {
	responder_modificacion(5, 'El usuario ' . $usuario . ' ya pertenece a otra persona');
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
	responder_modificacion(8, 'Debe seleccionar por lo menos un horario válido');
}

$passwordActualizar = $password === '' ? null : $password;

$actualizado = clsUsuario::update_empleado(
	$idPersonal,
	$estado,
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
	$passwordActualizar,
	$cartera,
	$fechaIngreso,
	$fechaBaja,
	$idUsuarioModifica,
	$refrigerio,
	$horarios
);

if (!$actualizado) {
	responder_modificacion(11, 'No se pudo modificar el personal. No se guardaron cambios incompletos');
}

responder_modificacion(1, 'Modificado correctamente');

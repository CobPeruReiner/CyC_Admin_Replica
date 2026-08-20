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

function normalizar_fecha_modificacion($fecha)
{
	$fecha = trim((string)$fecha);
	if ($fecha === '') {
		return false;
	}

	if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})(?:[ T].*)?$/', $fecha, $m)) {
		$anio = (int)$m[1];
		$mes = (int)$m[2];
		$dia = (int)$m[3];
		return checkdate($mes, $dia, $anio) ? sprintf('%04d-%02d-%02d', $anio, $mes, $dia) : false;
	}

	if (preg_match('/^(\d{1,2})[\/.\-](\d{1,2})[\/.\-](\d{4})(?:\s.*)?$/', $fecha, $m)) {
		$dia = (int)$m[1];
		$mes = (int)$m[2];
		$anio = (int)$m[3];
		return checkdate($mes, $dia, $anio) ? sprintf('%04d-%02d-%02d', $anio, $mes, $dia) : false;
	}

	$fechaTexto = preg_replace('/\s+/', ' ', str_replace(',', ' ', $fecha));
	$fechaTexto = trim($fechaTexto);
	$meses = array(
		'enero' => 1,
		'january' => 1,
		'jan' => 1,
		'febrero' => 2,
		'february' => 2,
		'feb' => 2,
		'marzo' => 3,
		'march' => 3,
		'mar' => 3,
		'abril' => 4,
		'april' => 4,
		'apr' => 4,
		'mayo' => 5,
		'may' => 5,
		'junio' => 6,
		'june' => 6,
		'jun' => 6,
		'julio' => 7,
		'july' => 7,
		'jul' => 7,
		'agosto' => 8,
		'august' => 8,
		'aug' => 8,
		'septiembre' => 9,
		'setiembre' => 9,
		'september' => 9,
		'sep' => 9,
		'sept' => 9,
		'octubre' => 10,
		'october' => 10,
		'oct' => 10,
		'noviembre' => 11,
		'november' => 11,
		'nov' => 11,
		'diciembre' => 12,
		'december' => 12,
		'dec' => 12
	);

	if (preg_match('/^(\d{1,2})\s+([[:alpha:]áéíóúñü\.]+)\s+(\d{4})$/iu', $fechaTexto, $m)) {
		$dia = (int)$m[1];
		$nombreMes = strtolower(rtrim($m[2], '.'));
		$anio = (int)$m[3];
		if (isset($meses[$nombreMes]) && checkdate($meses[$nombreMes], $dia, $anio)) {
			return sprintf('%04d-%02d-%02d', $anio, $meses[$nombreMes], $dia);
		}
	}

	if (preg_match('/^([[:alpha:]áéíóúñü\.]+)\s+(\d{1,2})\s+(\d{4})$/iu', $fechaTexto, $m)) {
		$nombreMes = strtolower(rtrim($m[1], '.'));
		$dia = (int)$m[2];
		$anio = (int)$m[3];
		if (isset($meses[$nombreMes]) && checkdate($meses[$nombreMes], $dia, $anio)) {
			return sprintf('%04d-%02d-%02d', $anio, $meses[$nombreMes], $dia);
		}
	}

	return false;
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
$estadoSolicitado = entero_post_modificacion('estado');
$estado = in_array($estadoSolicitado, array(0, 1, 4), true) ? $estadoSolicitado : 0;
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
$idGrupoCartera = entero_post_modificacion('id_grupo_cartera');
/* Solo los cargos operativos administran cartera principal. */
if (!clsUsuario::cargo_requiere_cartera($cargo)) {
	$cartera = 0;
	$idGrupoCartera = 0;
} elseif ($cartera <= 0) {
	$idGrupoCartera = 0;
}
if ($cargo === 15) {
	$idGrupoCartera = 0;
}
$refrigerio = entero_post_modificacion('refrigerio');
$idUsuarioModifica = (int)$_SESSION['id_ls'];

if ($idPersonal <= 0) {
	responder_modificacion(8, 'Identificador de personal inválido');
}

$datosPersonalActual = clsUsuario::select_user($idPersonal);
if (empty($datosPersonalActual)) {
	responder_modificacion(8, 'El personal indicado no existe');
}
$carteraActual = isset($datosPersonalActual['id_cartera']) ? (int)$datosPersonalActual['id_cartera'] : 0;
$grupoCarteraActual = isset($datosPersonalActual['id_grupo_cartera']) ? (int)$datosPersonalActual['id_grupo_cartera'] : 0;
$estadoActual = isset($datosPersonalActual['IDESTADO']) ? (int)$datosPersonalActual['IDESTADO'] : 0;

/*
 * IDESTADO=4 representa vacaciones. Se conserva en modificaciones normales.
 * El cese se procesa únicamente por la opción Dar de baja.
 */
if ($estadoActual === 4) {
	$estado = 4;
}

if (($estadoActual === 1 || $estadoActual === 4) && $estado === 0) {
	responder_modificacion(8, 'Para registrar una baja, use la opción Dar de baja del listado.');
}

if ($estadoActual === 4 && ($carteraActual !== $cartera || $grupoCarteraActual !== $idGrupoCartera || (int)$datosPersonalActual['CARGO'] !== $cargo)) {
	responder_modificacion(8, 'El personal se encuentra de vacaciones. El cargo o la cartera deben modificarse cuando retorne a estado activo.');
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

$fechaNacimientoNormalizada = normalizar_fecha_modificacion($fechaNacimiento);
if ($fechaNacimientoNormalizada === false) {
	error_log('Fecha de nacimiento inválida en modificación: ' . json_encode($fechaNacimiento));
	responder_modificacion(9, 'La fecha de nacimiento no es válida. Use DD/MM/YYYY o YYYY-MM-DD');
}
$fechaNacimiento = $fechaNacimientoNormalizada;

$fechaIngresoNormalizada = normalizar_fecha_modificacion($fechaIngreso);
if ($fechaIngresoNormalizada === false) {
	error_log('Fecha de ingreso inválida en modificación: ' . json_encode($fechaIngreso));
	responder_modificacion(9, 'La fecha de ingreso no es válida. Use DD/MM/YYYY o YYYY-MM-DD');
}
$fechaIngreso = $fechaIngresoNormalizada;

if ($fechaBaja === '' || substr($fechaBaja, 0, 10) === '0000-00-00') {
	$fechaBaja = '0000-00-00';
} else {
	$fechaBajaNormalizada = normalizar_fecha_modificacion($fechaBaja);
	if ($fechaBajaNormalizada === false) {
		error_log('Fecha de cese inválida en modificación: ' . json_encode($fechaBaja));
		responder_modificacion(9, 'La fecha de cese no es válida. Use DD/MM/YYYY o YYYY-MM-DD');
	}
	$fechaBaja = $fechaBajaNormalizada;
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

if ($sexo <= 0 || $estadoCivil <= 0 || $cargo <= 0 || $gradoInstruccion <= 0 || $sucursal <= 0 || $refrigerio <= 0) {
	responder_modificacion(8, 'Uno o más campos de selección son inválidos');
}

/*
 * En vacaciones el contexto ya fue comparado contra el registro actual y no
 * puede cambiar. Evitamos revalidar su contexto durante vacaciones para que
 * una edición de datos generales no falle por cambios externos de cartera.
 */
if ($estadoActual !== 4) {
	if (clsUsuario::cargo_requiere_cartera($cargo) && $cartera <= 0) {
		responder_modificacion(8, 'Debe seleccionar una cartera para el cargo elegido');
	}

	if ($cartera > 0 && !clsUsuario::validar_grupo_cartera($cartera, $idGrupoCartera, $cargo)) {
		responder_modificacion(8, 'Debe seleccionar un grupo válido para la cartera elegida');
	}

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
	$idGrupoCartera,
	$fechaIngreso,
	$fechaBaja,
	$idUsuarioModifica,
	$refrigerio,
	$horarios
);

if (!$actualizado) {
	$mensaje = clsUsuario::ultimo_mensaje_usuario();
	responder_modificacion(11, $mensaje !== '' ? $mensaje : 'No se pudieron guardar los cambios. Intente nuevamente.');
}

$estadoAnterior = isset($datosPersonalActual['IDESTADO']) ? (int)$datosPersonalActual['IDESTADO'] : 0;
if ($estadoAnterior === 0 && $estado === 1) {
	$mensajeExito = in_array($cargo, array(15, 16), true)
		? 'Reingreso guardado. Revise la responsabilidad de cartera.'
		: 'Reingreso registrado correctamente.';
} elseif ($estadoAnterior === 1 && $estado === 0) {
	$mensajeExito = 'Baja registrada correctamente.';
} else {
	$mensajeExito = 'Cambios guardados correctamente.';
}
responder_modificacion(1, $mensajeExito);

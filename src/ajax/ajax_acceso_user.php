<?php
session_start();

$responce = new stdClass();
$responce->codigo = 0;

require_once("../php/clsUsuario.php");
require_once("../php/clsOtp.php");
require_once("../php/clsMailer.php");
require_once("../php/clsCaptcha.php");

$usuario = $_REQUEST['username'];
$password = $_REQUEST['password'];
$captcha = isset($_REQUEST['captcha']) ? $_REQUEST['captcha'] : null;

$ip = $_SERVER['REMOTE_ADDR'];

/* validar captcha */
if (!clsCaptcha::verificar($captcha, $ip)) {
	$responce->codigo = 0;
	$responce->mensaje = "Captcha inválido";
	echo json_encode($responce);
	exit;
}

/* validar usuario/password */
$arr_datos = clsUsuario::acceso($usuario, $password);

if (sizeof($arr_datos) != 1) {

	$intentos = clsUsuario::incAttempts($usuario);

	if ($intentos >= 3)
		clsUsuario::bloquearUsuario($usuario);

	$responce->codigo = 0;
	$responce->mensaje = "Usuario o Password incorrecto";
	$responce->intentos = $intentos;

	echo json_encode($responce);
	exit;
}

/* reset intentos */
clsUsuario::resetAttempts($usuario);

/* generar OTP */
$otp = clsOtp::generar();

session_start();

clsOtp::guardar($usuario, $otp);

/* enviar correo */
clsMailer::enviarCodigo(
	$arr_datos[0]["email"],
	$arr_datos[0]["empleado"],
	$otp
);

/* guardar temporal */
$_SESSION["tmp_user"] = $arr_datos[0];

$responce->codigo = 4;
$responce->mensaje = "OTP enviado";

echo json_encode($responce);

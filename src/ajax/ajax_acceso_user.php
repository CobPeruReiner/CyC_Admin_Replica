<?php
session_start();

$responce = new stdClass();
$responce->codigo = 0;
$responce->mensaje = "Error";
$responce->intentos = 0;

require_once("../php/clsUsuario.php");
require_once("../php/clsOtp.php");
require_once("../php/clsMailer.php");
require_once("../php/clsCaptcha.php");

$usuario = isset($_POST['username']) ? trim($_POST['username']) : "";
$password = isset($_POST['password']) ? trim($_POST['password']) : "";
$captcha = isset($_POST['captcha']) ? $_POST['captcha'] : null;

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

	if ($intentos >= 3) {

		clsUsuario::bloquearUsuario($usuario);

		$responce->codigo = 3;
		$responce->mensaje = "Usuario bloqueado";
		$responce->intentos = $intentos;
	} else {

		$responce->codigo = 0;
		$responce->mensaje = "Usuario o contraseña incorrectos";
		$responce->intentos = $intentos;
	}

	echo json_encode($responce);
	exit;
}

/* reset intentos */
clsUsuario::resetAttempts($usuario);

/* generar OTP */
$otp = clsOtp::generar();

/* guardar OTP */
clsOtp::guardar($usuario, $otp);

/* enviar correo */
$enviado = clsMailer::enviarCodigo(
	$arr_datos[0]["email"],
	$arr_datos[0]["empleado"],
	$otp
);

/* si falla correo */
if (!$enviado) {

	error_log("Error enviando OTP a: " . $arr_datos[0]["email"]);

	$responce->codigo = 2;
	$responce->mensaje = "No se pudo enviar el código. Contacte soporte.";

	echo json_encode($responce);
	exit;
}

/* guardar sesión temporal */
$_SESSION["tmp_user"] = $arr_datos[0];

/* éxito */
$responce->codigo = 4;
$responce->mensaje = "OTP enviado";

echo json_encode($responce);

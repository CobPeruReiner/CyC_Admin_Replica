<?php
session_start();

$responce = new stdClass();
$responce->codigo = 0;
$responce->mensaje = "Error";

require_once("../php/clsUsuario.php");
require_once("../php/clsOtp.php");
require_once("../php/clsMailer.php");

$doc = isset($_POST['doc']) ? trim($_POST['doc']) : "";

if ($doc == "") {
  $responce->codigo = 0;
  $responce->mensaje = "Ingrese su DNI";
  echo json_encode($responce);
  exit;
}

/* buscar usuario por DNI */
$arr_datos = clsUsuario::getByDocumento($doc);

if (sizeof($arr_datos) != 1) {
  $responce->codigo = 0;
  $responce->mensaje = "No existe un usuario activo con ese DNI";
  echo json_encode($responce);
  exit;
}

/* generar OTP */
$otp = clsOtp::generar();

/* guardar OTP recovery */
clsOtp::guardarRecovery($doc, $otp);

/* enviar correo */
$enviado = clsMailer::enviarCodigoRecuperacion(
  $arr_datos[0]["email"],
  $arr_datos[0]["empleado"],
  $otp
);

if (!$enviado) {
  error_log("Error enviando OTP recovery a: " . $arr_datos[0]["email"]);

  $responce->codigo = 0;
  $responce->mensaje = "No se pudo enviar el código. Contacte soporte.";
  echo json_encode($responce);
  exit;
}

/* guardar sesión temporal */
$_SESSION["recovery_doc"] = $doc;
$_SESSION["recovery_otp_verified"] = false;

/* éxito */
$responce->codigo = 1;
$responce->mensaje = "Se envió un código a su correo";

echo json_encode($responce);

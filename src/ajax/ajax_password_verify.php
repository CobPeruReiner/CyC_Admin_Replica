<?php
session_start();

$responce = new stdClass();
$responce->codigo = 0;
$responce->mensaje = "Error";

require_once("../php/clsOtp.php");

$doc = isset($_POST['doc']) ? trim($_POST['doc']) : "";
$otp = isset($_POST['otp']) ? trim($_POST['otp']) : "";

if ($doc == "" || $otp == "") {
  $responce->codigo = 0;
  $responce->mensaje = "Datos incompletos";
  echo json_encode($responce);
  exit;
}

if (!isset($_SESSION["recovery_doc"]) || $_SESSION["recovery_doc"] !== $doc) {
  $responce->codigo = 0;
  $responce->mensaje = "La sesión de recuperación expiró";
  echo json_encode($responce);
  exit;
}

/* verificar OTP recovery */
$ok = clsOtp::verificarRecovery($doc, $otp);

if (!$ok) {
  $responce->codigo = 0;
  $responce->mensaje = "Código inválido o expirado";
  echo json_encode($responce);
  exit;
}

$_SESSION["recovery_otp_verified"] = true;

$responce->codigo = 1;
$responce->mensaje = "Código verificado";

echo json_encode($responce);

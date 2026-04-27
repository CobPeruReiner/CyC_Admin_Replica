<?php
session_start();

$responce = new stdClass();
$responce->codigo = 0;
$responce->mensaje = "Error";

require_once("../php/clsUsuario.php");

$doc = isset($_POST['doc']) ? trim($_POST['doc']) : "";
$password = isset($_POST['password']) ? trim($_POST['password']) : "";

if ($doc == "" || $password == "") {
  $responce->codigo = 0;
  $responce->mensaje = "Datos incompletos";
  echo json_encode($responce);
  exit;
}

if (
  !isset($_SESSION["recovery_doc"]) ||
  $_SESSION["recovery_doc"] !== $doc ||
  !isset($_SESSION["recovery_otp_verified"]) ||
  $_SESSION["recovery_otp_verified"] !== true
) {
  $responce->codigo = 0;
  $responce->mensaje = "La sesión de recuperación expiró";
  echo json_encode($responce);
  exit;
}

/* actualizar password */
$result = clsUsuario::updatePasswordByDocumento($doc, $password);

if (!$result["ok"]) {
  $responce->codigo = 0;
  $responce->mensaje = $result["mensaje"];
  echo json_encode($responce);
  exit;
}

/* limpiar sesión recovery */
unset($_SESSION["recovery_doc"]);
unset($_SESSION["recovery_otp_verified"]);

if (isset($_SESSION["otp_recovery_by_doc"][$doc])) {
  unset($_SESSION["otp_recovery_by_doc"][$doc]);
}

$responce->codigo = 1;
$responce->mensaje = "Contraseña actualizada correctamente";

echo json_encode($responce);

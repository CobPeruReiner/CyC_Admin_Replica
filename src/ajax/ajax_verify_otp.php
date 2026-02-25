<?php

require_once("../php/clsOtp.php");
require_once("../php/clsUsuario.php");

session_start();

$res = new stdClass();
$res->codigo = 0;
$res->mensaje = "Error";

$usuario = isset($_POST["usuario"]) ? trim($_POST["usuario"]) : "";
$otp = isset($_POST["otp"]) ? trim($_POST["otp"]) : "";

/* validar sesión temporal */
if (!isset($_SESSION["tmp_user"])) {

  $res->codigo = 2;
  $res->mensaje = "Sesión expirada";

  echo json_encode($res);
  exit;
}

/* validar OTP */
if (!clsOtp::verificar($usuario, $otp)) {

  $res->codigo = 0;
  $res->mensaje = "Código incorrecto";

  echo json_encode($res);
  exit;
}

/* obtener usuario */
$user = $_SESSION["tmp_user"];

/* crear sesión final */
$_SESSION['nombre_ls'] = $user['empleado'];
$_SESSION['tipo_ls']   = $user['tipo'];
$_SESSION['user_ls']   = $user['usuario'];
$_SESSION['id_ls']     = $user['idpersonal'];

/* registrar logeo */
$verificar = clsUsuario::verificar_logeo($user['idpersonal'], 'IN');

if (sizeof($verificar) == 0) {

  clsUsuario::registrar_user_in($user['idpersonal']);
}

/* limpiar sesión temporal */
unset($_SESSION["tmp_user"]);

/* éxito */
$res->codigo = 1;
$res->mensaje = "Login correcto";

echo json_encode($res);

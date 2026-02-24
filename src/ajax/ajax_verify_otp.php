<?php

require_once("../php/clsOtp.php");
require_once("../php/clsUsuario.php");

session_start();

$res = new stdClass();

$usuario = $_POST["usuario"];
$otp = $_POST["otp"];

if (!clsOtp::verificar($usuario, $otp)) {

  $res->codigo = 0;
  $res->mensaje = "OTP incorrecto";
} else {

  $user = $_SESSION["tmp_user"];

  $_SESSION['nombre_ls'] = $user['empleado'];
  $_SESSION['tipo_ls']   = $user['tipo'];
  $_SESSION['user_ls']   = $user['usuario'];
  $_SESSION['id_ls']     = $user['idpersonal'];

  $verificar = clsUsuario::verificar_logeo($user['idpersonal'], 'IN');

  if (sizeof($verificar) == 0)
    clsUsuario::registrar_user_in($user['idpersonal']);

  unset($_SESSION["tmp_user"]);

  $res->codigo = 1;
}

echo json_encode($res);

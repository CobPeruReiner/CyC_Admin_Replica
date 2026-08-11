<?php
date_default_timezone_set('America/Lima');
ini_set('display_errors', '0');
ini_set('log_errors', '1');
header('Content-Type: application/json; charset=utf-8');
session_start();

require_once("../php/clsUsuario.php");

$respuesta = new stdClass();
$respuesta->codigo = 0;
$respuesta->mensaje = 'No se pudo procesar la baja.';

if (!isset($_SESSION['id_ls']) || !isset($_SESSION['user_ls']) || !isset($_SESSION['nombre_ls'])) {
    $respuesta->codigo = 2;
    $respuesta->mensaje = 'La sesión terminó. Inicie sesión nuevamente.';
    echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    exit;
}

$id = isset($_POST['id']) ? (int)$_POST['id'] : (isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0);
$motivo = isset($_POST['motivo']) ? trim((string)$_POST['motivo']) : '';

if ($id <= 0) {
    $respuesta->codigo = 4;
    $respuesta->mensaje = 'No se pudo identificar al personal.';
    echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    exit;
}

if ($motivo === '') {
    $motivo = 'Baja registrada desde RR.HH.';
}
if (strlen($motivo) > 255) {
    $motivo = substr($motivo, 0, 255);
}

$verificar = clsUsuario::verificar_sesion($_SESSION['id_ls'], $_SESSION['user_ls']);
if (sizeof($verificar) == 0) {
    $respuesta->codigo = 3;
    $respuesta->mensaje = 'La sesión no es válida. Inicie sesión nuevamente.';
    echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    exit;
}

if (!clsUsuario::baja_user($id, (int)$_SESSION['id_ls'], $motivo)) {
    $respuesta->codigo = 5;
    $mensaje = clsUsuario::ultimo_mensaje_usuario();
    $respuesta->mensaje = $mensaje !== '' ? $mensaje : 'No se pudo registrar la baja.';
    echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);
    exit;
}

$respuesta->codigo = 1;
$respuesta->mensaje = 'Baja registrada correctamente.';
echo json_encode($respuesta, JSON_UNESCAPED_UNICODE);

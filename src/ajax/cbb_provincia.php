<?php
header('Content-Type: text/html; charset=UTF-8');
ini_set('display_errors', '0');
ini_set('log_errors', '1');

require_once('../php/clsSucursal.php');

$idDepartamento = isset($_GET['id']) && is_numeric($_GET['id']) ? (int)$_GET['id'] : 0;

echo '<option value="">Seleccione Provincia</option>';

if ($idDepartamento <= 0) {
	exit;
}

$arr_datos = clsSucursal::provincias($idDepartamento);
if (!is_array($arr_datos)) {
	error_log('[cbb_provincia] clsSucursal::provincias no devolvió un arreglo.');
	exit;
}

foreach ($arr_datos as $datos) {
	$id = isset($datos['id']) ? $datos['id'] : '';
	$nombre = isset($datos['nombre']) ? $datos['nombre'] : '';
	echo '<option value="' . htmlspecialchars((string)$id, ENT_QUOTES, 'UTF-8') . '">' .
		htmlspecialchars((string)$nombre, ENT_QUOTES, 'UTF-8') .
		'</option>';
}

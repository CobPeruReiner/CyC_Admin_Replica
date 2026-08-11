<?php

require_once "global.php";

date_default_timezone_set('America/Lima');

$conexion = new mysqli(
	DB_HOST,
	DB_USERNAME,
	DB_PASSWORD,
	DB_NAME
);

if (mysqli_connect_errno()) {
	printf(
		"Ups parece que falló en la conexion con la base de datos: %s\n",
		mysqli_connect_error()
	);
	exit();
}

mysqli_query(
	$conexion,
	'SET NAMES "' . DB_ENCODE . '"'
);

/*
 * Zona horaria de la sesión MariaDB.
 * Perú = UTC-05:00 todo el año.
 */
if (!mysqli_query($conexion, "SET time_zone = '-05:00'")) {
	error_log(
		'No se pudo establecer timezone MariaDB: '
			. mysqli_error($conexion)
	);
}

if (!function_exists('ejecutarConsulta')) {

	function ejecutarConsulta($sql)
	{
		global $conexion;

		return $conexion->query($sql);
	}

	function ejecutarConsultaSimpleFila($sql)
	{
		global $conexion;

		$query = $conexion->query($sql);

		return $query->fetch_assoc();
	}

	function ejecutarConsulta_retornarID($sql)
	{
		global $conexion;

		$conexion->query($sql);

		return $conexion->insert_id;
	}

	function limpiarCadena($str)
	{
		global $conexion;

		$str = mysqli_real_escape_string(
			$conexion,
			trim($str)
		);

		return htmlspecialchars($str);
	}
}

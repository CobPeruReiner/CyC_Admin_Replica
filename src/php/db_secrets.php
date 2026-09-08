<?php

function admin_read_secret($name)
{
	$path = "/run/secrets/" . $name;

	if (!is_readable($path)) {
		die("Secret de base de datos no disponible");
	}

	return trim(file_get_contents($path));
}

function admin_db_connection()
{
	$connection = @mysqli_connect(
		admin_read_secret("db_host"),
		admin_read_secret("db_user"),
		admin_read_secret("db_password"),
		admin_read_secret("db_name")
	);

	if (!$connection) {
		die("No se pudo conectar a la base de datos");
	}

	mysqli_set_charset($connection, "utf8");

	return $connection;
}

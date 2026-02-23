<?php
class clsConexion
{
	private $servidor;
	private $usuario;
	private $password;
	private $bd;

	private $link;

	private function secret($name)
	{
		$path = "/run/secrets/" . $name;

		if (!file_exists($path)) {
			die("Secret no encontrado: " . $name);
		}

		return trim(file_get_contents($path));
	}

	public function __construct()
	{
		$this->servidor = $this->secret("db_host");
		$this->usuario  = $this->secret("db_user");
		$this->password = $this->secret("db_password");
		$this->bd       = $this->secret("db_name");
	}

	public function conectar()
	{
		$this->link = mysql_connect(
			$this->servidor,
			$this->usuario,
			$this->password
		) or die("No se encuentra server");

		mysql_select_db($this->bd)
			or die("No se encuentra BD");
	}

	public function desconectar()
	{
		return mysql_close($this->link);
	}
}

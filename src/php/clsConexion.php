<?php
class clsConexion
{
	private $servidor = "192.168.1.31";
	//private $usuario = "cycwebcob_plataforma";
	private $usuario = "cycwebcob";
	//private $password = "dp5P99}Z@";
	private $password = "k4&{'Ba7Np1";
	private $bd = "SISTEMAGEST";

	// private $servidor = "192.168.1.39";
	// private $usuario = "raul";
	// private $password = "loquecallamoslosadmin1";
	// private $bd = "SISTEMAGEST_DESARROLLO";

	private $link;

	//echo conectar();
	public function conectar()
	{
		$this->link = mysql_connect($this->servidor, $this->usuario, $this->password) or die("No se encuentra server");
		mysql_select_db($this->bd) or die("No se encuentra BD");

		// Caracteres especiales
		// mysql_query("SET NAMES 'utf8'", $this->link);

		//mysql_set_charset('utf8', $link);
	}

	public function desconectar()
	{
		return mysql_close($this->link) or die("Error cerrando server");
	}
}

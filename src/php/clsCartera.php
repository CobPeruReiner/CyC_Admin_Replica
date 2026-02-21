<?php
date_default_timezone_set('America/Lima');
require_once "clsConexion.php";
class clsCartera
{

	public static function listar()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT a.*,c.nombre as tipo, b.nombre as cliente,if(a.estado=1,'<label>ACTIVE</label>','<label>SUSPENDED</label>') as estado,'' as opciones 
				FROM cartera a
				left join cliente b on a.idcliente=b.id
                left join tipo_cartera c on c.id=a.tipo";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos[] = array($row["id"], utf8_encode($row["cartera"]), $row["tramo"], $row["central"], $row["tipo"], utf8_encode($row["cliente"]), $row["estado"], $row["opciones"]);
		}
		$objConx->desconectar();
		if ($res)
			return $arr_datos;
		return $res;
	}

	public static function consulta_cliente()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT id,nombre FROM cliente order by nombre";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos[] = array("id" => $row["id"], "nombre" => utf8_encode($row["nombre"]));
		}
		$objConx->desconectar();
		if ($res)
			return $arr_datos;
		return $res;
	}

	public static function consulta_tipo()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT id,nombre FROM tipo_cartera order by nombre";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos[] = array("id" => $row["id"], "nombre" => utf8_encode($row["nombre"]));
		}
		$objConx->desconectar();
		if ($res)
			return $arr_datos;
		return $res;
	}


	// public static function registrar($nombre, $tipo, $tramo, $central, $idcliente)
	// {
	// 	$objConx = new clsConexion();
	// 	$objConx->conectar();
	// 	$fecha = date("Y-m-d H:i:s");
	// 	$sql = "INSERT INTO cartera VALUES(default,upper('$nombre'),'$tipo','$tramo','$central',$idcliente,'$fecha','',1)";
	// 	//echo($sql);
	// 	$res = mysql_query($sql) or die(mysql_error());
	// 	$res = mysql_insert_id();
	// 	$objConx->desconectar();
	// 	return $res;
	// }

	public static function registrar($nombre, $tipo, $tramo, $central, $idcliente)
	{
		$objConx = new clsConexion();
		$objConx->conectar();

		// Sanitiza (ext/mysql)
		$nombre    = mysql_real_escape_string($nombre);
		$tramo     = mysql_real_escape_string($tramo);
		$central   = mysql_real_escape_string($central);
		$tipo      = (int)$tipo;
		$idcliente = (int)$idcliente;

		$fecha = date("Y-m-d H:i:s");

		// Si tienes el analista en sesión, úsalo; si no, deja DEFAULT/NULL
		$idAnalista = isset($_SESSION['IDPERSONAL']) ? (int)$_SESSION['IDPERSONAL'] : 'DEFAULT';

		$sql = "INSERT INTO cartera
            (cartera, tipo, tramo, central, idcliente, fecha_registro, fecha_baja, estado, idAnalistabd)
            VALUES
            (UPPER('$nombre'), $tipo, '$tramo', '$central', $idcliente, '$fecha', DEFAULT, 1, $idAnalista)";

		$res = mysql_query($sql) or die(mysql_error());
		$id  = mysql_insert_id();
		$objConx->desconectar();
		return $id;
	}

	public static function select($id)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT * from cartera WHERE id = $id ";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos = $row;
		}
		$objConx->desconectar();
		return $arr_datos;
	}


	public static function update($id, $nombre, $tipo, $tramo, $central, $idcliente, $estado)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "UPDATE cartera set cartera=upper('$nombre'),tipo='$tipo',tramo='$tramo',central='$central',idcliente='$idcliente',estado='$estado' WHERE id =$id";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}

	public static function baja($id)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha = date("Y-m-d H:i:s");
		$sql = "UPDATE cartera set estado=0,fecha_baja='$fecha' where id='$id'";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
}

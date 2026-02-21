<?php
date_default_timezone_set('America/Lima');
require_once "clsConexion.php";
class clsCliente
{

	public static function listar()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT a.*,concat(b.apellidos,' ',b.nombres) as personal,if(estado=1,'<label>ACTIVE</label>','<label>SUSPENDED</label>') as estado,'' as opciones FROM cliente a
				left join personal b on a.idpersonal=b.idpersonal";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos[] = array($row["id"], utf8_encode($row["nombre"]), utf8_encode($row["identificador"]), utf8_encode($row["personal"]), $row["estado"], $row["opciones"]);
		}
		$objConx->desconectar();
		if ($res)
			return $arr_datos;
		return $res;
	}

	public static function consulta_personal()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT idpersonal as id,concat(apellidos,' ',nombres) as nombre FROM personal where idestado=1 order by nombre";
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


	// public static function registrar($nombre, $identificador, $idpersonal)
	// {
	// 	$objConx = new clsConexion();
	// 	$objConx->conectar();
	// 	$fecha = date("Y-m-d H:i:s");
	// 	$sql = "INSERT INTO cliente VALUES(default,upper('$nombre'),upper('$identificador'),'$idpersonal','$fecha','',1)";
	// 	//echo($sql);
	// 	$res = mysql_query($sql) or die(mysql_error());
	// 	$res = mysql_insert_id();
	// 	$objConx->desconectar();
	// 	return $res;
	// }

	public static function registrar($nombre, $identificador, $idpersonal)
	{
		$objConx = new clsConexion();
		$objConx->conectar();

		$nombre        = mysql_real_escape_string($nombre);
		$identificador = mysql_real_escape_string($identificador);

		$idpersonal_sql = ($idpersonal === '' || $idpersonal === null) ? 'NULL' : (int)$idpersonal;

		$fecha = date("Y-m-d H:i:s");

		$sql = "INSERT INTO cliente
            (nombre, identificador, idpersonal, fecha_registro, fecha_baja, estado)
            VALUES
            (UPPER('$nombre'), UPPER('$identificador'), $idpersonal_sql, '$fecha', DEFAULT, 1)";

		mysql_query($sql) or die(mysql_error());
		$id = mysql_insert_id();

		$objConx->desconectar();
		return $id;
	}


	public static function select($id)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT * from cliente WHERE id = $id ";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos = $row;
		}
		$objConx->desconectar();
		return $arr_datos;
	}


	// public static function update($id, $nombre, $identificador, $idpersonal, $estado)
	// {
	// 	$objConx = new clsConexion();
	// 	$objConx->conectar();
	// 	$sql = "UPDATE cliente set nombre=upper('$nombre'),identificador=upper('$identificador'),idpersonal='$idpersonal',estado='$estado' WHERE id =$id";
	// 	//echo($sql);
	// 	$res = mysql_query($sql) or die(mysql_error());
	// 	$res = mysql_insert_id();
	// 	$objConx->desconectar();
	// 	return $res;
	// }

	public static function update($id, $nombre, $identificador, $idpersonal, $estado)
	{
		$objConx = new clsConexion();
		$objConx->conectar();

		$id            = (int)$id;
		$estado        = (int)$estado;
		$nombre        = mysql_real_escape_string($nombre);
		$identificador = mysql_real_escape_string($identificador);
		$idpersonal_sql = ($idpersonal === '' || $idpersonal === null) ? 'NULL' : (int)$idpersonal;

		$sql = "UPDATE cliente
            SET nombre = UPPER('$nombre'),
                identificador = UPPER('$identificador'),
                idpersonal = $idpersonal_sql,
                estado = $estado
            WHERE id = $id";
		mysql_query($sql) or die(mysql_error());

		$aff = mysql_affected_rows();
		$objConx->desconectar();
		return $aff;
	}

	// public static function baja($id)
	// {
	// 	$objConx = new clsConexion();
	// 	$objConx->conectar();
	// 	$sql = "UPDATE cliente set estado=0,fecha_baja='$fecha' where id='$id'";
	// 	//echo($sql);
	// 	$res = mysql_query($sql) or die(mysql_error());
	// 	$res = mysql_insert_id();
	// 	$objConx->desconectar();
	// 	return $res;
	// }

	public static function baja($id)
	{
		$objConx = new clsConexion();
		$objConx->conectar();

		$id    = (int)$id;
		$fecha = date("Y-m-d H:i:s");

		$sql = "UPDATE cliente SET estado = 0, fecha_baja = '$fecha' WHERE id = $id";
		mysql_query($sql) or die(mysql_error());

		$aff = mysql_affected_rows();
		$objConx->desconectar();
		return $aff;
	}
}

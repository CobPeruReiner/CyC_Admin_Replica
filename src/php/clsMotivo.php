<?php
date_default_timezone_set('America/Lima');
require_once "clsConexion.php";
class clsMotivo
{

	public static function listar()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "
			SELECT a.*,b.EFECTO, c.ACCION,if(a.idestado=1,'<label>ACTIVE</label>','<label>SUSPENDED</label>') as estado,'' as opciones  FROM motivo a
			left join efecto b on a.IDEFECTO=b.IDEFECTO
			left join accion c on b.IDACCION=c.IDACCION

			";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos[] = array($row["IDMOTIVO"], utf8_encode($row["MOTIVO"]), utf8_encode($row["EFECTO"]), utf8_encode($row["ACCION"]), utf8_encode($row["DESCRIPCION"]), $row["estado"], $row["opciones"]);
		}
		$objConx->desconectar();
		if ($res)
			return $arr_datos;
		return $res;
	}


	public static function registrar($nombre, $efecto, $homologo, $descripcion)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha = date("Y-m-d H:i:s");
		$sql = "INSERT INTO motivo VALUES(default,upper('$nombre'),$efecto,'$homologo','$descripcion',1)";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}

	public static function select_motivo($id)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT * from motivo WHERE IDMOTIVO = $id ";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos = $row;
		}
		$objConx->desconectar();
		return $arr_datos;
	}


	public static function update_motivo($id, $nombre, $efecto, $homolo, $DESCRIPCION, $IDESTADO)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "UPDATE motivo set MOTIVO=upper('$nombre'),idefecto='$efecto',homolo='$homolo',DESCRIPCION='$DESCRIPCION',IDESTADO='$IDESTADO' WHERE IDMOTIVO =$id";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}

	public static function consulta_efecto()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT IDEFECTO as id,concat(efecto,' : ',b.ACCION) as nombre FROM efecto a
				left join accion b on a.IDACCION=b.IDACCION
				where a.IDESTADO=1
				order by a.EFECTO ";
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


	public static function consulta_efecto2()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT concat(IDEFECTO,'|',promesa) as id,concat(efecto,' : ',b.ACCION) as nombre FROM efecto a
				left join accion b on a.IDACCION=b.IDACCION
				where a.IDESTADO=1
				order by a.EFECTO ";
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

	public static function baja($id)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "UPDATE motivo set idestado=0 where IDMOTIVO='$id'";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
}

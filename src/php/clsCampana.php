<?php
date_default_timezone_set('America/Lima');
require_once "clsConexion.php";
class clsCampana
{

	public static function carteras()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT a.id,upper(concat(a.cartera,': ',b.nombre)) as nombre FROM cartera a
				left join cliente b on a.idcliente=b.id
				where a.estado=1 ";
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

	public static function tipos()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT * from tipo_campana
				where estado=1 ";
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


	public static function registrar($nombre, $cartera, $identificador, $tipo, $fecha_campana, $monto, $porcentaje, $homologo)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha = date("Y-m-d H:i:s");
		$sql = "INSERT INTO campanas (ID,nombre,FECHAREG,IDCARTERA,IDENTIFICADOR,TIPO,FECHACAM,MONTO,PERCENT_DESC,HOMOLO,IDESTADO) VALUES (default,upper('$nombre'),'$fecha','$cartera','$identificador','$tipo','$fecha_campana','$monto','$porcentaje','$homologo',1)";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}


	// public static function listar()
	// {
	// 	$objConx = new clsConexion();
	// 	$objConx->conectar();
	// 	$sql = "SELECT c.*,upper(concat(a.cartera,': ',b.nombre)) as cartera,d.nombre as tipo_c,
	// 	if(c.IDESTADO=1,'<label>ACTIVE</label>','<label>SUSPENDED</label>') as estado,'' as opciones FROM campanas c
	// 			left join cartera a  on a.id=c.IDCARTERA
	// 			left join cliente b on a.idcliente=b.id
	// 			left join tipo_campana d on c.tipo=d.id
	// 			 ";
	// 	$res = mysql_query($sql) or die(mysql_error());
	// 	//echo($sql);
	// 	$arr_datos = array();
	// 	while ($row = mysql_fetch_array($res)) {
	// 		$arr_datos[] = array($row["ID"], utf8_encode($row["nombre"]), utf8_encode($row["cartera"]), utf8_encode($row["tipo_c"]), utf8_encode($row["FECHACAM"]), $row["estado"], $row["opciones"]);
	// 	}
	// 	$objConx->desconectar();
	// 	if ($res)
	// 		return $arr_datos;
	// 	return $res;
	// }


	public static function listar($fecha = null)
	{
		$objConx = new clsConexion();
		$objConx->conectar();

		$hoy = $fecha ?: date('Y-m-d');
		if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $hoy)) $hoy = date('Y-m-d');

		$inicio = $hoy . ' 00:00:00';
		$fin    = date('Y-m-d', strtotime($hoy . ' +1 day')) . ' 00:00:00';

		$sql = "
      SELECT
        c.ID,
        c.nombre,
        UPPER(CONCAT(a.cartera, ': ', b.nombre)) AS cartera,
        d.nombre AS tipo_c,
        c.FECHACAM,
        IF(c.IDESTADO=1,'<label>ACTIVE</label>','<label>SUSPENDED</label>') AS estado,
        '' AS opciones
      FROM campanas c
      LEFT JOIN cartera a      ON a.id = c.IDCARTERA
      LEFT JOIN cliente b      ON a.idcliente = b.id
      LEFT JOIN tipo_campana d ON c.tipo = d.id
      WHERE c.FECHAREG >= '$inicio' AND c.FECHAREG < '$fin'
      ORDER BY c.ID DESC
    ";

		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_assoc($res)) {
			// Id | Nombre | Cartera | Tipo | Fecha (FECHACAM) | Estado | Opciones
			$arr_datos[] = array(
				(int)$row["ID"],
				utf8_encode($row["nombre"]),
				utf8_encode($row["cartera"]),
				utf8_encode($row["tipo_c"]),
				utf8_encode($row["FECHACAM"]),
				$row["estado"],
				$row["opciones"]
			);
		}
		$objConx->desconectar();
		return $arr_datos;
	}


	public static function select($id)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT *,date(FECHACAM) as fecha,time(FECHACAM) as hora from campanas WHERE ID = $id ";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos = $row;
		}
		$objConx->desconectar();
		return $arr_datos;
	}

	public static function update($ID, $nombre, $cartera, $identificador, $tipo, $fecha_campana, $monto, $porcentaje, $homolo, $idestado)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "UPDATE campanas set nombre=upper('$nombre'),IDCARTERA='$cartera',IDENTIFICADOR='$identificador',TIPO='$tipo',FECHACAM='$fecha_campana',MONTO='$monto',PERCENT_DESC='$porcentaje',HOMOLO='$homolo',IDESTADO='$idestado' WHERE ID =$ID";
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
		$sql = "UPDATE campanas set IDESTADO=0 where ID='$id'";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
}

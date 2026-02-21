<?php
date_default_timezone_set('America/Lima');
require_once "clsConexion.php";
class clsCuota
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



	public static function registrar($nombre, $cartera, $identificador, $tipo, $fecha_cuota, $monto, $homologo)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha = date("Y-m-d H:i:s");
		$sql = "INSERT INTO cuotas (IDCUOTA,CUOTA,FECHAREG,IDCARTERA,IDENTIFICADOR,TIPO,FECHACUO,MONTO,HOMOLO,IDESTADO) VALUES (default,upper('$nombre'),'$fecha','$cartera','$identificador','$tipo','$fecha_cuota','$monto','$homologo',1)";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}


	// public static function listar() {
	// 	$objConx = new clsConexion();
	// 	$objConx->conectar();
	// 	$sql = "SELECT c.*,upper(concat(a.cartera,': ',b.nombre)) as cartera,
	// 	if(c.IDESTADO=1,'<label>ACTIVE</label>','<label>SUSPENDED</label>') as estado,'' as opciones FROM cuotas c
	// 			left join cartera a  on a.id=c.IDCARTERA
	// 			left join cliente b on a.idcliente=b.id
	// 			 ";
	// 	$res = mysql_query($sql) or die(mysql_error());
	// 	//echo($sql);
	// 	$arr_datos = array();
	// 	while($row = mysql_fetch_array($res)) {  
	// 		  $arr_datos[] = array($row["IDCUOTA"],utf8_encode($row["CUOTA"]),utf8_encode($row["cartera"]),utf8_encode($row["TIPO"]),utf8_encode($row["FECHACUO"]),$row["estado"],$row["opciones"]);
	// 	}
	// 	$objConx->desconectar();
	// 	if ($res)
	// 	return $arr_datos;
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
        c.IDCUOTA,
        c.CUOTA,
        UPPER(CONCAT(a.cartera, ': ', b.nombre)) AS cartera,
        c.TIPO,
        c.FECHACUO,
        IF(c.IDESTADO=1,'<label>ACTIVE</label>','<label>SUSPENDED</label>') AS estado,
        '' AS opciones
      FROM cuotas c
      LEFT JOIN cartera a ON a.id = c.IDCARTERA
      LEFT JOIN cliente b ON a.idcliente = b.id
      WHERE c.FECHAREG >= '$inicio' AND c.FECHAREG < '$fin'
      ORDER BY c.IDCUOTA DESC
    ";

		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_assoc($res)) {
			$arr_datos[] = array(
				(int)$row["IDCUOTA"],
				utf8_encode($row["CUOTA"]),
				utf8_encode($row["cartera"]),
				utf8_encode($row["TIPO"]),
				utf8_encode($row["FECHACUO"]),
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
		$sql = "SELECT *,date(FECHACUO) as fecha,time(FECHACUO) as hora from cuotas WHERE IDCUOTA = $id ";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos = $row;
		}
		$objConx->desconectar();
		return $arr_datos;
	}

	public static function update($ID, $nombre, $cartera, $identificador, $tipo, $fecha_cuota, $monto, $homologo, $idestado)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "UPDATE cuotas set CUOTA=upper('$nombre'),IDCARTERA='$cartera',IDENTIFICADOR='$identificador',TIPO='$tipo',FECHACUO='$fecha_cuota',MONTO='$monto',HOMOLO='$homologo',IDESTADO='$idestado' WHERE IDCUOTA =$ID";
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
		$sql = "UPDATE cuotas set IDESTADO=0 where IDCUOTA='$id'";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
}

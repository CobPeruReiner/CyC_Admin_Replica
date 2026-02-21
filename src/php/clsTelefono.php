<?php
date_default_timezone_set('America/Lima');
require_once "clsConexion.php";
class clsTelefono
{

	public static function personal()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT a.idpersonal as id,upper(concat(a.apellidos,', ',a.nombres)) as nombre FROM personal a
				where a.IDESTADO=1 ";
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

	public static function operador()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT id,nombre from operador where estado=1 ";
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



	public static function registrar($documento, $fuente, $numero, $tipo, $operador, $personal)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha = date("Y-m-d H:i:s");
		$sql = "INSERT INTO telefonos (IDTELEFONO,DOC,FECHAREG,FUENTE,NUMERO,TIPO,OPERADOR,IDPERSONAL,IDESTADO) VALUES (default,'$documento','$fecha',upper('$fuente'),'$numero','$tipo','$operador','$personal',1)";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}

	public static function update($ID, $documento, $fuente, $numero, $tipo, $operador, $personal, $idestado)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "UPDATE telefonos set DOC='$documento',FUENTE=upper('$fuente'),NUMERO='$numero',TIPO='$tipo',OPERADOR='$operador',IDPERSONAL='$personal',IDESTADO='$idestado' WHERE IDTELEFONO  =$ID";
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
	// 	$sql = "SELECT c.*,upper(concat(a.apellidos,', ',a.nombres)) as personal,d.nombre as operador_nombre,
	// 	if(c.IDESTADO=1,'<label>ACTIVE</label>','<label>SUSPENDED</label>') as estado,'' as opciones 
	//       FROM telefonos c
	// 			left join personal a  on a.idpersonal=c.idpersonal
	// 			left join operador d on c.operador=d.id
	// 			 ";
	// 	$res = mysql_query($sql) or die(mysql_error());
	// 	//echo($sql);
	// 	$arr_datos = array();
	// 	while ($row = mysql_fetch_array($res)) {
	// 		$arr_datos[] = array($row["IDTELEFONO"], utf8_encode($row["NUMERO"]), utf8_encode($row["FUENTE"]), utf8_encode($row["operador_nombre"]), utf8_encode($row["personal"]), $row["estado"], $row["opciones"]);
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
        c.IDTELEFONO,
        c.NUMERO,
        c.FUENTE,
        d.nombre AS operador_nombre,
        UPPER(CONCAT(a.apellidos, ', ', a.nombres)) AS personal,
        IF(c.IDESTADO=1,'<label>ACTIVE</label>','<label>SUSPENDED</label>') AS estado,
        '' AS opciones
      FROM telefonos c
      LEFT JOIN personal a ON a.idpersonal = c.idpersonal
      LEFT JOIN operador d ON c.operador = d.id
      WHERE c.FECHAREG >= '$inicio' AND c.FECHAREG < '$fin'
      ORDER BY c.IDTELEFONO DESC
    ";

		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_assoc($res)) {
			$arr_datos[] = array(
				(int)$row["IDTELEFONO"],
				utf8_encode($row["NUMERO"]),
				utf8_encode($row["FUENTE"]),
				utf8_encode($row["operador_nombre"]),
				utf8_encode($row["personal"]),
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
		$sql = "SELECT * from telefonos WHERE IDTELEFONO = $id ";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos = $row;
		}
		$objConx->desconectar();
		return $arr_datos;
	}



	public static function baja($id)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "UPDATE telefonos set IDESTADO=0 where IDTELEFONO='$id'";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
}

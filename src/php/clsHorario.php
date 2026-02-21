<?php
date_default_timezone_set('America/Lima');
require_once "clsConexion.php";
class clsHorario
{

	public static function horarios()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT id,upper(nombre) as nombre FROM horario_dia where estado=1 ";
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

	public static function registrar($nombre, $inicio, $fin, $break, $refri, $tipo, $break2, $refri2)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha = date("Y-m-d H:i:s");
		$sql = "INSERT INTO horario (IDHORARIO,HORARIO,HORAINICIO,HORAFIN,BREAK,HORA_REF,break2,refri2,DIAS,IDESTADO) VALUES (default,upper('$nombre'),'$inicio','$fin','$break','$refri','$break2','$refri2',$tipo,1)";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}


	public static function listar()
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT a.*,b.nombre as tipo,if(IDESTADO=1,'<label>ACTIVE</label>','<label>SUSPENDED</label>') as estado,'' as opciones FROM horario a 
				left join horario_dia b on a.DIAS=b.id ";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos[] = array($row["IDHORARIO"], utf8_encode($row["HORARIO"]), utf8_encode($row["tipo"]), $row["HORAINICIO"], $row["HORAFIN"], $row["estado"], $row["opciones"]);
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
		$id = intval($id);
		$sql = "UPDATE horario SET IDESTADO = 0 WHERE IDHORARIO = $id";
		$res = mysql_query($sql) or die(mysql_error());
		$objConx->desconectar();
		return (bool)$res;
	}


	public static function select_horario($id)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT * from horario WHERE idhorario = $id ";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while ($row = mysql_fetch_array($res)) {
			$arr_datos = $row;
		}
		$objConx->desconectar();
		return $arr_datos;
	}

	public static function update_horario($IDHORARIO, $HORARIO, $HORAINICIO, $HORAFIN, $BREAK, $HORA_REF, $break2, $refri2, $DIAS, $IDESTADO)
	{
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha = date("Y-m-d H:i:s");
		$sql = "UPDATE horario set HORARIO=upper('$HORARIO'),HORAINICIO='$HORAINICIO',HORAFIN='$HORAFIN',BREAK='$BREAK',HORA_REF='$HORA_REF',break2='$break2',refri2='$refri2',DIAS='$DIAS',IDESTADO='$IDESTADO' WHERE IDHORARIO =$IDHORARIO";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
}

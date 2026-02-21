<?php
date_default_timezone_set('America/Lima');
require_once "clsConexion.php";
class clsFile{
	
	public static function consulta_norma(){
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "select B.id as value, A.nombre as sector,B.nombre as norma from sector A
				inner JOIN normas_iso B on A.id=B.id_sector order by A.nombre";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {
			  $arr_datos[] = array($row["value"],utf8_encode($row["sector"]),utf8_encode($row["norma"]));
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}

	public static function consulta_archivo(){
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT id,nombre FROM tipo_archivo where estado_activo=1 order by nombre ";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {
			  $arr_datos[] = array("id"=>$row["id"],"nombre"=>utf8_encode($row["nombre"]));
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}  

	public static function consulta_languages(){
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT id,nombre FROM language where estado_activo=1 order by nombre ";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {
			  $arr_datos[] = array("id"=>$row["id"],"nombre"=>utf8_encode($row["nombre"]));
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	} 


	public static function registrar($id_norma,$id_version,$id_language,$fecha_caducidad,$estado,$size) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha=date("Y-m-d H:i:s");
		$sql = "INSERT INTO file (id_norma,id_version,id_language,fecha_caducidad,fecha_registro,status,size) VALUES('$id_norma','$id_version','$id_language','$fecha_caducidad','$fecha','$estado','$size')";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
	public static function actualizar_ruta_id($id, $ruta,$extension) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "UPDATE file set fichero='$ruta',extension='$extension' where id = $id";
		$res = mysql_query($sql) or die(mysql_error());
		//	res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
	

}
?>
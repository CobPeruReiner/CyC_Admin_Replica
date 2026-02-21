<?php
date_default_timezone_set('America/Lima');
require_once "clsConexion.php";
class clsSector{
	
	public static function listar_sector() {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT id,nombre,fecha_create,if(estado_activo=1,'<label>ACTIVE</label>','<label>SUSPENDED</label>') as estado,'' as opciones
		FROM sector";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {  
			  $arr_datos[] = array($row["id"],utf8_encode($row["nombre"]),$row["fecha_create"],$row["estado"],$row["opciones"]);
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}

	public static function verificar_nombre($nombre){		
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "select * from sector where nombre='$nombre'";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)){
			$arr_datos[]=$row;
		}
		$objConx->desconectar();
		return $arr_datos;
	}
	
	public static function verificar_nombre_update($nombre,$id){		
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "select * from sector where nombre='$nombre' and id=$id";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)){
			$arr_datos[]=$row;
		}
		$objConx->desconectar();
		return $arr_datos;
	}

	public static function registrar($nombre) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha=date("Y-m-d H:i:s");
		$sql = "INSERT INTO sector VALUES(default,upper('$nombre'),'$fecha',1)";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}

	public static function update($id,$nombre) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha=date("Y-m-d H:i:s");
		$sql = "UPDATE sector set nombre=upper('$nombre'),estado_activo=1  WHERE id =$id";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	

}
?>
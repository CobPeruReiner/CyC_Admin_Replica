<?php
date_default_timezone_set('America/Lima');
require_once "clsConexion.php";
class clsCategoria{
	
	public static function listar() {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT *,if(idestado=1,'<label>ACTIVE</label>','<label>SUSPENDED</label>') as estado,'' as opciones 
		FROM categoria";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {  
			  $arr_datos[] = array($row["IDCATEGORIA"],utf8_encode($row["CATEGORIA"]),utf8_encode($row["DESCRIPCION"]),$row["estado"],$row["opciones"]);
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}
	
	public static function registrar ($nombre,$descripcion) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha=date("Y-m-d H:i:s");
		$sql = "INSERT INTO categoria VALUES(default,upper('$nombre'),'$descripcion',1)";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
	public static function select_categoria($id) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT * from categoria WHERE IDCATEGORIA = $id ";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {
			$arr_datos = $row;			
		}
		$objConx->desconectar();
		return $arr_datos;
	}
	
	public static function update_categoria($id,$categoria,$DESCRIPCION,$IDESTADO) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "UPDATE categoria set categoria=upper('$categoria'),DESCRIPCION='$DESCRIPCION',IDESTADO='$IDESTADO' WHERE IDCATEGORIA =$id";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
	public static function baja($id) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "UPDATE categoria set idestado=0 where idcategoria='$id'";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}	

		

}
?>
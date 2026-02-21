<?php
date_default_timezone_set('America/Lima');
require_once "clsConexion.php";
class clsAccion{
	
	public static function listar() {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT a.*, b.cartera as cartera,c.nombre as tipo_cartera,d.nombre as cliente,if(a.idestado=1,'<label>ACTIVE</label>','<label>SUSPENDED</label>') as estado,'' as opciones FROM accion a left join cartera b on a.idcartera=b.id left join tipo_cartera c on c.id=b.tipo left join cliente d on d.id=b.idcliente";
		$res = mysql_query($sql) or die(mysql_error());
		//echo($sql);
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {  
			  $arr_datos[] = array($row["IDACCION"],utf8_encode($row["ACCION"]),$row["cartera"],$row["tipo_cartera"],utf8_encode($row["cliente"]),$row["estado"],$row["opciones"]);
		}
		$objConx->desconectar();
		if ($res)
		return $arr_datos;
		return $res;
	}
	
	public static function consulta_cartera(){
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT a.id,concat(a.cartera,': ',b.nombre) as nombre FROM cartera a
				left join cliente b on a.idcliente=b.id
				where a.estado=1
				order by a.cartera asc";
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
	
	public static function consulta_tipo(){
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT id,nombre FROM tipo_accion where estado=1 order by nombre";
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
	
	
	public static function registrar ($nombre,$cartera,$tipo) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$fecha=date("Y-m-d H:i:s");
		$sql = "INSERT INTO accion VALUES(default,upper('$nombre'),'$cartera','$tipo',1)";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
	public static function select_accion($id) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "SELECT * from accion WHERE idaccion = $id ";
		$res = mysql_query($sql) or die(mysql_error());
		$arr_datos = array();
		while($row = mysql_fetch_array($res)) {
			$arr_datos = $row;			
		}
		$objConx->desconectar();
		return $arr_datos;
	}
	
	public static function update_accion($idaccion,$accion,$cartera,$tipo,$IDESTADO) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "UPDATE accion set accion=upper('$accion'),idcartera='$cartera',tipo='$tipo',IDESTADO='$IDESTADO' WHERE idaccion =$idaccion";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}
	
	public static function baja($id) {
		$objConx = new clsConexion();
		$objConx->conectar();
		$sql = "UPDATE accion set idestado=0 where idaccion='$id'";
		//echo($sql);
		$res = mysql_query($sql) or die(mysql_error());
		$res = mysql_insert_id();
		$objConx->desconectar();
		return $res;
	}	

		

}
?>